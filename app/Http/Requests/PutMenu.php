<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutMenu extends FormRequest
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
            'name' => 'sometimes|string|max:100',
            'restaurant_id' => 'sometimes|exists:restaurants,id',
            'price' => 'sometimes|numeric|min:0',
            'photo' => 'sometimes|mimes:png,jpg,jpeg|max:1024',
            'active' => 'sometimes|boolean'
        ];
    }
}
