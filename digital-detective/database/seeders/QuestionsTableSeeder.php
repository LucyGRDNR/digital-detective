<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question; 

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Question::create([
            'chapter_id' => 1,
            'content' => 'Budeš tedy lupiče pronásledovat?',
            'question_type' => '1',
        ]);

        Question::create([
            'chapter_id' => 1,
            'content' => 'Spočítej, kolikátý je ošahlík (ten hodně osahaný andílek) zleva a kolikátý zprava. Obě čísla porovnej – mají jednu společnou vlastnost. Napiš odpověď, jaká jsou to čísla...',
            'question_type' => '2',
        ]);
    }
}
