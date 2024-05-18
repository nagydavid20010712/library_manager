<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->string("isbn", length: 200)->primary();
            $table->text("title");
            $table->text("description");
            $table->text("genre");
            $table->text("language");
            $table->text("publisher");
            $table->text("writers");
            $table->text("cover");
            $table->integer("publish_date");
            $table->integer("number_of_pages");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
