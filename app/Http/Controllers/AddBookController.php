<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use Illuminate\Support\Facades\File;

use Purifier;
class AddBookController extends Controller
{
    public function index() {
        return view("add_book");
    }

    public function upload_book(Request $request) {
        $validated = Validator::make($request->all(), [
            "isbn" => "required|numeric",
            "publisher" => "required",
            "title" => "required",
            "publish" => "required|numeric",
            "description" => "required",
            "writers" => "required",
            "language" => "required",
            "number_of_pages" => "required|numeric",
            "cover" => "required|file|mimes:jpg|max: 5120" //5MB
        ], 
        [
            "isbn.required" => "ISBN szám megadása kötelező!",
            "isbn.numeric" => "Az ISBN csak számjegyekből állhat!",
            "publisher.required" => "A kiadónak a kitöltése kötelező!",
            "title.required" => "A cím kitöltése kötelező!",
            "publish.required" => "A kiadás dátumának a kitöltése kötelező!",
            "publish.numeric" => "A kiadás dátum csak szám lehet!",
            "description.required" => "A leírásnak a kitöltése kötelező!",
            "writers.required" => "A szerző(k) kitöltése kötelező!",
            "language.required" => "A nyelv kitöltése kötelező!",
            "number_of_pages.required" => "Az oldalak számát meg kell adni!",
            "number_of_pages.numeric" => "Csak számot lehet megadni"
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
        $w_isbn = preg_replace('/\s+/', '', $request->input("isbn"));
        $w_language = preg_replace('/\s+/', '', $request->input("language"));
        $w_number_of_pages = preg_replace('/\s+/', '', $request->input("number_of_pages"));

        /*XSS elleni védelem*/
        $cleaned_title = Purifier::clean($w_title);
        $cleaned_publish = Purifier::clean($w_publish);
        $cleaned_description = Purifier::clean($w_description);
        $cleaned_writers = Purifier::clean($w_writers);
        $cleaned_genre = Purifier::clean($w_genre);
        $cleaned_publisher = Purifier::clean($w_publisher);
        $cleaned_isbn = Purifier::clean($w_isbn);
        $cleaned_language = Purifier::clean($w_language);
        $cleaned_number_of_pages = Purifier::clean($w_number_of_pages);


        if($w_title == $cleaned_title &&
           $w_publish == $cleaned_publish &&
           $w_description == $cleaned_description &&
           $w_writers == $cleaned_writers &&
           $w_genre == $cleaned_genre &&
           $w_publisher == $cleaned_publisher &&
           $w_isbn == $cleaned_isbn &&
           $w_language == $cleaned_language &&
           $w_number_of_pages == $cleaned_number_of_pages) 
           {
                $cover = $request->file("cover");
                $cover_name = $request->input('isbn') . "." . $cover->getClientOriginalExtension();
                $res = DB::transaction(function() use($request, $cover_name) {
                    Book::create([
                          "isbn" => $request->input("isbn"),
                          "title" => $request->input("title"),
                          "description" => $request->input("description"),
                          "genre" => $request->input("genre"),
                          "language" => $request->input("language"),
                          "publisher" => $request->input("publisher"),
                          "writers" => $request->input("writers"),
                          "cover" => "images/book_covers/" . $cover_name,
                          "publish_date" => $request->input("publish"),
                          "number_of_pages" => $request->input("number_of_pages")
                    ]);
                    return true;
                });

                if($res) {
                    $path = $cover->move(public_path("images/book_covers"), $cover_name);

                    if($path) {
                        return response()->json(["msgType" => "success", "msg" => "Könyv hozzáadása sikeres!"], 200);
                    } 
                    
                    return response()->json(["msgType" => "cover_error", "msg" => "Hiba történt a borító feltöltése során!"], 200);
                } else {
                    return response()->json(["msgType" => "insert_error", "msg" => "Hiba történt a könyv hozzáadása során!"], 200);
                }

           }
        return response()->json(["msgType" => "not_known", "msg" => "Ismeretlen hiba történt!"], 200);
    }
}
