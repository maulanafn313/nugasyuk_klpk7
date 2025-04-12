<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_name',
        'schedule_category',
        'priority',
        'start_schedule',
        'due_schedule',
        'before_start_schedule',
        'upload_file',
        'url',
        'description',
        'status',
    ];

    //Pemilik Schedule
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Collaborator (many-to-many)
    public function collaborators()
    {
        return $this->belongsToMany(
            User::class,
            'collaborators',
            'schedule_id', // Foreign key pada pivot table yang mengacu ke schedule
            'user_id' // Foreign key pada pivot table yang mengacu ke user
        )->withPivot('role')->withTimestamps();
    }
}
