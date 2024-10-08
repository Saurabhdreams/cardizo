<?php

namespace App\Http\Requests;

use App\Models\Enquiry;
use Illuminate\Foundation\Http\FormRequest;

class CreateEnquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        setLocalLang(getLocalLanguage());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $dynamicRules = Enquiry::$rules;
        $dynamicRules['email'] = 'required|email|max:25';
        if (!empty($this->vcard->privacy_policy) || !empty($this->vcard->term_condition)) {
            $dynamicRules['terms_condition'] = 'required';
        }
        return $dynamicRules;
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'The email may not be greater than 25 characters.',
            'terms_condition.required' => __('messages.placeholder.agree_term'),
        ];
    }
}
