<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DeviceType;
use Override;

class Device extends Model
{
    use SoftDeletes;
    use HasFactory;

    // const CREATED_AT = null;
    // const UPDATED_AT = null;
    protected $fillable = [
        'id', 
        'uid',
        'name',
        'type',
        'location',
        'gas_threshold',
        'temperature_threshold',
        'humidity_threshold',
        'gas_mod_threshold', // gas Threshold value
        'temperature_mod_threshold', // temp Threshold value
        'humidity_mod_threshold', // humidity Threshold value
        'is_active',
        ];
    protected $casts = [
        'type' => DeviceType::class,
        'is_active' => 'boolean',
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
    
    protected static function booted()
    {
        // static::creating(function ($device) {
        //     // Once the record is created, we have the auto-incremented $device->id
        //     if (empty($device->uid)) {

        //         // Get the string value from the enum instance (defaults to 'Device')
        //         $type = $device->type?->value ?? 'Device';
        //         // Pad the ID with leading zeros to 3 digits (e.g., 1 -> 001)
        //         $paddedId = str_pad($device->id, 3, '0', STR_PAD_LEFT);

        //         $device->update([
        //             'uid' => "{$type}-{$paddedId}"
        //         ]);
        //     }
        // });
        static::creating(function ($device) {
            if (empty($device->uid)) {
                $type = $device->type?->value ?? $device->type ?? 'Device';
                
                // To get the next auto-incrementing ID safely before save, 
                // or use a temporary unique string/hash if ID isn't incremented yet:
                $latestId = static::max('id') + 1;
                $paddedId = str_pad($latestId, 3, '0', STR_PAD_LEFT);
                
                $device->uid = "{$type}-{$paddedId}";
            }
        });
    }

    public function sensorReadings()
    {
        return $this->hasMany(SensorData::class);
    }
}
