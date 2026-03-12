@extends('layouts.app')

@section('content')
    <div class="container" id="car-{{ $car->id }}">
        <h2>Aanbod aanpassen: {{ $car->brand }} {{ $car->model }} ({{ $car->license_plate }})</h2>

        {{-- Prijs aanpassen --}}
        <form action="{{ route('car.updatePrice', $car->id) }}" method="POST" class="d-flex gap-2 mb-3">
            @csrf
            {{-- Price --}}
            <div class="mb-3">
                <label class="form-label">Prijs (€)</label>
                <input type="number" name="price" value="{{ $car->price }}" class="form-control w-auto">
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select w-auto">
                    <option value="available" {{ !$car->sold_at ? 'selected' : '' }}>Beschikbaar</option>
                    <option value="sold" {{ $car->sold_at ? 'selected' : '' }}>Verkocht</option>
                </select>
            </div>

            {{-- Sold At (optional) --}}
            <div class="mb-3">
                <label class="form-label">Verkocht op</label>
                <input type="date" name="sold_at" value="{{ $car->sold_at ? $car->sold_at->format('Y-m-d') : '' }}"
                    class="form-control w-auto">
                <small class="text-muted">Laat leeg als de auto niet verkocht is.</small>
            </div>

            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>


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
