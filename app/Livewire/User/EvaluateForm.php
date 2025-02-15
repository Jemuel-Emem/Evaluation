<?php
namespace App\Livewire\User;

use App\Models\Evaluation;
use App\Models\EvaluationForm;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class EvaluateForm extends Component
{
    use WithPagination, Actions;

    public $search;

    public function render()
    {
        $search = '%' . $this->search . '%';

        // Ensure we always get a collection, even if empty
        $evaluations = Evaluation::whereHas('event', function ($query) use ($search) {
            $query->where('eventname', 'like', $search);
        })
            ->paginate(10) ?? collect(); // Ensure it returns a collection

        return view('livewire.user.evaluate-form', [
            'evaluations' => EvaluationForm::with('event')->selectRaw('event_id, MAX(id) as max_id')
                ->groupBy('event_id')
                ->orderBy('max_id', 'desc')
                ->paginate(5),
        ]);
    }

    public function evaluate($evaluationId)
    {
        // dd($evaluationId);
        return redirect()->route('eval-final', ['evaluation_id' => $evaluationId]);
    }

}
