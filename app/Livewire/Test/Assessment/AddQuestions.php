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

class AddQuestions extends Component
{
    public $positions = [];

    
    public $skills = [];

    public $choices = [['text' => '', 'status' => 'incorrect']];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $question, $duration = 0, $status, $vduration;
    public $points = 1;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $assessmentquestion_id;
    public $filterStatus = 'all'; 

    public $questions = [
        [
            'question' => '',
            'points' => 1,
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
            }
        }
    }

    protected $rules = [
        'questions' => 'required|array|min:1',
        'questions.*.question' => 'required|string|max:255',
        'questions.*.points' => 'required|integer|min:1',
        'questions.*.hours' => 'nullable|integer|min:0',
        'questions.*.minutes' => 'nullable|integer|min:0|max:59',
        'questions.*.seconds' => 'nullable|integer|min:0|max:59',
        'questions.*.choices' => 'required|array|min:2',
        'questions.*.choices.*.text' => 'required|string|max:255',
        'questions.*.choices.*.status' => 'required|in:correct,incorrect',
    ];
    
    public function render()
    {
        return view('livewire.test.assessment.add-questions');
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
            'points' => 1,
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
            unset($this->questions[$index]);
            $this->questions = array_values($this->questions);
        }
    }

    public function createAssessmentQuestions()
    {
        Log::info('Validation data:', ['data' => $this->validate()]);

        $this->validate();

        // dd('yawa');

        DB::transaction(function () {
            try {
                Log::info('Starting transaction for multiple question creation.');

                foreach ($this->questions as $index => $questionData) {
                    Log::info("Processing question #{$index}");

                    $assessmentquestion = new AssessmentQuestion();
                    $assessmentquestion->question = $questionData['question'];
                    $assessmentquestion->points = $questionData['points'] ?? $this->points;
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

                    Log::info("Question #{$index} created successfully.", [
                        'question_id' => $assessmentquestion->id,
                        'question_text' => $assessmentquestion->question
                    ]);

                    foreach ($questionData['choices'] ?? $this->choices as $choiceIndex => $choice) {
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

                Log::info('All questions and choices created successfully.');
            } catch (\Exception $e) {
                Log::error('Error while creating assessment questions.', ['error' => $e->getMessage()]);
                throw $e;
            }
        });

        $this->clear();
        $this->dispatch('hide-assessmentquestionModal');
        $this->dispatch('success', 'Questions Created Successfully');
    }

    public function clear()
    {
        $this->resetValidation();
        $this->questions = [
            [
                'question' => '',
                'points' => 1,
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0,
                'choices' => [
                    ['text' => '', 'status' => 'incorrect'],
                    ['text' => '', 'status' => 'incorrect']
                ],
            ]
        ];
    }


}

