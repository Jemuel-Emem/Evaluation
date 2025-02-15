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
    public function store()
    {
        foreach ($this->selected_category as $key => $value) {
            EvaluationForm::create([
                'event_id'    => $this->event_id,
                'category_id' => $value,

            ]);
        }
    }
}
