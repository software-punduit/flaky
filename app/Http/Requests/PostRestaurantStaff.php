<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRestaurantStaff extends FormRequest
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
            'name' => 'string|required|max:100',
            'email'=> 'email|required|max:100|unique:users,email',
            'password' => 'string|required|max:100|min:8',
            'restaurant_id' => 'numeric|required|exists:restaurant,id'
        ];
    }
}
