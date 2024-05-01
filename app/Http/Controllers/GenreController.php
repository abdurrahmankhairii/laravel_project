<?php

namespace App\Http\Controllers;

//import model genre
use App\Models\Genre; 

//import model genre
use App\Models\Location; 

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

//import Facades Storage
use Illuminate\Support\Facades\Storage;

class GenreController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View
    {
        //get all genres
        $genres = Genre::latest()->paginate(10);

        //render view with genres
        return view('genres.index', compact('genres'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('genres.create');
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
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'genre_music'         => 'required|min:3'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/genres', $image->hashName());

        //create genre
        Genre::create([
            'image'         => $image->hashName(),
            'genre_music'         => $request->genre_music,
        ]);

        //redirect to index
        return redirect()->route('genres.index')->with(['success' => 'Data Saved!']);
    }

        /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get genre by ID
        $genre = Genre::findOrFail($id);

        //render view with genre
        return view('genres.show', compact('genre'));
    }

        /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get genre by ID
        $genre = Genre::findOrFail($id);

        //render view with genre
        return view('genres.edit', compact('genre'));
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
        $request->validate([
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'genre_music'         => 'required|min:3'
        ]);

        //get genre by ID
        $genre = Genre::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/genres', $image->hashName());

            //delete old image
            Storage::delete('public/genres/'.$genre->image);

            //update genre with new image
            $genre->update([
                'image'         => $image->hashName(),
                'genre_music'         => $request->genre_music
            ]);

        } else {

            //update genre without image
            $genre->update([
                'genre_music'         => $request->genre_music
            ]);
        }

        //redirect to index
        return redirect()->route('genres.index')->with(['success' => 'Data successfully changed!']);
    }

        
    /**
     * destroy
     *
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        //get genre by ID
        $genre = Genre::findOrFail($id);

        //delete image
        Storage::delete('public/genres/'. $genre->image);

        //delete genre
        $genre->delete();

        //redirect to index
        return redirect()->route('genres.index')->with(['success' => 'Data Deleted!']);
    }

}
