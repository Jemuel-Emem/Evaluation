<?php

namespace App\Livewire\Admin;
use Livewire\WithPagination;
use App\Models\Program_Activity_Question as ProgramActivityQuestion;
use Livewire\Component;

class Act extends Component
{
    use WithPagination;

    public $question_text;
    public $edit_id = null;
    public $add_modal = false;
    public $edit_modal = false;

    protected $rules = [
        'question_text' => 'required|string|min:5|max:255',
    ];

    public function addquestion()
    {
        $this->validate();

        ProgramActivityQuestion::create([
            'text' => $this->question_text,
        ]);

        $this->reset(['question_text', 'add_modal']);
        session()->flash('message', 'Question added successfully.');
    }

    public function edit($id)
    {
        $question = ProgramActivityQuestion::findOrFail($id);
        $this->edit_id = $id;
        $this->question_text = $question->text;
        $this->edit_modal = true;
    }

    public function updatequestion()
    {
        $this->validate();

        if ($this->edit_id) {
            ProgramActivityQuestion::where('id', $this->edit_id)
                ->update(['text' => $this->question_text]);
        }

        $this->reset(['question_text', 'edit_id', 'edit_modal']);
        session()->flash('message', 'Question updated successfully.');
    }

    public function delete($id)
    {
        ProgramActivityQuestion::findOrFail($id)->delete();
        session()->flash('message', 'Question deleted successfully.');
    }
    public function render()
    {

        return view('livewire.admin.act', [
            'questions' => ProgramActivityQuestion::paginate(5),
        ]);
    }
}
