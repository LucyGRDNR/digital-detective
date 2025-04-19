<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Story; 

class StoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Story::create([
            'name' => 'CHYŤ POPLETENÉHO ZLODĚJE',
            'description' => 'Procházková hra na cca 30 min, vhodná i jako procházka s dětmi. Během pátrání bude třeba si všímat míst a věcí kolem sebe a hledat různé drobnosti, což může bavit právě i děti.',
            'image_path' => 'images/zlodej.jpg',
            'place' => 'Plzeň',
            'place_GPS' => '',
            'distance' => 200,
            'time' => 30
        ]);
    }
}
