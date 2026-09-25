<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{
    /**
     * Store a newly created inquiry/lead in storage.
     */
    public function store(Request $request)
    {
        // Anti-spam honeypot check (hidden field in form)
        if ($request->filled('website_hp')) {
            if ($request->header('X-Inertia')) {
                return redirect()->back()->with('success', 'Your inquiry has been received! Our senior architect will contact you within 24 hours.');
            }
            return response()->json([
                'success' => true,
                'message' => 'Your inquiry has been received! Our senior architect will contact you within 24 hours.',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:120',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'company' => 'nullable|string|max:150',
            'service_interest' => 'nullable|string|max:100',
            'budget' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:3000',
        ]);

        if ($validator->fails()) {
            if ($request->header('X-Inertia')) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $clientName = trim($request->name ?? '');
        if (empty($clientName)) {
            $clientName = ucfirst(explode('@', $request->email)[0] ?? 'Growth Lead');
        }

        $clientIp = \App\Services\GeoIPService::getClientIp($request);
        $country = \App\Services\GeoIPService::getCountry($clientIp, $request);

        $inquiry = Inquiry::create([
            'name' => $clientName,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'service_interest' => $request->service_interest ?? 'Inbound Growth Inquiry',
            'budget' => $request->budget,
            'message' => $request->message ?? 'Submitted via website growth form.',
            'source_url' => $request->header('referer', url()->current()),
            'ip_address' => $clientIp,
            'country' => $country,
            'user_agent' => $request->userAgent(),
            'status' => 'new',
        ]);

        // Feature 3: Dispatch Free AI Lead Scoring & Intent Evaluation in background
        \App\Jobs\ScoreLeadJob::dispatchAfterResponse($inquiry->id);

        if ($request->header('X-Inertia')) {
            return redirect()->back()->with('success', 'Thank you! Your growth consultation request has been received. Our senior architect will review your domain and respond within 24 hours.');
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your growth consultation request has been received. Our senior architect will review your domain and respond within 24 hours.',
                'inquiry_id' => $inquiry->id,
            ]);
        }

        return redirect()->back()->with('success', 'Thank you! Your inquiry has been submitted successfully.');
    }
}
