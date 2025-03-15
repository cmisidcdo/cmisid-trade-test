<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Livewire\WithPagination;

class Logs extends Component
{

    use WithPagination;

    public $search = '';
    public $selectedLog = null;

    public function updatedSearch()
    {
        $this->resetPage(); 
    }
    public function render()
    {
        $logs = Activity::query()
            ->where('description', 'like', '%' . $this->search . '%')
            ->orWhere('log_name', 'like', '%' . $this->search . '%')
            ->orWhereHas('causer', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
            return view('livewire.logs',[
                'logs' => $logs
            ]);
    }

    public function showDetails($logId)
    {
        $this->selectedLog = Activity::find($logId);
    }
}
