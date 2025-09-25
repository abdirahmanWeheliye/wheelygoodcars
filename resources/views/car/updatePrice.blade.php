@extends('layouts.app')

@section('content')
    <div class="container" id="car-{{ $car->id }}">
        <h2>Aanbod aanpassen: {{ $car->brand }} {{ $car->model }} ({{ $car->license_plate }})</h2>

        {{-- Prijs aanpassen --}}
        <form action="{{ route('car.updatePrice', $car->id) }}" method="POST" class="d-flex gap-2 mb-3">
            @csrf
            <input type="number" name="price" value="{{ $car->price }}" class="form-control form-control-sm w-auto"
                style="max-width: 120px;">
            <button type="submit" class="btn btn-sm btn-primary">Opslaan</button>
        </form>

        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Status --}}
        <div class="mb-2 status">
            <strong>Status:</strong>
            @if ($car->sold_at)
                <span class="badge bg-danger">Verkocht</span>
            @else
                <span class="badge bg-success">Beschikbaar</span>
            @endif
        </div>

        {{-- Toggle-status knop --}}
        <button type="button" class="btn btn-sm btn-warning toggle-status" data-id="{{ $car->id }}">
            @if ($car->sold_at)
                Markeer als beschikbaar
            @else
                Markeer als verkocht
            @endif
        </button>
    </div>

    {{-- Ajax script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-status').forEach(button => {
                button.addEventListener('click', function() {
                    const carId = this.dataset.id;

                    fetch(`/cars/${carId}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            const container = document.querySelector(`#car-${carId}`);
                            const statusDiv = container.querySelector('.status');
                            const toggleButton = container.querySelector('.toggle-status');

                            if (data.status === 'Verkocht') {
                                statusDiv.innerHTML =
                                    '<strong>Status:</strong> <span class="badge bg-danger">Verkocht</span>';
                                toggleButton.innerText = 'Markeer als beschikbaar';
                            } else {
                                statusDiv.innerHTML =
                                    '<strong>Status:</strong> <span class="badge bg-success">Beschikbaar</span>';
                                toggleButton.innerText = 'Markeer als verkocht';
                            }
                        });
                });
            });
        });
    </script>
@endsection
