<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientePost extends FormRequest
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
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'nif' => 'required|digits:9',
            'endereco' => 'required',
            'tipo_pagamento' => 'required|in:MC,PAYPAL,VISA',
            'ref_pagamento' => 'required',
            'foto_url' => 'nullable|image|max:8192',
            'bloqueado' => 'required|boolean'
        ];
    }
}
