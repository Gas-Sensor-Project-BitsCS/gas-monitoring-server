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
            $table->char('uid', 36)->unique(); // UUID or unique identifier
            $table->string('name', 100); // Device Name
            $table->string('location', 100)->nullable(); // Device Loaction
            $table->decimal('gas_threshold', 8, 2); // gas Threshold 
            $table->decimal('temperature_threshold', 6, 2); // temp Threshold
            $table->decimal('humidity_threshold', 6, 2); // humidity Threshold
            $table->decimal('gas_mod_threshold', 8, 2); // gas Moderate Threshold
            $table->decimal('temperature_mod_threshold', 6, 2); // temp Moderate Threshold
            $table->decimal('humidity_mod_threshold', 6, 2); // humidity Moderate Threshold
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            //$table->index('last_seen_at');
            // $table->index('name');

            //$table->timestamps(); // created_at & updated_at
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
