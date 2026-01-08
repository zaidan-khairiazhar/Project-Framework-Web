<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Propinsi;

class PropinsiController extends Controller
{
    public function index()
    {
        $propinsi = Propinsi::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Propinsi',
            'data'    => $propinsi
        ], 200);
    }
}
