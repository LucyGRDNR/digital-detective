<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{   
     /**
     * Display the game interface for a specific story.
     * This method prepares the view for playing a story. It can optionally
     * reset the game progress if the 'start_over' query parameter is present.
     *
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request.
     * @param  \App\Models\Story  $story The story instance to be played.
     * @return \Illuminate\View\View
     */
   public function play(Request $request, Story $story)
    {
        $startOver = $request->query('start_over', false);

        return view('play', [
            'story' => $story,
            'startOver' => $startOver, 
        ]);
    }
}
