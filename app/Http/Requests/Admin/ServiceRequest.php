<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class ServiceRequest extends FormRequest
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
            'image' => $isCreate ? 'required|mimes:jpeg,jpg,png,webp' : 'mimes:jpeg,jpg,png,webp',
            'title.*' => 'required|string',
            'text.*' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => Lang::get('validation.required', ['attribute' => ':attribute']),
            '*.string' => Lang::get('validation.string', ['attribute' => ':attribute']),
            'image.mimes' => Lang::get('validation.invalid_image', ['attribute' => 'header logo']),
            'image.dimensions' => Lang::get('validation.invalid_dimensions', [
                'attribute' => 'header logo',
                'width' => 288,  // Genişlik üçün 288 px istifadə ediləcək
                'height' => 154  // Hündürlük üçün 154 px istifadə ediləcək
            ]),
            'image.max' => Lang::get('validation.invalid_size', [
                'attribute' => 'header logo',
                'size' => '2048 kB'  // 2048 kB maksimal fayl ölçüsünü göstərir
            ]),
        ];
    }
}
