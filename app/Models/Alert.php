<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    const CREATED_AT = 'triggered_at';
    const UPDATED_AT = null;
    protected $fillable = [
        'id',
        'device_id',
        // 'sensor_reading_id',
        // 'alert_type',
        'severity',
        'status',
        'triggered_at',
        'resolved_at'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    public function sensorData()
    {
        return $this->belongsTo(SensorData::class);
    }
}
