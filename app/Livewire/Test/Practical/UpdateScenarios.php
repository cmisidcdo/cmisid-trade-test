<?php

namespace App\Livewire\Test\Practical;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\AQChoice;
use App\Models\PracticalScenario;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;


class UpdateScenarios extends Component
{
    use WithFileUploads;

    public function render()
    {
        return view('livewire.test.practical.update-scenarios');
    }

    public $positions = [];

    
    public $skills = [];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $scenario, $decription, $duration = 0, $status, $vduration;

    public $file, $existing_file;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $practicalscenario_id;
    public $deletedScenarios = [];
    public $showReplaceInput = null;
    public $replaceFileVisibility = [];

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
                
                $this->loadPracticalScenarios($this->position_skill_id);
            }
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

    public function loadPracticalScenarios($position_skill_id)
    {
        $this->scenarios = PracticalScenario::where('position_skill_id', $position_skill_id)
            ->get()
            ->map(function ($scenario) {
                return [
                    'id' => $scenario->id,
                    'scenario' => $scenario->scenario,
                    'description' => $scenario->description,
                    'hours' => floor($scenario->duration / 3600),
                    'minutes' => floor(($scenario->duration % 3600) / 60),
                    'seconds' => $scenario->duration % 60,
                    'existing_file' => $scenario->file_path ?? null,
                ];
            })->toArray();
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

    public function removeScenario($index)
    {
        if (isset($this->scenarios[$index])) {
            if (isset($this->scenarios[$index]['id'])) {
                $this->deletedScenarios[] = $this->scenarios[$index]['id'];
            }
            unset($this->scenarios[$index]);
            $this->scenarios = array_values($this->scenarios);
        }
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

                foreach ($this->deletedScenarios as $scenarioId) {
                    $scenario = PracticalScenario::find($scenarioId);
                    if ($scenario) {
                        if ($scenario->file_path) {
                            Storage::delete($scenario->file_path);
                            Log::info("File for scenario #{$scenarioId} deleted.");
                        }
                        $scenario->delete();
                        Log::info("scenario #{$scenarioId} deleted.");
                    }
                }

                foreach ($this->scenarios as $index => $scenarioData) {
                    Log::info("Processing scenario #{$index}");

                    if (isset($scenarioData['id'])) {
                        $practicalscenario = PracticalScenario::find($scenarioData['id']);
                        if ($practicalscenario) {
                            $practicalscenario->scenario = $scenarioData['scenario'];
                            $practicalscenario->description = $scenarioData['description'];
                            $practicalscenario->position_skill_id = $this->position_skill_id;

                            $totalSeconds = (
                                ($scenarioData['hours'] ?? $this->hours) * 3600 +
                                ($scenarioData['minutes'] ?? $this->minutes) * 60 +
                                ($scenarioData['seconds'] ?? $this->seconds)
                            );
                            $practicalscenario->duration = $totalSeconds;

                            if (isset($scenarioData['file'])) {
                                if ($practicalscenario->file_path) {
                                    Storage::delete($practicalscenario->file_path);
                                    Log::info("Replaced file for scenario #{$index}");
                                }

                                $path = $scenarioData['file']->store('scenarios', 'public');
                                $practicalscenario->file_path = $path;
                            }

                            $practicalscenario->save();

                            Log::info("Scenario #{$index} updated successfully.", [
                                'scenario_id' => $practicalscenario->id,
                                'scenario_text' => $practicalscenario->scenario
                            ]);
                        }
                    } else {
                        $practicalscenario = new PracticalScenario();
                        $practicalscenario->scenario = $scenarioData['scenario'];
                        $practicalscenario->description = $scenarioData['description'];
                        $practicalscenario->position_skill_id = $this->position_skill_id;

                        $totalSeconds = (
                            ($scenarioData['hours'] ?? $this->hours) * 3600 +
                            ($scenarioData['minutes'] ?? $this->minutes) * 60 +
                            ($scenarioData['seconds'] ?? $this->seconds)
                        );
                        $practicalscenario->duration = $totalSeconds;

                        if (isset($scenarioData['file'])) {
                            $path = $scenarioData['file']->store('scenarios', 'public');
                            $practicalscenario->file_path = $path;
                        }

                        $practicalscenario->save();

                        Log::info("New scenario created with ID {$practicalscenario->id}");
                    }
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

    public function toggleReplaceInput($index)
    {
        $this->replaceFileVisibility[$index] = !($this->replaceFileVisibility[$index] ?? false);
    }

    public function clear()
    {
        $this->resetValidation();
        $this->loadPracticalScenarios($this->position_skill_id);
    }
}
