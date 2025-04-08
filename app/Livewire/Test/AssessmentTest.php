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

    public $archive = false;

    public $search;
    public $positions = [];

    
    public $skills = [];

    public $choices = [['text' => '', 'status' => '']];
    
    public $position_id, $title, $skill_id, $question, $duration = 0, $status, $vduration;
    public $points = 1;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $assessmentquestion_id;
    public $filterStatus = 'all'; 

    protected $listeners = ['deleteAssessmentQuestion'];

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

    public function updatingFilterStatus()
    {
        $this->resetPage(); 
    }

    private function loadDropdownData()
    {
        $this->positions = Position::all();
    }


    public function addChoice()
    {
        $this->choices[] = ['text' => '', 'status' => 'incorrect'];
    }

    public function removeChoice($index)
    {
        unset($this->choices[$index]);
        $this->choices = array_values($this->choices); 
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
            'skill_id' => ['required', 'integer', 'min:1'],        
            'hours' => 'required|integer|min:0|max:23',
            'minutes' => 'required|integer|min:0|max:59',
            'seconds' => 'required|integer|min:0|max:59',
            'duration' => 'required|integer|min:0|max:86400',
            'choices.*.text' => 'required|string|min:1',
        ];
    }

    public function updated($property)
    {
        $this->duration = ($this->hours * 3600) + ($this->minutes * 60) + $this->seconds;
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

    public function loadAssessmentQuestions()
    {

    }

    public function refreshTable()
    {
        //haha
    }

    public function loadPositionAssessmentQuestions()
    {
        $query = AssessmentQuestion::withTrashed()
            ->with(['positionSkill.position'])
            ->when($this->filterStatus !== 'all', function ($query) {
                if ($this->filterStatus === 'yes') {
                    $query->whereNull('deleted_at');
                } elseif ($this->filterStatus === 'no') {
                    $query->whereNotNull('deleted_at');
                }
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('question', 'like', '%' . $this->search . '%')
                        ->orWhere('duration', 'like', '%' . $this->search . '%');
                });
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
    



    public function createAssessmentQuestion()
    {

        $this->validate();

        DB::transaction(function () {
            try {
                Log::info('Starting transaction for question creation.');

                $assessmentquestion = new AssessmentQuestion();
                $assessmentquestion->question = $this->question;
                $assessmentquestion->question = $this->question;
                $assessmentquestion->points = $this->points;
                $assessmentquestion->skill_id = $this->skill_id;
                $totalSeconds = ($this->hours * 3600) + ($this->minutes * 60) + $this->seconds;
                $assessmentquestion->duration = $totalSeconds;
                $assessmentquestion->deleted_at = $this->status === 'no' ? now() : null;
                $assessmentquestion->save();

                Log::info('Question created successfully.', ['question_id' => $assessmentquestion->id]);

                foreach ($this->choices as $index => $choice) {
                    $is_answer = $choice['status'] === 'correct';

                    AQChoice::create([
                        'question_id' => $assessmentquestion->id,
                        'choice_text' => $choice['text'],
                        'is_answer' => $is_answer,
                    ]);

                    Log::info("Choice {$index} saved.", [
                        'question_id' => $assessmentquestion->id,
                        'choice_text' => $choice['text'],
                        'is_answer' => $is_answer
                    ]);
                }

                Log::info('All choices saved successfully.');
            } catch (\Exception $e) {
                Log::error('Error while creating assessment question.', ['error' => $e->getMessage()]);
                throw $e; 
            }
        });

        $this->clear();
        $this->dispatch('hide-assessmentquestionModal');
        $this->dispatch('success', 'Question Created Successfully');
    }



    public function clear()
    {
        $this->reset();
        $this->resetValidation();
        $this->choices = [
            ['text' => '', 'status' => 'incorrect']
        ];
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

            if ($this->status === 'no' && is_null($assessmentquestion->deleted_at)) {
                $assessmentquestion->delete();
            } elseif ($this->status === 'yes' && !is_null($assessmentquestion->deleted_at)) {
                $assessmentquestion->restore();
            } else {
                $assessmentquestion->save();
            }

            Log::info('AssessmentQuestion updated', ['id' => $assessmentquestion->id]);

            $existingChoices = AQChoice::where('question_id', $assessmentquestion->id)->get();

            $updatedChoiceIds = [];

            foreach ($this->choices as $choice) {
                if (!empty($choice['id'])) {
                    $aqChoice = AQChoice::find($choice['id']);
                    if ($aqChoice) {
                        $aqChoice->choice_text = $choice['text'];
                        $aqChoice->is_answer = $choice['status'] === 'correct';
                        $aqChoice->save();

                        Log::info('Choice updated', [
                            'id' => $aqChoice->id,
                            'text' => $choice['text'],
                            'is_answer' => $aqChoice->is_answer
                        ]);

                        $updatedChoiceIds[] = $aqChoice->id;
                    }
                } else {
                    $newChoice = AQChoice::create([
                        'question_id' => $assessmentquestion->id,
                        'choice_text' => $choice['text'],
                        'is_answer' => $choice['status'] === 'correct',
                    ]);

                    Log::info('New choice created', [
                        'id' => $newChoice->id,
                        'text' => $choice['text'],
                        'is_answer' => $newChoice->is_answer
                    ]);

                    $updatedChoiceIds[] = $newChoice->id;
                }
            }

            AQChoice::where('question_id', $assessmentquestion->id)
                ->whereNotIn('id', $updatedChoiceIds)
                ->delete();

            Log::info('Unused choices deleted if any.');
        });

        $this->clear();
        $this->dispatch('hide-assessmentquestionModal');
        $this->dispatch('success', 'Question and choices updated successfully.');
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
    
        if (!$this->editMode) { 
            $this->status = 'yes'; 
        }

        $this->dispatch('show-assessmentquestionModal');
    }

    
    public function showViewModal($questionId)
    {
        $this->clear();
    
        $question = AssessmentQuestion::withTrashed()
            ->with('skill') 
            ->findOrFail($questionId);
    
        $hours = floor($question->duration / 3600);
        $minutes = floor(($question->duration % 3600) / 60);
        $seconds = $question->duration % 60;
    
        $this->fill([
            'title' => optional($question->skill)->title, 
            'competency_level' => optional($question->skill)->competency_level,
            'vduration' => sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds), 
            'status' => is_null($question->deleted_at) ? 'yes' : 'no',
            'question' =>$question->question,
            'choices' => $question->choices->map(function ($choice) {
            return [
                'text' => $choice->choice_text,
                'status' => $choice->is_answer,
            ];
        })->toArray(),
        ]);
    
        $this->question_id = $question->id;
    
        $this->dispatch('show-viewModal');
    }
    

}
