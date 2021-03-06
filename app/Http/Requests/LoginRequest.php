<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

/**
 * @property mixed $email
 * @property mixed $password
 */
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'email' => ['exists:users','email', 'required'],
            'password' => ['required', 'min:6'],
        ];
    }
}
