<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $quests = [
            [
                'title' => 'Dobrodružství v Praze',
                'location' => 'Praha',
                'duration' => '2 hodiny',
                'distance' => '5 km',
                'language' => 'CZ',
                'image' => asset('storage/images/praha.jpg')
            ],
            [
                'title' => 'Tajemství Brna',
                'location' => 'Brno',
                'duration' => '1.5 hodiny',
                'distance' => '3 km',
                'language' => 'CZ',
                'image' => asset('storage/images/brno.jpg')
            ],
            [
                'title' => 'Útěk z Ostravy',
                'location' => 'Ostrava',
                'duration' => '3 hodiny',
                'distance' => '8 km',
                'language' => 'EN',
                'image' => asset('storage/images/ostrava.jpg')
            ],
        ];

        return view('welcome', compact('quests'));
    }
}