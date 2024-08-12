<?php

namespace App\Http\Requests\Video;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'video_url' => ['required', 'min:15', 'string'], 
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'challenge_id' => ['required','integer', 'exists:challenges,id']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    public function messages()
    {
        return [
            'video_url' => 'The video_url field is required.',
            'video_url.required' => 'The video_url description is required.',
            'user_id' => 'The user_id field is required.',
            'user_id.required' => 'The user_id description is required.',
            'user_id.exists' => 'The user do not exist.',
            'user_id.integer' => 'The user must be id',
            'challenge_id' => 'The challenge_id field is required.',
            'challenge_id.required' => 'The challenge_id description is required.',
            'challenge_id.exists' => 'The challenge_id do not exist.',
            'challenge_id.integer' => 'The challenge must be id',
        ];
    }
}
