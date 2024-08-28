<?php

namespace App\Livewire\Admin;
use App\Models\event as event;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use Livewire\Component;

class ManageEvents extends Component
{
    use WithFileUploads, Actions, WithPagination;
    public $add_modal = false;
    public $edit_modal = false;
    public $search, $eventname;
    public $event_id;
    protected $rules = [
        'eventname' => 'required|string|max:255',
    ];

    public function render()
    {
        $search = '%' .$this->search. '%';
        return view('livewire.admin.manage-events',[
            'events' => event::where('id', 'like', $search)->paginate(10),
        ]);

    }

public function addevent(){
    $this->validate();

    Event::create([
        'eventname' => $this->eventname,
    ]);

    $this->notification()->success(
        $title = 'Data saved!',
        $description = 'The events details were saved successfully'
    );
    $this->reset(['eventname', 'add_modal']);

  $this->add_modal = false;
}

public function edit($id)
{
    $event = Event::findOrFail($id);
    $this->event_id = $event->id;
    $this->eventname = $event->eventname;
    $this->edit_modal = true;
}

public function updateevent()
{
    $this->validate();

    $event = Event::findOrFail($this->event_id);
    $event->update([
        'eventname' => $this->eventname,
    ]);

    $this->dialog([
        'title'       => 'Data saved!',
        'description' => 'The event was updated successfully',
        'icon'        => 'success'
    ]);

    $this->reset(['eventname', 'edit_modal', 'event_id']);
}

public function delete($id)
{
    Event::findOrFail($id)->delete();

    $this->dialog([
        'title'       => 'Data Deleted!',
        'description' => 'The event was deleted successfully',
        'icon'        => 'trash'
    ]);
}
}
