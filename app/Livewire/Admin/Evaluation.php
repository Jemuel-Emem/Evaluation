<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\evaluation as evals;
use App\Models\Event;
use App\Models\Program_Activity_Question as ProgramActivity;
use App\Models\venue_questions as Venue;
use App\Models\accomodations_question as Accommodation;
use App\Models\speaker_question as Speaker;
use Livewire\WithPagination;

class Evaluation extends Component
{
    use WithPagination;

    public $event_id;
    public $selectedQuestions = []; // Store selected questions as checkboxes
    public $add_modal = false;
    public $edit_modal = false;
    public $evaluation_id;

    protected $rules = [
        'event_id' => 'required|exists:events,id',
    ];

    public function resetForm()
    {
        $this->event_id = null;
        $this->selectedQuestions = [];
    }

    public function store()
    {
        $this->validate(['event_id' => 'required|exists:events,id']);

        evals::create([
            'event_id' => $this->event_id,
            'has_program_activities' => isset($this->selectedQuestions['program_activity']),
            'has_venue' => isset($this->selectedQuestions['venue']),
            'has_accommodations' => isset($this->selectedQuestions['accommodation']),
            'has_speaker' => isset($this->selectedQuestions['speaker']),
        ]);

        $this->resetForm();
        $this->add_modal = false;
    }

    public function edit($id)
    {
        $evaluation = evals::findOrFail($id);
        $this->evaluation_id = $evaluation->id;
        $this->event_id = $evaluation->event_id;
        $this->selectedQuestions = [
            'program_activity' => $evaluation->program_activities_id,
            'venue' => $evaluation->venue_id,
            'accommodation' => $evaluation->accommodations_id,
            'speaker' => $evaluation->speaker_id,
        ];
        $this->edit_modal = true;
    }

    public function update()
    {
        $this->validate();

        $evaluation = evals::findOrFail($this->evaluation_id);
        $evaluation->update([
            'event_id' => $this->event_id,
            'program_activities_id' => $this->selectedQuestions['program_activity'] ?? null,
            'venue_id' => $this->selectedQuestions['venue'] ?? null,
            'accommodations_id' => $this->selectedQuestions['accommodation'] ?? null,
            'speaker_id' => $this->selectedQuestions['speaker'] ?? null,
        ]);

        $this->resetForm();
        $this->edit_modal = false;
    }


    public function delete($id)
{
    $evaluation = evals::findOrFail($id);

    $evaluation->update([
        'program_activities_id' => null,
        'venue_id' => null,
        'accommodations_id' => null,
        'speaker_id' => null,
    ]);

    $evaluation->delete();
}



    public function render()
    {
        return view('livewire.admin.evaluation', [
            'evaluations' => evals::paginate(10),
            'events' => Event::all(),
            'programActivities' => ProgramActivity::all(),
            'venues' => Venue::all(),
            'accommodations' => Accommodation::all(),
            'speakers' => Speaker::all(),
        ]);
    }
}
