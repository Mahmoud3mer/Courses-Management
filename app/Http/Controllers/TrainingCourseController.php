<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingCourse;
use App\Models\Course;
use App\Http\Requests\CreateTrainingRequest;
use App\Models\Student;
use App\Http\Requests\AddStudentToTrainingCourseRequest;
use App\Models\TrainingCourseEnrolment;

class TrainingCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainingCourses = TrainingCourse::all();
        return view('training-courses.index', compact('trainingCourses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::select('id', 'name')->where('active', '=', 1)->get();

        return view('training-courses.ajax.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTrainingRequest $request)
    {
        $validated = $request->validated();

        TrainingCourse::create($validated);

        return redirect()->route('training-courses.index')->with('success', 'تم إضافة الدورة بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trainingCourse = TrainingCourse::find($id);
        $trainingCourseEnrolments = TrainingCourseEnrolment::where('training_course_id', $id)->get();

        if (!$trainingCourse) {
            return redirect()->route('training-courses.index')->with('error', 'الدورة التدريبية غير موجودة.');
        }

        return view('training-courses.ajax.show', compact('trainingCourse', 'trainingCourseEnrolments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $courses = Course::select('id', 'name')->where('active', '=', 1)->get();

        $trainingCourse = TrainingCourse::find($id);
        
        if (!$trainingCourse) {
            return redirect()->route('training-courses.index')->with('error', 'الدورة التدريبية غير موجودة.');
        }

        return view('training-courses.ajax.edit', compact('trainingCourse', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateTrainingRequest $request, string $id)
    {
        $validated = $request->validated();

        $trainingCourse = TrainingCourse::find($id);

        if (!$trainingCourse) {
            return redirect()->back()->with('error', 'الدورة التدريبية غير موجودة.')->withInput();
        }

        $trainingCourse->update($validated);

        return redirect()->route('training-courses.index')->with('success', 'تم تحديث الدورة التدريبية بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trainingCourse = TrainingCourse::find($id);

        if (!$trainingCourse) {
            return redirect()->back()->with('error', 'الدورة التدريبية غير موجودة.');
        }

        $trainingCourse->delete();

        return redirect()->route('training-courses.index')->with('success', 'تم حذف الدورة التدريبية بنجاح.');
    }


    public function addStudent($id)
    {
        $trainingCourse = TrainingCourse::find($id);

        if (!$trainingCourse) {
            return redirect()->route('training-courses.index')->with('error', 'الدورة التدريبية غير موجودة.');
        }

        $students = Student::select('id', 'name')->where('active', '=', 1)->get();

        return view('training-courses.ajax.add-student', compact('trainingCourse', 'students'));
    }

    public function storeStudent(AddStudentToTrainingCourseRequest $request, $id)
    {
        $trainingCourse = TrainingCourse::find($id);

        if (!$trainingCourse) {
            return redirect()->route('training-courses.index')->with('error', 'الدورة التدريبية غير موجودة.');
        }

        
        $validated = $request->validated();

        $studentCounter = TrainingCourseEnrolment::where('training_course_id', $id)->where('student_id', $validated['student_id'])->count();

        if ($studentCounter > 0) {
            return redirect()->route('training-courses.show', $id)->with('error', 'الطالب مسجل بالفعل في هذه الدورة.');
        }

        TrainingCourseEnrolment::create([
            'student_id' => $validated['student_id'],
            'training_course_id' => $id,
            'enrolment_date' => $validated['enrolment_date'],
        ]);

        return redirect()->route('training-courses.show', $id)->with('success', 'تم إضافة الطالب إلى الدورة بنجاح.');
    }


    public function destroyStudent($courseId, $studentId)
    {
        $trainingCourse = TrainingCourse::find($courseId);

        if (!$trainingCourse) {
            return redirect()->route('training-courses.index')->with('error', 'الدورة التدريبية غير موجودة.');
        }

        $enrolment = TrainingCourseEnrolment::where('training_course_id', $courseId)->where('student_id', $studentId)->first();

        if (!$enrolment) {
            return redirect()->route('training-courses.show', $courseId)->with('error', 'الطالب غير مسجل في هذه الدورة.');
        }

        $enrolment->delete();

        return redirect()->route('training-courses.show', $courseId)->with('success', 'تم حذف الطالب من الدورة بنجاح.');
    }
}
