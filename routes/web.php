<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ViewBookController;
use App\Http\Controllers\ListBooksController;

Route::get('/', [IndexController::class, "index"]);


Route::get("/view_book/{book_isbn}", [ViewBookController::class, "index"]);
Route::get("/view_book", function() {
    return redirect("/");
});
Route::delete("/delete_book/{book_isbn}", [ViewBookController::class, "delete_book"]);

Route::get("/list_books", [ListBooksController::class, "index"]);