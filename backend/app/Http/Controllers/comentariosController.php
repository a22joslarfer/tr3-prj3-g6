<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;

class comentariosController extends Controller
{
    public function index($id_bereal)
    {
        $comentarios = Comentario::where('id_bereal', $id_bereal)->get();
        return response()->json($comentarios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'comentario' => 'required',
            'id_bereal' => 'required|exists:bereal,id',
            'id_usuari' => 'required'
        ]);

        $comentario = new Comentario();
        $comentario->comentario = $request->comentario;
        $comentario->id_bereal = $request->id_bereal;
        $comentario->id_usuari = $request->id_usuari;
        $comentario->save();

        return response()->json(['message' => 'Comentari creat'], 201);
    }

    public function show($id)
    {
        $comentario = Comentario::find($id);
        return response()->json($comentario);
    }

    public function destroy($id)
    {
        $comentario = Comentario::find($id);
        $comentario->delete();

        return response()->json(['message' => 'Comentario eliminado exitosamente']);
    }

    public function indexComentarios()
    {
        $comentarios = Comentario::all();
        return response()->json($comentarios);
    }
}
