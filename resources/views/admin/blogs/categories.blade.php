@extends('admin.layouts.admin')

@section('title', 'Blog Categories')

@section('content')
<div class="space-y-6 max-w-5xl">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
        <a href="{{ route('admin.blogs.index') }}" class="hover:text-white transition-colors">Blogs</a>
        <span>/</span>
        <span class="text-[#ff3b30] font-bold">Categories</span>
      </div>
      <h1 class="text-2xl font-black text-white tracking-tight flex items-center gap-2.5">
        <i class="fas fa-tags text-[#ff3b30]"></i>
        <span>Blog Topics &amp; Categories</span>
      </h1>
      <p class="text-xs text-slate-400 mt-1">
        Browse categories and their distribution across your published articles.
      </p>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('admin.blogs.create') }}"
         class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white text-xs font-bold shadow-md shadow-red-500/20 transition-all">
        <i class="fas fa-plus"></i>
        <span>Add Article</span>
      </a>
      <a href="{{ route('admin.blogs.index') }}"
         class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors">
        <i class="fas fa-arrow-left"></i>
        <span>All Articles</span>
      </a>
    </div>
  </div>

  <!-- Categories Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($categories as $cat)
      <div class="p-5 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all space-y-4 shadow-lg group">
        <div class="flex items-center justify-between">
          <div class="w-10 h-10 rounded-xl bg-[#ff3b30]/10 text-[#ff3b30] flex items-center justify-center text-sm font-black group-hover:bg-[#ff3b30] group-hover:text-white transition-colors">
            <i class="fas fa-folder"></i>
          </div>
          <span class="px-2.5 py-1 rounded-full text-xs font-mono font-bold bg-slate-800 text-slate-300">
            {{ $cat->count }} {{ Str::plural('article', $cat->count) }}
          </span>
        </div>

        <div>
          <h3 class="text-lg font-black text-white group-hover:text-[#ff3b30] transition-colors">
            {{ $cat->category }}
          </h3>
          <p class="text-xs text-slate-400 mt-1">
            Browse and manage all technical articles published under {{ $cat->category }}.
          </p>
        </div>

        <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between">
          <a href="{{ route('admin.blogs.index', ['category' => $cat->category]) }}"
             class="text-xs font-bold text-[#ff3b30] hover:underline flex items-center gap-1">
            <span>Filter Articles</span>
            <i class="fas fa-arrow-right text-[10px]"></i>
          </a>
          <a href="{{ route('blogs.index', ['category' => $cat->category]) }}" target="_blank"
             class="text-xs text-slate-500 hover:text-slate-300 transition-colors" title="View Public Listing">
            <i class="fas fa-arrow-up-right-from-square text-[11px]"></i>
          </a>
        </div>
      </div>
    @empty
      <div class="col-span-full py-12 text-center text-slate-500 bg-slate-900 rounded-2xl border border-slate-800">
        <i class="fas fa-tags text-3xl mb-3 text-slate-700 block"></i>
        <p class="font-bold">No categories found in database.</p>
      </div>
    @endforelse
  </div>

</div>
@endsection
