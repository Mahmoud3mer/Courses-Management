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
                                <button class="btn btn-danger btn-sm delete-course-btn" type="button">حذف</button>
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

{{-- Pagination Links --}}
<div id="pagination-links-ajax" style="overflow-x: hidden; padding-inline: 15px;">
    {{ $students->links('pagination::bootstrap-5') }}
</div>
