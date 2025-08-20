<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentValidation extends FormRequest
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
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:255|unique:students,email',
            'country_id' => 'required|exists:countries,id',
            'national_id' => 'required|string|max:50|unique:students,national_id',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
            'gender' => 'required|in:male,female',
            'active' => 'required|boolean',
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'يرجى إدخال اسم الطالب',
            'name.string' => 'يجب أن يكون اسم الطالب نصًا',
            'name.max' => 'يجب أن لا يتجاوز اسم الطالب 255 حرفًا',
            'name.min' => 'يجب أن لا يقل اسم الطالب عن 3 أحرف',
            'email.required' => 'يرجى إدخال البريد الإلكتروني للطالب',
            'email.email' => 'البريد الإلكتروني غير صالح',
            'email.max' => 'يجب أن لا يتجاوز البريد الإلكتروني 255 حرفًا',
            'email.unique' => 'هذا البريد الإلكتروني مسجل بالفعل',
            'country_id.required' => 'يرجى اختيار الدولة',
            'country_id.exists' => 'الدولة المختارة غير موجودة',
            'address.required' => 'يرجى إدخال عنوان الطالب',
            'address.string' => 'يجب أن يكون العنوان نصًا',
            'address.max' => 'يجب أن لا يتجاوز العنوان 255 حرفًا',
            'phone.required' => 'يرجى إدخال رقم الهاتف',
            'phone.max' => 'رقم الهاتف يجب أن لا يتجاوز 20 حرفًا',
            'notes.string' => 'الملاحظات يجب أن تكون نصًا',
            'notes.max' => 'الملاحظات يجب أن لا تتجاوز 500 حرفًا',
            'gender.required' => 'يرجى اختيار الجنس',
            'active.required' => 'يرجى اختيار الحالة',
            'national_id.required' => 'يرجى إدخال الرقم القومي للهوية',
            'national_id.string' => 'يجب أن يكون الرقم القومي للهوية نصًا',
            'national_id.max' => 'يجب أن لا يتجاوز الرقم القومي للهوية 50 حرفًا',
            'national_id.unique' => 'هذا الرقم القومي للهوية مسجل بالفعل',
        ];
    }
}