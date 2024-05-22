<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

use Illuminate\Support\Facades\Cache;

class ListBooksController extends Controller
{
    public function index(Request $request) {
        if(!$request->input("value")) {
            $books = Book::get()->toArray();
            return view("list_books", ["books" => $books]);
        }

        $filtered = Book::where($request->input("filter"), "LIKE", "%" . $request->input("value") . "%")->get()->toArray();


        return view("list_books", ["books" => $filtered]);
    }
}
