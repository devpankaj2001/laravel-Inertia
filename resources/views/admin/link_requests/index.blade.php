@extends('admin.layouts.admin')

@section('title', 'Client Link Requests & Outreach')
@section('page_title', 'Client Link Requests & Monetization')

@section('admin_content')
<div class="space-y-6">

  <!-- Flash Messages -->
  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <i class="fas fa-check-circle text-lg"></i>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-300">
        <i class="fas fa-times"></i>
      </button>
    </div>
  @endif

  @if(isset($errors) && $errors->any())
    <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 space-y-1 text-xs">
      <p class="font-bold flex items-center gap-1.5">
        <i class="fas fa-triangle-exclamation"></i>
        <span>Please resolve the following:</span>
      </p>
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Top Metric Cards & Action Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
    <div>
      <h2 class="text-xl font-black text-white tracking-tight flex items-center gap-2">
        <i class="fas fa-link text-[#ff3b30]"></i>
        <span>Client Backlink Placements &amp; Deals</span>
      </h2>
      <p class="text-xs text-slate-400">Manage paid link insertions, client outreach, deals, and anchor text placements.</p>
    </div>

    <!-- Add Request Button -->
    <button type="button" onclick="openAddModal()"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs shadow-lg shadow-red-500/20 transition-all cursor-pointer shrink-0">
      <i class="fas fa-plus"></i>
      <span>Add Manual Link Request</span>
    </button>
  </div>

  <!-- Metric Summary Cards -->
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Deals</p>
        <p class="text-xl font-black text-white mt-1">{{ $counts['total'] }}</p>
      </div>
      <div class="w-9 h-9 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-[#ff3b30] text-sm">
        <i class="fas fa-link"></i>
      </div>
    </div>

    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pending</p>
        <p class="text-xl font-black text-purple-400 mt-1">{{ $counts['pending'] }}</p>
      </div>
      <div class="w-9 h-9 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 text-sm">
        <i class="fas fa-hourglass-half"></i>
      </div>
    </div>

    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Accepted</p>
        <p class="text-xl font-black text-emerald-400 mt-1">{{ $counts['accepted'] }}</p>
      </div>
      <div class="w-9 h-9 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-sm">
        <i class="fas fa-handshake"></i>
      </div>
    </div>

    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Link Live</p>
        <p class="text-xl font-black text-blue-400 mt-1">{{ $counts['published'] }}</p>
      </div>
      <div class="w-9 h-9 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 text-sm">
        <i class="fas fa-check-double"></i>
      </div>
    </div>

    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Declined</p>
        <p class="text-xl font-black text-red-400 mt-1">{{ $counts['rejected'] }}</p>
      </div>
      <div class="w-9 h-9 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400 text-sm">
        <i class="fas fa-ban"></i>
      </div>
    </div>

    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trash</p>
        <p class="text-xl font-black text-slate-400 mt-1">{{ $counts['trashed'] }}</p>
      </div>
      <div class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 text-sm">
        <i class="fas fa-trash-alt"></i>
      </div>
    </div>
  </div>

  <!-- Filter & Search Bar -->
  <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex flex-wrap items-center gap-2">
      <span class="text-xs font-bold text-slate-400 mr-1 flex items-center gap-1.5">
        <i class="fas fa-filter text-[10px]"></i> View:
      </span>
      <a href="{{ route('admin.link_requests.index', array_filter(['search' => $search])) }}"
         class="px-3 py-1 rounded-lg text-xs font-bold transition-all {{ empty($statusFilter) ? 'bg-[#ff3b30] text-white shadow-sm' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
        All ({{ $counts['total'] }})
      </a>
      <a href="{{ route('admin.link_requests.index', array_filter(['status' => 'pending', 'search' => $search])) }}"
         class="px-3 py-1 rounded-lg text-xs font-bold transition-all {{ $statusFilter === 'pending' ? 'bg-[#ff3b30] text-white shadow-sm' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
        Pending ({{ $counts['pending'] }})
      </a>
      <a href="{{ route('admin.link_requests.index', array_filter(['status' => 'accepted', 'search' => $search])) }}"
         class="px-3 py-1 rounded-lg text-xs font-bold transition-all {{ $statusFilter === 'accepted' ? 'bg-[#ff3b30] text-white shadow-sm' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
        Accepted ({{ $counts['accepted'] }})
      </a>
      <a href="{{ route('admin.link_requests.index', array_filter(['status' => 'published', 'search' => $search])) }}"
         class="px-3 py-1 rounded-lg text-xs font-bold transition-all {{ $statusFilter === 'published' ? 'bg-[#ff3b30] text-white shadow-sm' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
        Link Live ({{ $counts['published'] }})
      </a>
      <a href="{{ route('admin.link_requests.index', array_filter(['status' => 'rejected', 'search' => $search])) }}"
         class="px-3 py-1 rounded-lg text-xs font-bold transition-all {{ $statusFilter === 'rejected' ? 'bg-[#ff3b30] text-white shadow-sm' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
        Declined ({{ $counts['rejected'] }})
      </a>
      <a href="{{ route('admin.link_requests.index', ['status' => 'trashed', 'search' => $search]) }}"
         class="px-3 py-1 rounded-lg text-xs font-bold transition-all {{ $statusFilter === 'trashed' ? 'bg-amber-500 text-slate-950 shadow-sm' : 'bg-slate-800 text-slate-400 hover:bg-slate-700' }}">
        <i class="fas fa-trash-can mr-1"></i> Trash ({{ $counts['trashed'] }})
      </a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.link_requests.index') }}" class="flex items-center gap-2">
      @if(!empty($statusFilter))
        <input type="hidden" name="status" value="{{ $statusFilter }}">
      @endif
      <div class="relative">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search client, country, link..."
               class="w-56 sm:w-64 pl-8 pr-3 py-1.5 text-xs rounded-xl bg-slate-950 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30]">
        <i class="fas fa-search absolute left-2.5 top-2 text-slate-500 text-xs"></i>
      </div>
      @if(!empty($search))
        <a href="{{ route('admin.link_requests.index', array_filter(['status' => $statusFilter])) }}" class="px-2.5 py-1.5 rounded-xl bg-slate-800 text-slate-400 hover:text-white text-xs">
          Clear
        </a>
      @endif
    </form>
  </div>

  <!-- Requests Table -->
  <div class="rounded-2xl bg-slate-900 border border-slate-800 overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs">
        <thead>
          <tr class="border-b border-slate-800 bg-slate-950/60 text-slate-400 font-bold uppercase tracking-wider">
            <th class="py-3.5 px-4 text-center w-12">#</th>
            <th class="py-3.5 px-4">Client Name &amp; Country</th>
            <th class="py-3.5 px-4 text-center">Status</th>
            <th class="py-3.5 px-4">Target Article / Service</th>
            <th class="py-3.5 px-4">Requested Anchor &amp; Link</th>
            <th class="py-3.5 px-4">Deal / Budget</th>
            <th class="py-3.5 px-4 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/60">
          @forelse($requests as $req)
            <tr class="hover:bg-slate-800/40 transition-colors {{ $req->trashed() ? 'opacity-60 bg-red-950/10' : '' }}">
              <td class="py-4 px-4 text-center font-mono text-slate-500">
                #{{ $req->id }}
              </td>

              <!-- Client Name & Country -->
              <td class="py-4 px-4">
                <div class="space-y-1">
                  <div class="flex items-center gap-2">
                    <span class="font-extrabold text-white text-sm">{{ $req->client_name }}</span>
                    @if($req->country)
                      <span class="px-2 py-0.5 rounded-md bg-slate-800 text-slate-300 font-bold text-[10px] border border-slate-700 flex items-center gap-1">
                        <i class="fas fa-globe text-[9px] text-[#ff3b30]"></i>
                        {{ $req->country }}
                      </span>
                    @endif
                  </div>

                  @if($req->client_email && !str_starts_with($req->client_email, 'manual_'))
                    <a href="mailto:{{ $req->client_email }}" class="text-[#ff3b30] hover:underline flex items-center gap-1 text-[11px]">
                      <i class="fas fa-envelope text-[10px]"></i> {{ $req->client_email }}
                    </a>
                  @endif

                  @if($req->client_company || $req->client_website)
                    <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                      <span>{{ $req->client_company ?? 'Individual' }}</span>
                      @if($req->client_website)
                        <span>•</span>
                        <a href="{{ $req->client_website }}" target="_blank" class="text-blue-400 hover:underline flex items-center gap-1">
                          <i class="fas fa-arrow-up-right-from-square text-[9px]"></i> Web
                        </a>
                      @endif
                    </div>
                  @endif
                </div>
              </td>

              <!-- Status with Quick Switcher -->
              <td class="py-4 px-4 text-center">
                @if($req->trashed())
                  <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-500/20 text-red-400 border border-red-500/30">
                    Trashed
                  </span>
                @else
                  @php $badge = $req->status_badge; @endphp
                  <div class="space-y-1.5 inline-block text-center">
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badge['class'] }}">
                      {{ $badge['label'] }}
                    </span>
                    <form method="POST" action="{{ route('admin.link_requests.status', $req->id) }}">
                      @csrf
                      <select name="status" onchange="this.form.submit()"
                              class="px-2 py-0.5 rounded text-[10px] bg-slate-950 border border-slate-700 text-slate-300 focus:outline-none focus:border-[#ff3b30] cursor-pointer block mx-auto">
                        <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ $req->status === 'reviewed' ? 'selected' : '' }}>Reviewing</option>
                        <option value="accepted" {{ $req->status === 'accepted' ? 'selected' : '' }}>Deal Accepted</option>
                        <option value="published" {{ $req->status === 'published' ? 'selected' : '' }}>✓ Link Live</option>
                        <option value="rejected" {{ $req->status === 'rejected' ? 'selected' : '' }}>Declined</option>
                      </select>
                    </form>
                  </div>
                @endif
              </td>

              <!-- Target Article / Service -->
              <td class="py-4 px-4">
                <div class="max-w-[210px] space-y-0.5">
                  <p class="font-bold text-white line-clamp-1" title="{{ $req->target_page_title }}">
                    {{ $req->target_page_title ?? 'Target Page' }}
                  </p>
                  <a href="{{ $req->target_page_url }}" target="_blank" class="text-[11px] font-mono text-slate-400 hover:text-[#ff3b30] line-clamp-1 block">
                    {{ $req->target_page_url }}
                  </a>
                  <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-semibold bg-slate-800 text-slate-300">
                    {{ $req->link_type_label ?? 'Contextual Link' }}
                  </span>
                </div>
              </td>

              <!-- Requested Anchor & Link -->
              <td class="py-4 px-4">
                <div class="max-w-[230px] space-y-1">
                  @if($req->requested_anchor_text)
                    <p class="font-bold text-amber-300 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20 inline-block text-[11px]">
                      "{{ $req->requested_anchor_text }}"
                    </p>
                  @endif
                  @if($req->target_link_url)
                    <p class="font-mono text-[10px] text-slate-400 truncate">
                      <a href="{{ $req->target_link_url }}" target="_blank" class="text-blue-400 hover:underline flex items-center gap-1">
                        <i class="fas fa-link text-[9px]"></i> {{ $req->target_link_url }}
                      </a>
                    </p>
                  @endif
                  @if($req->proposed_context)
                    <p class="text-[10px] text-slate-400 line-clamp-2 italic border-l-2 border-slate-700 pl-1.5">
                      {{ $req->proposed_context }}
                    </p>
                  @endif
                </div>
              </td>

              <!-- Deal / Budget -->
              <td class="py-4 px-4">
                <div>
                  <span class="font-extrabold text-emerald-400 font-mono text-xs">
                    {{ $req->budget_offer ?? 'Negotiable' }}
                  </span>
                  <p class="text-[10px] text-slate-500 mt-0.5 font-mono">{{ $req->created_at->format('d M, Y') }}</p>
                </div>
              </td>

              <!-- Action: Edit, Delete, Restore, Copy -->
              <td class="py-4 px-4 text-center">
                @if($req->trashed())
                  <!-- Restore Form -->
                  <form method="POST" action="{{ route('admin.link_requests.restore', $req->id) }}" class="inline-block">
                    @csrf
                    <button type="submit" class="px-3 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 hover:bg-emerald-500/30 text-xs font-bold transition-colors">
                      <i class="fas fa-rotate-left mr-1"></i> Restore
                    </button>
                  </form>
                @else
                  <div class="flex items-center justify-center gap-1.5">
                    <!-- Edit Button -->
                    <button type="button" onclick="openEditModal({{ json_encode($req) }})"
                            class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors shadow-sm"
                            title="Edit Link Request Details">
                      <i class="fas fa-pen-to-square text-[11px]"></i>
                    </button>

                    <!-- Copy HTML Snippet -->
                    @if($req->target_link_url)
                      <button type="button"
                              onclick="navigator.clipboard.writeText('<a href=&quot;{{ $req->target_link_url }}&quot; target=&quot;_blank&quot; rel=&quot;noopener&quot;>{{ $req->requested_anchor_text ?? 'Link' }}</a>'); alert('Copied HTML Link Tag to clipboard! You can paste it into the Classic Editor in your blog/service.');"
                              class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-amber-500 text-slate-300 hover:text-slate-950 flex items-center justify-center transition-colors shadow-sm cursor-pointer"
                              title="Copy Ready-to-Paste HTML Link Tag">
                        <i class="fas fa-code text-[11px]"></i>
                      </button>
                    @endif

                    <!-- Quick Email Client -->
                    @if($req->client_email && !str_starts_with($req->client_email, 'manual_'))
                      <a href="mailto:{{ $req->client_email }}?subject={{ urlencode('Regarding your backlink placement on ' . ($req->target_page_title ?? 'WebRanker')) }}&body={{ urlencode("Hi {$req->client_name},\n\nWe are ready to place your link ('{$req->requested_anchor_text}') on:\n{$req->target_page_url}\n\nBudget: {$req->budget_offer}\n\nPlease confirm.\n\nBest regards,\nEditorial Team") }}"
                         class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-emerald-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors shadow-sm"
                         title="Email Client">
                        <i class="fas fa-envelope text-[11px]"></i>
                      </a>
                    @endif

                    <!-- Soft Delete Button -->
                    <form method="POST" action="{{ route('admin.link_requests.destroy', $req->id) }}"
                          onsubmit="return confirm('Move link request #{{ $req->id }} ({{ $req->client_name }}) to trash? (Soft Delete)');"
                          class="inline-block">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-red-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors shadow-sm"
                              title="Soft Delete">
                        <i class="fas fa-trash-can text-[11px]"></i>
                      </button>
                    </form>
                  </div>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-slate-500">
                <div class="flex flex-col items-center justify-center gap-2">
                  <i class="fas fa-link-slash text-2xl text-slate-600"></i>
                  <p class="text-sm font-semibold">No link insertion records found.</p>
                  <p class="text-xs text-slate-500">Click "+ Add Manual Link Request" to add your first deal.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($requests->hasPages())
      <div class="p-4 border-t border-slate-800">
        {{ $requests->links() }}
      </div>
    @endif
  </div>

