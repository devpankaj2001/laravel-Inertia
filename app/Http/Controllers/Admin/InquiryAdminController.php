<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryAdminController extends Controller
{
    /**
     * Display a listing of inquiries / leads.
     */
    public function index(Request $request)
    {
        $query = Inquiry::with(['conversation.messages'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('company', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('country', 'like', "%{$s}%")
                  ->orWhere('ip_address', 'like', "%{$s}%");
            });
        }

        $inquiries = $query->paginate(15)->withQueryString();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Retrieve the complete AI Chat transcript for this lead
     */
    public function chatHistory(Inquiry $inquiry)
    {
        $conversation = $inquiry->conversation;

        if (!$conversation && !empty($inquiry->session_id)) {
            $conversation = \App\Models\AIConversation::where('session_id', $inquiry->session_id)->first();
        }

        if (!$conversation && !empty($inquiry->email)) {
            $conversation = \App\Models\AIConversation::where('lead_email', $inquiry->email)->latest()->first();
        }

        if (!$conversation) {
            return response()->json([
                'success' => false,
                'message' => 'No recorded AI Chat session found for this direct inquiry.',
                'lead' => [
                    'id' => $inquiry->id,
                    'name' => $inquiry->name,
                    'email' => $inquiry->email,
                    'phone' => $inquiry->phone,
                    'country' => $inquiry->country ?: 'India',
                    'country_flag' => \App\Services\GeoIPService::getCountryFlag($inquiry->country),
                    'ip_address' => $inquiry->ip_address,
                ],
                'messages' => [],
            ]);
        }

        $messages = $conversation->messages()->orderBy('id', 'asc')->get();

        return response()->json([
            'success' => true,
            'lead' => [
                'id' => $inquiry->id,
                'name' => $inquiry->name,
                'email' => $inquiry->email,
                'phone' => $inquiry->phone,
                'country' => $inquiry->country ?: 'India',
                'country_flag' => \App\Services\GeoIPService::getCountryFlag($inquiry->country),
                'ip_address' => $inquiry->ip_address,
                'session_id' => $conversation->session_id,
                'service_interest' => $inquiry->service_interest,
                'created_at' => $inquiry->created_at->format('M d, Y h:i A'),
            ],
            'messages' => $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'role' => $msg->role,
                    'content' => $msg->content,
                    'time' => $msg->created_at?->format('h:i A') ?: '',
                ];
            }),
        ]);
    }

    /**
     * Update the status of an inquiry.
     */
    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'status' => 'required|in:new,in_review,contacted,closed',
        ]);

        $inquiry->update(['status' => $request->status]);

        return back()->with('success', "Lead #{$inquiry->id} status updated to " . ucfirst(str_replace('_', ' ', $request->status)));
    }
}
