<?php

namespace App\Http\Requests;

use App\Models\Testimonial;
use Illuminate\Foundation\Http\FormRequest;

class CreateTestimonialRequest extends FormRequest
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
        return Testimonial::$rules;
    }

    public function messages(): array
    {
        return [
            'name.string' => (__('messages.flash.name_is_required')),
            'description.string' => (__('messages.flash.decription_is_required')),
            'image.required' => (__('The Image field is required')),
        ];
    }
}
