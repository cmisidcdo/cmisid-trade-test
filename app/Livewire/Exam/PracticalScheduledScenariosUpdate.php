<?php

namespace App\Livewire\Exam;

use App\Models\AssignedPractical;
use App\Models\PracticalScore;
use App\Models\PracticalScoreSkill;
use App\Models\PracticalScoreSkillScenario;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\PracticalScenario;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class PracticalScheduledScenariosUpdate extends Component
{
    use WithFileUploads;

    public function render()
    {
        return view('livewire.exam.practical-scheduled-scenarios-update');
    }

    public $positions = [];

    
    public $skills = [];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $scenario, $decription, $duration = 0, $status, $vduration;

    public $file, $existing_file;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $practicalscenario_id, $archive = false, $assigned_practical_id;
    public $deletedScenarios = [];
    public $showReplaceInput = null;
    public $replaceFileVisibility = [];
    public $unlinkedScenarios = [];

    public $linkedScenarios = [];

    public $practical_score_id;

    public $scenarios = [
        [
            'scenario' => '',
            'description' => '',
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
            'file' => null,
        ]
    ];
    

    public function mount($AssignedId)
    {
        $this->assigned_practical_id = $AssignedId;

        $assigned = AssignedPractical::with('candidate.position')->find($this->assigned_practical_id);
        
        if ($assigned && $assigned->candidate && $assigned->candidate->position) {
            $this->position_id = $assigned->candidate->position->id;
            $this->position = Position::find($this->position_id);
            $this->candidate_id = $assigned->candidate->id;

            $practicalScore = PracticalScore::where('assigned_practical_id', $this->assigned_practical_id)->first();
            if ($practicalScore) {
                $this->practical_score_id = $practicalScore->id;
            }

            $this->loadSkills();
            $this->loadPracticalScenarios($this->position_id);
        } else {
            $this->position_id = null;
            $this->skills = [];
            $this->scenarios = [];
        }
    }

    protected $rules = [
        'scenarios' => 'required|array|min:1',
        'scenarios.*.scenario' => 'required|string|max:255',
        'scenarios.*.description' => 'required|string|max:255',
        'scenarios.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'scenarios.*.hours' => 'nullable|integer|min:0',
        'scenarios.*.minutes' => 'nullable|integer|min:0|max:59',
        'scenarios.*.seconds' => 'nullable|integer|min:0|max:59',
    ];

    public function loadPracticalScenarios($position_id)
    {
        $allScenarios = PracticalScenario::whereHas('positionSkill', function ($query) use ($position_id) {
            $query->where('position_id', $position_id);
        })->with('positionSkill.skill')->get();

        $linkedScenarioIds = PracticalScoreSkillScenario::whereHas('practicalScoreSkill.practicalScore', function ($query) {
            $query->where('assigned_practical_id', $this->assigned_practical_id);
        })->pluck('practical_scenario_id')->toArray();

        $mapScenario = function ($scenario) {
            return [
                'id' => $scenario->id,
                'scenario' => $scenario->scenario,
                'description' => $scenario->description,
                'hours' => floor($scenario->duration / 3600),
                'minutes' => floor(($scenario->duration % 3600) / 60),
                'seconds' => $scenario->duration % 60,
                'existing_file' => $scenario->file_path ?? null,
                'skill_id' => $scenario->positionSkill->skill->id,
                'skill_title' => $scenario->positionSkill->skill->title,
            ];
        };

        $this->linkedScenarios = $allScenarios->filter(fn($s) => in_array($s->id, $linkedScenarioIds))->map($mapScenario)->values()->toArray();
        $this->unlinkedScenarios = $allScenarios->filter(fn($s) => !in_array($s->id, $linkedScenarioIds))->map($mapScenario)->values()->toArray();

        $this->scenarios = $this->archive ? $this->unlinkedScenarios : $this->linkedScenarios;
    }

    public function addExistingScenario($index)
    {

        $scenario = $this->unlinkedScenarios[$index];
        $this->linkedScenarios[] = $scenario;
        unset($this->unlinkedScenarios[$index]);
        $this->unlinkedScenarios = array_values($this->unlinkedScenarios);

        Log::info('Linked Scenarios Length:', ['linkedScenariosLength' => count($this->linkedScenarios)]);
        Log::info('Unlinked Scenarios Length:', ['unlinkedScenariosLength' => count($this->unlinkedScenarios)]);

        $this->scenarios = $this->archive ? $this->unlinkedScenarios : $this->linkedScenarios;
    }

    
    public function removeScenario($index)
    {
        if (isset($this->linkedScenarios[$index])) {
            $scenario = $this->linkedScenarios[$index];
            $this->unlinkedScenarios[] = $scenario;

            unset($this->linkedScenarios[$index]);
            $this->linkedScenarios = array_values($this->linkedScenarios);

            $this->scenarios = $this->archive ? $this->unlinkedScenarios : $this->linkedScenarios;

            Log::info('Linked Scenarios Length:', ['linkedScenariosLength' => count($this->linkedScenarios)]);
            Log::info('Unlinked Scenarios Length:', ['unlinkedScenariosLength' => count($this->unlinkedScenarios)]);
        }
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
    
    public function addScenario()
    {
        $this->scenarios[] = [
            'scenario' => '',
            'description' => '',
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
        ];
    }

    public function showReplace($index)
    {
        // dd('bushet');
        $this->showReplaceInput = $index;
    }
    
    public function removeFile($index)
    {
        $filePath = $this->scenarios[$index]['existing_file'];
    
        if ($filePath && Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    
        $practicalscenario = PracticalScenario::find($this->scenarios[$index]['id']);
        if ($practicalscenario) {
            $practicalscenario->file_path = null;
            $practicalscenario->save();
        }
    

        unset($this->scenarios[$index]['existing_file']);
        $this->showReplaceInput = null;
    }


   public function updatePracticalScenarios()
    {
        DB::transaction(function () {
            try {
                Log::info('Starting transaction for multiple scenario update.');

                $updatedScenarioIds = [];
                $practicalScoreSkill = null;
                $totalAccumulatedDuration = 0;

                foreach ($this->scenarios as $index => $scenarioData) {
                    Log::info("Processing scenario #{$index}");

                    $totalSeconds = (
                        ($scenarioData['hours'] ?? $this->hours) * 3600 +
                        ($scenarioData['minutes'] ?? $this->minutes) * 60 +
                        ($scenarioData['seconds'] ?? $this->seconds)
                    );

                    $totalAccumulatedDuration += $totalSeconds; 

                    $positionSkill = PositionSkill::where('position_id', $this->position_id)
                                                ->where('skill_id', $scenarioData['skill_id'])
                                                ->first();

                    if (!$positionSkill) {
                        Log::warning("No PositionSkill found for position_id={$this->position_id}, skill_id={$scenarioData['skill_id']}");
                        continue;
                    }

                    if (!$practicalScoreSkill) {
                        $practicalScoreSkill = PracticalScoreSkill::firstOrCreate([
                            'position_skill_id' => $positionSkill->id,
                            'practical_score_id' => $this->practical_score_id,
                        ]);
                    }

                    if (isset($scenarioData['id'])) {
                        $practicalscenario = PracticalScenario::find($scenarioData['id']);
                        if ($practicalscenario) {
                            $practicalscenario->scenario = $scenarioData['scenario'];
                            $practicalscenario->description = $scenarioData['description'];
                            $practicalscenario->duration = $totalSeconds;
                            $practicalscenario->position_skill_id = $positionSkill->id;

                            if (isset($scenarioData['file'])) {
                                if ($practicalscenario->file_path) {
                                    Storage::delete($practicalscenario->file_path);
                                    Log::info("Replaced file for scenario #{$index}");
                                }
                                $practicalscenario->file_path = $scenarioData['file']->store('scenarios', 'public');
                            }

                            $practicalscenario->save();
                            Log::info("Scenario #{$index} updated successfully.");
                        }
                    } else {
                        $practicalscenario = new PracticalScenario();
                        $practicalscenario->scenario = $scenarioData['scenario'];
                        $practicalscenario->description = $scenarioData['description'];
                        $practicalscenario->duration = $totalSeconds;
                        $practicalscenario->position_skill_id = $positionSkill->id;

                        if (isset($scenarioData['file'])) {
                            $practicalscenario->file_path = $scenarioData['file']->store('scenarios', 'public');
                        }

                        $practicalscenario->save();
                        Log::info("New scenario created with ID {$practicalscenario->id}");
                    }

                    $updatedScenarioIds[] = $practicalscenario->id;

                    $exists = PracticalScoreSkillScenario::where('practical_score_skill_id', $practicalScoreSkill->id)
                        ->where('practical_scenario_id', $practicalscenario->id)
                        ->exists();

                    if (!$exists) {
                        PracticalScoreSkillScenario::create([
                            'practical_score_skill_id' => $practicalScoreSkill->id,
                            'practical_scenario_id' => $practicalscenario->id,
                        ]);

                        Log::info("Link created for scenario ID {$practicalscenario->id} and score skill ID {$practicalScoreSkill->id}");
                    } else {
                        Log::info("Link already exists for scenario ID {$practicalscenario->id} and score skill ID {$practicalScoreSkill->id}");
                    }
                }

                $practicalScore = PracticalScore::where('assigned_practical_id', $this->assigned_practical_id)->first();
                if ($practicalScore) {
                    $practicalScore->total_duration = $totalAccumulatedDuration;
                    $practicalScore->save();
                    Log::info("PracticalScore total_duration updated to {$totalAccumulatedDuration} seconds.");
                }

                if ($practicalScoreSkill) {
                    Log::info('Unlinked Scenarios:', ['unlinkedScenarios' => $this->unlinkedScenarios]);

                    if ($practicalScore) {
                        $practicalScoreSkills = PracticalScoreSkill::where('practical_score_id', $practicalScore->id)->get();

                        foreach ($practicalScoreSkills as $scoreSkill) {
                            $linkedScenarios = PracticalScoreSkillScenario::where('practical_score_skill_id', $scoreSkill->id)->get();

                            foreach ($linkedScenarios as $linkedScenario) {
                                if (in_array($linkedScenario->practical_scenario_id, array_column($this->unlinkedScenarios, 'id'))) {
                                    Log::info("Unlinking scenario ID {$linkedScenario->practical_scenario_id} from score skill ID {$scoreSkill->id}");

                                    $linkedScenario->delete();
                                    Log::info("Scenario ID {$linkedScenario->practical_scenario_id} unlinked successfully.");
                                }
                            }
                        }
                    } else {
                        Log::error('No PracticalScore found for assigned_practical_id ' . $this->assigned_practical_id);
                    }
                } else {
                    Log::error('No PracticalScoreSkill found to unlink scenarios.');
                }

                Log::info('All scenarios updated successfully.');
            } catch (\Exception $e) {
                Log::error('Error while updating assessment scenarios.', ['error' => $e->getMessage()]);
                throw $e;
            }
        });

        $this->clear();
        $this->dispatch('success', 'Scenarios Updated Successfully');
    }


    public function toggleArchive()
    {
        $this->archive = !$this->archive;

        $this->scenarios = $this->archive ? $this->unlinkedScenarios : $this->linkedScenarios;
    }

    public function toggleReplaceInput($index)
    {
        $this->replaceFileVisibility[$index] = !($this->replaceFileVisibility[$index] ?? false);
    }

    public function clear()
    {
        $this->resetValidation();
        $this->loadPracticalScenarios($this->position_id);
    }
}
