<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;

class Device extends Model
{
    use HasFactory;

    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $fillable = [
        'id', 
        'uid',
        'location',
        'gas_threshold',
        'temperature_threshold',
        'humidity_threshold',
        'last_seen_at'
        ];

    protected function casts(): array
    {
        return [
            'gas_threshold' => 'float',
            'temperature_threshold' => 'float',
            'humidity_threshold' => 'float',
        ];
    }
}
