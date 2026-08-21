<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class DashboardController extends Controller
{
    public function latestSensorData(){
        return SensorData::orderBy('id','desc')->first();
    }
    public function index(Request $request){
        $readings = $this->latestSensorData();
        return view("dashboard",compact("readings"));
    }
}
