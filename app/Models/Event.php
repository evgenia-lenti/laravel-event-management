<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'capacity',
        'current_registrations_count',
        'status',
    ];

    protected $casts = [
        'status' => EventStatus::class,
        'event_date' => 'datetime',
    ];

    public function registrations()
    {
        return $this->belongsToMany(User::class, 'event_registrations')->withTimestamps();
    }
}
