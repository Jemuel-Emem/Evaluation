<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;
    protected $fillable = [
        'eventname',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
