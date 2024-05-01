@extends('layouts.app')

@section('content')
<h1>Concerts</h1>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Concert Name</th>
            <th>Location</th>
            <th>Genre</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($concerts as $concert)
            <tr>
                <td>{{ $concert->concert_name }}</td>
                <td>{{ $concert->locationGenre->location->city }}</td>
                <td>{{ $concert->locationGenre->genre->genre_music }}</td>
                <td>{{ Str::limit($concert->description, 50) }}</td>
                <td>
                    <a href="{{ route('concerts.show', $concert->id) }}" class="btn btn-primary">View</a>
                    </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

