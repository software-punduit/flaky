<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class PostProfile extends FormRequest
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
        $user  = Auth::user();
        return [
            'name' => ['string', 'required', 'max:100'],
            'email' => ['email', 'required', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'address' => ['nullable', 'string', 'max:252'],
            'phone' => ['nullable', 'string', 'max:25'],
            'photo' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],




        ];
    }
}
