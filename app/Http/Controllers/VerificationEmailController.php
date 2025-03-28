<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VerificationEmailController extends Controller
{
    /**
     * Verifica el código de verificación del correo electrónico.
     *
     * @param string $code
     * @return JsonResponse
     */
    public function verify(string $code): JsonResponse
    {
        try {
            $user = User::whereHas('emailVerification', function ($query) use ($code) {
                $query->where('code', $code);
            })->first();

            if (!$user) {
                return response()->json(['message' => 'Código de verificación inválido.'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (!$user->verifyEmail($code)) {
                return response()->json(['message' => 'Error al verificar el correo electrónico.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json(['message' => 'Correo electrónico verificado con éxito.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Reenvía el código de verificación del correo electrónico.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resend(Request $request): JsonResponse
    {
        try {
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado.'], Response::HTTP_NOT_FOUND);
            }

            if (!$user->emailVerification) {

                $user->sendEmailVerificationNotification();
            }

            // Enviar la notificación del correo electrónico
            $user->sendEmailVerificationNotification();

            return response()->json(['message' => 'Código de verificación reenviado con éxito.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno del servidor.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
