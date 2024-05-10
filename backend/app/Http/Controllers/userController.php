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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string', // Añadido
            'birthday' => 'nullable|date', // Añadido
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Asegúrate de agregar la validación de la imagen aquí
        ]);

        // Procesar y almacenar la imagen de perfil
        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            // Obtener el nombre del archivo
            $fileName = $request->file('profile_photo')->getClientOriginalName();

            // Mover la imagen a la carpeta profile en el directorio public
            $request->file('profile_photo')->move(public_path('profile'), $fileName);

            // Almacenar la ruta relativa de la imagen en la base de datos
            $profilePhotoPath = 'profile/' . $fileName;
        }

        // Crear un nuevo usuario
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'birthday' => $request->input('birthday'),
            'api_token' => Str::random(60),
            'profile_photo' => $profilePhotoPath, // Almacenar la ruta relativa de la imagen en la base de datos
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
            'new_password' => 'nullable|string|min:8',
            'phone' => 'required|string',
            'birthday' => 'required|string',
            'old_password' => 'required|string', // Nuevo campo para la contraseña anterior
        ]);

        // Obtener el usuario existente
        $user = User::findOrFail($id);

        // Verificar si la contraseña anterior coincide
        if (Hash::check($request->input('old_password'), $user->password)) {
            // La contraseña anterior coincide, procede a actualizar el usuario
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->filled('new_password')) {
                // Si se proporciona una nueva contraseña, actualiza la contraseña
                $user->password = Hash::make($request->input('new_password'));
            }
            $user->phone = $request->input('phone');
            $user->birthday = $request->input('birthday');
            $user->save();

            return response()->json($user);
        } else {
            // La contraseña anterior no coincide, devuelve un error
            return response()->json(['error' => 'La contraseña anterior no es válida'], 400);
        }
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
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255',
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Asegúrate de agregar la validación de la imagen aquí
        ]);
    
        // Crear una nueva instancia de usuario con los datos validados
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone' => $validatedData['phone'],
            'birthday' => $validatedData['birthday'],
            'api_token' => Str::random(60),
        ]);
    
        // Guardar la imagen en el sistema de archivos
        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('profile_photos'), $imageName);
            $user->profile_photo = $imageName;
        }
    
        // Guardar el usuario en la base de datos
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

                $token = $user->createToken("api_token")->plainTextToken;

                return response()->json([
                    "status" => 1,
                    "msg" => "Usuario logeado  exitosamente",
                    "access_token" => $token,
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
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
            $qrContent = 'http://elysium.daw.inspedralbes.cat/auth/' . $userId;
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



    // return profile_photo from user
    public function getProfilePhoto($id)
    {
        $user = User::find($id);
        if ($user) {
            // Construir la URL completa de la imagen de perfil
            $profilePhotoUrl = url($user->profile_photo);
            return response()->json($profilePhotoUrl);
        }
        return response()->json(['error' => 'User not found'], 404);
    }
    public function getFollowers($id)
    {
        $user = User::find($id);

        if ($user) {
            $followersCount = $user->seguidores;
            return response()->json(['seguidores' => $followersCount]);
        }

        return response()->json(['error' => 'User not found'], 404);
    }
}
