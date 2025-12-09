<?php

namespace App\Http\Controllers;

use App\Data\IndonesiaLocations;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCities($province)
    {
        $cities = IndonesiaLocations::getCities($province);
        return response()->json($cities);
    }
}
