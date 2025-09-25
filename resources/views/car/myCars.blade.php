@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Mijn aangeboden auto's</h2>

        @if ($cars->isEmpty())
            <p>Je hebt nog geen auto's aangeboden.</p>
        @else
            <table class="table table-striped table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kenteken</th>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Prijs</th>
                        <th>Kilometers</th>
                        <th>Productiejaar</th>
                        <th>Kleur</th>
                        <th>Bekeken</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $car)
                        <tr>
                            <td>{{ $car->id }}</td>
                            <td>{{ $car->license_plate }}</td>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->model }}</td>
                            <td>€{{ number_format($car->price, 2) }}</td>
                            <td>{{ number_format($car->mileage) }} km</td>
                            <td>{{ $car->production_year ?? '-' }}</td>
                            <td>{{ $car->color ?? '-' }}</td>
                            <td>{{ $car->views }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Bewerk</a>
                                <form action="{{ route('car.destroy', $car->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Weet je zeker dat je deze auto wilt verwijderen?');">
                                        Verwijder
                                    </button>
                            </td>
                            <td>
                                <a href="{{ route('car.pdf', $car->id) }}" class="btn btn-sm btn-secondary">PDF</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
    </div>
@endsection
