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
            $table->bigInteger('seat_type_id')->unsigned()->index();
            $table->bigInteger('hall_id')->unsigned()->index();
            $table->text('status');
            $table->integer('amount');
            $table->timestamps();
        });

        Schema::table('seats', function (Blueprint $table) {
            $table->foreign('seat_type_id')->references('id')->on('seat_types');
        });
        Schema::table('seats', function (Blueprint $table) {
            $table->foreign('hall_id')->references('id')->on('halls');
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
