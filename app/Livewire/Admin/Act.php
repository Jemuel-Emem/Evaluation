<?php
namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\CategoryQuestion;
use Livewire\Component;
use Livewire\WithPagination;

class Act extends Component
{
    use WithPagination;

    public $question_text;

    public $cat_name;
    public $edit_id    = null;
    public $add_modal  = false;
    public $edit_modal = false;

    public $category_id;

    protected $rules = [
        'question_text' => 'required|string|min:5|max:255',
    ];

    public function addquestion()
    {
        $this->validate();

        CategoryQuestion::create([
            'category_id' => $this->category_id,
            'question'    => $this->question_text,
        ]);

        $this->reset(['question_text', 'add_modal']);
        session()->flash('message', 'Question added successfully.');
    }

    public function edit($id)
    {
        $question            = CategoryQuestion::findOrFail($id);
        $this->edit_id       = $id;
        $this->question_text = $question->question;
        $this->edit_modal    = true;
    }

    public function updatequestion()
    {
        $this->validate();

        if ($this->edit_id) {
            CategoryQuestion::where('id', $this->edit_id)
                ->update(['question' => $this->question_text]);
        }

        $this->reset(['question_text', 'edit_id', 'edit_modal']);
        session()->flash('message', 'Question updated successfully.');
    }

    public function delete($id)
    {
        CategoryQuestion::findOrFail($id)->delete();
        session()->flash('message', 'Question deleted successfully.');
    }

    public function mount()
    {
        $this->category_id = request('id');

        $this->cat_name = Category::where('id', $this->category_id)->first()->name;
    }
    public function render()
    {

        return view('livewire.admin.act', [
            'questions' => CategoryQuestion::where('category_id', $this->category_id)->paginate(5),
        ]);
    }
}
