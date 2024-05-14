<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reviewModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class reviewController extends Controller
{
    
    public function createReview(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required',
            'disco_id' => 'required',
            'titulo' => 'required',
            'content' => 'required',
            'puntuacion' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Change 'required' to 'nullable'
            'categoria' => 'required',
        ]);
    
        try {
            $review = new ReviewModel;
            $review->usuario_id = $request->usuario_id;
            $review->disco_id = $request->disco_id;
            $review->titulo = $request->titulo;
            $review->content = $request->content;
            $review->puntuacion = $request->puntuacion;
            $review->categoria = $request->categoria;
    
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('public/photos');
                $review->photo = str_replace('public/', 'storage/', $photoPath);
            } else {
                $review->photo = null; 
            }
    
            $review->save();
    
            return response()->json($review);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the review.'], 500);
        }
    }
    


    public function getReviews()
    {
        $reviews = reviewModel::all();

        return response()->json($reviews);
    }
    public function getReview($id)
    {
        $review = reviewModel::find($id);
        return response()->json($review);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'usuario_id' => 'required',
            'disco_id' => 'required',
            'titulo' => 'required',
            'content' => 'required',
            'puntuacion' => 'required',
        ]);

        $review = reviewModel::find($id);
        $review->usuario_id = $request->usuario_id;
        $review->disco_id = $request->disco_id;
        $review->titulo = $request->titulo;
        $review->content = $request->content;
        $review->puntuacion = $request->puntuacion;
        $review->save();


        return response()->json($review);
    }
    public function delete($id)
    {
        $review = reviewModel::find($id);
        $review->delete();
        return response()->json($review);
    }

    public function getReviewsByUser($id)
    {
        $reviews = reviewModel::where('user_id', $id)->get();
        return response()->json($reviews);
    }

    public function getReviewsByDiscoteca($id)
    {
        $reviews = reviewModel::where('disco_id', $id)->get();
        return response()->json($reviews);
    }

    public function getReviewsByPuntuacion($puntuacion)
    {
        $reviews = reviewModel::where('puntuacion', $puntuacion)->get();
        return response()->json($reviews);
    }
}
