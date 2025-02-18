<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class venue_ratings extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'eventname',
        'stronglyagree',
        'agree',
        'moderatelyagree',
        'disagree',
        'stronglydisagree',
    ];
}
