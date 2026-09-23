@extends('admin.layouts.admin')

@section('title', 'Dynamic Service Categories')
@section('page_title', 'Dynamic Categories')

@section('admin_content')
<div class="space-y-6">

  <!-- Header Breadcrumb & Actions -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
      <a href="{{ route('admin.services.index') }}" class="hover:text-white transition-colors">Services</a>
      <span>/</span>
      <span class="text-white">Dynamic Categories ({{ count($categories) }})</span>
    </div>
    <div class="flex items-center gap-2">
      <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white text-xs font-bold shadow-md shadow-red-500/20 transition-all">
        <i class="fas fa-plus"></i> Add Service in Category
      </a>
      <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors">
        <i class="fas fa-arrow-left"></i> All Services
      </a>
    </div>
  </div>

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

  <!-- Explanation Banner -->
  <div class="p-5 rounded-2xl bg-gradient-to-r from-amber-500/10 via-slate-900 to-slate-900 border border-amber-500/20 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-start gap-3">
      <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
        <i class="fas fa-lightbulb"></i>
      </div>
      <div>
        <h4 class="text-sm font-extrabold text-white">How Dynamic Categories Work</h4>
        <p class="text-xs text-slate-400 mt-1 leading-relaxed">
          Categories in WebRanker are completely dynamic. When you assign or type a new category in any service, it automatically registers as a pillar and populates the frontend mega-menu, sitemaps, and category filters.
        </p>
      </div>
    </div>
  </div>

  <!-- Dynamic Categories Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @forelse($categories as $categoryName)
      @php
        $categoryServices = $servicesGrouped[$categoryName] ?? collect();
      @endphp
      <div class="rounded-2xl bg-slate-900 border border-slate-800 overflow-hidden shadow-xl flex flex-col justify-between">
        
        <!-- Category Card Header -->
        <div class="p-5 border-b border-slate-800 bg-slate-950/50">
          <div class="flex items-start justify-between gap-2">
            <div class="space-y-1">
              <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                <i class="fas fa-tag text-[9px]"></i> Dynamic Category
              </span>
              <h3 class="text-lg font-black text-white tracking-tight">{{ $categoryName }}</h3>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-mono font-bold bg-slate-800 text-slate-300 border border-slate-700">
              {{ $categoryServices->count() }} {{ Str::plural('Service', $categoryServices->count()) }}
            </span>
          </div>
        </div>

        <!-- Services in this Category -->
        <div class="p-5 space-y-2.5 flex-1">
          <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Services inside this pillar:</p>
          <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
            @forelse($categoryServices as $svc)
              <div class="p-2.5 rounded-xl bg-slate-950 border border-slate-800 flex items-center justify-between hover:border-slate-700 transition-colors">
                <div class="flex items-center gap-2.5 min-w-0">
                  <div class="w-7 h-7 rounded-lg bg-slate-800 text-[#ff3b30] flex items-center justify-center text-xs shrink-0">
                    <i class="{{ $svc->icon }}"></i>
                  </div>
                  <div class="truncate">
                    <p class="text-xs font-bold text-white truncate">{{ $svc->title }}</p>
                    <p class="text-[10px] text-slate-500 truncate">{{ $svc->tagline ?? $svc->slug }}</p>
                  </div>
                </div>
                <div class="flex items-center gap-1 shrink-0 ml-2">
                  <span class="w-2 h-2 rounded-full {{ $svc->is_active ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                  <a href="{{ route('admin.services.edit', $svc->id) }}" class="p-1 text-slate-400 hover:text-white text-xs" title="Edit">
                    <i class="fas fa-pen-to-square"></i>
                  </a>
                </div>
              </div>
            @empty
              <p class="text-xs text-slate-500 italic py-2">No services currently assigned to this category.</p>
            @endforelse
          </div>
        </div>

        <!-- Category Actions & Rename Tool -->
        <div class="p-4 bg-slate-950/80 border-t border-slate-800 space-y-3">
          <details class="group">
            <summary class="cursor-pointer text-xs font-bold text-slate-400 hover:text-white flex items-center justify-between select-none">
              <span class="flex items-center gap-1.5"><i class="fas fa-pen text-[10px]"></i> Rename Category Across Services</span>
              <i class="fas fa-chevron-down text-[10px] group-open:rotate-180 transition-transform"></i>
            </summary>
            <form method="POST" action="{{ route('admin.services.categories.update') }}" class="mt-3 space-y-2">
              @csrf
              <input type="hidden" name="old_category" value="{{ $categoryName }}">
              <div class="flex gap-2">
                <input type="text" name="new_category" value="{{ $categoryName }}" required
                       class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
                <button type="submit"
                        class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs shrink-0 transition-colors">
                  Save
                </button>
              </div>
            </form>
          </details>

          <div class="flex items-center justify-between pt-1">
            <a href="{{ route('admin.services.index', ['category' => $categoryName]) }}"
               class="text-xs font-bold text-slate-400 hover:text-white flex items-center gap-1">
              <span>Filter catalog</span> <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
            <a href="{{ route('admin.services.create') }}"
               class="text-xs font-bold text-[#ff3b30] hover:text-red-400 flex items-center gap-1">
              <i class="fas fa-plus text-[10px]"></i> <span>Add in category</span>
            </a>
          </div>
        </div>

      </div>
    @empty
      <div class="col-span-3 py-12 text-center text-slate-500">
        <p class="font-bold text-slate-400">No categories found in database.</p>
        <a href="{{ route('admin.services.create') }}" class="inline-block mt-3 px-4 py-2 rounded-xl bg-[#ff3b30] text-white text-xs font-bold">
          Create First Service &amp; Category
        </a>
      </div>
    @endforelse
  </div>

</div>
@endsection
