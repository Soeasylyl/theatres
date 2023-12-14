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
            $table->unsignedBigInteger('theatre_id');
            $table->string('name');
            $table->text('description');
            $table->decimal('amount')->unsigned();
            $table->timestamps();

            $table->foreign('theatre_id')
                  ->references('id')
                  ->on('theatres')
                  ->cascadeOnDelete();
        });

        DB::statement('ALTER TABLE seat_types ALTER COLUMN amount TYPE money USING amount::money');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_types');
    }
};
