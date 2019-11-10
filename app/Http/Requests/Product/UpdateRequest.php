<?php

namespace App\Http\Requests\Product;

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
        $id = $this->route('product');

        return [
            'name'      => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($id)],
            'price'     => ['required', 'integer', 'min:1'],
            'vendor_id' => ['required', 'integer', Rule::exists('vendors', 'id')],
        ];
    }
}
