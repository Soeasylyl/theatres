<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->unsignedBigInteger('movie_id')->index();
            $table->unsignedBigInteger('hall_id')->index();

            $table->foreign('movie_id')
                  ->references('id')
                  ->on('movies');

            $table->foreign('hall_id')
                  ->references('id')
                  ->on('halls');
        });

        DB::statement('ALTER TABLE screenings ADD COLUMN price money');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
