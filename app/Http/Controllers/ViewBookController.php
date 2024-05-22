<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookInSeries;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use Purifier;

class ViewBookController extends Controller
{
    public function index($book_isbn) {
       
        //Log::info(Cache::store("memcached")->get("anyad"));
        $book = Book::where("isbn", $book_isbn)->first();
        $same_books = Book::select("isbn", "title", "writers", "cover")->where("genre", "like", "%" . $book->genre . "%")->where("isbn", "!=", $book_isbn)->take(4)->get();
        $series = BookInSeries::join("series", "series.id", "=", "book_in_series.series_id")->select("series_id", "name")->where("isbn", $book_isbn)->first();
        
        $supported_languages = Http::get("https://api-free.deepl.com/v2/languages", [
            "auth_key" => env("DEEPL_API_KEY")
        ]);
        
        if(!Cache::store("memcached")->has("book:" . $book_isbn)) {
            /*ha még nem volt a könyv megnyitva akkor hozzáadjuk a cache-hez*/
            //$book = Book::where("isbn", $book_isbn)->first();

         
            
            /*ha nem tartozik a könyhöz széria akkor elég visszatéri*/
            if($series == null) {
                /*ez csak azért fontos mert a könyvekhez hozzá van adva a széria azonosítója*/
                Cache::store("memcached")->put("book:" . $book_isbn, ["book" => $book, "series" => -1], now()->addHour());
                return view("view_book", ["book" => Cache::store("memcached")->get("book:" . $book_isbn), "series" => null, "series_name" => null, "supported_languages" => $supported_languages->json(), "same" => $same_books]);
            }

            Cache::store("memcached")->put("book:" . $book_isbn, ["book" => $book, "series" => "series:" . $series->series_id], now()->addHour());
            //Log::info($series->series_id);
        }

        /*könyv nem tartozik szériába*/
        if(Cache::store("memcached")->get("book:" . $book_isbn)["series"] == -1) {
            return view("view_book", ["book" => Cache::store("memcached")->get("book:" . $book_isbn), "series" => null, "series_name" => null, "supported_languages" => $supported_languages->json(), "same" => $same_books]);
        }

         /*nézzük meg a szériát, hogy van e cachelve*/
        if(!Cache::store("memcached")->has("series:" . $series->series_id)) {
            /*ha még a széria nem volt cachelve akkor beletesszük*/
            /*elsőnek le kell kérni a szériába tartozó könyveket és a széria adatait*/

            //$series = BookInSeries::join("series", "series.id", "=", "book_in_series.series_id")->select("series_id", "name")->where("isbn", $book_isbn)->first();
            $books_in_series = BookInSeries::join("books", "books.isbn", "=", "book_in_series.isbn")
                                            ->select("books.isbn")
                                            ->where("book_in_series.series_id", "=", $series->series_id)
                                            ->get();
                    
            /*kezdjük el bejárni az egy szériába tartozó könyveket*/
            $isbn_arr = [];
            foreach($books_in_series as $bis) {
                $isbn_arr[] = $bis["isbn"];
                    
            }
            
            /*állítsuk össze a széria adatszerkezetet*/
            $s = [
                "name" => $series->name,
                "books" => $isbn_arr
            ];

            //Log::info($s);

            /*mentsük el*/
            Cache::store("memcached")->put("series:" . $series->series_id, $s, now()->addHour());
        }

        /*ha még nem is volt cachelve a széria akkor még ezelött megcsináltuk*/
        /*most már csak vissza kell adni az adatokat*/

        /*1. vegyük ki a nekünk kellő könyvet*/
        $b = Cache::store("memcached")->get("book:" . $book_isbn);

        /*2. vegyük ki a nekünk kellő szériát*/
        $s = Cache::store("memcached")->get($b["series"]);

        /*állítsuk össze a visszaadandó szériába tartozó könyvek adatszerkezetét*/
        $bis = [];
        foreach($s["books"] as $isbn) {
            /*hogy saját maga ne jelenjen meg a szériák között*/
            if($isbn != $book_isbn) {
                if(!Cache::store("memcached")->has("book:" . $isbn)) {
                     /*ha még a cache-ben véletlenül az egyik rész nincs benne akkor beletesszük*/
                    Cache::store("memcached")->put("book:" . $isbn, ["book" => Book::where("isbn", $isbn)->first(), "series" => $b["series"]], now()->addHour());
                }
                $bis[] = Cache::get("book:" . $isbn);
            }
        }

        /*return response()->json([
            "book" => Cache::store("memcached")->get("book:" . $book_isbn),
            "series" => $bis,
            "series_name" => $s["name"],
            "supported_language" => $supported_languages,
            "same" => $same_books
        ], 200);*/

        return view("view_book", [
            "book" => Cache::store("memcached")->get("book:" . $book_isbn),
            "series" => $bis,
            "series_name" => $s["name"],
            "supported_languages" => $supported_languages->json(),
            "same" => $same_books
        ]);

        /*
        $same_books = Book::select("isbn", "title", "writers", "cover")->where("genre", "like", "%" . $book->genre . "%")->where("isbn", "!=", $book_isbn)->take(4)->get();
        $series = BookInSeries::join("series", "series.id", "=", "book_in_series.series_id")->select("series_id", "name")->where("isbn", $book_isbn)->first(); 

        $supported_languages = Http::get("https://api-free.deepl.com/v2/languages", [
            "auth_key" => env("DEEPL_API_KEY")
        ]);

        if($series != null) {
            $books_in_series = BookInSeries::join("books", "books.isbn", "=", "book_in_series.isbn")
                                           ->select("books.isbn", "books.title", "books.cover")
                                           ->where("book_in_series.isbn", "!=", $book_isbn)
                                           ->where("book_in_series.series_id", "=", $series->series_id)
                                           ->get();

            //Log::info($books_in_series);

            if($books_in_series != null) {
                return view("view_book", ["book" => $book, "series" => $books_in_series, "series_name" => $series, "supported_languages" => $supported_languages->json(), "same" => $same_books]);
            } 

            return view("view_book", ["book" => $book, "series" => null, "series_name" => $series, "supported_languages" => $supported_languages->json(), "same" => $same_books]);
        }

        return view("view_book", ["book" => $book, "series" => null, "series_name" => null, "supported_languages" => $supported_languages->json(), "same" => $same_books]);*/
    }

