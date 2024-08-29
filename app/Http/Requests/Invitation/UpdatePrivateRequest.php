<?php

namespace App\Http\Requests\Invitation;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrivateRequest extends FormRequest
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
            'surname_id'=>'exists:surnames,id',
            'group_id'=>'exists:groups,id',
            'email' => 'email|unique:invitations,email',
            'additional_email'=>'email',
            'whatsapp_number'=>'numeric|starts_with:+966',
            'send_email'=>'boolean',
            'send_whatsapp'=>'boolean',
            'confirmed_at'=> 'date'
        ];
    }
}
