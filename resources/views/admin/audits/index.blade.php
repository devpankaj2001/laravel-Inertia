@extends('admin.layouts.admin')

@section('title', 'AI SEO & Speed Audits')
@section('page_title', 'AI SEO & Website Performance Audits')

@section('admin_content')

<div class="space-y-6">

  <!-- Header Filter Bar -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
    <div>
      <h3 class="text-base font-extrabold text-white flex items-center gap-2">
        <i class="fas fa-gauge-high text-[#ff3b30]"></i>
        <span>Instant Performance &amp; SEO Diagnostic Leads</span>
      </h3>
      <p class="text-xs text-slate-400 mt-1">Real-time Google Core Web Vitals diagnostics and AI 48-Hour Roadmaps generated for visitors.</p>
    </div>

    <!-- Search input -->
    <form method="GET" action="{{ route('admin.audits.index') }}" class="flex items-center gap-2">
      <div class="relative w-full sm:w-72">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-500 text-xs">
          <i class="fas fa-search"></i>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by domain, email, country..."
               class="w-full pl-9 pr-4 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:border-[#ff3b30] focus:outline-none">
      </div>
      <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition-colors">
        Filter
      </button>
    </form>
  </div>

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
              <th class="py-3 px-4">Scores</th>
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
                $roadmap = $audit->ai_roadmap ?? [];
              @endphp
              <tr class="hover:bg-slate-800/40 transition-colors">
                <!-- Domain -->
                <td class="py-3.5 px-4 font-mono">
                  <div class="flex items-center gap-2">
                    <span class="text-slate-500 font-bold">#{{ $audit->id }}</span>
                    <a href="{{ $audit->domain_url }}" target="_blank" rel="noreferrer" class="text-white font-bold hover:text-[#ff3b30] flex items-center gap-1">
                      <span>{{ parse_url($audit->domain_url, PHP_URL_HOST) ?: $audit->domain_url }}</span>
                      <i class="fas fa-external-link-alt text-[10px] opacity-60"></i>
                    </a>
                  </div>
                </td>

                <!-- Scores -->
                <td class="py-3.5 px-4">
                  <div class="flex items-center gap-2">
                    <span class="px-2 py-1 rounded-lg font-bold text-xs {{ $perf >= 85 ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($perf >= 50 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30') }}">
                      Speed: {{ $perf }}/100
                    </span>
                    <span class="px-2 py-1 rounded-lg font-bold text-xs {{ $seo >= 85 ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($seo >= 50 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30') }}">
                      SEO: {{ $seo }}/100
                    </span>
                  </div>
                </td>

                <!-- CWV -->
                <td class="py-3.5 px-4 font-mono text-[11px] text-slate-400">
                  <div class="space-y-0.5">
                    <div>FCP: <span class="text-slate-200">{{ $cwv['fcp'] ?? 'N/A' }}</span></div>
                    <div>LCP: <span class="text-slate-200">{{ $cwv['lcp'] ?? 'N/A' }}</span></div>
                    <div>CLS: <span class="text-slate-200">{{ $cwv['cls'] ?? 'N/A' }}</span></div>
                  </div>
                </td>

                <!-- Lead -->
                <td class="py-3.5 px-4">
                  <div class="font-semibold text-white">{{ $audit->email }}</div>
                  @if($audit->phone)
                    <div class="text-slate-400 text-[11px]">{{ $audit->phone }}</div>
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
                  {{ $audit->created_at->format('M d, Y h:i A') }}
                </td>

                <!-- Action -->
                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                  <div class="flex items-center justify-end gap-2">
                    <button type="button"
                            onclick='openRoadmapModal(@json($audit))'
                            class="px-2.5 py-1.5 rounded-lg bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-300 font-bold border border-indigo-500/30 transition-colors flex items-center gap-1">
                      <i class="fas fa-robot text-[11px]"></i>
                      <span>AI Roadmap</span>
                    </button>
                    <form method="POST" action="{{ route('admin.audits.destroy', $audit->id) }}" onsubmit="return confirm('Delete this audit log?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-1.5 rounded-lg hover:bg-red-500/20 text-slate-500 hover:text-red-400 transition-colors" title="Delete Audit">
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

<!-- Roadmap Detail Modal -->
<div id="roadmapModalBackdrop" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden items-center justify-center p-4">
  <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-2xl w-full p-6 sm:p-8 max-h-[85vh] overflow-y-auto space-y-5 text-white shadow-2xl relative">
    <button type="button" onclick="closeRoadmapModal()" class="absolute top-5 right-5 text-slate-400 hover:text-white text-lg">
      <i class="fas fa-times"></i>
    </button>
    <div class="border-b border-slate-800 pb-3">
      <span class="text-xs uppercase font-extrabold tracking-wider text-[#ff3b30]">AI Diagnostic Report</span>
      <h3 id="modalDomain" class="text-xl font-black text-white mt-1">Website Roadmap</h3>
    </div>
    
    <div>
      <h4 class="text-xs uppercase font-bold text-slate-400 tracking-wider mb-1">Executive Assessment</h4>
      <p id="modalSummary" class="text-sm text-slate-300 leading-relaxed bg-slate-950 p-3.5 rounded-xl border border-slate-800/80"></p>
    </div>

    <div>
      <h4 class="text-xs uppercase font-bold text-emerald-400 tracking-wider mb-2 flex items-center gap-1.5">
        <i class="fas fa-bolt"></i>
        <span>Top 3 Technical Speed Fixes</span>
      </h4>
      <ul id="modalSpeedFixes" class="space-y-1.5 text-xs text-slate-300 list-disc list-inside bg-slate-950 p-3.5 rounded-xl border border-slate-800/80"></ul>
    </div>

    <div>
      <h4 class="text-xs uppercase font-bold text-amber-400 tracking-wider mb-2 flex items-center gap-1.5">
        <i class="fas fa-bullseye"></i>
        <span>Top 3 Organic Keyword Opportunities</span>
      </h4>
      <ul id="modalKeywordOpp" class="space-y-1.5 text-xs text-slate-300 list-disc list-inside bg-slate-950 p-3.5 rounded-xl border border-slate-800/80"></ul>
    </div>

    <div>
      <h4 class="text-xs uppercase font-bold text-indigo-400 tracking-wider mb-2 flex items-center gap-1.5">
        <i class="fas fa-shield-alt"></i>
        <span>Schema &amp; Architecture Fixes</span>
      </h4>
      <ul id="modalSchemaFixes" class="space-y-1.5 text-xs text-slate-300 list-disc list-inside bg-slate-950 p-3.5 rounded-xl border border-slate-800/80"></ul>
    </div>
  </div>
</div>

<script>
function openRoadmapModal(audit) {
  document.getElementById('modalDomain').textContent = audit.domain_url + ' (' + audit.email + ')';
  const rm = audit.ai_roadmap || {};
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

  const backdrop = document.getElementById('roadmapModalBackdrop');
  backdrop.classList.remove('hidden');
  backdrop.classList.add('flex');
}

function closeRoadmapModal() {
  const backdrop = document.getElementById('roadmapModalBackdrop');
  backdrop.classList.add('hidden');
  backdrop.classList.remove('flex');
}
</script>

@endsection
