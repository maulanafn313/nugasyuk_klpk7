<?php




namespace App\Models;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;




class Faq extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'answer',
        'answered_by',
        'answered_at',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answeredBy()
    {
        return $this->belongsTo(User::class, 'answered_by');
    }
}
