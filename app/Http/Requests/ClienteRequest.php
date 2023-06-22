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
            'name.required' =>  'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' =>    'O formato do email é inválido',
            'email.unique' =>   'O email tem que ser único',
            'nif.integer' =>    'O nif tem que ser inteiro',
            'nif.unique' => 'O nif tem que ser unico',
            'default_payment_type.in' => 'O tipo de pagamento tem de ser MC, Paypal, Visa',
            'file_foto.image' => 'O ficheiro com a foto não é uma imagem',
            'file_foto.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 8 Mb',
            'password_inicial.required' => 'A password inicial é obrigatória',
        ];
    }
}
