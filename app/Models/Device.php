<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;

class Device extends Model
{
    use HasFactory;

    // const CREATED_AT = null;
    // const UPDATED_AT = null;
    protected $fillable = [
        'id', 
        'uid',
        'name',
        'location',
        'gas_threshold',
        'temperature_threshold',
        'humidity_threshold',
        'gas_mod_threshold', // gas Threshold value
        'temperature_mod_threshold', // temp Threshold value
        'humidity_mod_threshold', // humidity Threshold value
        'is_active',
        'deleted_at',
        ];

    protected function casts(): array
    {
        return [
            'gas_threshold' => 'float',
            'temperature_threshold' => 'float',
            'humidity_threshold' => 'float',
            'gas_mod_threshold' => 'float', // gas Threshold value
            'temperature_mod_threshold' => 'float', // temp Threshold value
            'humidity_mod_threshold' => 'float',
        ];
    }

    public function sensorReadings()
    {
        return $this->hasMany(SensorData::class);
    }
}
