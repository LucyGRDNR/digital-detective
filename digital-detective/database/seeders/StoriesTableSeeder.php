<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Story; 
use Illuminate\Support\Facades\DB;

class StoriesTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('stories')->insert([
            [
                'id' => 1,
                'name' => 'NAJDI NEBOŽTÍKŮV POKLAD',
                'description' => 'Procházková hra na cca 30 min, která jednoduchým a pohodovým způsobem prověří všeobecné znalosti.
                    Malé děti zcela jistě nebudou vědět odpovědi na tázané otázky, ale mohlo by je bavit si všímat míst a věcí kolem sebe a hledat nějaký ukrytý poklad.
                    Hra začíná u věže kostela na náměstí Republiky v Plzni. Pokud tedy ještě nejsi na tom správném místě, doprav se nejprve tam a poté pokračuj.
                    Poznámka pro rodiče: na konci je ale poklad pouze imaginární, takže pokud byste šli s dětmi, připravte si něco k nalezení dopředu, nebo vysvětlení, jak to s tím pokladem je. Však uvidíte!:)',
                'image_path' => 'images/poklad-story.jpg',
                'place' => 'Kostel na náměstí Republiky v Plzni',
                'place_GPS' => NULL,
                'distance' => 2,
                'time' => 30,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 2,
                'name' => 'CHYŤ POPLETENÉHO ZLODĚJE',
                'description' => 'Procházková hra na cca 30 min, vhodná i jako procházka s dětmi. Během pátrání bude třeba si všímat míst a věcí kolem sebe a hledat různé drobnosti, což může bavit právě i děti.
                    Hra začíná u věže kostela na náměstí Republiky v Plzni. Pokud tedy ještě nejsi na tom správném místě, doprav se nejprve tam a poté pokračuj.',
                'image_path' => 'images/zlodej-story.jpg',
                'place' => 'Kostel na náměstí Republiky v Plzni',
                'place_GPS' => NULL,
                'distance' => 2,
                'time' => 30,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
        ]);
}
    }
