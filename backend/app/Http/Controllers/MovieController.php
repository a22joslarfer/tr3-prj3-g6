<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class MovieController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'year' => 'required|integer',
                'rating' => 'required|numeric',
                'poster' => 'required|string',
                'synopsis' => 'required|string',
                'genre_id' => 'required|integer',
                'showing_date' => 'required|date',
                'poster_bg1' => 'required|string',
                'poster_bg2' => 'required|string',
            ]);

            $movie = Movie::create($validatedData);
            return response()->json($movie, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'There was an error while creating the movie: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        return Movie::all();
    }

    public function show($id)
    {
        return Movie::find($id);
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $movie->update($request->all());

        return response()->json($movie, 200);
    }

    public function delete($id)
    {
        try {
            $movie = Movie::findOrFail($id);
            $movie->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Movie successfully deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'There was an error deleting the movie: ' . $e->getMessage()
            ], 500);
        }
    }

    // get json and insert into db

    public function insert(Request $request)
    {
        $movies = $request->json()->all();

        foreach ($movies as $movie) {
            Movie::create([
                'title' => $movie['title'],
                'year' => $movie['year'],
                'rating' => $movie['rating'],
                'poster' => $movie['poster'],
                'synopsis' => $movie['synopsis'],
                'genre_id' => $movie['genre_id'],
                'showing_date' => $movie['showing_date'],
                'poster_bg1' => $movie['poster_bg1'],
                'poster_bg2' => $movie['poster_bg2'],
            ]);
        }
        // return response with message if positive
        return response()->json(['message' => 'Movies inserted'], 201);
    }

    // return json of all movies with showing_date > today

    public function getEstrenos()
    {
        $currentDate = Carbon::now();
        $movies = Movie::where('showing_date', '>', $currentDate)->get();
        return response()->json($movies, 200);
    }

    // get title based on movie id 

    public function getTitle($id)
    {
        $movie = Movie::find($id);
        if(!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }
        return response()->json(['title' => $movie->title], 200);
    }
}
