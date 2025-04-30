<?php
namespace App\Http\Controllers;

use App\Models\Story;

class StoryController extends Controller
{
    public function show($id)
    {
        $story = Story::findOrFail($id);

        return view('show', compact('story'));
    }
}
