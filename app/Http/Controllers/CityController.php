<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CityController extends Controller
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
            'state_id' => 'required|exists:states,id',
            'city_name' => 'required'
        ]);

        $city = City::create($request->only('state_id', 'city_name'));

        return response()->json($city, 201);
    }

    public function show(City $city)
    {
        return response()->json($city->load('state'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'city_name' => 'required'
        ]);

        $city->update($request->only('state_id', 'city_name'));

        return response()->json($city);
    }

    public function destroy(City $city)
    {
        $city->delete();
        return response()->json(['message' => 'City deleted']);
    }
}
