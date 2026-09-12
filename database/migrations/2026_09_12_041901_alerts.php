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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('device_id')
            //     ->constrained()
            //     ->cascadeOnDelete();

            $table->foreignId('sensor_reading_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('gas_value', 10, 2);
            $table->decimal('threshold_value', 10, 2);

            $table->enum('severity', [
                'warning',
                'critical'
            ]);

            $table->enum('status', [
                'active',
                'resolved'
            ])->default('active');

            $table->timestamp('triggered_at');
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
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
