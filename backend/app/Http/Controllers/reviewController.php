<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewModel;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;



class reviewController extends Controller
{

    public function createReview(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'usuario_id' => 'required|exists:users,id',
                'disco_id' => 'required',
                'titulo' => 'required',
                'content' => 'required',
                'puntuacion' => 'required|integer|min:1|max:5',
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'categoria' => 'required',
            ]);
    
            // Almacenar la foto y obtener la ruta
            $photoPath = $request->file('photo')->store('public/img');
    
            // Crear la nueva revisión
            $review = ReviewModel::create([
                'photo' => str_replace('public/', 'storage/', $photoPath),
                'usuario_id' => $validatedData['usuario_id'],
                'disco_id' => $validatedData['disco_id'],
                'titulo' => $validatedData['titulo'],
                'content' => $validatedData['content'],
                'puntuacion' => $validatedData['puntuacion'],
                'categoria' => $validatedData['categoria'],
            ]);
    
            return response()->json(['message' => 'Review stored successfully', 'review' => $review], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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