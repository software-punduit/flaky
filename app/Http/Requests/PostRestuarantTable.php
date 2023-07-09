<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRestuarantTable extends FormRequest
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
            'name' => 'string|required|max:100|unique:restaurant_tables,name',
            'reservation_fee' => 'numeric|required|min:0',
            'photo' => ['required','mimes:png,jpg,jpeg', 'max:1024'],
            'restaurant_id' => 'numeric|exists:restaurants,id',
        ];
    }
}
