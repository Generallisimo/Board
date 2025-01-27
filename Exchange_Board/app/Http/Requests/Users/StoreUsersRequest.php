<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
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
            'password'=> ['required', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
            'role'=> 'required | string',
            'details_to'=>['nullable', 'string', 'regex:/^T[a-zA-Z0-9]+/'],
            'percent'=>'nullable',
            'agent_id'=>'nullable | string'
        ];
    }
}
