<?php

namespace App\Http\Controllers\Api;

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
        // 1. Validate incoming JSON payload
        $validated = $request->validate([
            'device_uid'  => 'required|string|exists:devices,uid',
            'gas_value'   => 'required|numeric',
            'temperature' => 'required|nullable',
            'humidity'    => 'required|nullable',
        ]);

        // 2. Find the device by its unique UID
        $device = Device::where('uid', $validated['device_uid'])->first();

        // 3. Store the reading in DB
        $reading = SensorData::create([
            'device_id'   => $device->id,
            'gas_value'   => $validated['gas_value'],
            'temperature' => $validated['temperature'],
            'humidity'    => $validated['humidity'],
            'recorded_at' => now(),
        ]);
        
        // Alert generate service
        $alert = $this->alertService->process($reading, $device);

        // // 4. Update the device's last_seen_at timestamp
        // $device->update(['last_seen_at' => now()]);

        // 5. Return success JSON response
        return response()->json([
            'status'  => 'success',
            'message' => 'Sensor reading stored successfully',
            // 'data'    => $reading,
            // 'alert'   => $alert
        ], 201);
    }
}
