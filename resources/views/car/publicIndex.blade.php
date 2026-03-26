@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Aanbod</h2>

        <input type="text" id="search" class="form-control mb-3" placeholder="Zoek op merk of model...">

        <div id="results">
            @include('car.partials.results', ['cars' => $cars])
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            let query = this.value;

            fetch("{{ route('car.search') }}?q=" + query)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('results').innerHTML = html;
                });
        });
    </script>
@endsection
