<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\berealModel; 

class BeRealController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'img_del' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_tra' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_usuari' => 'required|exists:usuarios,id'
        ]);

        // Crear un nuevo registro en la base de datos
        berealModel::create($request->all());

        // Redirigir a alguna parte (por ejemplo, a la lista de beReals)
        return redirect()->route('bereals.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bereals = berealModel::findOrFail($id);

        return view('bereals.show', compact('bereals'));
    }
}
