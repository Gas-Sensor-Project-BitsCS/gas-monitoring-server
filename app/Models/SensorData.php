<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    const CREATED_AT = 'recorded_at';
    const UPDATED_AT = null;
    protected $table = 'sensor_readings';
    protected $fillable = [
        'gas_value',
        'temperature',
        'humidity',
        'recorded_at',
    ];
    
    
}
