<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService
    ) {}

    public function show()
    {
        $contactEmail = $this->settingsService->getValue('contact_email');
        $contactPhone = $this->settingsService->getValue('contact_phone');
        $contactAddress = $this->settingsService->getValue('contact_address');
        $seoTitle = $this->settingsService->getSetting('contact_seo_title');
        $seoDescription = $this->settingsService->getSetting('contact_seo_description');

        return view('contact', [
            'contactEmail' => $contactEmail,
            'contactPhone' => $contactPhone,
            'contactAddress' => $contactAddress,
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
        ]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $submission = ContactSubmission::create($validated);

        // Send email notification
        \Illuminate\Support\Facades\Notification::route('mail', 'grapenstudio@gmail.com')
            ->notify(new \App\Notifications\ContactSubmissionNotification($submission));

        return redirect()->back()->with('success', 'Your message has been sent. Thank you.');
    }
}
