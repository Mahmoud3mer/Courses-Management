<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseValidation extends FormRequest
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
            'name' => 'required|string|max:255|min:2',
            'active' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'يرجى إدخال اسم الكورس',
            'name.string' => 'يجب أن يكون اسم الكورس نصًا',
            'name.max' => 'يجب أن لا يتجاوز اسم الكورس 255 حرفًا',
            'name.min' => 'يجب أن يكون اسم الكورس على الأقل 2 حرفًا',
            'active.required' => 'يرجى تحديد حالة الكورس',
        ];
    }
}
