<?php

namespace App\Http\Requests\Api\User\Register;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|string|unique:users,phone',
            'image'     => 'nullable|image',
            'password'  => 'required|string|min:8|confirmed',
            'fcm_token' => 'required|string',
            'type'      => ['required', new Enum(\App\Enums\UserType::class)],
            'arrival_date' => 'required|string|max:255',
            'departure_date' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'hotel_id' => 'required|exists:hotels,id',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $validator->errors()->first(),
                'type'    => 'error',
                'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
    // 'errors' => $validator->errors(),
}
