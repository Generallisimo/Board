<?php

namespace App\Http\Requests\Exchanges;

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
            'client_id' => 'required',
            'market_id' => 'required',
            'agent_id' => 'required',
            'amount' => 'required',
            'amount_users' =>'required',
            'percent_client' => 'required',
            'percent_market' => 'required',
            'percent_agent' => 'required',
            'method' => 'required',
            'currency' => 'required',
            'details_market_payment' =>'required',
            'result_client' =>'required',
            'amount_client' =>'required',
            'amount_market' =>'required',
            'amount_agent' =>'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'callback'=>'required'
        ];
    }
}
