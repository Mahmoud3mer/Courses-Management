@extends('layouts.app')

@section('title', 'تفاصيل الدورة التدريبية')
@push('styles')
    <style>
        .show-success-msg {
            position: absolute;
            top: -105px;
            right: 0;
            display: flex;
            gap: 8px;
        }

        .show-success-msg button {
            border: 0;
            border-radius: 4px;
            background: #e4fce4e0;
            font-weight: 500;
            color: green;
        }
    </style>
@endpush
@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">تفاصيل الدورة التدريبية</h3>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- مكان لعرض رسالة النجاح أو الخطأ  Alert --}}
            <div id="liveAlertPlaceholder"></div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">بيانات الدورة</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>اسم الكورس:</strong>
                                    <span>{{ $trainingCourse->course->name }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>سعر الدورة:</strong>
                                    <span>{{ $trainingCourse->price }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>تاريخ البدء:</strong>
                                    <span>{{ $trainingCourse->start_date }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>تاريخ الانتهاء:</strong>
                                    <span>{{ $trainingCourse->end_date }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>الطلاب المسجلون:</strong>
                                    <span>{{ $trainingCourse->students->count() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>الملاحظات:</strong>
                                    <span>{{ $trainingCourse->note ?: 'لا توجد ملاحظات.' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <div class="card table-responsive p-0" style="height: 300px;">
                            {{-- <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">الطلاب المسجلون</h5>
                                <span class="badge bg-primary rounded-pill">{{ $trainingCourse->students->count() }}
                                    طالب</span>
                            </div>
                            <div class="card-body">
                                @if ($trainingCourse->students->isEmpty())
                                    <p class="text-muted text-center">لا يوجد طلاب مسجلون في هذه الدورة حتى الآن.</p>
                                @else
                                    <ul class="list-group list-group-flush">
                                        @foreach ($trainingCourse->students as $student)
                                            <li class="list-group-item">{{ $student->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div> --}}
                            @if (@isset($trainingCourse->students) and !@empty($trainingCourse->students) and count($trainingCourse->students) > 0)
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>اسم الطالب</th>
                                            <th>تاريخ الاضافة</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @dd($trainingCourse->students) --}}
                                        @isset($trainingCourse->students)
                                            @foreach ($trainingCourse->students as $student)
                                                <tr>
                                                    <td>{{ $student->name }}</td>
                                                    {{-- @dd($trainingCourseEnrolments->where('student_id', $student->id)->first()) --}}
                                                    <td>{{ $trainingCourseEnrolments->where('student_id', $student->id)->first()->enrolment_date }}
                                                    </td>
                                                    <td style="display: flex; gap: 5px; flex-wrap: wrap;">
                                                        <form
                                                            action="{{ route('training-courses.destroyStudent', ['courseId' => $trainingCourse->id, 'studentId' => $student->id]) }}"
                                                            method="POST" style="display:inline;" class="delete-course-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm delete-course-btn"
                                                                type="button">حذف</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            @else
                                <p style="text-align: center; color:brown; margin-top:15px;">لا توجد دورات تدريبية متاحة</p>
                            @endif

                        </div>

                        <div>
                            <a href="{{ route('training-courses.addStudent', $trainingCourse->id) }}"
                                class="btn btn-primary">إضافة طالب</a>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">العودة</a>
                </div>
            </div>
        </div>
    </div>

    {{-- My Modal to improve delete --}}
    <div class="myModal" id="modal" style="z-index: 100;">
        <p>هل أنت متأكد أنك تريد حذف هذا الكورس؟</p>
        <button class="btn btn-danger" id="confirmDeleteBtn">حذف</button>
        <button class="btn btn-secondary" id="cancelDeleteBtn">إلغاء</button>
    </div>
@endsection


@push('scripts')
    <script>
        const response = '{{ session('success') }}';
        // console.log(response);
        const alertPlaceholder = document.getElementById('liveAlertPlaceholder')

        const alert = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible show-success-msg" role="alert">`,
                `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>`,
                `   <div>${message}</div>`,
                `</div>`
            ].join('')

            alertPlaceholder.append(wrapper)
        }

        if (response) {
            alert(response, 'success')
        }

        $('.btn-close').on('click', function() {
            $(this).closest('.alert').remove()
        })


        // handle delete confirmation
        let confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        let delete_course_btn = document.querySelectorAll('.delete-course-btn');
        let modal = document.getElementById('modal');

        let formToDelete = null;

        delete_course_btn.forEach(button => {
            button.addEventListener('click', function() {
                console.log('Delete button clicked', this.id);

                modal.style.display = 'block';
                formToDelete = this.closest('.delete-course-form');
            });
        });

        cancelDeleteBtn.addEventListener('click', function() {
            // Close the modal
            modal.style.display = 'none';
            formToDelete = null;
        });

        confirmDeleteBtn.addEventListener('click', function() {
            if (formToDelete) {
                formToDelete.submit();
            }

            modal.style.display = 'none';
        });
    </script>
@endpush
