<?php

use App\Enums\StatusPaymentsEnum;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->timestamps();
            $table->decimal('amount')->unsigned();

            $table->string('status')->default(StatusPaymentsEnum::PENDING_PAYMENT->value);

            $table->foreign('booking_id')
                  ->references('id')
                  ->on('bookings')
                  ->nullOnDelete();;
        });

        DB::statement('ALTER TABLE payments ALTER COLUMN amount TYPE money USING amount::money');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
