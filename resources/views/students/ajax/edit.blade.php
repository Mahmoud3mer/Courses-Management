@extends('layouts.app')

@section('title', 'تعديل طالب')

@section('content')
    <div class="col-12" style="display: flex; justify-content: center; align-items: center;">
        <form id="form-create-student" enctype="multipart/form-data"
            style="width:80%; background:white; padding:20px; border-radius:10px; margin-bottom:20px" method="POST"
            action="{{ route('students.update', $student->id) }}">
            @csrf
            @method('PUT')

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <label for="name" class="form-label">اسم الطالب</label>
                <span class="required">*</span>
                <input autofocus type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $student->name) }}" placeholder="أدخل اسم الطالب">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <span class="required">*</span>
                <input autofocus type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $student->email) }}" placeholder="أدخل البريد الإلكتروني">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group mb-4" style="display: flex; flex-direction: column;">
                <div>
                    <label for="country_id" class="form-label">الدولة التابع لها الطالب</label>
                    <span class="required">*</span>
                </div>
                <select class="custom-select" style="width: 100%;" id="country_id" name="country_id"
                    aria-label="Example select with button addon">
                    <option selected value="">أختر الدولة</option>
                    @isset($countries)
                        @foreach ($countries as $country)
                            <option value="{{ old('country_id', $country->id) }}" @if ($student->country_id == $country->id) selected @endif>
                                {{ $country->name }}</option>
                        @endforeach
                    @endisset

                </select>
                @error('country_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="national_id" class="form-label">الرقم القومي للهوية</label>
                <span class="required">*</span>
                <input autofocus type="text" class="form-control" id="national_id" name="national_id"
                    value="{{ old('national_id', $student->national_id) }}" placeholder="أدخل الرقم القومي لا يقل عن 14 رقماً">
                @error('national_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="form-label">العنوان</label>
                <span class="required">*</span>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $student->address) }}"
                    placeholder="أدخل العنوان">
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="form-label">رقم الهاتف</label>
                <span class="required">*</span>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $student->phone) }}"
                    placeholder="أدخل رقم الهاتف">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="notes" class="form-label">ملاحظات</label>
                <input type="text" class="form-control" id="notes" name="notes" value="{{ old('notes', $student->notes) }}"
                    placeholder="أدخل ملاحظات">
            </div>

            <div class="input-group mb-4" style="display: flex; flex-direction: column;">
                <div>
                    <label for="gender" class="form-label">الجنس</label>
                    <span class="required">*</span>
                </div>
                <select class="custom-select" style="width: 100%;" id="gender" name="gender"
                    aria-label="Example select with button addon">
                    <option selected value="">أختر الجنس</option>
                    @isset($genders)
                        @foreach ($genders as $key => $value)
                            <option value="{{ $key }}" @if ($student->gender == $key) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    @endisset
                </select>
                @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group mb-4" style="display: flex; flex-direction: column;">
                <div>
                    <label for="active" class="form-label">الحالة</label>
                    <span class="required">*</span>
                </div>
                <select class="custom-select" style="width: 100%;" id="active" name="active"
                    aria-label="Example select with button addon">
                    <option selected value="">أختر</option>
                    <option value="1" @if ($student->active == 1) selected @endif>مفعل</option>
                    <option value="0" @if ($student->active == 0) selected @endif>غير مفعل</option>
                </select>
                @error('active')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group mb-4">
                <input type="file" class="form-control" id="image" name="image" style="display: none">
                <img src="" alt="" id="image-preview"
                    style="width: 300px; height: 200px;display: none;">
                <span class="remove-image" id="remove-image">x</span>
                <input type="hidden" name="remove_image" id="remove-image-flag" value="0">
                <label class="input-group-text label-file-input" for="image" id="image-label">
                    <span>
                        صورة الطالب (ان وجدت)
                    </span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary">تحديث الطالب</button>
        </form>
    </div>

@endsection


@push('scripts')
    <script>
        const image = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imageLabel = document.getElementById('image-label');
        const removeImage = document.getElementById('remove-image');
        const imgFromDb = "{{ $student->image ? asset('upload/' . $student->image) : '' }}";
        const removeImageFlag = document.getElementById('remove-image-flag');

        if (imgFromDb) {
            imagePreview.src = imgFromDb;
            imagePreview.style.display = 'block';
            imageLabel.style.display = 'none';
            removeImage.style.display = 'flex';
        }

        image.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    imageLabel.style.display = 'none';
                    removeImage.style.display = 'flex';
                }
                reader.readAsDataURL(file);
            }
        });

        removeImage.addEventListener('click', function() {
            image.value = null;
            imagePreview.src = '';
            imagePreview.style.display = 'none';
            imageLabel.style.display = 'flex';
            removeImage.style.display = 'none';
            removeImageFlag.value = 1;
        });

        // imagePreview.addEventListener('click', function() {
        //     const link = document.createElement('a');
        //     link.href = imagePreview.src;
        //     link.target = '_blank';
        //     link.click();
        // });
    </script>
@endpush
