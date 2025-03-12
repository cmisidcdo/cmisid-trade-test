<?php

namespace App\Livewire\References;

use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Positions extends Component
{
    use WithPagination;

    public $editMode, $viewMode;

    public $archive = false;

    public $search;
    public $position_id;
    public $title, $salary_grade, $competency_level, $interview_priority;
    public $selectedskills = [];
    public function render()
    {
        return view('livewire.references.positions', [
            'positions' => $this->getPositions(),
            'skills' => $this->getSkills(),
            'selectedskills' => $this->selectedskills,            
        ]);
    }
    
    public function selectSkills()
    {
        $this->dispatch('show-skillsModal');
    }

    public function backToPosition()
    {
        $this->dispatch('hide-skillsModal');
    }

    public function addSkill($skillId)
    {
        $skill = Skill::find($skillId);

        if ($skill) {
            $this->selectedskills[] = [
                'id' => $skill->id,
                'title' => $skill->title,
                'competency_level' => 'basic',
            ];
        }

        $this->dispatch('hide-skillsModal');
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
                Rule::unique('positions', 'title')->ignore($this->position_id),
            ],
        ];
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function getPositions()
    {
        $query = Position::query();

        if ($this->archive) {
            $query->onlyTrashed(); 
        }

        return $query
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }

    public function getSkills()
    {
        $query = Skill::query();
    
        if (!empty($this->selectedskills)) {
            $selectedSkillIds = array_column($this->selectedskills, 'id');
            $query->whereNotIn('id', $selectedSkillIds);
        }
    
        return $query->paginate(5);
    }
    
    public function removeSkill($index)
    {
        unset($this->selectedskills[$index]);
        $this->selectedskills = array_values($this->selectedskills);
    }

    public function updateCompetencyLevel($index, $level)
    {
        $updatedSkills = $this->selectedskills;

        $updatedSkills[$index]['competency_level'] = $level;

        $this->selectedskills = $updatedSkills;
    }



    
    public function createPosition()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'salary_grade' => 'required|integer',
            'competency_level' => 'required|in:basic,intermediate,advanced',
            'interview_priority' => 'required|boolean',
        ]);
    
        DB::transaction(function () {
            $position = new Position();
            $position->title = $this->title;
            $position->salary_grade = $this->salary_grade;
            $position->competency_level = $this->competency_level;
            $position->interview_priority = $this->interview_priority;
            $position->save();
    
            foreach ($this->selectedskills as $skill) {
                $positionSkill = new PositionSkill();
                $positionSkill->skill_id = $skill['id'];
                $positionSkill->position_id = $position->id;
                $positionSkill->competency_level = $skill['competency_level'];
                $positionSkill->save();
            }
        });
    
        $this->clear();
        $this->dispatch('hide-positionModal');
        $this->dispatch('success', 'Position Created Successfully');
    }
    
    


    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function readPosition($positionId)
    {
        $position = Position::withTrashed()->findOrFail($positionId);

        $this->fill([
            'title' => $position->title,
            'salary_grade' => $position->salary_grade,
            'competency_level' => $position->competency_level,
            'interview_priority' => $position->interview_priority,
        ]);

        $this->position_id = $position->id;
        $this->editMode = true;

        $this->selectedskills = PositionSkill::where('position_id', $positionId)
            ->join('skills', 'position_skills.skill_id', '=', 'skills.id') 
            ->select('position_skills.skill_id as id', 'skills.title', 'position_skills.competency_level')
            ->get()
            ->toArray();

        $this->dispatch('show-positionModal');
    }

    public function viewPosition($positionId)
    {
        $position = Position::withTrashed()->findOrFail($positionId);

        $this->fill([
            'title' => $position->title,
            'salary_grade' => $position->salary_grade,
            'competency_level' => $position->competency_level,
            'interview_priority' => $position->interview_priority,
        ]);

        $this->position_id = $position->id;

        $this->selectedskills = PositionSkill::where('position_id', $positionId)
            ->join('skills', 'position_skills.skill_id', '=', 'skills.id') 
            ->select('position_skills.skill_id as id', 'skills.title', 'position_skills.competency_level')
            ->get()
            ->toArray();

        $this->dispatch('show-viewSkillsModal');
    }


    public function updatePosition()
    {
        $this->validate();
    
        DB::transaction(function () {  
            $position = Position::withTrashed()->findOrFail($this->position_id);
            
            $position->title = $this->title;
            $position->salary_grade = $this->salary_grade;
            $position->competency_level = $this->competency_level;
            $position->interview_priority = $this->interview_priority;
            $position->save();
    
            $existingSkills = PositionSkill::where('position_id', $this->position_id)->get()->keyBy('skill_id');
    
            $newSkillIds = collect($this->selectedskills)->pluck('id');
    
            foreach ($this->selectedskills as $skill) {
                if (isset($existingSkills[$skill['id']])) {
                    $existingSkill = $existingSkills[$skill['id']];
                    if ($existingSkill->competency_level !== $skill['competency_level']) {
                        $existingSkill->competency_level = $skill['competency_level'];
                        $existingSkill->save();
                    }
                } else {
                    PositionSkill::create([
                        'position_id' => $this->position_id,
                        'skill_id' => $skill['id'],
                        'competency_level' => $skill['competency_level'],
                    ]);
                }
            }
    
            PositionSkill::where('position_id', $this->position_id)
                ->whereNotIn('skill_id', $newSkillIds)
                ->delete();
        });
    
        $this->clear();
        $this->dispatch('hide-positionModal');
        $this->dispatch('success', 'Position updated successfully.');
    }
    

    
    public function deletePosition(Position $position)
    {
        $position->delete();

        $this->dispatch('success', 'Position deleted successfully');
    }

    public function restorePosition($position_id)
    {
        $position = Position::withTrashed()->findOrFail($position_id);
        $position->restore();
    
        $this->dispatch('success', 'Position restored successfully.');
    }
}
