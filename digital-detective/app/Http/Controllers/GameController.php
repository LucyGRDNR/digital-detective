<?php

namespace App\Http\Controllers;

use App\Models\Chapter;

class GameController extends Controller
{
    public function play($storyId)
    {
        $firstChapter = Chapter::where('story_id', $storyId)->orderBy('id')->first();

        return view('play', [
            'story_id' => $storyId,
            'first_chapter_id' => $firstChapter->id,
        ]);
    }
}
