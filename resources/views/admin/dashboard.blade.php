@extends('admin.layouts.admin')

@section('title', 'Admin Overview')
@section('page_title', 'System Dashboard & Growth Overview')

@section('admin_content')

  <!-- KPI Cards Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-2">
      <div class="flex items-center justify-between text-slate-400">
        <span class="text-xs font-bold uppercase tracking-wider">Total Inquiries</span>
        <span class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center text-sm"><i class="fas fa-inbox"></i></span>
      </div>
      <div class="flex items-baseline gap-2">
        <span class="text-3xl font-extrabold text-white">{{ $stats['total_inquiries'] }}</span>
        @if($stats['new_inquiries'] > 0)
          <span class="text-xs font-bold text-red-400 bg-red-500/10 px-2 py-0.5 rounded-full border border-red-500/20">
            {{ $stats['new_inquiries'] }} New
          </span>
        @endif
      </div>
      <p class="text-xs text-slate-500">Leads captured via Get in Touch drawer</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-2">
      <div class="flex items-center justify-between text-slate-400">
        <span class="text-xs font-bold uppercase tracking-wider">Core Services</span>
        <span class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-400 flex items-center justify-center text-sm"><i class="fas fa-cubes"></i></span>
      </div>
      <div class="flex items-baseline gap-2">
        <span class="text-3xl font-extrabold text-white">{{ $stats['total_services'] }}</span>
        <span class="text-xs text-emerald-400 font-semibold">Live in Schema</span>
      </div>
      <p class="text-xs text-slate-500">Structured ItemList Schema.org active</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-2">
      <div class="flex items-center justify-between text-slate-400">
        <span class="text-xs font-bold uppercase tracking-wider">Industry Domains</span>
        <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm"><i class="fas fa-industry"></i></span>
      </div>
      <div class="flex items-baseline gap-2">
        <span class="text-3xl font-extrabold text-white">{{ $stats['total_domains'] }}</span>
        <span class="text-xs text-slate-400">Verticals</span>
      </div>
      <p class="text-xs text-slate-500">Targeted search ranking authority</p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-2">
      <div class="flex items-center justify-between text-slate-400">
        <span class="text-xs font-bold uppercase tracking-wider">FAQ Microdata</span>
        <span class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center text-sm"><i class="fas fa-circle-question"></i></span>
      </div>
      <div class="flex items-baseline gap-2">
        <span class="text-3xl font-extrabold text-white">{{ $stats['total_faqs'] }}</span>
        <span class="text-xs text-emerald-400 font-semibold">FAQPage Active</span>
      </div>
      <p class="text-xs text-slate-500">Google Rich Results eligible</p>
    </div>

  </div>

  <!-- Schema Status Banner & Fast Action -->
  <div class="bg-gradient-to-r from-slate-900 via-slate-900 to-red-950/40 border border-slate-800 rounded-3xl p-6 lg:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 shadow-xl">
    <div class="space-y-2 max-w-2xl">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/20 text-xs font-bold">
        <i class="fas fa-shield-halved"></i>
        <span>ADVANCED SEARCH RANKING CENTER</span>
      </div>
      <h3 class="text-2xl font-extrabold text-white">Manage LocalBusiness, Organization &amp; Custom Schema</h3>
      <p class="text-slate-400 text-sm leading-relaxed">
        Control your Google Knowledge Graph appearance, map coordinates, local SEO pack presence, business hours, and inject bespoke Schema.org JSON-LD microdata directly into your site's &lt;head&gt;.
      </p>
    </div>
    <a href="{{ route('admin.schema.index') }}"
       class="px-6 py-3 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2 shrink-0">
      <span>Configure Schema &amp; SEO</span>
      <i class="fas fa-arrow-right text-xs"></i>
    </a>
  </div>

  <!-- Schema Health Check Matrix -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 space-y-4">
    <h3 class="text-base font-bold text-white flex items-center gap-2">
      <i class="fas fa-check-double text-[#ff3b30]"></i>
      <span>Active Schema.org Modules Status</span>
    </h3>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
      <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
        <span class="text-xs text-slate-400 block font-medium">LocalBusiness</span>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ ($schemaToggles['enable_local_business'] ?? true) ? 'text-emerald-400' : 'text-slate-500' }}">
          <span class="w-1.5 h-1.5 rounded-full {{ ($schemaToggles['enable_local_business'] ?? true) ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
          {{ ($schemaToggles['enable_local_business'] ?? true) ? 'Active' : 'Disabled' }}
        </span>
      </div>

      <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
        <span class="text-xs text-slate-400 block font-medium">Organization</span>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ ($schemaToggles['enable_organization'] ?? true) ? 'text-emerald-400' : 'text-slate-500' }}">
          <span class="w-1.5 h-1.5 rounded-full {{ ($schemaToggles['enable_organization'] ?? true) ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
          {{ ($schemaToggles['enable_organization'] ?? true) ? 'Active' : 'Disabled' }}
        </span>
      </div>

      <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
        <span class="text-xs text-slate-400 block font-medium">WebSite Search</span>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ ($schemaToggles['enable_website'] ?? true) ? 'text-emerald-400' : 'text-slate-500' }}">
          <span class="w-1.5 h-1.5 rounded-full {{ ($schemaToggles['enable_website'] ?? true) ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
          {{ ($schemaToggles['enable_website'] ?? true) ? 'Active' : 'Disabled' }}
        </span>
      </div>

      <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
        <span class="text-xs text-slate-400 block font-medium">FAQPage Rich</span>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ ($schemaToggles['enable_faq'] ?? true) ? 'text-emerald-400' : 'text-slate-500' }}">
          <span class="w-1.5 h-1.5 rounded-full {{ ($schemaToggles['enable_faq'] ?? true) ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
          {{ ($schemaToggles['enable_faq'] ?? true) ? 'Active' : 'Disabled' }}
        </span>
      </div>

      <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
        <span class="text-xs text-slate-400 block font-medium">ItemList Services</span>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ ($schemaToggles['enable_services'] ?? true) ? 'text-emerald-400' : 'text-slate-500' }}">
          <span class="w-1.5 h-1.5 rounded-full {{ ($schemaToggles['enable_services'] ?? true) ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
          {{ ($schemaToggles['enable_services'] ?? true) ? 'Active' : 'Disabled' }}
        </span>
      </div>

      <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
        <span class="text-xs text-slate-400 block font-medium">Custom JSON-LD</span>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ ($schemaToggles['enable_custom_jsonld'] ?? true) ? 'text-emerald-400' : 'text-slate-500' }}">
          <span class="w-1.5 h-1.5 rounded-full {{ ($schemaToggles['enable_custom_jsonld'] ?? true) ? 'bg-emerald-400' : 'bg-slate-500' }}"></span>
          {{ ($schemaToggles['enable_custom_jsonld'] ?? true) ? 'Injected' : 'Disabled' }}
        </span>
      </div>
    </div>
  </div>

  <!-- Recent Inquiries Table -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 space-y-4">
    <div class="flex items-center justify-between">
      <div>
        <h3 class="text-lg font-bold text-white">Recent Inquiries &amp; Growth Leads</h3>
        <p class="text-xs text-slate-400">Captured through the interactive Get in Touch drawer</p>
      </div>
      <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-bold text-[#ff3b30] hover:underline flex items-center gap-1">
        <span>View All Inquiries</span> <i class="fas fa-arrow-right text-[10px]"></i>
      </a>
    </div>

    @if($recentInquiries->isEmpty())
      <div class="p-8 text-center text-slate-500 text-sm">
        No inquiries received yet. Leads submitted through the home page will appear here instantly.
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="border-b border-slate-800 text-slate-400 text-xs uppercase tracking-wider font-semibold">
              <th class="py-3 px-4">Contact</th>
              <th class="py-3 px-4">Company</th>
              <th class="py-3 px-4">Interest</th>
              <th class="py-3 px-4">Date</th>
              <th class="py-3 px-4">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            @foreach($recentInquiries as $inq)
              <tr class="hover:bg-slate-800/30 transition-colors">
                <td class="py-3 px-4">
                  <div class="font-bold text-white">{{ $inq->name }}</div>
                  <div class="text-xs text-slate-400">{{ $inq->email }}</div>
                </td>
                <td class="py-3 px-4 text-xs">{{ $inq->company ?? '—' }}</td>
                <td class="py-3 px-4">
                  <span class="px-2 py-0.5 rounded-md bg-slate-800 text-xs text-slate-300">{{ $inq->service_interest ?? 'General' }}</span>
                </td>
                <td class="py-3 px-4 text-xs text-slate-400">{{ $inq->created_at->diffForHumans() }}</td>
                <td class="py-3 px-4">
                  @if($inq->status === 'new')
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-red-500/20 text-red-400 border border-red-500/30">New</span>
                  @elseif($inq->status === 'contacted')
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Contacted</span>
                  @else
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400 border border-blue-500/30">{{ ucfirst($inq->status) }}</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

@endsection
