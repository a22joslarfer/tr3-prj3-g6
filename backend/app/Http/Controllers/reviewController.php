<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reviewModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\File;

class reviewController extends Controller
{

    public function createReview(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|integer',
            'disco_id' => 'required|integer',
            'titulo' => 'required|string|max:255',
            'content' => 'required|string',
            'puntuacion' => 'required|integer|min:1|max:5',
            'categoria' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $photo = $request->file->store('public/img');

            $review = new ReviewModel;
            $review->usuario_id = $request->usuario_id;
            $review->disco_id = $request->disco_id;
            $review->titulo = $request->titulo;
            $review->content = $request->content;
            $review->puntuacion = $request->puntuacion;
            $review->categoria = $request->categoria;

            // Guardar la imagen en el sistema de archivos
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public', $imageName);
                $review->photo = $imageName;
            }

            $review->save();

            return response()->json($review);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred while creating the review.'], 500);

        }
    }

    public function getFotos($id)
    {
        $review = reviewModel::find($id);
        $photo = $review->photo;
        return Storage::url("public/photos/{$photo}");
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