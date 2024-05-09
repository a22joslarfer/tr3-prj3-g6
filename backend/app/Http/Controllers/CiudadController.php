<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    /**
     * Muestra una lista de todas las ciudades.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ciudades = Ciudad::all();
        return response()->json($ciudades);
    }

    /**
     * Muestra la ciudad especificada por ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ciudad = Ciudad::find($id);
        if (!$ciudad) {
            return response()->json(['error' => 'Ciudad no encontrada'], 404);
        }
        return response()->json($ciudad);
    }

    // Otros métodos como store(), update(), destroy() según sea necesario
}
