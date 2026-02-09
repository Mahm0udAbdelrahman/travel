<?php
namespace App\Http\Requests\Dashboard\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
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
            'name'      => ['required', 'array'],
            'name.en'   => ['required', 'string', 'max:255'],
            'name.ar'   => ['nullable', 'string', 'max:255'],
            'name.it'   => ['nullable', 'string', 'max:255'],
            'name.es'   => ['nullable', 'string', 'max:255'],
            'name.de'   => ['nullable', 'string', 'max:255'],
            'name.ja'   => ['nullable', 'string', 'max:255'],
            'name.zh'   => ['nullable', 'string', 'max:255'],
            'name.ru'   => ['nullable', 'string', 'max:255'],
            'name.fr'   => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],

            'tour_leader_ids'  => 'nullable|array|min:1',

        ];
    }

}
