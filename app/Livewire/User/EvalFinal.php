<?php

namespace App\Livewire\User;
use App\Models\Question;
use App\Models\ratings;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use Livewire\Component;

class EvalFinal extends Component
{
    use WithFileUploads, Actions, WithPagination;
    public $questionid, $eventname;
    public $ratings = [];

    public function mount($questionid = null)
    {
        $this->questionid = $questionid;
        $selectedQuestion = Question::find($this->questionid);
        if ($selectedQuestion) {
            $this->eventname = $selectedQuestion->eventname;
        }
    }

    public function submitEvaluation()
    {
        $meanRatings = $this->calculateMeanRatings();


        $stronglyAgreeCount = 0;
        $agreeCount = 0;
        $moderatelyAgreeCount = 0;
        $disagreeCount = 0;
        $stronglyDisagreeCount = 0;


        foreach ($meanRatings as $rating) {
            switch ($rating['category']) {
                case 'Strongly Agree':
                    $stronglyAgreeCount++;
                    break;
                case 'Agree':
                    $agreeCount++;
                    break;
                case 'Moderately Agree':
                    $moderatelyAgreeCount++;
                    break;
                case 'Disagree':
                    $disagreeCount++;
                    break;
                case 'Strongly Disagree':
                    $stronglyDisagreeCount++;
                    break;
            }
        }




        ratings::create([
            'eventname' => $this->eventname,
            'stronglyagree' => $stronglyAgreeCount,
            'agree' => $agreeCount,
            'moderatelyagree' => $moderatelyAgreeCount,
            'disagree' => $disagreeCount,
            'strongdisagree'=>$stronglyDisagreeCount
        ]);
        dd("done");

    }
    public function calculateMeanRatings()
    {
        $meanRatings = [];

        foreach ($this->ratings as $questionId => $rating) {
            // Convert to an array if it's not already
            if (!is_array($rating)) {
                $rating = [$rating];
            }
            $mean = array_sum($rating) / count($rating);
            $category = $this->getCategory($mean);
            $meanRatings[$questionId] = [
                'mean' => $mean,
                'category' => $category,
            ];
        }

        return $meanRatings;
    }

    public function getCategory($mean)
    {
        if ($mean >= 4.20) {
            return 'Strongly Agree';
        } elseif ($mean >= 3.40) {
            return 'Agree';
        } elseif ($mean >= 2.60) {
            return 'Moderately Agree';
        } elseif ($mean >= 1.80) {
            return 'Disagree';
        } else {
            return 'Strongly Disagree';
        }
    }
    public function render()
    {
        $selectedQuestion = Question::find($this->questionid);
        $questions = Question::where('eventname', $selectedQuestion->eventname)->paginate(10);

        return view('livewire.user.eval-final', [
            'questionid' => $this->questionid,
            'questions' => $questions,
        ]);
    }
}
