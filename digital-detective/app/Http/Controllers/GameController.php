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
   public function play(Request $request, Story $story)
    {
        $startOver = $request->query('start_over', false);

        return view('play', [
            'story' => $story,
            'startOver' => $startOver, 
        ]);
    }
}
