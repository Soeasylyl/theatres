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
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cinema_id')->index();
            $table->string('name');
            $table->string('description', 1000);
            $table->timestamps();

            $table->foreign('cinema_id')
                  ->references('id')
                  ->on('cinemas');
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
