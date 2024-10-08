<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;


class UpdateChangePasswordRequest extends FormRequest
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
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail('The current password is incorrect.');
                    }
                },
            ],
            'new_password' => 'required|same:confirm_password|min:8|max:18|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/',
            'confirm_password' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'The Current Password field is required.',
            'current_password.min' => 'The Current Password must be at least 8 characters.',
            'new_password.required' => 'The New Password field is required.',
            'new_password.same' => 'The New Password and Confirm Password must match.',
            'new_password.regex' => 'The New Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'confirm_password.required' => 'The Confirm Password field is required.',
        ];
    }
}
