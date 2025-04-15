<?php

namespace App\Livewire\Test\Assessment;

use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\AQChoice;
use App\Models\AssessmentQuestion;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class UpdateQuestions extends Component
{
    public $positions = [];

    
    public $skills = [];

    public $choices = [['text' => '', 'status' => 'incorrect']];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $question, $duration = 0, $status, $vduration;
    public $points = 1, $competency_level = 'basic';

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $assessmentquestion_id, $archive;
    public $deletedQuestions = [], $restoredQuestions = [];


    public $questions = [
        [
            'question' => '',
            'competency_level' => 'basic',
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
            'choices' => [
                ['text' => '', 'status' => 'correct'],
                ['text' => '', 'status' => 'incorrect'],
            ],
        ]
    ];
    

    public function mount()
    {
        $this->position_id = request()->query('position_id');
        $this->skill_id = request()->query('skill_id');
        
        if ($this->position_id && $this->skill_id) {
            $this->position = Position::find($this->position_id);
            $this->skill = Skill::find($this->skill_id);
            
            $this->position_skill = PositionSkill::where('position_id', $this->position_id)
                ->where('skill_id', $this->skill_id)
                ->first();
            
            if ($this->position_skill) {
                $this->position_skill_id = $this->position_skill->id;
                
                $this->loadAssessmentQuestions($this->position_skill_id);
            }
        }
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;

        if ($this->position_skill_id) {
            $this->loadAssessmentQuestions($this->position_skill_id);
        }
    }


    

    protected $rules = [
        'questions' => 'required|array|min:1',
        'questions.*.question' => 'required|string|max:255',
        'questions.*.competency_level' => 'required|in:basic,intermediate,advanced',
        'questions.*.hours' => 'nullable|integer|min:0',
        'questions.*.minutes' => 'nullable|integer|min:0|max:59',
        'questions.*.seconds' => 'nullable|integer|min:0|max:59',
        'questions.*.choices' => 'required|array|min:2',
        'questions.*.choices.*.text' => 'required|string|max:255',
        'questions.*.choices.*.status' => 'required|in:correct,incorrect',
    ];

    public function loadAssessmentQuestions($position_skill_id)
    {
        $query = AssessmentQuestion::with('choices')
            ->where('position_skill_id', $position_skill_id);

        if ($this->archive) {
            $query->onlyTrashed();
        }

        $this->questions = $query->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'competency_level' => $question->competency_level,
                    'hours' => floor($question->duration / 3600),
                    'minutes' => floor(($question->duration % 3600) / 60),
                    'seconds' => $question->duration % 60,
                    'choices' => $question->choices->map(function ($choice) {
                        return [
                            'text' => $choice->choice_text,
                            'status' => $choice->is_answer ? 'correct' : 'incorrect',
                        ];
                    })->toArray(),
                ];
            })->toArray();
    }

        
    public function render()
    {
        return view('livewire.test.assessment.update-questions');
    }

    public function addChoice($index)
    {
        $this->questions[$index]['choices'][] = ['text' => '', 'status' => 'incorrect'];
    }
    
    public function removeChoice($questionIndex, $choiceIndex)
    {
        unset($this->questions[$questionIndex]['choices'][$choiceIndex]);
        $this->questions[$questionIndex]['choices'] = array_values($this->questions[$questionIndex]['choices']);
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'question' => '',
            'competency_level' => 'basic',
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
            'choices' => [
                ['text' => '', 'status' => 'incorrect'],
                ['text' => '', 'status' => 'incorrect']
            ],
        ];
    }

    public function removeQuestion($index)
    {
        if (isset($this->questions[$index])) {
            if (isset($this->questions[$index]['id'])) {
                $this->deletedQuestions[] = $this->questions[$index]['id'];
            }
            unset($this->questions[$index]);
            $this->questions = array_values($this->questions);
        }
    }

    public function restoreQuestion($questionId)
    {
        $question = AssessmentQuestion::onlyTrashed()->find($questionId);
        if ($question) {
            $question->restore();

            Log::info("Question #{$questionId} restored.");

            if ($this->position_skill_id) {
                $this->loadAssessmentQuestions($this->position_skill_id);
            }

            $this->dispatch('success', 'Question restored successfully.');
        } else {
            $this->dispatch('error', 'Question not found or already active.');
        }
    }


    public function updateAssessmentQuestions()
    {
        DB::transaction(function () {
            try {
                Log::info('Starting transaction for multiple question update.');
    
                foreach ($this->deletedQuestions as $questionId) {
                    $question = AssessmentQuestion::find($questionId);
                    if ($question) {
                        $question->delete();
                        Log::info("Question #{$questionId} deleted.");
                    }
                }
    
                foreach ($this->questions as $index => $questionData) {
                    Log::info("Processing question #{$index}");
    
                    if (isset($questionData['id'])) {
                        $assessmentquestion = AssessmentQuestion::find($questionData['id']);
                        if ($assessmentquestion) {
                            $assessmentquestion->question = $questionData['question'];
                            $assessmentquestion->competency_level = $questionData['competency_level'];
                            $assessmentquestion->position_skill_id = $this->position_skill_id;
    
                            $totalSeconds = (
                                ($questionData['hours'] ?? $this->hours) * 3600 +
                                ($questionData['minutes'] ?? $this->minutes) * 60 +
                                ($questionData['seconds'] ?? $this->seconds)
                            );
                            $assessmentquestion->duration = $totalSeconds;
    
                            $assessmentquestion->deleted_at = 
                                ($questionData['status'] ?? $this->status) === 'no' ? now() : null;
    
                            $assessmentquestion->save();
    
                            Log::info("Question #{$index} updated successfully.", [
                                'question_id' => $assessmentquestion->id,
                                'question_text' => $assessmentquestion->question
                            ]);
    
                            $assessmentquestion->choices()->delete();
    
                            foreach ($questionData['choices'] ?? [] as $choiceIndex => $choice) {
                                $is_answer = $choice['status'] === 'correct';
    
                                AQChoice::create([
                                    'question_id' => $assessmentquestion->id,
                                    'choice_text' => $choice['text'],
                                    'is_answer' => $is_answer,
                                ]);
    
                                Log::info("Choice #{$choiceIndex} saved.", [
                                    'question_id' => $assessmentquestion->id,
                                    'choice_text' => $choice['text'],
                                    'is_answer' => $is_answer
                                ]);
                            }
    
                            Log::info("All choices saved for question #{$index}.");
                        }
                    } else {
                        $assessmentquestion = new AssessmentQuestion();
                        $assessmentquestion->question = $questionData['question'];
                        $assessmentquestion->competency_level = $questionData['competency_level'];
                        $assessmentquestion->position_skill_id = $this->position_skill_id;
    
                        $totalSeconds = (
                            ($questionData['hours'] ?? $this->hours) * 3600 +
                            ($questionData['minutes'] ?? $this->minutes) * 60 +
                            ($questionData['seconds'] ?? $this->seconds)
                        );
                        $assessmentquestion->duration = $totalSeconds;
    
                        $assessmentquestion->deleted_at = 
                            ($questionData['status'] ?? $this->status) === 'no' ? now() : null;
    
                        $assessmentquestion->save();
    
                        Log::info("New question created with ID {$assessmentquestion->id}");
    
                        foreach ($questionData['choices'] ?? [] as $choiceIndex => $choice) {
                            $is_answer = $choice['status'] === 'correct';
    
                            AQChoice::create([
                                'question_id' => $assessmentquestion->id,
                                'choice_text' => $choice['text'],
                                'is_answer' => $is_answer,
                            ]);
    
                            Log::info("Choice #{$choiceIndex} added for new question {$assessmentquestion->id}");
                        }
    
                        Log::info("All choices saved for new question.");
                    }
                }
    
                Log::info('All questions and choices updated successfully.');
            } catch (\Exception $e) {
                Log::error('Error while updating assessment questions.', ['error' => $e->getMessage()]);
                throw $e;
            }
        });
    
        $this->clear();
        $this->dispatch('success', 'Questions Updated Successfully');
    }
    



    public function clear()
    {
        $this->resetValidation();
        $this->loadAssessmentQuestions($this->position_skill_id);
    }

}
