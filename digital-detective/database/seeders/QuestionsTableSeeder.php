<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question; 
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            [
                'id' => 1,
                'chapter_id' => 1,
                'text' => 'Vydej se na západo-jiho-západ až ke dvěma cibulovitým věžím. Jednoslovný název stavby, kterou tyto věže zdobí, zadej jako kód pro další cestu.',
                'type' => 1,
                'wrong_feedback' => 'Bohužel, toto není správný název. Světová strana rozhodně nekončí na kraji náměstí. Jaká stavba s dvěma věžemi by se tím směrem mohla asi nacházet?',
                'input_answer' => 'synagoga',
                'hint' => 'Jako další nápověda může být, že v té stavbě trvale nežijí lidé.',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 2,
                'chapter_id' => 3,
                'text' => 'Copak asi ty hebrejské znaky znamenají? Ukaž, jak jsi na tom s teologií.',
                'type' => 1,
                'wrong_feedback' => 'Tak znaky z téhle desky se jako celek nazývají jinak.' . "\n" . 'Je to české slovo, celkem běžně známé, i když ateisté jej nepoužijí tak často.',
                'input_answer' => 'desatero',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 3,
                'chapter_id' => 5,
                'text' => 'Kdopak je autorem literární předlohy? Správnou odpovědí je příjmení autora.',
                'type' => 1,
                'wrong_feedback' => 'Je to autor mnoha pohádek. Jeho jméno je tak notoricky známé, že další nápověda snad ani není třeba',
                'input_answer' => 'andersen',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 4,
                'chapter_id' => 7,
                'text' => 'Dojdi k jedné z nich a příjmení zadej, abys potvrdil, že jsi na správném místě.',
                'type' => 1,
                'wrong_feedback' => 'Pokud Tě nic nenapadá, projdi si sochy v okolí a podívej se, jak se ti pánové jmenují.',
                'input_answer' => 'smetana',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 5,
                'chapter_id' => 9,
                'text' => 'V jakém příbuzenském stavu byli Bedřich a Josef František?',
                'type' => 3,
                'wrong_feedback' => 'Zkus to znovu!',
                'input_answer' => NULL,
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 6,
                'chapter_id' => 11,
                'text' => 'Ale kterýpak strom má takhle krásné lusky?' . "\n" . 'To je jistě skoro botanický oříšek.',
                'type' => 1,
                'wrong_feedback' => 'Bohužel, takový strom nebožtík na mysli zcela jistě neměl.',
                'input_answer' => 'katalpa',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
        ]);

        DB::table('questions')->insert([
            [
                'id' => 7,
                'chapter_id' => 13,
                'text' => 'Budeš tedy lupiče pronásledovat?',
                'type' => 3,
                'wrong_feedback' => 'Tak takovouto odpověď by od detektiva tvého formátu skutečně nikdo nečekal. Zkus ještě jednou zvážit své rozhodnutí.',
                'input_answer' => NULL,
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 8,
                'chapter_id' => 15,
                'text' => 'Napiš odpověď, jaká jsou to čísla...',
                'type' => 1,
                'wrong_feedback' => 'Nene, kroutí hlavou holčička. Tahle odpověď určitě není správná. Už to slovo i slyšela, ale nemůže si vzpomenout. Zkus ještě přemýšlet.',
                'input_answer' => 'prvočísla',
                'hint' => 'Pokud si už vážně nevíš rady, zkus pátrat třeba ve vlastnostech čísel.',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 9,
                'chapter_id' => 17,
                'text' => 'Tak copak vidíš zajímavého na domě?',
                'type' => 1,
                'wrong_feedback' => 'Bohužel nikoli. Ale možná by Ti mohlo napovědět zjištění, jaký je právě čas.',
                'input_answer' => 'sluneční hodiny',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 10,
                'chapter_id' => 19,
                'text' => 'Poradíš mu, jaký předmět z následující nabídky má kamarádovi pořídit?',
                'type' => 3,
                'wrong_feedback' => 'Ne tak docela. Ale pokud tě napadá, jak by se tím dal měřit čas, určitě budeme rádi za návrh. Ale nyní zkus ještě něco jiného',
                'input_answer' => NULL,
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 11,
                'chapter_id' => 21,
                'text' => 'A níže zadej číslo lampy u druhého místa.',
                'type' => 2,
                'wrong_feedback' => 'Toto bohužel není hledané číslo. Stojíš určitě na správném místě? Je to nejbližší lampa? Jen hledej…',
                'input_answer' => '24424',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 12,
                'chapter_id' => 23,
               'text' => 'A níže zadej číslo lampy u druhého místa.',
                'type' => 2,
                'wrong_feedback' => 'Toto bohužel není hledané číslo. Stojíš určitě na správném místě? Je to nejbližší lampa? Jen hledej…',
                'input_answer' => '14841',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 13,
                'chapter_id' => 25,
                'text' => 'A níže zadej číslo lampy u druhého místa.',
                'type' => 2,
                'wrong_feedback' => 'Toto bohužel není hledané číslo. Stojíš určitě na správném místě? Je to nejbližší lampa? Jen hledej…',
                'input_answer' => '14842',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 14,
                'chapter_id' => 27,
                'text' => 'A níže zadej číslo lampy u druhého místa.',
                'type' => 2,
                'wrong_feedback' => 'Toto bohužel není hledané číslo. Stojíš určitě na správném místě? Je to nejbližší lampa? Jen hledej…',
                'input_answer' => '14844',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 15,
                'chapter_id' => 29,
                'text' => 'A níže zadej číslo lampy u druhého místa.',
                'type' => 2,
                'wrong_feedback' => 'Toto bohužel není hledané číslo. Stojíš určitě na správném místě? Je to nejbližší lampa? Jen hledej…',
                'input_answer' => '00247',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 16,
                'chapter_id' => 31,
                'text' => 'A níže zadej číslo lampy u druhého místa.',
                'type' => 2,
                'wrong_feedback' => 'Toto bohužel není hledané číslo. Stojíš určitě na správném místě? Je to nejbližší lampa? Jen hledej…',
                'input_answer' => '00248',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 17,
                'chapter_id' => 33,
                'text' => 'Poraď mu, na kterém z projektů se Křižík nepodílel.',
                'type' => 3,
                'wrong_feedback' => 'Tak na tomto projektu se kupodivu František křižík nepodílel. Zkus si tipnout nějaký jiný.',
                'input_answer' => NULL,
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 18,
                'chapter_id' => 35,
                'text' => 'Zajímá ho zejména do kolika má muzeum otevřeno v neděli, když je normálně otevřeno. Poradíš mu?',
                'type' => 1,
                'wrong_feedback' => 'Klučina se na Tebe nevěřícně podívá, ale asi ti moc nevěří a dál marně snaží zahlédnout kýženou část otevírací doby. Chtělo by to asi zkontrolovat, zda se fakt díváš na neděli a zadáváš číslo běžné zavírací hodiny.',
                'input_answer' => '18:00',
                'hint' => 'Čas musí být zapsán ve formátu HH:MM, tedy například 13:30.',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
            [
                'id' => 19,
                'chapter_id' => 37,
                'text' => 'Kolik Kč vlastně stojí malá?',
                'type' => 2,
                'wrong_feedback' => 'Když se kolem sebe rozhlédneš, jistě hned uvidíš planetu, která jako by spadla na zem rovnou z nebe.',
                'input_answer' => '20',
                'hint' => '',
                'created_at' => '2025-06-18 07:33:25',
                'updated_at' => '2025-06-18 07:33:25'
            ],
        ]);
    }
}
