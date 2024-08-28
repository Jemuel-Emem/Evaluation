<?php

namespace App\Livewire\Admin;
use App\Models\User as User;
use Livewire\Component;
use App\Models\ratings as rate;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $search = '';

    public function render()
    {
        $search = '%' . $this->search . '%';

        $eventRatings = rate::where('eventname', 'like', $search)
            ->select('eventname',
                DB::raw('SUM(stronglyagree) as stronglyagree'),
                DB::raw('SUM(agree) as agree'),
                DB::raw('SUM(moderatelyagree) as moderatelyagree'),
                DB::raw('SUM(disagree) as disagree'),
                DB::raw('SUM(strongdisagree) as strongdisagree'))
            ->groupBy('eventname')
            ->get();

        // Calculate the percentages
        $eventRatings->each(function ($rating) {
            $totalResponses = $rating->stronglyagree + $rating->agree + $rating->moderatelyagree + $rating->disagree + $rating->strongdisagree;

            $rating->stronglyagree_percentage = $totalResponses > 0 ? ($rating->stronglyagree / $totalResponses) * 100 : 0;
            $rating->agree_percentage = $totalResponses > 0 ? ($rating->agree / $totalResponses) * 100 : 0;
            $rating->moderatelyagree_percentage = $totalResponses > 0 ? ($rating->moderatelyagree / $totalResponses) * 100 : 0;
            $rating->disagree_percentage = $totalResponses > 0 ? ($rating->disagree / $totalResponses) * 100 : 0;
            $rating->strongdisagree_percentage = $totalResponses > 0 ? ($rating->strongdisagree / $totalResponses) * 100 : 0;
        });

        return view('livewire.admin.index', [
            'eventRatings' => $eventRatings,
        ]);
    }
    }