</div>

<!-- ========================================== -->
<!-- 1. ADD MANUAL LINK REQUEST MODAL           -->
<!-- ========================================== -->
<div id="addLinkRequestModal" class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
  <div class="relative w-full max-w-2xl bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-2xl my-8">
    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-lg">
          <i class="fas fa-plus"></i>
        </div>
        <div>
          <h3 class="text-lg font-black text-white">Add Manual Link Request</h3>
          <p class="text-xs text-slate-400">Record a new client deal, target article/service, anchor text and budget.</p>
        </div>
      </div>
      <button type="button" onclick="closeAddModal()" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form method="POST" action="{{ route('admin.link_requests.store') }}" class="space-y-4">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Client Name -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Client Name <span class="text-[#ff3b30]">*</span>
          </label>
          <input type="text" name="client_name" required placeholder="e.g. John Doe / Semrush Media"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Country -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Country <span class="text-slate-500 lowercase">(optional)</span>
          </label>
          <input type="text" name="country" placeholder="e.g. United States, UK, Germany, India"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Client Email -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Client Email
          </label>
          <input type="email" name="client_email" placeholder="client@agency.com"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Company / Website -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Company / Agency
          </label>
          <input type="text" name="client_company" placeholder="e.g. Acme Tech Solutions"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>
      </div>

      <!-- Quick Selector for Target Article / Service -->
      <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-3">
        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
          <i class="fas fa-bullseye text-[#ff3b30] mr-1"></i> Target Article or Service Picker
        </label>
        
        <select id="addTargetPicker" onchange="fillTargetFields('add', this.value)"
                class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
          <option value="">-- Select an Article or Service (or enter manually below) --</option>
          <optgroup label="Blog Articles">
            @foreach($blogs as $b)
              <option value="{{ route('blogs.show', $b->slug) }}" data-title="{{ $b->title }}">{{ $b->title }}</option>
            @endforeach
          </optgroup>
          <optgroup label="Services">
            @foreach($services as $s)
              <option value="{{ route('services.show', $s->slug) }}" data-title="{{ $s->title }}">{{ $s->title }}</option>
            @endforeach
          </optgroup>
        </select>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
          <div>
            <label class="block text-[11px] font-semibold text-slate-400 mb-0.5">Target Title</label>
            <input type="text" id="add_target_page_title" name="target_page_title" placeholder="Article / Service Title"
                   class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
          <div>
            <label class="block text-[11px] font-semibold text-slate-400 mb-0.5">Target Page URL <span class="text-[#ff3b30]">*</span></label>
            <input type="text" id="add_target_page_url" name="target_page_url" required placeholder="https://... or /blogs/slug"
                   class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs font-mono focus:outline-none focus:border-[#ff3b30]">
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Requested Anchor Text -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Requested Anchor Text <span class="text-[#ff3b30]">*</span>
          </label>
          <input type="text" name="requested_anchor_text" required placeholder="e.g. best data platform"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Target Link URL -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Target Link URL <span class="text-[#ff3b30]">*</span>
          </label>
          <input type="url" name="target_link_url" required placeholder="https://client.com/page"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs font-mono focus:outline-none focus:border-[#ff3b30]">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Deal / Budget Offer -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Deal / Budget
          </label>
          <input type="text" name="budget_offer" placeholder="e.g. $150, $250 / year, $500"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-emerald-400 font-mono text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Status -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Initial Status <span class="text-[#ff3b30]">*</span>
          </label>
          <select name="status" required
                  class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
            <option value="pending">Pending Review</option>
            <option value="reviewed">Reviewing Proposal</option>
            <option value="accepted" selected>Deal Accepted</option>
            <option value="published">✓ Link Live (Published)</option>
            <option value="rejected">Declined</option>
          </select>
        </div>
      </div>

      <!-- Proposed Context / Sentence -->
      <div>
        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
          Proposed Context / Sentence in Article
        </label>
        <textarea name="proposed_context" rows="2" placeholder="e.g. In Section 3, paragraph 2, link the phrase 'best data platform' to client URL."
                  class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]"></textarea>
      </div>

      <!-- Admin Notes -->
      <div>
        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
          Internal Notes (Payment/Invoice/Contact)
        </label>
        <input type="text" name="admin_notes" placeholder="e.g. Paid via PayPal on 23 Sept. Invoice #1042."
               class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
      </div>

      <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
        <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs font-bold hover:bg-slate-700 transition-colors">
          Cancel
        </button>
        <button type="submit" class="px-5 py-2 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white text-xs font-extrabold shadow-md shadow-red-500/20 transition-all">
          <i class="fas fa-check mr-1"></i> Save Link Deal
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========================================== -->
<!-- 2. EDIT LINK REQUEST MODAL                 -->
<!-- ========================================== -->
<div id="editLinkRequestModal" class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
  <div class="relative w-full max-w-2xl bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-2xl my-8">
    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-lg">
          <i class="fas fa-pen-to-square"></i>
        </div>
        <div>
          <h3 class="text-lg font-black text-white">Edit Link Request #<span id="editIdLabel"></span></h3>
          <p class="text-xs text-slate-400">Update deal status, country, target page, anchor text or budget.</p>
        </div>
      </div>
      <button type="button" onclick="closeEditModal()" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form id="editLinkForm" method="POST" action="" class="space-y-4">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Client Name -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Client Name <span class="text-[#ff3b30]">*</span>
          </label>
          <input type="text" id="edit_client_name" name="client_name" required
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Country -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Country
          </label>
          <input type="text" id="edit_country" name="country" placeholder="e.g. United States, UK, Germany"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Client Email -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Client Email
          </label>
          <input type="email" id="edit_client_email" name="client_email"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Company -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Company / Agency
          </label>
          <input type="text" id="edit_client_company" name="client_company"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>
      </div>

      <!-- Quick Selector for Target Article / Service in Edit -->
      <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-3">
        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
          <i class="fas fa-bullseye text-[#ff3b30] mr-1"></i> Target Article or Service
        </label>
        
        <select onchange="fillTargetFields('edit', this.value)"
                class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
          <option value="">-- Quick Pick Article or Service --</option>
          <optgroup label="Blog Articles">
            @foreach($blogs as $b)
              <option value="{{ route('blogs.show', $b->slug) }}" data-title="{{ $b->title }}">{{ $b->title }}</option>
            @endforeach
          </optgroup>
          <optgroup label="Services">
            @foreach($services as $s)
              <option value="{{ route('services.show', $s->slug) }}" data-title="{{ $s->title }}">{{ $s->title }}</option>
            @endforeach
          </optgroup>
        </select>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
          <div>
            <label class="block text-[11px] font-semibold text-slate-400 mb-0.5">Target Title</label>
            <input type="text" id="edit_target_page_title" name="target_page_title"
                   class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
          <div>
            <label class="block text-[11px] font-semibold text-slate-400 mb-0.5">Target Page URL <span class="text-[#ff3b30]">*</span></label>
            <input type="text" id="edit_target_page_url" name="target_page_url" required
                   class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs font-mono focus:outline-none focus:border-[#ff3b30]">
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Requested Anchor Text -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Requested Anchor Text <span class="text-[#ff3b30]">*</span>
          </label>
          <input type="text" id="edit_requested_anchor_text" name="requested_anchor_text" required
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Target Link URL -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Target Link URL <span class="text-[#ff3b30]">*</span>
          </label>
          <input type="url" id="edit_target_link_url" name="target_link_url" required
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs font-mono focus:outline-none focus:border-[#ff3b30]">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Deal / Budget Offer -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Deal / Budget
          </label>
          <input type="text" id="edit_budget_offer" name="budget_offer"
                 class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-emerald-400 font-mono text-xs focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Status -->
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
            Status <span class="text-[#ff3b30]">*</span>
          </label>
          <select id="edit_status" name="status" required
                  class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
            <option value="pending">Pending Review</option>
            <option value="reviewed">Reviewing Proposal</option>
            <option value="accepted">Deal Accepted</option>
            <option value="published">✓ Link Live (Published)</option>
            <option value="rejected">Declined</option>
          </select>
        </div>
      </div>

      <!-- Proposed Context -->
      <div>
        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
          Proposed Context / Sentence in Article
        </label>
        <textarea id="edit_proposed_context" name="proposed_context" rows="2"
                  class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]"></textarea>
      </div>

      <!-- Admin Notes -->
      <div>
        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">
          Internal Notes (Payment/Invoice/Contact)
        </label>
        <input type="text" id="edit_admin_notes" name="admin_notes"
               class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
      </div>

      <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
        <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs font-bold hover:bg-slate-700 transition-colors">
          Cancel
        </button>
        <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold shadow-md shadow-blue-500/20 transition-all">
          <i class="fas fa-check mr-1"></i> Update Link Deal
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function openAddModal() {
    document.getElementById('addLinkRequestModal').classList.remove('hidden');
  }

  function closeAddModal() {
    document.getElementById('addLinkRequestModal').classList.add('hidden');
  }

  function openEditModal(req) {
    if (!req) return;
    document.getElementById('editIdLabel').textContent = req.id;
    document.getElementById('editLinkForm').action = "{{ url('admin/link-requests') }}/" + req.id;

    document.getElementById('edit_client_name').value = req.client_name || '';
    document.getElementById('edit_country').value = req.country || '';
    document.getElementById('edit_client_email').value = (req.client_email && !req.client_email.startsWith('manual_')) ? req.client_email : '';
    document.getElementById('edit_client_company').value = req.client_company || '';
    document.getElementById('edit_target_page_title').value = req.target_page_title || '';
    document.getElementById('edit_target_page_url').value = req.target_page_url || '';
    document.getElementById('edit_requested_anchor_text').value = req.requested_anchor_text || '';
    document.getElementById('edit_target_link_url').value = req.target_link_url || '';
    document.getElementById('edit_budget_offer').value = req.budget_offer || '';
    document.getElementById('edit_status').value = req.status || 'accepted';
    document.getElementById('edit_proposed_context').value = req.proposed_context || '';
    document.getElementById('edit_admin_notes').value = req.admin_notes || '';

    document.getElementById('editLinkRequestModal').classList.remove('hidden');
  }

  function closeEditModal() {
    document.getElementById('editLinkRequestModal').classList.add('hidden');
  }

  function fillTargetFields(mode, url) {
    if (!url) return;
    const select = event.target;
    const selectedOption = select.options[select.selectedIndex];
    const title = selectedOption ? selectedOption.getAttribute('data-title') : '';

    if (mode === 'add') {
      document.getElementById('add_target_page_url').value = url;
      if (title) document.getElementById('add_target_page_title').value = title;
    } else {
      document.getElementById('edit_target_page_url').value = url;
      if (title) document.getElementById('edit_target_page_title').value = title;
    }
  }

  // Close modals on escape key or clicking backdrop
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeAddModal();
      closeEditModal();
    }
  });

  window.addEventListener('click', function(e) {
    if (e.target === document.getElementById('addLinkRequestModal')) closeAddModal();
    if (e.target === document.getElementById('editLinkRequestModal')) closeEditModal();
  });
</script>
@endsection
