<?php

namespace App\Livewire\Admin;
use Livewire\WithPagination;
use App\Models\venue_questions as VenueQuestion;
use Livewire\Component;

class Venue extends Component
{
    use WithPagination;

    public $venue_question_text;
    public $selectedQuestionId;
    public $add_venue_modal = false;
    public $edit_venue_modal = false;

    protected $rules = [
        'venue_question_text' => 'required|string|max:255',
    ];

    public function addVenueQuestion()
    {
        $this->validate();

        VenueQuestion::create([
            'question_text' => $this->venue_question_text,
        ]);

        session()->flash('message', 'Question added successfully.');
        $this->reset(['venue_question_text', 'add_venue_modal']);
    }

    public function editVenue($id)
    {
        $question = VenueQuestion::findOrFail($id);
        $this->selectedQuestionId = $id;
        $this->venue_question_text = $question->question_text;
        $this->edit_venue_modal = true;
    }

    public function updateVenueQuestion()
    {
        $this->validate();

        if ($this->selectedQuestionId) {
            $question = VenueQuestion::findOrFail($this->selectedQuestionId);
            $question->update([
                'question_text' => $this->venue_question_text,
            ]);

            session()->flash('message', 'Question updated successfully.');
            $this->reset(['venue_question_text', 'edit_venue_modal', 'selectedQuestionId']);
        }
    }

    public function deleteVenue($id)
    {
        VenueQuestion::findOrFail($id)->delete();
        session()->flash('message', 'Question deleted successfully.');
    }

    public function render()
    {
        $venueQuestions = VenueQuestion::paginate(5);

        return view('livewire.admin.venue', [
            'venueQuestions' => $venueQuestions,
        ]);
    }

}
