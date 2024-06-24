<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index() {
        $countries = Country::all();
        $arr = [];
        foreach($countries as $country) {
            $arr[$country->code] = $country;
        }
        return $arr;
    }
}
