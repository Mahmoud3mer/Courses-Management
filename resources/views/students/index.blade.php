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

        <div class="card">
            <div class="card-header" style="display: flex; flex-direction: column; gap:10px;">
                <div style="display: flex; gap:25px;">
                    <h3 class="card-title"> بيانات الطلاب </h3>
                    <a href="{{ route('students.create') }}"><button class="btn btn-primary btn-sm">اضافة جديد</button></a>
                </div>
                <div class="card-tools" style="display: flex; gap: 10px; align-items: center;">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        {{-- <label for="country_id" class="form-label">البحث باسم الطالب</label> --}}
                        <input type="text" placeholder="البحث باسم الطالب" name="searchByName" id="searchByName"
                            class="form-control float-right">
                    </div>

                    <div class="input-group input-group-sm" style="width: 250px;">
                        {{-- <label for="country_id" class="form-label">البحث باسم الدولة</label> --}}
                        <select class="custom-select" style="width: 100%;" id="searchByCountry" name="country_id"
                            aria-label="Example select with button addon">
                            <option selected value="all">جميع الدول</option>
                            @isset($countries)
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if (old('country_id') == $country->id) selected @endif>
                                        {{ $country->name }}</option>
                                @endforeach
                            @endisset

                        </select>
                    </div>
                </div>
            </div>

            <div id="liveAlertPlaceholder"></div>

            <div class="card-body table-responsive p-0" style="height: 300px;" id="ajax_response_table">
                @if (@isset($students) and !@empty($students) and count($students) > 0)
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>اسم الطالب</th>
                                <th>الدولة</th>
                                <th>العنوان</th>
                                <th>الهاتف</th>
                                <th>الصورة</th>
                                <th>ملاحظات</th>
                                <th>حالة الطالب</th>
                                <th>تاريخ الاضافة</th>
                                <th>تاريخ التعديل</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($students)
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->country->name }}</td>
                                        <td>{{ $student->address }}</td>
                                        <td>{{ $student->phone }}</td>
                                        <td style="text-align: center;">
                                            {{-- {{ $student->image }} --}}
                                            <img src="{{ asset('upload/' . $student->image) }}" alt="{{ $student->name }}"
                                                style="width: 60px; height: 60px; border-radius: 50%;">
                                        </td>
                                        <td>{{ $student->notes }}</td>
                                        <td>
                                            @if ($student->active)
                                                <span class="badge badge-success">مُفعل</span>
                                            @else
                                                <span class="badge badge-danger">غير مُفعل</span>
                                            @endif
                                        </td>
                                        <td>{{ $student->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $student->updated_at->format('Y-m-d') }}</td>
                                        <td style="display: flex; gap: 5px; flex-wrap: wrap;">
                                            <a href="{{ route('students.edit', $student->id) }}"><button
                                                    class="btn btn-success btn-sm">تعديل</button></a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST"
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
                    <p style="text-align: center; color:brown; margin-top:15px;">لا يوجد طلاب مُتاحين</p>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    {{-- My Modal to improve delete --}}
    <div class="myModal" id="modal">
        <p>هل أنت متأكد أنك تريد حذف هذا الطالب؟</p>
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


        // Handle Search
        $(document).ready(function() {
            $('#searchByName, #searchByCountry').on('input', function() {
                let searchValue = $('#searchByName').val();
                let searchCountry = $('#searchByCountry').val();

                $.ajax({
                    url: '{{ route('students.search') }}',
                    type: 'post',
                    'dataType': 'html', // return HTML response
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        searchByName: searchValue,
                        searchByCountry: searchCountry
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
        });
    </script>
@endpush
