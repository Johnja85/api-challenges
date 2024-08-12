<?php

namespace App\Traits;


trait ApiResponseTrait
{
    /**
     * Método para respuestra satisfactoria status 200
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data= [], $message = 'Success')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ],200);
    }

    /**
     * Método para respuestra creación status 201
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function createResponse($data= [], $message = 'Success')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ],201);
    }

    /**
     * Retorna con estado error status 500.
     *
     * @param  string $message
     * @param  array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($errors= [], $message = 'Internal Server Error')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $errors
        ],500);
    }

    /**
     * Retorna no fue encontardo el registro status 404.
     *
     * @param  string $message 
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFoundResponse($message = 'Not Found')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ],404);
    }

    /**
     * Retorna cuando las credeales son invalidas status 401.
     *
     * @param  string $message 
     * @return \Illuminate\Http\JsonResponse
     */
    public function invalidResponse($message = 'Invalid Credentials')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ],401);
    }
}