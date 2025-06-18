<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'text',
        'is_correct',
        'next_chapter_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function nextChapter()
    {
        return $this->belongsTo(Chapter::class, 'next_chapter_id');
    }
}
