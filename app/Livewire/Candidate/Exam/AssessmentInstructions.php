<?php

namespace App\Livewire\Candidate\Exam;

use Livewire\Component;

class AssessmentInstructions extends Component
{
    public function render()
    {
        return view('livewire.candidate.exam.assessment-instructions')->layout('components.layouts.candidate-app');
    }

    public function proceedToTest()
    {
        $this->dispatch('openTestInNewTab');
    }
}
