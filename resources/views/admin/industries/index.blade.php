@extends('admin.layouts.admin')

@section('title', 'Industries & Verticals Management')

@section('content')
<div class="space-y-6">

  <!-- Header & Top Stats -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-black text-white tracking-tight flex items-center gap-3">
        <i class="fas fa-building text-[#ff3b30]"></i>
        <span>Industries &amp; Verticals</span>
      </h1>
      <p class="text-sm text-slate-400 mt-1">Manage vertical industry landing pages, conversion metrics, architectural solutions, and SEO.</p>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('industries.index') }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold transition-colors flex items-center gap-2 border border-slate-700">
        <i class="fas fa-external-link-alt text-[10px]"></i>
        <span>View Live Directory</span>
      </a>
      <a href="{{ route('admin.industries.create') }}" class="px-4 py-2 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white text-xs font-extrabold uppercase tracking-wider transition-all flex items-center gap-2 shadow-lg shadow-red-500/20">
        <i class="fas fa-plus"></i>
        <span>Add Industry</span>
      </a>
    </div>
  </div>

  <!-- Metric Quick Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-xs text-slate-400 font-semibold">Total Verticals</p>
        <p class="text-2xl font-black text-white mt-0.5">{{ $totalCount }}</p>
      </div>
      <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-slate-400">
        <i class="fas fa-cubes text-base"></i>
      </div>
    </div>
    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-xs text-slate-400 font-semibold">Live / Active Pages</p>
        <p class="text-2xl font-black text-emerald-400 mt-0.5">{{ $activeCount }}</p>
      </div>
      <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
        <i class="fas fa-circle-check text-base"></i>
      </div>
    </div>
    <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-between">
      <div>
        <p class="text-xs text-slate-400 font-semibold">Inactive / Drafts</p>
        <p class="text-2xl font-black text-amber-400 mt-0.5">{{ $inactiveCount }}</p>
      </div>
      <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center">
        <i class="fas fa-pause-circle text-base"></i>
      </div>
    </div>
  </div>

  <!-- Filter & Search Controls -->
  <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800">
    <form method="GET" action="{{ route('admin.industries.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
      <!-- Search -->
      <div class="md:col-span-5 relative">
        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by industry name, slug, keywords..." class="w-full pl-9 pr-4 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30]">
      </div>

      <!-- Category Group Filter -->
      <div class="md:col-span-4">
        <select name="group" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-slate-300 focus:outline-none focus:border-[#ff3b30]">
          <option value="all">All Category Groups</option>
          @foreach($categoryGroups as $grp)
            <option value="{{ $grp }}" {{ request('group') === $grp ? 'selected' : '' }}>{{ $grp }}</option>
          @endforeach
        </select>
      </div>

      <!-- Status Filter -->
      <div class="md:col-span-2">
        <select name="status" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-slate-300 focus:outline-none focus:border-[#ff3b30]">
          <option value="">All Status</option>
          <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
          <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
        </select>
      </div>

      <!-- Buttons -->
      <div class="md:col-span-1 flex items-center gap-1.5">
        <button type="submit" class="w-full py-2 px-3 bg-[#ff3b30] hover:bg-red-600 text-white rounded-xl text-xs font-bold transition-colors flex items-center justify-center" title="Apply Filter">
          <i class="fas fa-filter"></i>
        </button>
        @if(request('search') || request('status') || request('group'))
          <a href="{{ route('admin.industries.index') }}" class="py-2 px-3 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white rounded-xl text-xs transition-colors flex items-center justify-center" title="Reset Filter">
            <i class="fas fa-rotate-left"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Industries Table -->
  <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
    @if($industries->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
          <thead class="text-xs uppercase bg-slate-950/60 text-slate-400 border-b border-slate-800">
            <tr>
              <th scope="col" class="py-3.5 px-4 w-12 text-center">#</th>
              <th scope="col" class="py-3.5 px-4">Industry &amp; Slug</th>
              <th scope="col" class="py-3.5 px-4">Category Group</th>
              <th scope="col" class="py-3.5 px-4">Key Metric</th>
              <th scope="col" class="py-3.5 px-4 text-center">Status</th>
              <th scope="col" class="py-3.5 px-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800">
            @foreach($industries as $industry)
              <tr class="hover:bg-slate-800/40 transition-colors">
                
                <!-- Order/ID -->
                <td class="py-3.5 px-4 text-center text-xs font-mono text-slate-500">
                  {{ $industry->sort_order ?: $industry->id }}
                </td>

                <!-- Industry Name + Icon + Slug -->
                <td class="py-3.5 px-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-[#ff3b30] flex-shrink-0 text-base">
                      <i class="{{ $industry->icon_class }}"></i>
                    </div>
                    <div class="space-y-0.5 max-w-sm">
                      <a href="{{ route('admin.industries.edit', $industry->id) }}" class="font-bold text-white hover:text-[#ff3b30] transition-colors leading-snug block">
                        {{ $industry->name }}
                      </a>
                      <p class="text-xs text-slate-400 line-clamp-1">
                        {{ $industry->description ?? 'No summary provided.' }}
                      </p>
                      <div class="flex items-center gap-2 text-[11px] text-slate-500 font-mono">
                        <span>/industries/{{ $industry->slug }}</span>
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Category Group -->
                <td class="py-3.5 px-4">
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                    {{ $industry->category_group ?: 'General' }}
                  </span>
                </td>

                <!-- Highlight Metric -->
                <td class="py-3.5 px-4">
                  @if(!empty($industry->highlight_stat))
                    <div class="space-y-0.5">
                      <span class="font-black text-emerald-400 text-xs">{{ $industry->highlight_stat }}</span>
                      <span class="text-[11px] text-slate-400 block">{{ $industry->stat_label ?? 'Metric' }}</span>
                    </div>
                  @else
                    <span class="text-xs text-slate-500">—</span>
                  @endif
                </td>

                <!-- Status Toggle -->
                <td class="py-3.5 px-4 text-center">
                  <form action="{{ route('admin.industries.toggle', $industry->id) }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="px-2.5 py-1 rounded-full text-[11px] font-bold transition-all {{ $industry->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500/20' : 'bg-slate-800 text-slate-400 border border-slate-700 hover:bg-slate-700' }}" title="Click to toggle status">
                      {{ $industry->is_active ? '● Active' : '○ Inactive' }}
                    </button>
                  </form>
                </td>

                <!-- Actions -->
                <td class="py-3.5 px-4 text-right">
                  <div class="flex items-center justify-end gap-1.5">
                    <!-- Live View -->
                    <a href="{{ route('industries.show', $industry->slug) }}" target="_blank" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors" title="View Public Page">
                      <i class="fas fa-external-link-alt text-xs"></i>
                    </a>

                    <!-- Edit -->
                    <a href="{{ route('admin.industries.edit', $industry->id) }}" class="p-2 rounded-lg bg-slate-800 hover:bg-[#ff3b30] text-slate-400 hover:text-white transition-colors" title="Edit Industry">
                      <i class="fas fa-pen-to-square text-xs"></i>
                    </a>

                    <!-- Delete Form -->
                    <form action="{{ route('admin.industries.destroy', $industry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the industry \'{{ addslashes($industry->name) }}\'? This cannot be undone.');" class="inline-block">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-2 rounded-lg bg-slate-800 hover:bg-red-600 text-slate-400 hover:text-white transition-colors" title="Delete Industry">
                        <i class="fas fa-trash text-xs"></i>
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
      <div class="p-4 border-t border-slate-800">
        {{ $industries->links() }}
      </div>
    @else
      <div class="py-16 text-center space-y-4">
        <div class="w-16 h-16 rounded-full bg-slate-800 text-slate-500 flex items-center justify-center mx-auto text-2xl">
          <i class="fas fa-cubes"></i>
        </div>
        <h3 class="text-base font-bold text-white">No industries found</h3>
        <p class="text-xs text-slate-400 max-w-sm mx-auto">Try clearing search filters or add a new industry vertical to get started.</p>
        <a href="{{ route('admin.industries.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#ff3b30] text-white text-xs font-bold uppercase tracking-wider">
          <i class="fas fa-plus"></i> Add New Industry
        </a>
      </div>
    @endif
  </div>

</div>
@endsection
