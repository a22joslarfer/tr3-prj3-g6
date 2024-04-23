<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bereal; 
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
        $validatedData = $request->validate([
            'img_del' => 'required|file',
            'img_tra' => 'required|file',
            'id_usuari' => 'required|exists:usuarios,id'
        ]);

        $img_del = $request->file('img_del')->store('public/img');
        $img_tra = $request->file('img_tra')->store('public/img');

        $bereal = Bereal::create([
          'img_del' => str_replace('public/', 'storage/', $img_del),
          'img_tra' => str_replace('public/', 'storage/', $img_tra),
          'id_usuari' => $validatedData['id_usuari']
      ]);

        return response()->json($bereal, 201);
    }

    public function index()
    {
        $bereals = Bereal::all();
        return response()->json($bereals);
    }

    public function show($id)
    {
        return Bereal::find($id);
    }
}
