<?php

namespace App\Http\Controllers\Api;

use App\Models\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $query = Alert::latest('triggered_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $alerts = $query->paginate(20);

        return response()->json([
            'status' => 'success',
            'alerts' => $alerts
        ]);
    }
}
