<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Sample quest data
        $quests = [
            [
                'title' => 'Adventure in Prague',
                'location' => 'Prague',
                'duration' => '2 hours',
                'distance' => '5 km',
                'language' => 'Czech',
                'image' => 'https://via.placeholder.com/400x200?text=Prague'
            ],
            [
                'title' => 'Mystery in Brno',
                'location' => 'Brno',
                'duration' => '1.5 hours',
                'distance' => '3 km',
                'language' => 'Czech',
                'image' => 'https://via.placeholder.com/400x200?text=Brno'
            ],
            [
                'title' => 'Escape in Ostrava',
                'location' => 'Ostrava',
                'duration' => '3 hours',
                'distance' => '8 km',
                'language' => 'English',
                'image' => 'https://via.placeholder.com/400x200?text=Ostrava'
            ],
        ];

        return view('welcome', compact('quests'));
    }
}