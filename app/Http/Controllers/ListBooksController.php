<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

use Illuminate\Support\Facades\Cache;

class ListBooksController extends Controller
{
    public function index() {

        

        $books = Book::get()->toArray();

        return view("list_books", ["books" => $books]);
    }
}
