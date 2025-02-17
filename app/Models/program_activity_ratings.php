<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program_activity_ratings extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'stronglyagree',
        'agree',
        'moderatelyagree',
        'disagree',
        'stronglydisagree',
    ];

}
