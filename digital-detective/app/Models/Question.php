<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'text',
        'type',
        'wrong_feedback',
        'input_answer',
        'hint',
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
