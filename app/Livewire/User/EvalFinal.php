<?php
namespace App\Livewire\User;
use App\Models\Category;
use App\Models\program_activity_ratings;
use App\Models\accomodations_ratings;
use App\Models\speaker_ratings;
use App\Models\venue_ratings;
use App\Models\Evaluation;
use App\Models\EvaluationForm;
use App\Models\event;
use App\Models\Program_Activity_Question;
use App\Models\Ratings;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class EvalFinal extends Component
{
    use WithFileUploads, Actions, WithPagination;

    public $evaluation_id, $eventname;
    public $ratings      = [];
    public $comments     = '';
    public $hasEvaluated = false;

    public function mount()
    {
        $this->evaluation_id = request('evaluation_id');
        $event = event::where('id', $this->evaluation_id)->first();

        if ($event) {
            $this->eventname = $event->eventname;
        }


        $existingEvaluation = Ratings::where('user_id', auth()->id())
            ->where('eventname', $this->eventname)
            ->where('status', 'Completed')
            ->first();

        if ($existingEvaluation) {
            $this->hasEvaluated = true; // Disable submission if already evaluated
        }
    }

    public function render()
    {
        $evaluation = Evaluation::with(['programActivity', 'venue', 'accommodation', 'speaker'])
            ->find($this->evaluation_id);

        if (! $evaluation) {
            return view('livewire.user.eval-final', [
                'questions'  => collect([]), // Return an empty collection if no evaluation found
                'categories' => EvaluationForm::where('event_id', $this->evaluation_id)->get(),
            ]);
        }

        $programQuestions       = \App\Models\Program_Activity_Question::whereIn('id', explode(',', $evaluation->program_activities_id))->get();
        $venueQuestions         = \App\Models\venue_questions::whereIn('id', explode(',', $evaluation->venue_id))->get();
        $accommodationQuestions = \App\Models\accomodations_question::whereIn('id', explode(',', $evaluation->accommodations_id))->get();
        $speakerQuestions       = \App\Models\Speaker_Question::whereIn('id', explode(',', $evaluation->speaker_id))->get();

        // Combine all question collections
        $questions = $programQuestions->concat($venueQuestions)
            ->concat($accommodationQuestions)
            ->concat($speakerQuestions);

        return view('livewire.user.eval-final', [
            'questions'    => $questions,
            'hasEvaluated' => $this->hasEvaluated,

        ]);
    }

    public function submitEvaluation()
    {
            if ($this->hasEvaluated) {
        $this->dialog()->error(
            'Already Evaluated!',
            'You have already submitted an evaluation for this event.'
        );
        return;
    }
        // Calculate mean ratings for all categories
        $meanRatings = $this->calculateMeanRatings();


        $programRatings = $this->filterProgramActivityRatings();
        $venueRatings = $this->filterVenueRatings();
        $accommodationRatings = $this->filterAccommodationRatings();
        $speakerRatings = $this->filterSpeakerRatings();


        \App\Models\program_activity_ratings::create([
            'event_id'        => $this->evaluation_id,
            'eventname'        => $this->eventname,
               'stronglyagree'   => $programRatings['Strongly Agree'] ?? 0,
               'agree'           => $programRatings['Agree'] ?? 0,
               'moderatelyagree' => $programRatings['Moderately Agree'] ?? 0,
               'disagree'        => $programRatings['Disagree'] ?? 0,
               'stronglydisagree'  => $programRatings['Strongly Disagree'] ?? 0,
           ]);

           \App\Models\speaker_ratings::create([
            'event_id'        => $this->evaluation_id,
            'eventname'        => $this->eventname,
               'stronglyagree'   => $speakerRatings['Strongly Agree'] ?? 0,
               'agree'           => $speakerRatings['Agree'] ?? 0,
               'moderatelyagree' => $speakerRatings['Moderately Agree'] ?? 0,
               'disagree'        => $speakerRatings['Disagree'] ?? 0,
               'stronglydisagree'  => $speakerRatings['Strongly Disagree'] ?? 0,
           ]);


           \App\Models\venue_ratings::create([
            'event_id'        => $this->evaluation_id,
            'eventname'        => $this->eventname,
               'stronglyagree'   => $venueRatings['Strongly Agree'] ?? 0,
               'agree'           => $venueRatings['Agree'] ?? 0,
               'moderatelyagree' => $venueRatings['Moderately Agree'] ?? 0,
               'disagree'        => $venueRatings['Disagree'] ?? 0,
               'stronglydisagree'  => $venueRatings['Strongly Disagree'] ?? 0,
           ]);


           \App\Models\accomodations_ratings::create([
            'event_id'        => $this->evaluation_id,
            'eventname'        => $this->eventname,
               'stronglyagree'   => $accommodationRatings['Strongly Agree'] ?? 0,
               'agree'           => $accommodationRatings['Agree'] ?? 0,
               'moderatelyagree' => $accommodationRatings['Moderately Agree'] ?? 0,
               'disagree'        => $accommodationRatings['Disagree'] ?? 0,
               'stronglydisagree'  => $accommodationRatings['Strongly Disagree'] ?? 0,
           ]);

        Ratings::create([
            'user_id'         => auth()->id(),
            'event_id'        => $this->evaluation_id,
            'eventname'       => $this->eventname,
            'stronglyagree'   => $meanRatings['Strongly Agree'] ?? 0,
            'agree'           => $meanRatings['Agree'] ?? 0,
            'moderatelyagree' => $meanRatings['Moderately Agree'] ?? 0,
            'disagree'        => $meanRatings['Disagree'] ?? 0,
            'strongdisagree'  => $meanRatings['Strongly Disagree'] ?? 0,
            'status'          => 'Completed',
            'comments'        => $this->comments,
        ]);

        // Save program activity ratings separately in the program_act_rate table


        // Success dialog
        $this->dialog()->success(
            'Evaluation Saved!',
            'Your evaluation has been successfully submitted. Thank you for your feedback!'
        );

        $this->hasEvaluated = true;
    }

    // Helper method to check if programRatings has valid data
    protected function hasProgramRatings($programRatings)
    {
        // Check if any rating category has a value greater than 0
        return array_sum($programRatings) > 0;
    }


public function filterProgramActivityRatings()
{
    // Ensure evaluation_id is cast to an integer
    $evaluationId = (int) $this->evaluation_id;

    if (!$evaluationId) {
        return [
            'Strongly Agree'    => 0,
            'Agree'             => 0,
            'Moderately Agree'  => 0,
            'Disagree'          => 0,
            'Strongly Disagree' => 0,
        ];
    }

    // Step 1: Get the "Program Activities" category
    $category = \App\Models\Category::where('name', 'Program Activities')->first();

    if (!$category) {
        // No category found with name 'Program Activities'
        return [
            'Strongly Agree'    => 0,
            'Agree'             => 0,
            'Moderately Agree'  => 0,
            'Disagree'          => 0,
            'Strongly Disagree' => 0,
        ];
    }

    // Step 2: Get all question IDs for the "Program Activities" category
    $programQuestionIds = \App\Models\CategoryQuestion::where('category_id', $category->id)
        ->pluck('id')
        ->toArray();

    // Step 3: Initialize rating counters
    $programRatings = [
        'Strongly Agree'    => 0,
        'Agree'             => 0,
        'Moderately Agree'  => 0,
        'Disagree'          => 0,
        'Strongly Disagree' => 0,
    ];

    // Step 4: Loop through all ratings and filter based on program activity questions
    foreach ($this->ratings as $questionId => $rating) {
        $questionId = (int) $questionId; // Ensure question ID is an integer
        $rating = (float) $rating; // Ensure rating is a float

        // Check if the question is part of the program activity questions
        if (in_array($questionId, $programQuestionIds)) {
            // Convert the rating value to the corresponding category
            $category = $this->getCategory($rating);  // Ensure rating is processed as a float

            // Increment the counter for that category
            $programRatings[$category]++;
        }
    }

    // Debug: Check the program ratings before returning


    return $programRatings;
}

public function filterVenueRatings()
{
    $evaluationId = (int) $this->evaluation_id;

    if (!$evaluationId) {
        return [
            'Strongly Agree'    => 0,
            'Agree'             => 0,
            'Moderately Agree'  => 0,
            'Disagree'          => 0,
            'Strongly Disagree' => 0,
        ];
    }

    // Step 1: Get the "Venue" category
    $category = \App\Models\Category::where('name', 'Venue')->first();

    if (!$category) {
        return [
            'Strongly Agree'    => 0,
            'Agree'             => 0,
            'Moderately Agree'  => 0,
            'Disagree'          => 0,
            'Strongly Disagree' => 0,
        ];
    }

    // Step 2: Get all question IDs for the "Venue" category
    $venueQuestionIds = \App\Models\CategoryQuestion::where('category_id', $category->id)
        ->pluck('id')
        ->toArray();

    // Step 3: Initialize rating counters
    $venueRatings = [
        'Strongly Agree'    => 0,
        'Agree'             => 0,
        'Moderately Agree'  => 0,
        'Disagree'          => 0,
        'Strongly Disagree' => 0,
    ];

    // Step 4: Loop through all ratings and filter based on venue questions
    foreach ($this->ratings as $questionId => $rating) {
        $questionId = (int) $questionId;
        $rating = (float) $rating;

        if (in_array($questionId, $venueQuestionIds)) {
            $category = $this->getCategory($rating);
            $venueRatings[$category]++;
        }
    }

    return $venueRatings;
}

public function filterAccommodationRatings()
{
    $evaluationId = (int) $this->evaluation_id;

    if (!$evaluationId) {
        return [
            'Strongly Agree'    => 0,
            'Agree'             => 0,
            'Moderately Agree'  => 0,
            'Disagree'          => 0,
            'Strongly Disagree' => 0,
        ];
    }

    // Step 1: Get the "Accommodations" category
    $category = \App\Models\Category::where('name', 'Accommodations')->first();

    if (!$category) {
        return [
            'Strongly Agree'    => 0,
            'Agree'             => 0,
            'Moderately Agree'  => 0,
            'Disagree'          => 0,
            'Strongly Disagree' => 0,
        ];
    }

    // Step 2: Get all question IDs for the "Accommodations" category
    $accommodationQuestionIds = \App\Models\CategoryQuestion::where('category_id', $category->id)
        ->pluck('id')
        ->toArray();

    // Step 3: Initialize rating counters
    $accommodationRatings = [
        'Strongly Agree'    => 0,
        'Agree'             => 0,
        'Moderately Agree'  => 0,
        'Disagree'          => 0,
        'Strongly Disagree' => 0,
    ];

    // Step 4: Loop through all ratings and filter based on accommodation questions
    foreach ($this->ratings as $questionId => $rating) {
        $questionId = (int) $questionId;
        $rating = (float) $rating;

        if (in_array($questionId, $accommodationQuestionIds)) {
            $category = $this->getCategory($rating);
            $accommodationRatings[$category]++;
        }
    }

    return $accommodationRatings;
}

public function filterSpeakerRatings()
{
    $evaluationId = (int) $this->evaluation_id;

    if (!$evaluationId) {
        return [
            'Strongly Agree'    => 0,
            'Agree'             => 0,
            'Moderately Agree'  => 0,
            'Disagree'          => 0,
            'Strongly Disagree' => 0,
        ];
    }

    // Step 1: Get the "Speakers" category
    $category = \App\Models\Category::where('name', 'Speakers')->first();

    if (!$category) {
        return [
            'Strongly Agree'    => 0,
            'Agree'             => 0,
            'Moderately Agree'  => 0,
            'Disagree'          => 0,
            'Strongly Disagree' => 0,
        ];
    }

    // Step 2: Get all question IDs for the "Speakers" category
    $speakerQuestionIds = \App\Models\CategoryQuestion::where('category_id', $category->id)
        ->pluck('id')
        ->toArray();

    // Step 3: Initialize rating counters
    $speakerRatings = [
        'Strongly Agree'    => 0,
        'Agree'             => 0,
        'Moderately Agree'  => 0,
        'Disagree'          => 0,
        'Strongly Disagree' => 0,
    ];

    // Step 4: Loop through all ratings and filter based on speaker questions
    foreach ($this->ratings as $questionId => $rating) {
        $questionId = (int) $questionId;
        $rating = (float) $rating;

        if (in_array($questionId, $speakerQuestionIds)) {
            $category = $this->getCategory($rating);
            $speakerRatings[$category]++;
        }
    }

    return $speakerRatings;
}

public function calculateMeanRatings()
{
    $meanRatings = [
        'Strongly Agree'    => 0,
        'Agree'             => 0,
        'Moderately Agree'  => 0,
        'Disagree'          => 0,
        'Strongly Disagree' => 0,
    ];
// Add this to check the ratings array


    foreach ($this->ratings as $rating) {
        if (!is_numeric($rating)) continue;
        $category = $this->getCategory((float) $rating);
        $meanRatings[$category]++;
    }

    return $meanRatings;
}

    public function selectOnlyOne($questionId, $selectedRating)
    {
        $this->ratings[$questionId] = $selectedRating;
    }

    public function getCategory($mean)
    {
        if ($mean >= 4.20) {
            return 'Strongly Agree';
        }

        if ($mean >= 3.40) {
            return 'Agree';
        }

        if ($mean >= 2.60) {
            return 'Moderately Agree';
        }

        if ($mean >= 1.80) {
            return 'Disagree';
        }

        return 'Strongly Disagree';
    }

}
