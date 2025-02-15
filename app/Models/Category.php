<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function evaluationForms()
    {
        return $this->hasMany(EvaluationForm::class);
    }

    public function categoryQuestions()
    {
        return $this->hasMany(CategoryQuestion::class);
    }
}
