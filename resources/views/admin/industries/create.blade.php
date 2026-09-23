@extends('admin.layouts.admin')

@section('title', 'Add New Industry Vertical')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

  <!-- Header -->
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-3">
      <a href="{{ route('admin.industries.index') }}" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
        <i class="fas fa-arrow-left text-sm"></i>
      </a>
      <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Add New Industry Vertical</h1>
        <p class="text-xs text-slate-400 mt-0.5">Configure vertical landing page architecture, challenges, solutions, and SEO.</p>
      </div>
    </div>
    <a href="{{ route('admin.industries.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors">
      Cancel
    </a>
  </div>

  @if($errors->any())
    <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs space-y-1">
      <div class="font-bold flex items-center gap-2">
        <i class="fas fa-circle-exclamation"></i> Please fix the following errors:
      </div>
      <ul class="list-disc pl-5 space-y-0.5">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.industries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- SECTION 1: PRIMARY IDENTITY & NAVIGATION -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <h3 class="text-sm font-extrabold uppercase tracking-wider text-white flex items-center gap-2">
          <i class="fas fa-fingerprint text-[#ff3b30]"></i>
          <span>1. Primary Identity &amp; Classification</span>
        </h3>
        <span class="text-xs text-slate-500 font-mono">* Required fields</span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Industry Name -->
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Industry Name <span class="text-red-400">*</span>
          </label>
          <input type="text" name="name" id="industryName" value="{{ old('name') }}" required
                 placeholder="e.g. CleanTech &amp; Renewable Energy"
                 class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30] transition-colors">
        </div>

        <!-- URL Slug -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
              URL Slug <span class="text-slate-500 font-normal">(Auto-syncs from Name)</span>
            </label>
            <button type="button" onclick="generateSlugFromName()" class="text-[11px] font-semibold text-[#ff3b30] hover:text-red-400 transition-colors flex items-center gap-1 cursor-pointer">
              <i class="fas fa-arrows-rotate text-[10px]"></i> Auto-Generate
            </button>
          </div>
          <div class="flex items-center rounded-xl bg-slate-950 border border-slate-800 overflow-hidden focus-within:border-[#ff3b30] transition-colors">
            <span class="px-3.5 py-2.5 bg-slate-900 text-slate-400 text-xs font-mono border-r border-slate-800 whitespace-nowrap flex-shrink-0 select-none">/industries/</span>
            <input type="text" name="slug" id="industrySlug" value="{{ old('slug') }}"
                   placeholder="cleantech-renewable-energy"
                   class="w-full px-3.5 py-2.5 bg-transparent text-xs text-white focus:outline-none font-mono">
          </div>
        </div>

        <!-- FontAwesome Icon -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
              FontAwesome Icon Class <span class="text-red-400">*</span>
            </label>
            <span class="text-[11px] text-slate-400 font-mono" id="iconStatusLabel">FontAwesome 6 Free</span>
          </div>
          <div class="flex items-center gap-3">
            <div id="iconPreview" class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-[#ff3b30] text-lg flex-shrink-0 transition-all">
              <i class="fa-solid fa-building"></i>
            </div>
            <input type="text" name="icon" id="iconInput" value="{{ old('icon', 'fa-solid fa-building') }}" required
                   placeholder="e.g. fa-solid fa-solar-panel or fa-leaf"
                   class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30] transition-colors font-mono">
          </div>
          <div class="flex flex-wrap items-center gap-2 pt-1 text-[11px] text-slate-400">
            <span class="font-bold text-slate-300">Quick suggestions:</span>
            <button type="button" onclick="setIcon('fa-solid fa-cart-shopping')" class="hover:text-white px-2 py-0.5 rounded bg-slate-800 border border-slate-700 flex items-center gap-1.5 cursor-pointer"><i class="fa-solid fa-cart-shopping text-[#ff3b30]"></i> cart-shopping</button>
            <button type="button" onclick="setIcon('fa-solid fa-building-columns')" class="hover:text-white px-2 py-0.5 rounded bg-slate-800 border border-slate-700 flex items-center gap-1.5 cursor-pointer"><i class="fa-solid fa-building-columns text-[#ff3b30]"></i> building-columns</button>
            <button type="button" onclick="setIcon('fa-solid fa-heart-pulse')" class="hover:text-white px-2 py-0.5 rounded bg-slate-800 border border-slate-700 flex items-center gap-1.5 cursor-pointer"><i class="fa-solid fa-heart-pulse text-[#ff3b30]"></i> heart-pulse</button>
            <button type="button" onclick="setIcon('fa-solid fa-city')" class="hover:text-white px-2 py-0.5 rounded bg-slate-800 border border-slate-700 flex items-center gap-1.5 cursor-pointer"><i class="fa-solid fa-city text-[#ff3b30]"></i> city</button>
            <button type="button" onclick="setIcon('fa-solid fa-truck-fast')" class="hover:text-white px-2 py-0.5 rounded bg-slate-800 border border-slate-700 flex items-center gap-1.5 cursor-pointer"><i class="fa-solid fa-truck-fast text-[#ff3b30]"></i> truck-fast</button>
            <button type="button" onclick="setIcon('fa-solid fa-solar-panel')" class="hover:text-white px-2 py-0.5 rounded bg-slate-800 border border-slate-700 flex items-center gap-1.5 cursor-pointer"><i class="fa-solid fa-solar-panel text-[#ff3b30]"></i> solar-panel</button>
          </div>
        </div>

        <!-- Category Group -->
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Category Group
          </label>
          <select name="category_group" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-slate-200 focus:outline-none focus:border-[#ff3b30]">
            @foreach($categoryGroups as $grp)
              <option value="{{ $grp }}" {{ old('category_group') === $grp ? 'selected' : '' }}>{{ $grp }}</option>
            @endforeach
          </select>
        </div>

        <!-- Sort Order -->
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Sort Order
          </label>
          <input type="number" name="sort_order" value="{{ old('sort_order', $nextOrder ?? 0) }}" min="0"
                 class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Active Toggle -->
        <div class="flex items-center gap-3 pt-6">
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="sr-only peer">
            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
          </label>
          <div>
            <span class="text-xs font-bold text-white block">Active &amp; Published</span>
            <span class="text-[11px] text-slate-500">Enable to make live on directory and single page</span>
          </div>
        </div>
      </div>
    </div>

    <!-- SECTION 2: METRICS & HERO COPY -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <h3 class="text-sm font-extrabold uppercase tracking-wider text-white flex items-center gap-2">
          <i class="fas fa-chart-line text-[#ff3b30]"></i>
          <span>2. Hero Headline, KPIs &amp; Summary</span>
        </h3>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Highlight Stat -->
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Highlight Stat Badge
          </label>
          <input type="text" name="highlight_stat" value="{{ old('highlight_stat', '+310%') }}"
                 placeholder="e.g. +310% or Sub-400ms"
                 class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Stat Label -->
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Stat Label
          </label>
          <input type="text" name="stat_label" value="{{ old('stat_label', 'Organic Revenue Growth') }}"
                 placeholder="e.g. Revenue Growth, Conversion Boost"
                 class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Hero Tagline -->
        <div class="md:col-span-2 space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Single Page Hero Tagline / Subtitle
          </label>
          <input type="text" name="hero_tagline" value="{{ old('hero_tagline') }}"
                 placeholder="e.g. Enterprise Full-Stack Systems, Sub-Second Latency, and Search Authority for High-Growth Brands"
                 class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Short Description -->
        <div class="md:col-span-2 space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Card Short Summary (Used on Directory &amp; Cards)
          </label>
          <textarea name="description" rows="3"
                    placeholder="Short 2-3 sentence summary of how WebRanker transforms this industry..."
                    class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30] leading-relaxed">{{ old('description') }}</textarea>
        </div>

        <!-- Tags / Capabilities -->
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Capabilities Tags (comma separated)
          </label>
          <input type="text" name="tags" value="{{ old('tags') }}"
                 placeholder="Headless Checkout, Algolia Search, Multi-Vendor"
                 class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Technologies Stack -->
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Tech Stack Tags (comma separated)
          </label>
          <input type="text" name="technologies" value="{{ old('technologies', 'Next.js 15, Laravel 11, AWS Edge, Redis, GraphQL') }}"
                 placeholder="Next.js, Laravel, GraphQL, Redis, AWS"
                 class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
        </div>

        <!-- Featured Image -->
        <div class="md:col-span-2 space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Cover / Diagram Image (Optional — defaults to WebRanker high-tech cover if empty)
          </label>
          <input type="file" name="featured_image_file" accept="image/*"
                 class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#ff3b30] file:text-white hover:file:bg-red-600">
        </div>
      </div>
    </div>

    <!-- SECTION 3: DETAILED ARCHITECTURE & STRATEGY CONTENT -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-800 gap-3">
        <div>
          <h3 class="text-sm font-extrabold uppercase tracking-wider text-white flex items-center gap-2">
            <i class="fas fa-layer-group text-[#ff3b30]"></i>
            <span>3. Detailed Vertical Architecture &amp; Strategy</span>
          </h3>
          <p class="text-xs text-slate-400 mt-0.5">Switch smoothly between rich visual WYSIWYG editing and raw HTML source code.</p>
        </div>

        <!-- Mode Tabs & Quick Actions -->
        <div class="flex items-center gap-2 flex-wrap">
          <!-- Editor Tabs -->
          <div class="inline-flex items-center p-1 bg-slate-950 rounded-xl border border-slate-800">
            <button type="button" id="tabVisualBtn" onclick="switchEditorTab('visual')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-[#ff3b30] text-white shadow-sm cursor-pointer">
              <i class="fas fa-pen-nib text-[10px]"></i>
              <span>Visual Editor</span>
            </button>
            <button type="button" id="tabSourceBtn" onclick="switchEditorTab('source')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 text-slate-400 hover:text-white hover:bg-slate-900 cursor-pointer">
              <i class="fas fa-code text-[11px]"></i>
              <span>Source &amp; HTML Code</span>
            </button>
          </div>

          <!-- Quick Action Buttons -->
          <button type="button" id="formatHtmlBtn" onclick="formatSourceHtml()" title="Beautify / Indent HTML Code"
                  class="hidden px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors flex items-center gap-1 cursor-pointer">
            <i class="fas fa-wand-magic-sparkles text-[11px] text-amber-400"></i>
            <span>Format HTML</span>
          </button>
          <button type="button" onclick="insertArchitectureTemplate()" title="Insert Responsive Technical Architecture Grid"
                  class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors flex items-center gap-1 cursor-pointer">
            <i class="fas fa-plus text-[10px] text-emerald-400"></i>
            <span>Architecture Template</span>
          </button>
        </div>
      </div>

      <!-- Synchronized Hidden Master Textarea submitted with the form -->
      <textarea name="detailed_content" id="masterDetailedContentInput" class="hidden">{{ old('detailed_content') }}</textarea>

      <!-- VISUAL TAB CONTAINER -->
      <div id="visualTabWrapper" class="space-y-2">
        <div class="rounded-xl overflow-hidden border border-slate-800 bg-slate-950">
          <textarea id="ckDetailedEditor">{{ old('detailed_content') }}</textarea>
        </div>
        <p class="text-[11px] text-slate-500">Visual mode: Edit text, format headings (H2-H4), bullet points, blockquotes, tables, and hyperlinks.</p>
      </div>

      <!-- SOURCE CODE TAB CONTAINER -->
      <div id="sourceTabWrapper" class="hidden space-y-2">
        <div class="relative rounded-xl overflow-hidden border border-slate-800 bg-[#030712]">
          <div class="flex items-center justify-between px-4 py-2 bg-slate-950/80 border-b border-slate-800 text-[11px] font-mono text-slate-400">
            <span class="flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
              HTML5 Source Editor • Raw Markup Mode
            </span>
            <div class="flex items-center gap-3">
              <span id="sourceCharCount">0 characters</span>
              <button type="button" onclick="copySourceHtml()" class="hover:text-white transition-colors flex items-center gap-1 text-[#ff3b30] cursor-pointer">
                <i class="fas fa-copy text-[10px]"></i> Copy
              </button>
            </div>
          </div>
          <textarea id="sourceCodeInput" rows="16" spellcheck="false"
                    class="w-full px-4 py-3 bg-[#030712] text-amber-200 font-mono text-xs leading-relaxed focus:outline-none focus:ring-1 focus:ring-[#ff3b30] resize-y placeholder-slate-600"
                    placeholder="<!-- Write or paste any custom HTML, Tailwind components, SVG diagrams, or technical grids -->"></textarea>
        </div>
        <p class="text-[11px] text-slate-500">Source mode: Edit pure HTML tags, inline SVG, custom Tailwind grid classes, or embed external widgets.</p>
      </div>

    </div>

    <!-- SECTION 4: CHALLENGES & SOLUTIONS REPEATER -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-sm font-extrabold uppercase tracking-wider text-white flex items-center gap-2">
            <i class="fas fa-scale-balanced text-[#ff3b30]"></i>
            <span>4. Industry Challenges vs WebRanker Engineering Solutions</span>
          </h3>
          <p class="text-xs text-slate-400 mt-1">Showcase the typical failure points in this industry vs our modern solutions.</p>
        </div>
        <button type="button" onclick="addChallengeSolutionRow()" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-white transition-colors flex items-center gap-1.5">
          <i class="fas fa-plus text-[10px] text-emerald-400"></i> Add Row
        </button>
      </div>

      <div id="challengeSolutionContainer" class="space-y-4">
        <!-- Default Row 1 -->
        <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-3 relative group">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
              <label class="block text-[11px] font-bold uppercase text-red-400">Legacy Challenge / Pain Point</label>
              <input type="text" name="challenge_titles[]" value="Slow Time-to-Interactive &amp; Fragile Monoliths" placeholder="Challenge Title" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-white">
              <textarea name="challenge_descriptions[]" rows="2" placeholder="Details of how legacy systems fail..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-slate-300 mt-1">Legacy CMS templates choke during flash traffic surges, leading to 8-second cart abandonment and dropped organic rankings.</textarea>
            </div>
            <div class="space-y-1">
              <label class="block text-[11px] font-bold uppercase text-emerald-400">WebRanker Engineering Solution</label>
              <input type="text" name="solution_titles[]" value="Decoupled Edge SSR &amp; Global Microservices" placeholder="Solution Title" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-white">
              <textarea name="solution_descriptions[]" rows="2" placeholder="How our architecture solves it..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-slate-300 mt-1">We decouple the frontend onto edge networks delivering sub-400ms TTFB with high-throughput asynchronous backends.</textarea>
            </div>
          </div>
          <button type="button" onclick="this.closest('.p-4').remove()" class="text-xs text-slate-500 hover:text-red-400 transition-colors">
            <i class="fas fa-trash"></i> Remove Pair
          </button>
        </div>
      </div>
    </div>

    <!-- SECTION 5: FAQS REPEATER -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-sm font-extrabold uppercase tracking-wider text-white flex items-center gap-2">
            <i class="fas fa-circle-question text-[#ff3b30]"></i>
            <span>5. Vertical Frequently Asked Questions (FAQ Schema)</span>
          </h3>
          <p class="text-xs text-slate-400 mt-1">Populates interactive accordion and FAQPage schema for Google rich snippets.</p>
        </div>
        <button type="button" onclick="addFaqRow()" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-white transition-colors flex items-center gap-1.5">
          <i class="fas fa-plus text-[10px] text-emerald-400"></i> Add FAQ
        </button>
      </div>

      <div id="faqContainer" class="space-y-3">
        <!-- Default FAQ 1 -->
        <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-2 relative">
          <input type="text" name="faq_questions[]" value="How does your engineering approach ensure compliance and uptime in this sector?" placeholder="Question..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-white font-bold">
          <textarea name="faq_answers[]" rows="2" placeholder="Answer..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-slate-300">We implement strict end-to-end encryption, automated OWASP Top 10 compliance audits, and multi-region failover clusters with 99.99% guaranteed SLA uptime.</textarea>
          <button type="button" onclick="this.closest('.p-4').remove()" class="text-xs text-slate-500 hover:text-red-400 transition-colors">
            <i class="fas fa-trash"></i> Remove FAQ
          </button>
        </div>
      </div>
    </div>

    <!-- SECTION 6: SEARCH ENGINE OPTIMIZATION (SEO) -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <h3 class="text-sm font-extrabold uppercase tracking-wider text-white flex items-center gap-2">
          <i class="fas fa-magnifying-glass text-[#ff3b30]"></i>
          <span>6. Search Engine Optimization &amp; Schema</span>
        </h3>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Meta Title Tag</label>
          <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Defaults to: [Name] Digital Engineering &amp; SEO Architecture | WebRanker" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Focus Keywords</label>
          <input type="text" name="focus_keywords" value="{{ old('focus_keywords') }}" placeholder="e.g. enterprise ecommerce SEO, headless architecture, PCI-DSS compliance" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">
        </div>

        <div class="md:col-span-2 space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Meta Description</label>
          <textarea name="meta_description" rows="2" placeholder="Compelling 150-160 character description summarizing the vertical solutions..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white focus:outline-none focus:border-[#ff3b30]">{{ old('meta_description') }}</textarea>
        </div>

        <div class="md:col-span-2 space-y-1.5">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">Custom Schema.org JSON-LD (Optional)</label>
          <textarea name="custom_schema" rows="3" placeholder='{"@@context":"https://schema.org","@@type":"Service",...}' class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white font-mono focus:outline-none focus:border-[#ff3b30]">{{ old('custom_schema') }}</textarea>
        </div>
      </div>
    </div>

    <!-- Submit Toolbar -->
    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-900 border border-slate-800 sticky bottom-6 shadow-2xl z-30">
      <a href="{{ route('admin.industries.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors">
        Cancel
      </a>
      <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white text-xs font-extrabold uppercase tracking-wider transition-all shadow-lg shadow-red-500/20 flex items-center gap-2">
        <i class="fas fa-check"></i>
        <span>Save &amp; Publish Industry</span>
      </button>
    </div>

  </form>

</div>

@push('admin_scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
  // Normalized Icon Class Helper
  function getFullIconClass(val) {
    let icon = (val || '').trim();
    if (!icon) return 'fa-solid fa-cube';
    if (!icon.includes('fa-solid') && !icon.includes('fas') && !icon.includes('fab') && !icon.includes('far')) {
      if (!icon.startsWith('fa-')) {
        return 'fa-solid fa-' + icon;
      }
      return 'fa-solid ' + icon;
    }
    return icon;
  }

  // Icon Preview Live Update
  const iconInput = document.getElementById('iconInput');
  const iconPreview = document.getElementById('iconPreview');
  function updateIconPreview() {
    if (!iconInput || !iconPreview) return;
    const resolvedClass = getFullIconClass(iconInput.value);
    iconPreview.innerHTML = '<i class="' + resolvedClass + '"></i>';
  }
  if (iconInput) {
    iconInput.addEventListener('input', updateIconPreview);
  }

  function setIcon(val) {
    if (!iconInput) return;
    iconInput.value = val;
    updateIconPreview();
  }

  // Auto-generate slug from name if slug untouched
  const nameInput = document.getElementById('industryName');
  const slugInput = document.getElementById('industrySlug');
  let slugModified = false;
  if (slugInput) {
    slugInput.addEventListener('input', () => { slugModified = true; });
  }
  if (nameInput) {
    nameInput.addEventListener('input', () => {
      if (!slugModified) {
        generateSlugFromName();
      }
    });
  }

  function generateSlugFromName() {
    if (!nameInput || !slugInput) return;
    const str = nameInput.value.trim();
    if (!str) return;
    const slug = str
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '');
    slugInput.value = slug;
  }

  // CKEditor 5 & Source Code Tab Switcher
  let classicEditorInstance = null;
  let currentEditorTab = 'visual';

  const sourceInput = document.getElementById('sourceCodeInput');
  if (sourceInput) {
    sourceInput.value = document.getElementById('masterDetailedContentInput')?.value || '';
    updateSourceCharCount();
    sourceInput.addEventListener('input', () => {
      updateSourceCharCount();
      if (currentEditorTab === 'source') {
        const master = document.getElementById('masterDetailedContentInput');
        if (master) master.value = sourceInput.value;
      }
    });
  }

  function updateSourceCharCount() {
    const countEl = document.getElementById('sourceCharCount');
    if (countEl && sourceInput) {
      countEl.textContent = `${sourceInput.value.length.toLocaleString()} characters`;
    }
  }

  if (document.querySelector('#ckDetailedEditor')) {
    ClassicEditor
      .create(document.querySelector('#ckDetailedEditor'), {
        toolbar: [
          'heading', '|',
          'bold', 'italic', 'underline', 'strikethrough', '|',
          'bulletedList', 'numberedList', '|',
          'blockQuote', 'insertTable', 'link', '|',
          'undo', 'redo'
        ]
      })
      .then(editor => {
        classicEditorInstance = editor;
        editor.model.document.on('change:data', () => {
          if (currentEditorTab === 'visual') {
            const master = document.getElementById('masterDetailedContentInput');
            if (master) master.value = editor.getData();
          }
        });
      })
      .catch(error => {
        console.error('Classic Editor failed to initialize:', error);
      });
  }

  function switchEditorTab(mode) {
    const visualWrapper = document.getElementById('visualTabWrapper');
    const sourceWrapper = document.getElementById('sourceTabWrapper');
    const tabVisualBtn = document.getElementById('tabVisualBtn');
    const tabSourceBtn = document.getElementById('tabSourceBtn');
    const formatHtmlBtn = document.getElementById('formatHtmlBtn');
    const master = document.getElementById('masterDetailedContentInput');

    if (mode === 'source') {
      currentEditorTab = 'source';
      if (classicEditorInstance) {
        sourceInput.value = classicEditorInstance.getData();
      }
      if (master) master.value = sourceInput.value;
      updateSourceCharCount();

      visualWrapper.classList.add('hidden');
      sourceWrapper.classList.remove('hidden');
      formatHtmlBtn.classList.remove('hidden');

      tabVisualBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 text-slate-400 hover:text-white hover:bg-slate-900 cursor-pointer';
      tabSourceBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-[#ff3b30] text-white shadow-sm cursor-pointer';
    } else {
      currentEditorTab = 'visual';
      if (classicEditorInstance) {
        classicEditorInstance.setData(sourceInput.value);
      }
      if (master) master.value = sourceInput.value;

      sourceWrapper.classList.add('hidden');
      visualWrapper.classList.remove('hidden');
      formatHtmlBtn.classList.add('hidden');

      tabSourceBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 text-slate-400 hover:text-white hover:bg-slate-900 cursor-pointer';
      tabVisualBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-[#ff3b30] text-white shadow-sm cursor-pointer';
    }
  }

  // Format / Beautify HTML
  function formatSourceHtml() {
    if (!sourceInput || !sourceInput.value.trim()) return;
    let html = sourceInput.value.trim();
    let formatted = '';
    let indent = 0;
    const tab = '  ';
    html = html.replace(/>\s*</g, '><');
    const tokens = html.split(/(<\/?[a-zA-Z0-9\-]+[^>]*>)/g).filter(Boolean);

    tokens.forEach(token => {
      if (token.startsWith('</')) {
        indent = Math.max(0, indent - 1);
        formatted += tab.repeat(indent) + token.trim() + '\n';
      } else if (token.startsWith('<') && !token.endsWith('/>') && !/^(<img|<input|<br|<hr|<meta|<link)/i.test(token)) {
        formatted += tab.repeat(indent) + token.trim() + '\n';
        indent++;
      } else {
        const trimmed = token.trim();
        if (trimmed) {
          formatted += tab.repeat(indent) + trimmed + '\n';
        }
      }
    });

    sourceInput.value = formatted.trim();
    updateSourceCharCount();
  }

  // Copy HTML
  function copySourceHtml() {
    if (!sourceInput) return;
    const content = currentEditorTab === 'visual' && classicEditorInstance ? classicEditorInstance.getData() : sourceInput.value;
    navigator.clipboard.writeText(content).then(() => {
      alert('HTML markup copied to clipboard!');
    }).catch(() => {
      sourceInput.select();
      document.execCommand('copy');
      alert('HTML markup copied to clipboard!');
    });
  }

  // Insert Architecture Blueprint Template
  function insertArchitectureTemplate() {
    const industryName = document.getElementById('industryName')?.value || 'CleanTech & Renewable Energy';
    const template = `<h3>Enterprise Technical Architecture for ${industryName}</h3>
<p>Our engineering blueprint for <strong>${industryName}</strong> replaces fragmented monolithic systems with decoupled edge computing, multi-tier caching, and real-time transaction pipelines.</p>
<h4>1. Microservices &amp; Edge Delivery</h4>
<ul>
  <li><strong>Sub-400ms Dynamic TTFB:</strong> Distributed SSR delivery across global PoPs.</li>
  <li><strong>Stateless API Layer:</strong> High-throughput REST &amp; GraphQL microservices.</li>
  <li><strong>Automated Failover:</strong> Multi-region redundancy with 99.99% SLA.</li>
</ul>
<h4>2. Compliance, Security &amp; Data Integrity</h4>
<p>All data at rest and in transit is safeguarded under zero-trust authorization protocols, continuous CI/CD security telemetry, and full audit logs.</p>`;

    if (currentEditorTab === 'visual' && classicEditorInstance) {
      classicEditorInstance.setData(template);
      sourceInput.value = template;
    } else {
      sourceInput.value = template;
      if (classicEditorInstance) classicEditorInstance.setData(template);
    }
    const master = document.getElementById('masterDetailedContentInput');
    if (master) master.value = template;
    updateSourceCharCount();
  }

  // Sync before form submission
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    if (form) {
      form.addEventListener('submit', () => {
        const master = document.getElementById('masterDetailedContentInput');
        if (!master) return;
        if (currentEditorTab === 'source' && sourceInput) {
          master.value = sourceInput.value;
        } else if (classicEditorInstance) {
          master.value = classicEditorInstance.getData();
        }
      });
    }
  });

  // Repeater for Challenge / Solution
  function addChallengeSolutionRow() {
    const container = document.getElementById('challengeSolutionContainer');
    const row = document.createElement('div');
    row.className = 'p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-3 relative group';
    row.innerHTML = `
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-1">
          <label class="block text-[11px] font-bold uppercase text-red-400">Legacy Challenge / Pain Point</label>
          <input type="text" name="challenge_titles[]" placeholder="Challenge Title" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-white">
          <textarea name="challenge_descriptions[]" rows="2" placeholder="Details of how legacy systems fail..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-slate-300 mt-1"></textarea>
        </div>
        <div class="space-y-1">
          <label class="block text-[11px] font-bold uppercase text-emerald-400">WebRanker Engineering Solution</label>
          <input type="text" name="solution_titles[]" placeholder="Solution Title" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-white">
          <textarea name="solution_descriptions[]" rows="2" placeholder="How our architecture solves it..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-slate-300 mt-1"></textarea>
        </div>
      </div>
      <button type="button" onclick="this.closest('.p-4').remove()" class="text-xs text-slate-500 hover:text-red-400 transition-colors cursor-pointer">
        <i class="fas fa-trash"></i> Remove Pair
      </button>
    `;
    container.appendChild(row);
  }

  // Repeater for FAQs
  function addFaqRow() {
    const container = document.getElementById('faqContainer');
    const row = document.createElement('div');
    row.className = 'p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-2 relative';
    row.innerHTML = `
      <input type="text" name="faq_questions[]" placeholder="Question..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-white font-bold">
      <textarea name="faq_answers[]" rows="2" placeholder="Answer..." class="w-full px-3 py-2 bg-slate-900 border border-slate-800 rounded-lg text-xs text-slate-300"></textarea>
      <button type="button" onclick="this.closest('.p-4').remove()" class="text-xs text-slate-500 hover:text-red-400 transition-colors cursor-pointer">
        <i class="fas fa-trash"></i> Remove FAQ
      </button>
    `;
    container.appendChild(row);
  }
</script>
@endpush

@push('admin_styles')
<style>
  .ck.ck-editor {
    width: 100% !important;
  }
  .ck.ck-editor__main > .ck-editor__editable {
    height: 380px !important;
    min-height: 250px !important;
    max-height: 480px !important;
    overflow-y: auto !important;
    border-bottom-left-radius: 0.75rem !important;
    border-bottom-right-radius: 0.75rem !important;
    font-size: 0.875rem !important;
    line-height: 1.7 !important;
    scrollbar-width: thin !important;
    scrollbar-color: #ff3b30 #0f172a !important;
  }
  .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar {
    width: 8px !important;
  }
  .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-track {
    background: #0f172a !important;
    border-bottom-right-radius: 0.75rem !important;
  }
  .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-thumb {
    background-color: #334155 !important;
    border-radius: 4px !important;
  }
  .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-thumb:hover {
    background-color: #ff3b30 !important;
  }
  .ck.ck-editor__main > .ck-editor__editable:focus {
    border-color: #ff3b30 !important;
    box-shadow: none !important;
  }
  .ck.ck-toolbar {
    border-top-left-radius: 0.75rem !important;
    border-top-right-radius: 0.75rem !important;
  }
  .ck.ck-button {
    cursor: pointer !important;
  }

  /* Source Code Editor Scrollbar & Height */
  #sourceCodeInput {
    height: 380px !important;
    min-height: 250px !important;
    max-height: 480px !important;
    overflow-y: auto !important;
    scrollbar-width: thin !important;
    scrollbar-color: #ff3b30 #030712 !important;
  }
  #sourceCodeInput::-webkit-scrollbar {
    width: 8px !important;
  }
  #sourceCodeInput::-webkit-scrollbar-track {
    background: #030712 !important;
    border-bottom-right-radius: 0.75rem !important;
  }
  #sourceCodeInput::-webkit-scrollbar-thumb {
    background-color: #334155 !important;
    border-radius: 4px !important;
  }
  #sourceCodeInput::-webkit-scrollbar-thumb:hover {
    background-color: #ff3b30 !important;
  }

  /* Dark Theme Specific */
  html:not(.theme-light) .ck.ck-editor__main > .ck-editor__editable {
    background-color: #020617 !important;
    color: #e2e8f0 !important;
    border-color: #1e293b !important;
  }
  html:not(.theme-light) .ck.ck-toolbar {
    background-color: #090d16 !important;
    border-color: #1e293b !important;
  }
  html:not(.theme-light) .ck.ck-button {
    color: #94a3b8 !important;
  }
  html:not(.theme-light) .ck.ck-button:hover,
  html:not(.theme-light) .ck.ck-button.ck-on {
    background-color: #1e293b !important;
    color: #ffffff !important;
  }
  html:not(.theme-light) .ck.ck-dropdown__panel {
    background-color: #090d16 !important;
    border-color: #1e293b !important;
  }
  html:not(.theme-light) .ck.ck-list__item .ck-button {
    color: #cbd5e1 !important;
  }
  html:not(.theme-light) .ck.ck-list__item .ck-button:hover {
    background-color: #1e293b !important;
    color: #ffffff !important;
  }
  html:not(.theme-light) .ck.ck-toolbar .ck-toolbar__separator {
    background-color: #1e293b !important;
  }

  /* Light Theme Specific */
  html.theme-light .ck.ck-editor__main > .ck-editor__editable {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border-color: #cbd5e1 !important;
    scrollbar-color: #ff3b30 #f1f5f9 !important;
  }
  html.theme-light .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-track {
    background: #f1f5f9 !important;
  }
  html.theme-light .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-thumb {
    background-color: #cbd5e1 !important;
  }
  html.theme-light .ck.ck-toolbar {
    background-color: #f8fafc !important;
    border-color: #cbd5e1 !important;
  }
</style>
@endpush
@endsection
