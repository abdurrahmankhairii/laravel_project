<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Concert - Abdurrahman Khairi</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightblue">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="container">
                        <form action="{{ route('concerts.store') }}" method="POST" enctype="multipart/form-data">
                        
                            @csrf
                            @method('post')

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">IMAGE</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            
                                <!-- error message untuk image -->
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">CONCERT'S NAME</label>
                                <input type="text" class="form-control @error('concert_name') is-invalid @enderror" name="concert_name" value="{{ old('concert_name') }}" placeholder="Input the concert's Name">
                            
                                <!-- error message for concert name -->
                                @error('concert_name')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">DESCRIPTION</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Input the Description concert">{{ old('description') }}</textarea>
                            
                                <!-- error message untuk description -->
                                @error('description')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold" for="city">CITY</label>
                                        <div>
                                            <select name="location_id" id="city" class="form-control">
                                            <option value="">Select a city first</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->city }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                                                            
                                        <!-- error message untuk music_location -->
                                        @error('city')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold" for="genre">MUSIC GENRE</label>
                                            <div>
                                                <select name="genre_id[]" id="genre" class="form-control">
                                                <option value="">Select a Genre Music after select City</option>
                                                </select>
                                            </div>
                                            <!-- error message untuk music_genre -->
                                            @error('genre_music')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">PRICE</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" placeholder="Input Price of the Concert">
                                    
                                        <!-- error message untuk price -->
                                        @error('price')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">SEAT</label>
                                        <input type="number" class="form-control @error('seat') is-invalid @enderror" name="seat" value="{{ old('seat') }}" placeholder="Input Seat of the Concert">
                                    
                                        <!-- error message untuk seat -->
                                        @error('seat')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary me-3">SAVE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
    <script>
        $(document).ready(function() {
            // contoh JSON
            //[{"id":1,"genre_music":"HipHop"},{"id":4,"genre_music":"Dangdut"},{"id":5,"genre_music":"Pop"},{"id":7,"genre_music":"Jazz"}]
            $("#city").change(function() {
                var cityId = $(this).val();

                $.ajax({
                    url: "/genre_list/" + cityId,
                    method: "GET",
                    success: function(data) {
                        $("#genre").empty();
                        console.log("TEST");
                        console.log(JSON.parse(data));
                        // TODO try to load the JSON from laravel
                        $.each(JSON.parse(data), function(i, genre) {
                            console.log(genre);
                            $("#genre").append("<option value='" + genre.id + "'>" + genre.genre_music + "</option>");
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
