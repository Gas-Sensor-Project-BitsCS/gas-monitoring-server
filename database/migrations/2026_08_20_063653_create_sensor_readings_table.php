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
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id(); // bigint, primary key
            $table->foreignId('device_id')
                ->constrained('devices')
                ->restrictOnDelete();
            $table->decimal('gas_value',8,2);
            $table->decimal('temperature',6,2)->nullable();
            $table->decimal('humidity',6,2)->nullable();
            $table->timestamp('recorded_at')->useCurrent();
            $table->index(['device_id', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_readings');
    }
};
