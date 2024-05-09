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
        ]);        return response()->json($user);

    }    



    
  public function generateQRCode(User $user)
{
    try {
      
        // Generar el contenido para el código QR (puede ser dinámico) llevar a http://localhost:3000/
        $qrContent = 'http://viaegis.daw.inspedralbes.cat/';

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

