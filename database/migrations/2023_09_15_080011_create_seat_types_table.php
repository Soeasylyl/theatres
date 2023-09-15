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
        Schema::create('seat_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cinema_id');
            $table->double('amount');
            $table->timestamps();

            $table->foreign('cinema_id')
                ->references('id')
                ->on('cinemas');
        });

        DB::statement('ALTER TABLE seat_types ALTER COLUMN amount TYPE money USING amount::text::money');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_types');
    }
};
