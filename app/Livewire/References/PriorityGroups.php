<?php

namespace App\Livewire\References;

use Livewire\Component;
use App\Models\PriorityGroup;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class PriorityGroups extends Component
{
    use WithPagination;
    public $editMode;

    public $archive = false;

    public $search;
    public $title, $prioritygroup_id;

    protected $listeners = ['deletePriorityGroup'];

    public function mount()
    {
        $user = auth()->user();

        if(!$user->can('read reference')){
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.references.priority-groups', [
            'prioritygroups' => $this->getPriorityGroups()
        ]);
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
                Rule::unique('priority_groups', 'title')->ignore($this->prioritygroup_id),
            ],
        ];
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function getPriorityGroups()
    {
        $query = PriorityGroup::query();

        if ($this->archive) {
            $query->onlyTrashed(); 
        }

        return $query
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }

    public function createPriorityGroup()
    {
        $this->validate();
        DB::transaction(function () {
            $prioritygroup = new PriorityGroup();
            $prioritygroup->title = $this->title;
            $prioritygroup->save();
        });

        $this->clear();
        $this->dispatch('hide-prioritygroupModal');
        $this->dispatch('success', 'Priority Group Created Successfuly');
       
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function readPriorityGroup($prioritygroupId)
    {
        $prioritygroup = PriorityGroup::withTrashed()->findOrFail($prioritygroupId);

        $this->fill(
            $prioritygroup->only(['title']) 
        );

        $this->prioritygroup_id = $prioritygroup->id;
        $this->editMode = true;
        $this->dispatch('show-prioritygroupModal');
    }


    public function updatePriorityGroup()
    {
        $this->validate();

        DB::transaction(function () {  
            $prioritygroup = PriorityGroup::withTrashed()->findOrFail($this->prioritygroup_id);
            
            $prioritygroup->title = $this->title;
            $prioritygroup->save();
        });

        $this->clear();
        $this->dispatch('hide-prioritygroupModal');
        $this->dispatch('success', 'Priority Group updated successfully.');
    }

    public function confirmDelete($id)
    {

        $this->dispatch('confirm-delete', 
            message: 'This Priority Group will be sent to archive',
            eventName: 'deletePriorityGroup',
            eventData: ['id' => $id]
        );
    }

    
    public function deletePriorityGroup($id)
    {
        PriorityGroup::findOrFail($id)->delete();

        $this->dispatch('success', 'Priority Group archived successfully');
    }

    public function restorePriorityGroup($prioritygroup_id)
    {
        $prioritygroup = PriorityGroup::withTrashed()->findOrFail($prioritygroup_id);
        $prioritygroup->restore();
    
        $this->dispatch('success', 'Priority Group restored successfully.');
    }

    public function showAddEditModal()
    {
        $this->clear();
        $this->dispatch('show-prioritygroupModal');
    }
}
