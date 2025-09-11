<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function create()
    {
        return view('car.aanbod');
    }

    public function store(Request $request)
    {
        $request->validate([
            'license_plate'   => 'required|string|max:10',
            'brand'           => 'required|string|max:50',
            'model'           => 'required|string|max:50',
            'price'           => 'required|numeric|min:0',
            'mileage'         => 'required|integer|min:0',
            'seats'           => 'nullable|integer|min:1',
            'doors'           => 'nullable|integer|min:1',
            'production_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'weight'          => 'nullable|integer|min:0',
            'color'           => 'nullable|string|max:30',
            'image'           => 'nullable|string|max:255',
        ]);

        $car = Car::create([
            'user_id'         => auth()->id(), // Koppel de ingelogde gebruiker
            'license_plate'   => $request->license_plate,
            'brand'           => $request->brand,
            'model'           => $request->model,
            'price'           => $request->price,
            'mileage'         => $request->mileage,
            'seats'           => $request->seats,
            'doors'           => $request->doors,
            'production_year' => $request->production_year,
            'weight'          => $request->weight,
            'color'           => $request->color,
            'image'           => $request->image,
        ]);

        return view('car.overzicht', [
            'car' => $car
        ]);
    }

    public function myCars()
    {
        // Haal alle auto's van de ingelogde gebruiker
        $cars = Car::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();

        return view('car.myCars', compact('cars'));
    }

    public function destroy(Car $car)
    {
        // Controleer of de ingelogde gebruiker eigenaar is
        if ($car->user_id !== auth()->id()) {
            abort(403, 'Je mag deze auto niet verwijderen.');
        }

        $car->delete();

        return redirect()->route('car.myCars')->with('success', 'Auto succesvol verwijderd.');
    }
}
