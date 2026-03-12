@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Auto aanbieden</h2>

        <form id="carForm" method="POST" action="{{ route('aanbod.store') }}" enctype="multipart/form-data">
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
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>

            <div class="mb-3">
                <label for="mileage" class="form-label">Kilometerstand</label>
                <input type="number" class="form-control" id="mileage" name="mileage" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Upload een foto!</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <div class="d-flex gap-2">

                <button id="rdwBtn" type="button" class="btn btn-secondary">Haal gegevens op</button>

            </div>
        </form>
    </div>

    <script>
        const rdwUrl = "{{ url('/rdw') }}";

        document.getElementById('rdwBtn').addEventListener('click', function() {
            const kenteken = document.getElementById('license_plate').value.trim();

            if (kenteken.length === 0) {
                alert("Vul eerst een kenteken in.");
                return;
            }

            fetch("{{ url('/rdw') }}/" + kenteken)
                .then(res => res.json())
                .then(data => {
                    if (!data.error) {

                        alert("RDW-gegevens succesvol opgehaald!");

                        document.getElementById('brand').value = data.brand || '';
                        document.getElementById('model').value = data.model || '';
                        document.getElementById('color').value = data.color || '';
                        document.getElementById('production_year').value = data.production_year || '';
                        document.getElementById('doors').value = data.doors || '';
                        document.getElementById('weight').value = data.weight || '';
                    } else {
                        alert("RDW fout: " + data.error);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Technische fout bij RDW-opvraag.");
                });
        });

        let kenteken = document.getElementById('license_plate').value.trim();
        kenteken = kenteken.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
    </script>
@endsection
