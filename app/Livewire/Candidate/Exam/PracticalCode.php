<?php

namespace App\Livewire\Candidate\Exam;

use Livewire\Component;

class PracticalCode extends Component
{
    public function render()
    {
        return view('livewire.candidate.exam.practical-code')->layout('components.layouts.candidate-app');
    }
}
