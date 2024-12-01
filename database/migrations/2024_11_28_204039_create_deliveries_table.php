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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('consumer_id')->constrained('consumers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('bapb_number')->nullable();
            $table->date('departure_date');
            $table->date('arrival_date')->nullable();
            $table->enum('status', ['pending', 'verified', 'prefer','delivered', 'success'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
