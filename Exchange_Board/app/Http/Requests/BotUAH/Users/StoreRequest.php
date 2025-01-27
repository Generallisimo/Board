<?php

namespace App\Http\Requests\BotUAH\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hash_id' => 'required | string | unique:users,hash_id',
            // 'password'=> ['required', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
            'password'=> 'nullable',
            'role'=> 'required | string',
            // 'details_to'=>['nullable', 'string', 'regex:/^T[a-zA-Z0-9]+/'],
            'details_to'=>'nullable',
            'percent'=>'nullable',
            'agent_id'=>'nullable'
        ];
    }

    
    public function prepareForValidation(){
        $this->merge([
            'hash_id'=>$this->route('hash_id'),
            'password'=>$this->route('password'),
            'role'=>$this->route('role'),
            'details_to'=>$this->route('details_to'),
            'percent'=>$this->route('percent'),
            'agent_id'=>$this->route('agent_id')
        ]);
    }
}
