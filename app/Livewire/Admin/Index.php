<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ratings as Rate;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $search = '';
    public $selectedEvent = null;

    public function updatedSelectedEvent($value)
    {
        $this->selectedEvent = $value;
    }

    public function view(){
        $this->render();
    }

    public function render()
    {
        $search = '%' . $this->search . '%';

        // Get all events for dropdown
        $eventsList = Rate::select('eventname')->groupBy('eventname')->get();

        // Filter event ratings based on the selected event
        $eventRatings = Rate::when($this->selectedEvent, function ($query) {
                $query->where('eventname', $this->selectedEvent);
            })
            ->where('eventname', 'like', $search)
            ->select('eventname',
                DB::raw('SUM(stronglyagree) as stronglyagree'),
                DB::raw('SUM(agree) as agree'),
                DB::raw('SUM(moderatelyagree) as moderatelyagree'),
                DB::raw('SUM(disagree) as disagree'),
                DB::raw('SUM(strongdisagree) as strongdisagree'))
            ->groupBy('eventname')
            ->paginate(1); // Paginate by 1 item per page

        // Calculate percentages and total evaluations
        $eventRatings->each(function ($rating) {
            $totalResponses = $rating->stronglyagree + $rating->agree + $rating->moderatelyagree + $rating->disagree + $rating->strongdisagree;

            $rating->total_responses = $totalResponses; // Total users who evaluated the event

            $rating->stronglyagree_percentage = $totalResponses > 0 ? ($rating->stronglyagree / $totalResponses) * 100 : 0;
            $rating->agree_percentage = $totalResponses > 0 ? ($rating->agree / $totalResponses) * 100 : 0;
            $rating->moderatelyagree_percentage = $totalResponses > 0 ? ($rating->moderatelyagree / $totalResponses) * 100 : 0;
            $rating->disagree_percentage = $totalResponses > 0 ? ($rating->disagree / $totalResponses) * 100 : 0;
            $rating->strongdisagree_percentage = $totalResponses > 0 ? ($rating->strongdisagree / $totalResponses) * 100 : 0;
        });

        return view('livewire.admin.index', [
            'eventRatings' => $eventRatings,
            'eventsList' => $eventsList,
        ]);
    }
}
