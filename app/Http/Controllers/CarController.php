<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Car;
use Barryvdh\DomPDF\Facade\Pdf;


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
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/cars', $filename);
            $car->image = $filename;
            $car->save();
        }

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


    public function fetchFromRdw($license_plate)
    {
        // Normalize plate
        $cleanPlate = strtoupper(str_replace(['-', ' '], '', $license_plate));

        // RDW dataset
        $url = "https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=" . $cleanPlate;

        $response = Http::get($url);

        // If RDW returned data
        if ($response->successful() && !empty($response->json())) {
            $data = $response->json()[0];

            return response()->json([
                'brand'           => $data['merk'] ?? null,
                'model'           => $data['handelsbenaming'] ?? null,
                'color'           => $data['eerste_kleur'] ?? null,
                'doors'           => $data['aantal_deuren'] ?? null,
                'production_year' => isset($data['datum_eerste_toelating'])
                    ? substr($data['datum_eerste_toelating'], 0, 4)
                    : null,
                'weight'          => $data['massa_ledig_voertuig'] ?? null,
            ]);
        }

        // 🔥 FALLBACK: Try your own database
        $car = Car::where('license_plate', $license_plate)->first();

        if ($car) {
            return response()->json([
                'brand'           => $car->brand,
                'model'           => $car->model,
                'color'           => $car->color,
                'doors'           => $car->doors,
                'production_year' => $car->production_year,
                'weight'          => $car->weight,
            ]);
        }

        // If neither RDW nor DB has data
        return response()->json(['error' => 'Geen data gevonden voor dit kenteken'], 404);
    }

    public function show(Car $car)
    {
        // Optioneel: views verhogen
        $car->increment('views');

        return view('car.show', compact('car'));
    }

    public function generatePdf(Car $car)
    {
        // Controleer of de ingelogde gebruiker eigenaar is
        if ($car->user_id !== auth()->id()) {
            abort(403, 'Je mag deze auto niet bekijken.');
        }

        $pdf = Pdf::loadView('car.pdf', compact('car'));

        // Download de PDF
        return $pdf->download('auto_' . $car->license_plate . '.pdf');
    }

    public function editPrice(Car $car)
    {
        return view('car\updatePrice', compact('car'));
    }


    public function updatePrice(Request $request, Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403, 'Je mag dit aanbod niet aanpassen.');
        }

        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $car->price = $request->price;
        $car->save();

        return back()->with('success', 'Prijs bijgewerkt!');
    }

    public function toggleStatus(Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403, 'Je mag dit aanbod niet aanpassen.');
        }

        $car->sold_at = $car->sold_at ? null : now();
        $car->save();

        return response()->json([
            'status' => $car->sold_at ? 'Verkocht' : 'Beschikbaar'
        ]);
    }

    public function publicIndex()
    {

        $cars = Car::whereNull('sold_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('car.publicIndex', compact('cars'));
    }
}
