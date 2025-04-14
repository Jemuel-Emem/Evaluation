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
    public function getRatingInterpretation($mean)
    {
        if ($mean >= 4.5) {
            return 'Strongly Agree';
        } elseif ($mean >= 3.5) {
            return 'Agree';
        } elseif ($mean >= 2.5) {
            return 'Moderately Agree';
        } elseif ($mean >= 1.5) {
            return 'Disagree';
        } else {
            return 'Strongly Disagree';
        }
    }
    public function render()
    {
        $search = '%' . $this->search . '%';

        // Get all events for dropdown
        $eventsList = Rate::select('eventname')->groupBy('eventname')->get();

        // Fetch event ratings for the selected event
        $eventRatings = Rate::when($this->selectedEvent, function ($query) {
            $query->where('eventname', $this->selectedEvent);
        })
        ->where('eventname', 'like', $search)
        ->select('eventname',
            DB::raw('COUNT(DISTINCT user_id) as total_respondents'),
            DB::raw('SUM(stronglyagree) as stronglyagree'),
            DB::raw('SUM(agree) as agree'),
            DB::raw('SUM(moderatelyagree) as moderatelyagree'),
            DB::raw('SUM(disagree) as disagree'),
            DB::raw('SUM(strongdisagree) as stronglydisagree'))
        ->groupBy('eventname')
        ->paginate(1);

        // Fetch program activity ratings for the selected event
        $programActivityRatings = DB::table('program_activity_ratings') // Assuming this is the correct table
            ->when($this->selectedEvent, function ($query) {
                $query->where('eventname', $this->selectedEvent);
            })
            ->select('eventname',
                DB::raw('SUM(stronglyagree) as program_stronglyagree'),
                DB::raw('SUM(agree) as program_agree'),
                DB::raw('SUM(moderatelyagree) as program_moderatelyagree'),
                DB::raw('SUM(disagree) as program_disagree'),
                DB::raw('SUM(stronglydisagree) as program_stronglydisagree'))
            ->groupBy('eventname')
            ->get();

        // Fetch venue ratings for the selected event
        $venueRatings = DB::table('venue_ratings')
            ->when($this->selectedEvent, function ($query) {
                $query->where('eventname', $this->selectedEvent);
            })
            ->select('eventname',
                DB::raw('SUM(stronglyagree) as venue_stronglyagree'),
                DB::raw('SUM(agree) as venue_agree'),
                DB::raw('SUM(moderatelyagree) as venue_moderatelyagree'),
                DB::raw('SUM(disagree) as venue_disagree'),
                DB::raw('SUM(stronglydisagree) as venue_stronglydisagree'))
            ->groupBy('eventname')
            ->get();

        // Fetch accommodation ratings for the selected event
        $accommodationRatings = DB::table('accomodations_ratings')
            ->when($this->selectedEvent, function ($query) {
                $query->where('eventname', $this->selectedEvent);
            })
            ->select('eventname',
                DB::raw('SUM(stronglyagree) as accommodation_stronglyagree'),
                DB::raw('SUM(agree) as accommodation_agree'),
                DB::raw('SUM(moderatelyagree) as accommodation_moderatelyagree'),
                DB::raw('SUM(disagree) as accommodation_disagree'),
                DB::raw('SUM(stronglydisagree) as accommodation_stronglydisagree'))
            ->groupBy('eventname')
            ->get();

        // Fetch speaker ratings for the selected event
        $speakerRatings = DB::table('speaker_ratings')
            ->when($this->selectedEvent, function ($query) {
                $query->where('eventname', $this->selectedEvent);
            })
            ->select('eventname',
                DB::raw('SUM(stronglyagree) as speaker_stronglyagree'),
                DB::raw('SUM(agree) as speaker_agree'),
                DB::raw('SUM(moderatelyagree) as speaker_moderatelyagree'),
                DB::raw('SUM(disagree) as speaker_disagree'),
                DB::raw('SUM(stronglydisagree) as speaker_stronglydisagree'))
            ->groupBy('eventname')
            ->get();

        // Merge ratings data into event ratings
        $eventRatings->each(function ($rating) use ($programActivityRatings, $venueRatings, $accommodationRatings, $speakerRatings) {
            $programRating = $programActivityRatings->firstWhere('eventname', $rating->eventname);
            if ($programRating) {
                $rating->program_stronglyagree = $programRating->program_stronglyagree;
                $rating->program_agree = $programRating->program_agree;
                $rating->program_moderatelyagree = $programRating->program_moderatelyagree;
                $rating->program_disagree = $programRating->program_disagree;
                $rating->program_stronglydisagree = $programRating->program_stronglydisagree;
            }

            $venueRating = $venueRatings->firstWhere('eventname', $rating->eventname);
            if ($venueRating) {
                $rating->venue_stronglyagree = $venueRating->venue_stronglyagree;
                $rating->venue_agree = $venueRating->venue_agree;
                $rating->venue_moderatelyagree = $venueRating->venue_moderatelyagree;
                $rating->venue_disagree = $venueRating->venue_disagree;
                $rating->venue_stronglydisagree = $venueRating->venue_stronglydisagree;
            }

            $accommodationRating = $accommodationRatings->firstWhere('eventname', $rating->eventname);
            if ($accommodationRating) {
                $rating->accommodation_stronglyagree = $accommodationRating->accommodation_stronglyagree;
                $rating->accommodation_agree = $accommodationRating->accommodation_agree;
                $rating->accommodation_moderatelyagree = $accommodationRating->accommodation_moderatelyagree;
                $rating->accommodation_disagree = $accommodationRating->accommodation_disagree;
                $rating->accommodation_stronglydisagree = $accommodationRating->accommodation_stronglydisagree;
            }

            $speakerRating = $speakerRatings->firstWhere('eventname', $rating->eventname);
            if ($speakerRating) {
                $rating->speaker_stronglyagree = $speakerRating->speaker_stronglyagree;
                $rating->speaker_agree = $speakerRating->speaker_agree;
                $rating->speaker_moderatelyagree = $speakerRating->speaker_moderatelyagree;
                $rating->speaker_disagree = $speakerRating->speaker_disagree;
                $rating->speaker_stronglydisagree = $speakerRating->speaker_stronglydisagree;
            }
        });




        return view('livewire.admin.index', [
            'eventRatings' => $eventRatings,
            'programActivityRatings' => $programActivityRatings,
            'venueRatings' => $venueRatings,
            'accommodationRatings' => $accommodationRatings,
            'speakerRatings' => $speakerRatings,
            'eventsList' => $eventsList,
         //'eventQuestions' => $eventQuestions,
        ]);
    }


}


