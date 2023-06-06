<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PutRestaurant extends FormRequest
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
        $restaurant = $this->route('restaurant');
        return [
            'active' => 'sometimes|boolean',
            'name' => [
                'string',
                'sometimes',
                'max:50',
               Rule::unique('restaurants', 'name')->ignore($restaurant->id)
            ],
            'phone' => 'string|sometimes|max:20',
            'address' => 'string|sometimes|max:500',
            'email' => 'email|sometimes|max:100',
            'description' => 'string|sometimes|max:500',
        ];
    }
}
