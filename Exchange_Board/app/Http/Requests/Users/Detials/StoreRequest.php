<?php

namespace App\Http\Requests\Users\Detials;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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
            'hash_id' =>'required | string',
            // add validete on phone or card more
            'details_market_to' =>[
                'required', 
                'string', 
                'min:10', 
                'max:16',
                Rule::unique('add_market_details')->where(function($query){
                    return $query->where('hash_id', $this->hash_id);
                })
            ],
            'name_method' =>'required | string',
            'comment' =>'required | string',
        ];
    }
}
