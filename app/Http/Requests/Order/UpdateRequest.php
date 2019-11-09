<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status'       => ['required', 'integer', Rule::in([0, 10, 20])],
            'client_email' => ['required', 'string', 'email', 'max:255'],
            'partner_id'   => ['required', 'integer', Rule::exists('partners', 'id')],
            'delivery_at'  => ['required', 'date'],

            'products'                  => ['required', 'array', 'min:0'],
            'products.*.id'             => ['required', 'integer', Rule::exists('products', 'id')],
            'products.*.price'          => ['required', 'numeric', 'min:1'],
            'products.*.pivot'          => ['required', 'array'],
            'products.*.pivot.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
