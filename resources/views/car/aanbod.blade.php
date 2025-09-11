@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Auto aanbieden</h2>

        <form method="POST" action="{{ route('aanbod.store') }}">
            @csrf

            <div class="mb-3">
                <label for="license_plate" class="form-label">Kenteken</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate" required>
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Merk</label>
                <input type="text" class="form-control" id="brand" name="brand">
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model">
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Kleur</label>
                <input type="text" class="form-control" id="color" name="color">
            </div>

            <div class="mb-3">
                <label for="production_year" class="form-label">Bouwjaar</label>
                <input type="text" class="form-control" id="production_year" name="production_year">
            </div>

            <div class="mb-3">
                <label for="doors" class="form-label">Aantal deuren</label>
                <input type="number" class="form-control" id="doors" name="doors">
            </div>

            <div class="mb-3">
                <label for="weight" class="form-label">Gewicht</label>
                <input type="number" class="form-control" id="weight" name="weight">
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Prijs (€)</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <div class="mb-3">
                <label for="mileage" class="form-label">Kilometerstand</label>
                <input type="number" class="form-control" id="mileage" name="mileage" required>
            </div>

            <button type="submit" class="btn btn-success">Opslaan</button>
        </form>
    </div>

    <script>
        document.getElementById('license_plate').addEventListener('blur', function() {
            const kenteken = this.value.trim();
            if (kenteken.length === 0) return;

            fetch('/rdw/' + kenteken)
                .then(res => res.json())
                .then(data => {
                    if (!data.error) {
                        document.getElementById('brand').value = data.brand || '';
                        document.getElementById('model').value = data.model || '';
                        document.getElementById('color').value = data.color || '';
                        document.getElementById('production_year').value = data.production_year || '';
                        document.getElementById('doors').value = data.doors || '';
                        document.getElementById('weight').value = data.weight || '';
                    } else {
                        alert(data.error);
                    }
                })
                .catch(err => console.error(err));
        });
    </script>
@endsection
