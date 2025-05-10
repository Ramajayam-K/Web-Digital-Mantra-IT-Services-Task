<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StateController extends Controller
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
            'country_id' => 'required|exists:countries,id',
            'state_name' => 'required'
        ]);

        $state = State::create($request->only('country_id', 'state_name'));

        return response()->json($state, 201);
    }

    public function show(State $state)
    {
        return response()->json($state->load('country'));
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_name' => 'required'
        ]);

        $state->update($request->only('country_id', 'state_name'));

        return response()->json($state);
    }

    public function destroy(State $state)
    {
        $state->delete();
        return response()->json(['message' => 'State deleted']);
    }
}
