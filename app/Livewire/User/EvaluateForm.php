<?php

namespace App\Livewire\User;

use App\Models\Evaluation;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use Livewire\Component;

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
            'evaluations' => $evaluations,
        ]);
    }

    public function evaluate($evaluationId)
    {
 dd($evaluationId);
        return redirect()->route('eval-final', ['evaluation_id' => $evaluationId]);
    }


}
