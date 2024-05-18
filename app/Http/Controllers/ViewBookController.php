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
            "genre" => "required",
            "cover" => "required|file|mimes:jpg|max:5120" //5MB korlát
        ],
        [
            "title.required" => "A cím kitöltése kötelező!",
            "publish.required" => "A megjelenés évének a kitöltése kötelező!",
            "publish.numeric" => "Csak számot lehet megadni évnek!",
            "description.required" => "A leírás kitöltése kötelező!",
            "writers.required" => "A szerző(k) kitöltése kötelező!",
            "genre.required" => "Műfaj kitöltése kötelező!",
            "cover.required" => "Borítókép feltöltése kötelező!",
            "cover.files" => "Borítókép feltöltése kötelező!",
            "cover.mimes" => "Csak .jpg-t lehet feltölteni!",
            "cover.max" => "Maximum 5MB méretű képet leeht feltölteni!"
        ]);

        if($validated->fails()) {
            return response()->json(["msgType" => "form_error", "msg" => $validated->errors()], 200);
        }

        $cleaned_title = Purifier::clean($request->input("title"));
        $cleaned_publish = Purifier::clean($request->input("publish"));
        $cleaned_description = Purifier::clean($request->input("description"));
        $cleaned_writers = Purifier::clean($request->input("writers"));
        $cleaned_genre = Purifier::clean($request->input("genre"));
        
        Log::info($cleaned_description);

        if($request->input("title") === $cleaned_title && 
           $request->input("publish") === $cleaned_publish &&
           $request->input("description") === $cleaned_description &&
           $request->input("writers") === $cleaned_writers &&
           $request->input("genre") === $cleaned_genre) {

            $res = DB::transaction(function() use($request, $cleaned_description, $cleaned_genre, $cleaned_publish, $cleaned_title, $cleaned_writers) {
                Book::where("isbn", $request->input("isbn"))
                ->update(["title" => $cleaned_title, "description" => $cleaned_description, "publish_date" => $cleaned_publish, "writers" => $cleaned_writers, "genre" => $cleaned_genre]);
                return true;
            });
        
            if($res) {
                $cover = $request->file("cover");
                $cover_name = $request->input('isbn') . "." . $cover->getClientOriginalExtension();
                
                //File::delete("images/book_covers/" . $request->input('isbn') . ".jpg");
                //$path = $cover->storeAs("images/book_covers", $cover_name);
                //$path = $cover->move(public_path("images/book_covers"), $cover_name);
                //Log::info($path);

                Image::make($cover)->encode("jpg", 100)
                    ->save(public_path("images/book_covers/" . $cover_name));

                
                return response()->json(["msgType" => "success", "msg" => "Könyv adatai sikeresen frissítve!", "updated_data" => Book::where("isbn", $request->input("isbn"))->first()], 200);

                /*if($path) {
                    return response()->json(["msgType" => "success", "msg" => "Könyv adatai sikeresen frissítve!", "updated_data" => Book::where("isbn", $request->input("isbn"))->first()], 200);
                } else {
                    return response()->json(["msgType" => "cover_error", "msg" => "Hiba történt a kép feltöltése közbe! A könyv adatai frissítve.", "updated_data" => Book::where("isbn", $request->input("isbn"))->first()], 200);
                }*/

            } else {
                return response()->json(["msgType" => "update_err", "msg" => "Hiba történt az adatok frissítése során"], 200);
            }
        }

        return response()->json(["msgType" => "not_known", "msg" => "Ismeretlen hiba történt!"], 200);
    }
}
