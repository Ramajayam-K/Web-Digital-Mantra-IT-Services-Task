<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Country');
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_name' => 'required|unique:countries,country_name'
        ]);

        $country = Country::create([
            'country_name' => $request->country_name
        ]);

        return response()->json($country, 200);
    }

    public function show(Country $country)
    {
        return response()->json($country);
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'country_name' => 'required|unique:countries,country_name,' . $country->id
        ]);

        $country->update([
            'country_name' => $request->country_name
        ]);

        return response()->json($country);
    }

    public function destroy(Country $country)
    {
        $deletedStatus=$country->delete();
        if($deletedStatus>0){
            return response()->json(['status'=>1,'message' => 'Country deleted']);
        }
         return response()->json(['status'=>0,'message' => 'Country is not deleted']);
    }
}
