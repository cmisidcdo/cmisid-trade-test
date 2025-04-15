<?php

namespace App\Livewire\Test\Oral;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\OralQuestion;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class UpdateOralQuestions extends Component
{
    use WithFileUploads;

    public function render()
    {
        return view('livewire.test.oral.update-oral-questions');
    }

    public $positions = [];

    
    public $skills = [];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $question, $decription, $duration = 0, $status, $vduration;

    public $file, $existing_file;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $oralquestion_id, $archive;
    public $deletedQuestions = [];
    public $showReplaceInput = null;
    public $replaceFileVisibility = [];

    public $questions = [
        [
            'question' => '',
            'description' => '',
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
            'file' => null,
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
                
                $this->loadOralQuestions($this->position_skill_id);
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

    public function loadOralQuestions($position_skill_id)
    {
        $query = OralQuestion::query();

        if ($this->archive) {
            $query->onlyTrashed();
        }

        $this->questions = $query->where('position_skill_id', $position_skill_id)
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'description' => $question->description,
                    'hours' => floor($question->duration / 3600),
                    'minutes' => floor(($question->duration % 3600) / 60),
                    'seconds' => $question->duration % 60,
                    'existing_file' => $question->file_path ?? null,
                ];
            })->toArray();
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'question' => '',
            'description' => '',
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
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
        $question = OralQuestion::onlyTrashed()->find($questionId);
        if ($question) {
            $question->restore();

            Log::info("Question #{$questionId} restored.");

            if ($this->position_skill_id) {
                $this->loadOralQuestions($this->position_skill_id);
            }

            $this->dispatch('success', 'Question restored successfully.');
        } else {
            $this->dispatch('error', 'Question not found or already active.');
        }
    }

    public function showReplace($index)
    {
        // dd('bushet');
        $this->showReplaceInput = $index;
    }
    
    public function removeFile($index)
    {
        $filePath = $this->questions[$index]['existing_file'];
    
        if ($filePath && Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    
        $oralquestion = OralQuestion::find($this->questions[$index]['id']);
        if ($oralquestion) {
            $oralquestion->file_path = null;
            $oralquestion->save();
        }
    

        unset($this->questions[$index]['existing_file']);
        $this->showReplaceInput = null;
    }


    public function updateOralQuestions()
    {
        DB::transaction(function () {
            try {
                Log::info('Starting transaction for multiple question update.');

                foreach ($this->deletedQuestions as $questionId) {
                    $question = OralQuestion::find($questionId);
                    if ($question) {
                        if ($question->file_path) {
                            Storage::delete($question->file_path);
                            Log::info("File for question #{$questionId} deleted.");
                        }
                        $question->delete();
                        Log::info("question #{$questionId} deleted.");
                    }
                }

                foreach ($this->questions as $index => $questionData) {
                    Log::info("Processing question #{$index}");

                    if (isset($questionData['id'])) {
                        $oralquestion = OralQuestion::find($questionData['id']);
                        if ($oralquestion) {
                            $oralquestion->question = $questionData['question'];
                            $oralquestion->description = $questionData['description'];
                            $oralquestion->position_skill_id = $this->position_skill_id;

                            $totalSeconds = (
                                ($questionData['hours'] ?? $this->hours) * 3600 +
                                ($questionData['minutes'] ?? $this->minutes) * 60 +
                                ($questionData['seconds'] ?? $this->seconds)
                            );
                            $oralquestion->duration = $totalSeconds;

                            if (isset($questionData['file'])) {
                                if ($oralquestion->file_path) {
                                    Storage::delete($oralquestion->file_path);
                                    Log::info("Replaced file for question #{$index}");
                                }

                                $path = $questionData['file']->store('questions', 'public');
                                $oralquestion->file_path = $path;
                            }

                            $oralquestion->save();

                            Log::info("question #{$index} updated successfully.", [
                                'question_id' => $oralquestion->id,
                                'question_text' => $oralquestion->question
                            ]);
                        }
                    } else {
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

                        if (isset($questionData['file'])) {
                            $path = $questionData['file']->store('questions', 'public');
                            $oralquestion->file_path = $path;
                        }

                        $oralquestion->save();

                        Log::info("New question created with ID {$oralquestion->id}");
                    }
                }

                Log::info('All questions updated successfully.');
            } catch (\Exception $e) {
                Log::error('Error while updating assessment questions.', ['error' => $e->getMessage()]);
                throw $e;
            }
        });

        $this->clear();
        $this->dispatch('success', 'questions Updated Successfully');
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
        
        if ($this->position_skill_id) {
            $this->loadOralQuestions($this->position_skill_id);
        }
    }

    public function toggleReplaceInput($index)
    {
        $this->replaceFileVisibility[$index] = !($this->replaceFileVisibility[$index] ?? false);
    }

    public function clear()
    {
        $this->resetValidation();
        $this->loadOralQuestions($this->position_skill_id);
    }
}
