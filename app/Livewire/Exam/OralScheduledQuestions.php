<?php

namespace App\Livewire\Exam;

use App\Models\AssignedOral;
use App\Models\OralQuestion;
use App\Models\OralScore;
use App\Models\OralScoreSkill;
use App\Models\OralScoreSkillQuestion;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class OralScheduledQuestions extends Component
{
    use WithFileUploads;

    public function render()
    {
        return view('livewire.exam.oral-scheduled-questions');
    }

    public $positions = [];

    
    public $skills = [];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $question, $decription, $duration = 0, $status, $vduration;

    public $file, $existing_file;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $oralquestion_id, $archive, $assigned_oral_id;
    public $deletedquestions = [];
    public $showReplaceInput = null;
    public $replaceFileVisibility = [];

    public $oral_score_id;

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
    

    public function mount($newAssignedId)
    {
        $this->assigned_oral_id = $newAssignedId;

        $assigned = AssignedOral::with('candidate.position')->find($this->assigned_oral_id);
        
        if ($assigned && $assigned->candidate && $assigned->candidate->position) {
            $this->position_id = $assigned->candidate->position->id;
            $this->position = Position::find($this->position_id);
            $this->candidate_id = $assigned->candidate->id;

            $oralScore = OralScore::where('assigned_oral_id', $this->assigned_oral_id)->first();
            if ($oralScore) {
                $this->oral_score_id = $oralScore->id;
            }

            $this->loadSkills();
            $this->loadOralQuestions($this->position_id);
        } else {
            $this->position_id = null;
            $this->skills = [];
            $this->questions = [];
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

    public function loadOralQuestions($position_id)
    {
        $this->questions = OralQuestion::whereHas('positionSkill', function ($query) use ($position_id) {
            $query->where('position_id', $position_id);
        })->get()
        ->map(function ($question) {
            return [
                'id' => $question->id,
                'question' => $question->question,
                'description' => $question->description,
                'hours' => floor($question->duration / 3600),
                'minutes' => floor(($question->duration % 3600) / 60),
                'seconds' => $question->duration % 60,
                'existing_file' => $question->file_path ?? null,
                'skill_id' => $question->positionSkill->skill->id,
                'skill_title' => $question->positionSkill->skill->title,
            ];
        })
        ->toArray();
    }

    public function loadSkills()
    {
        if ($this->position_id) {
            $this->skills = PositionSkill::where('position_id', $this->position_id)
                ->with('skill')
                ->get()
                ->map(function ($ps) {
                    return [
                        'id' => $ps->id,
                        'skill_id' => $ps->skill->id,
                        'title' => $ps->skill->title,
                    ];
                })
                ->toArray();
        } else {
            $this->skills = [];
        }
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
                $this->deletedquestions[] = $this->questions[$index]['id'];
            }
            unset($this->questions[$index]);
            $this->questions = array_values($this->questions);
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

    
                foreach ($this->questions as $index => $questionData) {
                    Log::info("Processing question #{$index}");
    
                    $totalSeconds = (
                        ($questionData['hours'] ?? $this->hours) * 3600 +
                        ($questionData['minutes'] ?? $this->minutes) * 60 +
                        ($questionData['seconds'] ?? $this->seconds)
                    );
    
                    $positionSkill = PositionSkill::where('position_id', $this->position_id)
                                                  ->where('skill_id', $questionData['skill_id'])
                                                  ->first();
    
                    if (!$positionSkill) {
                        Log::warning("No PositionSkill found for position_id={$this->position_id}, skill_id={$questionData['skill_id']}");
                        continue;
                    }
                    
                    $oralScoreSkill = OralScoreSkill::firstOrCreate([
                        'position_skill_id' => $positionSkill->id,
                        'oral_score_id' => $this->oral_score_id,
                    ]);
    
                    if (isset($questionData['id'])) {
                        $oralquestion = OralQuestion::find($questionData['id']);
                        if ($oralquestion) {
                            $oralquestion->question = $questionData['question'];
                            $oralquestion->description = $questionData['description'];
                            $oralquestion->duration = $totalSeconds;
                            $oralquestion->position_skill_id = $positionSkill->id;
    
                            if (isset($questionData['file'])) {
                                if ($oralquestion->file_path) {
                                    Storage::delete($oralquestion->file_path);
                                    Log::info("Replaced file for question #{$index}");
                                }
                                $oralquestion->file_path = $questionData['file']->store('questions', 'public');
                            }
    
                            $oralquestion->save();
                            Log::info("question #{$index} updated successfully.");
                        }
                    } else {
                        $oralquestion = new OralQuestion();
                        $oralquestion->question = $questionData['question'];
                        $oralquestion->description = $questionData['description'];
                        $oralquestion->duration = $totalSeconds;
                        $oralquestion->position_skill_id = $positionSkill->id;
    
                        if (isset($questionData['file'])) {
                            $oralquestion->file_path = $questionData['file']->store('questions', 'public');
                        }
    
                        $oralquestion->save();
                        Log::info("New question created with ID {$oralquestion->id}");
                    }
    
                    OralScoreSkillQuestion::firstOrCreate([
                        'oral_score_skill_id' => $oralScoreSkill->id,
                        'oral_question_id' => $oralquestion->id,
                    ]);
                }
    
                Log::info('All questions updated successfully.');
            } catch (\Exception $e) {
                Log::error('Error while updating assessment questions.', ['error' => $e->getMessage()]);
                throw $e;
            }
        });

        $this->dispatch('success', 'questions Updated Successfully');
        return redirect()->route('exam.interviewlist');
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
        $this->loadOralQuestions($this->position_id);
    }
}
