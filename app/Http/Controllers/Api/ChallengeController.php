<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Challenge\PostRequest;
use App\Models\Challenge;
use App\Services\HuggingFaceService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChallengeController extends Controller
{
    private $aiService;
    private $challenge;

    use ApiResponseTrait;


    public function __construct(HuggingFaceService $aiService)
    {
        $this->aiService = $aiService;
        $this->challenge = new Challenge();
    }

    /**
     * Este método optienes todos los challenges mediante solicitud token paginado de 10 en 10
     * 
     * @version 1.0
     * 
     * @return json
     */
    public function index()
    {
        $challenge = $this->challenge->with('user')->paginate(10);

        return $this->successResponse($challenge);
    }

    /**
     * Este método optienes todos los challenges mediante solicitud token paginado de 10 en 10
     * con solicitud de token
     * @param PostRequest $request 
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        $description = $this->aiService->generateContent($request->title);

        if ($description) {
            $challenge = $this->challenge->create([
                'title' => $request->title,
                'description' => $description,
                'difficulty' => 1,
                'user_id' => Auth::user()->id
            ]);

            return $this->createResponse($challenge, 201);
        }

        return $this->errorResponse($description);
    }

    /**
     * Método de consulta challenge en especifico con solicitud de token
     * @param string $id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $challenge = $this->challenge->with('user')->find($id);

        if (!$challenge) {
            
            return $this->notFoundResponse('Challenge do not exist');
        }
        return $this->successResponse($challenge);
    }

    /**
     * Método actualización de challenge especifico con solicitud de token
     * @param PostRequest $request
     * @param string $id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostRequest $request, string $id)
    {
        $challenge = $this->challenge->find($id);

        if ($challenge) {
            if ($request->validated('user_id') == Auth::user()->id) {
                $description = $this->aiService->generateContent($request->title);
                if ($description) {
                    $challenge->update([
                        'title' => $request->validated('title'),
                        'description' => $description,
                        'difficulty' => 1,
                        'user_id' => Auth::user()->id
                    ]);
                        
                    return $this->createResponse($challenge);
                }
            }else {

                return $this->invalidResponse('The challenge does not belong to the authenticated user');
            }

            return $this->errorResponse($challenge);
        }

        return $this->notFoundResponse('Challenge do not found');
    }

    /**
     * Método eliminación de challenge especifico con solicitud de token
     * @param string $id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $challenge = $this->challenge->find($id);

        if ($challenge) {

            if ($challenge->user_id == Auth::user()->id) {
                $challenge->delete();

                return $this->successResponse($challenge);
            }
                
            return $this->invalidResponse('The Challenge does not belong to the authenticated user');
        }

        return $this->notFoundResponse('Challenge do not found');
    }
}
