<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStoryLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'user_story_logs';

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'story_id',
        'chapter_id',
        'question_id',
        'option_id',
        'user_input',
        'is_correct_answer',
        'event_type',
        'event_description',
    ];

    /**
     * The attributes that should be cast
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_correct_answer' => 'boolean',
    ];

    /**
     * Get the user that owns the log
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the story that the log belongs to
     */
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * Get the chapter associated with the log event
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Get the question associated with the log event
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the option associated with the log event
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}