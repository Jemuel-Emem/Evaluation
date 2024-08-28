<?php

namespace App\Livewire\Admin;

use App\Models\ratings as rate;
use Livewire\Component;
use Livewire\WithPagination;

class Ratings extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        $search = '%' . $this->search . '%';

        // Fetch ratings and calculate totals for each event
        $ratings =rate::where('eventname', 'like', $search)->paginate(10);
        $eventRatings = [];

        foreach ($ratings as $rating) {
            if (!isset($eventRatings[$rating->eventname])) {
                $eventRatings[$rating->eventname] = [
                    'stronglyagree' => 0,
                    'agree' => 0,
                    'moderatelyagree' => 0,
                    'disagree' => 0,
                    'strongdisagree' => 0,
                ];
            }

            $eventRatings[$rating->eventname]['stronglyagree'] += $rating->stronglyagree;
            $eventRatings[$rating->eventname]['agree'] += $rating->agree;
            $eventRatings[$rating->eventname]['moderatelyagree'] += $rating->moderatelyagree;
            $eventRatings[$rating->eventname]['disagree'] += $rating->disagree;
            $eventRatings[$rating->eventname]['strongdisagree'] += $rating->strongdisagree;
        }

        return view('livewire.admin.ratings', [
            'ratings' => $ratings,
            'eventRatings' => $eventRatings,
        ]);
    }
}
