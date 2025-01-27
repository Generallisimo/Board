<?php

namespace App\Http\Requests\Bot\Personal\Details\Card;

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
            'hash_id' =>'required',
            // add validete on phone or card more
            'details_market_to' =>[
                'required',
                Rule::unique('add_market_details')->where(function($query){
                    return $query->where('hash_id', $this->hash_id);
                })
            ],
            'name_method' =>'required',
            'comment' =>'required',
        ];
    }

    public function prepareForValidation(){
        $this->merge([
            'hash_id'=>$this->route('hash_id'),
            'details_market_to'=>$this->route('details_market_to'),
            'name_method'=>$this->route('name_method'),
            'comment'=>$this->route('comment'),
        ]);
    }
}
