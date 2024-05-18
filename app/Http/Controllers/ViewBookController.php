<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Log;

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
}
