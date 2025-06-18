<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStoryProgress extends Model
{
    use HasFactory;


    protected $table = 'user_story_progress';

    protected $fillable = [
        'user_id',
        'story_id',
        'current_chapter_id',
        'completed',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'is_end' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function currentChapter()
    {
        return $this->belongsTo(Chapter::class, 'current_chapter_id');
    }
}