<?php

namespace App\Http\Controllers;

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

class LocationController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get genres locations
        $locations = Location::with('genres')
        ->orderBy('created_at', 'desc')
        ->paginate(10);


        //render view with locations and genres
        return view('locations.index', compact('locations')); // Pass the $genres variable to the view

    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        
        $genres = Genre::all(); // Retrieve all genres from the database

        return view('locations.create', compact('genres')); // Pass the $genres variable to the view

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
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'city'         => 'required|min:3',
            'genres'  => 'required|array'
        ]);



        //upload images
        $image = $request->file('image');
        $image->storeAs('public/locations', $image->hashName());
            
        $location = Location::create([
            'image'         => $image->hashName(),
            'city' => $validatedData['city'],
        ]);
        $location->genres()->attach($validatedData['genres']);
    
        return redirect()->route('locations.index')->with('success','Location created successfully.');
    }

        /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get location by ID
        // $location = Location::findOrFail($id);
            // ->with('genres')
            // ->orderBy('created_at', 'desc')
            // ->paginate(10);

        $location= Location::with('genres')->find($id);

        $genres = Genre::all(); // Retrieve all genres from the database

        //render view with location
        return view('locations.show', compact('location','genres'));
    }

        /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get location by ID
        $location = Location::findOrFail($id);

        // //validate form
        // $validatedData = $location->validate([
        //     'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
        //     'city'         => 'required|min:5',
        //     'genres'  => 'required|array'
        //  ]);
    
        // //upload images
        // $image = $location->file('image');
        // $image->storeAs('public/locations', $image->hashName());
                
        // $location = Location::create([
        //     'image'         => $image->hashName(),
        //     'city' => $validatedData['city'],
        // ]);
            
        // $location->genres()->attach($validatedData['genres']);

        $genres = Genre::all(); // Retrieve all genres from the database

        //render view with location
        return view('locations.edit', compact('location','genres'));

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
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'city'         => 'required|min:3',
            'genres'  => 'required|array'
        ]);

        //get location by ID
        $location = Location::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/locations', $image->hashName());

            //delete old image
            Storage::delete('public/locations/'.$location->image);

            //update location with new image
            $location->update([
                'image'         => $image->hashName(),
                'city' => $validatedData['city'],
                
            ]);
        } else {

            //update location without image
            $location->update([
                'city' => $validatedData['city'],
            ]);
        }

        // $location->genres()->attach($validatedData['genres']);

        // Get the selected genres from the request data
        $selectedGenres = $validatedData['genres'];

        // Detach all the genres from the location
        $location->genres()->detach();

        // Attach the selected genres to the location
        foreach ($selectedGenres as $genreId) {
            $location->genres()->attach($genreId);
        }

        //redirect to index
        return redirect()->route('locations.index')->with('success', 'Location successfully changed!');

            //    //validate form
            //    $validatedData = $request->validate([
            //     'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            //     'city'         => 'required|min:5',
            //     'genres'  => 'required|array'
            // ]);
    
    
    
            // //upload images
            // $image = $request->file('image');
            // $image->storeAs('public/locations', $image->hashName());
                
            // $location = Location::create([
            //     'image'         => $image->hashName(),
            //     'city' => $validatedData['city'],
            // ]);
            // $location->genres()->attach($validatedData['genres']);
        
            // return redirect()->route('locations.index')->with('success','Location created successfully.');
    }

        
    /**
     * destroy
     *
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        //get location by ID
        $location = Location::findOrFail($id);

        //delete image
        Storage::delete('public/locations/'. $location->image);

        //delete location
        $location->delete();

        //redirect to index
        return redirect()->route('locations.index')->with(['success' => 'Location Deleted!']);
    }

}
