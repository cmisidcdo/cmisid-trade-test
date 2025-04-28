<?php

namespace App\Livewire;


use App\Models\User;
use App\Models\Candidate;
use App\Models\AssessmentScore;
use App\Models\AssignedAssessment;
use App\Models\AssignedPractical;
use App\Models\AssignedOral;
use Livewire\Component;

class Dashboard extends Component
{
    public $adminCount;
    public $candidateCount;
    public $incomingAssessmentCount;

    public $events = [];

    

    public function mount()
    {
        $this->adminCount = User::where('type', 'admin')->count();
        $this->candidateCount = Candidate::count();
        $this->incomingAssessmentCount = AssessmentScore::where('status', 'pending')->count();
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = [];

        // Assigned Assessments
        foreach (AssignedAssessment::all() as $assessment) {
            $this->events[] = [
                'title' => 'Assessment',
                'start' => $assessment->assigned_date . 'T' . $assessment->assigned_time,
                'color' => '#2196f3',
            ];
        }

        // Assigned Practicals
        foreach (AssignedPractical::all() as $practical) {
            $this->events[] = [
                'title' => 'Practical',
                'start' => $practical->assigned_date . 'T' . $practical->assigned_time,
                'color' => '#4caf50',
            ];
        }

        // Assigned Interviews
        foreach (AssignedOral::all() as $interview) {
            $this->events[] = [
                'title' => 'Interview',
                'start' => $interview->assigned_date . 'T' . $interview->assigned_time,
                'color' => '#ff9800',
            ];
        }
    }
    public function render()
    {
        return view('livewire.dashboard');
    }

}
