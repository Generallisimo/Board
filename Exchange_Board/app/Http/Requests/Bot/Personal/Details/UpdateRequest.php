<?php

namespace App\Http\Requests\Bot\Personal\Details;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'id' => 'required',
            'detail_id'=>'required'
        ];
    }

    public function prepareForValidation(){
        $this->merge([
            'id'=>$this->route('id'),
            'detail_id'=>$this->route('detail_id'),
        ]);
    }
}