    public function delete_book($book_isbn) {
        $cover = Book::where("isbn", $book_isbn)->select("cover")->first();
        $res = Book::where("isbn", $book_isbn)->delete();
        
        if($res) {
            $s_key = Cache::store("memcached")->get("book:" . $book_isbn)["series"];
            
            /*töröljük ki a cache-ből*/            
            Cache::store("memcached")->forget("book:" . $book_isbn);

            /*ha a könyv egy szériába tartozik akkor a szériából is ki kell törölni*/
            if($s_key != -1) {
                $series = Cache::store("memcached")->get($s_key);
                /*for($i = 0; $i < count($series["books"]); $i++) {
                    if($series["books"][$i] == $book_isbn) {
                        unset($series["books"][$i]);
                    }
                }*/

                $index = array_search($book_isbn, $series["books"]);
                unset($series["books"][$index]);

                /*ha a széria összes könyvét kitöröltük akkor a szériát is kitörötljük a cache-ből különben frissítjük*/
                if(count($series["books"][$index]) == 0) {
                    Cache::store("memcached")->forget($s_key);
                } else {
                    Cache::store("memcached")->put($s_key, $series, now()->addHour());
                }
            }

            /*kitöröljük a könyv borítóját is*/
            //Storage::delete(public_path($cover->cover));
            unlink(public_path($cover->cover));
            return response()->json(["success" => true]);
        }

        return response()->json(["err" => "Valami hiba történt a könyv törlése közben..."]);
    }

