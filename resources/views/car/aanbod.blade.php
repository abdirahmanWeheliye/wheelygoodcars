@extends('layouts.app')

@section('content')
    <h2>Auto aanbieden</h2>
    <form method="POST" action="{{ route('aanbod.store') }}">
        @csrf
        <label>Kenteken:
            <input type="text" name="license_plate" required>
        </label>
        <br><br>
        <label>price (€):
            <input type="number" name="price" required>
        </label>
        <br><br>
        <button type="submit">Aanbieden</button>
    </form>
@endsection
