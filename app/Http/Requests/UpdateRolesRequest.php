<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRolesRequest extends FormRequest
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
            "name" => ['required',
                Rule::unique('roles','name')->ignore($this->route('id'),'id')],
            "description" => ['required'],
            "permissions" => ['required', 'array', Rule::exists('permissions', 'id')],
        ];
    }
}
