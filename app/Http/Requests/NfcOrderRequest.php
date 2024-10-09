<?php

namespace App\Http\Requests;

use App\Models\NfcOrders;
use Illuminate\Foundation\Http\FormRequest;

class NfcOrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge(NfcOrders::$rules, [
            // 'payment_type' => 'required',
            'logo' => 'required',
            'phone' => 'required|digits_between:10,15',
            'vcard_id' => 'required'
        ]);
    }

    public function messages(): array
    {
        return [
            // 'payment_type.required' => __('payment method is required'),
            'logo.required' => __('The Logo field is required'),
            'vcard_id.required' => __('The vcard field is required'),
            'phone.required' => __('The Phone field is required'),
            'phone.digits_between' => __('The Phone number must be between 10 and 15 digits.'),

        ];
    }
}
