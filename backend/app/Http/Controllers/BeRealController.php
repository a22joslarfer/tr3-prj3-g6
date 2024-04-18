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
    public function createBereal(Request $request)
    {
        $request->validate([
            'img_del' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img_tra' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_usuari' => 'required|exists:usuarios,id'
        ]);

        berealModel::create($request->all());        
    }

    public function show($id)
    {
        $bereals = berealModel::findOrFail($id);
        return view('bereals.show', compact('bereals'));
    }
}
