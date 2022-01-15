<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

/**
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $phone_number
 * @property mixed $email
 * @property mixed $password
 */
class RegistrationRequest extends FormRequest
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
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['required', 'unique:users,phoneNumber', 'between:10,15'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:6'],
        ];
    }
}
