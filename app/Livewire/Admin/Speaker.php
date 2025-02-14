<?php

namespace App\Livewire\Admin;
use Livewire\WithPagination;
use App\Models\speaker_question as SpeakerQuestion;
use Livewire\Component;

class Speaker extends Component
{
    use WithPagination;

    public $speaker_question_text;
    public $selectedQuestionId;
    public $add_speaker_modal = false;
    public $edit_speaker_modal = false;

    protected $rules = [
        'speaker_question_text' => 'required|string|max:255',
    ];

    public function addSpeakerQuestion()
    {
        $this->validate();

        SpeakerQuestion::create([
            'question_text' => $this->speaker_question_text,
        ]);

        session()->flash('message', 'Question added successfully.');
        $this->reset(['speaker_question_text', 'add_speaker_modal']);
    }

    public function editSpeaker($id)
    {
        $question = SpeakerQuestion::findOrFail($id);
        $this->selectedQuestionId = $id;
        $this->speaker_question_text = $question->question_text;
        $this->edit_speaker_modal = true;
    }

    public function updateSpeakerQuestion()
    {
        $this->validate();

        if ($this->selectedQuestionId) {
            $question = SpeakerQuestion::findOrFail($this->selectedQuestionId);
            $question->update([
                'question_text' => $this->speaker_question_text,
            ]);

            session()->flash('message', 'Question updated successfully.');
            $this->reset(['speaker_question_text', 'edit_speaker_modal', 'selectedQuestionId']);
        }
    }

    public function deleteSpeaker($id)
    {
        SpeakerQuestion::findOrFail($id)->delete();
        session()->flash('message', 'Question deleted successfully.');
    }

    public function render()
    {
        $speakerQuestions = SpeakerQuestion::paginate(5);

        return view('livewire.admin.speaker', [
            'speakerQuestions' => $speakerQuestions,
        ]);
    }

}
