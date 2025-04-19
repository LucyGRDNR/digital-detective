<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function hint()
    {
        return $this->hasOne(Hint::class);
    }

}
