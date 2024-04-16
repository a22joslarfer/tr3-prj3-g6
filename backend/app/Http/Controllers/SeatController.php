<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Movie;
class SeatController extends Controller
{
    //

    public function index()
    {
        return Seat::all();
    }

    public function insert(Request $request)
    {
        $seats = $request->json()->all();

        foreach ($seats as $seat) {
            Seat::create([
                'movie_id' => $seat['movie_id'],
                'status' => 'available',
                'row' => $seat['row'],
                'column' => $seat['column'],
                'vip' => 'false',
            ]);
        }
        // return response with message if positive
        return response()->json(['message' => 'seats inserted'], 201);
    }

    // find all seats for a movie

    public function show($id)
    {
        return Seat::where('movie_id', $id)->get();
    }

    public function delete($id)
    {

        if(Seat::where('movie_id', $id)->doesntExist()){
            return response()->json(['message' => 'seats not found'], 404);
        }
        
        Seat::where('movie_id', $id)->delete();
        return response()->json(['message' => 'seats deleted'], 200);
    }

    // create seats based on movie_id (12 rows 10 columns)

    public function create($id)
    {

        if(Seat::where('movie_id', $id)->exists()){
            return response()->json(['message' => 'seats already created'], 200);
        }

        for ($i = 1; $i <= 12; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                Seat::create([
                    'movie_id' => $id,
                    'status' => 'available',
                    'row' => $i,
                    'column' => $j,
                    'vip' => 'false',
                ]);
            }
        }
        return response()->json(['message' => 'seats created'], 201);
    }

    // based on 2 values (movie_id and row) update the statues of the seats to 'booked'

    public function update(Request $request, $id)
    {

        $movie = Movie::find($id);
        if(!$movie){
            return response()->json(['message' => 'movie not found'], 404);
        }

        $seats = Seat::where('movie_id', $id)->where('row', $request->row)->get();

        if($seats->isEmpty()){
            return response()->json(['message' => 'seats not found'], 404);
        }  

        foreach ($seats as $seat) {
            $seat->vip = 'true';
            $seat->save();
        }

        return response()->json(['message' => 'seats updated'], 200);
    }

    // get a single seat via an id

    public function getSeat($id)
    {
        $seat = Seat::find($id);
        if(!$seat){
            return response()->json(['message' => 'seat not found'], 404);
        }
        return $seat;
    }

}
