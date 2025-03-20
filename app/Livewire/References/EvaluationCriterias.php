<?php

namespace App\Livewire\References;

use Livewire\Component;
use App\Models\EvaluationCriteria;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class EvaluationCriterias extends Component
{
    use WithPagination;
    public $editMode;

    public $assessmentCriteria = true, $oralCriteria = false, $practicalCriteria = false;   

    public $archive = false;

    public $search;
    public $title, $criteria_id;

    protected $listeners = ['deleteCriteria'];

    public function mount()
    {
        $user = auth()->user();

        if(!$user->can('read reference')){
            abort(403);
        }
    }


    public function render()
    {
        return view('livewire.references.evaluation-criterias', [
            'criterias' => $this->getCriterias()
        ]);
    }
    

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'title'  => ['required', 
                'string',
                Rule::unique('evaluation_criterias', 'title')->ignore($this->criteria_id),
            ],
        ];
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function getCriterias()
    {
        $query = EvaluationCriteria::query();

        if ($this->archive) {
            $query->onlyTrashed(); 
        }

        return $query
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }

    public function createCriteria()
    {
        $this->validate();
        DB::transaction(function () {
            $criteria = new EvaluationCriteria();
            $criteria->title = $this->title;
            $criteria->save();
        });

        $this->clear();
        $this->dispatch('hide-criteriaModal');
        $this->dispatch('success', 'Criteria Created Successfuly');
       
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function readCriteria($criteriaId)
    {
        $criteria = EvaluationCriteria::withTrashed()->findOrFail($criteriaId);

        $this->fill(
            $criteria->only(['title']) 
        );

        $this->criteria_id = $criteria->id;
        $this->editMode = true;
        $this->dispatch('show-criteriaModal');
    }


    public function updateCriteria()
    {
        $this->validate();

        DB::transaction(function () {  
            $criteria = EvaluationCriteria::withTrashed()->findOrFail($this->criteria_id);
            $criteria->title = $this->title;
            $criteria->save();
        });

        $this->clear();
        $this->dispatch('hide-criteriaModal');
        $this->dispatch('success', 'Criteria updated successfully.');
    }

        public function confirmDelete($id)
    {

        $this->dispatch('confirm-delete', 
            message: 'This criteria will be sent to archive',
            eventName: 'deleteCriteria',
            eventData: ['id' => $id]
        );
    }

    
    public function deleteCriteria(EvaluationCriteria $criteria)
    {
        $criteria->delete();

        $this->dispatch('success', 'Criteria archived successfully');
    }

    public function restoreCriteria($criteria_id)
    {
        $criteria = EvaluationCriteria::withTrashed()->findOrFail($criteria_id);
        $criteria->restore();
    
        $this->dispatch('success', 'Criteria restored successfully.');
    }

    public function setCriteria($criteria)
    {
        $this->assessmentCriteria = $criteria === 'assessment';
        $this->oralCriteria = $criteria === 'oral';
        $this->practicalCriteria = $criteria === 'practical';
    }

    public function showAddEditModal()
    {
        $this->clear();
        $this->dispatch('show-criteriaModal');
    }
}
