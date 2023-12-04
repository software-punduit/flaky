<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostWithdrawWallet extends FormRequest
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
            'amount' => 'numeric|required|min:0.01|max:1000000'
        ];
    }
}
