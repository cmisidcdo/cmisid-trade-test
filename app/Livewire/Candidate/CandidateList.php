<?php

namespace App\Livewire\Candidate;

use Livewire\Component;
use App\Models\Candidate;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class CandidateList extends Component
{
    use WithPagination;
    public $editMode;

    public $archive = false;

    public $search;
    public $title, $candidate_id;

    public function render()
    {
        return view('livewire.candidate.candidate-list', [
            'candidates' => $this->getCandidates()
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
                Rule::unique('candidates', 'title')->ignore($this->candidate_id),
            ],
        ];
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function getCandidates()
    {
        $query = Candidate::with(['office', 'position', 'priorityGroup']); 
        if ($this->archive) {
            $query->onlyTrashed();
        }

        return $query
            ->when($this->search, function ($query) {
                $query->where('fullname', 'like', '%' . $this->search . '%');
            })
            ->paginate(3);
    }


    public function createCandidate()
    {
        $this->validate();
        DB::transaction(function () {
            $candidate = new Candidate();
            $candidate->title = $this->title;
            $candidate->save();
        });

        $this->clear();
        $this->dispatch('hide-candidateModal');
        $this->dispatch('success', 'Candidate Created Successfuly');
       
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function readCandidate($candidateId)
    {
        $candidate = Candidate::withTrashed()->findOrFail($candidateId);

        $this->fill(
            $candidate->only(['title']) 
        );

        $this->candidate_id = $candidate->id;
        $this->editMode = true;
        $this->dispatch('show-candidateModal');
    }


    public function updateCandidate()
    {
        $this->validate();

        DB::transaction(function () {  
            $candidate = Candidate::withTrashed()->findOrFail($this->candidate_id);
            
            $candidate->title = $this->title;
            $candidate->save();
        });

        $this->clear();
        $this->dispatch('hide-candidateModal');
        $this->dispatch('success', 'Candidate updated successfully.');
    }

    
    public function deleteCandidate(Candidate $candidate)
    {
        $candidate->delete();

        $this->dispatch('success', 'Candidate deleted successfully');
    }

    public function restoreCandidate($candidate_id)
    {
        $candidate = Candidate::withTrashed()->findOrFail($candidate_id);
        $candidate->restore();
    
        $this->dispatch('success', 'Candidate restored successfully.');
    }
}
