<?php
namespace App\Http\Requests\Dashboard\Offer;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
            'name'           => ['required', 'array'],
            'name.en'        => ['required', 'string', 'max:255'],
            'name.ar'        => ['nullable', 'string', 'max:255'],
            'name.it'        => ['nullable', 'string', 'max:255'],
            'name.es'        => ['nullable', 'string', 'max:255'],
            'name.de'        => ['nullable', 'string', 'max:255'],
            'name.ja'        => ['nullable', 'string', 'max:255'],
            'name.zh'        => ['nullable', 'string', 'max:255'],
            'name.ru'        => ['nullable', 'string', 'max:255'],
            'name.fr'        => ['nullable', 'string', 'max:255'],
            'description'    => ['required', 'array'],
            'description.en' => ['required', 'string', 'max:255'],
            'description.ar' => ['nullable', 'string', 'max:255'],
            'description.it' => ['nullable', 'string', 'max:255'],
            'description.es' => ['nullable', 'string', 'max:255'],
            'description.de' => ['nullable', 'string', 'max:255'],
            'description.ja' => ['nullable', 'string', 'max:255'],
            'description.zh' => ['nullable', 'string', 'max:255'],
            'description.ru' => ['nullable', 'string', 'max:255'],
            'description.fr' => ['nullable', 'string', 'max:255'],
            'image'          => ['nullable', 'image'],
            'start_date'     => ['required', 'string'],
            'end_date'       => ['required', 'string'],
            'price'          => ['required', 'string', 'max:255'],
            'is_active'      => ['required', 'boolean'],
            'excursion_ids'  => 'required|array|min:1',
        ];
    }

}
