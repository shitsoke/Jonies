<?php

namespace App\Http\Controllers;

use App\Models\CareerApplication;
use Illuminate\Http\Request;

class CareerApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'resume'  => 'required|file|mimes:pdf,doc,docx|max:5120',
            'message' => 'nullable|string',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'local');

        CareerApplication::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'resume_path' => $resumePath,
            'message' => $validated['message'] ?? null,
        ]);

        return redirect()->route('careers')->with('success', 'Thank you for your application! Our team will review your resume shortly.');
    }
}