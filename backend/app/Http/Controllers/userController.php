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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Crear un nuevo usuario
        $user = new User([
            'name' => $request->input('nombre'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'api_token' => Str::random(60), // Generar un token aleatorio
        ]);
        $user->save();

        return response()->json($user, 201);
    }

    public function show($id)
    {
        // Mostrar un usuario específico
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Actualizar un usuario existente
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
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
       
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'birthday' => $request->input('birthday'),
            'api_token' => Str::random(60), 
        ]);
        $user->save();

        return response()->json($user, 201);
    }


    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (!Auth::attempt($request->only('email', 'password'))) {
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
<<<<<<< HEAD

    public function getUsers($id)
    {
        $user = User::find($id);
        return response()->json($user);
        
    }
    public function getUser($id)
    {
        $user = User::find($id);
        return response()->json($user);
        
    }
}
=======
    public function getUserById($id)
    {
        $user = usuarioModel::find($id);
    
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
>>>>>>> origin/bereal-fotos
