@extends('layouts.app')

@section('title', 'الدورات التدريبية')

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
    <div class="col-12">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="">
            <div class="" style="display: flex; justify-content: space-between;">
                <h3 class="card-title"> بيانات الدورات التدريبية </h3>
                <a href="{{ route('training-courses.create') }}"><button class="btn btn-primary btn-sm">اضافة
                        جديد</button></a>
            </div>

            {{-- مكان لعرض رسالة النجاح أو الخطأ  Alert --}}
            <div id="liveAlertPlaceholder"></div>

            <div class="table-responsive p-0">
                @if (@isset($trainingCourses) and !@empty($trainingCourses) and count($trainingCourses) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>اسم الكورس</th>
                                <th>سعر الدورة</th>
                                <th>تاريخ البدء</th>
                                <th>تاريخ الانتهاء</th>
                                <th>ملاحظات</th>
                                <th>تاريخ الاضافة</th>
                                <th>تاريخ التعديل</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($trainingCourses)
                                @foreach ($trainingCourses as $course)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ route('training-courses.show', $course->id) }}">{{ $course->course->name }}</a>
                                        </td>
                                        <td>{{ $course->price }}</td>
                                        <td>{{ $course->start_date }}</td>
                                        <td>{{ $course->end_date }}</td>
                                        <td>{{ $course->note }}</td>
                                        <td>{{ $course->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $course->updated_at->format('Y-m-d') }}</td>
                                        <td style="display: flex; gap: 5px; flex-wrap: wrap;">
                                            <a href="{{ route('training-courses.show', $course->id) }}"><button
                                                    class="btn btn-info btn-sm">تفاصيل</button></a>
                                            <a href="{{ route('training-courses.edit', $course->id) }}"><button
                                                    class="btn btn-success btn-sm">تعديل</button></a>
                                            <form action="{{ route('training-courses.destroy', $course->id) }}" method="POST"
                                                style="display:inline;" class="delete-course-form">
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

                {{-- Pagination Links --}}
                <div id="pagination-links-ajax" style="overflow-x: hidden; padding-inline: 15px;">
                    {{ $trainingCourses->links('pagination::bootstrap-5') }}
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    {{-- My Modal to improve delete --}}
    <div class="myModal" id="modal">
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

        // استخدم Event Delegation على عنصر أب ثابت (مثل document)
        document.addEventListener('click', function(event) {
            // تحقق مما إذا كان العنصر الذي تم النقر عليه يحتوي على الكلاس 'delete-course-btn'
            if (event.target.classList.contains('delete-course-btn')) {
                let modal = document.getElementById('modal');
                let formToDelete = event.target.closest('.delete-course-form');

                if (modal && formToDelete) {
                    modal.style.display = 'block';
                    document.getElementById('confirmDeleteBtn').onclick = function() {
                        formToDelete.submit();
                    };
                }
            }
        });

        // تأكد من أن مستمعي الأحداث الآخرين للمودال موجودين
        let modal = document.getElementById('modal');
        let cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

        cancelDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    </script>
@endpush
