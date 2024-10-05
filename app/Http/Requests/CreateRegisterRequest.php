<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRegisterRequest extends FormRequest
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
        $rules = User::$rules;
        $rules['password'] = 'required|same:password_confirmation|min:8|max:18|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/';
        $rules['term_policy_check'] = 'required';
        $rules['first_name'] = 'max:30';
        $rules['last_name'] = 'max:30';
        $rules['email'] = 'regex:/^[a-z0-9._%+-]{1,50}@[a-z0-9.-]{1,50}\.[a-z]{2,}$/i';
        
        
        if (getSuperAdminSettingValue('captcha_enable')) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'term_policy_check.required' => __('messages.placeholder.agree_term'),
            'g-recaptcha-response.required' =>  __('messages.placeholder.required_captcha'),
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'email.regex'    => 'The email address must have a username and domain, each between 1 and 50 characters, separated by "@" and ending with a valid top-level domain.',
        ];
    }
}
