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

        if($series != null) {
            $books_in_series = BookInSeries::join("books", "books.isbn", "=", "book_in_series.isbn")
                                           ->select("books.isbn", "books.title", "books.cover")
                                           ->where("book_in_series.isbn", "!=", $book_isbn)
                                           ->where("book_in_series.series_id", "=", $series->series_id)
                                           ->get();

            if($books_in_series != null) {
                return view("view_book", ["book" => $book, "series" => $books_in_series, "series_name" => $series, "supported_languages" => $supported_languages->json(), "same" => $same_books]);
            } 

            return view("view_book", ["book" => $book, "series" => null, "series_name" => $series, "supported_languages" => $supported_languages->json(), "same" => $same_books]);
        }

        return view("view_book", ["book" => $book, "series" => null, "series_name" => null, "supported_languages" => $supported_languages->json(), "same" => $same_books]);
    }

    public function delete_book($book_isbn) {
        $res = Book::where("isbn", $book_isbn)->delete();

        if($res) return response()->json(["success" => true]);

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
         * akkor minden gond nélkül ellehet az eredetit tárolni
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
                /*
                $cover = $request->file("cover");
                $cover_name = $request->input('isbn') . "." . $cover->getClientOriginalExtension();
                
                File::delete(public_path("images/book_covers/" . $request->input('isbn') . ".jpg"));
                //$path = $cover->storeAs("images/book_covers", $cover_name);
                $path = $cover->move(public_path("images/book_covers"), $cover_name);
                //Log::info($path);

                Book::where("isbn", $request->input('isbn'))->update(["cover" => "images/book_covers/" . $cover_name]);
                
                if($path) {
                    return response()->json(["msgType" => "success", "msg" => "Könyv adatai sikeresen frissítve!", "updated_data" => Book::where("isbn", $request->input("isbn"))->first()], 200);
                } else {
                    return response()->json(["msgType" => "cover_error", "msg" => "Hiba történt a kép feltöltése közbe! A könyv adatai frissítve.", "updated_data" => Book::where("isbn", $request->input("isbn"))->first()], 200);
                }
                */
                return response()->json(["msgType" => "success", "msg" => "Könyv adatai sikeresen frissítve!", "updated_data" => Book::where("isbn", $request->input("isbn"))->first()], 200);
            } else {
                return response()->json(["msgType" => "update_err", "msg" => "Hiba történt az adatok frissítése során"], 200);
            }
        }

        return response()->json(["msgType" => "not_known", "msg" => "Ismeretlen hiba történt!"], 200);
    }

    public function translate(Request $request) {
        $book = Book::where("isbn", $request->input("isbn"))->first();

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

        Log::info($translated_description);
        return response()->json(["translation" => "success", "translated_title" => $translated_title->json(), "translated_description" => $translated_description->json()], 200);
    }


}
