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

        $chapter7 = Chapter::create([
            'story_id' => 1,
            'content' => 'Už jsi konečně před Pražskou 13?',
            'next_chapter_id' => null,
        ]);

        $chapter8 = Chapter::create([
            'story_id' => 1,
            'content' => 'Bohužel nikoli. Ale možná by Ti mohlo napovědět zjištění, jaký je právě čas.',
            'next_chapter_id' => null,
        ]);

        $chapter9 = Chapter::create([
            'story_id' => 1,
            'content' => 'Dobrá práce! A pátrání pokračuje. Můžeš si případně poznamenat DAPOR jako kód dalšího úkolu.',
            'next_chapter_id' => null,
        ]);

        $chapter10 = Chapter::create([
            'story_id' => 1,
            'content' => 'Hned vedle stojí bohatý podnikatel a nahlas přemýšlí, jaký dárek by měl koupit pro svého kamaráda. Rád by mu dal něco extravagantního, co by současně dokázalo měřit čas.',
            'next_chapter_id' => null,
        ]);

        $chapter11 = Chapter::create([
            'story_id' => 1,
            'content' => 'Ne tak docela. Ale pokud tě napadá, jak by se tím dal měřit čas, určitě budeme rádi za návrh. Ale nyní zkus ještě něco jiného.',
            'next_chapter_id' => null,
        ]);

        $chapter12 = Chapter::create([
            'story_id' => 1,
            'content' => 'Ano, je to svíčka! Ta časoměrná má na sobě barevně oddělené pruhy a jak odhořívá, měří čas. (Můžeš si případně poznamenat FSTOA jako kód dalšího úkolu.)',
            'next_chapter_id' => null,
        ]);

        $chapter13 = Chapter::create([
            'story_id' => 1,
            'content' => 'Podnikatel byl tak nadšen, že ti dal k dispozici fotografie, které pořídil a na mobil odeslal jeho luxusní fotoaparát, než jej o něj připravil jakýsi chmaták. Jeho popis shodou okolností odpovídá i popisu bankovního lupiče. Vystopuj lupičovy další kroky z fragmentů nahodile pořízených obrázků. Zadávej jako odpověď vždy číslo nejbližší pouliční lampy (ano, každá lampa má své číslo). Po zadání správného čísla, obdržíš další fotografii.
Nejprve najdi toto místo:',
            'next_chapter_id' => null,
        ]);

        $chapter14 = Chapter::create([
            'story_id' => 1,
            'content' => 'Toto bohužel není hledané číslo. Stojíš určitě na správném místě? Je to nejbližší lampa? Jen hledej…',
            'next_chapter_id' => null,
        ]);

        $chapter15 = Chapter::create([
            'story_id' => 1,
            'content' => 'Číslo je správně, můžeš pokračovat! Můžeš si případně poznamenat F37HL jako kód dalšího úkolu.',
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

        $chapter6->next_chapter_id = $chapter7->id;
        $chapter6->save();

        $chapter7->next_chapter_id = $chapter9->id;
        $chapter7->save();

        $chapter8->next_chapter_id = $chapter7->id;
        $chapter8->save();

        $chapter9->next_chapter_id = $chapter10->id;
        $chapter9->save();

        $chapter10->next_chapter_id = $chapter10->id;
        $chapter10->save();

        $chapter11->next_chapter_id = $chapter10->id;
        $chapter11->save();

        $chapter12->next_chapter_id = $chapter13->id;
        $chapter12->save();

        $chapter13->next_chapter_id = $chapter15->id;
        $chapter13->save();

        $chapter14->next_chapter_id = $chapter13->id;
        $chapter14->save();
    }
}
