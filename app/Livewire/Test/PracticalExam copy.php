<?php

namespace App\Livewire\Test;

use App\Models\PracticalScenario;
use Livewire\Component;
use App\Models\OralQuestion;
use App\Models\Position;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PracticalExam extends Component
{
    use WithPagination, WithFileUploads ;
    public $editMode;

    public $archive = false;

    public $search;

    public $skills = [];

    public $choices = [['text' => '', 'status' => '']];
    
    public $skill_id, $status, $skill, $vduration, $title, $scenario, $description, $file_path, $file, $newFilePath;

    public $practicalscenario_id;
    
    public $filterStatus = 'all'; 

    public $points = 1;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $competency_levels = ['basic', 'intermediate', 'advanced'];
    
    public $competency_level;

    public function mount()
    {
        // $user = auth()->user();

        // if(!$user->can('read reference')){
        //     abort(403);
        // }

    }

    public function updatedCompetencyLevel()
    {
        $this->updateSkills();
        $this->skill_id = null;
    }

    public function removeFile($id)
    {
        $scenario = PracticalScenario::find($id);

        if ($scenario && $scenario->file_path) {

            Storage::delete('public/' . $scenario->file_path); 

            $scenario->update(['file_path' => null]);

            $this->file_path = null;

            $this->dispatch('success', 'File removed successfully');
        }
    }

    public function render()
    {
        return view('livewire.test.practical-exam', [
            'practicalscenarios' => $this->loadPracticalScenarios()
        ]);
    }
    
    public function rules()
    {
        return [
            'skill_id' => ['required'],
            'scenario' => ['required', 'string', 'max:255'],
        ];
    }


    public function updatingFilterStatus()
    {
        $this->resetPage(); 
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function loadPracticalScenarios()
    {
        return PracticalScenario::withTrashed()
            ->with('skill')
            ->when($this->filterStatus !== 'all', function ($query) {
                if ($this->filterStatus === 'yes') {
                    $query->whereNull('deleted_at');
                } elseif ($this->filterStatus === 'no') {
                    $query->whereNotNull('deleted_at'); 
                }
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('question', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10)
            ->through(function ($question) {
                $question->formatted_duration = gmdate("H:i:s", $question->duration);
                $question->skill_title = $question->skill->title ?? 'N/A'; 
                $question->competency_level = $question->skill->competency_level ?? 'N/A'; 
                return $question;
            });
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
        $this->choices = [
            ['text' => '', 'status' => 'incorrect']
        ];
    }

    public function updateSkills()
    {
        if ($this->competency_level) {
            $this->skills = Skill::where('competency_level', $this->competency_level)->get();
        } else {
            $this->skills = [];
        }
    }

    public function showAddEditModal()
    {
        $this->clear();
        if (!$this->editMode) { 
            $this->status = 'yes'; 
        }
        $this->dispatch('show-practicalscenarioModal');
    }

    public function readPracticalScenario($practicalscenarioId)
    {
        $this->clear();
        $practicalscenario = PracticalScenario::withTrashed()->with('skill')->findOrFail($practicalscenarioId);
        
        $this->hours = floor($practicalscenario->duration / 3600);
        $this->minutes = floor(($practicalscenario->duration % 3600) / 60);
        $this->seconds = $practicalscenario->duration % 60;

        $this->fill([
            'practicalscenario_id' => $practicalscenario->id,
            'scenario'          => $practicalscenario->scenario,
            'description'          => $practicalscenario->description,
            'points'            => $practicalscenario->points,
            'file_path'          => $practicalscenario->file_path,
            'skill_id'       => $practicalscenario->skill_id,
            'competency_level'  => $practicalscenario->skill->competency_level ?? 'N/A',
        ]);

        $this->status = is_null($practicalscenario->deleted_at) ? 'yes' : 'no';
        $this->updateSkills();
        $this->editMode = true;
        $this->dispatch('show-practicalscenarioModal');
    }

    public function createPracticalScenario()
    {
        
        $this->validate();

        DB::transaction(function () {

            $practicalscenario = new PracticalScenario();
            $practicalscenario->scenario = $this->scenario; 
            $practicalscenario->description = $this->description; 
            $practicalscenario->points = $this->points;
            $practicalscenario->skill_id = $this->skill_id;
            $practicalscenario->duration = ($this->hours * 3600) + ($this->minutes * 60) + $this->seconds;
            $practicalscenario->deleted_at = $this->status === 'no' ? now() : null;

            if ($this->file) {
                // Delete old file if it exists
                if ($practicalscenario->file_path) {
                    Storage::delete('public/' . $practicalscenario->file_path);
                }
            
                // ✅ Save file using the same logic as in create
                $filePath = $this->file->store('practical_scenarios', 'public');
                $practicalscenario->file_path = $filePath;
            }
            
            $practicalscenario->save();

        });

        $this->clear();
        $this->dispatch('hide-practicalscenarioModal');
        $this->dispatch('success', 'Scenario Created Successfully');
    }

    public function updatePracticalScenario()
    {

        $this->validate();


        DB::transaction(function () {  
            $practicalscenario = PracticalScenario::withTrashed()->findOrFail($this->practicalscenario_id);
            
            Log::info('practicalscenario found', ['id' => $practicalscenario->id]);

            $practicalscenario->scenario = $this->scenario;
            $practicalscenario->description = $this->description;
            $practicalscenario->points = $this->points;
            $practicalscenario->skill_id = $this->skill_id;
            $totalSeconds = ($this->hours * 3600) + ($this->minutes * 60) + $this->seconds;
            $practicalscenario->duration = $totalSeconds;

            if ($this->file) {
                if ($practicalscenario->file_path) {
                    Storage::delete('public/' . $practicalscenario->file_path);
                }
            
                $filePath = $this->file->store('practical_scenarios', 'public');
                Log::info('File stored', ['path' => $filePath]);
            
                $practicalscenario->file_path = $filePath;
            }
            

            if ($this->status === 'no' && is_null($practicalscenario->deleted_at)) {
                $practicalscenario->delete();
            } elseif ($this->status === 'yes' && !is_null($practicalscenario->deleted_at)) {
                $practicalscenario->restore();
            } else {
                $practicalscenario->save();
            }

        });

        $this->clear();
        $this->dispatch('hide-practicalscenarioModal');
        $this->dispatch('success', 'Scenario updated successfully.');
    }

    public function showViewModal($questionId)
    {
        $this->clear();
    
        $question = OralQuestion::withTrashed()
            ->with('skill') 
            ->findOrFail($questionId);
    
        $this->fill([
            'title' => optional($question->skill)->title, 
            'competency_level' => optional($question->skill)->competency_level,
            'status' => is_null($question->deleted_at) ? 'yes' : 'no',
            'question' =>$question->question,
        ]);
    
        $this->question_id = $question->id;
    
        $this->dispatch('show-viewModal');
    }

}


