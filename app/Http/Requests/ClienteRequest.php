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
            'email' => 'required',
            'id' => 'required',
            'nif' => 'nullable|digits:9',
            'address' => 'nullable',
            'default_payment_type' => 'nullable|in:MC,PAYPAL,VISA',
            'default_payment_ref' => 'nullable',
            'photo_url' => 'sometimes|image|max:8192',
            'password_inicial' => 'sometimes|required',
            'bloqueado' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>  'O nome é obrigatório',
            'id.required' => 'O id é obrigatório',
            'id.unique' => 'O id é único',
            'email.required' => 'O email é obrigatório',
            'email.email' =>    'O formato do email é inválido',
            'email.unique' =>   'O email tem que ser único',
            'nif.integer' =>    'O nif tem que ser inteiro',
            'nif.unique' => 'O nif tem que ser unico',
            'default_payment_type.in' => 'O tipo de pagamento tem de ser MC, Paypal, Visa',
            'default_payment_ref.char' => 'A referência de pagamento tem de ser com caracteres',
            'photo_url.image' => 'O ficheiro com a foto não é uma imagem',
            'photo_url.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 8 Mb',
            'password_inicial.required' => 'A password inicial é obrigatória',
        ];
    }
}
