<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter; 
use App\Models\Story;

class ChaptersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $chapter1 = Chapter::create([
            'story_id' => 1,
            'content' => 'Jsi sice na náměstí Republiky v Plzni a právě dnes mimo službu, ale když slyšíš alarm v budově České spořitelny vedle Morového sloupu na náměstí, zbystříš. Zaznamenáš, že jakýsi lupič vyloupil banku a utíká směrem k Andělíčkovi, který plní přání. Jistě to pro tak ostříleného detektiva, jako jsi, nebude žádný problém dopadnout diletanta, který jde do banky s pytlem a vybere si pobočku na kamerami hlídaném náměstí.',
            'next_chapter_id' => null,
        ]);

        $chapter2 = Chapter::create([
            'story_id' => 1,
            'content' => 'Tak takovouto odpověď by od detektiva tvého formátu skutečně nikdo nečekal. Zkus ještě jednou zvážit své rozhodnutí.',
            'next_chapter_id' => null,
        ]);

        $chapter3 = Chapter::create([
            'story_id' => 1,
            'content' => 'Inu dobrá, kola pátrací mašinérie se začínají roztáčet... Dojdi k Andělíčkovi. Pokud nevíš, kde to je, zeptej se. Ale jsi přece detektiv... A až tam budeš, zvol pokračovat. Můžeš si případně poznamenat ADHLC jako kód dalšího úkolu.',
            'next_chapter_id' => null,
        ]);

        $chapter4 = Chapter::create([
            'story_id' => 1,
            'content' => 'Pokud ještě nejsi u Andělíčka, tak rychle doběhni a pátrej dále… A právě před ním stojí holčička, která má jediné přání – zjistit, co mají společného dvě čísla. Když jí pomůžeš, prozradí ti, kam utíkal lupič, kterého hledáš.',
            'next_chapter_id' => null,
        ]);

        $chapter5 = Chapter::create([
            'story_id' => 1,
            'content' => 'Nene, kroutí hlavou holčička. Tahle odpověď určitě není správná. Už to slovo i slyšela, ale nemůže si vzpomenout. Zkus ještě přemýšlet. Pokud si už vážně nevíš rady, zkus pátrat třeba ve vlastnostech čísel.',
            'next_chapter_id' => null,
        ]);

        $chapter6 = Chapter::create([
            'story_id' => 1,
            'content' => 'Výborně. Jsou to nejen lichá čísla, ale rovněž i prvočísla! A pátrání pokračuje. Dívka Ti ukázala směrem k Pražské ulici s tím, že si lupič nahlas opakoval: „Pražská 13“. „Mimochodem, 13 je také prvočíslo, že?“ zaradovala se. Můžeš si případně poznamenat KZTDM jako kód dalšího úkolu.',
            'next_chapter_id' => null,
        ]);

        $chapter1->next_chapter_id = $chapter3->id;
        $chapter1->save();

        $chapter2->next_chapter_id = $chapter1->id;
        $chapter2->save();

        $chapter3->next_chapter_id = $chapter4->id;
        $chapter3->save();

        $chapter4->next_chapter_id = $chapter6->id;
        $chapter4->save();

        $chapter5->next_chapter_id = $chapter4->id;
        $chapter5->save();
    }
}
