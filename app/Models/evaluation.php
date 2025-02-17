<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'program_activities_id',
        'venue_id',
        'accommodations_id',
        'speaker_id',
    ];

    // Relationships
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function programActivity()
    {
        return $this->belongsTo(Program_Activity_Question::class, 'program_activities_id');
    }
    public function programActivities()
    {
        return $this->belongsToMany(Program_Activity_Question::class, 'evaluation_program_activity');
    }

    public function venue()
    {
        return $this->belongsTo(venue_questions::class, 'venue_id');
    }

    public function accommodation()
    {
        return $this->belongsTo(accomodations_question::class, 'accommodations_id');
    }

    public function speaker()
    {
        return $this->belongsTo(speaker_question::class, 'speaker_id');
    }
}
