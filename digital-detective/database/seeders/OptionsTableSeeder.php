<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Option; 
use Illuminate\Support\Facades\DB;

class OptionsTableSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('options')->insert([
            [
                'id' => 1,
                'question_id' => 5,
                'text' => 'v žádném',
                'is_correct' => 0,
                'next_chapter_id' => 9,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 2,
                'question_id' => 5,
                'text' => 'synovec a strýc',
                'is_correct' => 0,
                'next_chapter_id' => 9,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 3,
                'question_id' => 5,
                'text' => 'strýc a synovec',
                'is_correct' => 0,
                'next_chapter_id' => 9,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 4,
                'question_id' => 5,
                'text' => 'bratranci',
                'is_correct' => 1,
                'next_chapter_id' => 10,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 5,
                'question_id' => 5,
                'text' => 'jedna a táž osoba (pseudonym)',
                'is_correct' => 0,
                'next_chapter_id' => 9,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
        ]);

         DB::table('options')->insert([
            [
                'id' => 6,
                'question_id' => 7,
                'text' => 'ano',
                'is_correct' => 1,
                'next_chapter_id' => 14,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 7,
                'question_id' => 7,
                'text' => 'ne',
                'is_correct' => 0,
                'next_chapter_id' => 13,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 8,
                'question_id' => 7,
                'text' => 'ještě nevím',
                'is_correct' => 0,
                'next_chapter_id' => 13,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 9,
                'question_id' => 10,
                'text' => 'mlýnské kolo',
                'is_correct' => 0,
                'next_chapter_id' => 19,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 10,
                'question_id' => 10,
                'text' => 'svíčka',
                'is_correct' => 1,
                'next_chapter_id' => 20,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 11,
                'question_id' => 10,
                'text' => 'namočené lano',
                'is_correct' => 0,
                'next_chapter_id' => 19,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 12,
                'question_id' => 17,
                'text' => 'pouliční dráha v Praze',
                'is_correct' => 0,
                'next_chapter_id' => 33,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 13,
                'question_id' => 17,
                'text' => 'páternoster ve Škroupově ulici v Plzni',
                'is_correct' => 1,
                'next_chapter_id' => 34,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 14,
                'question_id' => 17,
                'text' => 'Fontána na výstavišti v Praze',
                'is_correct' => 0,
                'next_chapter_id' => 33,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 15,
                'question_id' => 17,
                'text' => 'osvětlení v domě Emila Škody',
                'is_correct' => 0,
                'next_chapter_id' => 33,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
        ]);
    }
}
