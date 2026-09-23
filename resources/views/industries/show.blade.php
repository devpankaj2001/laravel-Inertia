@extends('layouts.app')

@section('content')
<div class="industry-single-page bg-[#faf7f2] min-h-screen">

  <!-- ======= 1. HERO COMMAND CENTER ======= -->
  <section class="relative pt-32 pb-20 lg:pt-36 lg:pb-28 bg-[#faf7f2] border-b border-[#e6dfd3] overflow-hidden">
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
          <li>
            <a href="{{ route('industries.index') }}" class="hover:text-[#ff3b30] transition-colors">Industries</a>
          </li>
          @if(!empty($industry->category_group))
            <li class="opacity-40">/</li>
            <li>
              <a href="{{ route('industries.index', ['group' => $industry->category_group]) }}" class="hover:text-[#ff3b30] transition-colors font-bold text-slate-700">
                {{ $industry->category_group }}
              </a>
            </li>
          @endif
          <li class="opacity-40">/</li>
          <li class="text-[#ff3b30] font-bold truncate max-w-[200px] sm:max-w-none" aria-current="page">
            {{ $industry->name }}
          </li>
        </ol>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Left Hero Copy -->
        <div class="lg:col-span-7 space-y-6">
          <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold bg-[#161514] text-[#cfa86e] shadow-sm">
              <span class="w-1.5 h-1.5 rounded-full bg-[#ff3b30] animate-pulse"></span>
              <span>{{ strtoupper($industry->category_group ?? 'ENTERPRISE DOMAIN') }}</span>
            </span>
            @if(!empty($industry->highlight_stat))
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-700 border border-emerald-500/20">
                <i class="fas fa-arrow-trend-up text-[10px]"></i>
                <span>{{ $industry->highlight_stat }} {{ $industry->stat_label ?? 'Performance Impact' }}</span>
              </span>
            @endif
          </div>

          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#161514] tracking-tight leading-[1.1]">
            Next-Generation Digital Systems for <span class="text-[#ff3b30]">{{ $industry->name }}</span>
          </h1>

          <p class="text-base sm:text-lg text-[#6e675f] leading-relaxed">
            {{ $industry->hero_tagline ?? $industry->description ?? 'We architect mission-critical web applications, high-concurrency transactional portals, and automated SEO pipelines engineered specifically for ' . $industry->name . '.' }}
          </p>

          <!-- Core Capability Badges -->
          @if(!empty($industry->tags) && is_array($industry->tags))
            <div class="flex flex-wrap gap-2 pt-2">
              @foreach($industry->tags as $tag)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white border border-[#e6dfd3] text-xs font-bold text-slate-700 shadow-sm">
                  <i class="fas fa-check text-emerald-500 text-[10px]"></i> {{ $tag }}
                </span>
              @endforeach
            </div>
          @endif

          <!-- CTA Buttons -->
          <div class="pt-4 flex flex-wrap items-center gap-4">
            <a href="#inquiryForm"
               class="px-8 py-4 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs tracking-wider uppercase shadow-xl shadow-red-500/30 transition-all flex items-center gap-2">
              <span>Schedule Architecture Audit</span>
              <i class="fas fa-arrow-right text-[11px]"></i>
            </a>
            <a href="#strategy"
               class="px-6 py-4 rounded-xl bg-white hover:bg-slate-50 text-[#161514] font-extrabold text-xs tracking-wider uppercase border border-[#e6dfd3] shadow-sm transition-all">
              Technical Blueprint ↓
            </a>
          </div>
        </div>

        <!-- Right Visual Card -->
        <div class="lg:col-span-5">
          <div class="p-8 rounded-3xl bg-white border border-[#e6dfd3] shadow-2xl space-y-6 relative overflow-hidden">
            <div class="flex items-center justify-between pb-4 border-b border-[#f0eae1]">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[#ff3b30] text-white flex items-center justify-center text-xl shadow-lg shadow-red-500/20">
                  <i class="{{ $industry->icon_class }}"></i>
                </div>
                <div>
                  <h4 class="font-black text-[#161514] text-base">{{ $industry->name }}</h4>
                  <span class="text-xs text-[#6e675f] font-mono">Architecture Blueprint</span>
                </div>
              </div>
              <span class="w-3 h-3 rounded-full bg-emerald-400 animate-ping"></span>
            </div>

            <div class="space-y-3 text-xs">
              <div class="flex items-center justify-between py-2 border-b border-[#f0eae1]">
                <span class="text-[#6e675f] font-bold">Standard Metric Impact</span>
                <span class="font-black text-emerald-600 font-mono">{{ $industry->highlight_stat ?? '+310% Growth' }}</span>
              </div>
              <div class="flex items-center justify-between py-2 border-b border-[#f0eae1]">
                <span class="text-[#6e675f] font-bold">Target Core Web Vitals</span>
                <span class="font-bold text-[#161514] font-mono">100/100 Mobile Pass</span>
              </div>
              <div class="flex items-center justify-between py-2 border-b border-[#f0eae1]">
                <span class="text-[#6e675f] font-bold">Security &amp; Hardening</span>
                <span class="font-bold text-slate-800">OWASP Top 10 + Zero-Trust</span>
              </div>
              <div class="flex items-center justify-between py-2">
                <span class="text-[#6e675f] font-bold">Code Handover</span>
                <span class="font-bold text-[#ff3b30]">100% Client Ownership</span>
              </div>
            </div>

            <a href="#inquiryForm"
               class="w-full py-3.5 rounded-xl bg-[#161514] hover:bg-black text-white font-extrabold text-xs tracking-wider uppercase text-center block shadow-lg transition-all">
              Request Technical Proposal →
            </a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ======= 2. DETAILED ARCHITECTURE & STRATEGY SECTION (WITH STICKY SIDEBAR) ======= -->
  <section id="strategy" class="py-20 bg-white border-b border-[#e6dfd3]">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

        <!-- Sticky Left Sidebar (Prevents empty space when content is long) -->
        <div class="lg:col-span-4 xl:col-span-4">
          <div class="lg:sticky lg:top-28 space-y-6">

            <!-- Header Block -->
            <div class="space-y-4">
              <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">VERTICAL RIGOR</span>
              <h2 class="text-3xl sm:text-4xl font-black text-[#161514] tracking-tight leading-tight">
                Architectural Standards for {{ $industry->name }}
              </h2>
              <p class="text-sm sm:text-base text-[#6e675f] leading-relaxed">
                {{ $industry->description ?? 'We eliminate legacy software vulnerabilities and conversion bottlenecks by deploying modern edge microservices and topical authority search pipelines.' }}
              </p>
            </div>

            <!-- Core Engineering Standards Box -->
            <div class="p-5 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-3.5">
              <div class="flex items-center justify-between">
                <h4 class="text-xs font-black uppercase tracking-wider text-[#161514]">Deployment Guarantees</h4>
                <span class="w-2 h-2 rounded-full bg-[#ff3b30]"></span>
              </div>
              <ul class="space-y-2.5 text-xs text-[#4b5563]">
                <li class="flex items-start gap-2.5">
                  <i class="fas fa-bolt text-[#ff3b30] mt-0.5 text-xs flex-shrink-0"></i>
                  <span><strong class="text-[#161514]">Sub-400ms TTFB:</strong> Edge-rendered dynamic routes with zero layout shifts.</span>
                </li>
                <li class="flex items-start gap-2.5">
                  <i class="fas fa-shield-halved text-[#ff3b30] mt-0.5 text-xs flex-shrink-0"></i>
                  <span><strong class="text-[#161514]">Zero Vendor Lock-In:</strong> Fully audited commits delivered straight to your private repo.</span>
                </li>
                <li class="flex items-start gap-2.5">
                  <i class="fas fa-sitemap text-[#ff3b30] mt-0.5 text-xs flex-shrink-0"></i>
                  <span><strong class="text-[#161514]">Schema Graphing:</strong> Sector-specific JSON-LD entities for first-page Google domination.</span>
                </li>
              </ul>
            </div>

            <!-- Sticky Consultation Box -->
            <div class="p-5 rounded-2xl bg-[#161514] text-white space-y-3.5 shadow-xl shadow-black/10">
              <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold tracking-wider uppercase text-[#cfa86e]">Direct Architect Review</span>
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Free Discovery
                </span>
              </div>
              <div>
                <h4 class="text-sm font-black text-white">Scaling {{ $industry->name }} Systems?</h4>
                <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                  Get a dedicated technical roadmap and compliance audit from our lead solutions architects.
                </p>
              </div>
              <a href="#inquiryForm"
                 class="w-full py-2.5 px-4 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs tracking-wider uppercase text-center block shadow-lg shadow-red-500/20 transition-all">
                Schedule Architecture Consultation →
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

        <!-- Right Detailed Content Column -->
        <div class="lg:col-span-8 xl:col-span-8 space-y-8">
          
          <!-- Detailed HTML / WYSIWYG Content -->
          <div class="prose prose-slate max-w-none text-[#374151] leading-relaxed text-base space-y-4">
            @if(!empty($industry->detailed_content))
              {!! $industry->detailed_content !!}
            @else
              <div class="p-6 sm:p-8 rounded-3xl bg-[#faf7f2] border border-[#e6dfd3] space-y-4">
                <h3 class="text-2xl font-black text-[#161514] tracking-tight">The Reality of {{ $industry->name }} Digital Architecture</h3>
                <p class="text-base text-[#4b5563] leading-relaxed">
                  Organizations in the <strong>{{ $industry->name }}</strong> sector frequently encounter severe bottlenecks: slow legacy databases, compliance vulnerabilities, high cart/quote bounce rates, and missed first-page search opportunities.
                </p>
                <p class="text-base text-[#4b5563] leading-relaxed">
                  At <strong>WebRanker</strong>, we deliver tailored full-stack web and mobile engineering coupled with deep programmatic SEO. Whether you are modernizing core workflows, launching customer self-service portals, or optimizing high-traffic transactions, our senior architects build for sub-second speeds and commercial revenue scale.
                </p>
              </div>
            @endif
          </div>

          <!-- Technologies Stack Pills -->
          @php
            $techList = $industry->technologies ?: ['Next.js 15', 'Laravel 11', 'FastAPI', 'Redis', 'AWS Edge', 'Docker', 'GraphQL'];
          @endphp
          <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] space-y-3">
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#161514] flex items-center gap-2">
              <i class="fas fa-microchip text-[#ff3b30]"></i>
              <span>Core Multi-Stack Technology Capabilities</span>
            </h4>
            <div class="flex flex-wrap gap-2">
              @foreach($techList as $tech)
                <span class="px-3 py-1.5 rounded-xl bg-[#faf7f2] border border-[#e6dfd3] text-xs font-extrabold text-[#161514]">
                  {{ $tech }}
                </span>
              @endforeach
            </div>
          </div>

          <!-- Key Challenges vs Solutions Matrix -->
          @php
            $challenges = $industry->challenges ?: [
              ['title' => 'Slow Response Times & Fragile Monoliths', 'description' => 'Legacy server-rendered templates crash under traffic spikes, causing high bounce rates and lost conversion revenue.'],
              ['title' => 'Compliance & Data Security Liabilities', 'description' => 'Unencrypted data at rest and poorly structured audit trails risk severe regulatory penalties and brand damage.']
            ];
            $solutions = $industry->solutions ?: [
              ['title' => 'Decoupled Edge SSR & Global CDN Microservices', 'description' => 'Sub-400ms rendering on globally distributed edge networks with automated caching.'],
              ['title' => 'Zero-Trust Architecture & Automated Hardening', 'description' => 'End-to-end tokenization, OWASP Top 10 compliance audits, and automated security scans in CI/CD.']
            ];
          @endphp

          <div class="space-y-4 pt-2">
            <h3 class="text-2xl font-black text-[#161514] tracking-tight">Solving Core Bottlenecks in {{ $industry->name }}</h3>
            <div class="space-y-4">
              @foreach($challenges as $i => $chal)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3]">
                  <div class="space-y-2">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-extrabold uppercase tracking-wider text-red-500">
                      <i class="fas fa-triangle-exclamation"></i> Legacy Industry Challenge
                    </span>
                    <h4 class="font-extrabold text-[#161514] text-base">{{ $chal['title'] ?? 'Operational Bottleneck' }}</h4>
                    <p class="text-xs text-[#6e675f] leading-relaxed">{{ $chal['description'] ?? '' }}</p>
                  </div>
                  <div class="space-y-2 md:border-l md:border-[#e6dfd3] md:pl-4">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-extrabold uppercase tracking-wider text-emerald-600">
                      <i class="fas fa-circle-check"></i> WebRanker Engineered Solution
                    </span>
                    <h4 class="font-extrabold text-[#161514] text-base">{{ $solutions[$i]['title'] ?? 'Modern Architectural Fix' }}</h4>
                    <p class="text-xs text-[#6e675f] leading-relaxed">{{ $solutions[$i]['description'] ?? '' }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <!-- Performance & Schema Highlights Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
            <div class="p-5 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-2">
              <div class="w-8 h-8 rounded-lg bg-[#161514] text-white flex items-center justify-center text-xs">
                <i class="fas fa-gauge-high"></i>
              </div>
              <h4 class="font-extrabold text-[#161514] text-sm">Sub-500ms Edge Latency Guarantee</h4>
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

  <!-- ======= 3. FREQUENTLY ASKED QUESTIONS (FAQS) ======= -->
  @php
    $faqs = $industry->faqs ?: [
      [
        'question' => "How does WebRanker ensure strict industry compliance for {$industry->name} builds?",
        'answer' => "We implement automated security pipelines, end-to-end encryption, strict role-based access control (RBAC), and industry-specific certifications including HIPAA, PCI-DSS, SOC2, and GDPR."
      ],
      [
        'question' => "Can you integrate our new web portal with legacy ERP and CRM systems?",
        'answer' => "Yes. Our team specializes in resilient API bridges, background webhook queues, and cryptographic authentication to synchronize data seamlessly without disrupting legacy operations."
      ],
      [
        'question' => "Do we own full intellectual property and source code once the build is complete?",
        'answer' => "Yes, 100%. Upon project milestone completion, all repository rights, documentation, and source code belong exclusively to your enterprise with zero vendor lock-in."
      ]
    ];
  @endphp

  <section class="py-20 bg-[#faf7f2] border-b border-[#e6dfd3]">
    <div class="max-w-4xl mx-auto px-6 space-y-12">
      <div class="text-center space-y-3">
        <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">TRANSPARENCY &amp; SPECIFICATIONS</span>
        <h2 class="text-3xl sm:text-4xl font-black text-[#161514] tracking-tight">
          Frequently Asked Questions
        </h2>
        <p class="text-sm text-[#6e675f]">
          Key questions regarding architecture, compliance, and delivery for {{ $industry->name }}.
        </p>
      </div>

      <div class="space-y-4" id="faqAccordion">
        @foreach($faqs as $idx => $faq)
          <div class="rounded-2xl bg-white border border-[#e6dfd3] overflow-hidden shadow-sm">
            <button type="button" class="w-full p-5 text-left flex items-center justify-between gap-4 font-extrabold text-sm sm:text-base text-[#161514] hover:text-[#ff3b30] transition-colors focus:outline-none"
                    onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.faq-chevron').classList.toggle('rotate-180')">
              <span>{{ $faq['question'] }}</span>
              <i class="fas fa-chevron-down text-xs text-slate-400 faq-chevron transition-transform duration-200"></i>
            </button>
            <div class="{{ $idx === 0 ? '' : 'hidden' }} px-5 pb-5 pt-1 text-xs sm:text-sm text-[#6e675f] leading-relaxed border-t border-[#f0eae1]">
              {{ $faq['answer'] }}
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ======= 4. RELATED INDUSTRY SOLUTIONS ======= -->
  @if($relatedIndustries->count() > 0)
    <section class="py-20 bg-white border-b border-[#e6dfd3]">
      <div class="max-w-7xl mx-auto px-6 space-y-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">ADJACENT VERTICALS</span>
            <h3 class="text-2xl sm:text-3xl font-black text-[#161514] tracking-tight mt-1">Explore Related Sectors</h3>
          </div>
          <a href="{{ route('industries.index') }}" class="text-xs font-extrabold text-[#ff3b30] hover:underline flex items-center gap-1.5">
            <span>View All Verticals Directory</span>
            <i class="fas fa-arrow-right text-[10px]"></i>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach($relatedIndustries as $rel)
            <article class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] hover:border-[#161514] transition-all hover:shadow-lg space-y-4 flex flex-col justify-between">
              <div class="space-y-3">
                <div class="w-10 h-10 rounded-xl bg-white border border-[#e6dfd3] flex items-center justify-center text-[#ff3b30] text-lg">
                  <i class="{{ $rel->icon_class }}"></i>
                </div>
                <h4 class="font-extrabold text-base text-[#161514]">
                  <a href="{{ route('industries.show', $rel->slug) }}" class="hover:text-[#ff3b30] transition-colors">
                    {{ $rel->name }}
                  </a>
                </h4>
                <p class="text-xs text-[#6e675f] line-clamp-2 leading-relaxed">
                  {{ $rel->description }}
                </p>
              </div>

              <div class="pt-4 border-t border-[#e6dfd3] flex items-center justify-between">
                <span class="text-[11px] font-bold text-emerald-600">{{ $rel->highlight_stat ?? 'High-Speed' }}</span>
                <a href="{{ route('industries.show', $rel->slug) }}" class="text-xs font-extrabold text-[#161514] hover:text-[#ff3b30] transition-colors flex items-center gap-1">
                  <span>Explore</span>
                  <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- ======= 5. CONSULTATION DISCOVERY AUDIT SECTION ======= -->
  <section id="inquiryForm" class="py-24 bg-[#161514] text-white relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-6 text-center space-y-8 relative z-10">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold bg-white/10 text-[#cfa86e]">
        <span>DIRECT LEAD ARCHITECT CONSULTATION</span>
      </div>

      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
        Build Your Custom <span class="text-[#ff3b30]">{{ $industry->name }}</span> Architecture
      </h2>

      <p class="text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
        Speak directly with our senior software engineers and technical SEO directors. We review your current stack, identify bottlenecks, and formulate a 48-hour execution blueprint.
      </p>

      <!-- Inquiry Action Form -->
      <div class="pt-4 max-w-xl mx-auto bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-2xl text-left space-y-5">
        <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-4">
          @csrf
          <input type="hidden" name="service" value="{{ $industry->name }} Industry Architecture">
          
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-300 mb-1">Your Name</label>
              <input type="text" name="name" required placeholder="Alex Morgan" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-300 mb-1">Work Email</label>
              <input type="email" name="email" required placeholder="alex@company.com" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-300 mb-1">Company &amp; Project URL (Optional)</label>
            <input type="text" name="website" placeholder="https://yourcompany.com" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-300 mb-1">Technical Scope &amp; Target Objectives</label>
            <textarea name="message" rows="3" required placeholder="Describe your current bottleneck, target timeline, or architectural requirements for {{ $industry->name }}..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30] leading-relaxed"></textarea>
          </div>

          <button type="submit" class="w-full py-3.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-lg shadow-red-500/30">
            Submit {{ $industry->name }} Consultation Request →
          </button>
        </form>
      </div>

    </div>
  </section>

</div>
@endsection
