<div class="row">
    @forelse($cars as $car)
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">

                @if ($car->image)
                    <img src="{{ asset('storage/cars/' . $car->image) }}" class="card-img-top"
                        alt="{{ $car->brand }}">
                @endif

                <div class="card-body">
                    <h5>
                        <a href="{{ route('car.show', $car->id) }}">
                            {{ $car->brand }} {{ $car->model }}
                        </a>
                    </h5>

                    <p class="card-text">
                        Kenteken: {{ $car->license_plate }} <br>
                        Prijs: €{{ number_format($car->price, 2, ',', '.') }} <br>

                    </p>

                   
                </div>

            </div>
        </div>
    @empty
        <p>Geen auto's gevonden.</p>
    @endforelse
</div>
