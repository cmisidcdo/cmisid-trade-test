<?php

namespace App\Livewire\Candidate\Exam;

use App\Models\AssignedPractical;
use Livewire\Component;

class PracticalCode extends Component
{
    public $inputcode;

    public function login()
    {
        $assigned = AssignedPractical::where('access_code', $this->inputcode)->first();

        if ($assigned) {
            $this->dispatch('show-confirmationModal');
        } else {
            session()->flash('error', 'Invalid access code.');
        }
    }
    public function render()
    {
        return view('livewire.candidate.exam.practical-code')->layout('components.layouts.candidate-app');
    }
}
