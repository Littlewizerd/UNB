<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SemesterController extends Controller
{
    /**
     * Display a listing of semesters
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $semesters = Semester::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%");
        })
        ->orderBy('year', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('semesters.index', compact('semesters', 'search'));
    }

    /**
     * Show the form for creating a new semester
     */
    public function create()
    {
        return view('semesters.create');
    }

    /**
     * Store a newly created semester
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'year' => 'required|integer|min:2560|max:2650',
            'is_active' => 'boolean',
        ]);

        Semester::create($request->all());

        return redirect()->route('semesters.index')->with('success', 'สร้างภาคเรียนสำเร็จ');
    }

    /**
     * Display the specified semester
     */
    public function show(Semester $semester)
    {
        return view('semesters.show', compact('semester'));
    }

    /**
     * Show the form for editing the semester
     */
    public function edit(Semester $semester)
    {
        return view('semesters.edit', compact('semester'));
    }

    /**
     * Update the specified semester
     */
    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'year' => 'required|integer|min:2560|max:2650',
            'is_active' => 'boolean',
        ]);

        $semester->update($request->all());

        return redirect()->route('semesters.index')->with('success', 'อัปเดตภาคเรียนสำเร็จ');
    }

    /**
     * Remove the specified semester
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()->route('semesters.index')->with('success', 'ลบภาคเรียนสำเร็จ');
    }
}
