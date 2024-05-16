<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bereal;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


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
            'id_usuari' => 'required|exists:users,id',
            'hora' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $img_del = $request->file('img_del')->store('public/img');
        $img_tra = $request->file('img_tra')->store('public/img');

        // Convert 'hora' into a valid datetime format
        $hora = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['hora'])
            ->setYear(date('Y')) // Set the year to the current year
            ->format('Y-m-d H:i:s');

        $bereal = Bereal::create([
            'img_del' => str_replace('public/', 'storage/', $img_del),
            'img_tra' => str_replace('public/', 'storage/', $img_tra),
            'id_usuari' => $validatedData['id_usuari'],
            'hora' => $hora,
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

    public function update(Request $request, $id)
    {
        
    }
    





    public function delete($id)
    {
        Bereal::destroy($id);
        if (Bereal::find($id) === null) {
            return response()->json();
        }
    }
}
