<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRestaurant extends FormRequest
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
            'name' => 'string|required|max:100|unique:restaurants,name',
            'email' => 'email|sometimes|max:100',
            'address' => 'string|required|max:500',
            'phone' => 'string|required|max:20',
            'description' => 'string|required|max:500'
        ];
    }
}
