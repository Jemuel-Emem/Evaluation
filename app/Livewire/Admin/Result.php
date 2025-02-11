<?php

namespace App\Livewire\Admin;

use App\Models\ratings;
use Livewire\Component;

class Result extends Component
{
    public $ratings;
    public $selectedEvent = ''; // Property to store the selected event name
    public $events; // Property to store all unique event names

    public function mount()
    {
        // Fetch all unique event names for the dropdown
        $this->events = ratings::distinct('eventname')->pluck('eventname');

        // Fetch all ratings with user and event details
        $this->filterRatings();
    }

    public function filterRatings()
    {
        // Filter ratings based on the selected event
        $this->ratings = ratings::with('user')
            ->when($this->selectedEvent, function ($query) {
                $query->where('eventname', $this->selectedEvent);
            })
            ->get();
    }

    public function updatedSelectedEvent()
    {
        // Re-fetch ratings whenever the selected event changes
        $this->filterRatings();
    }

    public function render()
    {
        return view('livewire.admin.result', [
            'ratings' => $this->ratings,
            'events' => $this->events,
        ]);
    }

public function sa(){

}
}
