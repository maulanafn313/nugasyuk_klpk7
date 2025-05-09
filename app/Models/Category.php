<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['schedule_category'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
