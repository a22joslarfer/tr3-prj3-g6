<?php

namespace App\Http\Controllers;

use App\Models\categoriasReviewModel;
use Illuminate\Http\Request;

class categoriasReviewController extends Controller
{
    // Obtener todas las categorias
    public function index()
    {
        $categorias = categoriasReviewModel::all();
        return response()->json($categorias);
    }

    // Crear una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
        ]);

        $categoria = categoriasReviewModel::create($request->all());

        return response()->json(['message' => 'Categoría creada exitosamente', 'categoria' => $categoria], 201);
    }

    // Mostrar una categoría específica
    public function show($id)
    {
        $categoria = categoriasReviewModel::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }
        return response()->json($categoria);
    }

    // Actualizar una categoría existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
        ]);

        $categoria = categoriasReviewModel::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $categoria->update($request->all());

        return response()->json(['message' => 'Categoría actualizada exitosamente', 'categoria' => $categoria]);
    }

    // Eliminar una categoría
    public function destroy($id)
    {
        $categoria = categoriasReviewModel::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada exitosamente']);
    }


    public function getCategorias()
    {
        $categorias = categoriasReviewModel::all();
        return response()->json($categorias);
    }
}
