<?php

namespace App\Models;

use App\Models\Story;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function nextChapter()
    {
        return $this->belongsTo(Chapter::class, 'next_chapter_id');
    }

}
