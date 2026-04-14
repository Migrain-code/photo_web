<?php

namespace App\Http\Controllers;

use App\Models\ProjectSubmission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function show()
    {
        $services = array_keys(ProjectSubmission::serviceOptions());

        $countryCodes = [
            'US +1' => '+1',
            'TR +90' => '+90',
            'UK +44' => '+44',
            'DE +49' => '+49',
            'FR +33' => '+33',
            'NL +31' => '+31',
            'ES +34' => '+34',
            'IT +39' => '+39',
        ];

        return view('start-a-project', [
            'services' => $services,
            'countryCodes' => $countryCodes,
        ]);
    }

    public function submit(Request $request)
    {
        $services = array_keys(ProjectSubmission::serviceOptions());

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone_country' => ['required', 'string', 'max:10'],
            'phone_number' => ['required', 'string', 'max:30'],
            'message' => ['required', 'string'],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['required', 'string', Rule::in($services)],
        ]);

        $phone = trim($validated['phone_country'] . ' ' . $validated['phone_number']);

        $submission = ProjectSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $phone,
            'message' => $validated['message'],
            'services' => $validated['services'],
        ]);

        // Send email notification
        \Illuminate\Support\Facades\Notification::route('mail', 'grapenstudio@gmail.com')
            ->notify(new \App\Notifications\ProjectSubmissionNotification($submission));

        return redirect()->back()->with('success', 'Thank you. Your project request has been submitted.');
    }
}
