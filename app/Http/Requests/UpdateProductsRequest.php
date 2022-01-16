<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $name
 * @property mixed $description
 * @property mixed $type
 * @property mixed $category
 * @property mixed $price
 * @property mixed $quantity
 * @property mixed $manufacturer
 * @property mixed $distributor
 */
class UpdateProductsRequest extends FormRequest
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
            'name' => ['required', Rule::unique('products','name')
                ->ignore($this->route('id'), 'id')],
            'description' => ['required'],
            'type' => ['required'],
            'category' => ['required'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'manufacturer' => ['required'],
            'distributor' => ['required'],
        ];
    }
}
