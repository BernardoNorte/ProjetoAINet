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
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'nif' => 'required|digits:9',
            'endereco' => 'required',
            'tipo_pagamento' => 'required|in:MC,PAYPAL,VISA',
            'ref_pagamento' => 'required',
            'foto_url' => 'nullable|image|max:8192',
            'password_inicial' => 'sometimes|required',
            'bloqueado' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>  'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' =>    'O formato do email é inválido',
            'email.unique' =>   'O email tem que ser único',
            'nif.required' =>   'O nif é obrigatório',
            'nif.integer' =>    'O nif tem que ser inteiro',
            'tipo_pagamento.required' => 'O tipo de pagamento é obrigatório',
            'tipo_pagamento.in' => 'O tipo de pagamento tem de ser MC, Paypal, Visa',
            'ref_pagamento.required' => 'A referência de pagamento é obrigatória',
            'ref_pagamento.char' => 'A referência de pagamento tem de ser com caracteres',
            'file_foto.image' => 'O ficheiro com a foto não é uma imagem',
            'file_foto.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 8 Mb',
            'password_inicial.required' => 'A password inicial é obrigatória',
        ];
    }
}
