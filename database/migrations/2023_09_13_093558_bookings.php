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
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('screening_id')->unsigned()->index();
            $table->bigInteger('seat_id')->unsigned()->index();
            $table->text('status');
            $table->timestamps();

        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('screening_id')->references('id')->on('screenings');
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('seat_id')->references('id')->on('seats');
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
