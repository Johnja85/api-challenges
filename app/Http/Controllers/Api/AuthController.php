<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Este método es el sistema de autenticación de los usuarios
     * 
     * @param PostRequest $request Request de usuario y clave para autenticar
     * 
     * @version 1.0
     * 
     * @return json Restuesta con token de acceso
     */
    public function login(PostRequest $request){
        $userAuth = $request->only('email', 'password');

        if (Auth::attempt($userAuth)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User logged in successfully',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expiresIn' => 3600
            ], 200);

        }else {
            return $this->invalidResponse('Invalid login Crendentials');

        }
    }
    /**
     * Este método es el sistema de cerrar sesión de los usuarios mediante solicitud token
     * 
     * @param Request $request Request de usuario y clave para cerrar sesión
     * 
     * @version 1.0
     * 
     * @return json
     */
    public function logout(Request $request){

        $user = $request->user();

        if ($user) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => 'User Logged out successfully',
            ]);
        }else{
            return $this->invalidResponse('Invalid token or user not authenticated');
        }
    }
}
