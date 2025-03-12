<?php

namespace App\Livewire\Candidate;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\Position;
use App\Models\Office;
use App\Models\PriorityGroup;

class UpdateCandidate extends Component
{
    public $fullname, $email, $contactno, $remarks, $position_id, $office_id, $priority_group_id;
    
    public $positions = [], $offices = [], $priorityGroups = [];


    public function mount()
    {
        $this->positions = Position::all();
        $this->offices = Office::all();
        $this->priorityGroups = PriorityGroup::all();
    }

    public function save()
    {
        $this->validate([
            'fullname' => 'required|string',
            'email' => 'required|email|unique:candidates,email',
            'contactno' => 'required|string|unique:candidates,contactno',
            'remarks' => 'nullable|string',
            'position_id' => 'required|exists:positions,id',
            'office_id' => 'required|exists:offices,id',
            'priority_group_id' => 'required|exists:priority_groups,id',
        ]);

        Candidate::create([
            'fullname' => $this->fullname,
            'email' => $this->email,
            'contactno' => $this->contactno,
            'remarks' => $this->remarks,
            'position_id' => $this->position_id,
            'office_id' => $this->office_id,
            'priority_group_id' => $this->priority_group_id,
        ]);

        $this->dispatch('success', 'Candidate Created Successfuly');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.candidate.update-candidate');
    }
}