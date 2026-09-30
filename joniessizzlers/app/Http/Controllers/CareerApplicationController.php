<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // Save resume file to storage/app/public/resumes
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        // Redirect back to the careers page with a success message
        return redirect()->route('careers')->with('success', 'Thank you for your application! Our team will review your resume shortly.');
    }
}