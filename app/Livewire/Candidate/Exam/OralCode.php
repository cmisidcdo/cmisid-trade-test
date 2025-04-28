<?php

namespace App\Livewire\Candidate\Exam;

use App\Models\AssignedOral;
use Livewire\Component;

class OralCode extends Component
{
    public $inputcode;

    public function login()
    {
        $assigned = AssignedOral::where('access_code', $this->inputcode)->first();

        if ($assigned) {
            $this->dispatch('show-confirmationModal');
        } else {
            session()->flash('error', 'Invalid access code.');
        }
    }

    public function render()
    {
        return view('livewire.candidate.exam.oral-code')->layout('components.layouts.candidate-app');
    }
}