    public function update_book(Request $request) {

        $validated = Validator::make($request->all(),[
            "title" => "required",
            "publish" => "required|numeric",
            "description" => "required",
            "writers" => "required",
            "genre" => "required",
            "publisher" => "required",
            "language" => "required",
            "number_of_pages" => "required|numeric"
        ],
        [
            "title.required" => "A cím kitöltése kötelező!",
            "publish.required" => "A megjelenés évének a kitöltése kötelező!",
            "publish.numeric" => "Csak számot lehet megadni évnek!",
            "description.required" => "A leírás kitöltése kötelező!",
            "writers.required" => "A szerző(k) kitöltése kötelező!",
            "genre.required" => "Műfaj kitöltése kötelező!",
            "publisher.required" => "Kiadó kitöltése kötelező!",
            "language.required" => "Nyelv kitöltése kötelező!",
            "number_of_pages.required" => "Oldalak számának megadása kötelező!",
            "number_of_pages.numeric" => "Az oldalak száma csak szám lehet!"
        ]);

        if($validated->fails()) {
            return response()->json(["msgType" => "form_error", "errors" => $validated->errors()], 200);
        }

        /*összes whitespace karakter eltávolítása*/
        $w_title = preg_replace('/\s+/', '', $request->input("title"));
        $w_publish = preg_replace('/\s+/', '', $request->input("publish"));
        $w_description = preg_replace('/\s+/', '', $request->input("description"));
        $w_writers = preg_replace('/\s+/', '', $request->input("writers"));
        $w_genre = preg_replace('/\s+/', '', $request->input("genre"));
        $w_publisher = preg_replace('/\s+/', '', $request->input("publisher"));
        $w_language = preg_replace('/\s+/', '', $request->input("language"));
        $w_number_of_pages = preg_replace('/\s+/', '', $request->input("number_of_pages"));

        /*XSS elleni védelem*/
        $cleaned_title = Purifier::clean($w_title);
        $cleaned_publish = Purifier::clean($w_publish);
        $cleaned_description = Purifier::clean($w_description);
        $cleaned_writers = Purifier::clean($w_writers);
        $cleaned_genre = Purifier::clean($w_genre);
        $cleaned_publisher = Purifier::clean($w_publisher);
        $cleaned_language = Purifier::clean($w_language);
        $cleaned_number_of_pages = Purifier::clean($w_number_of_pages);

        //Log::info($cleaned_genre);

        /**
         * ha nem történt tisztítás
         * akkor minden gond nélkül el lehet az eredetit tárolni
         */
        if ( $w_title == $cleaned_title && 
           $w_publish == $cleaned_publish &&
           $w_description == $cleaned_description &&
           $w_writers == $cleaned_writers &&
           $w_genre == $cleaned_genre && 
           $w_publisher == $cleaned_publisher &&
           $w_language == $cleaned_language &&
           $w_number_of_pages == $cleaned_number_of_pages ) {
            
            $res = DB::transaction(function() use($request) {
                Book::where("isbn", $request->input("isbn"))
                ->update(["title" => $request->input("title"), 
                          "description" => $request->input("description"), 
                          "publish_date" => $request->input("publish"), 
                          "writers" => $request->input("writers"), 
                          "genre" => $request->input("genre"),
                          "publisher" => $request->input("publisher"),
                          "language" => $request->input("language"),
                          "number_of_pages" => $request->input("number_of_pages")]);

                return true;
            });
        
            if($res) {
                return response()->json(["msgType" => "success", "msg" => "Könyv adatai sikeresen frissítve!", "updated_data" => Book::where("isbn", $request->input("isbn"))->first()], 200);
            } else {
                return response()->json(["msgType" => "update_err", "msg" => "Hiba történt az adatok frissítése során"], 200);
            }
        }

        return response()->json(["msgType" => "not_known", "msg" => "Ismeretlen hiba történt!"], 200);
    }

    public function translate(Request $request) {
        //$book = Book::where("isbn", $request->input("isbn"))->first();

        $book = Cache::store("memcached")->get("book:" . $request->input("isbn"))["book"];

        /*cím*/
        $translated_title = Http::get("https://api-free.deepl.com/v2/translate", [
            "auth_key" => env("DEEPL_API_KEY"),
            "text" => $book->title,
            "target_lang" => $request->input("target_lang")
        ]);

        /*leírás*/
        $translated_description = Http::get("https://api-free.deepl.com/v2/translate", [
            "auth_key" => env("DEEPL_API_KEY"),
            "text" => $book->description,
            "target_lang" => $request->input("target_lang")
        ]);
        
        if(!$translated_title->successful() || !$translated_description->successful()) {
            return response()->json(["translation" => "failed", "msg" => "Hiba történt a fordítás során!"], 200);
        }

        //Log::info($translated_description);
        return response()->json(["translation" => "success", "translated_title" => $translated_title->json(), "translated_description" => $translated_description->json()], 200);
    }


}
