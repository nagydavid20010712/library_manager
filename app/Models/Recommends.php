<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommends extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "isbn",
        "user_id"
    ];

}
