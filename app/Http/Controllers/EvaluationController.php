<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Question;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function show($eventId)
    {
        $event = Event::findOrFail($eventId);
        $questions = Question::where('id', $eventId)->paginate(10); // Adjust pagination as needed

        return view('user.eval-final', compact('event', 'questions'));
    }

    // public function submit(Request $request, $eventId)
    // {
    //     $questions = Question::where('event_id', $eventId)->get();

    //     foreach ($questions as $question) {
    //         $rating = new Rating();
    //         $rating->question_id = $question->id;
    //         $rating->rating = $request->input('rating_' . $question->id);
    //         $rating->save();
    //     }

    //     return redirect()->route('evaluate.show', ['event' => $eventId])->with('success', 'Evaluation submitted successfully!');
    // }
}
