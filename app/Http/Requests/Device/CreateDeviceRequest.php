<?php

namespace App\Http\Requests\Device;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateDeviceRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fcm_token' => [
                'required',
                'string',
                'max:255'
            ],
            'platform' => [
                'required',
                'string',
                'in:ios,android,web'
            ],
        ];
    }

    public function getUserId(): string
    {
        return $this->user()->id;
    }

    public function getFcmToken(): string
    {
        return $this->get('fcm_token');
    }

    public function getPlatform(): string
    {
        return $this->get('platform');
    }
}
