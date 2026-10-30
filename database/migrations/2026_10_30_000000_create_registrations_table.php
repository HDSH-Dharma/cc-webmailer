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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->string('full_name');
            $table->string('email')->index();
            $table->string('password');
            $table->date('birthdate');
            $table->string('event');
            $table->string('ticket_category');
            $table->unsignedTinyInteger('quantity');
            $table->unsignedInteger('total_price');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
