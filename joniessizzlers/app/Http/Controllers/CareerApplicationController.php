<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CareerApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'message' => ['nullable', 'string'],
        ]);

        $resume = $request->file('resume');
        $resumePath = $resume->storeAs('job-applications', time() . '-' . $resume->getClientOriginalName());

        $emailBody = "New job application received.\n\n";
        $emailBody .= "Name: " . $validated['name'] . "\n";
        $emailBody .= "Email: " . $validated['email'] . "\n";
        $emailBody .= "Message: " . ($validated['message'] ?? 'No message provided.') . "\n";

        Mail::raw($emailBody, function ($message) use ($validated, $resumePath) {
            $message->to('pamakevin774@gmail.com')
                ->subject('New Job Application')
                ->replyTo($validated['email'], $validated['name']);

            if (Storage::exists($resumePath)) {
                $message->attach(Storage::path($resumePath), [
                    'as' => basename($resumePath),
                    'mime' => Storage::mimeType($resumePath),
                ]);
            }
        });

        Storage::delete($resumePath);

        return redirect()->route('careers')->with('success', 'Your application has been submitted successfully.');
    }
}
