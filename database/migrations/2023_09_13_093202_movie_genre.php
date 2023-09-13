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
        Schema::create('movie_genre', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('genre_id')->unsigned()->index();
            $table->bigInteger('movie_id')->unsigned()->index();
        });
        Schema::table('movie_genre', function (Blueprint $table) {
            $table->foreign('genre_id')->references('id')->on('genres');
        });
        Schema::table('movie_genre', function (Blueprint $table) {
            $table->foreign('movie_id')->references('id')->on('movies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
