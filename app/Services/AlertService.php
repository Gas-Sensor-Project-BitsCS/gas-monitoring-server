<?php

namespace App\Services;

use App\Models\Alert;
use App\Models\Device;
use App\Models\SensorData;

class AlertService
{
    
    public function process(SensorData $reading, Device $device) : ?Alert
    {
        // Gas is above threshold
        if($reading->gas_value >= $device->gas_threshold){
            return $this->createOrUpdateAlert($reading, $device);
        }

        // Gas is back to safe level
        $this->resolveActiveAlerts($device);

        return null;
    }

    public function createOrUpdateAlert(SensorData $reading, Device $device):Alert
    {
        // Don't create duplicate active alerts
        $alert = Alert::where('device_id', $device->id)
                ->where('status', 'active')
                ->latest()
                ->first();
        
        if($alert){
            return $alert;
        }

        $severity = $this->calculateSeverity($reading->gas_value, $device->gas_threshold);

        return Alert::create([
            'device_id' => $device->id,
            'sensor_data_id' => $reading->id,
            'severity' => $severity,
            'status' => 'active',
            'triggered_at' => now()
        ]);
    }

    // public function alertTypes(SensorData $reading, Device $device): array
    // {
    //     $types = [];
    //     if($reading->gas_value >= $device->gas_threshold) $types[] = 'gas';
    //     if($reading->temperature >= $device->temperature_threshold) $types[] = 'temperature';
    //     if($reading->humidity >= $device->humidity_threshold) $types[] = 'humidity';
    //     return $types;
    // }

    public function calculateSeverity( string $value, string $threshold): string
    {
        if($value > $threshold * 1.5) return 'critical';
        return 'high';

    }

    public function resolveActiveAlerts(Device $device):void
    {
        Alert::where('device_id', $device->id)
            ->where('status','active')
            ->update([
                'status' => 'resolved',
                'resolved_at' => now()
            ]);
    }
}
