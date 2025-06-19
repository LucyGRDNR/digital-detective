<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter; 
use App\Models\Story;
use Illuminate\Support\Facades\DB;

class ChaptersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('chapters')->insert([
            [
                'id' => 1,
                'story_id' => 1,
                'title' => 'Nebožtíkův poklad',
                'content' => 'Najala si tě rodina bohatého, ale trochu podivínského nebožtíka. Ten na sklonku svého bohulibého života, hnán motivací mít alespoň vnoučata s širokým rozhledem, ukryl značnou část svého majetku na neznámém místě a zanechal dědicům jen první indícii. Dědicové jsou v koncích, tak povolali tebe. Honorář je pochopitelně vedlejší, jde přece o test tvých schopností.' . "\n\n" . 'Důležité je se dostat na náměsti v Plzni. Odhadneš, které to má být?' . "\n" . 'Už jsi na náměstí? Tak se nyní postav zády ke katedrále sv. Bartoloměje a prokaž svůj smysl pro orientaci v prostoru.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 2,
                'story_id' => 1,
                'title' => 'Pokračovat',
                'content' => 'Dobrá práce! Pátrání pokračuje.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 3,
                'story_id' => 1,
                'title' => 'Synagoga',
                'content' => 'Mezi dvojicí věží Velké synagogy je stříška, která ukrývá kamennou desku.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 4,
                'story_id' => 1,
                'title' => 'Pokračovat',
                'content' => 'Výborně, další obor máš za sebou! Přesuň se k Divadlu J. K. Tyla a prokaž, že ti ani kultura není cizí.' . "\n" . 'Až se přesuneš, pokračuj.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 5,
                'story_id' => 1,
                'title' => 'Divadlo J. K. Tyla',
                'content' => 'Před nedávnem měla premiéru Malá mořská víla',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 6,
                'story_id' => 1,
                'title' => 'Pokračovat',
                'content' => 'Správně! Je vidět, že nejsi kulturní barbar! Pokračuj do městských sadů.' . "\n" . 'Až tam budeš, zvol pokračovat.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 7,
                'story_id' => 1,
                'title' => 'Sadový okruh',
                'content' => 'Nacházíš se na začátku sadového okruhu. Někde blízko kolem jsou sochy dvou mužů stejných příjmení.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 8,
                'story_id' => 1,
                'title' => 'Pokračovat',
                'content' => 'No ano! Tak tedy jdeme dále.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 9,
                'story_id' => 1,
                'title' => 'Socha Smetany',
                'content' => 'A teď jedna záludná otázka:',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 10,
                'story_id' => 1,
                'title' => 'Pokračovat',
                'content' => 'Skvělé! Takže i vědomosti z historie ti nejsou cizí. Jen pokračuj, už jsi skoro u cíle.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 11,
                'story_id' => 1,
                'title' => 'Tajemný strom',
                'content' => 'Téměř to vypadá, že to bude prostě klasicky poklad zakopaný pod stromem.',
                'image_path' => 'chapter_images/katalpa-chapter.jpg',
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 12,
                'story_id' => 1,
                'title' => 'Konec',
                'content' => 'Bravo! I otázka z botaniky byla zodpovězena správně.' . "\n" . 'A zde také pátrání končí. Nacházíš vzkaz od nebožtíka pro jeho dědice, který si můžeš poslechnout kliknutím SEM a kromě odměny, kterou od nich jistě dostaneš, tě může hřát pocit zdárně vyřešeného případu.',
                'image_path' => NULL,
                'is_end' => 1,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
        ]);
        

        DB::table('chapters')->where('id', 1)->update(['next_chapter_id' => 2]);
        DB::table('chapters')->where('id', 2)->update(['next_chapter_id' => 3]);
        DB::table('chapters')->where('id', 3)->update(['next_chapter_id' => 4]);
        DB::table('chapters')->where('id', 4)->update(['next_chapter_id' => 5]);
        DB::table('chapters')->where('id', 5)->update(['next_chapter_id' => 6]);
        DB::table('chapters')->where('id', 6)->update(['next_chapter_id' => 7]);
        DB::table('chapters')->where('id', 7)->update(['next_chapter_id' => 8]);
        DB::table('chapters')->where('id', 8)->update(['next_chapter_id' => 9]);
        DB::table('chapters')->where('id', 9)->update(['next_chapter_id' => 10]);
        DB::table('chapters')->where('id', 10)->update(['next_chapter_id' => 11]);
        DB::table('chapters')->where('id', 11)->update(['next_chapter_id' => 12]);

          DB::table('chapters')->insert([
            [
                'id' => 13,
                'story_id' => 2,
                'title' => 'Nebožtíkův poklad',
                'content' => 'Jsi sice na náměstí Republiky v Plzni a právě dnes mimo službu, ale když slyšíš alarm v budově České spořitelny vedle Morového sloupu na náměstí, zbystříš. Zaznamenáš, že jakýsi lupič vyloupil banku a utíká směrem k Andělíčkovi, který plní přání. Jistě to pro tak ostříleného detektiva, jako jsi, nebude žádný problém dopadnout diletanta, který jde do banky s pytlem a vybere si pobočku na kamerami hlídaném náměstí.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 14,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Inu dobrá, kola pátrací mašinérie se začínají roztáčet... Dojdi k Andělíčkovi. Pokud nevíš, kde to je, zeptej se. Ale jsi přece detektiv... A až tam budeš, zvol pokračovat.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 15,
                'story_id' => 2,
                'title' => 'Holčička u Andělíčka',
                'content' => 'Pokud ještě nejsi u Andělíčka, tak rychle doběhni a pátrej dále…
                    A právě před ním stojí holčička, která má jediné přání – zjistit, co mají společného dvě čísla. Když jí pomůžeš, prozradí ti, kam utíkal lupič, kterého hledáš.
                    Spočítej, kolikátý je ošahlík (ten hodně osahaný andílek) zleva a kolikátý zprava. Obě čísla porovnej – mají jednu společnou vlastnost.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 16,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Výborně. Jsou to nejen lichá čísla, ale rovněž i prvočísla! A pátrání pokračuje.
                    Dívka Ti ukázala směrem k Pražské ulici s tím, že si lupič nahlas opakoval: „Pražská 13“.
                    „Mimochodem, 13 je také prvočíslo, že?“ zaradovala se.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 17,
                'story_id' => 2,
                'title' => 'Ukazatel na domě',
                'content' => 'Už jsi konečně před Pražskou 13? ',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 18,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Dobrá práce! A pátrání pokračuje.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 19,
                'story_id' => 2,
                'title' => 'Dárek pana podnikatele',
                'content' => 'Hned vedle stojí bohatý podnikatel a nahlas přemýšlí, jaký dárek by měl koupit pro svého kamaráda.
                    Rád by mu dal něco extravagantního, co by současně dokázalo měřit čas.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 20,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Ano, je to svíčka!
                    Ta časoměrná má na sobě barevně oddělené pruhy a jak odhořívá, měří čas.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 21,
                'story_id' => 2,
                'title' => 'Fotografická stopa',
                'content' => 'Podnikatel byl tak nadšen, že ti dal k dispozici fotografie, které pořídil a na mobil odeslal jeho luxusní fotoaparát, než jej o něj připravil jakýsi chmaták. Jeho popis shodou okolností odpovídá i popisu bankovního lupiče. Vystopuj lupičovy další kroky z fragmentů nahodile pořízených obrázků. Zadávej jako odpověď vždy číslo nejbližší pouliční lampy (ano, každá lampa má své číslo). Po zadání správného čísla, obdržíš další fotografii.',
                'image_path' => 'chapter_images/foto1-2.jpg',
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 22,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Číslo je správně, můžeš pokračovat!',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 23,
                'story_id' => 2,
                'title' => 'Fotografie 3/7',
                'content' => 'Najdi místo dle obrázku níže.',
                'image_path' => 'chapter_images/foto3.jpg',
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 24,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Ano, správně! Pokračuj dále.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
             [
                'id' => 25,
                'story_id' => 2,
                'title' => 'Fotografie 4/7',
                'content' => 'Najdi místo dle obrázku níže.',
                'image_path' => 'chapter_images/foto4.jpg',
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
             [
                'id' => 26,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Skvěle, pokračuj v tomto duchu dále!',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
             [
                'id' => 27,
                'story_id' => 2,
                'title' => 'Fotografie 5/7',
                'content' => 'Najdi místo dle obrázku níže.',
                'image_path' => 'chapter_images/foto5.jpg',
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
             [
                'id' => 28,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Správná odpověď.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
             [
                'id' => 29,
                'story_id' => 2,
                'title' => 'Fotografie 6/7',
                'content' => 'Najdi místo dle obrázku níže.',
                'image_path' => 'chapter_images/foto6.jpg',
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
             [
                'id' => 30,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Jsi na správném místě!',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
              [
                'id' => 31,
                'story_id' => 2,
                'title' => 'Fotografie 7/7',
                'content' => 'Najdi místo dle obrázku níže.',
                'image_path' => 'chapter_images/foto7.jpg',
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
              [
                'id' => 32,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Paráda, chutě dále!',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 33,
                'story_id' => 2,
                'title' => 'František Křižík',
                'content' => 'Muž označovaný také jako český Edison se proslavil tzv. obloukovou lampou, která na výstavě v Paříži porazila Edisonovu žárovku a získala zlatou medaili.
                    Před plastikou stojí skupinka turistů a nešťastný průvodce si není zcela jistý informací, kterou říká.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 34,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Po opakovaném ujištění, že páternoster opravdu není dílem F. Křižíka, ti průvodce děkuje s tím, že je rád, že dobří lidé v Plzni ještě nevymřeli. On už málem nad Plzeňany zlomil hůl, neboť zrovna před malou chvílí do jejich skupinky narazil jakýsi pobuda s pytlem přes rameno a fotoaparátem v ruce...
                    A kde že se to stalo? No támhle kousek za kolejemi a pelášil směrem ke zkamenělému stromu před Západočeským muzeem.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 35,
                'story_id' => 2,
                'title' => 'Muzeum',
                'content' => 'Muzeum sice (doufejme) vidíš, ale lupič nikde. Jen před vchodem do muzea postává klučina se zmrzlinou a studuje prosklenou vitrínu. Ač umí číst, díky své výšce nemůže přečíst otevírací dobu.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 36,
                'story_id' => 2,
                'title' => 'Pokračovat',
                'content' => 'Sdělíš čas klučinovi. Moc děkuje a směřuje tě do sadů ke dřevěnému stánku se zmrzlinou. "Vypadáš vyčerpaně, co si dát zmrzlinu. Tady kousek v tom dřevěném stánku točí moje mamka zmrzlinu, určitě si tam skoč. Jistě chutnala i tomu zpocenému pánovi s pytlem přes rameno, kterému jsem to taky doporučil."
                    Vydej se tam...',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 37,
                'story_id' => 2,
                'title' => 'Stánek se zmrzlinou',
                'content' => 'Jsi na místě a zkoumavě se rozhlížíš. A co si dát také tu zmrzlinu?',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 38,
                'story_id' => 2,
                'title' => 'Konec',
                'content' => 'Výborně! Jak se tak díváš pozorněji, vidíš chlapíka s pytlem a fotoaparátem, který zrovna vystál frontu a chystá se platit a bankovky vytahuje z pytle. A již za pár okamžiků je lapen, ty jsi hrdinou dne a TV štáby tě asi (dnes) nenechají na pokoji.
                    "Úžasný zásah! Skvělá práce!" chválí tě okolní přihlížející.
                    Kromě odměny za zachráněné peníze, která na tebe jistě čeká, tě může hřát skvělý pocit z vyřešeného případu.',
                'image_path' => NULL,
                'is_end' => 1,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
        ]);

        DB::table('chapters')->where('id', 14)->update(['next_chapter_id' => 15]);
        DB::table('chapters')->where('id', 15)->update(['next_chapter_id' => 16]);
        DB::table('chapters')->where('id', 16)->update(['next_chapter_id' => 17]);
        DB::table('chapters')->where('id', 17)->update(['next_chapter_id' => 18]);
        DB::table('chapters')->where('id', 18)->update(['next_chapter_id' => 19]);

        DB::table('chapters')->where('id', 20)->update(['next_chapter_id' => 21]);
        DB::table('chapters')->where('id', 21)->update(['next_chapter_id' => 22]);
        DB::table('chapters')->where('id', 22)->update(['next_chapter_id' => 23]);
        DB::table('chapters')->where('id', 23)->update(['next_chapter_id' => 24]);
        DB::table('chapters')->where('id', 24)->update(['next_chapter_id' => 25]);
        DB::table('chapters')->where('id', 25)->update(['next_chapter_id' => 26]);
        DB::table('chapters')->where('id', 26)->update(['next_chapter_id' => 27]);
        DB::table('chapters')->where('id', 27)->update(['next_chapter_id' => 28]);
        DB::table('chapters')->where('id', 28)->update(['next_chapter_id' => 29]);
        DB::table('chapters')->where('id', 29)->update(['next_chapter_id' => 30]);
        DB::table('chapters')->where('id', 30)->update(['next_chapter_id' => 31]);
        DB::table('chapters')->where('id', 31)->update(['next_chapter_id' => 32]);
        DB::table('chapters')->where('id', 32)->update(['next_chapter_id' => 33]);

        DB::table('chapters')->where('id', 34)->update(['next_chapter_id' => 35]);
        DB::table('chapters')->where('id', 35)->update(['next_chapter_id' => 36]);
        DB::table('chapters')->where('id', 36)->update(['next_chapter_id' => 37]);
        DB::table('chapters')->where('id', 37)->update(['next_chapter_id' => 38]);

        DB::table('chapters')->insert([
            [
                'id' => 39,
                'story_id' => 3,
                'title' => 'Hala těžkých oprav',
                'content' => 'Začněte v takzvané hale těžkých oprav, která patří Spolu s autobusovou halou k největším v celém areálu. Určitě ji snadno najdete.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 40,
                'story_id' => 3,
                'title' => 'Pokračovat',
                'content' => 'Ano, to je správně. Vycházkovým krokem se nyní přesuňte do dílen v depu…. a pokračujte.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 41,
                'story_id' => 3,
                'title' => 'Háčkovaná věž',
                'content' => 'Na nádvoří areálu narazíte na 15 metrů vysokou rozhlednu s názvem Háčkovaná věž. Je trochu křivá, trochu rezavá, ale rozhodně nepřehlédnutelná. Byla postavena v rámci výstavy Restart, která vznikla jako součást projektu Plzeň Evropské hlavní město kultury 2015. A právě s touto věží souvisí i naše další otázka',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 42,
                'story_id' => 3,
                'title' => 'Pokračovat',
                'content' => 'Přesně tak! Snad jste si příjemně vystoupali a cítíte se svěží na další úkoly...',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 43,
                'story_id' => 3,
                'title' => 'Nejvyšší stavba',
                'content' => 'Pokud jste vystoupali až nahoru, rozhlédněte se kolem sebe. Odpověď na další otázku máte totiž doslova na dohled.',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 44,
                'story_id' => 3,
                'title' => 'Pokračovat',
                'content' => 'Výborně! To je správná odpověď. A kdyby to náhodou bylo náhodou, tak se na to zkuste zajít podívat ještě jednou. Pokračujte dále…',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 45,
                'story_id' => 3,
                'title' => 'Využití areálu',
                'content' => 'Než se DEPO2015 stalo kreativním prostorem plným kultury, designu a nápadů, měl tento areál zcela jiný účel. I když si teď možná kvůli názvu areálu představíte řady zaparkovaných autobusů a zvuk startujících motorů, nenechte se zmást.
                    Víte, k čemu původně tento prostor sloužil?',
                'image_path' => NULL,
                'is_end' => 0,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 46,
                'story_id' => 3,
                'title' => 'Konec',
                'content' => 'No ano! Jsi zkrátka znalci. A touto správnou odpovědí jste úspěšně završili svou cestu za poznáím prostor DEPO2015.
                    Určitě vyzkoušejte co nejvíce toho, co prostor nabízí, a nebo ještě lépe: podílejte se na zdejším dění a přispívejte svými vlastními nápady.',
                'image_path' => NULL,
                'is_end' => 1,
                'next_chapter_id' => NULL,
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],       
        ]);

        DB::table('chapters')->where('id', 39)->update(['next_chapter_id' => 40]);
        DB::table('chapters')->where('id', 40)->update(['next_chapter_id' => 41]);
        DB::table('chapters')->where('id', 41)->update(['next_chapter_id' => 42]);
        DB::table('chapters')->where('id', 42)->update(['next_chapter_id' => 43]);

        DB::table('chapters')->where('id', 44)->update(['next_chapter_id' => 45]);

    }
}
