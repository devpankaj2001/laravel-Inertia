<div class="industries-landing-page bg-[#faf7f2] min-h-screen">

  <!-- ======= 1. HERO SECTION ======= -->
  <section class="relative pt-32 pb-20 lg:pt-36 lg:pb-24 bg-[#faf7f2] border-b border-[#e6dfd3] overflow-hidden">
    <!-- Ambient Background Lighting -->
    <div class="absolute inset-0 pointer-events-none opacity-40">
      <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-b from-red-200/40 via-amber-100/30 to-transparent blur-3xl rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
      <!-- Breadcrumbs -->
      <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex flex-wrap items-center gap-2 text-xs font-semibold text-[#6e675f]">
          <li>
            <a href="{{ route('home') }}" class="hover:text-[#ff3b30] transition-colors flex items-center gap-1.5">
              <i class="fas fa-house-chimney text-[11px]"></i> Home
            </a>
          </li>
          <li class="opacity-40">/</li>
          <li class="text-[#ff3b30] font-bold" aria-current="page">Industries</li>
        </ol>
      </nav>

      <div class="max-w-4xl mx-auto text-center space-y-5">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold bg-[#161514] text-[#cfa86e] shadow-sm">
          <span class="w-1.5 h-1.5 rounded-full bg-[#ff3b30] animate-pulse"></span>
          <span>ENTERPRISE VERTICAL ARCHITECTURE</span>
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#161514] tracking-tight leading-[1.1]">
          Industry Solutions Built for <span class="text-[#ff3b30]">Compliance, Speed &amp; Scale</span>
        </h1>

        <p class="text-base sm:text-lg text-[#6e675f] leading-relaxed max-w-2xl mx-auto">
          Generic templates fail when complex industry compliance and high-throughput transactional speed collide. We engineer bespoke full-stack systems tailored to your specific vertical requirements.
        </p>

        <!-- Search Bar -->
        <div class="pt-4 max-w-xl mx-auto">
          <form method="GET" action="{{ route('industries.index') }}" class="relative flex items-center">
            @if(request('group') && request('group') !== 'all')
              <input type="hidden" name="group" value="{{ request('group') }}">
            @endif
            <i class="fas fa-search absolute left-4 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Search by industry (e.g. Health, FinTech, E-Commerce, Logistics)..."
                   class="w-full pl-11 pr-28 py-3.5 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm text-sm text-[#161514] placeholder-slate-400 focus:outline-none focus:border-[#ff3b30] focus:ring-2 focus:ring-red-500/10 transition-all">
            <button type="submit" class="absolute right-2 px-4 py-2 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs uppercase tracking-wider transition-all">
              Search
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= 2. FILTER TABS & DIRECTORY GRID ======= -->
  <section class="py-16 bg-white border-b border-[#e6dfd3]">
    <div class="max-w-7xl mx-auto px-6 space-y-10">

      <!-- Category Filter Pills -->
      <div class="flex flex-wrap items-center justify-center gap-2 border-b border-[#f0eae1] pb-6">
        <a href="{{ route('industries.index', ['search' => request('search')]) }}"
           class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ empty($selectedGroup) || $selectedGroup === 'all' ? 'bg-[#161514] text-white shadow-md' : 'bg-[#faf7f2] hover:bg-[#f2ece1] text-[#6e675f] border border-[#e6dfd3]' }}">
          All Verticals ({{ $totalIndustriesCount }})
        </a>
        @foreach($categoryGroups as $grp)
          <a href="{{ route('industries.index', ['group' => $grp->category_group, 'search' => request('search')]) }}"
             class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ $selectedGroup === $grp->category_group ? 'bg-[#ff3b30] text-white shadow-md shadow-red-500/20' : 'bg-[#faf7f2] hover:bg-[#f2ece1] text-[#6e675f] border border-[#e6dfd3]' }}">
            {{ $grp->category_group }} ({{ $grp->count }})
          </a>
        @endforeach
      </div>

      <!-- Active Search Warning / Clear -->
      @if(!empty($searchQuery) || ($selectedGroup !== 'all' && !empty($selectedGroup)))
        <div class="flex items-center justify-between text-xs text-[#6e675f] bg-[#faf7f2] p-3 rounded-xl border border-[#e6dfd3]">
          <span>
            Showing results for
            @if(!empty($selectedGroup) && $selectedGroup !== 'all') <strong>Group: "{{ $selectedGroup }}"</strong> @endif
            @if(!empty($searchQuery)) <strong>Search: "{{ $searchQuery }}"</strong> @endif
          </span>
          <a href="{{ route('industries.index') }}" class="text-[#ff3b30] font-bold hover:underline">Clear all filters</a>
        </div>
      @endif

      <!-- Industries Grid -->
      @if($industries->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          @foreach($industries as $industry)
            <article class="domain-card-box group bg-[#faf7f2] hover:bg-white rounded-3xl border border-[#e6dfd3] hover:border-[#161514] p-7 transition-all duration-300 shadow-sm hover:shadow-xl flex flex-col justify-between h-full">
              
              <div class="space-y-4">
                <!-- Top Row: Icon + Category Badge -->
                <div class="flex items-center justify-between">
                  <div class="w-12 h-12 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm flex items-center justify-center text-[#ff3b30] text-xl group-hover:scale-110 group-hover:bg-[#ff3b30] group-hover:text-white transition-all duration-300">
                    <i class="{{ $industry->icon_class }}"></i>
                  </div>
                  @if(!empty($industry->category_group))
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#f2ece1] text-[#6e675f] border border-[#e6dfd3]">
                      {{ $industry->category_group }}
                    </span>
                  @endif
                </div>

                <!-- Title & Headline -->
                <div>
                  <h3 class="text-xl font-black text-[#161514] group-hover:text-[#ff3b30] transition-colors leading-snug">
                    <a href="{{ route('industries.show', $industry->slug) }}" class="focus:outline-none">
                      {{ $industry->name }}
                    </a>
                  </h3>
                  <p class="text-xs text-[#6e675f] leading-relaxed mt-2 line-clamp-3">
                    {{ $industry->description ?? 'Bespoke full-stack digital architectures engineered specifically for enterprise throughput and Google search dominance.' }}
                  </p>
                </div>

                <!-- Tags / Capabilities -->
                @if(!empty($industry->tags) && is_array($industry->tags))
                  <div class="flex flex-wrap gap-1.5 pt-1">
                    @foreach(array_slice($industry->tags, 0, 3) as $tag)
                      <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md bg-white text-slate-700 border border-[#e6dfd3]">
                        {{ $tag }}
                      </span>
                    @endforeach
                  </div>
                @endif
              </div>

              <!-- Footer with Metric & Link -->
              <div class="pt-6 mt-6 border-t border-[#e6dfd3] flex items-center justify-between">
                <div>
                  @if(!empty($industry->highlight_stat))
                    <span class="font-mono font-black text-sm text-[#161514] block">{{ $industry->highlight_stat }}</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#ff3b30]">{{ $industry->stat_label ?? 'Performance' }}</span>
                  @else
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Enterprise Ready</span>
                  @endif
                </div>

                <a href="{{ route('industries.show', $industry->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-[#161514] group-hover:text-[#ff3b30] transition-colors">
                  <span>Explore Blueprint</span>
                  <i class="fas fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
                </a>
              </div>

            </article>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="pt-8">
          {{ $industries->links() }}
        </div>
      @else
        <div class="py-20 text-center space-y-4">
          <div class="w-16 h-16 rounded-full bg-[#faf7f2] text-slate-400 flex items-center justify-center mx-auto text-2xl border border-[#e6dfd3]">
            <i class="fas fa-filter"></i>
          </div>
          <h3 class="text-xl font-bold text-[#161514]">No matching vertical solutions found</h3>
          <p class="text-sm text-[#6e675f] max-w-md mx-auto">Try adjusting your search terms or clearing category filters to view all 25+ industry solutions.</p>
          <a href="{{ route('industries.index') }}" class="inline-block px-5 py-2.5 rounded-xl bg-[#ff3b30] text-white text-xs font-bold uppercase tracking-wider">
            View All Industries
          </a>
        </div>
      @endif

    </div>
  </section>

  <!-- ======= 3. WHY PARTNER FOR VERTICAL SOLUTIONS ======= -->
  <section class="py-24 bg-[#faf7f2] border-b border-[#e6dfd3]">
    <div class="max-w-7xl mx-auto px-6 space-y-16">
      <div class="text-center max-w-3xl mx-auto space-y-4">
        <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">ENGINEERING RIGOR</span>
        <h2 class="text-3xl sm:text-5xl font-black text-[#161514] tracking-tight">
          Why Vertical Specialization Matters
        </h2>
        <p class="text-base text-[#6e675f]">
          Cookie-cutter websites fail under heavy regulatory compliance and industry-specific transactional loads. We architect platforms designed for your sector’s unique challenges.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] space-y-3 shadow-sm">
          <div class="w-10 h-10 rounded-xl bg-red-50 text-[#ff3b30] flex items-center justify-center text-lg">
            <i class="fas fa-shield-halved"></i>
          </div>
          <h4 class="font-extrabold text-[#161514] text-base">Regulatory Hardening</h4>
          <p class="text-xs text-[#6e675f] leading-relaxed">
            HIPAA-safe data pipelines, PCI-DSS payment gateways, SOC2-audited workflows, and strict GDPR privacy engineering.
          </p>
        </div>

        <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] space-y-3 shadow-sm">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
            <i class="fas fa-bolt"></i>
          </div>
          <h4 class="font-extrabold text-[#161514] text-base">Sub-400ms Edge Latency</h4>
          <p class="text-xs text-[#6e675f] leading-relaxed">
            Eliminate bounce rates during flash sales, registration surges, and high-concurrency booking engine spikes.
          </p>
        </div>

        <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] space-y-3 shadow-sm">
          <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
            <i class="fas fa-sitemap"></i>
          </div>
          <h4 class="font-extrabold text-[#161514] text-base">Entity Schema Graphing</h4>
          <p class="text-xs text-[#6e675f] leading-relaxed">
            Deep JSON-LD structured data signals industry-specific authority, Google rich snippets, and Knowledge Graph dominance.
          </p>
        </div>

        <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] space-y-3 shadow-sm">
          <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
            <i class="fas fa-code-commit"></i>
          </div>
          <h4 class="font-extrabold text-[#161514] text-base">100% Code Ownership</h4>
          <p class="text-xs text-[#6e675f] leading-relaxed">
            Full git commit handover, clean documentation, zero proprietary vendor hostage licensing, and full IP ownership.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= 4. CTA CONSULTATION BANNER ======= -->
  <section class="py-20 bg-[#161514] text-white">
    <div class="max-w-5xl mx-auto px-6 text-center space-y-6">
      <span class="text-xs font-extrabold tracking-widest text-[#cfa86e] uppercase">TAILORED ROADMAP</span>
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
        Don’t see your exact industry listed?
      </h2>
      <p class="text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
        Our senior solutions architects build bespoke platforms across every high-stakes commercial sector. Schedule a technical discovery session today.
      </p>
      <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
        <a href="#consultation" class="px-8 py-4 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs tracking-wider uppercase shadow-xl shadow-red-500/30 transition-all">
          Schedule Vertical Architecture Consultation →
        </a>
        <a href="{{ route('services.index') }}" class="px-8 py-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-extrabold text-xs tracking-wider uppercase border border-slate-700 transition-all">
          Explore Services Catalog
        </a>
      </div>
    </div>
  </section>

</div>
