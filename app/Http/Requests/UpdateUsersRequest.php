<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $phone_number
 * @property mixed $role
 * @property mixed $email
 */
class UpdateUsersRequest extends FormRequest
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
            'role' => ['required'],
            'phone_number' => ['required', 'between:10,15', Rule::unique('users', 'phoneNumber')
                ->ignore($this->route('id'), 'id')],
            'email' => ['required', Rule::unique('users', 'email')
                ->ignore($this->route('id'), 'id')],
        ];
    }
}
