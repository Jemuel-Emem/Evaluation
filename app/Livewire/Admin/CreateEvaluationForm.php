<?php
namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\EvaluationForm;
use App\Models\event;
use Livewire\Component;

class CreateEvaluationForm extends Component
{
    public $selected_category = [];
    public $event_id;
    public $edit_id = null; // To track the evaluation being edited
    public $isEditing = false; // To toggle edit mode
    public $id;

    public function render()
    {
        return view('livewire.admin.create-evaluation-form', [
            'events'      => event::all(),
            'categories'  => Category::all(),
            'evaluations' => EvaluationForm::with('event')->selectRaw('event_id, MAX(id) as max_id')
                ->groupBy('event_id')
                ->orderBy('max_id', 'desc')
                ->paginate(5),
        ]);
    }

    public function edit($event_id)
    {
        $this->edit_id = $event_id;
        $this->isEditing = true;

        // Load the selected event and categories
        $this->event_id = $event_id;
        $this->selected_category = EvaluationForm::where('event_id', $event_id)
            ->pluck('category_id')
            ->toArray();
    }

    public function delete($event_id)
    {
        // Delete all evaluation forms for the selected event
        EvaluationForm::where('event_id', $event_id)->delete();

        // Reset the form and exit edit mode
        $this->resetForm();
        session()->flash('message', 'Evaluation deleted successfully.');
    }

    public function store()
    {
        // If editing, delete existing categories for the event
        if ($this->isEditing) {
            EvaluationForm::where('event_id', $this->event_id)->delete();
        }

        // Add new categories
        foreach ($this->selected_category as $category_id) {
            EvaluationForm::create([
                'event_id'    => $this->event_id,
                'category_id' => $category_id,
            ]);
        }

        // Reset the form and exit edit mode
        $this->resetForm();
        session()->flash('message', 'Evaluation saved successfully.');
    }

    public function resetForm()
    {
        $this->event_id = null;
        $this->selected_category = [];
        $this->edit_id = null;
        $this->isEditing = false;
    }
}
