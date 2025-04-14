<?php

namespace App\Livewire\Test\Oral;

use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\OralQuestion;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;


class AddOralQuestions extends Component
{
    use WithFileUploads;

    public function render()
    {
        return view('livewire.test.oral.add-oral-questions');
    }

    public $positions = [];

    
    public $skills = [];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $question, $description, $duration = 0, $status, $vduration;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $oralquestion_id;

    public $questions = [
        [
            'question' => '',
            'description' => '',
            'file' => null,
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
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
        'questions.*.description' => 'required|string|max:255',
        'questions.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'questions.*.hours' => 'nullable|integer|min:0',
        'questions.*.minutes' => 'nullable|integer|min:0|max:59',
        'questions.*.seconds' => 'nullable|integer|min:0|max:59',
    ];

    public function addQuestion()
    {
        $this->questions[] = [
            'question' => '',
            'description' => '',
            'file' => null,
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
        ];
    }

    public function removeQuestion($index)
    {
        if (isset($this->questions[$index])) {
            unset($this->questions[$index]);
            $this->questions = array_values($this->questions);
        }
    }

    public function createOralQuestions()
    {
        Log::info('Validation data:', ['data' => $this->validate()]);

        $this->validate();

        // dd('yawa');

        DB::transaction(function () {
            try {
                Log::info('Starting transaction for multiple question creation.');

                foreach ($this->questions as $index => $questionData) {
                    Log::info("Processing question #{$index}");

                    $oralquestion = new OralQuestion();
                    $oralquestion->question = $questionData['question'];
                    $oralquestion->description = $questionData['description'];
                    $oralquestion->position_skill_id = $this->position_skill_id;

                    $totalSeconds = (
                        ($questionData['hours'] ?? $this->hours) * 3600 +
                        ($questionData['minutes'] ?? $this->minutes) * 60 +
                        ($questionData['seconds'] ?? $this->seconds)
                    );
                    $oralquestion->duration = $totalSeconds;

                    if (!empty($questionData['file'])) {
                        $filePath = $questionData['file']->store('uploads/practical_questions', 'public');
                        $oralquestion->file_path = $filePath;
                    }
                    
                    $oralquestion->save();

                    Log::info("question #{$index} created successfully.", [
                        'question_id' => $oralquestion->id,
                        'question_text' => $oralquestion->question
                    ]);

                }

                Log::info('All questions created successfully.');
            } catch (\Exception $e) {
                Log::error('Error while creating assessment questions.', ['error' => $e->getMessage()]);
                throw $e;
            }
        });

        $this->clear();
        $this->dispatch('success', 'questions Created Successfully');
    }

    public function clear()
    {
        $this->resetValidation();
        $this->questions = [
            [
                'question' => '',
                'description' => '',
                'file' => null,
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0,
            ]
        ];
    }

}
