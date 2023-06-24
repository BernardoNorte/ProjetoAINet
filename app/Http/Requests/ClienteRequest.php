<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
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
                Rule::unique('users', 'email')->ignore($this->email, 'email')
            ],
            'nif' => 'nullable|digits:9',
            'address' => 'nullable',
            'default_payment_type' => 'nullable|in:MC,PAYPAL,VISA',
            'default_payment_ref' => 'nullable',
            'file_foto' => 'nullable|image|max:8192',
            'password_inicial' => 'sometimes|required',
            'blocked' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>  'The name is required',
            'email.required' => 'The email is required',
            'email.email' =>    'Not valid email format',
            'email.unique' =>   'Email must be unique',
            'nif.integer' =>    'NIF has to be an integer',
            'nif.unique' => 'NIF has to be unique',
            'default_payment_type.in' => 'Pyament type has to be MC, Paypal, Visa',
            'file_foto.image' => 'The file with the photo is not an image',
            'file_foto.size' => 'File size must be lower than 8 Mb',
            'password_inicial.required' => 'Initial password is required',
        ];
    }
}
