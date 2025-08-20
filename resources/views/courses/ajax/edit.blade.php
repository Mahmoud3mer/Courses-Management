@extends('layouts.app')

@section('title', 'تعديل الكورس')

@section('content')
@section('content')
    <div class="col-12" style="display: flex; justify-content: center; align-items: center;">
        <form id="form-create-course" style="width:80%; background:white; padding:20px; border-radius:10px;" method="POST"
            action="{{ route('courses.update', $course->id) }}">
            @csrf
            @method('PUT')

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <label for="name" class="form-label">اسم الكورس</label>
                <input autofocus type="text" class="form-control" id="name" name="name"
                    value="{{ $course->name }}" placeholder="أدخل اسم الكورس">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group mb-4" style="display: flex; flex-direction: column;">
                <label for="active" class="form-label">الحالة</label>
                <select class="custom-select" style="width: 100%;" id="active" name="active"
                    aria-label="Example select with button addon">
                    <option selected value="">أختر</option>
                    <option value="1" @if ($course->active == 1) selected @endif>مفعل</option>
                    <option value="0" @if ($course->active == 0) selected @endif>غير مفعل</option>
                </select>
                @error('active')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">تحديث الكورس</button>
        </form>
    </div>
@endsection
