@extends('admin.layouts.admin')

@section('title', 'Services Catalog')
@section('page_title', 'Services & Dynamic Categories')

@section('admin_content')
<div class="space-y-6">

  <!-- Feedback Flash Messages -->
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

  <!-- Top Metric Cards & Actions -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Services</p>
        <p class="text-2xl font-black text-white mt-1">{{ $totalCount }}</p>
      </div>
      <div class="w-11 h-11 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-[#ff3b30] text-lg">
        <i class="fas fa-layer-group"></i>
      </div>
    </div>

    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active on Site</p>
        <p class="text-2xl font-black text-emerald-400 mt-1">{{ $activeCount }}</p>
      </div>
      <div class="w-11 h-11 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-lg">
        <i class="fas fa-toggle-on"></i>
      </div>
    </div>

    <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dynamic Categories</p>
        <p class="text-2xl font-black text-amber-400 mt-1">{{ count($categories) }}</p>
      </div>
      <div class="w-11 h-11 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 text-lg">
        <i class="fas fa-tags"></i>
      </div>
    </div>

    <div class="p-5 rounded-2xl bg-gradient-to-br from-red-500/20 via-slate-900 to-slate-900 border border-red-500/30 flex items-center justify-between">
      <div>
        <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Need New Service?</p>
        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 mt-2 px-3.5 py-1.5 rounded-lg bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-xs shadow-md shadow-red-500/30 transition-all">
          <i class="fas fa-plus"></i> Add Service
        </a>
      </div>
      <a href="{{ route('admin.services.categories') }}" class="text-xs font-bold text-slate-400 hover:text-white underline">
        Categories →
      </a>
    </div>
  </div>

  <!-- Dynamic Filter Bar -->
  <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 space-y-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      
      <!-- Category Filter Pills (Dynamic from DB) -->
      <div class="flex flex-wrap items-center gap-2">
        <span class="text-xs font-bold text-slate-400 mr-1 flex items-center gap-1.5">
          <i class="fas fa-filter text-[10px]"></i> Category:
        </span>
        <a href="{{ route('admin.services.index', array_filter(['status' => $statusFilter, 'search' => $search])) }}"
           class="px-3 py-1 rounded-lg text-xs font-bold transition-all {{ empty($categoryFilter) ? 'bg-[#ff3b30] text-white shadow-sm' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
          All ({{ $totalCount }})
        </a>
        @foreach($categories as $cat)
          <a href="{{ route('admin.services.index', array_filter(['category' => $cat, 'status' => $statusFilter, 'search' => $search])) }}"
             class="px-3 py-1 rounded-lg text-xs font-bold transition-all {{ $categoryFilter === $cat ? 'bg-[#ff3b30] text-white shadow-sm' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
            {{ $cat }} <span class="opacity-75 font-mono text-[10px]">({{ $categoryCounts[$cat] ?? 0 }})</span>
          </a>
        @endforeach
      </div>

      <!-- Search & Status Form -->
      <form method="GET" action="{{ route('admin.services.index') }}" class="flex items-center gap-2">
        @if(!empty($categoryFilter))
          <input type="hidden" name="category" value="{{ $categoryFilter }}">
        @endif

        <div class="relative">
          <input type="text" name="search" value="{{ $search }}" placeholder="Search service..."
                 class="w-48 sm:w-56 pl-8 pr-3 py-1.5 text-xs rounded-xl bg-slate-950 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30]">
          <i class="fas fa-search absolute left-2.5 top-2 text-slate-500 text-xs"></i>
        </div>

        <select name="status" onchange="this.form.submit()"
                class="px-2.5 py-1.5 text-xs rounded-xl bg-slate-950 border border-slate-700 text-white focus:outline-none focus:border-[#ff3b30]">
          <option value="">All Status</option>
          <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Active Only</option>
          <option value="inactive" {{ $statusFilter === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
        </select>

        @if(!empty($categoryFilter) || !empty($statusFilter) || !empty($search))
          <a href="{{ route('admin.services.index') }}" class="px-2.5 py-1.5 text-xs rounded-xl bg-slate-800 text-slate-400 hover:text-white" title="Clear Filters">
            <i class="fas fa-rotate-left"></i>
          </a>
        @endif
      </form>
    </div>
  </div>

  <!-- Services Table -->
  <div class="rounded-2xl bg-slate-900 border border-slate-800 overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-sm">
        <thead>
          <tr class="border-b border-slate-800 bg-slate-950/60 text-xs font-bold uppercase tracking-wider text-slate-400">
            <th class="py-3.5 px-4 w-12 text-center">#</th>
            <th class="py-3.5 px-4">Service Details</th>
            <th class="py-3.5 px-4">Dynamic Category</th>
            <th class="py-3.5 px-4">KPI / Badge</th>
            <th class="py-3.5 px-4 text-center">Sort Order</th>
            <th class="py-3.5 px-4 text-center">Status</th>
            <th class="py-3.5 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/60">
          @forelse($services as $index => $svc)
            <tr class="hover:bg-slate-800/40 transition-colors {{ !$svc->is_active ? 'opacity-60' : '' }}">
              <!-- Index -->
              <td class="py-4 px-4 text-center font-mono text-xs text-slate-500">
                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
              </td>

              <!-- Service Details (Icon, Title, Tagline, Slug) -->
              <td class="py-4 px-4">
                <div class="flex items-start gap-3">
                  <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-[#ff3b30] text-base shrink-0 mt-0.5 shadow-inner">
                    <i class="{{ $svc->icon }}"></i>
                  </div>
                  <div>
                    <div class="flex items-center gap-2">
                      <a href="{{ route('admin.services.edit', $svc->id) }}" class="font-extrabold text-white hover:text-[#ff3b30] transition-colors">
                        {{ $svc->title }}
                      </a>
                      @if($svc->is_featured)
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                          Featured
                        </span>
                      @endif
                    </div>
                    @if($svc->tagline)
                      <p class="text-xs text-slate-400 line-clamp-1 mt-0.5">{{ $svc->tagline }}</p>
                    @endif
                    <p class="text-[11px] font-mono text-slate-500 mt-0.5">slug: <span class="text-slate-400">/{{ $svc->slug }}</span></p>
                  </div>
                </div>
              </td>

              <!-- Dynamic Category Badge(s) -->
              <td class="py-4 px-4">
                <div class="flex flex-wrap gap-1.5 max-w-[240px]">
                  @foreach($svc->all_categories as $catItem)
                    <a href="{{ route('admin.services.index', ['category' => $catItem]) }}"
                       class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 transition-colors">
                      <i class="fas fa-tag text-[9px] text-amber-400"></i>
                      <span>{{ $catItem }}</span>
                    </a>
                  @endforeach
                </div>
              </td>

              <!-- KPI / Badge -->
              <td class="py-4 px-4">
                <div class="space-y-1">
                  @if($svc->badge)
                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                      {{ $svc->badge }}
                    </span>
                  @endif
                  @if($svc->kpi_label && $svc->kpi_value)
                    <div class="text-xs font-mono text-slate-400">
                      <span class="text-emerald-400 font-bold">{{ $svc->kpi_value }}</span>
                      <span class="text-slate-500 text-[11px]">({{ $svc->kpi_label }})</span>
                    </div>
                  @endif
                </div>
              </td>

              <!-- Sort Order -->
              <td class="py-4 px-4 text-center font-mono text-xs text-slate-300">
                {{ $svc->sort_order }}
              </td>

              <!-- Status Toggle -->
              <td class="py-4 px-4 text-center">
                <form method="POST" action="{{ route('admin.services.toggle', $svc->id) }}">
                  @csrf
                  <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold transition-all {{ $svc->is_active ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 hover:bg-emerald-500/30' : 'bg-slate-800 text-slate-400 border border-slate-700 hover:bg-slate-700' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $svc->is_active ? 'bg-emerald-400 animate-pulse' : 'bg-slate-500' }}"></span>
                    {{ $svc->is_active ? 'Active' : 'Inactive' }}
                  </button>
                </form>
              </td>

              <!-- Actions -->
              <td class="py-4 px-4 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a href="{{ route('admin.services.edit', $svc->id) }}"
                     class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors"
                     title="Edit Service">
                    <i class="fas fa-pen-to-square text-xs"></i>
                  </a>

                  <form method="POST" action="{{ route('admin.services.destroy', $svc->id) }}"
                        onsubmit="return confirm('Are you sure you want to delete the service \'{{ addslashes($svc->title) }}\'?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="p-2 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 border border-red-500/20 transition-colors"
                            title="Delete Service">
                      <i class="fas fa-trash-can text-xs"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-slate-400">
                <div class="max-w-sm mx-auto space-y-3">
                  <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-slate-500 mx-auto text-xl">
                    <i class="fas fa-layer-group"></i>
                  </div>
                  <p class="font-bold text-white">No services found</p>
                  <p class="text-xs text-slate-500">
                    @if(!empty($categoryFilter) || !empty($search) || !empty($statusFilter))
                      No services match your active filters. Try clearing filters or creating a new service.
                    @else
                      Get started by adding your first service to the catalog.
                    @endif
                  </p>
                  <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-xs shadow-lg shadow-red-500/20 transition-all">
                    <i class="fas fa-plus"></i> Add New Service
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
