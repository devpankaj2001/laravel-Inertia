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

        if ($request->filled('intent')) {
            $query->where('lead_intent', $request->intent);
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

    /**
     * Trigger on-demand AI Lead Scoring & Reply generation
     */
    public function reanalyze(Inquiry $inquiry)
    {
        $scored = \App\Services\LeadScoringService::scoreInquiry($inquiry);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'inquiry' => $scored,
                'message' => "Lead #{$inquiry->id} successfully scored with AI!",
            ]);
        }

        return back()->with('success', "Lead #{$inquiry->id} analyzed: Score {$scored->lead_score}/100 ({$scored->intent_label})");
    }

    /**
     * Get AI Score, requirement summary, and suggested reply draft
     */
    public function aiInsight(Inquiry $inquiry)
    {
        if (empty($inquiry->lead_score) || empty($inquiry->ai_suggested_reply)) {
            $inquiry = \App\Services\LeadScoringService::scoreInquiry($inquiry);
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $inquiry->phone ?? '');
        $waUrl = !empty($cleanPhone)
            ? 'https://wa.me/' . $cleanPhone . '?text=' . urlencode($inquiry->ai_suggested_reply ?? '')
            : null;

        $mailSubject = 'Regarding your inquiry with WebRanker (' . ($inquiry->service_interest ?: 'Web & Growth') . ')';
        $mailUrl = 'mailto:' . $inquiry->email . '?subject=' . urlencode($mailSubject) . '&body=' . urlencode($inquiry->ai_suggested_reply ?? '');

        return response()->json([
            'success' => true,
            'lead' => [
                'id' => $inquiry->id,
                'name' => $inquiry->name,
                'email' => $inquiry->email,
                'phone' => $inquiry->phone,
                'company' => $inquiry->company,
                'service' => $inquiry->service_interest,
                'budget' => $inquiry->budget,
                'message' => $inquiry->message,
                'score' => $inquiry->lead_score,
                'intent' => $inquiry->lead_intent,
                'intent_label' => $inquiry->intent_label,
                'badge_class' => $inquiry->intent_badge_class,
                'summary' => $inquiry->ai_summary,
                'suggested_reply' => $inquiry->ai_suggested_reply,
                'analyzed_at' => $inquiry->ai_analyzed_at?->format('M d, Y h:i A') ?: 'Just now',
                'wa_url' => $waUrl,
                'mail_url' => $mailUrl,
            ],
        ]);
    }
}
