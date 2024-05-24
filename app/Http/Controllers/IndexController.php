<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use App\Models\Recommends;

class IndexController extends Controller
{
    public function index() {

        $recommends = Recommends::join("users", "users.id", "=", "recommends.user_id")
                                ->join("books", "books.isbn", "=", "recommends.isbn")
                                ->select("books.isbn", "users.lname", "users.fname", "books.title", "books.writers", "books.cover")
                                ->get()
                                ->toArray();

        //return response()->json(["recommends" => $recommends], 200);
        return view("index", ["recommends" => $recommends]);
    }
}
