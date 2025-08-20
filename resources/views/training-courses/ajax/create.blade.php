@extends('layouts.app')

@section('title', 'إنشاء دورة تدريبية')

@section('content')
    <div class="col-12" style="display: flex; justify-content: center; align-items: center;">
        <form id="form-create-course" style="width:80%; background:white; padding:20px; border-radius:10px;" method="POST"
            action="{{ route('training-courses.store') }}">
            @csrf
            @method('POST')

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="input-group mb-4" style="display: flex; flex-direction: column;">
                <label for="course_id" class="form-label">اسم الكورس</label>
                <select class="custom-select" style="width: 100%;" id="course_id" name="course_id"
                    aria-label="Example select with button addon">
                    <option selected value="">أختر</option>
                    @isset($courses)
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @if(old('course_id') == $course->id) selected @endif>{{ $course->name }}</option>
                        @endforeach
                    @endisset
                </select>
                @error('course_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="form-label">سعر الدورة</label>
                <input autofocus type="number" min="0" class="form-control" id="price" name="price"
                    value="{{ old('price') }}" placeholder="أدخل سعر الدورة">
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="start_date" class="form-label">تاريخ بدء الدورة</label>
                <input type="date" class="form-control" id="start_date" name="start_date"
                    value="{{ old('start_date') }}" placeholder="أدخل تاريخ بدء الدورة">
                @error('start_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="form-label">تاريخ انتهاء الدورة</label>
                <input autofocus type="date" class="form-control" id="end_date" name="end_date"
                    value="{{ old('end_date') }}" placeholder="أدخل تاريخ انتهاء الدورة">
                @error('end_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="note" class="form-label">ملاحظات</label>
                <textarea class="form-control" id="note" name="note" rows="3"
                    placeholder="أدخل ملاحظات">{{ old('note') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">اضافة دورة تدريبية</button>
        </form>
    </div>
@endsection

