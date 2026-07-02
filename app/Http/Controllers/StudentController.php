<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('roll_number', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') || $request->status === '0') {
            $query->where('status', $request->status);
        }

        $students = $query->paginate(10)->withQueryString();

        return view('students.index', compact('students'));
    }

    public function getCreate()
    {
        return view('students.create');
    }

    public function postCreate(Request $request)
    {
        $validated = $request->validate([
            'student_id'     => 'required|unique:students,student_id',
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'nullable|string|max:255',
            'email'          => 'required|email|unique:students,email',
            'mobile'         => 'required|max:10|unique:students,mobile',
            'date_of_birth'  => 'required|date',
            'gender'         => 'required|in:Male,Female,Other',
            'course'         => 'required|string',
            'department'     => 'nullable|string',
            'semester'       => 'nullable|string',
            'roll_number'    => 'required|unique:students,roll_number',
            'address'        => 'nullable|string',
            'city'           => 'nullable|string',
            'state'          => 'nullable|string',
            'country'        => 'nullable|string',
            'pincode'        => 'nullable|digits_between:6,10',
            'admission_date' => 'required|date',
            'fees'           => 'nullable|numeric',
            'profile_image'  => 'nullable|image|max:2048',
        ]);

        $validated['full_name'] = trim($validated['first_name'] . ' ' . ($validated['last_name'] ?? ''));
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('students', 'public');
        }

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function getUpdate($id)
    {
        $student = Student::findOrFail($id);

        return view('students.update', compact('student'));
    }

    public function postUpdate(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'student_id'     => 'required|unique:students,student_id,' . $id,
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'nullable|string|max:255',
            'email'          => 'required|email|unique:students,email,' . $id,
            'mobile'         => 'required|max:15|unique:students,mobile,' . $id,
            'date_of_birth'  => 'required|date',
            'gender'         => 'required|in:Male,Female,Other',
            'course'         => 'required|string',
            'department'     => 'nullable|string',
            'semester'       => 'nullable|string',
            'roll_number'    => 'required|unique:students,roll_number,' . $id,
            'address'        => 'nullable|string',
            'city'           => 'nullable|string',
            'state'          => 'nullable|string',
            'country'        => 'nullable|string',
            'pincode'        => 'nullable|max:10',
            'admission_date' => 'required|date',
            'fees'           => 'nullable|numeric',
            'profile_image'  => 'nullable|image|max:2048',
        ]);

        $validated['full_name'] = trim($validated['first_name'] . ' ' . ($validated['last_name'] ?? ''));
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('profile_image')) {
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('students', 'public');
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function delete($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }

    public function view($id)
    {
        $student = Student::findOrFail($id);

        return view('students.view', compact('student'));
    }
}