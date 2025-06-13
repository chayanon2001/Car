<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return view('admin.cars.index', compact('cars'));
    }

    public function store(Request $request)
    {
        $car = Car::create($request->only(['brand', 'model', 'year']));
        return response()->json($car);
    }

    public function update(Request $request, Car $car)
    {
        $car->update($request->only(['brand', 'model', 'year']));
        return response()->json($car);
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return response()->json(['message' => 'deleted']);
    }
}
