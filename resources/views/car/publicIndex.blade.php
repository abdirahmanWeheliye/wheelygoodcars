@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Alle beschikbare auto's</h2>

    @if($cars->isEmpty())
        <p>Er zijn momenteel geen beschikbare auto's.</p>
    @else
        <div class="row">
            @foreach($cars as $car)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        @if($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->brand }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                            <p class="card-text">
                                Kenteken: {{ $car->license_plate }} <br>
                                Prijs: €{{ number_format($car->price, 2, ',', '.') }} <br>
                                Kilometerstand: {{ number_format($car->mileage) }} km
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
