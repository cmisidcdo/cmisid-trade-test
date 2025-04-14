<?php

namespace App\Livewire\Candidate;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.candidate.home')->layout('components.layouts.candidate-app');
    }
}
