@extends('layouts.app')

@section('content')

  <!-- ======= SERVICES CATALOG HERO ======= -->
  <section class="relative pt-32 pb-16 lg:pt-36 lg:pb-24 bg-[#faf7f2] border-b border-[#e6dfd3] overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center space-y-4">
      <nav aria-label="Breadcrumb" class="flex items-center justify-center gap-2 text-xs font-semibold text-[#6e675f] mb-2">
        <a href="{{ route('home') }}" class="hover:text-[#ff3b30] transition-colors">Home</a>
        <span class="opacity-40">/</span>
        <span class="text-[#ff3b30] font-bold">Services Catalog</span>
      </nav>

      <span class="badge-pill-eyebrow mx-auto">
        <span>ENGINEERING &amp; SEARCH EXCELLENCE</span>
      </span>

      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#161514] tracking-tight">
        Enterprise Services &amp; Digital Growth Solutions
      </h1>

      <p class="text-base sm:text-lg text-[#6e675f] max-w-2xl mx-auto leading-relaxed">
        High-velocity web development, native mobile applications, technical SEO dominance, and AI workflow automation.
      </p>

      <!-- Category Filter Pills -->
      <div class="pt-6 flex flex-wrap items-center justify-center gap-2">
        <a href="{{ route('services.index') }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ empty($categoryFilter) ? 'bg-[#161514] text-white shadow-md' : 'bg-white border border-[#e6dfd3] text-slate-700 hover:bg-slate-50' }}">
          All Services ({{ $allServices->count() }})
        </a>
        @foreach($categories as $cat)
          <a href="{{ route('services.index', ['category' => $cat]) }}"
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $categoryFilter === $cat ? 'bg-[#ff3b30] text-white shadow-md' : 'bg-white border border-[#e6dfd3] text-slate-700 hover:bg-slate-50' }}">
            {{ $cat }}
          </a>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ======= SERVICES DIRECTORY GRID ======= -->
  <section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($allServices as $svc)
          <article class="p-8 rounded-3xl bg-[#faf7f2] border border-[#e6dfd3] shadow-sm hover:shadow-2xl hover:border-slate-400 transition-all flex flex-col justify-between group">
            <div class="space-y-4">
              @if(!empty($svc->og_image))
                <a href="{{ route('services.show', $svc->slug) }}" class="block rounded-2xl overflow-hidden border border-[#e6dfd3] aspect-[16/9] mb-4 bg-slate-950 relative">
                  <img src="{{ asset($svc->og_image) }}" alt="{{ $svc->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                  <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
                </a>
              @endif
              <div class="flex items-center justify-between">
                <div class="w-12 h-12 rounded-2xl bg-[#161514] text-white flex items-center justify-center text-lg group-hover:bg-[#ff3b30] transition-colors shadow-md">
                  <i class="{{ $svc->icon }}"></i>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-mono font-bold bg-white text-slate-700 border border-[#e6dfd3]">
                  {{ $svc->category }}
                </span>
              </div>

              <div>
                <h2 class="text-xl font-black text-[#161514] tracking-tight group-hover:text-[#ff3b30] transition-colors">
                  <a href="{{ route('services.show', $svc->slug) }}">
                    {{ $svc->title }}
                  </a>
                </h2>
                @if($svc->tagline)
                  <p class="text-xs font-bold text-[#ff3b30] mt-1">{{ $svc->tagline }}</p>
                @endif
              </div>

              <p class="text-xs sm:text-sm text-[#6e675f] leading-relaxed line-clamp-3">
                {{ $svc->short_description }}
              </p>

              @if(!empty($svc->features) && is_array($svc->features))
                <ul class="pt-2 space-y-1.5 text-xs text-slate-600">
                  @foreach(array_slice($svc->features, 0, 3) as $feat)
                    <li class="flex items-center gap-2">
                      <i class="fas fa-check text-[10px] text-emerald-600"></i>
                      <span>{{ $feat }}</span>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>

            <div class="pt-6 mt-6 border-t border-[#e6dfd3] flex items-center justify-between">
              @if($svc->kpi_label && $svc->kpi_value)
                <div class="text-xs">
                  <span class="font-extrabold text-[#161514] font-mono">{{ $svc->kpi_value }}</span>
                  <span class="text-slate-500 text-[11px]">({{ $svc->kpi_label }})</span>
                </div>
              @else
                <span class="text-xs font-bold text-emerald-600">Enterprise Ready</span>
              @endif

              <a href="{{ route('services.show', $svc->slug) }}"
                 class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#161514] hover:bg-black text-white text-xs font-bold transition-colors">
                <span>Explore Page</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
              </a>
            </div>
          </article>
        @empty
          <div class="col-span-3 py-16 text-center text-[#6e675f] space-y-3">
            <p class="text-lg font-bold text-[#161514]">No services found in this category.</p>
            <a href="{{ route('services.index') }}" class="inline-block px-5 py-2.5 rounded-xl bg-[#ff3b30] text-white font-bold text-xs">
              View All Services
            </a>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- ======= BOTTOM CTA BANNER ======= -->
  <section class="py-16 bg-[#faf7f2] border-t border-[#e6dfd3]">
    <div class="max-w-4xl mx-auto px-6 text-center space-y-6">
      <h3 class="text-3xl font-black text-[#161514]">Need a Tailored Custom Architecture?</h3>
      <p class="text-sm text-[#6e675f] max-w-xl mx-auto leading-relaxed">
        We specialize in bespoke enterprise requirements, multi-tenant databases, and compliance frameworks.
      </p>
      <a href="{{ route('home') }}#consultation"
         class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-sm shadow-xl shadow-red-500/20 transition-all">
        <span>Request Custom Architecture Proposal</span>
        <i class="fas fa-arrow-right text-xs"></i>
      </a>
    </div>
  </section>

@endsection
