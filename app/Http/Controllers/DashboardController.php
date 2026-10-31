<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class DashboardController extends Controller
{
    public function latestSensorData(Request $request)
    {
        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:devices,id'],
        ]);

        $reading = SensorData::where('device_id', $validated['device_id'])
            ->latest('recorded_at')
            ->first();

        return response()->json($reading);
    }
    // public function index(Request $request){
    //     // $readings = $this->latestSensorData();
    //     return view("dashboard",compact("readings"));
    // }
}
