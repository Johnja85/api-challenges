<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Video\PostRequest;
use App\Models\Video;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    private $video;

    use ApiResponseTrait;

    public function __construct()
    {
        $this->video = new Video();
    }

    /**
     * Este método optienes todos los videos mediante solicitud token paginado de 10 en 10 con solicitud de token
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $video = $this->video->with('challenge')->paginate(10);

        return $this->successResponse($video);
    }

    /**
     * Método para crear videos con solicitud de token 
     * @param PostRequest $request
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        $video = $this->video->create($request->all());
        if($video){

            return $this->createResponse($video, 201);
        }

        return $this->errorResponse($video); 
    }

    /**
     * Método de consulta video en especifico con solicitud de token
     * @param string $id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $video = $this->video->with('challenge')->find($id);

        if (!$video) {
            
            return $this->notFoundResponse('Video do not exist');
        }
        return $this->successResponse($video);
    }

    /**
     * Método actualización de video especifico con solicitud de token
     * @param PostRequest $request
     * @param string $id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostRequest $request, string $id)
    {
        $video = $this->video->find($id);
        if ($video) {
            if ($request->validated('user_id') == Auth::user()->id) {
                $video->update([
                    'video_url' => $request->validated('video_url'),
                    'user_id' => $request->validated('user_id'),
                    'challenge_id' => $request->validated('challenge_id'),
                ]);
                    
                return $this->createResponse($video);
            }else{

                return $this->invalidResponse('The video does not belong to the authenticated user');
            }
        }

        return $this->notFoundResponse('Video do not found');
    }

    /**
     * Método eliminación de video especifico con solicitud de token
     * @param string $id
     * @version 1.0
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $video = $this->video->find($id);
        if ($video) {

            if ($video->user_id == Auth::user()->id) {
                $video->delete();

                return $this->successResponse($video);
            }
                
            return $this->invalidResponse('The Video does not belong to the authenticated user');
        }

        return $this->notFoundResponse('Video do not found');
    }
}
