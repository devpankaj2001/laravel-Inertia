<?php

namespace App\Http\Controllers;

use App\Models\AiAudit;
use App\Services\SEOAuditorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AuditController extends Controller
{
    /**
     * Run real-time performance and SEO audit.
     */
    public function runAudit(Request $request, SEOAuditorService $auditorService)
    {
        // Rate-limiting: Max 10 audit runs per minute per IP to avoid abuse
        $ip = $request->ip();
        $rateKey = 'audit-run:' . $ip;

        if (RateLimiter::tooManyAttempts($rateKey, 10)) {
            $seconds = RateLimiter::availableIn($rateKey);
            return response()->json([
                'success' => false,
                'message' => "Too many audit requests. Please wait {$seconds} seconds before running another diagnostic.",
            ], 429);
        }

        RateLimiter::hit($rateKey, 60);

        $validated = $request->validate([
            'domain' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        try {
            $result = $auditorService->auditDomain(
                $validated['domain'],
                $validated['email'],
                $validated['phone'] ?? null,
                $request
            );

            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate audit: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Fetch a specific audit report by ID.
     */
    public function show($id)
    {
        $audit = AiAudit::with('inquiry')->findOrFail($id);

        return response()->json([
            'success' => true,
            'audit' => $audit,
        ]);
    }

    /**
     * Admin view for all audits.
     */
    public function adminIndex(Request $request)
    {
        $query = AiAudit::with('inquiry')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('domain_url', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('country', 'like', "%{$s}%")
                  ->orWhere('ip_address', 'like', "%{$s}%");
            });
        }

        $audits = $query->paginate(15)->withQueryString();

        return view('admin.audits.index', compact('audits'));
    }

    /**
     * Admin delete an audit record.
     */
    public function adminDestroy(AiAudit $audit)
    {
        $audit->delete();

        return redirect()->back()->with('success', 'Audit record deleted successfully.');
    }
}
