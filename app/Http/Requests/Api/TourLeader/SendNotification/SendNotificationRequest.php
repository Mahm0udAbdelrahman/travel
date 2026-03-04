<?php

namespace App\Http\Requests\Api\TourLeader\SendNotification;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'   => 'nullable|exists:users,id',
            'user_ids'  => 'nullable|array',
            'user_ids.*'=> 'exists:users,id',

            'title_en'  => 'required|string|max:255',
            'body_en'   => 'required|string|max:100000',
        ];
    }
}
