<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
    'name',
    'description',
    'image_path',
    'place',
    'place_GPS',
    'distance',
    'time',
];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function progress()
    {
        return $this->hasMany(UserStoryProgress::class);
    }
}
