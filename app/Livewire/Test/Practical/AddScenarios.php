<?php

namespace App\Livewire\Test\Practical;

use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\PracticalScenario;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class AddScenarios extends Component
{

    use WithFileUploads;

    public function render()
    {
        return view('livewire.test.practical.add-scenarios');
    }

    public $positions = [];

    
    public $skills = [];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $scenario, $description, $duration = 0, $status, $vduration;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $practicalscenario_id;

    public $scenarios = [
        [
            'scenario' => '',
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
        'scenarios' => 'required|array|min:1',
        'scenarios.*.scenario' => 'required|string|max:255',
        'scenarios.*.description' => 'required|string|max:255',
        'scenarios.*.file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'scenarios.*.hours' => 'nullable|integer|min:0',
        'scenarios.*.minutes' => 'nullable|integer|min:0|max:59',
        'scenarios.*.seconds' => 'nullable|integer|min:0|max:59',
    ];

    public function addScenario()
    {
        $this->scenarios[] = [
            'scenario' => '',
            'description' => '',
            'file' => null,
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
        ];
    }

    public function removeScenario($index)
    {
        if (isset($this->scenarios[$index])) {
            unset($this->scenarios[$index]);
            $this->scenarios = array_values($this->scenarios);
        }
    }

    public function createPracticalScenarios()
    {
        Log::info('Validation data:', ['data' => $this->validate()]);

        $this->validate();

        // dd('yawa');

        DB::transaction(function () {
            try {
                Log::info('Starting transaction for multiple scenario creation.');

                foreach ($this->scenarios as $index => $scenarioData) {
                    Log::info("Processing scenario #{$index}");

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

                    if (!empty($scenarioData['file'])) {
                        $filePath = $scenarioData['file']->store('uploads/practical_scenarios', 'public');
                        $practicalscenario->file_path = $filePath;
                    }
                    
                    $practicalscenario->save();

                    Log::info("scenario #{$index} created successfully.", [
                        'scenario_id' => $practicalscenario->id,
                        'scenario_text' => $practicalscenario->scenario
                    ]);

                }

                Log::info('All scenarios created successfully.');
            } catch (\Exception $e) {
                Log::error('Error while creating assessment scenarios.', ['error' => $e->getMessage()]);
                throw $e;
            }
        });

        $this->clear();
        $this->dispatch('success', 'Scenarios Created Successfully');
    }

    public function clear()
    {
        $this->resetValidation();
        $this->scenarios = [
            [
                'scenario' => '',
                'description' => '',
                'file' => null,
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0,
            ]
        ];
    }


}
