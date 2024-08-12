<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class HuggingFaceService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api-inference.huggingface.co/models/',
        ]);
    }

    /**
     * Este método consume el servicio de HuggingFace para la creación de Challenges por IA
     * 
     * @param string $input Parametro para creación del challenge
     * @param string $model Modelo opcional para el tipo de petición a HuggingFace
     * @version 1.0
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateContent(string $input, string $model = 'distilgpt2')
    {
        try {
            $response = $this->client->post($model, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'inputs' => $input,
                ],
            ]);
    
            $body = json_decode($response->getBody()->getContents(), true);

            if (isset($body[0]['generated_text'])) {
                return $body[0]['generated_text'];
            } else {
                throw new \Exception('Key "generated_text" not found in response.');
            }
        } catch (\Exception $e) {
            Log::error('Error al llamar a AI: '. $e->getMessage());

            return response()->json(['error' => 'Error processing request']);
        }
    }
}