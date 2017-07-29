<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function show()
    {
    	return response()->json([
    		'ticker' => 'AAPL',
    		'value' => 500
    	], 200);
    }
}
