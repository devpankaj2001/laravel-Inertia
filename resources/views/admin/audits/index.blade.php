@extends('admin.layouts.admin')

@section('title', 'AI SEO & Speed Audits Intelligence')
@section('page_title', 'AI SEO & Website Performance Audits')

@section('admin_content')

<div class="space-y-6">

  <!-- Overview Stats Ribbon -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stat 1: Total Audits -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Audits Run</p>
        <h4 class="text-2xl font-black text-white mt-1">{{ number_format($stats['total'] ?? 0) }}</h4>
        <span class="text-[11px] text-emerald-400 font-semibold flex items-center gap-1 mt-1">
          <i class="fas fa-bolt text-[10px]"></i> Live visitor scans
        </span>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-[#ff3b30]/15 text-[#ff3b30] flex items-center justify-center text-xl border border-[#ff3b30]/25">
        <i class="fas fa-gauge-high"></i>
      </div>
    </div>

    <!-- Stat 2: Avg Speed Score -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Avg Speed Score</p>
        <h4 class="text-2xl font-black text-white mt-1">{{ $stats['avg_speed'] ?? 0 }}<span class="text-xs text-slate-500 font-normal"> / 100</span></h4>
        <span class="text-[11px] {{ ($stats['avg_speed'] ?? 0) >= 70 ? 'text-emerald-400' : 'text-amber-400' }} font-semibold flex items-center gap-1 mt-1">
          <i class="fas fa-chart-line text-[10px]"></i> {{ ($stats['avg_speed'] ?? 0) >= 70 ? 'Optimal Benchmark' : 'Needs Optimization' }}
        </span>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-amber-500/15 text-amber-400 flex items-center justify-center text-xl border border-amber-500/25">
        <i class="fas fa-tachometer-alt"></i>
      </div>
    </div>

    <!-- Stat 3: Avg SEO Score -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Avg Technical SEO</p>
        <h4 class="text-2xl font-black text-white mt-1">{{ $stats['avg_seo'] ?? 0 }}<span class="text-xs text-slate-500 font-normal"> / 100</span></h4>
        <span class="text-[11px] text-emerald-400 font-semibold flex items-center gap-1 mt-1">
          <i class="fas fa-search text-[10px]"></i> Architecture Health
        </span>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center text-xl border border-emerald-500/25">
        <i class="fas fa-shield-halved"></i>
      </div>
    </div>

    <!-- Stat 4: Phone Leads -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">WhatsApp &amp; Phone Leads</p>
        <h4 class="text-2xl font-black text-white mt-1">{{ number_format($stats['with_phone'] ?? 0) }}</h4>
        <span class="text-[11px] text-indigo-400 font-semibold flex items-center gap-1 mt-1">
          <i class="fab fa-whatsapp text-[10px]"></i> 1-Click Outreach Ready
        </span>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-indigo-500/15 text-indigo-400 flex items-center justify-center text-xl border border-indigo-500/25">
        <i class="fas fa-phone-volume"></i>
      </div>
    </div>
  </div>

  <!-- Header Filter Bar -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
    <div>
      <h3 class="text-base font-extrabold text-white flex items-center gap-2">
        <i class="fas fa-gauge-high text-[#ff3b30]"></i>
        <span>Instant Performance &amp; SEO Diagnostic Leads</span>
      </h3>
      <p class="text-xs text-slate-400 mt-1">Inspect Core Web Vitals, 48-Hour AI Roadmaps, and initiate 1-click WhatsApp/Email client pitches.</p>
    </div>

    <!-- Search input -->
    <form method="GET" action="{{ route('admin.audits.index') }}" class="flex items-center gap-2">
      <div class="relative w-full sm:w-72">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-500 text-xs">
          <i class="fas fa-search"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search domain, email, country..."
               class="w-full pl-9 pr-4 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:border-[#ff3b30] focus:outline-none">
      </div>
      <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition-colors">
        Filter
      </button>
    </form>
  </div>

  <!-- Flash Messages -->
  @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center gap-2">
      <i class="fas fa-check-circle"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="p-4 rounded-2xl bg-red-500/15 border border-red-500/30 text-red-300 text-xs font-semibold flex items-center gap-2">
      <i class="fas fa-exclamation-triangle"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  <!-- Audits Table -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 space-y-4">
    @if($audits->isEmpty())
      <div class="py-12 text-center text-slate-500 text-sm space-y-2">
        <i class="fas fa-gauge-high text-3xl text-slate-700 block"></i>
        <p>No audits recorded yet. Free audits initiated by website visitors will appear here instantly.</p>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wider font-semibold">
              <th class="py-3 px-4">Audit ID &amp; Target Domain</th>
              <th class="py-3 px-4">Performance &amp; SEO</th>
              <th class="py-3 px-4">Core Web Vitals</th>
              <th class="py-3 px-4">Lead Contact</th>
              <th class="py-3 px-4">Location</th>
              <th class="py-3 px-4">Timestamp</th>
              <th class="py-3 px-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300 text-xs">
            @foreach($audits as $audit)
              @php
                $perf = $audit->speed_score ?? 0;
                $seo = $audit->seo_score ?? 0;
                $cwv = $audit->performance_metrics ?? [];
                $bp = $cwv['best_practices_score'] ?? 90;
                $roadmap = $audit->ai_roadmap ?? [];
                $cleanDomain = parse_url($audit->domain_url, PHP_URL_HOST) ?: $audit->domain_url;
                $phoneClean = preg_replace('/[^0-9]/', '', $audit->phone ?? '');
                $lcpVal = $cwv['lcp'] ?? 'N/A';
                
                // WhatsApp personalized outreach template
                $waText = "Hi! We analyzed {$cleanDomain} with our AI Performance & SEO Engine. Your Speed Score is {$perf}/100 and SEO is {$seo}/100. We identified specific fixes for LCP ({$lcpVal}) and schema markup that can improve your organic Google rankings within 48 hours. Would you like us to implement these?";
                $waLink = $phoneClean ? "https://wa.me/{$phoneClean}?text=" . urlencode($waText) : null;
                $mailSubject = "Website Performance & SEO Diagnostic for {$cleanDomain}";
                $mailBody = "Hi,\n\nWe conducted a real-time Core Web Vitals & SEO audit for {$cleanDomain}.\n\nScorecard:\n• Performance Score: {$perf}/100\n• Technical SEO Score: {$seo}/100\n• Largest Contentful Paint (LCP): " . ($cwv['lcp'] ?? 'N/A') . "\n• Server TTFB: " . ($cwv['ttfb'] ?? 'N/A') . "\n\nWe have prepared a complete 48-Hour Implementation Plan to optimize your website. Let us know if you'd like us to proceed!\n\nBest regards,\nRankexa Team";
                $mailLink = "mailto:{$audit->email}?subject=" . urlencode($mailSubject) . "&body=" . urlencode($mailBody);
              @endphp
              <tr class="hover:bg-slate-800/40 transition-colors">
                <!-- Domain -->
                <td class="py-3.5 px-4 font-mono">
                  <div class="flex items-center gap-2">
                    <span class="text-slate-500 font-bold">#{{ $audit->id }}</span>
                    <a href="{{ $audit->domain_url }}" target="_blank" rel="noreferrer" class="text-white font-bold hover:text-[#ff3b30] flex items-center gap-1.5" title="Open website in new tab">
                      <span class="truncate max-w-[160px]">{{ $cleanDomain }}</span>
                      <i class="fas fa-external-link-alt text-[10px] opacity-60"></i>
                    </a>
                  </div>
                </td>

                <!-- Scores -->
                <td class="py-3.5 px-4">
                  <div class="flex flex-wrap items-center gap-1.5">
                    <span class="px-2 py-0.5 rounded-lg font-bold text-xs {{ $perf >= 85 ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($perf >= 50 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30') }}">
                      Speed: {{ $perf }}
                    </span>
                    <span class="px-2 py-0.5 rounded-lg font-bold text-xs {{ $seo >= 85 ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($seo >= 50 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30') }}">
                      SEO: {{ $seo }}
                    </span>
                    @if(isset($cwv['best_practices_score']))
                      <span class="px-2 py-0.5 rounded-lg font-bold text-[11px] bg-slate-800 text-slate-300 border border-slate-700 hidden sm:inline-block">
                        BP: {{ $cwv['best_practices_score'] }}
                      </span>
                    @endif
                  </div>
                </td>

                <!-- CWV -->
                <td class="py-3.5 px-4 font-mono text-[11px] text-slate-400">
                  <div class="space-y-0.5">
                    <div>FCP: <span class="text-slate-200 font-semibold">{{ $cwv['fcp'] ?? 'N/A' }}</span></div>
                    <div>LCP: <span class="text-slate-200 font-semibold">{{ $cwv['lcp'] ?? 'N/A' }}</span></div>
                    <div>CLS: <span class="text-slate-200 font-semibold">{{ $cwv['cls'] ?? 'N/A' }}</span></div>
                  </div>
                </td>

                <!-- Lead -->
                <td class="py-3.5 px-4">
                  <div class="font-semibold text-white truncate max-w-[160px]">{{ $audit->email }}</div>
                  @if($audit->phone)
                    <div class="text-slate-400 text-[11px] flex items-center gap-1.5 mt-0.5">
                      <span>{{ $audit->phone }}</span>
                      @if($waLink)
                        <a href="{{ $waLink }}" target="_blank" rel="noreferrer" class="text-emerald-400 hover:text-emerald-300" title="Send WhatsApp Message">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                      @endif
                    </div>
                  @endif
                </td>

                <!-- Location -->
                <td class="py-3.5 px-4">
                  <span class="px-2 py-0.5 rounded-full text-[11px] bg-slate-800 text-slate-300 border border-slate-700">
                    {{ $audit->country ?: 'Global' }}
                  </span>
                </td>

                <!-- Date -->
                <td class="py-3.5 px-4 text-slate-400 whitespace-nowrap">
                  {{ $audit->created_at->format('M d, Y') }}
                  <div class="text-[10px] text-slate-500">{{ $audit->created_at->format('h:i A') }}</div>
                </td>

                <!-- Actions -->
                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                  <div class="flex items-center justify-end gap-1.5">
                    <!-- Inspect Drawer Button -->
                    <button type="button"
                            onclick='openRoadmapModal(@json($audit))'
                            class="px-2.5 py-1.5 rounded-xl bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-300 font-bold border border-indigo-500/30 transition-colors flex items-center gap-1.5"
                            title="Inspect Complete Audit & AI Roadmap">
                      <i class="fas fa-microscope text-[11px]"></i>
                      <span class="hidden md:inline">Inspect</span>
                    </button>

                    <!-- WhatsApp Client Quick Button -->
                    @if($waLink)
                      <a href="{{ $waLink }}"
                         target="_blank"
                         rel="noreferrer"
                         class="p-2 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 border border-emerald-500/30 transition-colors"
                         title="Pitch Client on WhatsApp">
                        <i class="fab fa-whatsapp text-xs"></i>
                      </a>
                    @endif

                    <!-- Email Client Quick Button -->
                    <a href="{{ $mailLink }}"
                       class="p-2 rounded-xl bg-sky-500/20 hover:bg-sky-500/30 text-sky-400 border border-sky-500/30 transition-colors"
                       title="Email Diagnostic Report to Client">
                      <i class="fas fa-envelope text-xs"></i>
                    </a>

                    <!-- Re-scan Button -->
                    <form method="POST" action="{{ route('admin.audits.rescan', $audit->id) }}" onsubmit="return confirm('Re-run live audit for {{ $cleanDomain }}?');" class="inline">
                      @csrf
                      <button type="submit" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 transition-colors" title="Re-scan domain now">
                        <i class="fas fa-rotate text-xs"></i>
                      </button>
                    </form>

                    <!-- Delete Button -->
                    <form method="POST" action="{{ route('admin.audits.destroy', $audit->id) }}" onsubmit="return confirm('Delete this audit log?');" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-2 rounded-xl hover:bg-red-500/20 text-slate-500 hover:text-red-400 transition-colors" title="Delete Audit">
                        <i class="fas fa-trash-alt text-xs"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="pt-4 border-t border-slate-800 flex justify-between items-center text-xs text-slate-400">
        <div>Showing {{ $audits->firstItem() ?? 0 }} to {{ $audits->lastItem() ?? 0 }} of {{ $audits->total() }} audits</div>
        <div>{{ $audits->links() }}</div>
      </div>
    @endif
  </div>

</div>

<!-- Comprehensive Audit Inspection Modal -->
<div id="roadmapModalBackdrop" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden items-center justify-center p-3 sm:p-5">
  <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-3xl w-full p-6 sm:p-8 max-h-[90vh] overflow-y-auto space-y-6 text-white shadow-2xl relative">
    
    <!-- Close Button -->
    <button type="button" onclick="closeRoadmapModal()" class="absolute top-5 right-5 text-slate-400 hover:text-white text-lg w-8 h-8 rounded-full flex items-center justify-center hover:bg-white/10 transition-colors">
      <i class="fas fa-times"></i>
    </button>

    <!-- Modal Header -->
    <div class="border-b border-slate-800 pb-4">
      <div class="flex items-center gap-2">
        <span class="px-2.5 py-0.5 rounded-full bg-[#ff3b30]/15 text-[#ff3b30] text-[10px] font-extrabold uppercase tracking-wider border border-[#ff3b30]/30">
          AI Diagnostic Intelligence
        </span>
        <span id="modalTimestamp" class="text-xs text-slate-400"></span>
      </div>
      <h3 id="modalDomain" class="text-xl sm:text-2xl font-black text-white font-mono mt-1.5 flex items-center gap-2"></h3>
      <div id="modalLeadInfo" class="text-xs text-slate-400 mt-1 flex flex-wrap items-center gap-3"></div>
    </div>

    <!-- 4 Score Cards (Speed, SEO, Best Practices, Accessibility) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
      <div class="p-3.5 rounded-2xl bg-slate-950 border border-slate-800 text-center">
        <div class="text-[10px] font-bold text-slate-400 uppercase">Performance</div>
        <div id="modalScoreSpeed" class="text-2xl font-black mt-0.5"></div>
      </div>
      <div class="p-3.5 rounded-2xl bg-slate-950 border border-slate-800 text-center">
        <div class="text-[10px] font-bold text-slate-400 uppercase">Technical SEO</div>
        <div id="modalScoreSeo" class="text-2xl font-black mt-0.5"></div>
      </div>
      <div class="p-3.5 rounded-2xl bg-slate-950 border border-slate-800 text-center">
        <div class="text-[10px] font-bold text-slate-400 uppercase">Best Practices</div>
        <div id="modalScoreBp" class="text-2xl font-black mt-0.5"></div>
      </div>
      <div class="p-3.5 rounded-2xl bg-slate-950 border border-slate-800 text-center">
        <div class="text-[10px] font-bold text-slate-400 uppercase">Accessibility</div>
        <div id="modalScoreA11y" class="text-2xl font-black mt-0.5"></div>
      </div>
    </div>

    <!-- Core Web Vitals Key Metrics Grid -->
    <div>
      <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Core Web Vitals Telemetry</h4>
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5" id="modalCwvGrid"></div>
    </div>

    <!-- Tab Selection Inside Modal -->
    <div>
      <div class="flex items-center gap-1.5 p-1 rounded-2xl bg-slate-950 border border-slate-800 mb-4">
        <button type="button" onclick="setAdminTab('roadmap')" id="adminTabBtnRoadmap" class="flex-1 py-2 px-3 rounded-xl text-xs font-bold bg-[#ff3b30] text-white transition-all flex items-center justify-center gap-1.5">
          <i class="fas fa-robot text-[11px]"></i>
          <span>48-Hr AI Roadmap</span>
        </button>
        <button type="button" onclick="setAdminTab('checklist')" id="adminTabBtnChecklist" class="flex-1 py-2 px-3 rounded-xl text-xs font-bold text-slate-400 hover:text-white transition-all flex items-center justify-center gap-1.5">
          <i class="fas fa-clipboard-check text-[11px]"></i>
          <span>10-Point Checklist</span>
        </button>
      </div>

      <!-- Tab 1: AI Roadmap -->
      <div id="adminTabRoadmap" class="space-y-4">
        <div>
          <h4 class="text-xs uppercase font-bold text-slate-400 tracking-wider mb-1">Executive Technical Assessment</h4>
          <p id="modalSummary" class="text-xs sm:text-sm text-slate-200 leading-relaxed bg-slate-950 p-4 rounded-2xl border border-slate-800/80"></p>
        </div>

        <div>
          <h4 class="text-xs uppercase font-bold text-emerald-400 tracking-wider mb-2 flex items-center gap-1.5">
            <i class="fas fa-bolt"></i>
            <span>Top 3 Speed &amp; Architecture Fixes</span>
          </h4>
          <ul id="modalSpeedFixes" class="space-y-1.5 text-xs text-slate-300 list-disc list-inside bg-slate-950 p-4 rounded-2xl border border-slate-800/80"></ul>
        </div>

        <div>
          <h4 class="text-xs uppercase font-bold text-amber-400 tracking-wider mb-2 flex items-center gap-1.5">
            <i class="fas fa-bullseye"></i>
            <span>Top 3 Organic Keyword Opportunities</span>
          </h4>
          <ul id="modalKeywordOpp" class="space-y-1.5 text-xs text-slate-300 list-disc list-inside bg-slate-950 p-4 rounded-2xl border border-slate-800/80"></ul>
        </div>

        <div>
          <h4 class="text-xs uppercase font-bold text-indigo-400 tracking-wider mb-2 flex items-center gap-1.5">
            <i class="fas fa-shield-alt"></i>
            <span>Schema &amp; SEO Architecture Fixes</span>
          </h4>
          <ul id="modalSchemaFixes" class="space-y-1.5 text-xs text-slate-300 list-disc list-inside bg-slate-950 p-4 rounded-2xl border border-slate-800/80"></ul>
        </div>
      </div>

      <!-- Tab 2: 10-Point Checklist -->
      <div id="adminTabChecklist" class="hidden space-y-2.5" id="modalChecklistContainer">
        <!-- Injected via JavaScript -->
      </div>
    </div>

    <!-- Modal Footer Actions -->
    <div class="pt-4 border-t border-slate-800 flex flex-wrap items-center justify-between gap-3">
      <button type="button" id="modalCopyProposalBtn" onclick="copyClientProposal()" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs flex items-center gap-2 transition-colors cursor-pointer">
        <i class="fas fa-copy"></i>
        <span>Copy Client Proposal Pitch</span>
      </button>

      <div class="flex items-center gap-2">
        <a id="modalWaBtn" href="#" target="_blank" rel="noreferrer" class="py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-2 transition-colors">
          <i class="fab fa-whatsapp"></i>
          <span>WhatsApp Client</span>
        </a>
        <a id="modalMailBtn" href="#" class="py-2.5 px-4 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs flex items-center gap-2 transition-colors">
          <i class="fas fa-envelope"></i>
          <span>Email Report</span>
        </a>
      </div>
    </div>

  </div>
</div>

<script>
let currentAudit = null;

function setAdminTab(tab) {
  const roadmapTab = document.getElementById('adminTabRoadmap');
  const checklistTab = document.getElementById('adminTabChecklist');
  const btnRoadmap = document.getElementById('adminTabBtnRoadmap');
  const btnChecklist = document.getElementById('adminTabBtnChecklist');

  if (tab === 'roadmap') {
    roadmapTab.classList.remove('hidden');
    checklistTab.classList.add('hidden');
    btnRoadmap.className = 'flex-1 py-2 px-3 rounded-xl text-xs font-bold bg-[#ff3b30] text-white transition-all flex items-center justify-center gap-1.5';
    btnChecklist.className = 'flex-1 py-2 px-3 rounded-xl text-xs font-bold text-slate-400 hover:text-white transition-all flex items-center justify-center gap-1.5';
  } else {
    roadmapTab.classList.add('hidden');
    checklistTab.classList.remove('hidden');
    btnChecklist.className = 'flex-1 py-2 px-3 rounded-xl text-xs font-bold bg-[#ff3b30] text-white transition-all flex items-center justify-center gap-1.5';
    btnRoadmap.className = 'flex-1 py-2 px-3 rounded-xl text-xs font-bold text-slate-400 hover:text-white transition-all flex items-center justify-center gap-1.5';
  }
}

function openRoadmapModal(audit) {
  currentAudit = audit;
  const metrics = audit.performance_metrics || {};
  const rm = audit.ai_roadmap || {};
  const perf = audit.speed_score || 0;
  const seo = audit.seo_score || 0;
  const bp = metrics.best_practices_score || 88;
  const a11y = metrics.accessibility_score || 86;

  document.getElementById('modalDomain').innerHTML = `
    <span>${audit.domain_url}</span>
    <a href="${audit.domain_url}" target="_blank" rel="noreferrer" class="text-slate-400 hover:text-[#ff3b30] text-xs">
      <i class="fas fa-external-link-alt"></i>
    </a>
  `;
  document.getElementById('modalTimestamp').textContent = '• ' + (new Date(audit.created_at).toLocaleString());

  document.getElementById('modalLeadInfo').innerHTML = `
    <span><i class="fas fa-envelope text-slate-500 mr-1"></i> ${audit.email}</span>
    ${audit.phone ? `<span><i class="fas fa-phone text-slate-500 mr-1"></i> ${audit.phone}</span>` : ''}
    <span><i class="fas fa-globe text-slate-500 mr-1"></i> ${audit.country || 'Global'} (${audit.ip_address || 'N/A'})</span>
  `;

  // Score Dials
  const formatScore = (score) => {
    const col = score >= 85 ? 'text-emerald-400' : (score >= 50 ? 'text-amber-400' : 'text-[#ff3b30]');
    return `<span class="${col}">${score}</span><span class="text-xs text-slate-500 font-normal"> / 100</span>`;
  };

  document.getElementById('modalScoreSpeed').innerHTML = formatScore(perf);
  document.getElementById('modalScoreSeo').innerHTML = formatScore(seo);
  document.getElementById('modalScoreBp').innerHTML = formatScore(bp);
  document.getElementById('modalScoreA11y').innerHTML = formatScore(a11y);

  // Core Web Vitals Grid
  const cwvGrid = document.getElementById('modalCwvGrid');
  cwvGrid.innerHTML = `
    <div class="p-3 rounded-2xl bg-slate-950 border border-slate-800 text-center">
      <div class="text-[10px] font-bold text-slate-400 uppercase">FCP (Paint)</div>
      <div class="text-sm font-black text-white font-mono mt-0.5">${metrics.fcp || 'N/A'}</div>
      <div class="text-[9px] text-slate-500 mt-0.5">Target: ≤ 1.8s</div>
    </div>
    <div class="p-3 rounded-2xl bg-slate-950 border border-slate-800 text-center">
      <div class="text-[10px] font-bold text-slate-400 uppercase">LCP (Hero)</div>
      <div class="text-sm font-black text-white font-mono mt-0.5">${metrics.lcp || 'N/A'}</div>
      <div class="text-[9px] text-slate-500 mt-0.5">Target: ≤ 2.5s</div>
    </div>
    <div class="p-3 rounded-2xl bg-slate-950 border border-slate-800 text-center">
      <div class="text-[10px] font-bold text-slate-400 uppercase">CLS (Shift)</div>
      <div class="text-sm font-black text-white font-mono mt-0.5">${metrics.cls || 'N/A'}</div>
      <div class="text-[9px] text-slate-500 mt-0.5">Target: ≤ 0.10</div>
    </div>
    <div class="p-3 rounded-2xl bg-slate-950 border border-slate-800 text-center">
      <div class="text-[10px] font-bold text-slate-400 uppercase">Server TTFB</div>
      <div class="text-sm font-black text-white font-mono mt-0.5">${metrics.ttfb || 'N/A'}</div>
      <div class="text-[9px] text-slate-500 mt-0.5">Target: ≤ 200ms</div>
    </div>
  `;

  // AI Roadmap content
  document.getElementById('modalSummary').textContent = rm.executive_summary || 'No summary generated.';

  const fillList = (elId, items) => {
    const el = document.getElementById(elId);
    el.innerHTML = '';
    (items || []).forEach(item => {
      const li = document.createElement('li');
      li.textContent = item;
      el.appendChild(li);
    });
  };

  fillList('modalSpeedFixes', rm.speed_fixes);
  fillList('modalKeywordOpp', rm.keyword_opportunities);
  fillList('modalSchemaFixes', rm.schema_fixes);

  // Technical Checklist content
  const checklistContainer = document.getElementById('adminTabChecklist');
  checklistContainer.innerHTML = '';
  const checklistItems = metrics.checklist || [];
  if (checklistItems.length === 0) {
    checklistContainer.innerHTML = '<p class="text-xs text-slate-400 p-4">Standard diagnostic checklist executed cleanly.</p>';
  } else {
    checklistItems.forEach(item => {
      const div = document.createElement('div');
      div.className = `p-3 rounded-2xl border text-xs flex items-start gap-3 ${
        item.passed
          ? 'bg-emerald-500/10 border-emerald-500/25 text-emerald-300'
          : 'bg-red-500/10 border-red-500/25 text-red-300'
      }`;
      div.innerHTML = `
        <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5 ${item.passed ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400'}">
          <i class="fas ${item.passed ? 'fa-check' : 'fa-triangle-exclamation'} text-[10px]"></i>
        </div>
        <div class="flex-1">
          <div class="flex items-center justify-between">
            <span class="font-bold text-white">${item.name}</span>
            <span class="text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider font-extrabold ${item.passed ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400'}">${item.passed ? 'PASSED' : 'ACTION REQUIRED'}</span>
          </div>
          <p class="text-[11px] text-slate-300 mt-0.5 leading-relaxed">${item.description}</p>
        </div>
      `;
      checklistContainer.appendChild(div);
    });
  }

  // Quick Action Buttons
  const cleanPhone = (audit.phone || '').replace(/[^0-9]/g, '');
  const waBtn = document.getElementById('modalWaBtn');
  if (cleanPhone) {
    const waText = `Hi! We audited ${audit.domain_url}. Performance Score is ${perf}/100 and SEO is ${seo}/100. We prepared a 48-Hour Roadmap to solve LCP (${metrics.lcp || 'N/A'}) and schema gaps. Would you like to review?`;
    waBtn.href = `https://wa.me/${cleanPhone}?text=${encodeURIComponent(waText)}`;
    waBtn.classList.remove('hidden');
  } else {
    waBtn.classList.add('hidden');
  }

  const mailSubject = `Website Audit & Performance Optimization for ${audit.domain_url}`;
  const mailBody = `Hi,\n\nHere is your website audit scorecard for ${audit.domain_url}:\n\n• Performance: ${perf}/100\n• SEO Score: ${seo}/100\n• LCP: ${metrics.lcp || 'N/A'}\n• Server TTFB: ${metrics.ttfb || 'N/A'}\n\nOur team can deploy all required fixes within 48 hours. Let us know when you'd like to schedule a call.\n\nBest regards,\nRankexa Team`;
  document.getElementById('modalMailBtn').href = `mailto:${audit.email}?subject=${encodeURIComponent(mailSubject)}&body=${encodeURIComponent(mailBody)}`;

  // Set default tab
  setAdminTab('roadmap');

  const backdrop = document.getElementById('roadmapModalBackdrop');
  backdrop.classList.remove('hidden');
  backdrop.classList.add('flex');
}

function closeRoadmapModal() {
  const backdrop = document.getElementById('roadmapModalBackdrop');
  backdrop.classList.add('hidden');
  backdrop.classList.remove('flex');
}

function copyClientProposal() {
  if (!currentAudit) return;
  const m = currentAudit.performance_metrics || {};
  const rm = currentAudit.ai_roadmap || {};
  const proposalText = `📊 Website Audit & 48-Hour Performance Proposal
Domain: ${currentAudit.domain_url}
Client: ${currentAudit.email}

SCORES:
• Performance: ${currentAudit.speed_score}/100
• Technical SEO: ${currentAudit.seo_score}/100
• Core Web Vitals Status: ${m.cwv_status || 'NEEDS WORK'}
• LCP (Hero Element): ${m.lcp || 'N/A'}
• Server TTFB: ${m.ttfb || 'N/A'}

AI EXECUTIVE SUMMARY:
${rm.executive_summary || 'N/A'}

PROPOSED 48-HOUR SPEED FIXES:
${(rm.speed_fixes || []).map((f, i) => `${i + 1}. ${f}`).join('\n')}

PROPOSED SEO FIXES:
${(rm.schema_fixes || []).map((f, i) => `${i + 1}. ${f}`).join('\n')}`;

  navigator.clipboard.writeText(proposalText).then(() => {
    const btn = document.getElementById('modalCopyProposalBtn');
    const original = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-check text-emerald-400"></i><span>Copied to Clipboard!</span>';
    setTimeout(() => {
      btn.innerHTML = original;
    }, 2500);
  });
}
</script>

@endsection
