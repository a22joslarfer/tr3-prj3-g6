<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;


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
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
            'birthday' => 'required|string',
        ]);

        // Actualizar un usuario existente
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone = $request->input('phone');
        $user->birthday = $request->input('birthday');
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

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
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
        // Obtener el usuario autenticado
        $user = User::where('email', $request->input('email'))->firstOrFail();

        // Generar un nuevo token de API
        $user->api_token = Str::random(60);
        $user->save();

        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {

                $token = $user->createToken("auth_token")->plainTextToken;

                //si esta todo bien
                return response()->json([
                    "status" => 1,
                    "msg" => "Usuario logeado  exitosamente",
                    "access_token" => $token,
                    "email" => $user->email,
                    "name" => $user->name,
                    "id" => $user->id,
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
            "data" => $user->name, // Devolver solo el nombre del usuario
        ]);
    }



    public function generateQRCode($userId)
    {
        try {
            // Contenido del código QR con el ID de usuario de A y la URL de redirección
            $qrContent = 'http://localhost:3000/auth/' . $userId;    
            // Generar el código QR con Simple-QRCode
            $qrCode = QrCode::size(200)->generate($qrContent);
    
            // Nombre del archivo
            $fileName = 'qr_code_' . time() . '.svg';
    
            // Ruta de destino para guardar el código QR
            $qrPath = public_path('qr_codes/' . $fileName);
    
            // Guardar el código QR en la carpeta de destino
            File::put($qrPath, $qrCode);
    
            // Devolver la URL del código QR guardado
            return response()->file($qrPath);
        } catch (\Exception $e) {
            // Manejar el error de generación del código QR
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
