<?php

namespace App\Livewire\Candidate\Exam;

use Livewire\Component;

class CandidateAssessment extends Component
{
    public function render()
    {
        return view('livewire.candidate.exam.candidate-assessment')->layout('components.layouts.candidate-app');
    }
}
