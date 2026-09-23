@extends('admin.layouts.admin')

@section('title', 'Inquiries & Growth Leads')
@section('page_title', 'Inbound Leads & Growth Inquiries')

@section('admin_content')

<div class="space-y-6">

  <!-- Header Filter Bar -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
    <div class="flex flex-wrap items-center gap-2">
      <a href="{{ route('admin.inquiries.index') }}"
         class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ !request('status') ? 'bg-[#ff3b30] text-white' : 'bg-slate-800 text-slate-300 hover:text-white' }}">
        All Leads
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
              <th class="py-3 px-4">Company &amp; Phone</th>
              <th class="py-3 px-4">Service &amp; Budget</th>
              <th class="py-3 px-4">Message / Requirements</th>
              <th class="py-3 px-4">Date</th>
              <th class="py-3 px-4">Status &amp; Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            @foreach($inquiries as $inq)
              <tr class="hover:bg-slate-800/30 transition-colors align-top">
                <td class="py-4 px-4">
                  <div class="text-xs font-mono text-slate-500">#{{ $inq->id }}</div>
                  <div class="font-bold text-white text-sm">{{ $inq->name }}</div>
                  <a href="mailto:{{ $inq->email }}" class="text-xs text-[#ff3b30] hover:underline block">{{ $inq->email }}</a>
                </td>

                <td class="py-4 px-4 text-xs">
                  <div class="font-semibold text-slate-200">{{ $inq->company ?? 'Direct Prospect' }}</div>
                  <div class="text-slate-400">{{ $inq->phone ?? '—' }}</div>
                </td>

                <td class="py-4 px-4">
                  <span class="inline-block px-2.5 py-1 rounded-lg bg-slate-800 text-xs font-semibold text-slate-300 mb-1">
                    {{ $inq->service_interest ?? 'General Growth' }}
                  </span>
                  @if($inq->budget)
                    <div class="text-[11px] text-emerald-400 font-mono">{{ $inq->budget }}</div>
                  @endif
                </td>

                <td class="py-4 px-4 text-xs text-slate-400 max-w-xs">
                  <div class="line-clamp-3">{{ $inq->message ?: 'No additional message provided.' }}</div>
                </td>

                <td class="py-4 px-4 text-xs text-slate-400 whitespace-nowrap">
                  <div>{{ $inq->created_at->format('M d, Y') }}</div>
                  <div class="text-[10px] text-slate-500">{{ $inq->created_at->format('h:i A') }}</div>
                </td>

                <td class="py-4 px-4 whitespace-nowrap">
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

@endsection
