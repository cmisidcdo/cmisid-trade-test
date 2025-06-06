<?php

namespace App\Livewire\References;

use Livewire\Component;
use App\Models\Office;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;


class Offices extends Component
{
    use WithPagination;
    public $editMode;

    public $archive = false;

    public $search;
    public $title, $office_id, $status;
    public $filterStatus = 'all'; 

    protected $listeners = ['deleteOffice'];

    public function mount()
    {
        $user = auth()->user();

        if(!$user->can('read reference')){
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.references.offices', [
            'offices' => $this->loadOffices()
        ]);
    }

    public function updatingFilterStatus()
    {
        $this->resetPage(); 
    }

    

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'title'  => ['required', 
                'string',
                Rule::unique('offices', 'title')->ignore($this->office_id),
            ],
        ];
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function loadOffices()
    {
        return Office::withTrashed()
            ->withCount('candidates')
            ->when($this->filterStatus !== 'all', function ($query) {
                if ($this->filterStatus === 'yes') {
                    $query->whereNull('deleted_at');
                } elseif ($this->filterStatus === 'no') {
                    $query->whereNotNull('deleted_at'); 
                }
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);
    }

    public function createOffice()
    {
        $this->validate();
        DB::transaction(function () {
            $office = new Office();
            $office->title = $this->title;
            $office->deleted_at = $this->status === 'no' ? now() : null;
            $office->save();
        });

        $this->clear();
        $this->dispatch('hide-officeModal');
        $this->dispatch('success', 'Office Created Successfuly');
       
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function readOffice($officeId)
    {
        $office = Office::withTrashed()->findOrFail($officeId);

        $this->fill(
            $office->only(['title']) 
        );

        $this->office_id = $office->id;
        $this->status = is_null($office->deleted_at) ? 'yes' : 'no';
        $this->editMode = true;
        $this->dispatch('show-officeModal');
    }


    public function updateOffice()
    {
        $this->validate();

        DB::transaction(function () {  
            $office = Office::withTrashed()->findOrFail($this->office_id);
            
            $office->title = $this->title;
            if ($this->status === 'no' && is_null($office->deleted_at)) {
                $office->delete();
            } elseif ($this->status === 'yes' && !is_null($office->deleted_at)) {
                $office->restore();
            } else {
                $office->save();
            }
        });

        $this->clear();
        $this->dispatch('hide-officeModal');
        $this->dispatch('success', 'Office updated successfully.');
    }

    public function confirmDelete($id)
    {

        $this->dispatch('confirm-delete', 
            message: 'This Office will be sent to archive',
            eventName: 'deleteOffice',
            eventData: ['id' => $id]
        );
    }

    
    public function deleteOffice($id)
    {
        Office::findOrFail($id)->delete();

        $this->dispatch('success', 'Office deleted successfully');
    }

    public function restoreOffice($office_id)
    {
        $office = Office::withTrashed()->findOrFail($office_id);
        $office->restore();
    
        $this->dispatch('success', 'Office restored successfully.');
    }

    public function showAddEditModal()
    {
        $this->clear();
        if (!$this->editMode) { 
            $this->status = 'yes'; 
        }
        $this->dispatch('show-officeModal');
    }
}
