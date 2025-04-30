<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $stories = Story::all();

        return view('welcome', compact('stories'));
    }
}