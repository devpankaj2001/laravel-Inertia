@extends('admin.layouts.admin')

@section('title', 'Blog Articles Management')

@section('content')
<div class="space-y-6">

  <!-- Header & Action Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-black text-white tracking-tight flex items-center gap-2.5">
        <i class="fas fa-newspaper text-[#ff3b30]"></i>
        <span>Blog Articles Catalog</span>
      </h1>
      <p class="text-xs text-slate-400 mt-1">
        Publish, update, and optimize technical AI articles, engineering guides, and company news.
      </p>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('blogs.index') }}" target="_blank"
         class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors">
        <i class="fas fa-arrow-up-right-from-square"></i>
        <span>Live Blog Page</span>
      </a>
      <a href="{{ route('admin.blogs.create') }}"
         class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white text-xs font-extrabold shadow-lg shadow-red-500/20 transition-all">
        <i class="fas fa-plus"></i>
        <span>New Article</span>
      </a>
    </div>
  </div>

  <!-- Metric Overview Cards -->
  <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
    <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 space-y-1 shadow-lg">
      <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Articles</span>
      <p class="text-2xl font-black text-white font-mono">{{ $totalPosts }}</p>
      <span class="text-[10px] text-slate-500">In database</span>
    </div>
    <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 space-y-1 shadow-lg">
      <span class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider">Published</span>
      <p class="text-2xl font-black text-emerald-400 font-mono">{{ $publishedCount }}</p>
      <span class="text-[10px] text-slate-500">Live now</span>
    </div>
    <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 space-y-1 shadow-lg">
      <span class="text-[11px] font-bold text-purple-400 uppercase tracking-wider">Scheduled</span>
      <p class="text-2xl font-black text-purple-400 font-mono">{{ $scheduledCount }}</p>
      <span class="text-[10px] text-slate-500">Future release</span>
    </div>
    <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 space-y-1 shadow-lg">
      <span class="text-[11px] font-bold text-amber-400 uppercase tracking-wider">Drafts</span>
      <p class="text-2xl font-black text-amber-400 font-mono">{{ $draftCount }}</p>
      <span class="text-[10px] text-slate-500">Unpublished</span>
    </div>
    <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 space-y-1 shadow-lg">
      <span class="text-[11px] font-bold text-blue-400 uppercase tracking-wider">Categories</span>
      <p class="text-2xl font-black text-blue-400 font-mono">{{ count($categories) }}</p>
      <a href="{{ route('admin.blogs.categories') }}" class="text-[10px] text-[#ff3b30] hover:underline">Manage &rarr;</a>
    </div>
  </div>

  <!-- Search & Filter Controls -->
  <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xl">
    
    <!-- Category Tabs -->
    <div class="flex flex-wrap items-center gap-1.5 w-full md:w-auto">
      <a href="{{ route('admin.blogs.index', array_filter(['status' => $statusFilter, 'search' => $search])) }}"
         class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all border {{ empty($categoryFilter) ? 'bg-[#ff3b30] text-white border-[#ff3b30] shadow-md shadow-red-500/20' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white border-slate-700/60' }}">
        All
      </a>
      @foreach($categories as $cat)
        <a href="{{ route('admin.blogs.index', array_filter(['category' => $cat, 'status' => $statusFilter, 'search' => $search])) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all border {{ $categoryFilter === $cat ? 'bg-[#ff3b30] text-white border-[#ff3b30] shadow-md shadow-red-500/20' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white border-slate-700/60' }}">
          {{ $cat }}
        </a>
      @endforeach
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.blogs.index') }}" class="flex items-center gap-2 w-full md:w-auto">
      @if(!empty($categoryFilter))
        <input type="hidden" name="category" value="{{ $categoryFilter }}">
      @endif
      <div class="relative flex-1 md:w-64">
        <input type="text" name="search" value="{{ $search }}"
               placeholder="Search title, author, excerpt..."
               class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-[#ff3b30]">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
      </div>

      <select name="status" onchange="this.form.submit()"
              class="px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white text-xs focus:outline-none focus:border-[#ff3b30]">
        <option value="">All Status</option>
        <option value="published" {{ $statusFilter === 'published' ? 'selected' : '' }}>Published</option>
        <option value="scheduled" {{ $statusFilter === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
        <option value="draft" {{ $statusFilter === 'draft' ? 'selected' : '' }}>Drafts</option>
      </select>

      @if(!empty($search) || !empty($categoryFilter) || !empty($statusFilter))
        <a href="{{ route('admin.blogs.index') }}" class="px-2.5 py-2 text-xs rounded-xl bg-slate-800 text-slate-400 hover:text-white" title="Clear Filters">
          <i class="fas fa-times"></i>
        </a>
      @endif
    </form>

  </div>

  <!-- Articles Table -->
  <div class="rounded-2xl bg-slate-900 border border-slate-800 overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs text-slate-300">
        <thead class="bg-slate-950/80 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-800">
          <tr>
            <th class="py-3.5 px-4">Article</th>
            <th class="py-3.5 px-4">Category &amp; Tags</th>
            <th class="py-3.5 px-4">Author</th>
            <th class="py-3.5 px-4 text-center">Views</th>
            <th class="py-3.5 px-4 text-center">Featured</th>
            <th class="py-3.5 px-4 text-center">Status</th>
            <th class="py-3.5 px-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/60">
          @forelse($posts as $post)
            <tr class="hover:bg-slate-800/40 transition-colors">
              
              <!-- Article Title & Media -->
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-800 flex-shrink-0 border border-slate-700">
                    <img src="{{ $post->featured_image_url }}" alt="" class="w-full h-full object-cover">
                  </div>
                  <div class="space-y-0.5 max-w-sm">
                    <a href="{{ route('admin.blogs.edit', $post->id) }}" class="font-bold text-white hover:text-[#ff3b30] transition-colors line-clamp-1">
                      {{ $post->title }}
                    </a>
                    <div class="flex items-center gap-2 text-[11px] text-slate-500">
                      <span class="font-mono">{{ $post->slug }}</span>
                      <span>•</span>
                      <span>{{ $post->read_time ?? '5 min' }}</span>
                    </div>
                  </div>
                </div>
              </td>

              <!-- Category & Tags -->
              <td class="py-3.5 px-4">
                <div class="space-y-1">
                  <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold bg-[#ff3b30]/10 text-[#ff3b30] border border-[#ff3b30]/20">
                    {{ $post->category }}
                  </span>
                  @if(!empty($post->tags) && is_array($post->tags))
                    <div class="flex flex-wrap gap-1">
                      @foreach(array_slice($post->tags, 0, 2) as $t)
                        <span class="px-1.5 py-0.5 rounded text-[10px] bg-slate-800 text-slate-400 font-mono">
                          #{{ $t }}
                        </span>
                      @endforeach
                    </div>
                  @endif
                </div>
              </td>

              <!-- Author -->
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-2">
                  <span class="w-7 h-7 rounded-full bg-slate-800 text-amber-400 font-bold flex items-center justify-center text-[10px]">
                    {{ $post->author_initials }}
                  </span>
                  <div>
                    <p class="font-bold text-slate-200">{{ $post->author_name ?? 'Team' }}</p>
                    <p class="text-[10px] text-slate-500">{{ $post->author_role ?? 'Specialist' }}</p>
                  </div>
                </div>
              </td>

              <!-- Views -->
              <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-300">
                {{ number_format($post->views) }}
              </td>

              <!-- Featured Badge -->
              <td class="py-3.5 px-4 text-center">
                @if($post->is_featured)
                  <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    ★ Featured
                  </span>
                @else
                  <span class="text-slate-600">—</span>
                @endif
              </td>

              <!-- Publish Toggle / Scheduled Badge -->
              <td class="py-3.5 px-4 text-center">
                @if($post->is_scheduled)
                  <div class="inline-flex flex-col items-center">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-500/20 text-purple-300 border border-purple-500/30 flex items-center gap-1 shadow-sm">
                      <i class="fas fa-clock text-[9px]"></i> Scheduled
                    </span>
                    <span class="text-[9px] text-slate-400 font-mono mt-0.5" title="{{ $post->published_at ? $post->published_at->toDayDateTimeString() : '' }}">
                      {{ $post->published_at ? $post->published_at->format('M d, H:i') : '' }}
                    </span>
                  </div>
                @else
                  <form method="POST" action="{{ route('admin.blogs.toggle', $post->id) }}">
                    @csrf
                    <button type="submit"
                            class="px-2.5 py-1 rounded-full text-[11px] font-bold transition-all {{ $post->is_published ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 hover:bg-emerald-500/30' : 'bg-slate-800 text-slate-400 border border-slate-700 hover:bg-slate-700' }}">
                      {{ $post->is_published ? 'Published' : 'Draft' }}
                    </button>
                  </form>
                @endif
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a href="{{ route('blogs.show', $post->slug) }}" target="_blank"
                     class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors" title="View Public Page">
                    <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                  </a>
                  <a href="{{ route('admin.blogs.edit', $post->id) }}"
                     class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors" title="Edit Article">
                    <i class="fas fa-pen text-xs"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.blogs.destroy', $post->id) }}" onsubmit="return confirm('Permanently delete this article?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="p-1.5 rounded-lg bg-slate-800 hover:bg-red-500/20 text-slate-400 hover:text-red-400 transition-colors" title="Delete">
                      <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                  </form>
                </div>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-slate-500">
                <i class="fas fa-newspaper text-3xl mb-3 text-slate-700 block"></i>
                <p class="font-bold">No articles found matching your criteria.</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Table Pagination -->
    @if($posts->hasPages())
      <div class="p-4 border-t border-slate-800">
        {{ $posts->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
