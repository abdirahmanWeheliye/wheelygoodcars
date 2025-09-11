@extends('layouts.app')

@section('content')
    <h2>Overzicht</h2>
    <p>Kenteken: {{ $license_plate }}</p>
    <p>price: €{{ $price }}</p>
    <p>Auto succesvol aangeboden!</p>
@endsection
