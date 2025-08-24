@extends('layouts.app')

@section('title', 'الكورسات')

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
            <div class="" style="display: flex; flex-direction: column; gap:10px;">
                <div style="display: flex; gap:25px;">
                    <h3 class="card-title"> بيانات الكورسات </h3>
                    <a href="{{ route('courses.create') }}"><button class="btn btn-primary btn-sm">اضافة جديد</button></a>
                </div>

                <div class="" style="display: flex; gap: 10px; align-items: center;">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" placeholder="البحث باسم الكورس" name="searchByName" id="searchByName"
                            class="form-control float-right">
                    </div>

                    <div class="input-group input-group-sm" style="width: 250px;">
                        <select class="custom-select" style="width: 100%;" id="searchByActive" name="active"
                            aria-label="Example select with button addon">
                            <option selected value="all">كل الحالات</option>
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                    </div>
                </div>

            </div>

            {{-- مكان لعرض رسالة النجاح أو الخطأ  Alert --}}
            <div id="liveAlertPlaceholder"></div>

            <div class="table-responsive p-0" id="ajax_response_table" style="margin-top: 20px;">
                @if (@isset($courses) and !@empty($courses) and count($courses) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>اسم الكورس</th>
                                <th>حالة الكورس</th>
                                <th>تاريخ الاضافة</th>
                                <th>تاريخ التعديل</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($courses)
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->name }}</td>
                                        <td>
                                            @if ($course->active)
                                                <span class="badge badge-success">مُفعل</span>
                                            @else
                                                <span class="badge badge-danger">غير مُفعل</span>
                                            @endif
                                        </td>
                                        <td>{{ $course->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $course->updated_at->format('Y-m-d') }}</td>
                                        <td style="display: flex; gap: 5px; flex-wrap: wrap;">
                                            <a href="{{ route('courses.edit', $course->id) }}"><button
                                                    class="btn btn-success btn-sm">تعديل</button></a>
                                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
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
                    <p style="text-align: center; color:brown; margin-top:15px;">لا توجد كورسات متاحة</p>
                @endif

                {{-- Pagination Links --}}
                <div id="pagination-links-ajax" style="overflow-x: hidden; padding-inline: 15px;">
                    {{ $courses->links('pagination::bootstrap-5') }}
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
        

        // Handle Search
        $(document).ready(function() {
            $('#searchByName, #searchByActive').on('input', function() {
                let searchValue = $('#searchByName').val();
                let searchActive = $('#searchByActive').val();

                $.ajax({
                    url: '{{ route('courses.search') }}',
                    type: 'post',
                    'dataType': 'html', // return HTML response
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        searchByName: searchValue,
                        searchByActive: searchActive
                    },
                    success: function(response) {
                        // console.log(response);
                        $('#ajax_response_table').html(
                            response); // Update the table body with the new content
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                })
            });


            // Handle ajax pagination
            $(document).on('click', '#pagination-links-ajax a', function(event) {
                event.preventDefault();
                let url = $(this).attr('href');
                fetchCourses(url);
            });


            const fetchCourses = (url) => {
                let searchValue = $('#searchByName').val();
                let searchActive = $('#searchByActive').val();

                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'html',
                    data: {
                        _token: '{{ csrf_token() }}',
                        searchByName: searchValue,
                        searchByActive: searchActive
                    },
                    success: function(response) {
                        $('#ajax_response_table').html(response);
                        // Update pagination links
                        $('#pagination-links-ajax').html(
                            $(response).find('#pagination-links-ajax').html());
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            }
        });
    </script>
@endpush
