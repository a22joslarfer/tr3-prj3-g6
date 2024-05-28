<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\seguidorModel;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class seguidoresController extends Controller
{

    public function getSeguidores($id)
    {

        $seguidores = seguidorModel::where('seguido', $id)->get('seguidor');


        return $seguidores;
    }

    public function getAmigos($id)
    {

        // Get the ids of the users who are following the given user
        $seguidorIds = seguidorModel::where('seguido', $id)->pluck('seguidor');

        // Get the users who are following the given user and are also being followed by the given user
        $amigos = seguidorModel::where('seguidor', $id)->whereIn('seguido', $seguidorIds)->get('seguido');

        // Get the ids and names of the users with the ids in $amigos
        $users = User::whereIn('id', $amigos)->select('id', 'name', 'profile_photo')->get();

        return response()->json($users);
    }
    



    public function addSeguidor(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'seguidor' => 'required|exists:users,id',
                'seguido' => 'required|exists:users,id',
            ]);

            // Create a new seguidorModel instance
            $seguidor = new seguidorModel();
            $seguidor->seguidor = $request->seguidor;
            $seguidor->seguido = $request->seguido;
            $seguidor->save();

            return $seguidor;
        } catch (\Illuminate\Database\QueryException $e) {
            // Log the error message
            Log::error($e->getMessage());

            // Check if the error is due to a foreign key constraint violation
            if ($e->errorInfo[1] == 1452) {
                return response()->json(['error' => 'One of the users does not exist.'], 500);
            }

            // Return a generic 500 error response
            return response()->json(['error' => 'There was an error while saving the seguidor.'], 500);
        } catch (\Exception $e) {
            // Log the error message
            Log::error($e->getMessage());

            // Return a generic 500 error response
            return response()->json(['error' => 'There was an error while saving the seguidor.'], 500);
        }
    }

//funcion de cuantas personas esta siguiendo el user
    public function countSeguidores($id)
    {
        $seguidos = seguidorModel::where('seguidor', $id)->get('seguido');
        return $seguidos;
    }


    public function checkIfSeguidor($user_id, $friend_id)
    {


        $seguidor = seguidorModel::where('seguidor', $user_id)->where('seguido', $friend_id)->first();
        if ($seguidor) {
            return response()->json(['status' => true, 'message' => 'User is following']);
        } else {
            return response()->json(['status' => false, 'message' => 'User is not following']);
        }
    }
}
