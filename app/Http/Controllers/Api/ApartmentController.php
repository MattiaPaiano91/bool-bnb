<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


//Models
use App\Models\Apartment;
use GrahamCampbell\ResultType\Success;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartment = Apartment::with('users','apartment_service','apartment_sponsorhip','photos','services','sponsorhips');
        return response()->json([
            'success'=>true,
            'result'=>$apartment
        ]);
    }

    public function show(string $slug)
    {
        $apartment = Apartment::with('users','apartment_service','apartment_sponsorhip','photos','services','sponsorhips')->where("slug", $slug)->firstOrFail();
        return response()->json([
            'success'=>true,
            'result'=>$apartment
        ]);
    }
}