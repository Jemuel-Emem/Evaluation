<?php
namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class SurveyQuestions extends Component
{
    public function render()
    {
        return view('livewire.admin.survey-questions', [
            'categories' => Category::all(),
        ]);
    }
}
