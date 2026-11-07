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
        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key
            $table->string('type', 50); // e.g., 'ESP32', 'Arduino', 'Device'
            $table->string('uid', 50)->unique(); // Human-readable UID e.g., 'ESP32-1'
            $table->string('name', 100); // Device Name
            $table->string('location', 100)->nullable(); // Device Loaction
            $table->decimal('gas_threshold', 8, 2)->nullable(); // gas Threshold 
            $table->decimal('temperature_threshold', 6, 2)->nullable(); // temp Threshold
            $table->decimal('humidity_threshold', 6, 2)->nullable(); // humidity Threshold
            $table->decimal('gas_mod_threshold', 8, 2)->nullable(); // gas Moderate Threshold
            $table->decimal('temperature_mod_threshold', 6, 2)->nullable(); // temp Moderate Threshold
            $table->decimal('humidity_mod_threshold', 6, 2)->nullable(); // humidity Moderate Threshold
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

        });
        
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
