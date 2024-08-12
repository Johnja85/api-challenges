<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PutRequest;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponseTrait;
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Este método optienes todos los usuarios mediante solicitud token paginado de 10 en 10
     * con solicitud de token
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->user->paginate(10);

        return $this->successResponse($users);

    }

    /**
     * Método para crear usuarios 
     * @param StoreRequest $request
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'image_path' => '',
            'password' => bcrypt($request->password),
        ]);

        return $this->createResponse($user, 'User Created Successfully');
    }

    /**
     * Método de consulta usuario en especifico con solicitud de token
     * @param string $id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $user = $this->user->find($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        return $this->successResponse($user, 'User found');

    }

    /**
     * Método actualización de usuario especifico con solicitud de token
     * @param PutRequest $request
     * @param string $id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PutRequest $request, string $id)
    {
        $user = $this->user->find($id);

        if ($user) {
            if ($user->id == Auth::user()->id) {
                $user->update([
                    'name' => $request->validated('name'),
                    'email' => $request->validated('email'),
                    'image_path' => $request->validated('image_path'),
                    'password' => bcrypt($request->validated('password')),
                ]);
                    
                return $this->createResponse($user);
            }else{

                return $this->invalidResponse('The user does not belong to the authenticated user');
            }
        }

        return $this->notFoundResponse('user do not found');
    }
}
