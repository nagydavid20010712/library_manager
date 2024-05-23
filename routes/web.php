<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ViewBookController;
use App\Http\Controllers\ListBooksController;
use App\Http\Controllers\AddBookController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Middleware\CheckAuth;

Route::get('/', [IndexController::class, "index"]);


Route::get("/view_book/{book_isbn}", [ViewBookController::class, "index"]);
Route::get("/view_book", function() {
    return redirect("/list_books");
});
Route::delete("/delete_book/{book_isbn}", [ViewBookController::class, "delete_book"])->middleWare(ChechAuth::class);
Route::post("/update_book", [ViewBookController::class, "update_book"])->middleWare(CheckAuth::class);
Route::post("/translate", [ViewBookController::class, "translate"]);
Route::post("/recommend", [ViewBookController::class, "recommend"])->middleWare(CheckAuth::class);

Route::get("/list_books", [ListBooksController::class, "index"]);
//Route::get("/list_books/{filter}{value}", [ListBooksController::class, "filter"]);

Route::get("/add_book", [AddBookController::class, "index"])->middleWare(CheckAuth::class);
Route::post("/upload_book", [AddBookController::class, "upload_book"])->middleWare(CheckAuth::class);

Route::get("/log_reg", [LoginRegisterController::class, "index"]);
Route::post("/login", [LoginRegisterController::class, "login"]);
Route::post("/registration", [LoginRegisterController::class, "registration"]);

Route::get("/logout", function() {
    Auth::logout();
    return redirect("/");
});