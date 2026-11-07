<?php

namespace App\Enums;

enum DeviceType: string
{
    case ESP32 = 'ESP32';
    case ARDU = 'ARDU';
    case PI = 'PI';
    case NODE = 'NODE';
    case DEVICE = 'Device'; // Default fallback

    /**
     * Get all values as a simple array for validation.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
