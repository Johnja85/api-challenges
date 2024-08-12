<?php

namespace App\Services;


use Loffel\LaravelChatgpt\Facades\ChatGPT;
use Illuminate\Support\Facades\Log;
use Nwilging\LaravelChatGpt\Services\ChatGptService;

class OpenAIService
{
    protected $chatGptService;
    
    public function __construct(ChatGptService $chatGptService)
    {
        $this->chatGptService = $chatGptService;
    }
    public function generateChallenge($prompt)
    {
        $response = $this->chatGptService->createChat($prompt);
        Log::info($response);
        return $response;
    }
}