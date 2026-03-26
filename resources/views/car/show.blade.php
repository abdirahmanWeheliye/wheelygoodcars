@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>{{ $car->brand }} {{ $car->model }}</h2>

        @if ($car->image)
            <img src="{{ asset('storage/cars/' . $car->image) }}" width="300" class="mb-3">
        @endif

        <ul class="list-group">
            <li class="list-group-item"><strong>Kenteken:</strong> {{ $car->license_plate }}</li>
            <li class="list-group-item"><strong>Prijs:</strong> €{{ number_format($car->price, 2) }}</li>
            <li class="list-group-item"><strong>Kilometerstand:</strong> {{ number_format($car->mileage) }} km</li>
            <li class="list-group-item"><strong>Bouwjaar:</strong> {{ $car->production_year ?? '-' }}</li>
            <li class="list-group-item"><strong>Kleur:</strong> {{ $car->color ?? '-' }}</li>
            <li class="list-group-item"><strong>Gewicht:</strong> {{ $car->weight ?? '-' }} kg</li>
            <li class="list-group-item"><strong>Deuren:</strong> {{ $car->doors ?? '-' }}</li>
            <li class="list-group-item">
                <strong>Status:</strong>
                @if ($car->sold_at)
                    <span class="badge bg-danger">Verkocht</span>
                @else
                    <span class="badge bg-success">Beschikbaar</span>
                @endif
            </li>
        </ul>
    </div>
@endsection
