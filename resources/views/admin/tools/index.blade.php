@extends('admin.layouts.admin')

@section('title', 'Free SEO Tools Activity & Leads')
@section('page_title', 'SEO Tools Searches & Diagnostics')

@section('admin_content')

<div class="space-y-6">

  <!-- Overview Stats Ribbon -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Stat 1: Total Keyword Checks -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Keywords Checked</p>
        <h4 class="text-2xl font-black text-white mt-1">{{ \App\Models\SeoKeywordRanking::count() }}</h4>
        <span class="text-[11px] text-emerald-400 font-semibold flex items-center gap-1 mt-1">
          <i class="fas fa-search text-[10px]"></i> Live SERP lookups
        </span>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-[#ff3b30]/15 text-[#ff3b30] flex items-center justify-center text-xl border border-[#ff3b30]/25">
        <i class="fas fa-bullseye"></i>
      </div>
    </div>

    <!-- Stat 2: Page 1 Rankings Found -->
    @php
      $page1Count = \App\Models\SeoKeywordRanking::where('page', 1)->count();
    @endphp
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Page 1 Winners</p>
        <h4 class="text-2xl font-black text-white mt-1">{{ $page1Count }}</h4>
        <span class="text-[11px] text-emerald-400 font-semibold flex items-center gap-1 mt-1">
          <i class="fas fa-trophy text-[10px]"></i> Top 10 Google rank
        </span>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-amber-500/15 text-amber-400 flex items-center justify-center text-xl border border-amber-500/25">
        <i class="fas fa-trophy"></i>
      </div>
    </div>

    <!-- Stat 3: Total Backlink Audits -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Backlink Audits</p>
        <h4 class="text-2xl font-black text-white mt-1">{{ \App\Models\SeoBacklinkAudit::count() }}</h4>
        <span class="text-[11px] text-indigo-400 font-semibold flex items-center gap-1 mt-1">
          <i class="fas fa-link text-[10px]"></i> Domain authority scans
        </span>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-indigo-500/15 text-indigo-400 flex items-center justify-center text-xl border border-indigo-500/25">
        <i class="fas fa-link"></i>
      </div>
    </div>

    <!-- Stat 4: Captured Leads -->
    @php
      $leadsCount = \App\Models\SeoKeywordRanking::whereNotNull('user_email')->count() + \App\Models\SeoBacklinkAudit::whereNotNull('user_email')->count();
    @endphp
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 flex items-center justify-between">
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Captured Tool Leads</p>
        <h4 class="text-2xl font-black text-white mt-1">{{ $leadsCount }}</h4>
        <span class="text-[11px] text-emerald-400 font-semibold flex items-center gap-1 mt-1">
          <i class="fas fa-envelope text-[10px]"></i> Ready for outreach
        </span>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center text-xl border border-emerald-500/25">
        <i class="fas fa-user-plus"></i>
      </div>
    </div>
  </div>

  <!-- Table 1: Google Keyword Ranking Activity -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
    <div class="p-6 border-b border-slate-800 flex flex-wrap items-center justify-between gap-4">
      <div>
        <h3 class="text-lg font-black text-white flex items-center gap-2">
          <i class="fas fa-search text-[#ff3b30]"></i>
          <span>Google Keyword Ranking Searches</span>
        </h3>
        <p class="text-xs text-slate-400 mt-0.5">Live SERP positions queried by visitors</p>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('tools.rank_checker') }}" target="_blank"
           class="px-3.5 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 text-xs font-semibold text-slate-300 transition-colors flex items-center gap-1.5">
          <i class="fas fa-external-link-alt text-[10px]"></i>
          <span>Open Tool</span>
        </a>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs border-collapse">
        <thead class="bg-slate-950/60 text-slate-400 uppercase font-mono tracking-wider text-[11px]">
          <tr>
            <th class="py-3 px-4">Domain</th>
            <th class="py-3 px-4">Target Keyword</th>
            <th class="py-3 px-4">Region</th>
            <th class="py-3 px-4">Google Rank</th>
            <th class="py-3 px-4">Intent / Difficulty</th>
            <th class="py-3 px-4">User Email</th>
            <th class="py-3 px-4">Date &amp; Time</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/60 text-slate-300">
          @forelse($keywordRankings as $rank)
            <tr class="hover:bg-slate-800/40 transition-colors">
              <td class="py-3.5 px-4 font-bold text-white font-mono">
                {{ $rank->domain }}
              </td>
              <td class="py-3.5 px-4 font-semibold text-slate-200">
                "{{ $rank->keyword }}"
              </td>
              <td class="py-3.5 px-4 font-mono uppercase text-slate-400">
                {{ $rank->country }}
              </td>
              <td class="py-3.5 px-4">
                @if($rank->position)
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold font-mono {{ $rank->page === 1 ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-400 border border-amber-500/30' }}">
                    #{{ $rank->position }} (Page {{ $rank->page }})
                  </span>
                @else
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-800 text-slate-400">
                    &gt; 30 / Not Ranked
                  </span>
                @endif
              </td>
              <td class="py-3.5 px-4">
                <div class="text-xs text-slate-300">{{ $rank->ai_intent ?? 'Commercial' }}</div>
                <div class="text-[10px] text-slate-500 font-mono">{{ $rank->ai_difficulty ?? 'Medium' }}</div>
              </td>
              <td class="py-3.5 px-4">
                @if($rank->user_email)
                  <a href="mailto:{{ $rank->user_email }}" class="text-[#ff3b30] hover:underline font-mono text-xs">
                    {{ $rank->user_email }}
                  </a>
                @else
                  <span class="text-slate-600 font-mono text-xs">Anonymous</span>
                @endif
              </td>
              <td class="py-3.5 px-4 text-slate-400 font-mono text-[11px]">
                {{ $rank->created_at->diffForHumans() }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-8 text-center text-slate-500 text-xs">
                No keyword ranking searches recorded yet.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($keywordRankings->hasPages())
      <div class="p-4 border-t border-slate-800">
        {{ $keywordRankings->links() }}
      </div>
    @endif
  </div>

  <!-- Table 2: Backlink & Domain Authority Audits -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
    <div class="p-6 border-b border-slate-800 flex flex-wrap items-center justify-between gap-4">
      <div>
        <h3 class="text-lg font-black text-white flex items-center gap-2">
          <i class="fas fa-link text-indigo-400"></i>
          <span>Backlink &amp; Domain Authority Audits</span>
        </h3>
        <p class="text-xs text-slate-400 mt-0.5">Domain Authority &amp; Link Profile scans</p>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('tools.backlink_checker') }}" target="_blank"
           class="px-3.5 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 text-xs font-semibold text-slate-300 transition-colors flex items-center gap-1.5">
          <i class="fas fa-external-link-alt text-[10px]"></i>
          <span>Open Tool</span>
        </a>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs border-collapse">
        <thead class="bg-slate-950/60 text-slate-400 uppercase font-mono tracking-wider text-[11px]">
          <tr>
            <th class="py-3 px-4">Domain</th>
            <th class="py-3 px-4">Domain Authority (DA)</th>
            <th class="py-3 px-4">PageRank</th>
            <th class="py-3 px-4">Dofollow Ratio</th>
            <th class="py-3 px-4">Toxic Risk</th>
            <th class="py-3 px-4">User Email</th>
            <th class="py-3 px-4">Date &amp; Time</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/60 text-slate-300">
          @forelse($backlinkAudits as $audit)
            <tr class="hover:bg-slate-800/40 transition-colors">
              <td class="py-3.5 px-4 font-bold text-white font-mono">
                {{ $audit->domain }}
              </td>
              <td class="py-3.5 px-4">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black font-mono {{ $audit->domain_authority >= 50 ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($audit->domain_authority >= 30 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30') }}">
                  DA {{ $audit->domain_authority }} / 100
                </span>
              </td>
              <td class="py-3.5 px-4 font-mono font-bold text-slate-200">
                {{ number_format($audit->page_rank, 1) }} / 10
              </td>
              <td class="py-3.5 px-4 font-mono text-emerald-400">
                {{ $audit->dofollow_ratio }}% Dofollow
              </td>
              <td class="py-3.5 px-4">
                <span class="text-xs font-semibold {{ str_contains(strtolower($audit->toxic_risk), 'low') ? 'text-emerald-400' : 'text-amber-400' }}">
                  {{ $audit->toxic_risk }}
                </span>
              </td>
              <td class="py-3.5 px-4">
                @if($audit->user_email)
                  <a href="mailto:{{ $audit->user_email }}" class="text-[#ff3b30] hover:underline font-mono text-xs">
                    {{ $audit->user_email }}
                  </a>
                @else
                  <span class="text-slate-600 font-mono text-xs">Anonymous</span>
                @endif
              </td>
              <td class="py-3.5 px-4 text-slate-400 font-mono text-[11px]">
                {{ $audit->created_at->diffForHumans() }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-8 text-center text-slate-500 text-xs">
                No backlink audits recorded yet.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($backlinkAudits->hasPages())
      <div class="p-4 border-t border-slate-800">
        {{ $backlinkAudits->links() }}
      </div>
    @endif
  </div>

</div>

@endsection
