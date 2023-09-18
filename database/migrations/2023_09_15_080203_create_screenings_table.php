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
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('hall_id');
            $table->decimal('price')->unsigned();

            $table->foreign('movie_id')
                  ->references('id')
                  ->on('movies');

            $table->foreign('hall_id')
                  ->references('id')
                  ->on('halls');
        });

        DB::statement('ALTER TABLE screenings ALTER COLUMN price TYPE money USING price::money');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screenings');
    }
};
