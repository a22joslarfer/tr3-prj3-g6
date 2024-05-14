<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\categoriasReviewModel;
use Illuminate\Http\Request;

class categoriasReviewController extends Controller
{
    // obtener todas las categorias solo apartado nombre
    public function getCategorias()
    {
        $categorias = categoriasReviewModel::all();
        return response()->json($categorias);
    }
}