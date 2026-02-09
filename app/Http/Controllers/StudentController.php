<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    
    public function apiIndex()
    {
        $students = Student::all();  
        return response()->json($students);  
    }

    
    public function apiShow($id)
    {
        $student = Student::find($id); 
        if ($student) {
            return response()->json($student); 
        } else {
            return response()->json(['message' => 'Student not found'], 404); 
        }
    }

    public function apiUpdate(Request $request, $id)
    {
        $student = Student::find($id);  
        if ($student) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'student_id' => 'required|string|max:50|unique:students,student_id,' . $id,
                'age' => 'required|integer|min:1|max:120',
            ]);

            $student->update($validated); 
            return response()->json($student); 
        } else {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    
    public function apiDestroy($id)
    {
        $student = Student::find($id);  
        if ($student) {
            $student->delete();  
            return response()->json(['message' => 'Student deleted successfully']);
        } else {
            return response()->json(['message' => 'Student not found'], 404); 
        }
    }

    /**
     * Store a newly created resource in storage via API.
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50|unique:students,student_id',
            'age' => 'required|integer|min:1|max:120',
        ]);

        $student = Student::create($validated);
        return response()->json($student, 201);
    }


    public function index()
    {
        $students = Student::orderBy('id', 'asc')->get();
        return view('students.index', compact('students'));
    }
    
    public function create()
    {
         return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'student_id' => 'required|string|max:50|unique:students,student_id',
        'age' => 'required|integer|min:1|max:120',
    ]);

    Student::create($validated);

    return redirect('/students/create')->with('success', 'Student saved successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
    return view('students.index', compact('student'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'student_id' => 'required|string|max:50|unique:students,student_id,' . $student->id,
        'age' => 'required|integer|min:1|max:120',
    ]);

    $student->update($validated);

    return redirect()->route('students.index')->with('success', 'Student updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
    $student->delete();
    return redirect()->route('students.index')->with('success', 'Student deleted!');
    }

}