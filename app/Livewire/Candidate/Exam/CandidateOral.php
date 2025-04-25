<?php

namespace App\Livewire\Candidate\Exam;

use Livewire\Component;

class CandidateOral extends Component
{
    public function render()
    {
        return view('livewire.candidate.exam.candidate-oral')->layout('components.layouts.candidate-exam');
    }
}
