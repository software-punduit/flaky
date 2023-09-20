<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostOrder extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_quantities.*' => [
                'required', 
                'numeric',
                'min:0'
            ],

            'product_ids.*' => [
                'required',
                'exists:menus,id'
            ],

            'restaurant_id' => [
                'required',
                'exists:restaurants,id'
            ]

        ];
    }
}
