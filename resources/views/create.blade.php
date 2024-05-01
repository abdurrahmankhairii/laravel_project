@extends('layouts.app')

@section('content')
<h1>Create Concert</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('concerts.store') }}">
    @csrf
    <div class="form-group">
        <label for="concert_name">Concert Name</label>
        <input type="text" name="concert_name" id="concert_name" class="form-control" value="{{ old('concert_name') }}">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
    </div>
    <div class="form-group">
        <label for="price">Price (per seat)</label>
        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
    </div>
    <div class="form-group">
        <label for="seat">Number of Seats</label>
        <input type="number" name="seat" id="seat" class="form-control" value="{{ old('seat') }}">
    </div>
    <div class="form-group">
        <label for="location_id">Location</label>
        <select name="location_id" id="location_id" class="form-control">
            @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->city }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="genre_id">Genre</label>
        <select name="genre_id" id="genre_id" class="form-control">
            @foreach ($genres as $genre)
                <option value="{{ $genre->id }}">{{ $genre->genre_music }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create Concert</button>
</form>
@endsection
