<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// app/Models/HomepageContent.php
class HomepageContent extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'image_url'];
}

