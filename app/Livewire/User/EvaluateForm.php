<?php

namespace App\Livewire\User;

use App\Models\Question;
use App\Models\Event;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class EvaluateForm extends Component
{
    use WithFileUploads, Actions, WithPagination;

    public $search;
    public $currentStep = 1;
    public $selectedEvent;
    public $questions;
    public $events;
    public $questionid;
    public $selectedQuestionId;

    public function render()
    {

        $search = '%' . $this->search . '%';

        $questions = Question::whereIn('id', function ($query) use ($search) {
            $query->selectRaw('MIN(id)')
                ->from('questions')
                ->where('eventname', 'like', $search)
                ->groupBy('eventname');
        })
        ->paginate(10);

        return view('livewire.user.evaluate-form', [
            'question' => $questions,
        ]);


    }

    public function evaluate($questionId)
{
    Session::put('selectedQuestionId', $questionId);
    return redirect()->route('eval-final');


}



}
