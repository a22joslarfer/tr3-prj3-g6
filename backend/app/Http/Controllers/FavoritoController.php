<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'discoteca_id' => 'required|exists:discotecas,id',
        ]);

        $favorito = Favorito::create($request->all());

        return response()->json($favorito, 201);
    }

    public function destroy($id)
    {
        $favorito = Favorito::findOrFail($id);
        $favorito->delete();

        return response()->json(null, 204);
    }
    //getFavorites
    public function getFavoritos($id)
    {
        $favoritos = Favorito::where('user_id', $id)->get();
        return response()->json($favoritos);
    }
}
