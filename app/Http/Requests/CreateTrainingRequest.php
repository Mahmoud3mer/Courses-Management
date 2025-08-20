<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTrainingRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'note' => 'string|max:1000',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'course_id.required' => 'يجب اختيار دورة.',
            'course_id.exists' => 'الدورة المختارة غير موجودة.',
            'price.required' => 'سعر الدورة مطلوب.',
            'start_date.required' => 'تاريخ بدء الدورة مطلوب.',
            'end_date.required' => 'تاريخ انتهاء الدورة مطلوب.',
            'end_date.after' => 'تاريخ انتهاء الدورة يجب أن يكون بعد تاريخ البدء.',
        ];
    }
}
