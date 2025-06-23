<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{   
    /**
     * Display the welcome page with a list of all stories.
     * This method retrieves all available stories from the database and passes
     * them to the 'welcome' view.
     *
     * @return \Illuminate\View\View Returns the 'welcome' view populated with story data.
     */
    public function index()
    {
        $stories = Story::all();

        return view('welcome', compact('stories'));
    }
}