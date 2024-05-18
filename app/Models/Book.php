<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "isbn",
        "title",
        "description",
        "genre",
        "language",
        "publisher",
        "writers",
        "cover",
        "publish_date",
        "number_of_pages"
    ];
}
