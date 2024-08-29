<?php

namespace App\Http\Requests\Invitation;

use Illuminate\Foundation\Http\FormRequest;

class StorePrivateRequest extends FormRequest
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
            'formal_title' => 'required',
            'surname_id'=>'required|exists:surnames,id',
            'group_id'=>'required|exists:groups,id',
            'full_name'=>'required',
            'email' => 'required|email|unique:invitations,email',
            'additional_email'=>'email',
            'party' => 'required',
            'position' =>'required',
            'whatsapp_number'=>'required|numeric|starts_with:+966',
            'invitaion_lang'=>'required',
            'send_email'=>'required|boolean',
            'send_whatsapp'=>'required|boolean',
            'confirmed_at'=> 'date'
        ];
    }
}
