<?php

namespace App\Livewire\Test;


use Livewire\Component;
use App\Models\OralQuestion;
use App\Models\Position;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class OralInterview extends Component
{
    use WithPagination;
    public $editMode;

    public $archive = false;

    public $search;

    public $skills = [];

    public $choices = [['text' => '', 'status' => '']];
    
    public $position_id, $skill_id, $question, $status, $notes, $skill, $vduration, $title;

    public $oralquestion_id;
    
    public $filterStatus = 'all'; 

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

    public function render()
    {
        return view('livewire.test.oral-interview', [
            'oralquestions' => $this->loadOralQuestions()
        ]);
    }
    
    public function rules()
    {
        return [
            'skill_id' => ['required'],
            'question' => ['required', 'string', 'max:255'],
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

    public function loadOralQuestions()
    {
        return OralQuestion::withTrashed()
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
            ->paginate(10);
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
        $this->dispatch('show-oralquestionModal');
    }

    public function readOralQuestion($oralquestionId)
    {
        $this->clear();
        $oralquestion = OralQuestion::withTrashed()->with('skill')->findOrFail($oralquestionId);
    
        $this->fill([
            'oralquestion_id' => $oralquestion->id,
            'question'          => $oralquestion->question,
            'skill_id'       => $oralquestion->skill_id,
            'competency_level'  => $oralquestion->skill->competency_level ?? 'N/A',
        ]);

        $this->status = is_null($oralquestion->deleted_at) ? 'yes' : 'no';
        $this->updateSkills();
        $this->editMode = true;
        $this->dispatch('show-oralquestionModal');
    }

    public function createOralQuestion()
    {
        
        $this->validate();

        DB::transaction(function () {

            $oralquestion = new OralQuestion();
            $oralquestion->question = $this->question;
            $oralquestion->skill_id = $this->skill_id;
            $oralquestion->save();

        });

        $this->clear();
        $this->dispatch('hide-oralquestionModal');
        $this->dispatch('success', 'Question Created Successfully');
    }

    public function updateOralQuestion()
    {

        $this->validate();


        DB::transaction(function () {  
            $oralquestion = OralQuestion::withTrashed()->findOrFail($this->oralquestion_id);
            
            Log::info('oralQuestion found', ['id' => $oralquestion->id]);

            $oralquestion->question = $this->question;
            $oralquestion->notes = $this->notes;
            $oralquestion->skill_id = $this->skill_id;

            if ($this->status === 'no' && is_null($oralquestion->deleted_at)) {
                $oralquestion->delete();
            } elseif ($this->status === 'yes' && !is_null($oralquestion->deleted_at)) {
                $oralquestion->restore();
            } else {
                $oralquestion->save();
            }

        });

        $this->clear();
        $this->dispatch('hide-oralquestionModal');
        $this->dispatch('success', 'Question and choices updated successfully.');
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
