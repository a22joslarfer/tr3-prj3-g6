<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $genre = Genre::create($validatedData);

        return response()->json($genre, 201);
    }

    public function index()
    {
        return Genre::all();
    }

    public function show($id)
    {
        return Genre::find($id);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);
        $genre->update($request->all());

        return response()->json($genre, 200);
    }

    public function delete($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return response()->json(null, 204);
    }

    // get json and insert into db

    public function insert(Request $request)
    {
        $genres = $request->json()->all();

        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre['name'],
                'description' => $genre['description'],
            ]);
        }
        // return response with message if positive 
        return response()->json(['message' => 'Genres inserted'], 201);
       
    }

    
}
