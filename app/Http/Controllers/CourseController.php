<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Requests\CreateCourseValidation;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        // dd($courses);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.ajax.create');
    }

    public function store(CreateCourseValidation $request)
    {
        $course_is_exists = Course::where("name", '=', $request->name)->first();
        if ($course_is_exists) {
            return redirect()->back()->with(['error' => 'اسم الكورس موجود بالفعل.'])->withInput();
        }

        Course::create($request->validated());
        return redirect()->route('courses.index')->with('success', 'تم إنشاء الكورس بنجاح.');
    }

    public function show($id)
    {
        // Logic to display a specific course
    }

    public function edit($id)
    {
        // return course or 404 page
        // $course = Course::findOrFail($id);

        // return course or null that help me to handle error 
        $course = Course::find($id);
        if (!$course) {
            return redirect()->route('courses.index')->with(['error' => 'الكورس غير موجود.']);
        }

        return view('courses.ajax.edit', compact('course'));
    }

    public function update(CreateCourseValidation $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->validated());

        $course_is_exists = Course::where("name", '=', $request->name)->where('id', '!=', $course->id)->first();

        if ($course_is_exists) {
            return redirect()->back()->with(['error' => 'اسم الكورس موجود بالفعل.'])->withInput();
        }

        return redirect()->route('courses.index')->with('success', 'تم تعديل الكورس بنجاح.');
    }

    public function destroy($id)
    {
        // Logic to delete a specific course
        $course = Course::find($id);
        
        if (!$course) {
            return redirect()->route('courses.index')->with(['error' => 'الكورس غير موجود.']);
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'تم حذف الكورس بنجاح.');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $searchName = $request->input('searchByName');
            $searchActive = $request->input('searchByActive');

            if ($searchActive == 'all') {
                $courses = Course::where('name', 'like', '%' . $searchName . '%')->get();
            } else {
                $courses = Course::where('name', 'like', '%' . $searchName . '%')
                    ->where('active', $searchActive)
                    ->get();
            }

            return view('courses.ajax.course-ajax-search', compact('courses'));
        }
    }
}
