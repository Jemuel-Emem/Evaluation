<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\accomodations_question as AccommodationQuestion;

class Accomodations extends Component
{
    use WithPagination;

    public $accommodation_question_text;
    public $selectedQuestionId;
    public $add_accommodation_modal = false;
    public $edit_accommodation_modal = false;

    protected $rules = [
        'accommodation_question_text' => 'required|string|max:255',
    ];

    public function addAccommodationQuestion()
    {
        $this->validate();

        AccommodationQuestion::create([
            'question_text' => $this->accommodation_question_text,
        ]);

        session()->flash('message', 'Question added successfully.');
        $this->reset(['accommodation_question_text', 'add_accommodation_modal']);
    }

    public function editAccommodation($id)
    {
        $question = AccommodationQuestion::findOrFail($id);
        $this->selectedQuestionId = $id;
        $this->accommodation_question_text = $question->question_text;
        $this->edit_accommodation_modal = true;
    }

    public function updateAccommodationQuestion()
    {
        $this->validate();

        if ($this->selectedQuestionId) {
            $question = AccommodationQuestion::findOrFail($this->selectedQuestionId);
            $question->update([
                'question_text' => $this->accommodation_question_text,
            ]);

            session()->flash('message', 'Question updated successfully.');
            $this->reset(['accommodation_question_text', 'edit_accommodation_modal', 'selectedQuestionId']);
        }
    }

    public function deleteAccommodation($id)
    {
        AccommodationQuestion::findOrFail($id)->delete();
        session()->flash('message', 'Question deleted successfully.');
    }

    public function render()
    {
        $accommodationQuestions = AccommodationQuestion::paginate(5);

        return view('livewire.admin.accomodations', [
            'accommodationQuestions' => $accommodationQuestions,
        ]);
    }
}
