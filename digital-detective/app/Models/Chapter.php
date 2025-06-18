<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'title',
        'content',
        'image_path',
        'next_chapter_id',
        'is_end',
    ];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    }

    public function nextChapter()
    {
        return $this->belongsTo(Chapter::class, 'next_chapter_id');
    }
}
