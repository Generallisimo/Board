<?php

namespace App\Http\Requests\Users\Table;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTableRequest extends FormRequest
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
            'details_from'=> [
                'required', 
                'string',
                'regex:/^T[a-zA-Z0-9]+/',
            ],
            'details_to'=> [
                'required', 
                'string',
                'regex:/^T[a-zA-Z0-9]+/',
            ],
            'percent'=> 'required | string',
            //add validate key from wallet - detail_from
            'private_key'=> 'required | string'
        ];
    }
}
