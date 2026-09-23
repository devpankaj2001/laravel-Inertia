<?php

namespace App\Http\Controllers;

use App\Models\LinkRequest;
use Illuminate\Http\Request;

class LinkRequestController extends Controller
{
    /**
     * Store a client link placement or editorial collaboration inquiry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:150',
            'client_email' => 'required|email|max:150',
            'client_company' => 'nullable|string|max:150',
            'client_website' => 'nullable|url|max:255',
            'target_page_url' => 'required|string|max:255',
            'target_page_title' => 'nullable|string|max:255',
            'requested_anchor_text' => 'nullable|string|max:150',
            'target_link_url' => 'nullable|url|max:255',
            'link_type' => 'required|string|in:link_insertion,guest_post,sponsored_feature,service_partnership',
            'budget_offer' => 'nullable|string|max:100',
            'proposed_context' => 'nullable|string|max:1000',
            'message' => 'nullable|string|max:2000',
        ]);

        $linkRequest = LinkRequest::create([
            ...$validated,
            'status' => 'pending',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your link placement & partnership request has been submitted. Our editorial team will review and respond within 24 hours.',
                'id' => $linkRequest->id,
            ]);
        }

        return redirect()->back()->with('link_success', 'Thank you! Your link placement request has been submitted. Our editorial team will review it promptly.');
    }
}
