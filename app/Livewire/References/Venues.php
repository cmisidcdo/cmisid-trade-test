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
    public $title, $venue_id;

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
            'title'  => ['required', 
                'string',
                Rule::unique('venues', 'title')->ignore($this->venue_id),
            ],
        ];
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

    public function getVenues()
    {
        $query = Venue::query();

        if ($this->archive) {
            $query->onlyTrashed(); 
        }

        return $query
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }

    public function createVenue()
    {
        $this->validate();
        DB::transaction(function () {
            $venue = new Venue();
            $venue->title = $this->title;
            $venue->save();
        });

        $this->clear();
        $this->dispatch('hide-venueModal');
        $this->dispatch('success', 'Venue Created Successfuly');
       
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
            $venue->only(['title']) 
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
            
            $venue->title = $this->title;
            $venue->save();
        });

        $this->clear();
        $this->dispatch('hide-venueModal');
        $this->dispatch('success', 'Venue updated successfully.');
    }

    
    public function deleteVenue(Venue $venue)
    {
        $venue->delete();

        $this->dispatch('success', 'Venue deleted successfully');
    }

    public function restoreVenue($venue_id)
    {
        $venue = Venue::withTrashed()->findOrFail($venue_id);
        $venue->restore();
    
        $this->dispatch('success', 'Venue restored successfully.');
    }
}
