<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\discoModel;
use Illuminate\Http\Request;

class discoController extends Controller
{
    //
    // funcion para obtener todas las discotecas

    public function getDiscotecas()
    {
        $discotecas = discoModel::all();
        
        return response()->json($discotecas);
      
    }

    // funcion para obtener una discoteca por id

    public function getDiscoteca($id)
    {
        $discoteca = discoModel::find($id);
        return $discoteca;
    }

    // funcion para crear una discoteca
    // Estos son los campos de una discoteca: ['coordenadas', 'imgUrl', 'minEdad', 'horario', 'nombre_local', 'telefono',];

    public function createDiscoteca(Request $request)
    {
        $discoteca = discoModel::create($request->all());
        return $discoteca;
    }

    // funcion para actualizar una discoteca

    public function updateDiscoteca(Request $request, $id)
    {
        $discoteca = discoModel::find($id);
        $discoteca->update($request->all());
        return $discoteca;
    }

    // funcion para borrar una discoteca



    public function delete($id){
        $discotecas = discoModel::find($id);
        
        if (!$discotecas) {
            return response()->json([
                "status" => 0,
                "msg" => "Discoteca no encontrada",
            ], 404);
        }
    
        $discotecas->delete();
        return response()->json([
            "status" => 1,
            "msg" => "Discoteca eliminada exitosamente",
        ]);
    }

    // funcion para obtener las discotecas por nombre

    public function getDiscotecasByName($nombre_local)
    {
        $discotecas = discoModel::where('nombre_local', 'like', '%' . $nombre_local . '%')->get();
        return $discotecas;
    }

    // funcion para obtener las discotecas por edad

    public function getDiscotecasByAge($minEdad)
    {
        $discotecas = discoModel::where('minEdad', '>=', $minEdad)->get();
        return $discotecas;
    }

    // funcion para obtener las discotecas por horario

    public function getDiscotecasBySchedule($horario)
    {
        $discotecas = discoModel::where('horario', 'like', '%' . $horario . '%')->get();
        return $discotecas;
    }

}