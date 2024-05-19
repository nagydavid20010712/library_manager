<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

use Purifier;

class ViewBookController extends Controller
{
    public function index($book_isbn) {

        $book = Book::where("isbn", $book_isbn)->first();

        return view("view_book", ["book" => $book]);
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
            "genre" => "required"
        ],
        [
            "title.required" => "A cím kitöltése kötelező!",
            "publish.required" => "A megjelenés évének a kitöltése kötelező!",
            "publish.numeric" => "Csak számot lehet megadni évnek!",
            "description.required" => "A leírás kitöltése kötelező!",
            "writers.required" => "A szerző(k) kitöltése kötelező!",
            "genre.required" => "Műfaj kitöltése kötelező!"
        ]);

        if($validated->fails()) {
            return response()->json(["msgType" => "form_error", "msg" => $validated->errors()], 200);
        }

        /*összes whitespace karakter eltávolítása*/
        $w_title = preg_replace('/\s+/', '', $request->input("title"));
        $w_publish = preg_replace('/\s+/', '', $request->input("publish"));
        $w_description = preg_replace('/\s+/', '', $request->input("description"));
        $w_writers = preg_replace('/\s+/', '', $request->input("writers"));
        $w_genre = preg_replace('/\s+/', '', $request->input("genre"));

        /*XSS elleni védelem*/
        $cleaned_title = Purifier::clean($w_title);
        $cleaned_publish = Purifier::clean($w_publish);
        $cleaned_description = Purifier::clean($w_description);
        $cleaned_writers = Purifier::clean($w_writers);
        $cleaned_genre = Purifier::clean($w_genre);
        
        Log::info($cleaned_genre);

        /**
         * ha nem történt tisztítás
         * akkor minden gond nélkül ellehet az eredetit tárolni
         */
        if ($w_title == $cleaned_title && 
           $w_publish == $cleaned_publish &&
           $w_description == $cleaned_description &&
           $w_writers == $cleaned_writers &&
           $w_genre == $cleaned_genre) {
            
            $res = DB::transaction(function() use($request, $cleaned_description, $cleaned_genre, $cleaned_publish, $cleaned_title, $cleaned_writers) {
                Book::where("isbn", $request->input("isbn"))
                ->update(["title" => $request->input("title"), "description" => $request->input("description"), "publish_date" => $request->input("publish"), "writers" => $request->input("writers"), "genre" => $request->input("genre")]);
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
}
