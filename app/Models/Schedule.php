<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_name',
        'priority',
        'start_schedule',
        'due_schedule',
        'before_due_schedule',
        'upload_file',
        'url',
        'description',
        'status',
        'completed_at',
        'category_id',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    //Pemilik Schedule
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Category Schedule
    public function category()
    {
        return $this->belongsTo(Category::class);
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

    protected static function boot()
    {
        parent::boot(); 

        // Update status sebelum model disimpan
        static::saving(function ($schedule) {
            $schedule->updateStatus();
        });
    }

    /**
     * Hitung status (to-do, processed, overdue) berdasar waktu.
     * Jika sudah 'completed', tidak di-override.
     * Jangan save() di sini.
     */

        public function updateStatus()
        {
            if ($this->status === 'completed') {
                return;
            }
    
            $now   = Carbon::now();
            $start = Carbon::parse($this->start_schedule);
            $rem   = Carbon::parse($this->before_due_schedule);
            $due   = Carbon::parse($this->due_schedule);
    
            if ($now->lt($start)) {
                $this->status = 'to-do';
            } elseif ($now->between($start, $rem, false)) {
                $this->status = 'processed';
            } elseif ($now->between($rem, $due, false)) {
                $this->status = 'processed';
            } elseif ($now->gt($due)) {
                $this->status = 'overdue';
            }
        }

    // Tambahkan method untuk mendapatkan status label yang lebih deskriptif
    public function getStatusLabel()
    {
        switch ($this->status) {
            case 'to-do':
                return 'Waiting to Start';
            case 'processed':
                if (Carbon::now()->between(
                    Carbon::parse($this->before_due_schedule),
                    Carbon::parse($this->due_schedule)
                )) {
                    return 'In Progress (Near Deadline)';
                }
                return 'In Progress';
            case 'completed':
                return 'Completed';
            case 'overdue':
                return 'Overdue';
            default:
                return ucfirst($this->status);
        }
    }

    // Method untuk mengecek apakah schedule mendekati deadline
    public function isNearDeadline()
    {
        $now = Carbon::now();
        $reminderDate = Carbon::parse($this->before_due_schedule);
        $dueDate = Carbon::parse($this->due_schedule);
        
        return $now->between($reminderDate, $dueDate);
    }

    // Method helper untuk mengecek apakah schedule overdue
    public function isOverdue()
    {
        return Carbon::now()->isAfter(Carbon::parse($this->due_schedule));
    }

    // Method helper untuk mengecek apakah schedule dalam proses
    public function isInProgress()
    {
        return $this->status === 'processed';
    }

    // Method helper untuk mengecek apakah schedule completed
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /** 
     * Mark this schedule as completed — hanya boleh owner.
     */
    public function markAsCompletedByOwner(int $userId): bool
    {
        if ($this->user_id !== $userId) {
            return false;
        }
        $this->status = 'completed';
        return $this->save();
    }
}
