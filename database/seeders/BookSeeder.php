<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Book::count() == 0) {
            $b1 = new Book();
            $b1->isbn = 9786155628177;
            $b1->title = "S.T.A.L.K.E.R. - Katasztrófa sújtotta terület";
            $b1->description = "Hemul, a kommandós kiképzőből lett stalker rosszul tűri, ha csapata nem az elvárásai szerint viselkedik. Ám mivel kockázatos küldetéseiért kapott pénze rendszerint kifolyik a keze közül, most mégis kénytelen kísérőül szegődni egy csoport extrém kalandokat kereső, öntörvényű turista mellé. A Zóna azonban nem az a hely, ahová önfeledt szafarikra járhat az ember.
            A vadásztúra ígéretesen indul, ám a mutánsoktól hemzsegő vidék korántsem veszélytelen. Az első összecsapások után a csapat tagjai arra is ráébrednek, hogy a legveszedelmesebb szörnyeknek olykor emberarcuk van. No persze olykor a turisták sem egyszerű turisták. De hogy az önként vállalt vesszőfutást ki ússza meg élve, ki juthat ki a Zónából - ha ki lehet még jutni belőle egyáltalán -, azt még egy tapasztalt stalker sem tudja előre megmondani.";
            $b1->genre = "Sci-fi";
            $b1->language = "magyar";
            $b1->publisher = "Metropolis Group Media";
            $b1->writers = "Vaszilij Orehov";
            $b1->cover = "images/book_covers/9786155628177.jpg";
            $b1->publish_date = 2017;
            $b1->number_of_pages = 361;
            $b1->save();

            $b2 = new Book();
            $b2->isbn = 9786155628399;
            $b2->title = "S.T.A.L.K.E.R. - Tűzvonal";
            $b2->description = "Hemul legutóbbi, tragikusan végződő 'túravezetése' után klánját, barátait, munkáját és szerelmét is elvesztette, ezért végleg hátat fordított a Zónának. Vagy legalábbis így gondolta. Most azonban ismét a Zónában van, a hangulata pedig nem valami rózsás, mert egy régi barátja pisztolya mered rá negyven lépés távolságról.
            A cél persze nem ő, hanem egy körülötte keringő, életveszélyes relikvia, egy úgynevezett Boszorkánytojás, melynek már a puszta érintése is halálos. Hemul és barátja abban bíznak, hogy egy jól irányzott lövés kitérítheti szédítő pályájáról, és ezzel alkalom nyílik a menekülésre.
            A találat nyomán a relikvia szétrobban, és szilánkjai beterítik a stalkert... ám ő mégis életben marad, sőt látomása támad: egy tüzes vonalat pillant meg maga előtt.";
            $b2->genre = "Sci-fi";
            $b2->language = "magyar";
            $b2->publisher = "Metropolis Group Media";
            $b2->writers = "Vaszilij Orehov";
            $b2->cover = "images/book_covers/9786155628399.jpg";
            $b2->publish_date = 2017;
            $b2->number_of_pages = 360;
            $b2->save();

            $b3 = new Book();
            $b3->isbn = 9786155628689;
            $b3->title = "S.T.A.L.K.E.R. - Hadműveleti Zóna";
            $b3->description = "Hemult felkavaró álmok kísértik, miközben csapatával kifelé tartanak a Zónából. A szerelme, Gyinka kiszabadítására szervezett akció jól alakult, már csak élve el kell érniük a Határt. Ám valami titokzatos, láthatatlan hatalom jár a nyomukban, mindent elpusztítva, ami az útjába kerül.
            Az előttük húzódó labirintus hirtelen megsokszorozódik, amikor találkoznak egy régi ismerőssel, és megtudják tőle, hogy a Zónában valójában hét párhuzamos valóság keresztezi egymást. Az egyik ráadásul egy olyan, életre kelt rémálom, ahol az anomáliákból továbbfejlesztett fegyverekkel vívják épp a harmadik világháborút.
            A stalkerek csapata kereszttűzbe keveredik a vérszomjas szörnyetegek és a zónatechnológiás szuperfegyverek harapófogójában, és úgy tűnik, már csak a csoda segíthet rajtuk ebben a feje tetejére állt világban.";
            $b3->genre = "Sci-fi";
            $b3->language = "magyar";
            $b3->publisher = "Metropolis Group Media";
            $b3->writers = "Vaszilij Orehov";
            $b3->cover = "images/book_covers/9786155628689.jpg";
            $b3->publish_date = 2018;
            $b3->number_of_pages = 241;
            $b3->save();

            $b4 = new Book();
            $b4->isbn = 9786155508608;
            $b4->title = "S.T.A.L.K.E.R. - Agyar";
            $b4->description = "A stalker életében egyszer eljön az a pillanat, amikor már nem is tudja, miért megy a Zónába. Úgy vonzódik hozzá, mint gyermek az anyjához, mint vadállat az itatóhoz, mint virág a naphoz. Nem tudja, mit eredményez az útja, csak azt, hogy kezével rejtélyeket és szentségeket fog kiszakítani a Zóna méhéből.
            Néhány év után a stalker függővé válik. Nem élhet a Zóna nélkül. Nem tud meglenni a halálos kockázat nélkül, az őt körülvevő csend nélkül, a feje fölötti bágyadt napfény nélkül. Próbáld meg fél évre bezárni a négy fal közé, és megtapasztalhatod, milyen a stalker a Zóna nélkül.
            Pedig folyamatos küzdelem az élete: ki a fogát hagyja ott, ki csak valamelyik testrészét.
            Stalker volt, de most nyomorék, aki már nem mehet a Zónába. Végzete arra ítélte, hogy ott éljen a közelében, hallja hívását, lássa, ahogy szerencsésebb bajtársai elmennek és visszatérnek, s meghaljon a vágytól, mely már soha sem válhat valóra.
            A legtöbb stalker életében eljön a végső összecsapás ideje is, amikor határoznia kell: boldogan hal meg a csatában, vagy életben marad, emberi roncsként. Ez egy nagyon fontos döntés, mindenki a saját képességei szerint hozza meg: megtáncoltatni ellenségeit egy halálos forgatagban, és egyesülni velük a Zóna időtlenségében, vagy feladni egy részt saját belső világából, és megmenteni azt, ami ezután már alig ér valamit: az életét.
            Az igazi stalker megérzi, amikor eljön a végső csata ideje. És ezt mindenki másképp éli meg. De ha felfogtad, ha megragadtad, ha beléd ivódott, akkor neked már semmit sem kell elmagyarázni. Az utolsó pillanat, átitatva a csata gyönyörűségével mi lehet ennél szebb?";
            $b4->genre = "Sci-fi";
            $b4->language = "magyar";
            $b4->publisher = "Metropolis Media Group";
            $b4->writers = "Jezsi Tumanovszkij";
            $b4->cover = "images/book_covers/9786155508608.jpg";
            $b4->publish_date = 2016;
            $b4->number_of_pages = 264;
            $b4->save();

            $b5 = new Book();
            $b5->isbn = 9789635510115;
            $b5->title = "S.T.A.L.K.E.R. - Kikett a zóna egybekötött...";
            $b5->description = "A Zóna nem kedveli a turistákat, de azokat, akiket befogadott, nem engedi el olyan egyszerűen. A Kova néven ismert stalker egyszer csak úgy határozott, visszatér szokványos életéhez - két társával együtt felhagyott a portyázással, eladta zsákmányát, és visszaváltozott Alekszej Kozsevnyikovvá, mesterszerelővé, szerető férjjé és apává. De a Zóna kegyetlen emlékeztetőt adott neki, és Alekszej kénytelen útnak indulni újra, hogy megmentse tízéves kisfiát... E veszélyes utazáson ellenfelei vagy szövetségesei - hisz bármikor felcserélődnek a jóság és gonoszság pólusai - egy hírszerző tiszt, egy ifjú üzletember és egy szektásokkal üzletelő bandita, mindenki a maga saját céljaival. És a Zónával folytatott, gyakran egyenlőtlen küzdelemben végül mindig kiderül: valamennyi anomália közül a legrosszabb és a legkiszámíthatatlanabb maga az ember... ";
            $b5->genre = "Sci-fi";
            $b5->language = "magyar";
            $b5->publisher = "Metropolis Group Media";
            $b5->writers = "Roman Kulikov, Jezsi Tumanovszkij";
            $b5->cover = "images/book_covers/9789635510115.jpg";
            $b5->publish_date = 2020;
            $b5->number_of_pages = 408;
            $b5->save();

            $b6 = new Book();
            $b6->isbn = 9789635449828;
            $b6->title = "A legrosszabb esküvői tanú";
            $b6->description = "Egy oltár előtt elhagyott esküvőszervező? Ja, persze, az iróniát Carolina Santos is érzékeli. De múltjának e kellemetlen mozzanata ellenére Lina olyan lehetőséget kap, amely megváltoztathatja az életét. Csak egyetlen bökkenő van: együtt kell működnie a világ legrosszabb esküvői tanújával a saját kudarcba fulladt menyegzőjéről.
            Max Hartley marketingszakértő eltökélt szándéka, hogy letegye a névjegyét egy áhított szállodai ügyfélnél, aki az arculata kiterjesztését tervezi. Aztán megtudja, hogy a bátyja eszes, lenyűgöző és abszolút tabu exmenyasszonyával kell dolgoznia, aki ráadásul ki nem állhatja őt...
            Ha sikerül egymás kinyírása nélkül összehozniuk a prezentációjukat, mindketten jól járnak. Csakhogy Max az első számú közellenség, mióta arra biztatta a bátyját, hogy hagyja faképnél a menyasszonyt, és Lina a maga részéről kész megfizetni érte.
            Lina és Max hamar felfedezik, hogy nem az ellenszenv az egyetlen érzelem, amitől szikrázik közöttük a levegő. Ám ez a rossz csillagzat alatt született páros mégsem lehet több ideiglenes játszópajtásnál, mert Lina nem vágyik szerelemre, Max pedig soha többé nem hajlandó a bátyja mellett másodhegedűst alakítani...";
            $b6->genre = "romantikus";
            $b6->language = "magyar";
            $b6->publisher = "Kossuth Kiadó";
            $b6->writers = "Mia Sosa";
            $b6->cover = "images/book_covers/9789635449828.jpg";
            $b6->publish_date = 2020;
            $b6->number_of_pages = 0;
            $b6->save();

            $b7 = new Book();
            $b7->isbn = 9789635619801;
            $b7->title = "Vérből és hamuból";
            $b7->description = "Egy új korszak hajnalán, a születésekor kiválasztották Poppyt, ezért az élete sosem volt igazán a sajátja. A Szűz élete magányos. Sohasem érinthetik meg. Sohasem nézhetnek rá. Sohasem szólhatnak hozzá. Sohasem tapasztalhatja meg az élvezeteket. Ám ő Felemelkedésének napjára várva szívesebben tölti idejét a testőreivel, és inkább harcol a gonosszal, ami elvette tőle a családját, mint hogy arra készüljön, hogy az istenek méltónak találják. De ez a döntés sem volt sohasem az övé.

            EGY KÖTELESSÉG...
            
            Az egész királyság jövőjének terhe Poppy vállát nyomja, és ez olyasvalami, amire egyáltalán nem biztos, hogy vágyik. Hiszen egy Szűznek is van szíve. És lelke. És vágyai. És amikor Hawke, az arany szemű őr felesküszik rá, hogy biztosítja a Felemelkedését, így belép az életébe, a végzet és a kötelesség összekuszálódik a sóvárgással. Hawke felkorbácsolja a lány indulatait, elülteti benne a kételyt azzal szemben, amiben eddig hitt, és megkísérti azzal, ami tilos.
            
            EGY KIRÁLYSÁG...
            
            Egy bukott királyság, amit magára hagytak az istenek, és amitől rettegnek a halandók, ismét feltámad, hogy erőszakkal és bosszúval mindenáron visszaszerezze, ami egykor az övé volt. És ahogy az átkozottak árnyéka egyre közelebb húzódik, a tiltott és a helyes közötti határvonal is elmosódik. Poppy nem csupán a szívét kockáztatja, hanem azt is, hogy méltatlannak találják az istenek, ráadásul az élete is veszélybe kerül, amikor minden véres fenyegetés, ami egyben tartja a világát, kezdi felfedni magát.";
            $b7->genre = "fantasy";
            $b7->language = "magyar";
            $b7->publisher = "Könyvmoly képző";
            $b7->writers = "Jennifer L. Armentrout";
            $b7->cover = "images/book_covers/9789635619801.jpg";
            $b7->publish_date = 2020;
            $b7->number_of_pages = 0;
            $b7->save();

            $b8 = new Book();
            $b8->isbn = 9789635043460;
            $b8->title = "A kívülálló";
            $b8->description = "A Mr. Mercedes - Aki kapja, marja - Agykontroll trilógia után Stephen King - vagy ahogy rajongói világszerte emlegetik: a Mester - ismét egy hátborzongató thrillerrel hozza rá olvasóira az álmatlanságot. Az oklahomai kisváros, Flint City egyik parkjában brutálisan megerőszakolt, meggyilkolt és megcsonkított holttestre bukkannak. Az áldozat Frank Peterson, egy fehér fiúgyermek, életkora 11 év. A felfoghatatlan tett elkövetője pedig szemtanúk állítása és több, cáfolhatatlan bizonyíték szerint Terry Maitland gimnáziumi irodalomtanár és baseballedző, azaz T. edző, egy mindenki által ismert, köztiszteletben álló ember, két kislány édesapja.Ralph Anderson nyomozó letartóztatja az edzőt, méghozzá a lehető legmegalázóbb módon: a Maitland csapata számára kulcsfontosságú meccs közben, a szurkolósereg szeme láttára. Anderson indulata érthető: az ő kamasz fia is T. edző keze alatt tanulta a sportot. Az igazságszolgáltatás folyamatában azonban fennakadást okoz, hogy Maitlandnek kikezdhetetlen alibije van: szemtanúk, ujjlenyomatok, sőt DNS-minta igazolják, hogy a gyilkosság idején egy másik, távoli városban tartózkodott. Anderson nyomozónak segítőtársaival együtt választ kell találniuk a kérdésre: hogyan lehet ugyanaz az ember egyszerre két helyen? A rejtély megoldása Kinghez méltóan egyszerre hihetetlen és kétségbevonhatatlan, bármennyire sokkolja is azokat, akik egy texasi barlang mélyén végül szembekerülnek vele. A kívülálló amellett, hogy a New York Times bestsellerlistájának élére került, a Goodreads-en 2018-ban kategóriájának legjobb könyve lett, és az HBO minisorozatot készít belőle.";
            $b8->genre = "horror";
            $b8->language = "magyar";
            $b8->writers = "Stephen King";
            $b8->publisher = "Európa Kiadó";
            $b8->cover = "images/book_covers/9789635043460.jpg";
            $b8->publish_date = 2018;
            $b8->number_of_pages = 0;
            $b8->save();
        }
    }
}
