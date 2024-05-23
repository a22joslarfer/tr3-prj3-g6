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
            'id_usuari' => 'required',
            'autor' => 'required'
        ]);

        $comentario = Comentario::create([
            'comentario' => $request->comentario,
            'id_bereal' => $request->id_bereal,
            'id_usuari' => $request->id_usuari,
            'autor' => $request->autor
        ]);

        return response()->json(['message' => 'Comentario creado exitosamente', 'comentario' => $comentario], 201);
    }

    public function like($id)
{
    $comentario = Comentario::find($id);
    
    if (!$comentario) {
        return response()->json(['message' => 'Comentario no encontrado'], 404);
    }

    $comentario->likes++; 
    $comentario->save();

    return response()->json(['message' => 'Me gusta registrado exitosamente', 'comentario' => $comentario]);
}

    public function show($id)
    {
        $comentario = Comentario::find($id);
        return response()->json($comentario);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required',
            'id_bereal' => 'required|exists:bereal,id',
            'id_usuari' => 'required'
        ]);

        $comentario = Comentario::find($id);
        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        $comentario->comentario = $request->comentario;
        $comentario->id_bereal = $request->id_bereal;
        $comentario->id_usuari = $request->id_usuari;
        $comentario->save();

        return response()->json(['message' => 'Comentario actualizado exitosamente']);
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
