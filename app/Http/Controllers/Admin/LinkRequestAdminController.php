<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\LinkRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class LinkRequestAdminController extends Controller
{
    /**
     * Display a listing of client link insertion requests.
     */
    public function index(Request $request)
    {
        $statusFilter = $request->query('status');
        $search = $request->query('search');

        if ($statusFilter === 'trashed') {
            $query = LinkRequest::onlyTrashed()->latest('deleted_at');
        } else {
            $query = LinkRequest::latest();
            if (!empty($statusFilter)) {
                $query->where('status', $statusFilter);
            }
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_email', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('client_company', 'like', "%{$search}%")
                  ->orWhere('target_page_title', 'like', "%{$search}%")
                  ->orWhere('requested_anchor_text', 'like', "%{$search}%")
                  ->orWhere('target_link_url', 'like', "%{$search}%");
            });
        }

        $requests = $query->paginate(15)->withQueryString();

        $counts = [
            'total' => LinkRequest::count(),
            'pending' => LinkRequest::where('status', 'pending')->count(),
            'accepted' => LinkRequest::where('status', 'accepted')->count(),
            'published' => LinkRequest::where('status', 'published')->count(),
            'rejected' => LinkRequest::where('status', 'rejected')->count(),
            'trashed' => LinkRequest::onlyTrashed()->count(),
        ];

        // Fetch targets for dropdown in Add/Edit modal
        $blogs = BlogPost::select('id', 'title', 'slug')->latest()->get();
        $services = Service::select('id', 'title', 'slug')->orderBy('title')->get();

        return view('admin.link_requests.index', compact('requests', 'counts', 'statusFilter', 'search', 'blogs', 'services'));
    }

    /**
     * Store a manually created link insertion request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:120',
            'client_email' => 'nullable|email|max:150',
            'country' => 'nullable|string|max:100',
            'client_company' => 'nullable|string|max:150',
            'client_website' => 'nullable|string|max:255',
            'target_page_title' => 'nullable|string|max:255',
            'target_page_url' => 'required|string|max:255',
            'requested_anchor_text' => 'required|string|max:255',
            'target_link_url' => 'required|string|max:255',
            'link_type' => 'nullable|string|max:60',
            'budget_offer' => 'nullable|string|max:100',
            'status' => 'required|in:pending,reviewed,accepted,published,rejected',
            'proposed_context' => 'nullable|string|max:2000',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        if (empty($validated['client_email'])) {
            $validated['client_email'] = 'manual_' . time() . '@client.local';
        }

        $linkReq = LinkRequest::create($validated);

        return redirect()->route('admin.link_requests.index')->with('success', "Link request for '{$linkReq->client_name}' created successfully.");
    }

    /**
     * Update an existing link request.
     */
    public function update(Request $request, LinkRequest $linkRequest)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:120',
            'client_email' => 'nullable|email|max:150',
            'country' => 'nullable|string|max:100',
            'client_company' => 'nullable|string|max:150',
            'client_website' => 'nullable|string|max:255',
            'target_page_title' => 'nullable|string|max:255',
            'target_page_url' => 'required|string|max:255',
            'requested_anchor_text' => 'required|string|max:255',
            'target_link_url' => 'required|string|max:255',
            'link_type' => 'nullable|string|max:60',
            'budget_offer' => 'nullable|string|max:100',
            'status' => 'required|in:pending,reviewed,accepted,published,rejected',
            'proposed_context' => 'nullable|string|max:2000',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        if (empty($validated['client_email'])) {
            $validated['client_email'] = $linkRequest->client_email ?: ('manual_' . time() . '@client.local');
        }

        $linkRequest->update($validated);

        return redirect()->route('admin.link_requests.index')->with('success', "Link request #{$linkRequest->id} for '{$linkRequest->client_name}' updated successfully.");
    }

    /**
     * Update the status and admin notes of a link request.
     */
    public function updateStatus(Request $request, LinkRequest $linkRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,published,rejected',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $linkRequest->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
            ]);
        }

        return redirect()->back()->with('success', "Request #{$linkRequest->id} status updated to '{$linkRequest->status}'.");
    }

    /**
     * Soft delete a link insertion request.
     */
    public function destroy(LinkRequest $linkRequest)
    {
        $name = $linkRequest->client_name;
        $id = $linkRequest->id;
        $linkRequest->delete();

        return redirect()->route('admin.link_requests.index')->with('success', "Link request #{$id} ({$name}) moved to trash (soft deleted).");
    }

    /**
     * Restore a soft deleted link request.
     */
    public function restore($id)
    {
        $req = LinkRequest::onlyTrashed()->findOrFail($id);
        $req->restore();

        return redirect()->route('admin.link_requests.index', ['status' => 'trashed'])->with('success', "Link request #{$id} ({$req->client_name}) restored successfully.");
    }
}
