<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inTime;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class inTimesController extends Controller
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
        ]);

        $img_del = $request->file('img_del')->store('public/img');
        $img_tra = $request->file('img_tra')->store('public/img');

       

        $bereal = inTime::create([
            'img_del' => str_replace('public/', 'storage/', $img_del),
            'img_tra' => str_replace('public/', 'storage/', $img_tra),
            'id_usuari' => $validatedData['id_usuari'],
        ]);

        return response()->json($bereal, 201);
    }

    public function index()
    {
        $bereals = inTime::all();
        return response()->json($bereals);
    }

    public function show($id)
    {
        return inTime::find($id);
    }

    public function addlike($id){
        $bereal = inTime::find($id);
        $likes = $bereal->likes;
        $bereal->likes = $likes + 1;
    }

    public function addDislike($id){
        $bereal = inTime::find($id);
        $likes = $bereal->likes;
        $bereal->likes = $likes - 1;
    }
    





    public function delete($id)
    {
        inTime::destroy($id);
        if (inTime::find($id) === null) {
            return response()->json();
        }
    }
}
