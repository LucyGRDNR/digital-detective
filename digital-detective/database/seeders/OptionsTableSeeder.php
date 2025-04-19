<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Option; 

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Option::create([
            'question_id' => 1,
            'text' => 'Ano',
            'is_wrong' => false
        ]);

        Option::create([
            'question_id' => 1,
            'text' => 'Ne',
            'is_wrong' => true
        ]);

        Option::create([
            'question_id' => 1,
            'text' => 'Ještě nevím',
            'is_wrong' => true
        ]);
        Option::create([
            'question_id' => 2,
            'text' => 'Prvočísla',
            'is_wrong' => false
        ]);
    }
}
