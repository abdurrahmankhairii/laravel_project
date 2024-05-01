<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Concerts - Abdurrahman Khairi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightblue">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <img src="{{ asset('/storage/concerts/'.$concert->image) }}" class="rounded" style="width: 100%">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h2>{{ $concert->concert_name }}</h2>
                        <hr/>
                        <h5>Location's City</h5>
                        <p>{{ $concert->location->city}}</p>
                        <hr/>
                        <h5>Genre Music</h5>
                        <p>{{ $concert->genre->genre_music}}</p>
                        <hr/>
                        <h5>Description</h5>
                        <code>
                            <p>{!! $concert->description !!}</p>
                        </code>
                        <hr/>
                        <p>{{ "Rp " . number_format($concert->price,2,',','.') }}</p>
                        <p>Seat : {{ $concert->seat }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>