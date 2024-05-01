<?php

namespace App\Http\Controllers;

//import model concert
use App\Models\Concert;

//import model location
use App\Models\Location;

//import model genre
use App\Models\Genre;

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

//import Facades Storage
use Illuminate\Support\Facades\Storage;

class ConcertController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(): View
    {
        $concerts = Concert::all();

        //render view with concerts and locations
        return view('concerts.index', ["concerts" => $concerts]);
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        $locations = Location::with('genres')->get();
        $genres = Genre::all(); // Add this line to fetch all genres

        return view('concerts.create', compact('locations', 'genres')); // Pass the $genres variable to the view
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'concert_name' => 'required|min:5',
            'description' => 'required|min:10',
            'location_id' => 'required|exists:locations,id',
            'genre_id' => 'required|exists:genres,id',
            'price' => 'required|numeric',
            'seat' => 'required|numeric',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/concerts', $image->hashName());

        // Convert the array of genre IDs to a comma-separated string
        $genreIds = implode(',', $validatedData['genre_id']);

        //create concert
        $concert = Concert::create([
            'image' => $image->hashName(),
            'concert_name' => $validatedData['concert_name'],
            'description' => $validatedData['description'],
            'location_id' => $validatedData['location_id'],
            'genre_id' => $validatedData['genre_id'][0],
            'price' => $validatedData['price'],
            'seat' => $validatedData['seat'],
        ]);

        // Save the concert to the database
        $concert->save();

        //redirect to index
        return redirect()->route('concerts.index')->with(['success' => 'Concert created successfully!']);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get concert by ID
        $concert = Concert::findOrFail($id);

        //render view with concert
        return view('concerts.show', compact('concert'));//, ["concerts" => $concerts])
    }

    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {

        //get concert by ID
        $concert = Concert::findOrFail($id);
        
        $locations = Location::with('genres')->get();
        $genres = Genre::all(); // Add this line to fetch all genres

        //render view with concert 
        return view('concerts.edit', compact( 'concert','locations','genres')); // Pass the $genres variable to the view
    }


    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'concert_name' => 'required|min:5',
            'description' => 'required|min:10',
            'location_id' => 'required|exists:locations,id',
            'genre_id' => 'required|exists:genres,id',
            'price' => 'required|numeric',
            'seat' => 'required|numeric',
        ]);

        //get concert by ID
        $concert = Concert::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/concerts', $image->hashName());

            //delete old image
            Storage::delete('public/concerts/' . $concert->image);

            // Convert the array of genre IDs to a comma-separated string
            $genreIds = implode(',', $request->genre_id);

            //update concert with new image
            $concert->update([
                'image' => $image->hashName(),
                'concert_name' => $validatedData['concert_name'],
                'description' => $validatedData['description'],
                'location_id' => $validatedData['location_id'],
                'genre_id' => $validatedData['genre_id'][0],
                'price' => $validatedData['price'],
                'seat' => $validatedData['seat'],
            ]);

        } else {

            //update concert without image
            $concert->update([
                'concert_name' => $validatedData['concert_name'],
                'description' => $validatedData['description'],
                'location_id' => $validatedData['location_id'],
                'genre_id' => $validatedData['genre_id'][0],
                'price' => $validatedData['price'],
                'seat' => $validatedData['seat'],
            ]);
        }
        //redirect to index
        return redirect()->route('concerts.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    /**
     * destroy
     *
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        //get concert by ID
        $concert = Concert::findOrFail($id);

        //delete image
        Storage::delete('public/concerts/' . $concert->image);

        //delete concert
        $concert->delete();

        //redirect to index
        return redirect()->route('concerts.index')->with(['success' => 'Data Deleted!']);
    }

}
