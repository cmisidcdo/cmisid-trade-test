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
    public $title, $skill_id;

    public function render()
    {
        return view('livewire.references.skills', [
            'skills' => $this->getSkills()
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

    public function createSkill()
    {
        $this->validate();
        DB::transaction(function () {
            $skill = new Skill();
            $skill->title = $this->title;
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
        $this->dispatch('show-skillModal');
    }


    public function updateSkill()
    {
        $this->validate();

        DB::transaction(function () {  
            $skill = Skill::withTrashed()->findOrFail($this->skill_id);
            
            $skill->title = $this->title;
            $skill->save();
        });

        $this->clear();
        $this->dispatch('hide-skillModal');
        $this->dispatch('success', 'Skill updated successfully.');
    }

    
    public function deleteSkill(Skill $skill)
    {
        $skill->delete();

        $this->dispatch('success', 'Skill deleted successfully');
    }

    public function restoreSkill($skill_id)
    {
        $skill = Skill::withTrashed()->findOrFail($skill_id);
        $skill->restore();
    
        $this->dispatch('success', 'Skill restored successfully.');
    }
}
