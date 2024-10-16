<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEcardRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'vcard_id' => 'required',
            'first_name' => 'required|max:10',
            'last_name' => 'required|max:10',
            'email' =>
                'required',
                'string',
                'email',
                'min:8',
                'max:30',
            'occupation' => 'required|max:20',
            'phone' => 'required|numeric',
            'location' => 'required',
            'website' => 'required',
            'ecard-logo' => 'required|image|mimes:jpeg,png,jpg|dimensions:width=150,height=150',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function messages(): array
    {
        return [
            'vcard_id.required' => 'Please fill the Vcard Name',
            'email.email' => 'Please enter a valid email address.',
            'email.min' => 'Email must be at least 8 characters long.',
            'email.max' => 'Email cannot be longer than 30 characters.',
            'ecard-logo.dimensions' => 'E Card logo should have 150px width & hight.',
        ];
    }
}
