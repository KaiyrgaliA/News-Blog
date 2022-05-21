<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsRubric extends Model
{
    use HasFactory;

    protected $table = 'news_rubrics';

    protected $fillable = [
        'news_id',
        'rubric_id'
    ];

    public $timestamps = false;
}
