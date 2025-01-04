<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class SettingsRequest extends FormRequest
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
    public function rules()
    {
        $isCreate = $this->isMethod('post');
        return [
            'title.*' => 'required|string|max:255',
            'address.*' => 'required|string|max:255',
            'phone' => 'required',//|regex:/^([0-9\s\-\+\(\)]*)$/|min:10
            'email' => 'required|email|max:255',
            'header_logo' => $isCreate
                ? 'required|mimes:jpeg,jpg,png|max:2048|dimensions:width=197,height=101'
                : 'nullable|mimes:jpeg,jpg,png|max:2048|dimensions:width=197,height=101',
            'favicon' => $isCreate
                ? 'required|mimes:jpeg,jpg,png|max:2048|dimensions:width=197,height=101'
                : 'nullable|mimes:jpeg,jpg,png|max:2048|dimensions:width=197,height=101',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => Lang::get('validation.required', ['attribute' => ':attribute']),
            'phone.regex' => Lang::get('validation.invalid_phone', ['attribute' => 'phone']),
            'email.email' => Lang::get('validation.invalid_email', ['attribute' => 'email']),
            'header_logo.mimes' => Lang::get('validation.invalid_image', ['attribute' => 'header logo']),
            'header_logo.dimensions' => Lang::get('validation.invalid_dimensions', ['attribute' => 'header logo', 'width' => 200, 'height' => 73]),
            'header_logo.max' => Lang::get('validation.invalid_size', ['attribute' => 'header logo', 'size' => '8.8 kB']),
            'footer_logo.mimes' => Lang::get('validation.invalid_image', ['attribute' => 'footer logo']),
            'favicon.mimes' => Lang::get('validation.invalid_icon', ['attribute' => 'favicon']),
            'favicon.max' => Lang::get('validation.invalid_icon_size', ['attribute' => 'favicon']),
        ];
    }
}
