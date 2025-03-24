<?php

namespace App\Livewire\Test;

use Livewire\Component;
use App\Models\AssessmentQuestion;
use App\Models\Position;
use App\Models\Skill;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class AssessmentTest extends Component
{

    use WithPagination;
    public $editMode;

    public $archive = false;

    public $search;
    public $name, $location, $venue_id;

    public $positions = [];
    public $skills = [];
    
    public $position_id;
    public $skill_id;
    public $question;
    public $duration;
    public $points;

    public $hours = 0;
    public $minutes = 0;
    public $seconds = 0;
    public $assessmentquestion_id;
    

    public $competency_levels = ['basic', 'intermediate', 'advanced'];
    
    public $competency_level;

    protected $listeners = ['deleteAssessmentQuestion'];

    public function mount()
    {
        // $user = auth()->user();

        // if(!$user->can('read reference')){
        //     abort(403);
        // }

        $this->positions = Position::all();
    }

    public function updatedPositionId()
    {
        $this->skills = Skill::whereIn('id', function ($query) {
            $query->select('skill_id')
                  ->from('position_skills')
                  ->where('position_id', $this->position_id);
        })->get();
    }

    public function updatedCompetencyLevel()
    {
        $this->updateSkills();
        $this->skill_id = null;
    }

    public function render()
    {
        return view('livewire.test.assessment-test', [
            'assessmentquestions' => $this->getAssessmentQuestions()
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'question'  => ['required', 
                'string', Rule::unique('assessmentquestions', 'question')->ignore($this->assessmentquestion_id),
            ], 
            'points' => ['required', 'integer', 'min:1'],    
            'hours' => 'required|integer|min:0|max:23',
            'minutes' => 'required|integer|min:0|max:59',
            'seconds' => 'required|integer|min:0|max:59',
        ];
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function getAssessmentQuestions()
    {
        $query = AssessmentQuestion::with('skill');

        if ($this->archive) {
            $query->onlyTrashed(); 
        }

        return $query
            ->when($this->search, function ($query) {
                $query->where('question', 'like', '%' . $this->search . '%')
                ->orWhere('duration','like','%'. $this->search .'%');
            })
            ->paginate(10)
            ->through(function ($question) {
                $question->formatted_duration = gmdate("H:i:s", $question->duration);
                $question->skill_title = $question->skill->title ?? 'N/A'; 
                $question->competency_level = $question->skill->competency_level ?? 'N/A'; 
                return $question;
            });
    }

    public function createAssessmentQuestion()
    {
        $this->validate();

        // dd([
        //     'question' => $this->question,
        //     'points' => $this->points,
        //     'skill_id' => $this->skill_id,
        //     'hours' => $this->hours,
        //     'minutes' => $this->minutes,
        //     'seconds' => $this->seconds,
        //     'totalSeconds' => ($this->hours * 3600) + ($this->minutes * 60) + $this->seconds,
        // ]);

        DB::transaction(function () {
            $assessmentquestion = new AssessmentQuestion();
            $assessmentquestion->question = $this->question;
            $assessmentquestion->points = $this->points;
            $assessmentquestion->skill_id = $this->skill_id;
            $totalSeconds = ($this->hours * 3600) + ($this->minutes * 60) + $this->seconds;

            $assessmentquestion->duration = $totalSeconds;
            $assessmentquestion->save();
        });

        $this->clear();
        $this->dispatch('hide-assessmentquestionModal');
        $this->dispatch('success', 'Venue Created Successfully');
    }


    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function updateSkills()
    {
        if ($this->competency_level) {
            $this->skills = Skill::where('competency_level', $this->competency_level)->get();
        } else {
            $this->skills = [];
        }
    }

    public function readAssessmentQuestion($assessmentquestionId)
    {
        $assessmentquestion = AssessmentQuestion::withTrashed()->with('skill')->findOrFail($assessmentquestionId);
    
        $this->hours = floor($assessmentquestion->duration / 3600);
        $this->minutes = floor(($assessmentquestion->duration % 3600) / 60);
        $this->seconds = $assessmentquestion->duration % 60;
    
        $this->fill([
            'assessmentquestion_id' => $assessmentquestion->id,
            'question'          => $assessmentquestion->question,
            'points'            => $assessmentquestion->points,
            'skill_id'       => $assessmentquestion->skill_id,
            'competency_level'  => $assessmentquestion->skill->competency_level ?? 'N/A',
        ]);
        
        $this->updateSkills();
        $this->editMode = true;
        $this->dispatch('show-assessmentquestionModal');
    }

    public function updateAssessmentQuestion()
{
    Log::info('updateAssessmentQuestion called', [
        'assessmentquestion_id' => $this->assessmentquestion_id,
        'question' => $this->question,
        'points' => $this->points,
        'skill_id' => $this->skill_id,
        'hours' => $this->hours,
        'minutes' => $this->minutes,
        'seconds' => $this->seconds
    ]);

    $this->validate();

    DB::transaction(function () {  
        $assessmentquestion = AssessmentQuestion::withTrashed()->findOrFail($this->assessmentquestion_id);
        
        Log::info('AssessmentQuestion found', ['id' => $assessmentquestion->id]);

        $assessmentquestion->question = $this->question;
        $assessmentquestion->points = $this->points;
        $assessmentquestion->skill_id = $this->skill_id;
        $totalSeconds = ($this->hours * 3600) + ($this->minutes * 60) + $this->seconds;
        $assessmentquestion->duration = $totalSeconds;

        $assessmentquestion->save();

        Log::info('AssessmentQuestion updated', ['id' => $assessmentquestion->id]);
    });

    $this->clear();
    $this->dispatch('hide-assessmentquestionModal');
    $this->dispatch('success', 'Question updated successfully.');
}

    public function confirmDelete($id)
    {

        $this->dispatch('confirm-delete', 
            message: 'this venue will be sent to archive',
            eventName: 'deleteVenue',
            eventData: ['id' => $id]
        );
    }


    public function deleteAssessmentQuestion($id)
    {
        AssessmentQuestion::findOrFail($id)->delete();
         
        $this->dispatch('success', 'Venue archived successfully');
    }

    public function restoreAssessmentQuestion($venue_id)
    {
        $venue = AssessmentQuestion::withTrashed()->findOrFail($venue_id);
        $venue->restore();
    
        $this->dispatch('success', 'Venue restored successfully.');
    }

    public function showAddEditModal()
    {
        $this->clear();
        $this->dispatch('show-assessmentquestionModal');
    }
}
