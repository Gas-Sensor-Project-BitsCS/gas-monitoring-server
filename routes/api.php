<?php

use App\Http\Controllers\Api\SensorReadingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\DeviceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sensor-readings', [SensorReadingController::class,'store']);
Route::get('/sensor-readings/latest',[DashboardController::class,'latestSensorData']);
Route::get('/alerts', [AlertController::class, 'index']);
Route::get(
    '/devices/{device}',
    [DeviceController::class, 'show']
);
Route::put(
    '/devices/{device}/thresholds',
    [DeviceController::class, 'updateThresholds']
);
