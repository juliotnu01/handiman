<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ExternalLoginController extends Controller
{
    public function verify(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->with(['basicInformation', 'certifications', 'paymentMethods'])->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return response()->json(["valid" => true, "user" => $user]);
            }
            return response(400)->json(["valid" => false, "user" => null]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function register(Request $request)
    {
        try {
            // Validar los datos de entrada con mensajes personalizados en español
            $request->validate([
                'email' => 'required|email|unique:users,email',
                'mode' => 'required|in:cliente,admin', // Puedes ajustar los valores permitidos
                'name' => 'required|string|max:255',
                'password' => 'required|confirmed|min:8', // password_confirmation se valida automáticamente
            ], [
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico debe ser una dirección válida.',
                'email.unique' => 'El correo electrónico ya está registrado.',
                'mode.required' => 'El modo es obligatorio.',
                'mode.in' => 'El modo debe ser cliente o admin.',
                'name.required' => 'El nombre es obligatorio.',
                'name.string' => 'El nombre debe ser una cadena de texto.',
                'name.max' => 'El nombre no puede tener más de 255 caracteres.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.confirmed' => 'La confirmación de la contraseña no coincide.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            ]);

            // Crear el usuario
            $user = User::create([
                'email' => $request->email,
                'mode' => $request->mode === 'cliente' ? 1 : 0,
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);

            // Retornar respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado exitosamente.',
                'user' => $user,
                "valid" => true,
            ], 201);
        } catch (\Throwable $th) {
            // Manejar errores
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el usuario.',
                'error' => $th->getMessage(),
            ], 200);
        }
    }
}
