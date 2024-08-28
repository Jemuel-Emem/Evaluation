<?php

namespace App\Livewire\Admin;
use App\Models\event as Event;
use App\Models\question as survey;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use Livewire\Component;

class ManageQuestions extends Component
{
    use WithFileUploads, Actions, WithPagination;
    public $search, $eventname, $question, $survey_id;
    public $add_modal = false;
    public $edit_modal = false;
    protected $rules = [
        'eventname' => 'required',
        'question' => 'required|string|max:255',
    ];
    public function render()
    {
        // $search = '%' .$this->search. '%';
        // return view('livewire.admin.manage-questions',[
        //     'survey' => survey::where('id', 'like', $search)->paginate(10),
        // ]);

        $search = '%' . $this->search . '%';
        return view('livewire.admin.manage-questions', [
            'events' => Event::all(),
            'surveys' => Survey::where('id', 'like', $search)->paginate(10),
        ]);

    }

    public function addSurvey()
    {
        $this->validate();

        Survey::create([
            'eventname' => $this->eventname,
            'questtion' => $this->question,
        ]);
        $this->dialog([
            'title'       => 'Data saved!',
            'description' => 'The question was added successfully',
            'icon'        => 'success'
        ]);
        $this->reset(['eventname', 'question', 'add_modal']);


    }

    public function edit($id)
    {
        $survey = Survey::findOrFail($id);
        $this->survey_id = $survey->id;
        $this->eventname = $survey->eventname;
        $this->question = $survey->questtion;
        $this->edit_modal = true;
    }

    public function updateSurvey()
    {
        $this->validate();

        $survey = Survey::findOrFail($this->survey_id);
        $survey->update([
            'eventname' => $this->eventname,
            'questtion' => $this->question,
        ]);

        $this->dialog([
            'title'       => 'Data updated!',
            'description' => 'The question was updated successfully',
            'icon'        => 'success'
        ]);

        $this->reset(['eventname', 'question', 'edit_modal', 'survey_id']);
    }
    public function closeModal(){
        $this->add_modal = "false";
    }

    public function delete($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->delete();

        $this->notification()->success(
            $title = 'Data deleted!',
            $description = 'The survey question was deleted successfully'
        );

        $this->render();
    }

}
