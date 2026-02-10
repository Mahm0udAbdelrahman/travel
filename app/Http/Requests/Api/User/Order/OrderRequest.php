<?php
namespace App\Http\Requests\Api\User\Order;

use App\Enums\InquiryType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class OrderRequest extends FormRequest
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

            'id'             => 'required',
            'type_model'     => 'required|in:real_estate,event,excursion,offer,additional_service',
            'quantity'       => 'required|integer|min:1',
            'hotel_id'       => 'required|exists:hotels,id',
            'room_number'    => 'required|string|max:255',

             'date' => [
                Rule::requiredIf(
                    in_array(request('type_model'), ['excursion'])
                ),
                'date',
            ],

            'time'           => 'nullable|string|max:255',

              'type' => [
                Rule::requiredIf(request('type_model') === 'additional_service'),
                Rule::when(
                    request('type_model') === 'additional_service',
                    [new Enum(InquiryType::class)]
                ),
            ],

            'notes'          => 'nullable|string',

            'payment_method' => 'nullable|in:card,wallet,cash',

            'time_id' => [
                Rule::requiredIf(request('type_model') === 'excursion'),
                'exists:excursion_times,id'
            ],

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $validator->errors()->first(),
                'type'    => 'error',
                'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
                // 'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
