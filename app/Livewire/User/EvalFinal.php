<?php
namespace App\Livewire\User;

use App\Models\Evaluation;
use App\Models\EvaluationForm;
use App\Models\event;
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
        // $this->evaluation_id = $evaluation_id ?? request()->query('evaluation_id');
        // $evaluation = Evaluation::where('id', $this->evaluation_id)->first();

        // if ($evaluation) {
        //     $this->eventname = $evaluation->event->eventname;
        // }

        $this->evaluation_id = request('evaluation_id');
        $this->eventname     = event::where('id', $this->evaluation_id)->first()->eventname;
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

        $meanRatings = $this->calculateMeanRatings();

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

        $this->dialog()->success(
            'Evaluation Saved!',
            'Your evaluation has been successfully submitted. Thank you for your feedback!'
        );

        $this->hasEvaluated = true;
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

        foreach ($this->ratings as $rating) {
            $category = $this->getCategory($rating);
            $meanRatings[$category]++;
        }

        return $meanRatings;
    }
    public function selectOnlyOne($questionId, $selectedRating)
    {

        $this->ratings[$questionId] = [$selectedRating];
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
