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
            'is_wrong' => false,
            'wrong_chapter_id' => 2,
            'next_chapter_id' => 3,
        ]);

        Option::create([
            'question_id' => 1,
            'text' => 'Ne',
            'is_wrong' => true,
            'wrong_chapter_id' => 2,
            'next_chapter_id' => 3,
        ]);

        Option::create([
            'question_id' => 1,
            'text' => 'Ještě nevím',
            'is_wrong' => true,
            'wrong_chapter_id' => 2,
            'next_chapter_id' => 3,
        ]);

        Option::create([
            'question_id' => 2,
            'text' => 'Prvočísla',
            'is_wrong' => false,
            'wrong_chapter_id' => 5,
            'next_chapter_id' => 6,
        ]);

        Option::create([
            'question_id' => 3,
            'text' => 'Sluneční hodiny',
            'is_wrong' => false,
            'wrong_chapter_id' => 8,
            'next_chapter_id' => 9,
        ]);

        Option::create([
            'question_id' => 4,
            'text' => 'mlýnské kolo',
            'is_wrong' => true,
            'wrong_chapter_id' => 11,
            'next_chapter_id' => 12,
        ]);

        Option::create([
            'question_id' => 4,
            'text' => 'svíčka',
            'is_wrong' => false,
            'wrong_chapter_id' => 11,
            'next_chapter_id' => 12,
        ]);

        Option::create([
            'question_id' => 4,
            'text' => 'namočené lano',
            'is_wrong' => true,
            'wrong_chapter_id' => 11,
            'next_chapter_id' => 12,
        ]);

        Option::create([
            'question_id' => 5,
            'text' => '24424',
            'is_wrong' => false,
            'wrong_chapter_id' => 14,
            'next_chapter_id' => 15,
        ]);
    }
}
