<?php

namespace App\Http\Controllers\Api;

use App\Events\SensorReadingReceived;
use App\Models\SensorData;
use App\Models\Device;
use App\Services\AlertService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SensorReadingController extends Controller
{
    public function __construct(
        private AlertService $alertService
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_uid'  => 'required|string|exists:devices,uid',
            'gas_value'   => 'required|numeric',
            'temperature' => 'required|nullable|numeric',
            'humidity'    => 'required|nullable|numeric',
        ]);

        $device = Device::where('uid', $validated['device_uid'])->firstOrFail();

        $reading = SensorData::create([
            'device_id'   => $device->id,
            'gas_value'   => $validated['gas_value'],
            'temperature' => $validated['temperature'],
            'humidity'    => $validated['humidity'],
            'recorded_at' => now(),
        ]);

        // Process alerts based on this reading.
        $alert = $this->alertService->process($reading, $device);

        // Update the device's last-seen timestamp.
        // $device->update([
        //     'last_seen_at' => now(),
        // ]);

        // Broadcast the new reading through Laravel Reverb.
        SensorReadingReceived::dispatch([
            'device_id'   => $device->id,
            'device_uid'  => $device->uid,
            'gas_value'   => $reading->gas_value,
            'temperature' => $reading->temperature,
            'humidity'    => $reading->humidity,
            'recorded_at' => $reading->recorded_at->toISOString(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Sensor reading stored successfully',
        ], 201);
    }
}
