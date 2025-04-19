<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hint extends Model
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
}
