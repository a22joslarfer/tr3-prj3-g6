<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Mostrar todos los usuarios
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required',
            'password2' => 'required|same:password',
            'phone' => 'required',
            'birthdate' => 'required',
        ]);

        $user = new User();
        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                "status" => 0,
                "msg" => "Usuario no encontrado",
            ], 404);
        }

        $user->delete();
        return response()->json([
            "status" => 1,
            "msg" => "Usuario eliminado exitosamente",
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json($user);
    }

    public function destroy($id)
    {
        // Eliminar un usuario
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }


    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password2' => 'required|same:password',
            'phone' => 'required',
            'birthdate' => 'required',
        ]);

        $user = new User();
        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json($user, 201);
    }


    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'

        ]);
        $user = User::where("email", "=", $request->email)->first();

        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {

                $token = $user->createToken("auth_token")->plainTextToken;

                //si esta todo bien
                return response()->json([
                    "status" => 1,
                    "msg" => "Usuario logeado  exitosamente",
                    "access_token" => $token

                ]);
            } else {
                return response()->json([
                    "status" => 0,
                    "msg" => "La password es incorrecta",

                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Obtener el usuario autenticado
        $user = User::where('email', $request->input('email'))->firstOrFail();

        // Generar un nuevo token de API
        $user->api_token = Str::random(60);
        $user->save();

        return response()->json($user);
    }

    public function logout(Request $request)
    {
        // Obtener el usuario autenticado
        $user = $request->user();

        // Eliminar el token de API del usuario
        $user->api_token = null;
        $user->save();

        return response()->json(['message' => 'Logged out']);
    }



    public function getUsers($id)
    {
        $user = User::find($id);
        return response()->json($user);
        
    }
  
   
    public function getUserById($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                "status" => 0,
                "msg" => "Usuario no encontrado",
            ], 404);
        }
    
        return response()->json([
            "status" => 1,
            "msg" => "Nombre del usuario",
            "data" => $user->nombre, // Devolver solo el nombre del usuario
        ]);
    }    

}

