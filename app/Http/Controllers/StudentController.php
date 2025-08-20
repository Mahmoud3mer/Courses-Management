<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Country;
use App\Http\Requests\CreateStudentValidation;
use App\Http\Requests\UpdateStudentValidation;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        $countries = Country::select('id', 'name')->where('active', 1)->get();
        // dd($students);
        return view('students.index', compact('students', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genders = ['male' => 'ذكر', 'female' => 'أنثى'];
        $countries = Country::select('id', 'name')->where('active', 1)->get();

        return view('students.ajax.create', compact('countries', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStudentValidation $request)
    {

       $existingStudent = Student::where('email', $request->email)->first();

        if ($existingStudent) {
            return redirect()->back()->with('error', 'هذا الطالب موجود بالفعل')->withInput();
        }

        // الحصول على البيانات التي تم التحقق منها
        $validatedData = $request->validated();

        // Upload Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // 1- get extension //jpg, png, jpeg,...
            $extension = $image->getClientOriginalExtension();
            //2- اضافة اسم لكل ملف حتى لا يكون هناك اسم كرر
            $fileName = time().rand(1, 1000).'.'.$extension;
            // 3- Store image in public folder
            $image->move(public_path('upload'), $fileName);
            
            // إضافة اسم الملف الجديد إلى البيانات التي سيتم حفظها
            $validatedData['image'] = $fileName;
        }else {
            // إذا لم يتم رفع صورة، يمكن إعطاؤها قيمة افتراضية أو null
            $validatedData['image'] = null;
        }

        // إنشاء الطالب باستخدام البيانات المعدلة
        Student::create($validatedData);
        

        return redirect()->route('students.index')->with('success', 'تم إضافة الطالب بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $genders = ['male' => 'ذكر', 'female' => 'أنثى'];
        $countries = Country::select('id', 'name')->where('active', 1)->get();

        $student = Student::find($id);
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'هذا الطالب غير موجود');
        }


        return view('students.ajax.edit', compact('student', 'countries', 'genders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentValidation $request, string $id)
    {
        $existingStudent = Student::find($id);

        if (!$existingStudent) {
            return redirect()->back()->with('error', 'هذا الطالب غير موجود')->withInput();
        }

        $validatedData = $request->validated();
        $imagePath = $existingStudent->image; // الاحتفاظ بمسار الصورة القديمة


        // Upload Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = time().rand(1, 1000).'.'.$extension;
            $image->move(public_path('upload'), $fileName);
            
            // حذف الصورة القديمة إذا كانت موجودة
            if ($existingStudent->image && file_exists(public_path('upload/' . $existingStudent->image))) {
                unlink(public_path('upload/' . $existingStudent->image));
            }

            $validatedData['image'] = $fileName;
        } elseif ($request->input('remove_image') == 1) {
            // إزالة الصورة
            if ($existingStudent->image && file_exists(public_path('upload/' . $existingStudent->image))) {
                unlink(public_path('upload/' . $existingStudent->image));
            }
            $validatedData['image'] = null; // تعيين الصورة إلى null
        } else {
            // الاحتفاظ بالصورة القديمة
            $validatedData['image'] = $existingStudent->image;
        }

        $existingStudent->update($validatedData);

        return redirect()->route('students.index')->with('success', 'تم تعديل الطالب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect()->route('students.index')->with('error', 'هذا الطالب غير موجود');
        }

        // حذف الصورة إذا كانت موجودة
        if ($student->image && file_exists(public_path('upload/' . $student->image))) {
            unlink(public_path('upload/' . $student->image));
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'تم حذف الطالب بنجاح');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $searchName = $request->input('searchByName');
            $searchCountry = $request->input('searchByCountry');

            if ($searchCountry == 'all') {
                $students = Student::where('name', 'like', '%' . $searchName . '%')->get();
            } else {
                $students = Student::where('name', 'like', '%' . $searchName . '%')
                    ->where('country_id', $searchCountry)
                    ->get();
            }
            
            return view('students.ajax.student-ajax-search', compact('students'));
        }
    }
}
