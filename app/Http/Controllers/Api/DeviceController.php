<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function show(Device $device)
    {
        return response()->json([
            'status' => 'success',
            'device' => $device,
        ]);
    }

    /*
        Update threshold 
    */
    public function updateThresholds(
        Request $request,
        Device $device
    ) {
        $validated = $request->validate([
            'gas_threshold' => [
                'required',
                'numeric',
                'min:0',
            ],

            'temperature_threshold' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'humidity_threshold' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'gas_mod_threshold' => [
                'required',
                'numeric',
                'min:0',
            ],

            'temperature_mod_threshold' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'humidity_mod_threshold' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
        ]);

        $device->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Device thresholds updated successfully',
            'data' => [
                'device_id' => $device->id,
                'device_uid' => $device->device_uid,
                'gas_threshold' => $device->gas_threshold,
                'temperature_threshold' =>
                    $device->temperature_threshold,
                'humidity_threshold' =>
                    $device->humidity_threshold,
            ],
        ]);
    }
}
