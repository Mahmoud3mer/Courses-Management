@extends('layouts.app')

@section('title', 'إضافة طالب إلى الدورة')

@section('content')
    <div class="col-12" style="display: flex; justify-content: center; align-items: center;">
        <form id="form-create-course" style="width:80%; background:white; padding:20px; border-radius:10px;" method="POST"
            action="{{ route('training-courses.storeStudent', $trainingCourse->id) }}">
            @csrf
            @method('POST')

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="input-group mb-4" style="display: flex; flex-direction: column;">
                <label for="student_id" class="form-label">اسم الطالب</label>
                <select class="custom-select" style="width: 100%;" id="student_id" name="student_id"
                    aria-label="Example select with button addon">
                    <option selected value="">أختر</option>
                    @isset($students)
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @if(old('student_id') == $student->id) selected @endif>{{ $student->name }}</option>
                        @endforeach
                    @endisset
                </select>
                @error('course_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="enrolment_date" class="form-label">تاريخ تسجيل الطالب</label>
                <input type="date" class="form-control" id="enrolment_date" name="enrolment_date"
                    value="{{ old('enrolment_date') }}" placeholder="أدخل تاريخ تسجيل الطالب">
                @error('enrolment_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">اضافة طالب إلى الدورة</button>
            <a href="{{ route('training-courses.show', $trainingCourse->id) }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection

