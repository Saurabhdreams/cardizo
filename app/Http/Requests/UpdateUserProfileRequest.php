<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserProfileRequest extends FormRequest
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
        $id = Auth::id();

        $rules = User::$rules;
        $rules['email'] = $rules['email'].$id;
        $rules['profile'] = 'mimes:jpg,bmp,png,apng,avif,jpeg,';
        $rules['contact'] = 'required';

        return $rules;
    }

    public function messages(): array
{
    return [
        'contact.required' => 'The Contact field is required.',
        'contact.numeric' => 'The Contact must contain only numbers.',
        'contact.digits' => 'The Contact must be exactly 10 digits.',
        'profile.mimes' => 'The Profile must be an image of type jpg, bmp, png, apng, avif, or jpeg.',
        'email.unique' => 'This Email address is already taken.',
    ];
}

}
