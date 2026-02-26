<?php
namespace App\Http\Requests\Dashboard\Offer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
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
            'name'              => ['required', 'array'],
            'name.en'           => ['required', 'string', 'max:255'],
            'name.ar'           => ['nullable', 'string', 'max:255'],
            'name.it'           => ['nullable', 'string', 'max:255'],
            'name.es'           => ['nullable', 'string', 'max:255'],
            'name.de'           => ['nullable', 'string', 'max:255'],
            'name.ja'           => ['nullable', 'string', 'max:255'],
            'name.zh'           => ['nullable', 'string', 'max:255'],
            'name.ru'           => ['nullable', 'string', 'max:255'],
            'name.fr'           => ['nullable', 'string', 'max:255'],
            'description'       => ['required', 'array'],
            'description.en'    => ['required', 'string', 'max:10000'],
            'description.ar'    => ['nullable', 'string', 'max:10000'],
            'description.it'    => ['nullable', 'string', 'max:10000'],
            'description.es'    => ['nullable', 'string', 'max:10000'],
            'description.de'    => ['nullable', 'string', 'max:10000'],
            'description.ja'    => ['nullable', 'string', 'max:10000'],
            'description.zh'    => ['nullable', 'string', 'max:10000'],
            'description.ru'    => ['nullable', 'string', 'max:10000'],
            'description.fr'    => ['nullable', 'string', 'max:10000'],
            'image'             => ['nullable', 'image'],
            'start_date'        => ['required', 'string'],
            'end_date'          => ['required', 'string'],
            'price'             => ['required', 'string', 'max:255'],
            'is_active'         => ['required', 'boolean'],
            'excursion_ids'     => ['required', 'array'],
            'excursion_ids.*'   => ['integer', 'exists:excursions,id'],
            // 'days'            => ['nullable', 'array'],
            // 'days.*'          => ['array'],
            // 'days.*.*'        => ['integer', 'exists:excursion_days,id'],
            // 'times'           => ['nullable', 'array'],
            // 'times.*'         => ['integer', 'exists:excursion_times,id'],
            'times'             => 'required|array',
            'times.*.from_time' => 'required',
            'times.*.to_time'   => 'required',

        ];
    }
}
