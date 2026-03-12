@extends('layouts.app')

@section('content')
    <h2>Tags overzicht</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tag</th>
                <th>Niet-verkocht</th>
                <th>Verkocht</th>
                <th>Totaal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->unsold_count }}</td>
                    <td>{{ $tag->sold_count }}</td>
                    <td>{{ $tag->unsold_count + $tag->sold_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
