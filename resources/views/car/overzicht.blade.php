@extends('layouts.app')

@section('content')
   <h2>Overzicht</h2>

    <p>Kenteken: {{ $car->license_plate }}</p>
    <p>Prijs: €{{ $car->price }}</p>

    <p>Auto succesvol aangeboden!</p>
@endsection
