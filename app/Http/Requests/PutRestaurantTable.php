<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PutRestaurantTable extends FormRequest
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
        $restaurantTable = $this->route('restaurant_table');
        return [
            'active' => 'sometimes|boolean',
            'name' => [
                'sometimes',
                'string',
                'max:100',
                Rule::unique('restaurant_tables', 'name')->ignore($restaurantTable->id),
            ],
            'reservation_fee' => 'numeric|min:0|sometimes',
            'restaurant_id' => 'sometimes|exists:restaurants,id',
            'photo' => 'sometimes|mimes:png,jpg,jpeg|max:1024'
        ];
         
    }
}
