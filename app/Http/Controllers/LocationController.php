<?php

namespace App\Http\Controllers;

use App\Models\Company\City;
use App\Models\Company\Region;
use Illuminate\Http\Request;
use Mpociot\Reflection\DocBlock\Location;

class LocationController extends Controller
{
    public function getCountries()
    {
        $countries = City::all();

        return response()->json(['data' => $countries]);
    }

    public function getRegions()
    {
        $regions = Region::all();

        return response()->json(['data' => $regions]);
    }

    public function getCities()
    {
        $cities = City::all();

        return response()->json(['data' => $cities]);
    }
}
