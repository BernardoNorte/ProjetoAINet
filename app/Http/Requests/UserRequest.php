<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required',
            //[
                //'required',
                //'email',
                //Rule::unique('users', 'email')->ignore($this->user_id),
            //],
            'user_type' => 'required|in:C,E,A',
            'blocked' => 'required:boolean',
            'photo_url' => 'nullable',
            'password_incial' => 'sometimes|required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            //'email.unique' => 'O email tem de ser unico',
            'email.email' => 'O formato do email é inválido',
            'user_type.required' => 'O tipo de utilizador é obrigatório',
            'user_type.in' => 'O tipo de utilizador tem que ser C,E ou A',
            'blocked.required' => 'O campo blocked é obrigatório',
            'blocked.boolean' => 'O campo blocked tem que ser booleano',
            'password_inicial.required' => 'A password inicial é obrigatória',
        ];
    }

}
