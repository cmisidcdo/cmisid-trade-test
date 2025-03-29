<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Candidate;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Models\Position;
use App\Models\Office;
use App\Models\PriorityGroup;
use Carbon\Carbon;

class CandidateList extends Component
{
    use WithPagination;
    public $editMode;

    public $archive = false;

    public $search;
    public $filterStatus = 'all'; 
    public $title, $candidate_id;
    public $positions = [], $offices = [], $priorityGroups = [];
    public $candidate, $fullname, $email, $contactno, $remarks, $position_id, $office_id, $priority_group_id, $status;
    public $endorsement_date;

    public function mount()
    {
        $user = auth()->user();

        if(!$user->can('read candidate')){
            abort(403);
        }

        $this->positions = Position::all();
        $this->offices = Office::all();
        $this->priorityGroups = PriorityGroup::all();
    }

    public function render()
    {
        return view('livewire.settings.candidate-list', [
            'candidates' => $this->loadCandidates()
        ]);
    }

    public function updatingFilterStatus()
    {
        $this->resetPage(); 
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
            ->paginate(10);
    }

    public function loadCandidates()
    {
        return Candidate::withTrashed()
            ->with(['office', 'position', 'priorityGroup'])
            ->when($this->filterStatus !== 'all', function ($query) {
                if ($this->filterStatus === 'yes') {
                    $query->whereNull('deleted_at');
                } elseif ($this->filterStatus === 'no') {
                    $query->whereNotNull('deleted_at'); 
                }
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('fullname', 'like', '%' . $this->search . '%')
                    ->orWhereHas('office', function ($subQuery) { 
                        $subQuery->where('title', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->paginate(10);
    }




    public function createCandidate()
    {
        $this->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email',
            'contactno' => 'required|string|max:20',
            'position_id' => 'required|exists:positions,id',
            'office_id' => 'required|exists:offices,id',
            'priority_group_id' => 'required|exists:priority_groups,id',
            'endorsement_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);
    
        DB::transaction(function () {
            $candidate = new Candidate();
            $candidate->fullname = $this->fullname;
            $candidate->email = $this->email;
            $candidate->contactno = $this->contactno;
            $candidate->position_id = $this->position_id;
            $candidate->office_id = $this->office_id;
            $candidate->priority_group_id = $this->priority_group_id;
            $candidate->endorsement_date = $this->endorsement_date;
            $candidate->remarks = $this->remarks;
            $candidate->deleted_at = $this->status === 'no' ? now() : null;
            $candidate->save();
        });
    
        $this->clear();
        $this->dispatch('hide-candidateModal');
        $this->dispatch('success', 'Candidate Created Successfully');
    }


    public function clear()
    {
        $this->reset();
        $this->resetValidation();
        $this->loadDropdownData();
    }

    public function readCandidate($candidateId)
    {
        $this->loadDropdownData();

        $candidate = Candidate::withTrashed()->findOrFail($candidateId);

        $this->fill([
            'fullname' => $candidate->fullname,
            'email' => $candidate->email,
            'contactno' => $candidate->contactno,
            'position_id' => $candidate->position_id,
            'office_id' => $candidate->office_id,
            'priority_group_id' => $candidate->priority_group_id,
            'endorsement_date' => $candidate->endorsement_date 
                ? Carbon::parse($candidate->endorsement_date)->format('Y-m-d') 
                : null, 
            'remarks' => $candidate->remarks,
        ]);
        

        $this->candidate_id = $candidate->id;
        $this->status = is_null($candidate->deleted_at) ? 'yes' : 'no';
        $this->editMode = true;
        $this->dispatch('show-candidateModal');
    }

    private function loadDropdownData()
    {
        $this->positions = Position::all();
        $this->offices = Office::all();
        $this->priorityGroups = PriorityGroup::all();
    }



    public function updateCandidate()
    {
        $this->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:candidates,email,' . $this->candidate_id,
            'contactno' => 'required|string|max:20',
            'position_id' => 'required|exists:positions,id',
            'office_id' => 'required|exists:offices,id',
            'priority_group_id' => 'required|exists:priority_groups,id',
            'endorsement_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () {  
            $candidate = Candidate::withTrashed()->findOrFail($this->candidate_id);
            
            $candidate->fullname = $this->fullname;
            $candidate->email = $this->email;
            $candidate->contactno = $this->contactno;
            $candidate->position_id = $this->position_id;
            $candidate->office_id = $this->office_id;
            $candidate->priority_group_id = $this->priority_group_id;
            $candidate->endorsement_date = $this->endorsement_date;
            $candidate->remarks = $this->remarks;
            
            if ($this->status === 'no' && is_null($candidate->deleted_at)) {
                $candidate->delete();
            } elseif ($this->status === 'yes' && !is_null($candidate->deleted_at)) {
                $candidate->restore();
            } else {
                $candidate->save();
            }
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

    public function showAddEditModal()
    {
        $this->clear();
    
        if (!$this->editMode) { 
            $this->status = 'yes'; 
        }
    
        $this->dispatch('show-candidateModal');
    }

    public function viewCandidate($candidateId)
    {
        $this->candidate = Candidate::withTrashed()->findOrFail($candidateId);

        $this->dispatch('show-viewModal');
    }

}
