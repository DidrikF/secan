<?php

namespace App\Http\Controllers;

use App\Models\Common\Industry;
use App\Models\Common\Security;
use App\Models\InvestorProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoadApplicationController extends Controller
{

    //WONT DO IT LIKE THIS!
    //Could still be a usefull controller, but IDK what for ATM.
    public function show() //$authtoken
    {
        return view('application'); //, ['authtoken' => $authtoken]
    }

}

