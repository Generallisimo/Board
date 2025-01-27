<?php

namespace App\Http\Requests\Bot\Personal\Wallet;

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
            'hash_id'=>'required',
            // add request to details_to => ['nullable', 'string', 'regex:/^T[a-zA-Z0-9]+/']
            'details_to'=>'required'
        ];
    }

    public function prepareForValidation()
    {
        // Добавляем параметры маршрута в данные, которые будут валидироваться
        $this->merge([
            'hash_id' => $this->route('hash_id'),
            'details_to' => $this->route('details_to'),
        ]);
    }
}
