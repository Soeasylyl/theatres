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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('screening_id');
            $table->unsignedBigInteger('seat_id');
            $table->string('slug');
            $table->timestamps();

            $table->string('status')->default('free');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('screening_id')
                  ->references('id')
                  ->on('screenings');

            $table->foreign('seat_id')
                  ->references('id')
                  ->on('seats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
