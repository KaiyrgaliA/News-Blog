<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class News extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'anounce',
        'text',
        'author_id'
    ];

    public function authors()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function rubrics()
    {
        return $this->belongsToMany(Rubric::class, NewsRubric::class);
    }
}
