<?php
namespace App\Livewire\User;
use App\Models\Category;
use App\Models\program_activity_ratings;
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
    // Calculate mean ratings and program ratings
    $meanRatings = $this->calculateMeanRatings();
    $programRatings = $this->filterProgramActivityRatings(); // Get the program ratings counts

    // Save ratings to the Ratings table (all sections)
    Ratings::create([
        'user_id'         => auth()->id(),
        'eventname'       => $this->eventname,
        'stronglyagree'   => $meanRatings['Strongly Agree'] ?? 0,
        'agree'           => $meanRatings['Agree'] ?? 0,
        'moderatelyagree' => $meanRatings['Moderately Agree'] ?? 0,
        'disagree'        => $meanRatings['Disagree'] ?? 0,
        'strongdisagree'  => $meanRatings['Strongly Disagree'] ?? 0,
        'status'          => 'Completed',
        'comments'        => $this->comments,
    ]);

    if ($programRatings) {
        program_activity_ratings::create([
            'event_id'        => $this->evaluation_id,
            'stronglyagree'   => $programRatings['Strongly Agree'],
            'agree'           => $programRatings['Agree'],
            'moderatelyagree' => $programRatings['Moderately Agree'],
            'disagree'        => $programRatings['Disagree'],
            'stronglydisagree'=> $programRatings['Strongly Disagree'],
        ]);
    }

    // Success dialog
    $this->dialog()->success(
        'Evaluation Saved!',
        'Your evaluation has been successfully submitted. Thank you for your feedback!'
    );

    $this->hasEvaluated = true;
}


//     public function submitEvaluation()
// {


//     // if ($this->hasEvaluated) {
//     //     $this->dialog()->error(
//     //         'Already Evaluated!',
//     //         'You have already submitted an evaluation for this event.'
//     //     );
//     //     return;
//     // }

//     // Calculate ratings once and store in a variable
//     $meanRatings = $this->calculateMeanRatings();

//     // Save ratings to the Ratings table (all sections)
//      Ratings::create([
//          'user_id'         => auth()->id(),
//          'eventname'       => $this->eventname,
//          'stronglyagree'   => $meanRatings['Strongly Agree'] ?? 0,
//          'agree'           => $meanRatings['Agree'] ?? 0,
//          'moderatelyagree' => $meanRatings['Moderately Agree'] ?? 0,
//          'disagree'        => $meanRatings['Disagree'] ?? 0,
//          'strongdisagree'  => $meanRatings['Strongly Disagree'] ?? 0,
//          'status'          => 'Completed',
//          'comments'        => $this->comments,
//      ]);


//     $programRatings = $this->filterProgramActivityRatings();

//     // Ensure that program activity ratings exist before saving
//     if ($programRatings) {
//         program_activity_ratings::create([
//             'event_id'        => $this->evaluation_id,
//             'stronglyagree'   => $programRatings['Strongly Agree'] ?? 0,
//             'agree'           => $programRatings['Agree'] ?? 0,
//             'moderatelyagree' => $programRatings['Moderately Agree'] ?? 0,
//             'disagree'        => $programRatings['Disagree'] ?? 0,
//             'stronglydisagree'=> $programRatings['Strongly Disagree'] ?? 0,
//         ]);
//     }

//     $this->dialog()->success(
//         'Evaluation Saved!',
//         'Your evaluation has been successfully submitted. Thank you for your feedback!'
//     );

//     $this->hasEvaluated = true;
// }

// Method to filter ratings specifically for Program Activity Questions
// public function filterProgramActivityRatings()
// {
//     // Debug: Check the evaluation ID
//     $evaluation =$this->evaluation_id = (int) $this->evaluation_id;
//     // Check if the evaluation is fetched correctly
//      // Check if the evaluation is being fetched correctly

//     if (!$evaluation) {
//         return [
//             'Strongly Agree'    => 0,
//             'Agree'             => 0,
//             'Moderately Agree'  => 0,
//             'Disagree'          => 0,
//             'Strongly Disagree' => 0,
//         ];
//     }

//     // Get the category 'programActivity' from the categories table
//     $category = \App\Models\Category::where('name', 'Program Activities')->first();


//     if (!$category) {
//         // No category found with the name 'programActivity'
//         return [
//             'Strongly Agree'    => 0,
//             'Agree'             => 0,
//             'Moderately Agree'  => 0,
//             'Disagree'          => 0,
//             'Strongly Disagree' => 0,
//         ];
//     }

//     // Get the program activity questions related to this category for the evaluation
//     $programQuestionIds = \App\Models\EvaluationForm::where('event_id', $this->evaluation_id)
//         ->where('category_id', $category->id) // Use category id directly here
//         ->pluck('category_id') // Check if this returns the correct category IDs
//         ->toArray();
//    // Debug: Check the program question IDs

//     // Initialize an empty array to store the ratings
//     $programRatings = [
//         'Strongly Agree'    => 0,
//         'Agree'             => 0,
//         'Moderately Agree'  => 0,
//         'Disagree'          => 0,
//         'Strongly Disagree' => 0,
//     ];

//     // Loop through the ratings and associate them with program activity questions
//     foreach ($this->ratings as $questionId => $rating) {
//         $questionId = (int) $questionId; // Ensure the question ID is an integer

//         // Debug: Check each rating before processing
//       //  dd($questionId, $rating); // Debug the question ID and rating

//         // Check if the question ID is part of the program activity questions
//         if (in_array($questionId, $programQuestionIds)) {
//             // Convert rating to category and increment the appropriate rating counter
//             $category = $this->getCategory((float) $rating);
//             $programRatings[$category]++;
//         }
//     }

//     // Debug: Check the final ratings before returning
//     //dd($programRatings); // Check the final categorized ratings

//     return $programRatings;
// }

public function filterProgramActivityRatings()
{
    // Ensure evaluation_id is cast to an integer
    $evaluationId = (int) $this->evaluation_id;
dd( $evaluationId);
    if (!$evaluationId) {
        return [
            'Strongly Agree'    => 0,
            'Agree'             => 0,
            'Moderately Agree'  => 0,
            'Disagree'          => 0,
            'Strongly Disagree' => 0,
        ];
    }

    // Get the program activity category
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

    // Get program activity question IDs
    $programQuestionIds = \App\Models\CategoryQuestion::where('category_id', $this->evaluation_id)
        ->where('category_id', $category->id)
        ->pluck('category_id')  // Ensure this fetches the right questions
        ->toArray();

    // Initialize rating counters
    $programRatings = [
        'Strongly Agree'    => 0,
        'Agree'             => 0,
        'Moderately Agree'  => 0,
        'Disagree'          => 0,
        'Strongly Disagree' => 0,
    ];

    // Loop through all ratings, and ensure each question is counted
    foreach ($this->ratings as $questionId => $rating) {
        $questionId = (int) $questionId; // Ensure question ID is an integer
        $rating = (int) $rating; // Ensure rating is an integer as well

        // Debug: Check the question ID and rating before proceeding
      //  dd($questionId, $rating);

        // Check if the question is part of the program activity questions
        if (in_array($questionId, $programQuestionIds)) {
            // Convert the rating value to the corresponding category
            $category = $this->getCategory((float) $rating);  // Ensure rating is processed as a float

            // Increment the counter for that category
            $programRatings[$category]++;
        }
    }

    // Debug: Check the program ratings before returning
    // dd($programRatings);

    return $programRatings;
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
