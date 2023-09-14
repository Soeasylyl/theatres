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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->index();
            $table->timestamps();

            $table->enum('status', [
                'pending',
                'success',
                'declined'
            ])->default('pending');

            $table->foreign('booking_id')
                  ->references('id')
                  ->on('bookings');
        });

        DB::statement('ALTER TABLE payments ADD COLUMN amount money');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
