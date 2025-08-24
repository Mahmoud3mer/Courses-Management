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
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;"
                                class="delete-course-form">
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
    <p style="text-align: center; color:brown; margin-top:15px;">لا توجد كورسات متاحة</p>
@endif


