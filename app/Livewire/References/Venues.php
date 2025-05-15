<?php

namespace App\Livewire\References;

use Livewire\Component;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;


class Venues extends Component
{
    use WithPagination;
    public $editMode;

    public $archive = false;

    public $search;
    public $name, $location, $venue_id;

    protected $listeners = ['deleteVenue'];

    public function mount()
    {
        $user = auth()->user();

        if(!$user->can('read reference')){
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.references.venues', [
            'venues' => $this->getVenues()
        ]);
    }
    

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'name'  => ['required', 
                'string', Rule::unique('venues', 'name')->ignore($this->venue_id),
            ],
            'location' => ['required', 'string'],   
        ];
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function getVenues()
    {
        $query = Venue::with(['assignedAssessments', 'assignedPracticals', 'assignedOrals']);

        if ($this->archive) {
            $query->onlyTrashed(); 
        }

        return $query
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('location','like','%'. $this->search .'%');
            })
            ->paginate(10);
    }


    public function createVenue()
    {
        $this->validate();
        DB::transaction(function () {
            $venue = new Venue();
            $venue->name = $this->name;
            $venue->location = $this->location;
            $venue->save();
        });

        $this->clear();
        $this->dispatch('hide-venueModal');
        $this->dispatch('success', 'Venue Created Successfully');
    }


    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function readVenue($venueId)
    {
        $venue = Venue::withTrashed()->findOrFail($venueId);

        $this->fill(
            $venue->only(['name', 'location'])
        );

        $this->venue_id = $venue->id;
        $this->editMode = true;
        $this->dispatch('show-venueModal');
    }

    public function updateVenue()
    {
        $this->validate();

        DB::transaction(function () {  
            $venue = Venue::withTrashed()->findOrFail($this->venue_id);
            
            $venue->name = $this->name;
            $venue->location = $this->location;
            $venue->save();
        });

        $this->clear();
        $this->dispatch('hide-venueModal');
        $this->dispatch('success', 'Venue updated successfully.');
    }


    public function confirmDelete($id)
    {

        $this->dispatch('confirm-delete', 
            message: 'this venue will be sent to archive',
            eventName: 'deleteVenue',
            eventData: ['id' => $id]
        );
    }


    public function deleteVenue($id)
    {
        Venue::findOrFail($id)->delete();
         
        $this->dispatch('success', 'Venue archived successfully');
    }

    public function restoreVenue($venue_id)
    {
        $venue = Venue::withTrashed()->findOrFail($venue_id);
        $venue->restore();
    
        $this->dispatch('success', 'Venue restored successfully.');
    }

    public function showAddEditModal()
    {
        $this->clear();
        $this->dispatch('show-venueModal');
    }
}
