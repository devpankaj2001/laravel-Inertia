
  <!-- ======= 1. HERO & SERP RANKING COMMAND CENTER ======= -->
  <section class="relative pt-32 pb-20 lg:pt-36 lg:pb-28 bg-[#faf7f2] border-b border-[#e6dfd3] overflow-hidden">
    <!-- Ambient Background Lighting -->
    <div class="absolute inset-0 pointer-events-none opacity-40">
      <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-b from-red-200/40 via-amber-100/30 to-transparent blur-3xl rounded-full"></div>
    </div>

    <div class="max-w-7xl xl:max-w-[1380px] 2xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

      <!-- Semantic Breadcrumbs -->
      <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex flex-wrap items-center gap-2 text-xs font-semibold text-[#6e675f]">
          <li>
            <a href="{{ route('home') }}" class="hover:text-[#ff3b30] transition-colors flex items-center gap-1.5">
              <i class="fas fa-house-chimney text-[11px]"></i> Home
            </a>
          </li>
          <li class="opacity-40">/</li>
          <li>
            <a href="{{ route('services.index') }}" class="hover:text-[#ff3b30] transition-colors">Services</a>
          </li>
          <li class="opacity-40">/</li>
          <li>
            <a href="{{ route('services.index', ['category' => $service->category]) }}" class="hover:text-[#ff3b30] transition-colors font-bold text-slate-700">
              {{ $service->category }}
            </a>
          </li>
          <li class="opacity-40">/</li>
          <li class="text-[#ff3b30] font-bold truncate max-w-[200px] sm:max-w-none" aria-current="page">
            {{ $service->title }}
          </li>
        </ol>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 xl:gap-12 items-center">
        <!-- Left Hero Copy -->
        <div class="lg:col-span-7 xl:col-span-7 space-y-6">
          <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold bg-[#161514] text-[#cfa86e] shadow-sm">
              <i class="{{ $service->icon }} text-[11px]"></i>
              <span>{{ $service->badge ?? $service->category }}</span>
            </span>

            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
              <span>Available for New Projects</span>
            </span>
          </div>

          <!-- Single H1 with Focus Keyword -->
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#161514] tracking-tight leading-[1.1]">
            {{ $service->title }}
          </h1>

          @if($service->tagline)
            <p class="text-lg sm:text-xl font-bold text-[#ff3b30] leading-snug">
              {{ $service->tagline }}
            </p>
          @endif

          <p class="text-base sm:text-lg text-[#6e675f] leading-relaxed max-w-3xl">
            {{ $service->short_description ?? "Architecting ultra-fast, server-rendered web portals engineered for high conversion rates and sub-second Core Web Vitals." }}
          </p>

          <!-- Hero CTAs -->
          <div class="flex flex-wrap items-center gap-4 pt-2">
            <a href="#inquiryForm"
               class="px-7 py-3.5 rounded-xl bg-[#161514] hover:bg-black text-white font-extrabold text-sm shadow-xl shadow-black/10 hover:shadow-2xl transition-all flex items-center gap-2.5">
              <span>Claim Free 48h Growth Audit</span>
              <i class="fas fa-arrow-right text-xs text-[#cfa86e]"></i>
            </a>

            <a href="#deliverables"
               class="px-6 py-3.5 rounded-xl bg-white hover:bg-slate-50 text-[#161514] font-bold text-sm border border-[#e6dfd3] shadow-sm transition-colors flex items-center gap-2">
              <span>View Scope &amp; Deliverables</span>
              <i class="fas fa-chevron-down text-xs opacity-60"></i>
            </a>
          </div>

          <!-- Social Proof Bar -->
          <div class="pt-6 border-t border-[#e6dfd3]/80 flex flex-wrap items-center gap-6 text-xs text-[#6e675f] font-semibold">
            <div class="flex items-center gap-2">
              <div class="flex text-amber-500 text-xs">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
              <span class="font-extrabold text-[#161514]">4.9 / 5.0</span>
              <span>(140+ Client Audits)</span>
            </div>
            <div class="flex items-center gap-1.5">
              <i class="fas fa-bolt text-emerald-500"></i>
              <span>Sub-second Core Web Vitals</span>
            </div>
            <div class="flex items-center gap-1.5">
              <i class="fas fa-shield-check text-blue-500"></i>
              <span>SOC2 &amp; SEO Compliant</span>
            </div>
          </div>
        </div>

        <!-- Right Hero Interactive Matrix Card -->
        <div class="lg:col-span-5 xl:col-span-5">
          <div class="p-7 rounded-3xl bg-white border border-[#e6dfd3] shadow-2xl shadow-slate-200/60 relative overflow-hidden space-y-6">
            <!-- Card Eyebrow -->
            <div class="flex items-center justify-between pb-4 border-b border-[#e6dfd3]">
              <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#161514] text-white flex items-center justify-center text-sm shadow-md">
                  <i class="{{ $service->icon }}"></i>
                </div>
                <div>
                  <p class="text-xs font-bold text-[#161514] uppercase tracking-wider">Verified KPI Impact</p>
                  <p class="text-[11px] font-mono text-[#6e675f]">Production Grade Metrics</p>
                </div>
              </div>
              <span class="px-2.5 py-1 rounded-full text-xs font-black font-mono bg-emerald-50 text-emerald-700 border border-emerald-200">
                LIVE #1
              </span>
            </div>

            @if(!empty($service->og_image))
              <div class="rounded-2xl overflow-hidden border border-[#e6dfd3] shadow-md aspect-[16/10] bg-slate-950 relative group">
                <img src="{{ asset($service->og_image) }}" alt="{{ $service->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none"></div>
                <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between pointer-events-none">
                  <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#161514]/90 text-[#cfa86e] border border-white/10 backdrop-blur-md">
                    ARCHITECTURAL BLUEPRINT
                  </span>
                  <span class="text-white/80 text-xs">
                    <i class="fas fa-microchip"></i>
                  </span>
                </div>
              </div>
            @endif

            <!-- Prominent Metric Box -->
            <div class="p-5 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] flex items-center justify-between">
              <div>
                <p class="text-xs font-bold text-[#6e675f] uppercase tracking-wider">
                  {{ $service->kpi_label ?? 'Performance SLA' }}
                </p>
                <p class="text-3xl sm:text-4xl font-black text-[#161514] tracking-tight mt-1">
                  {{ $service->kpi_value ?? '0.42s' }}
                </p>
              </div>
              <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fas fa-chart-line"></i>
              </div>
            </div>

            <!-- Quick Service Specs -->
            <div class="space-y-3 text-xs">
              <div class="flex items-center justify-between py-2 border-b border-[#f2ece1]">
                <span class="font-bold text-[#6e675f]">Service Category</span>
                <span class="font-black text-[#161514]">{{ $service->category }}</span>
              </div>
              <div class="flex items-center justify-between py-2 border-b border-[#f2ece1]">
                <span class="font-bold text-[#6e675f]">Delivery Framework</span>
                <span class="font-black text-[#161514]">Agile 2-Week Sprints</span>
              </div>
              <div class="flex items-center justify-between py-2 border-b border-[#f2ece1]">
                <span class="font-bold text-[#6e675f]">Technical SEO Guarantee</span>
                <span class="font-black text-emerald-600">100% Core Web Vitals Pass</span>
              </div>
              <div class="flex items-center justify-between py-2">
                <span class="font-bold text-[#6e675f]">Global Provider</span>
                <span class="font-mono text-slate-700">WebRanker Technologies HQ</span>
              </div>
            </div>

            <a href="#inquiryForm"
               class="w-full py-3 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs tracking-wider uppercase text-center block shadow-lg shadow-red-500/20 transition-all">
              Schedule Architecture Consultation →
            </a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ======= 2. DETAILED ARCHITECTURE & STRATEGY SECTION ======= -->
  <section class="py-20 bg-white border-b border-[#e6dfd3]">
    <div class="max-w-7xl xl:max-w-[1380px] 2xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        <!-- Left Sticky Sidebar (Prevents empty space when content is long) -->
        <div class="lg:col-span-4 xl:col-span-4">
          <div class="lg:sticky lg:top-28 space-y-6">
            <div class="space-y-4">
              <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">ENGINEERED FOR SCALE</span>
              <h2 class="text-3xl sm:text-4xl font-black text-[#161514] tracking-tight leading-tight">
                Why Ambition Demands Next-Generation {{ $service->title }}
              </h2>
              <p class="text-sm sm:text-base text-[#6e675f] leading-relaxed">
                Legacy agencies build static templates that choke under load and flounder in organic SERPs. WebRanker takes an engineering-first stance: every line of code, component architecture, and server response is audited for maximum conversion speed and search engine crawlability.
              </p>
            </div>

            <!-- Engineering Standards & Guarantees -->
            <div class="p-5 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-3.5">
              <div class="flex items-center justify-between">
                <h4 class="text-xs font-black uppercase tracking-wider text-[#161514]">Core Engineering Standards</h4>
                <span class="w-2 h-2 rounded-full bg-[#ff3b30]"></span>
              </div>
              <ul class="space-y-2.5 text-xs text-[#4b5563]">
                <li class="flex items-start gap-2.5">
                  <i class="fas fa-bolt text-[#ff3b30] mt-0.5 text-xs flex-shrink-0"></i>
                  <span><strong class="text-[#161514]">Sub-400ms TTFB:</strong> Edge-first render and sub-second asset delivery pipelines.</span>
                </li>
                <li class="flex items-start gap-2.5">
                  <i class="fas fa-shield-halved text-[#ff3b30] mt-0.5 text-xs flex-shrink-0"></i>
                  <span><strong class="text-[#161514]">100% Code Ownership:</strong> Clean, modular repos with zero vendor lock-in.</span>
                </li>
                <li class="flex items-start gap-2.5">
                  <i class="fas fa-chart-line text-[#ff3b30] mt-0.5 text-xs flex-shrink-0"></i>
                  <span><strong class="text-[#161514]">Search-First Schema:</strong> Deep JSON-LD entity graph indexing.</span>
                </li>
              </ul>
            </div>

            <!-- Sticky Lead Consultation Widget -->
            <div class="p-5 rounded-2xl bg-[#161514] text-white space-y-3.5 shadow-xl shadow-black/10">
              <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold tracking-wider uppercase text-[#cfa86e]">Architecture Review</span>
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Free Discovery
                </span>
              </div>
              <div>
                <h4 class="text-sm font-black text-white">Planning your {{ $service->title }}?</h4>
                <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                  Get a dedicated technical roadmap and architecture consultation from our lead engineers.
                </p>
              </div>
              <a href="#inquiryForm"
                 class="w-full py-2.5 px-4 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs tracking-wider uppercase text-center block shadow-lg shadow-red-500/20 transition-all">
                Schedule Consultation →
              </a>
              <div class="flex items-center justify-center gap-2 pt-1 text-[11px] text-slate-400">
                <div class="flex text-amber-400 text-[10px]">
                  <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <span>4.9/5 by 150+ tech leaders</span>
              </div>
            </div>
          </div>
        </div>

        <div class="lg:col-span-8 xl:col-span-8 space-y-6">
          <div class="prose prose-slate max-w-none text-[#374151] leading-relaxed text-base space-y-4">
            @if(!empty($service->detailed_content))
              {!! $service->detailed_content !!}
            @else
              <p>
                In today's algorithmic landscape, user experience and search ranking algorithms are deeply intertwined. Slow render times, layout shifts (CLS), and poor semantic hierarchy degrade both customer trust and organic rank.
              </p>
              <p>
                Our <strong>{{ $service->title }}</strong> solves this by combining modern edge architectures, automated Schema.org structured data, and sub-second asset delivery pipelines. Whether you need enterprise micro-frontends, high-throughput APIs, or topical authority dominance, our engineering team builds for measurable commercial revenue.
              </p>
            @endif
          </div>

          <!-- Key Highlights Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
            <div class="p-4 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-2">
              <div class="w-8 h-8 rounded-lg bg-[#161514] text-white flex items-center justify-center text-xs">
                <i class="fas fa-gauge-high"></i>
              </div>
              <h4 class="font-extrabold text-[#161514] text-sm">Sub-500ms Edge Latency</h4>
              <p class="text-xs text-[#6e675f]">Zero-CLS layout engineering with global CDN edge caching.</p>
            </div>

            <div class="p-4 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-2">
              <div class="w-8 h-8 rounded-lg bg-[#ff3b30] text-white flex items-center justify-center text-xs">
                <i class="fas fa-sitemap"></i>
              </div>
              <h4 class="font-extrabold text-[#161514] text-sm">Entity Schema Graphing</h4>
              <p class="text-xs text-[#6e675f]">JSON-LD microdata structured specifically for Google rich snippets.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= 3. SCOPE OF DELIVERABLES & FEATURES ======= -->
  <section id="deliverables" class="py-24 bg-[#faf7f2] border-b border-[#e6dfd3]">
    <div class="max-w-7xl xl:max-w-[1380px] 2xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
        <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">COMPREHENSIVE SCOPE</span>
        <h2 class="text-3xl sm:text-5xl font-black text-[#161514] tracking-tight">
          What’s Included in Our {{ $service->title }}
        </h2>
        <p class="text-base text-[#6e675f]">
          Transparent, battle-tested deliverables crafted to eliminate technical debt and maximize ROI.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
          $featuresList = !empty($service->features) && is_array($service->features) ? $service->features : [
            'Next.js App Router & SSR Architecture',
            'Edge Function Caching & CDN Optimization',
            'Zero-CLS Layout Engine & Core Web Vitals',
            'Micro-frontends & High-Concurrency APIs',
            'Deep Technical SEO & Entity Graph Schema',
            'Automated CI/CD Deployment & Testing',
          ];
        @endphp

        @foreach($featuresList as $fIdx => $feature)
          <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-xl hover:border-slate-400 transition-all space-y-4 group">
            <div class="flex items-center justify-between">
              <div class="w-10 h-10 rounded-xl bg-[#faf7f2] group-hover:bg-[#ff3b30] group-hover:text-white text-[#ff3b30] flex items-center justify-center text-sm transition-colors shadow-inner">
                <i class="fas fa-check"></i>
              </div>
              <span class="font-mono text-xs font-bold text-[#9c958c]">
                {{ str_pad($fIdx + 1, 2, '0', STR_PAD_LEFT) }}
              </span>
            </div>

            <h3 class="text-lg font-black text-[#161514] tracking-tight">
              {{ $feature }}
            </h3>

            <p class="text-xs text-[#6e675f] leading-relaxed">
              Enterprise-grade execution meeting stringent quality criteria, load tested under peak traffic conditions.
            </p>

            <div class="pt-2 flex items-center gap-2 text-[11px] font-bold text-emerald-600">
              <i class="fas fa-circle-check"></i>
              <span>Included in Standard Scope</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ======= 4. PROVEN 4-STEP DELIVERY ROADMAP ======= -->
  <section class="py-24 bg-white border-b border-[#e6dfd3]">
    <div class="max-w-7xl xl:max-w-[1380px] 2xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
        <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">AGILE METHODOLOGY</span>
        <h2 class="text-3xl sm:text-5xl font-black text-[#161514] tracking-tight">
          How We Deliver {{ $service->title }}
        </h2>
        <p class="text-base text-[#6e675f]">
          From initial discovery to zero-downtime production deployment, our transparent execution plan keeps you ahead of schedule.
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
        <!-- Step 1 -->
        <div class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-4 relative">
          <span class="w-10 h-10 rounded-xl bg-[#161514] text-white flex items-center justify-center font-black text-sm font-mono">01</span>
          <h3 class="text-lg font-black text-[#161514]">Discovery &amp; Tech Audit</h3>
          <p class="text-xs text-[#6e675f] leading-relaxed">
            Deep analysis of existing infrastructure, competitor gaps, keyword intent, and bottleneck identification.
          </p>
        </div>

        <!-- Step 2 -->
        <div class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-4 relative">
          <span class="w-10 h-10 rounded-xl bg-[#161514] text-white flex items-center justify-center font-black text-sm font-mono">02</span>
          <h3 class="text-lg font-black text-[#161514]">Architecture &amp; Design</h3>
          <p class="text-xs text-[#6e675f] leading-relaxed">
            Component wireframes, schema design, API contract specifications, and Core Web Vitals target mapping.
          </p>
        </div>

        <!-- Step 3 -->
        <div class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-4 relative">
          <span class="w-10 h-10 rounded-xl bg-[#ff3b30] text-white flex items-center justify-center font-black text-sm font-mono">03</span>
          <h3 class="text-lg font-black text-[#161514]">Sprint Execution &amp; QA</h3>
          <p class="text-xs text-[#6e675f] leading-relaxed">
            High-velocity development cycles, automated testing, browser matrix verification, and crawl testing.
          </p>
        </div>

        <!-- Step 4 -->
        <div class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-4 relative">
          <span class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-sm font-mono">04</span>
          <h3 class="text-lg font-black text-[#161514]">Launch &amp; Rank Optimization</h3>
          <p class="text-xs text-[#6e675f] leading-relaxed">
            Zero-downtime deployment, Search Console indexation acceleration, live SERP tracking, and ongoing SLA retainers.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= 5. SERVICE FAQS WITH FAQPAGE SCHEMA ======= -->
  <section class="py-24 bg-[#faf7f2] border-b border-[#e6dfd3]">
    <div class="max-w-4xl xl:max-w-5xl 2xl:max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
      <div class="text-center space-y-3">
        <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">ANSWERS &amp; DETAILS</span>
        <h2 class="text-3xl sm:text-5xl font-black text-[#161514] tracking-tight">
          Frequently Asked Questions
        </h2>
        <p class="text-base text-[#6e675f]">
          Everything you need to know about our {{ $service->title }} engagements.
        </p>
      </div>

      <!-- FAQ Accordion List -->
      <div class="space-y-4">
        @foreach($faqsList as $faqIdx => $faq)
          <details class="group bg-white rounded-2xl border border-[#e6dfd3] p-6 shadow-sm [&_summary::-webkit-details-marker]:hidden" {{ $loop->first ? 'open' : '' }}>
            <summary class="flex items-center justify-between cursor-pointer font-black text-base sm:text-lg text-[#161514] gap-4 select-none">
              <span>{{ $faq['question'] }}</span>
              <span class="w-8 h-8 rounded-full bg-[#faf7f2] flex items-center justify-center text-xs shrink-0 group-open:rotate-180 transition-transform text-[#ff3b30]">
                <i class="fas fa-chevron-down"></i>
              </span>
            </summary>
            <div class="mt-4 pt-4 border-t border-[#f2ece1] text-sm text-[#6e675f] leading-relaxed">
              {!! nl2br(e($faq['answer'])) !!}
            </div>
          </details>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ======= 6. LEAD GENERATION & PROPOSAL INQUIRY FORM ======= -->
  <section id="inquiryForm" class="py-24 bg-white border-b border-[#e6dfd3] relative overflow-hidden">
    <div class="max-w-5xl xl:max-w-6xl 2xl:max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="bg-[#161514] text-white rounded-3xl p-8 sm:p-12 lg:p-16 shadow-2xl space-y-8 relative overflow-hidden">
        <!-- Accent Glow -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/20 blur-3xl rounded-full pointer-events-none"></div>

        <div class="max-w-2xl space-y-3">
          <span class="text-xs font-mono font-bold tracking-wider text-[#cfa86e] uppercase">CLAIM YOUR ROADMAP</span>
          <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
            Ready to Dominate with {{ $service->title }}?
          </h2>
          <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
            Fill out the form below for a free technical architecture review, competitor audit, and guaranteed growth proposal delivered within 48 hours.
          </p>
        </div>

        @if(session('success'))
          <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-sm font-bold flex items-center gap-3">
            <i class="fas fa-check-circle text-lg"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif

        <form method="POST" action="{{ route('inquiry.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-4">
          @csrf
          <input type="hidden" name="service_slug" value="{{ $service->slug }}">

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Your Full Name <span class="text-[#ff3b30]">*</span></label>
            <input type="text" name="name" required placeholder="Alexander Wright"
                   class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm">
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Work Email <span class="text-[#ff3b30]">*</span></label>
            <input type="email" name="email" required placeholder="alex@enterprise.com"
                   class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm">
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Phone / WhatsApp</label>
            <input type="text" name="phone" placeholder="+1 (555) 000-0000"
                   class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm">
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Selected Service</label>
            <input type="text" name="service" readonly value="{{ $service->title }}"
                   class="w-full px-4 py-3 rounded-xl bg-slate-800/80 border border-slate-700 text-slate-300 font-bold text-sm cursor-not-allowed">
          </div>

          <div class="sm:col-span-2 space-y-1.5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Project Requirements &amp; Goals</label>
            <textarea name="message" rows="4" placeholder="Tell us about your current site, tech challenges, and revenue targets..."
                      class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm leading-relaxed"></textarea>
          </div>

          <div class="sm:col-span-2 flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
            <p class="text-[11px] text-slate-500">
              🔒 100% Confidential. Zero-spam guarantee. NDA signed upon request.
            </p>
            <button type="submit"
                    class="px-8 py-3.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-sm tracking-wide shadow-lg shadow-red-500/30 transition-all flex items-center justify-center gap-2">
              <span>Submit Free Audit Request</span>
              <i class="fas fa-paper-plane text-xs"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- ======= 7. RELATED SERVICES IN THIS CATEGORY ======= -->
  @if($relatedServices->count() > 0)
    <section class="py-20 bg-[#faf7f2]">
      <div class="max-w-7xl xl:max-w-[1380px] 2xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
          <div>
            <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">EXPLORE COMPLEMENTARY CAPABILITIES</span>
            <h3 class="text-2xl sm:text-3xl font-black text-[#161514] tracking-tight mt-1">
              More in {{ $service->category }}
            </h3>
          </div>
          <a href="{{ route('services.index') }}" class="text-xs font-extrabold text-[#ff3b30] hover:underline flex items-center gap-1.5">
            <span>View All Services Catalog</span> <i class="fas fa-arrow-right text-[10px]"></i>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach($relatedServices as $relSvc)
            <a href="{{ route('services.show', $relSvc->slug) }}"
               class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-xl hover:border-slate-400 transition-all flex flex-col justify-between group">
              <div class="space-y-3">
                <div class="w-10 h-10 rounded-xl bg-[#faf7f2] group-hover:bg-[#ff3b30] group-hover:text-white text-[#ff3b30] flex items-center justify-center text-base transition-colors shadow-inner">
                  <i class="{{ $relSvc->icon }}"></i>
                </div>
                <h4 class="text-lg font-black text-[#161514] group-hover:text-[#ff3b30] transition-colors">
                  {{ $relSvc->title }}
                </h4>
                <p class="text-xs text-[#6e675f] line-clamp-2 leading-relaxed">
                  {{ $relSvc->tagline ?? $relSvc->short_description }}
                </p>
              </div>

              <div class="pt-4 mt-4 border-t border-[#f2ece1] flex items-center justify-between text-xs font-bold text-[#161514]">
                <span>Explore Service Details</span>
                <i class="fas fa-arrow-right text-xs text-[#ff3b30] group-hover:translate-x-1 transition-transform"></i>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- ======= 7.5 STRATEGIC INSIGHTS & RELATED ARTICLES ======= -->
  @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
    <section class="py-20 bg-white border-t border-[#e6dfd3]">
      <div class="max-w-7xl xl:max-w-[1380px] 2xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
          <div>
            <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">AUTHORITY RESEARCH &amp; GUIDES</span>
            <h3 class="text-2xl sm:text-3xl font-black text-[#161514] tracking-tight mt-1">
              Case Studies &amp; Architectural Insights
            </h3>
            <p class="text-xs text-[#6e675f] mt-1">Explore in-depth technical blueprints and implementation strategies.</p>
          </div>
          <a href="{{ route('blogs.index') }}" class="text-xs font-extrabold text-[#ff3b30] hover:underline flex items-center gap-1.5">
            <span>Read All Articles</span> <i class="fas fa-arrow-right text-[10px]"></i>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach($relatedBlogs as $bPost)
            <article class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] shadow-sm hover:shadow-xl hover:border-[#ff3b30]/30 transition-all flex flex-col justify-between group">
              <div class="space-y-3">
                <div class="flex items-center justify-between text-xs">
                  <span class="px-2.5 py-0.5 rounded-full bg-white text-[#ff3b30] font-bold text-[10px] border border-[#e6dfd3]">
                    {{ $bPost->category }}
                  </span>
                  <span class="text-[11px] font-mono text-[#8c827a]">{{ $bPost->read_time ?? '5 min' }}</span>
                </div>
                <h4 class="text-base font-extrabold text-[#161514] group-hover:text-[#ff3b30] transition-colors line-clamp-2">
                  <a href="{{ route('blogs.show', $bPost->slug) }}">{{ $bPost->title }}</a>
                </h4>
                <p class="text-xs text-[#6e675f] line-clamp-2 leading-relaxed">
                  {{ $bPost->excerpt ?? Str::limit(strip_tags($bPost->content), 120) }}
                </p>
              </div>

              <div class="pt-4 mt-4 border-t border-[#e6dfd3] flex items-center justify-between text-xs">
                <span class="font-extrabold text-[#161514]">{{ $bPost->author_name ?? 'WebRanker' }}</span>
                <a href="{{ route('blogs.show', $bPost->slug) }}" class="text-xs font-black text-[#ff3b30] group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                  <span>Read Guide</span> →
                </a>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- ======= 8. CO-MARKETING / STRATEGIC LINK PLACEMENT BANNER ======= -->
  <section class="py-12 bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border-t border-amber-500/20">
    <div class="max-w-7xl xl:max-w-[1380px] 2xl:max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
      <div class="space-y-1">
        <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-amber-500 text-slate-950">
          PARTNER NETWORK
        </span>
        <h3 class="text-xl font-black text-[#161514]">Looking for Co-Marketing, Tool Integrations or Link Features?</h3>
        <p class="text-xs text-[#6e675f]">Connect your enterprise software, SaaS, or agency services with our high-ranking search traffic.</p>
      </div>
      <button type="button" onclick="openLinkRequestModal('{{ url()->current() }}', '{{ addslashes($service->title) }}')"
              class="px-6 py-3 rounded-xl bg-slate-950 hover:bg-[#ff3b30] text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-md shrink-0 cursor-pointer">
        <i class="fas fa-handshake mr-1.5 text-amber-400"></i> Request Partnership or Link Feature
      </button>
    </div>
  </section>

  <!-- ======= 9. CLIENT LINK PLACEMENT / BRAND FEATURE MODAL ======= -->
  <div id="linkRequestModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-[#e6dfd3] space-y-5 relative max-h-[90vh] overflow-y-auto">
      
      <!-- Close Button -->
      <button type="button" onclick="closeLinkRequestModal()" class="absolute right-5 top-5 text-slate-400 hover:text-slate-800 text-lg">
        <i class="fas fa-times"></i>
      </button>

      <div class="space-y-1">
        <span class="px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-700 font-extrabold text-[10px] uppercase tracking-wider border border-amber-500/20">
          EDITORIAL COLLABORATION
        </span>
        <h3 class="text-xl sm:text-2xl font-black text-[#161514]">Request Link Insertion or Brand Feature</h3>
        <p class="text-xs text-[#6e675f] leading-relaxed">
          Feature your SaaS, engineering tool, or digital solution in this high-ranking service page. We review every request for quality and contextual relevance.
        </p>
      </div>

      <!-- AJAX Form -->
      <form id="linkRequestForm" onsubmit="submitLinkRequest(event)" class="space-y-4">
        @csrf
        <input type="hidden" name="target_page_url" id="modalTargetUrl" value="{{ url()->current() }}">
        <input type="hidden" name="target_page_title" id="modalTargetTitle" value="{{ $service->title }}">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Your Full Name <span class="text-red-500">*</span></label>
            <input type="text" name="client_name" required placeholder="e.g. Sarah Jenkins"
                   class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Work Email <span class="text-red-500">*</span></label>
            <input type="email" name="client_email" required placeholder="sarah@yourcompany.com"
                   class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Company / Brand</label>
            <input type="text" name="client_company" placeholder="e.g. ScaleAI Corp"
                   class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Your Website URL</label>
            <input type="url" name="client_website" placeholder="https://yourbrand.com"
                   class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Collaboration Type <span class="text-red-500">*</span></label>
            <select name="link_type" required class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30] bg-white">
              <option value="link_insertion">Contextual Link Insertion</option>
              <option value="sponsored_feature">Sponsored Editorial Feature / Review</option>
              <option value="guest_post">Expert Guest Post Contribution</option>
              <option value="service_partnership">Enterprise Co-Marketing Partnership</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Budget / Offer (USD)</label>
            <select name="budget_offer" class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30] bg-white">
              <option value="$150 - $300">$150 - $300</option>
              <option value="$300 - $600">$300 - $600</option>
              <option value="$600 - $1,200">$600 - $1,200</option>
              <option value="$1,200+">$1,200+ (Enterprise)</option>
              <option value="Negotiable">Negotiable</option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Requested Anchor Text</label>
            <input type="text" name="requested_anchor_text" placeholder="e.g. Modern CMS architecture"
                   class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Destination Target Link URL</label>
            <input type="url" name="target_link_url" placeholder="https://yourbrand.com"
                   class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-[#161514] mb-1">Proposed Context / Notes</label>
          <textarea name="proposed_context" rows="2" placeholder="Tell us which section you'd like your link added to, or describe your tool..."
                    class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]"></textarea>
        </div>

        <div id="linkRequestAlert" class="hidden p-3 rounded-xl text-xs font-bold"></div>

        <div class="flex items-center justify-end gap-3 pt-2">
          <button type="button" onclick="closeLinkRequestModal()" class="px-4 py-2 rounded-xl border border-[#e6dfd3] text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
            Cancel
          </button>
          <button type="submit" id="linkSubmitBtn" class="px-6 py-2 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs shadow-md shadow-red-500/20 transition-all">
            Submit Placement Request
          </button>
        </div>
      </form>

    </div>
  </div>

  <script>
    function openLinkRequestModal(url, title) {
      const modal = document.getElementById('linkRequestModal');
      if (!modal) return;
      if (url) document.getElementById('modalTargetUrl').value = url;
      if (title) document.getElementById('modalTargetTitle').value = title;
      modal.classList.remove('hidden');
    }

    function closeLinkRequestModal() {
      const modal = document.getElementById('linkRequestModal');
      if (modal) modal.classList.add('hidden');
    }

    async function submitLinkRequest(e) {
      e.preventDefault();
      const form = document.getElementById('linkRequestForm');
      const alertBox = document.getElementById('linkRequestAlert');
      const submitBtn = document.getElementById('linkSubmitBtn');

      submitBtn.disabled = true;
      submitBtn.textContent = 'Submitting...';
      alertBox.className = 'hidden';

      const formData = new FormData(form);

      try {
        const res = await fetch("{{ route('link_request.store') }}", {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
          body: formData
        });

        const data = await res.json();
        if (res.ok && data.success) {
          alertBox.className = 'p-3 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold block';
          alertBox.innerHTML = '<i class="fas fa-check-circle mr-1"></i> ' + data.message;
          form.reset();
          setTimeout(() => {
            closeLinkRequestModal();
            alertBox.className = 'hidden';
          }, 3500);
        } else {
          alertBox.className = 'p-3 rounded-xl bg-red-50 text-red-600 border border-red-200 text-xs font-bold block';
          alertBox.innerHTML = '<i class="fas fa-triangle-exclamation mr-1"></i> ' + (data.message || 'Please check your inputs.');
        }
      } catch (err) {
        alertBox.className = 'p-3 rounded-xl bg-red-50 text-red-600 border border-red-200 text-xs font-bold block';
        alertBox.innerHTML = '<i class="fas fa-triangle-exclamation mr-1"></i> An error occurred. Please try again.';
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit Placement Request';
      }
    }
  </script>

