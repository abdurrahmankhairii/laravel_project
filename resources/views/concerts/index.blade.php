<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Khairi Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    header {
      background-color: #66ccff;
      padding: 10px 20px;
      display: flex; /* Use flexbox for layout */
      justify-content: space-between; /* Align items horizontally */
      align-items: center; /* Align items vertically */
    }

    header h1 {
      color: #000;
      font-size: 25px;
      margin: 0;
    }

    header ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    header li {
      display: inline-block;
      margin-right: 20px;
    }

    header a {
      color: #333;
      text-decoration: none;
    }

    header button {
      background-color: #fff;
      border: 3px solid #ccc;
      padding: 5px 10px;
      cursor: pointer;
    }

    header .social-media {
      /* No additional styles needed here */
    }

    header .social-media li {
      display: inline-block;
    }
  </style>
</head>
<body style="background: lightgrey">
    <header>
        <h1>Abdurrahman Khairi</h1>
        <ul>
        <li><a href="{{ route('genres.index') }}" class="btn btn-sm btn-primary">Genre Music</a></li>
        <li><a href="{{ route('locations.index') }}" class="btn btn-sm btn-primary">Location City</a></li>
        <li><a href="{{ route('concerts.index') }}" class="btn btn-sm btn-primary">Concert Event</a></li>
        </ul>
        <ul class="social-media">
        <li><a href="https://www.instagram.com/abdurrahmankhairii"><img src="img/instagram.png" style="width:50px" alt="Instagram"></a></li>
        <li><a href="https://www.linkedin.com/in/abdurrahmankhairi/"><img src="img/linkedin.png" style="width:50px" alt="LinkedIn"></a></li>
        <li><a href="#"><img src="img/github.png" style="width:50px" alt="GitHub"></a></li>
        </ul>
    </header>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('concerts.create') }}" class="btn btn-md btn-success mb-3">ADD CONCERT</a>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">IMAGE</th>
                                    <th scope="col">CONCERT'S EVENT</th>
                                    <th scope="col">CITY</th>
                                    <th scope="col">GENRE MUSIC</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">SEAT</th>
                                    <th scope="col" style="width: 15%">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($concerts as $concert)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage/concerts/'.$concert->image) }}" class="rounded" style="width: 150px">
                                        </td>
                                        <td>{{ $concert->concert_name }}</td>
                                        <td>
                                            {{ $concert->location->city}}
                                        </td>
                                        <td>
                                            {{ $concert->genre->genre_music}}
                                        </td>
                                        <td>{{ "Rp " . number_format($concert->price,2,',','.') }}</td>
                                        <td>{{ $concert->seat }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Are You Sure ?');" action="{{ route('concerts.destroy', $concert->id) }}" method="POST">
                                                <a href="{{ route('concerts.show', $concert->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                                                <a href="{{ route('concerts.edit', $concert->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Concert Not Yet Ready.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //message with sweetalert
        @if(session('success'))
            Swal.fire({
                icon: "success",
                concert_name: "BERHASIL",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                concert_name: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

    </script>

</body>
</html>