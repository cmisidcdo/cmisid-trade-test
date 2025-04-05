<?php

namespace App\Livewire\References;

use Livewire\Component;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Skills extends Component
{
    use WithPagination;
    public $editMode;

    public $archive = false;

    public $search;
    public $filterStatus = 'all'; 
    public $title, $skill_id, $status;

    protected $listeners = ['deleteSkill'];

    public function mount()
    {
        $user = auth()->user();

        if(!$user->can('read reference')){
            abort(403);
        }
    }
    
    public function render()
    {
        return view('livewire.references.skills', [
            'skills' => $this->loadSkills()
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
                Rule::unique('skills', 'title')->ignore($this->skill_id),
            ],
            
        ];
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function getSkills()
    {
        $query = Skill::query();

        if ($this->archive) {
            $query->onlyTrashed(); 
        }

        return $query
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }

    public function loadSkills()
    {
        return Skill::withTrashed()
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

    public function createSkill()
    {
        $this->validate();
        DB::transaction(function () {
            $skill = new Skill();
            $skill->title = $this->title;
            $skill->deleted_at = $this->status === 'no' ? now() : null;
            $skill->save();
        });

        $this->clear();
        $this->dispatch('hide-skillModal');
        $this->dispatch('success', 'Skill Created Successfuly');
       
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function readSkill($skillId)
    {
        $skill = Skill::withTrashed()->findOrFail($skillId);

        $this->fill(
            $skill->only(['title']) 
        );

        $this->skill_id = $skill->id;
        $this->editMode = true;
        $this->status = is_null($skill->deleted_at) ? 'yes' : 'no';
        $this->dispatch('show-skillModal');
    }


    public function updateSkill()
    {
        $this->validate();

        DB::transaction(function () {  
            $skill = Skill::withTrashed()->findOrFail($this->skill_id);
            
            $skill->title = $this->title;
            if ($this->status === 'no' && is_null($skill->deleted_at)) {
                $skill->delete();
            } elseif ($this->status === 'yes' && !is_null($skill->deleted_at)) {
                $skill->restore();
            } else {
                $skill->save();
            }
        });

        $this->clear();
        $this->dispatch('hide-skillModal');
        $this->dispatch('success', 'Skill updated successfully.');
    }

    public function confirmDelete($id)
    {

        $this->dispatch('confirm-delete', 
            message: 'This skill will be sent to archive',
            eventName: 'deleteSkill',
            eventData: ['id' => $id]
        );
    }

    
    public function deleteSkill($id)
    {
        Skill::findOrFail($id)->delete();

        $this->dispatch('success', 'Skill archived successfully');
    }

    public function restoreSkill($skill_id)
    {
        $skill = Skill::withTrashed()->findOrFail($skill_id);
        $skill->restore();
    
        $this->dispatch('success', 'Skill restored successfully.');
    }

    public function showAddEditModal()
    {
        $this->clear();
        if (!$this->editMode) { 
            $this->status = 'yes'; 
        }
        $this->dispatch('show-skillModal');
    }
}
