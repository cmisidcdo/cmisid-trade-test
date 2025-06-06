<?php

namespace App\Livewire\Test;

use App\Models\PositionSkill;
use Livewire\Component;
use App\Models\AssessmentQuestion;
use App\Models\Position;
use App\Models\Skill;
use App\Models\AQChoice;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class AssessmentTest extends Component
{

    use WithPagination;

    public $editMode, $viewMode;

    public $search;
    public $positions = [];

    
    public $skills = [];
    
    public $position_id, $title, $skill_id, $question, $duration = 0, $status, $vduration;
    public $points = 1;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $assessmentquestion_id;

    public function mount()
    {
    }

    // public function updatedCompetencyLevel()
    // {
    //     $this->updateSkills();
    //     $this->skill_id = null;
    // }

    public function updatedPositionId($value)
    {
        $this->updateSkills();

        $this->skill_id = null;
    }



    public function render()
    {
        return view('livewire.test.assessment-test', [
            'assessmentquestions' => $this->loadPositionAssessmentQuestions(),
        ]);
    }

    private function loadDropdownData()
    {
        $this->positions = Position::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updated($property)
    {
        $this->duration = ($this->hours * 3600) + ($this->minutes * 60) + $this->seconds;
    }

    public function refreshTable()
    {
        //haha
    }

    public function loadPositionAssessmentQuestions()
    {
        $query = AssessmentQuestion::withTrashed()
            ->with(['positionSkill.position'])
            ->when($this->search, function ($query) {
                $query->where('positions.title', 'like', '%' . $this->search . '%');
            });
    
        $grouped = $query
            ->join('position_skills', 'position_skills.id', '=', 'assessmentquestions.position_skill_id')
            ->join('positions', 'positions.id', '=', 'position_skills.position_id')
            ->select(
                'positions.id as position_id',
                'positions.title as position_title',
                \DB::raw('COUNT(assessmentquestions.id) as total_questions'),
                \DB::raw('SUM(assessmentquestions.duration) as total_duration')
            )
            ->groupBy('positions.id', 'positions.title')
            ->paginate(10)
            ->through(function ($item) {
                $item->formatted_duration = gmdate("H:i:s", $item->total_duration);
                return $item;
            });
    
        return $grouped;
    }

    public function clear()
    {
        $this->reset();
        $this->loadDropdownData();
    }

    public function updateSkills()
    {
        if ($this->position_id) {
            $position = Position::find($this->position_id);

            if ($position) {
                $this->skills = $position->skills()
                    ->whereNull('skills.deleted_at')
                    ->get()
                    ->map(function ($skill) use ($position) {
                        $positionSkillId = DB::table('position_skills')
                            ->where('position_id', $position->id)
                            ->where('skill_id', $skill->id)
                            ->value('id');

                        $questionCount = AssessmentQuestion::where('position_skill_id', $positionSkillId)->count();

                        return [
                            'id' => $skill->id,
                            'title' => $skill->title,
                            'competency_level' => $skill->pivot->competency_level,
                            'question_count' => $questionCount,
                        ];
                    });
            } else {
                $this->skills = collect();
            }
        } else {
            $this->skills = collect();
        }
    }

    
    public function addQuestions($position_id, $skill_id)
    {

        $this->position_id = $position_id;
        $this->skill_id = $skill_id;

        $this->dispatch('open-new-tab', 
            position_id: $this->position_id,
            skill_id: $this->skill_id,
        );
    }

    public function updateQuestions($position_id, $skill_id)
    {

        $this->position_id = $position_id;
        $this->skill_id = $skill_id;

        $this->dispatch('open-new-update-tab', 
            position_id: $this->position_id,
            skill_id: $this->skill_id,
        );
    }

    public function viewQuestions($position_id, $skill_id)
    {

        $this->position_id = $position_id;
        $this->skill_id = $skill_id;

        $this->dispatch('open-new-view-tab', 
            position_id: $this->position_id,
            skill_id: $this->skill_id,
        );
    }
    
    public function readAssessmentQuestion($positionId)
    {
       
        $this->clear();
        $this->editMode = true;
        $this->position_id = $positionId;

        $this->updateSkills();
    
        $this->dispatch('show-assessmentquestionModal');
    }

    public function viewAssessmentQuestion($positionId)
    {
        $this->clear();
        $this->viewMode = true;
        $this->position_id = $positionId;
    
        $this->updateSkills();
    
        $this->dispatch('show-assessmentquestionModal');
    }

    public function showAddEditModal()
    {
        $this->clear();
    
        if (!$this->editMode) { 
            $this->status = 'yes'; 
        }

        $this->dispatch('show-assessmentquestionModal');
    }
    
}
