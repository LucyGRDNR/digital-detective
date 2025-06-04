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

         
        Story::create([
            'name' => 'TAJNÝ POKLAD STARÉHO MĚSTA',
            'description' => 'Dobrodružná hra pro celou rodinu, která vás provede historickým centrem města. Hledejte stopy, řešte hádanky a objevte tajemství ukryté mezi starými uličkami.',
            'image_path' => 'images/poklad.jpg',
            'place' => 'Český Krumlov',
            'place_GPS' => '',
            'distance' => 1500,
            'time' => 60
        ]);

        Story::create([
            'name' => 'ZÁHADA LESNÍHO DUCHA',
            'description' => 'Napínavá stezka lesem, kde se setkáte s legendami a pověstmi místního kraje. Ideální pro milovníky přírody a tajemna.',
            'image_path' => 'images/les.jpg',
            'place' => 'Šumava',
            'place_GPS' => '',
            'distance' => 3000,
            'time' => 90
        ]);

    }
}
