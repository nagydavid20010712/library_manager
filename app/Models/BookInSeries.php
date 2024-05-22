<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookInSeries extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "isbn",
        "series_id"
    ];
}
