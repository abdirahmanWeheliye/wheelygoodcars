@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <title>Auto PDF</title>
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
            }

            h2 {
                text-align: center;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            td,
            th {
                border: 1px solid #000;
                padding: 8px;
            }
        </style>
    </head>

    <body>
        <h2>Auto gegevens</h2>

        <table>
            <tr>
                <th>Kenteken</th>
                <td>{{ $car->license_plate }}</td>
            </tr>
            <tr>
                <th>Merk</th>
                <td>{{ $car->brand }}</td>
            </tr>
            <tr>
                <th>Model</th>
                <td>{{ $car->model }}</td>
            </tr>
            <tr>
                <th>Prijs</th>
                <td>€{{ number_format($car->price, 2) }}</td>
            </tr>
            <tr>
                <th>Kilometerstand</th>
                <td>{{ number_format($car->mileage) }} km</td>
            </tr>
            <tr>
                <th>Kleur</th>
                <td>{{ $car->color }}</td>
            </tr>
            <tr>
                <th>Bouwjaar</th>
                <td>{{ $car->production_year }}</td>
            </tr>
            <tr>
                <th>Aantal deuren</th>
                <td>{{ $car->doors ?? '-' }}</td>
            </tr>
            <tr>
                <th>Aantal zitplaatsen</th>
                <td>{{ $car->seats ?? '-' }}</td>
            </tr>
            <tr>
                <th>Gewicht</th>
                <td>{{ $car->weight ?? '-' }} kg</td>
            </tr>
        </table>
    </body>

    </html>
@endsection
