<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ViewBookController;
use App\Http\Controllers\ListBooksController;
use App\Http\Controllers\AddBookController;

Route::get('/', [IndexController::class, "index"]);


Route::get("/view_book/{book_isbn}", [ViewBookController::class, "index"]);
Route::get("/view_book", function() {
    return redirect("/");
});
Route::delete("/delete_book/{book_isbn}", [ViewBookController::class, "delete_book"]);
Route::post("/update_book", [ViewBookController::class, "update_book"]);
Route::post("/translate", [ViewBookController::class, "translate"]);

Route::get("/list_books", [ListBooksController::class, "index"]);

Route::get("/add_book", [AddBookController::class, "index"]);
Route::post("/upload_book", [AddBookController::class, "upload_book"]);