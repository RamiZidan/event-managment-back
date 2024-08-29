<?php

namespace App\Http\Requests\Invitation;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'surname_id'=>'required|exists:surnames,id',
            'full_name'=>'required',
            'phone_number'=>'required|numeric|starts_with:+966',
            'email' => 'required|email|unique:invitations,email',
            'party' => 'required',
            'position' =>'required'
        ];
    }
}
