<?php

use App\Enums\StatusBookingsEnum;
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
            $table->unsignedBigInteger('screening_id')->nullable();
            $table->unsignedBigInteger('seat_id')->nullable();
            $table->string('slug')->unique();
            $table->string('status')->default(StatusBookingsEnum::ACTIVE->value);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            $table->foreign('screening_id')
                  ->references('id')
                  ->on('screenings')
                  ->nullOnDelete();

            $table->foreign('seat_id')
                  ->references('id')
                  ->on('seats')
                  ->nullOnDelete();
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
