<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;
    use SoftDeletes;
    protected $table = 'schedules';
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
        'start_schedule' => 'datetime',
        'due_schedule' => 'datetime',
        'before_due_schedule' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    //Pemilik Schedule
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Category Schedule
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
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

    public static function boot()
    {
        parent::boot();

        // Sebelum model disimpan
        static::saving(function ($schedule) {
            $schedule->updateStatus();
        });

        // Setelah model dimuat
        static::retrieved(function ($schedule) {
            $oldStatus = $schedule->status;
            $schedule->updateStatus();
            
            // Jika status berubah, simpan langsung ke database
            if ($oldStatus !== $schedule->status) {
                $schedule->saveQuietly(); // Menggunakan saveQuietly untuk menghindari infinite loop
            }
        });
    }

    /**
     * Hitung status (to-do, processed, overdue) berdasar waktu.
     * Jika sudah 'completed', tidak di-override.
     * Jangan save() di sini.
     */

    public function updateStatus(): void
        {
            // Jika sudah completed, tidak perlu update
            if ($this->status === 'completed') {
                return;
            }

            $now = Carbon::now();
            $start = $this->start_schedule;
            $due = $this->due_schedule;

            $oldStatus = $this->status;
            
            // Update status berdasarkan waktu
            if ($now->lt($start)) {
                $this->status = 'to-do';
            } elseif ($now->gte($start) && $now->lte($due)) {
                $this->status = 'processed';
            } elseif ($now->gt($due)) {
                $this->status = 'overdue';
            }

            // Log perubahan status jika ada
            if ($oldStatus !== $this->status) {
                Log::info("Schedule ID {$this->id} status changed from {$oldStatus} to {$this->status}");
            }
        }

    // Tambahkan method untuk mendapatkan status label yang lebih deskriptif
    public function getStatusLabel()
    {
        switch ($this->status) {
            case 'to-do':
                return 'Akan Dikerjakan';
            case 'processed':
                if ($this->isNearDeadline()) {
                    return 'Sedang Dikerjakan (Mendekati Deadline)';
                }
                return 'Sedang Dikerjakan';
            case 'completed':
                return 'Selesai';
            case 'overdue':
                return 'Terlambat';
            default:
                return ucfirst($this->status);
        }
    }

    // Method untuk mengecek apakah schedule mendekati deadline
    public function isNearDeadline()
    {
        if ($this->status === 'completed') {
            return false;
        }

        $now = Carbon::now();
        $reminderDate = Carbon::parse($this->before_due_schedule);
        $dueDate = Carbon::parse($this->due_schedule);
        
        return $now->between($reminderDate, $dueDate) && $this->status === 'processed';
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
