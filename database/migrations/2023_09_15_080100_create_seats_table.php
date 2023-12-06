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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seat_type_id');
            $table->unsignedBigInteger('hall_id');
            $table->integer('row');
            $table->integer('number');
            $table->float('position_x');
            $table->float('position_y');

            $table->timestamps();

            $table->foreign('seat_type_id')
                  ->references('id')
                  ->on('seat_types')
                  ->nullOnDelete();

            $table->foreign('hall_id')
                  ->references('id')
                  ->on('halls')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
