<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Cms extends Model
{
    use HasFactory;
    protected $fillable = [
        'color',
        'logo',
        'hero_text',
        'description_text',
        'hero_text2',
        'description_text2',
        'img_text2',
        'hero_text3',
        'description_text3',
        'img_text3',
        'hero_text4',
        'description_text4',
        'img_text4',
    ];
}



