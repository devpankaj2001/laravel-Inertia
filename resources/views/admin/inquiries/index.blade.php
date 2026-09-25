@extends('admin.layouts.admin')

@section('title', 'Inquiries & Growth Leads')
@section('page_title', 'Inbound Leads & Growth Inquiries')

@section('admin_content')

<div class="space-y-6">

  <!-- Header Filter Bar -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('admin.inquiries.index') }}"
         class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ !request('status') && !request('intent') ? 'bg-[#ff3b30] text-white' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
        All Leads
      </a>
      <a href="{{ route('admin.inquiries.index', ['intent' => 'enterprise']) }}"
         class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors {{ request('intent') === 'enterprise' ? 'bg-emerald-600 text-white' : 'bg-slate-800 text-emerald-400 hover:bg-slate-700 border border-emerald-500/20' }}">
        🚀 Enterprise (85+)
      </a>
      <a href="{{ route('admin.inquiries.index', ['intent' => 'hot']) }}"
         class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors {{ request('intent') === 'hot' ? 'bg-amber-600 text-white' : 'bg-slate-800 text-amber-400 hover:bg-slate-700 border border-amber-500/20' }}">
        🔥 High-Intent
      </a>
      <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}"
         class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ request('status') === 'new' ? 'bg-[#ff3b30] text-white' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
        New
      </a>
      <a href="{{ route('admin.inquiries.index', ['status' => 'in_review']) }}"
         class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ request('status') === 'in_review' ? 'bg-[#ff3b30] text-white' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
        In Review
      </a>
      <a href="{{ route('admin.inquiries.index', ['status' => 'contacted']) }}"
         class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ request('status') === 'contacted' ? 'bg-[#ff3b30] text-white' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
        Contacted
      </a>
      <a href="{{ route('admin.inquiries.index', ['status' => 'closed']) }}"
         class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ request('status') === 'closed' ? 'bg-[#ff3b30] text-white' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
        Closed
      </a>
    </div>

    <!-- Search input -->
    <form method="GET" action="{{ route('admin.inquiries.index') }}" class="flex items-center gap-2">
      <div class="relative w-full sm:w-64">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-500 text-xs">
          <i class="fas fa-search"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, company..."
               class="w-full pl-9 pr-4 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:border-[#ff3b30] focus:outline-none">
      </div>
      @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
      @endif
      @if(request('intent'))
        <input type="hidden" name="intent" value="{{ request('intent') }}">
      @endif
      <button type="submit" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition-colors">
        Filter
      </button>
    </form>
  </div>

  <!-- Inquiries Table -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 space-y-4">
    @if($inquiries->isEmpty())
      <div class="py-12 text-center text-slate-500 text-sm space-y-2">
        <i class="fas fa-inbox text-3xl text-slate-700 block"></i>
        <p>No inquiries found matching your filter criteria.</p>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wider font-semibold">
              <th class="py-3 px-4">Lead ID &amp; Contact</th>
              <th class="py-3 px-4">Location &amp; IP</th>
              <th class="py-3 px-4">Service &amp; Budget</th>
              <th class="py-3 px-4">AI Score &amp; Intent</th>
              <th class="py-3 px-4">Message / Requirements</th>
              <th class="py-3 px-4">Date</th>
              <th class="py-3 px-4">Status &amp; Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            @foreach($inquiries as $inq)
              @php
                $hasChat = !empty($inq->conversation_id) || !empty($inq->session_id) || ($inq->conversation && $inq->conversation->messages->count() > 0);
                $countryFlag = \App\Services\GeoIPService::getCountryFlag($inq->country);
              @endphp
              <tr class="hover:bg-slate-800/30 transition-colors align-top">
                <td class="py-4 px-4">
                  <div class="flex items-center gap-2">
                    <span class="text-xs font-mono text-slate-500">#{{ $inq->id }}</span>
                    @if($hasChat)
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-[10px] font-bold">
                        <i class="fas fa-robot text-[9px]"></i> AI Lead
                      </span>
                    @endif
                  </div>
                  <div class="font-bold text-white text-sm mt-0.5">{{ $inq->name }}</div>
                  <a href="mailto:{{ $inq->email }}" class="text-xs text-[#ff3b30] hover:underline block">{{ $inq->email }}</a>
                  @if($inq->phone && $inq->phone !== '—')
                    <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                      <i class="fas fa-phone-alt text-[10px] text-slate-500"></i>
                      <span>{{ $inq->phone }}</span>
                    </div>
                  @endif
                </td>

                <td class="py-4 px-4 text-xs">
                  <div class="flex items-center gap-1.5 font-semibold text-slate-200">
                    <span class="text-base leading-none">{{ $countryFlag }}</span>
                    <span>{{ $inq->country ?: 'India' }}</span>
                  </div>
                  <div class="text-[11px] font-mono text-slate-500 mt-1">
                    {{ $inq->ip_address ?: '127.0.0.1' }}
                  </div>
                  @if($inq->company && $inq->company !== 'Direct Prospect')
                    <div class="text-[11px] text-slate-400 mt-1 truncate max-w-[140px]" title="{{ $inq->company }}">
                      <i class="fas fa-building text-[9px] text-slate-500 mr-1"></i>{{ $inq->company }}
                    </div>
                  @endif
                </td>

                <td class="py-4 px-4">
                  <span class="inline-block px-2.5 py-1 rounded-lg bg-slate-800 text-xs font-semibold text-slate-300 mb-1">
                    {{ $inq->service_interest ?? 'Custom Web Development' }}
                  </span>
                  @if($inq->budget)
                    <div class="text-[11px] text-emerald-400 font-mono">{{ $inq->budget }}</div>
                  @endif
                </td>

                <!-- AI Score & Intent (Feature 3) -->
                <td class="py-4 px-4 text-xs">
                  @if($inq->lead_score !== null)
                    <div class="space-y-1.5">
                      <div class="flex items-center gap-1.5">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-black border {{ $inq->intent_badge_class }}">
                          {{ $inq->lead_score }}/100
                        </span>
                      </div>
                      <div class="text-[11px] font-bold text-slate-300">
                        {{ $inq->intent_label }}
                      </div>
                      <button type="button"
                              onclick="openAiInsightModal({{ $inq->id }})"
                              class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-300 font-bold border border-indigo-500/30 text-[11px] transition-colors">
                        <i class="fas fa-wand-magic-sparkles text-[10px]"></i>
                        <span>AI Draft Reply</span>
                      </button>
                    </div>
                  @else
                    <button type="button"
                            onclick="openAiInsightModal({{ $inq->id }})"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold border border-slate-700 transition-colors">
                      <i class="fas fa-bolt text-amber-400 text-xs"></i>
                      <span>Score Lead</span>
                    </button>
                  @endif
                </td>

                <td class="py-4 px-4 text-xs text-slate-400 max-w-xs">
                  <div class="line-clamp-2">{{ $inq->message ?: 'No additional message provided.' }}</div>
                  @if($hasChat)
                    <div class="mt-2.5">
                      <button type="button"
                              onclick="openChatModal({{ $inq->id }})"
                              class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-red-600/20 to-orange-600/20 hover:from-red-600 hover:to-orange-600 border border-red-500/40 hover:border-transparent text-red-300 hover:text-white rounded-xl text-xs font-bold transition-all shadow-sm group">
                        <i class="fas fa-comments text-red-400 group-hover:text-white transition-colors"></i>
                        <span>View Chat</span>
                        @if($inq->conversation && $inq->conversation->messages->count() > 0)
                          <span class="px-1.5 py-0.2 bg-red-500/30 group-hover:bg-white/20 text-red-200 group-hover:text-white text-[10px] rounded-full font-mono">
                            {{ $inq->conversation->messages->count() }}
                          </span>
                        @endif
                      </button>
                    </div>
                  @endif
                </td>

                <td class="py-4 px-4 text-xs text-slate-400 whitespace-nowrap">
                  <div>{{ $inq->created_at->format('M d, Y') }}</div>
                  <div class="text-[10px] text-slate-500">{{ $inq->created_at->format('h:i A') }}</div>
                </td>

                <td class="py-4 px-4 whitespace-nowrap">
                  <div class="space-y-2">
                    <form method="POST" action="{{ route('admin.inquiries.status', $inq->id) }}" class="flex items-center gap-2">
                      @csrf
                      <select name="status" onchange="this.form.submit()"
                              class="text-xs font-semibold rounded-lg bg-slate-950 border border-slate-700 px-2.5 py-1 text-slate-200 focus:outline-none focus:border-[#ff3b30]">
                        <option value="new" {{ $inq->status === 'new' ? 'selected' : '' }}>New</option>
                        <option value="in_review" {{ $inq->status === 'in_review' ? 'selected' : '' }}>In Review</option>
                        <option value="contacted" {{ $inq->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="closed" {{ $inq->status === 'closed' ? 'selected' : '' }}>Closed</option>
                      </select>
                    </form>

                    @if($hasChat)
                      <button type="button"
                              onclick="openChatModal({{ $inq->id }})"
                              class="text-[11px] text-red-400 hover:text-red-300 font-medium flex items-center gap-1">
                        <i class="fas fa-eye text-[10px]"></i> View Chat Transcript
                      </button>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="pt-4 border-t border-slate-800">
        {{ $inquiries->links() }}
      </div>
    @endif
  </div>

</div>

<!-- AI Lead Insight & Ready Reply Modal (Feature 3) -->
<div id="aiInsightModal"
     class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md hidden items-center justify-center p-4 transition-all duration-200"
     role="dialog"
     aria-modal="true"
     aria-labelledby="aiInsightModalTitle">
  
  <div class="bg-slate-900 border border-slate-700/80 rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh] animate-in fade-in zoom-in-95 duration-200">
    <!-- Header -->
    <div class="p-5 border-b border-slate-800 bg-slate-950/70 flex items-start justify-between gap-4">
      <div class="space-y-1">
        <div class="flex items-center gap-2">
          <span class="inline-flex items-center justify-center w-7 h-7 rounded-xl bg-indigo-500/20 text-indigo-400 text-sm">
            <i class="fas fa-robot"></i>
          </span>
          <h3 id="aiInsightModalTitle" class="text-base font-bold text-white">AI Lead Scoring &amp; Reply Strategy</h3>
          <span id="aiInsightLeadId" class="text-xs font-mono text-slate-500"></span>
        </div>
        <p id="aiInsightClientDetails" class="text-xs text-slate-400"></p>
      </div>
      <button type="button"
              onclick="closeAiInsightModal()"
              class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-slate-800 transition-colors">
        <i class="fas fa-times text-sm"></i>
      </button>
    </div>

    <!-- Body Content -->
    <div id="aiInsightBody" class="p-6 overflow-y-auto space-y-5">
      <!-- Loading State -->
      <div id="aiInsightLoading" class="py-16 text-center text-slate-400 space-y-3">
        <i class="fas fa-circle-notch fa-spin text-2xl text-indigo-400"></i>
        <p class="text-xs">Analyzing lead intent and synthesizing personalized draft reply with Groq AI...</p>
      </div>

      <!-- Loaded Content -->
      <div id="aiInsightContent" class="space-y-5 hidden">
        <!-- Score & Intent Banner -->
        <div class="flex flex-wrap items-center justify-between gap-3 p-4 rounded-2xl bg-slate-950 border border-slate-800">
          <div>
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Intent Classification</div>
            <div id="aiInsightIntentLabel" class="text-sm font-extrabold text-white flex items-center gap-1.5"></div>
          </div>
          <div>
            <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1 text-right">Lead Score</div>
            <span id="aiInsightScoreBadge" class="px-3 py-1 rounded-xl text-sm font-black border"></span>
          </div>
        </div>

        <!-- AI Executive Requirement Summary -->
        <div class="space-y-1.5">
          <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
            <i class="fas fa-file-lines text-indigo-400"></i>
            <span>Client Requirement Analysis</span>
          </h4>
          <p id="aiInsightSummary" class="text-xs text-slate-300 leading-relaxed bg-slate-950 p-3.5 rounded-2xl border border-slate-800/80"></p>
        </div>

        <!-- Ready-to-Send Suggested Reply -->
        <div class="space-y-2">
          <div class="flex items-center justify-between">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
              <i class="fas fa-reply text-emerald-400"></i>
              <span>Ready-to-Send Draft Response (5-Minute Close)</span>
            </h4>
            <span class="text-[10px] text-slate-500">Edit or copy directly</span>
          </div>
          <textarea id="aiInsightDraftReply"
                    rows="6"
                    class="w-full p-4 rounded-2xl bg-slate-950 border border-slate-800 text-xs text-slate-200 leading-relaxed focus:outline-none focus:border-indigo-500 font-mono resize-y"></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="pt-2 flex flex-wrap items-center justify-between gap-3">
          <div class="flex items-center gap-2">
            <button type="button"
                    onclick="copyAiDraftReply()"
                    id="copyDraftBtn"
                    class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-md">
              <i class="fas fa-copy text-xs"></i>
              <span>Copy Reply</span>
            </button>

            <a id="aiInsightWhatsappBtn"
               href="#"
               target="_blank"
               rel="noreferrer"
               class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-md hidden">
              <i class="fab fa-whatsapp text-sm"></i>
              <span>Open in WhatsApp</span>
            </a>

            <a id="aiInsightEmailBtn"
               href="#"
               class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all border border-slate-700">
              <i class="fas fa-envelope text-xs"></i>
              <span>Open in Mail</span>
            </a>
          </div>

          <button type="button"
                  id="reanalyzeBtn"
                  onclick="triggerReanalyzeCurrentLead()"
                  class="px-3 py-2 bg-slate-950 hover:bg-slate-800 text-slate-400 hover:text-white rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-colors border border-slate-800">
            <i class="fas fa-rotate text-[11px]"></i>
            <span>Re-score with AI</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- AI Chat History Modal Popup -->
<div id="chatHistoryModal"
     class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md hidden items-center justify-center p-4 transition-all duration-200"
     role="dialog"
     aria-modal="true"
     aria-labelledby="chatModalTitle">
  
  <div class="bg-slate-900 border border-slate-700/80 rounded-3xl w-full max-w-3xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh] animate-in fade-in zoom-in-95 duration-200">
    
    <!-- Modal Header -->
    <div class="p-5 border-b border-slate-800 bg-slate-950/70 flex items-start justify-between gap-4">
      <div class="space-y-1">
        <div class="flex items-center gap-2">
          <span class="inline-flex items-center justify-center w-7 h-7 rounded-xl bg-[#ff3b30]/20 text-[#ff3b30] text-sm">
            <i class="fas fa-robot"></i>
          </span>
          <h3 id="chatModalTitle" class="text-base font-bold text-white">Client AI Chat Transcript</h3>
          <span id="chatModalLeadId" class="text-xs font-mono text-slate-500"></span>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400 pt-1">
          <div class="flex items-center gap-1.5 font-semibold text-slate-200">
            <span id="chatModalFlag" class="text-base leading-none"></span>
            <span id="chatModalCountry"></span>
          </div>
          <span class="text-slate-700">•</span>
          <div class="flex items-center gap-1 text-slate-400">
            <i class="fas fa-network-wired text-[10px] text-slate-500"></i>
            <span id="chatModalIp" class="font-mono text-[11px]"></span>
          </div>
          <span class="text-slate-700">•</span>
          <div class="flex items-center gap-1 text-slate-400">
            <i class="far fa-clock text-[10px] text-slate-500"></i>
            <span id="chatModalDate"></span>
          </div>
        </div>
      </div>

      <button type="button"
              onclick="closeChatModal()"
              class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-slate-800 transition-colors">
        <i class="fas fa-times text-sm"></i>
      </button>
    </div>

    <!-- Contact & Meta Bar -->
    <div class="bg-slate-950 px-5 py-3 border-b border-slate-800 flex flex-wrap items-center justify-between gap-3 text-xs">
      <div class="flex flex-wrap items-center gap-4">
        <div>
          <span class="text-slate-500 block text-[10px]">Client Name</span>
          <strong id="chatModalName" class="text-white text-xs"></strong>
        </div>
        <div>
          <span class="text-slate-500 block text-[10px]">Email Address</span>
          <a id="chatModalEmailLink" href="#" class="text-[#ff3b30] hover:underline font-mono text-xs"></a>
        </div>
        <div id="chatModalPhoneWrap">
          <span class="text-slate-500 block text-[10px]">Phone Number</span>
          <span id="chatModalPhone" class="text-slate-300 font-mono text-xs"></span>
        </div>
        <div>
          <span class="text-slate-500 block text-[10px]">Service Interest</span>
          <span id="chatModalInterest" class="text-slate-300 font-medium text-xs"></span>
        </div>
      </div>

      <div class="flex items-center gap-2">
        <a id="chatModalWhatsappBtn" href="#" target="_blank" class="hidden items-center gap-1.5 px-3 py-1.5 bg-emerald-600/20 hover:bg-emerald-600 text-emerald-300 hover:text-white rounded-xl text-xs font-bold transition-all border border-emerald-500/30">
          <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
        <a id="chatModalMailBtn" href="#" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-semibold transition-all">
          <i class="fas fa-envelope"></i> Reply via Email
        </a>
      </div>
    </div>

    <!-- Chat Dialogue Scroll Container -->
    <div id="chatModalMessages" class="p-6 overflow-y-auto space-y-4 flex-1 bg-slate-950/40">
      <!-- Dynamic Chat Message Bubbles -->
    </div>

    <!-- Modal Footer -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/90 flex items-center justify-between text-xs text-slate-500">
      <div class="flex items-center gap-2">
        <i class="fas fa-shield-alt text-emerald-400"></i>
        <span>SOC2 Compliant AI Session Logging</span>
      </div>
      <div>
        Session Hash: <span id="chatModalSessionId" class="font-mono text-slate-400"></span>
      </div>
    </div>
  </div>
</div>

<script>
  let currentActiveLeadId = null;

  function formatChatText(text) {
    if (!text) return '';
    return text
      .replace(/\*\*(.*?)\*\*/g, '<strong class="font-semibold text-white">$1</strong>')
      .replace(/\*(.*?)\*/g, '<em class="text-slate-300">$1</em>')
      .replace(/•\s*(.*)/g, '<li class="ml-4 list-disc text-slate-300">$1</li>')
      .replace(/\n/g, '<br/>');
  }

  // AI Lead Insight Modal Handler (Feature 3)
  function openAiInsightModal(inquiryId) {
    currentActiveLeadId = inquiryId;
    const modal = document.getElementById('aiInsightModal');
    const loading = document.getElementById('aiInsightLoading');
    const content = document.getElementById('aiInsightContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    loading.classList.remove('hidden');
    content.classList.add('hidden');

    fetch(`/admin/inquiries/${inquiryId}/ai-insight`, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(res => res.json())
    .then(data => {
      loading.classList.add('hidden');
      content.classList.remove('hidden');

      if (!data.success) {
        alert(data.message || 'Failed to fetch AI insights.');
        return;
      }

      const lead = data.lead;
      document.getElementById('aiInsightLeadId').textContent = `#${lead.id}`;
      document.getElementById('aiInsightClientDetails').textContent = `${lead.name} (${lead.email}) • ${lead.service || 'Web Development'}`;

      const scoreBadge = document.getElementById('aiInsightScoreBadge');
      scoreBadge.textContent = `${lead.score}/100`;
      scoreBadge.className = `px-3 py-1 rounded-xl text-sm font-black border ${lead.badge_class}`;

      document.getElementById('aiInsightIntentLabel').textContent = lead.intent_label;
      document.getElementById('aiInsightSummary').textContent = lead.summary || 'Commercial scope analyzed by WebRanker AI.';
      document.getElementById('aiInsightDraftReply').value = lead.suggested_reply || '';

      // Email button
      const mailBtn = document.getElementById('aiInsightEmailBtn');
      mailBtn.href = lead.mail_url || '#';

      // WhatsApp button
      const waBtn = document.getElementById('aiInsightWhatsappBtn');
      if (lead.wa_url) {
        waBtn.href = lead.wa_url;
        waBtn.classList.remove('hidden');
      } else {
        waBtn.classList.add('hidden');
      }
    })
    .catch(err => {
      console.error(err);
      loading.innerHTML = `<p class="text-xs text-red-400">Failed to analyze lead. Please try again.</p>`;
    });
  }

  function closeAiInsightModal() {
    const modal = document.getElementById('aiInsightModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
  }

  function copyAiDraftReply() {
    const replyText = document.getElementById('aiInsightDraftReply').value;
    navigator.clipboard.writeText(replyText).then(() => {
      const btn = document.getElementById('copyDraftBtn');
      const originalHtml = btn.innerHTML;
      btn.innerHTML = `<i class="fas fa-check text-xs"></i> <span>Copied!</span>`;
      btn.classList.add('bg-emerald-600');
      setTimeout(() => {
        btn.innerHTML = originalHtml;
        btn.classList.remove('bg-emerald-600');
      }, 2500);
    });
  }

  function triggerReanalyzeCurrentLead() {
    if (!currentActiveLeadId) return;
    const reBtn = document.getElementById('reanalyzeBtn');
    reBtn.innerHTML = `<i class="fas fa-spinner fa-spin text-xs"></i> <span>Analyzing...</span>`;
    reBtn.disabled = true;

    fetch(`/admin/inquiries/${currentActiveLeadId}/reanalyze`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
    .then(res => res.json())
    .then(data => {
      reBtn.innerHTML = `<i class="fas fa-rotate text-[11px]"></i> <span>Re-score with AI</span>`;
      reBtn.disabled = false;
      // Re-populate modal with fresh analysis
      openAiInsightModal(currentActiveLeadId);
    })
    .catch(() => {
      reBtn.innerHTML = `<i class="fas fa-rotate text-[11px]"></i> <span>Re-score with AI</span>`;
      reBtn.disabled = false;
    });
  }

  // Chat Modal Handlers
  function openChatModal(inquiryId) {
    const modal = document.getElementById('chatHistoryModal');
    const msgContainer = document.getElementById('chatModalMessages');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    msgContainer.innerHTML = `
      <div class="py-16 text-center text-slate-400 space-y-3">
        <i class="fas fa-circle-notch fa-spin text-2xl text-[#ff3b30]"></i>
        <p class="text-xs">Loading complete conversation transcript...</p>
      </div>
    `;

    fetch(`/admin/inquiries/${inquiryId}/chat`, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (!data.success && (!data.messages || data.messages.length === 0)) {
        msgContainer.innerHTML = `
          <div class="py-16 text-center text-slate-500 space-y-2">
            <i class="fas fa-comment-slash text-3xl text-slate-700 block"></i>
            <p class="text-sm font-semibold text-slate-300">No AI Chat messages recorded for this inquiry.</p>
            <p class="text-xs text-slate-500">This lead was submitted directly via the website contact form.</p>
          </div>
        `;
        return;
      }

      const lead = data.lead || {};
      document.getElementById('chatModalLeadId').textContent = `#${lead.id || inquiryId}`;
      document.getElementById('chatModalName').textContent = lead.name || 'Direct Prospect';
      
      const emailLink = document.getElementById('chatModalEmailLink');
      emailLink.textContent = lead.email || '—';
      emailLink.href = lead.email ? `mailto:${lead.email}` : '#';
      document.getElementById('chatModalMailBtn').href = lead.email ? `mailto:${lead.email}?subject=WebRanker%20Proposal%20Discussion` : '#';

      if (lead.phone && lead.phone !== '—') {
        document.getElementById('chatModalPhoneWrap').classList.remove('hidden');
        document.getElementById('chatModalPhone').textContent = lead.phone;
        
        const cleanPhone = lead.phone.replace(/[^0-9]/g, '');
        if (cleanPhone.length >= 10) {
          const waBtn = document.getElementById('chatModalWhatsappBtn');
          waBtn.classList.remove('hidden');
          waBtn.classList.add('inline-flex');
          waBtn.href = `https://wa.me/${cleanPhone}?text=Hi%20${encodeURIComponent(lead.name || '')}%2C%20following%20up%20on%20your%20WebRanker%20inquiry.`;
        }
      } else {
        document.getElementById('chatModalPhoneWrap').classList.add('hidden');
        document.getElementById('chatModalWhatsappBtn').classList.add('hidden');
      }

      document.getElementById('chatModalCountry').textContent = lead.country || 'India';
      document.getElementById('chatModalFlag').textContent = lead.country_flag || '🇮🇳';
      document.getElementById('chatModalIp').textContent = lead.ip_address || '127.0.0.1';
      document.getElementById('chatModalDate').textContent = lead.created_at || 'Just now';
      document.getElementById('chatModalInterest').textContent = lead.service_interest || 'General Growth';
      document.getElementById('chatModalSessionId').textContent = lead.session_id || 'Direct Inquiry';

      let html = '';
      data.messages.forEach(msg => {
        const isUser = msg.role === 'user';
        if (isUser) {
          html += `
            <div class="flex items-start justify-end gap-3">
              <div class="bg-gradient-to-r from-red-950/60 to-slate-800 border border-red-500/30 rounded-2xl rounded-tr-none p-3.5 max-w-lg text-slate-100 text-xs shadow-md">
                <div class="flex items-center justify-between gap-4 mb-1 text-[10px] text-red-300 font-bold">
                  <span>${lead.name || 'Client'}</span>
                  <span class="text-slate-400 font-mono">${msg.time || ''}</span>
                </div>
                <div class="whitespace-pre-wrap leading-relaxed">${msg.content}</div>
              </div>
              <div class="w-8 h-8 rounded-xl bg-red-600/20 border border-red-500/40 text-red-300 flex items-center justify-center font-bold text-xs shrink-0">
                <i class="fas fa-user"></i>
              </div>
            </div>
          `;
        } else {
          html += `
            <div class="flex items-start justify-start gap-3">
              <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#ff3b30] to-red-700 text-white flex items-center justify-center font-bold text-xs shadow-md shrink-0">
                <i class="fas fa-robot"></i>
              </div>
              <div class="bg-slate-900 border border-slate-800 rounded-2xl rounded-tl-none p-3.5 max-w-lg text-slate-200 text-xs shadow-md">
                <div class="flex items-center justify-between gap-4 mb-1 text-[10px] text-[#ff3b30] font-bold">
                  <span>WebRanker AI Assistant</span>
                  <span class="text-slate-500 font-mono">${msg.time || ''}</span>
                </div>
                <div class="leading-relaxed">${formatChatText(msg.content)}</div>
              </div>
            </div>
          `;
        }
      });

      msgContainer.innerHTML = html;
      msgContainer.scrollTop = msgContainer.scrollHeight;
    })
    .catch(err => {
      console.error('Failed to load chat history:', err);
      msgContainer.innerHTML = `
        <div class="py-12 text-center text-red-400 space-y-2 text-xs">
          <i class="fas fa-exclamation-triangle text-xl"></i>
          <p>Failed to load chat conversation. Please try again.</p>
        </div>
      `;
    });
  }

  function closeChatModal() {
    const modal = document.getElementById('chatHistoryModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeChatModal();
      closeAiInsightModal();
    }
  });

  document.getElementById('chatHistoryModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeChatModal();
  });

  document.getElementById('aiInsightModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAiInsightModal();
  });
</script>

@endsection
