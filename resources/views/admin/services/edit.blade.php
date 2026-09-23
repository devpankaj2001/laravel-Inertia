@extends('admin.layouts.admin')

@section('title', 'Edit Service - ' . $service->title)
@section('page_title', 'Edit Service')

@section('admin_content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Header Breadcrumb & Actions -->
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
      <a href="{{ route('admin.services.index') }}" class="hover:text-white transition-colors">Services</a>
      <span>/</span>
      <span class="text-white">Edit: {{ $service->title }}</span>
    </div>
    <div class="flex items-center gap-2">
      <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 text-xs font-bold hover:bg-emerald-500/30 transition-colors">
        <i class="fas fa-plus"></i> Add Another
      </a>
      <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors">
        <i class="fas fa-arrow-left"></i> Back to Catalog
      </a>
    </div>
  </div>

  @if(isset($errors) && $errors->any())
    <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 space-y-1">
      <p class="font-bold flex items-center gap-2 text-sm">
        <i class="fas fa-circle-exclamation"></i> Please fix the following errors:
      </p>
      <ul class="list-disc list-inside text-xs space-y-0.5 pl-2">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.services.update', $service->id) }}" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- SECTION 1: CORE IDENTITY -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white">1. Service Identity &amp; Dynamic Category</h3>
          <p class="text-xs text-slate-400">Update service naming, dynamic category classification and URL slug.</p>
        </div>
        <span class="w-7 h-7 rounded-lg bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-xs font-black">01</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <!-- Service Title -->
        <div class="space-y-1.5 sm:col-span-2">
          <label for="titleInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Service Title <span class="text-[#ff3b30]">*</span>
          </label>
          <input type="text" id="titleInput" name="title" value="{{ old('title', $service->title) }}" required
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm">
        </div>

        <!-- Slug URL -->
        <div class="space-y-1.5 sm:col-span-2">
          <label for="slugInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            URL Slug
          </label>
          <div class="flex items-center rounded-xl bg-slate-950 border border-slate-800 overflow-hidden focus-within:border-[#ff3b30]">
            <span class="px-3.5 py-2.5 bg-slate-900 text-slate-500 text-xs font-mono border-r border-slate-800">services/</span>
            <input type="text" id="slugInput" name="slug" value="{{ old('slug', $service->slug) }}"
                   class="w-full px-3 py-2.5 bg-transparent text-white placeholder-slate-600 focus:outline-none text-xs font-mono">
          </div>
        </div>

        <!-- Dynamic Category Multi-Selector with Live Search & Checkboxes -->
        <div class="space-y-3 sm:col-span-2 p-5 rounded-2xl bg-slate-950/70 border border-slate-800">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-slate-800/80">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-amber-400 flex items-center gap-2">
                <i class="fas fa-tags"></i> Service Industry Categories <span class="text-[#ff3b30]">*</span>
              </label>
              <p class="text-[11px] text-slate-400 mt-0.5">Select one or multiple target industries sorted in alphabetical order.</p>
            </div>
            <div class="flex items-center gap-2">
              <span id="selectedCategoryCountBadge" class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/10 text-amber-300 border border-amber-500/20 font-mono">
                0 Selected
              </span>
              <button type="button" id="toggleNewCatBtn" class="text-xs font-bold text-[#ff3b30] hover:text-red-400 transition-colors flex items-center gap-1.5">
                <i class="fas fa-plus-circle"></i> <span id="toggleCatLabel">+ Create New Category</span>
              </button>
            </div>
          </div>

          <!-- New Category Inline Input -->
          <div id="newCatGroup" class="space-y-1 {{ old('category_new') ? '' : 'hidden' }} p-3 rounded-xl bg-amber-500/5 border border-amber-500/30">
            <div class="flex items-center gap-2">
              <input type="text" name="category_new" id="categoryNewInput" value="{{ old('category_new') }}"
                     placeholder="Type brand-new category (e.g. AI & Automation, Robotics, CleanTech)..."
                     class="flex-1 px-4 py-2 rounded-xl bg-slate-900 border border-amber-500/50 text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 text-xs">
              <button type="button" id="addCustomCatBtn" class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs transition-colors">
                Add to List
              </button>
            </div>
            <p class="text-[10px] text-amber-400/80">✨ Added category will be dynamically appended and selected.</p>
          </div>

          <!-- Quick Search Filter Bar -->
          <div class="relative">
            <input type="text" id="categorySearchInput"
                   placeholder="Quick search categories (e.g. Healthcare, FinTech, E-commerce, Real Estate)..."
                   class="w-full pl-9 pr-8 py-2 rounded-xl bg-slate-900 border border-slate-800 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-[#ff3b30] transition-colors">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
            <button type="button" id="clearCatSearchBtn" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white text-xs">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <!-- Selected Category Chips Display -->
          <div id="selectedCategoryChips" class="flex flex-wrap gap-1.5 min-h-[22px]">
            <!-- Populated via JS -->
          </div>

          <!-- Checkboxes Grid Container (Alphabetical Order, Multi-Select) -->
          @php
            $assignedCats = old('categories', $service->all_categories);
          @endphp
          <div id="categoryGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-56 overflow-y-auto pr-1">
            @foreach($existingCategories as $cat)
              @php
                $isChecked = in_array($cat, $assignedCats);
              @endphp
              <label class="category-checkbox-item flex items-center justify-between p-2.5 rounded-xl border transition-all cursor-pointer select-none text-xs {{ $isChecked ? 'bg-amber-500/10 border-amber-500/40 text-white font-semibold' : 'bg-slate-900/60 hover:bg-slate-800 border-slate-800 text-slate-300' }}"
                     data-name="{{ strtolower($cat) }}">
                <div class="flex items-center gap-2.5 overflow-hidden">
                  <input type="checkbox" name="categories[]" value="{{ $cat }}" class="category-checkbox rounded text-[#ff3b30] bg-slate-950 border-slate-700 focus:ring-0 focus:ring-offset-0 cursor-pointer" {{ $isChecked ? 'checked' : '' }}>
                  <span class="truncate">{{ $cat }}</span>
                </div>
                <i class="fas fa-tag text-[10px] text-slate-600"></i>
              </label>
            @endforeach
          </div>

          <!-- Empty search result alert -->
          <div id="noCategoryMatch" class="hidden py-4 text-center text-xs text-slate-500">
            <i class="fas fa-search-minus mr-1 text-slate-600"></i> No categories match your search. Use "+ Create New Category" above to add it.
          </div>
        </div>
      </div>
    </div>

    <!-- SECTION 2: VISUAL ASSETS & BADGES -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white">2. Visual Icon, Badge &amp; KPI Metrics</h3>
          <p class="text-xs text-slate-400">Configure display icon, highlight badge and numeric results.</p>
        </div>
        <span class="w-7 h-7 rounded-lg bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-xs font-black">02</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <!-- Icon Picker -->
        <div class="space-y-2 sm:col-span-2">
          <label for="iconInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            FontAwesome Icon Class <span class="text-[#ff3b30]">*</span>
          </label>
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-slate-950 border border-slate-700 flex items-center justify-center text-[#ff3b30] text-xl shrink-0 shadow-inner" id="iconLivePreview">
              <i class="{{ old('icon', $service->icon) }}"></i>
            </div>
            <input type="text" id="iconInput" name="icon" value="{{ old('icon', $service->icon) }}" required
                   placeholder="fa-solid fa-code"
                   class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] font-mono text-xs">
          </div>

          <!-- Quick Icon Selector Chips -->
          <div class="pt-2">
            <p class="text-[11px] font-semibold text-slate-400 mb-1.5">Quick Icon Suggestions (Click to apply):</p>
            <div class="flex flex-wrap gap-1.5">
              @php
                $suggestedIcons = [
                  ['fa-solid fa-code', 'Code'],
                  ['fa-solid fa-mobile-screen-button', 'Mobile'],
                  ['fa-solid fa-magnifying-glass-chart', 'SEO'],
                  ['fa-solid fa-robot', 'AI'],
                  ['fa-solid fa-cloud', 'Cloud'],
                  ['fa-solid fa-cubes', 'Custom Dev'],
                  ['fa-solid fa-cart-shopping', 'E-commerce'],
                  ['fa-solid fa-palette', 'UI/UX'],
                  ['fa-solid fa-shield-halved', 'Security'],
                  ['fa-solid fa-bolt', 'Speed'],
                  ['fa-solid fa-network-wired', 'DevOps'],
                  ['fa-solid fa-chart-line', 'Growth'],
                  ['fa-solid fa-database', 'Data'],
                  ['fa-solid fa-check-double', 'QA'],
                ];
              @endphp
              @foreach($suggestedIcons as $icon)
                <button type="button" onclick="setIcon('{{ $icon[0] }}')"
                        class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 text-xs flex items-center gap-1.5 transition-colors">
                  <i class="{{ $icon[0] }} text-[11px] text-[#ff3b30]"></i>
                  <span>{{ $icon[1] }}</span>
                </button>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Tagline -->
        <div class="space-y-1.5 sm:col-span-2">
          <label for="taglineInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Tagline / Subheading
          </label>
          <input type="text" id="taglineInput" name="tagline" value="{{ old('tagline', $service->tagline) }}"
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm">
        </div>

        <!-- Short Description -->
        <div class="space-y-1.5 sm:col-span-2">
          <label for="shortDescInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Short Description
          </label>
          <textarea id="shortDescInput" name="short_description" rows="3"
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm leading-relaxed">{{ old('short_description', $service->short_description) }}</textarea>
        </div>

        <!-- Badge -->
        <div class="space-y-1.5">
          <label for="badgeInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Highlight Badge
          </label>
          <input type="text" id="badgeInput" name="badge" value="{{ old('badge', $service->badge) }}"
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm">
        </div>

        <!-- KPI Label & Value -->
        <div class="grid grid-cols-2 gap-3">
          <div class="space-y-1.5">
            <label for="kpiLabelInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
              KPI Label
            </label>
            <input type="text" id="kpiLabelInput" name="kpi_label" value="{{ old('kpi_label', $service->kpi_label) }}"
                   class="w-full px-3 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm">
          </div>
          <div class="space-y-1.5">
            <label for="kpiValueInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
              KPI Value
            </label>
            <input type="text" id="kpiValueInput" name="kpi_value" value="{{ old('kpi_value', $service->kpi_value) }}"
                   class="w-full px-3 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-500 focus:outline-none focus:border-[#ff3b30] text-sm font-mono text-emerald-400">
          </div>
        </div>
      </div>
    </div>

    <!-- SECTION 3: DYNAMIC FEATURES LIST -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white">3. Key Service Features</h3>
          <p class="text-xs text-slate-400">Bullet points highlighting capabilities and client deliverables.</p>
        </div>
        <button type="button" onclick="addFeatureRow()"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30 text-xs font-bold transition-colors">
          <i class="fas fa-plus"></i> Add Feature
        </button>
      </div>

      <div id="featuresContainer" class="space-y-2.5">
        @php
          $currentFeatures = old('features', $service->features ?? ['', '', '']);
          if(empty($currentFeatures)) $currentFeatures = [''];
        @endphp
        @foreach($currentFeatures as $fIndex => $feat)
          <div class="feature-row flex items-center gap-2">
            <span class="w-6 text-center text-slate-500 text-xs font-mono">{{ str_pad($fIndex + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <input type="text" name="features[]" value="{{ $feat }}"
                   placeholder="Key service feature capability..."
                   class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm">
            <button type="button" onclick="removeFeatureRow(this)"
                    class="p-2 text-slate-500 hover:text-red-400 transition-colors" title="Remove feature">
              <i class="fas fa-times"></i>
            </button>
          </div>
        @endforeach
      </div>
    </div>

    <!-- SECTION 4: DISPLAY SETTINGS & SORT ORDER -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white">4. Display Controls</h3>
          <p class="text-xs text-slate-400">Visibility, featured placement and ordering.</p>
        </div>
        <span class="w-7 h-7 rounded-lg bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-xs font-black">04</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Sort Order -->
        <div class="space-y-1.5">
          <label for="sortOrderInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Sort Order Priority
          </label>
          <input type="number" id="sortOrderInput" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0"
                 class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-[#ff3b30] text-sm font-mono">
          <p class="text-[11px] text-slate-500">Lower numbers appear first in lists.</p>
        </div>

        <!-- Is Active Toggle -->
        <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
          <div>
            <p class="text-xs font-bold text-white uppercase tracking-wider">Active Status</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Show on live site &amp; menus</p>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
          </label>
        </div>

        <!-- Is Featured Toggle -->
        <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
          <div>
            <p class="text-xs font-bold text-white uppercase tracking-wider">Featured Badge</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Highlight as top service</p>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
        </div>
      </div>
    </div>

    <!-- LIVE SEARCH RANKING & SEO AUDIT -->
    @include('admin.partials.seo_audit_card')

    <!-- SECTION 5: SEO & SERVICE DETAILS -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white flex items-center gap-2">
            <span>5. SEO Metadata &amp; Service Details</span>
            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Google SERP Ready</span>
          </h3>
          <p class="text-xs text-slate-400">Target high-intent search queries with customized meta tags and rich landing page content.</p>
        </div>
        <span class="w-7 h-7 rounded-lg bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-xs font-black">05</span>
      </div>

      <div class="space-y-4">
        <!-- Live Public URL Link -->
        <div class="p-3 rounded-xl bg-slate-950 border border-slate-800 flex items-center justify-between text-xs">
          <div class="flex items-center gap-2 text-slate-400">
            <i class="fas fa-link text-[#ff3b30]"></i>
            <span>Live URL:</span>
            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="text-white hover:text-[#ff3b30] underline font-mono">
              {{ route('services.show', $service->slug) }}
            </a>
          </div>
          <a href="{{ route('services.show', $service->slug) }}" target="_blank"
             class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-white font-bold text-[11px] flex items-center gap-1.5 transition-colors">
            <span>Visit Page</span> <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
          </a>
        </div>

        <!-- Meta Title -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between">
            <label for="metaTitleInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
              SEO Title Tag <span class="text-slate-500 font-normal lowercase">(Recommended: 50-60 chars)</span>
            </label>
            <span id="metaTitleCount" class="text-[11px] font-mono text-slate-500">{{ strlen($service->meta_title ?? '') }} / 60</span>
          </div>
          <input type="text" id="metaTitleInput" name="meta_title" value="{{ old('meta_title', $service->meta_title) }}"
                 placeholder="e.g. Next.js &amp; Custom Web Development Services | WebRanker"
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm">
          <p class="text-[11px] text-slate-500">Current synthesized fallback: <code class="text-slate-400">{{ $service->seo_title }}</code></p>
        </div>

        <!-- Meta Description -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between">
            <label for="metaDescInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
              SEO Meta Description <span class="text-slate-500 font-normal lowercase">(Recommended: 140-160 chars)</span>
            </label>
            <span id="metaDescCount" class="text-[11px] font-mono text-slate-500">{{ strlen($service->meta_description ?? '') }} / 160</span>
          </div>
          <textarea id="metaDescInput" name="meta_description" rows="2"
                    placeholder="High-intent snippet summarizing the service deliverables and ranking guarantees for search engine previews..."
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm leading-relaxed">{{ old('meta_description', $service->meta_description) }}</textarea>
        </div>

        <!-- Focus Keywords -->
        <div class="space-y-1.5">
          <label for="focusKeywordsInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Focus Keywords <span class="text-slate-500 font-normal lowercase">(Comma-separated search phrases)</span>
          </label>
          <input type="text" id="focusKeywordsInput" name="focus_keywords" value="{{ old('focus_keywords', $service->focus_keywords) }}"
                 placeholder="e.g. web development, Next.js developer, headless ecommerce, core web vitals"
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm">
        </div>

        <!-- Detailed Content / Service Details (Dual Mode: Visual & Source) -->
        <div class="space-y-3">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-1 border-b border-slate-800">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                Service Details &amp; Long-Form Strategy
              </label>
              <p class="text-[11px] text-slate-500">Provide comprehensive architectural methodologies, enterprise value propositions, and deliverables.</p>
            </div>

            <!-- Mode Tabs & Quick Actions -->
            <div class="flex items-center gap-2 flex-wrap">
              <!-- Editor Tabs -->
              <div class="inline-flex items-center p-1 bg-slate-950 rounded-xl border border-slate-800">
                <button type="button" id="tabServiceVisualBtn" onclick="switchServiceEditorTab('visual')"
                        class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-[#ff3b30] text-white shadow-sm cursor-pointer">
                  <i class="fas fa-pen-nib text-[10px]"></i>
                  <span>Visual Editor</span>
                </button>
                <button type="button" id="tabServiceSourceBtn" onclick="switchServiceEditorTab('source')"
                        class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 text-slate-400 hover:text-white hover:bg-slate-900 cursor-pointer">
                  <i class="fas fa-code text-[11px]"></i>
                  <span>Source &amp; HTML Code</span>
                </button>
              </div>

              <!-- Quick Action Buttons -->
              <button type="button" id="formatServiceHtmlBtn" onclick="formatServiceSourceHtml()" title="Beautify / Indent HTML Code"
                      class="hidden px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors flex items-center gap-1 cursor-pointer">
                <i class="fas fa-wand-magic-sparkles text-[11px] text-amber-400"></i>
                <span>Format HTML</span>
              </button>
              <button type="button" onclick="copyServiceSourceHtml()" title="Copy HTML"
                      class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors flex items-center gap-1 cursor-pointer">
                <i class="fas fa-copy text-[10px] text-[#ff3b30]"></i>
                <span>Copy</span>
              </button>
            </div>
          </div>

          <!-- Synchronized Hidden Master Textarea submitted with the form -->
          <textarea name="detailed_content" id="masterDetailedContentInput" class="hidden">{{ old('detailed_content', $service->detailed_content) }}</textarea>

          <!-- VISUAL TAB CONTAINER -->
          <div id="serviceVisualTabWrapper" class="space-y-2">
            <div class="rounded-xl overflow-hidden border border-slate-800 bg-slate-950">
              <textarea id="ckDetailedEditor">{{ old('detailed_content', $service->detailed_content) }}</textarea>
            </div>
            <p class="text-[11px] text-slate-500">Visual mode: Edit text, format headings (H2-H4), bullet points, blockquotes, tables, and hyperlinks.</p>
          </div>

          <!-- SOURCE CODE TAB CONTAINER -->
          <div id="serviceSourceTabWrapper" class="hidden space-y-2">
            <div class="relative rounded-xl overflow-hidden border border-slate-800 bg-[#030712]">
              <div class="flex items-center justify-between px-4 py-2 bg-slate-950/80 border-b border-slate-800 text-[11px] font-mono text-slate-400">
                <span class="flex items-center gap-2">
                  <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                  HTML5 Source Editor • Raw Markup Mode
                </span>
                <span id="serviceSourceCharCount">0 characters</span>
              </div>
              <textarea id="serviceSourceCodeInput" rows="16" spellcheck="false"
                        class="w-full px-4 py-3 bg-[#030712] text-amber-200 font-mono text-xs leading-relaxed focus:outline-none focus:ring-1 focus:ring-[#ff3b30] resize-y placeholder-slate-600"
                        placeholder="<!-- Write or paste any custom HTML, Tailwind components, SVG diagrams, or technical grids -->"></textarea>
            </div>
            <p class="text-[11px] text-slate-500">Source mode: Edit pure HTML tags, inline SVG, custom Tailwind grid classes, or embed external widgets.</p>
          </div>
        </div>

      </div>
    </div>

    <!-- SECTION 6: STRUCTURED DATA (FAQ & CUSTOM SCHEMA) -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-6 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white flex items-center gap-2">
            <span>6. JSON-LD Structured Data (FAQ &amp; Custom Schema)</span>
            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#ff3b30]/20 text-red-300 border border-[#ff3b30]/30">Rich Results</span>
          </h3>
          <p class="text-xs text-slate-400">Configure Google FAQ rich cards and custom Schema.org microdata for search engines and AI agents.</p>
        </div>
        <span class="w-7 h-7 rounded-lg bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-xs font-black">06</span>
      </div>

      <!-- 6.1 FAQ SCHEMA (FAQPage) -->
      <div class="p-5 rounded-xl bg-slate-950/70 border border-slate-800 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-800/80">
          <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-amber-400 flex items-center gap-2">
              <i class="fas fa-circle-question"></i>
              <span>1. FAQ Schema (Google FAQPage Structured Data)</span>
            </h4>
            <p class="text-[11px] text-slate-400 mt-0.5">Creates expandable Q&amp;A rich snippets under your search listings on Google.</p>
          </div>
          <button type="button" onclick="addFaqRow()"
                  class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition-colors inline-flex items-center gap-1.5 self-start sm:self-auto">
            <i class="fas fa-plus text-[10px]"></i> Add FAQ
          </button>
        </div>

        <div id="faqContainer" class="space-y-3">
          @php
            $currentFaqs = !empty($service->faqs) && is_array($service->faqs) && count($service->faqs) > 0
              ? $service->faqs
              : [['question' => '', 'answer' => '']];
          @endphp
          @foreach($currentFaqs as $faq)
            <div class="faq-item p-3.5 rounded-xl bg-slate-900 border border-slate-800 space-y-2">
              <div class="flex items-center justify-between gap-2">
                <input type="text" name="faq_questions[]" value="{{ $faq['question'] ?? '' }}"
                       placeholder="Question: e.g. What is the SLA guarantee for this service?"
                       class="w-full px-3 py-2 rounded-lg bg-slate-950 border border-slate-700 text-white placeholder-slate-600 text-xs focus:outline-none focus:border-[#ff3b30] font-semibold">
                <button type="button" onclick="removeFaqRow(this)" class="text-slate-500 hover:text-red-400 p-1" title="Remove question">
                  <i class="fas fa-times text-xs"></i>
                </button>
              </div>
              <textarea name="faq_answers[]" rows="2" placeholder="Answer: e.g. We guarantee 99.99% uptime with 24/7 incident response..."
                        class="w-full px-3 py-2 rounded-lg bg-slate-950 border border-slate-700 text-white placeholder-slate-600 text-xs focus:outline-none focus:border-[#ff3b30] leading-relaxed">{{ $faq['answer'] ?? '' }}</textarea>
            </div>
          @endforeach
        </div>
      </div>

      <!-- 6.2 CUSTOM SCHEMA (Raw JSON-LD) -->
      <div class="p-5 rounded-xl bg-slate-950/70 border border-slate-800 space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-800/80">
          <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-purple-400 flex items-center gap-2">
              <i class="fas fa-code"></i>
              <span>2. Custom Schema (Raw JSON-LD Structured Data)</span>
            </h4>
            <p class="text-[11px] text-slate-400 mt-0.5">Paste raw JSON-LD (e.g. SoftwareApplication, Product, HowTo). Will be automatically merged into header scripts.</p>
          </div>
          <div class="flex items-center gap-2">
            <span id="customSchemaBadge" class="hidden"></span>
            <button type="button" onclick="insertSampleSchema()"
                    class="px-2.5 py-1 rounded-lg bg-purple-500/10 hover:bg-purple-500/20 text-purple-300 border border-purple-500/20 text-xs font-bold transition-colors">
              <i class="fas fa-wand-magic-sparkles text-[10px]"></i> Insert Sample
            </button>
            <button type="button" onclick="formatCustomJson()"
                    class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors">
              <i class="fas fa-align-left text-[10px]"></i> Format JSON
            </button>
          </div>
        </div>

        <div class="space-y-1.5">
          <textarea id="customSchemaInput" name="custom_schema" rows="6" oninput="validateCustomJson()"
                    placeholder='{
  "@@context": "https://schema.org",
  "@@type": "SoftwareApplication",
  "name": "Custom Software Solution",
  "operatingSystem": "All Platforms"
}'
                    class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-emerald-400 placeholder-slate-600 focus:outline-none focus:border-purple-400 text-xs font-mono leading-relaxed">{{ old('custom_schema', $service->custom_schema) }}</textarea>
          <p class="text-[11px] text-slate-500">Do not include &lt;script&gt; tags; write pure JSON-LD markup. Validated in real-time.</p>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-between pt-2">
      <button type="button" onclick="confirmDeleteService()"
              class="px-4 py-2.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 font-bold text-xs border border-red-500/20 transition-colors flex items-center gap-2">
        <i class="fas fa-trash-can"></i> Delete Service
      </button>

      <div class="flex items-center gap-3">
        <a href="{{ route('admin.services.index') }}"
           class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition-colors">
          Cancel
        </a>
        <button type="submit"
                class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs shadow-lg shadow-red-500/30 transition-all flex items-center gap-2">
          <i class="fas fa-check"></i>
          <span>Save Changes</span>
        </button>
      </div>
    </div>
  </form>

  <!-- Separate Delete Form (avoids invalid HTML nested form submission) -->
  <form id="deleteServiceForm" method="POST" action="{{ route('admin.services.destroy', $service->id) }}" class="hidden">
    @csrf
    @method('DELETE')
  </form>

</div>

@push('admin_scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
  // Dynamic Category Management (Search, Checkboxes, Chips & Custom Category)
  const toggleBtn = document.getElementById('toggleNewCatBtn');
  const toggleLabel = document.getElementById('toggleCatLabel');
  const newCatGroup = document.getElementById('newCatGroup');
  const categoryNewInput = document.getElementById('categoryNewInput');
  const addCustomCatBtn = document.getElementById('addCustomCatBtn');
  const categorySearchInput = document.getElementById('categorySearchInput');
  const clearCatSearchBtn = document.getElementById('clearCatSearchBtn');
  const categoryGrid = document.getElementById('categoryGrid');
  const noCategoryMatch = document.getElementById('noCategoryMatch');
  const selectedCategoryChips = document.getElementById('selectedCategoryChips');
  const selectedCategoryCountBadge = document.getElementById('selectedCategoryCountBadge');

  // Toggle inline new category form
  toggleBtn.addEventListener('click', () => {
    if (newCatGroup.classList.contains('hidden')) {
      newCatGroup.classList.remove('hidden');
      categoryNewInput.focus();
      toggleLabel.textContent = '✕ Close New Category';
    } else {
      newCatGroup.classList.add('hidden');
      categoryNewInput.value = '';
      toggleLabel.textContent = '+ Create New Category';
    }
  });

  // Add custom category dynamically
  function addCustomCategory() {
    const name = (categoryNewInput.value || '').trim();
    if (!name) return;

    const existing = Array.from(categoryGrid.querySelectorAll('.category-checkbox'))
      .find(cb => cb.value.toLowerCase() === name.toLowerCase());

    if (existing) {
      existing.checked = true;
      existing.closest('.category-checkbox-item').classList.add('bg-amber-500/10', 'border-amber-500/40', 'text-white', 'font-semibold');
    } else {
      const label = document.createElement('label');
      label.className = 'category-checkbox-item flex items-center justify-between p-2.5 rounded-xl border transition-all cursor-pointer select-none text-xs bg-amber-500/10 border-amber-500/40 text-white font-semibold';
      label.setAttribute('data-name', name.toLowerCase());
      label.innerHTML = `
        <div class="flex items-center gap-2.5 overflow-hidden">
          <input type="checkbox" name="categories[]" value="${name}" class="category-checkbox rounded text-[#ff3b30] bg-slate-950 border-slate-700 focus:ring-0 focus:ring-offset-0 cursor-pointer" checked>
          <span class="truncate">${name}</span>
        </div>
        <i class="fas fa-sparkles text-[10px] text-amber-400"></i>
      `;
      categoryGrid.prepend(label);
      bindCheckbox(label.querySelector('.category-checkbox'));
    }

    categoryNewInput.value = '';
    newCatGroup.classList.add('hidden');
    toggleLabel.textContent = '+ Create New Category';
    updateCategoryState();
  }

  if (addCustomCatBtn) {
    addCustomCatBtn.addEventListener('click', addCustomCategory);
  }
  if (categoryNewInput) {
    categoryNewInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        addCustomCategory();
      }
    });
  }

  // Live Category Search Filter
  if (categorySearchInput) {
    categorySearchInput.addEventListener('input', () => {
      const q = categorySearchInput.value.toLowerCase().trim();
      clearCatSearchBtn.classList.toggle('hidden', !q);
      let matchCount = 0;
      categoryGrid.querySelectorAll('.category-checkbox-item').forEach(item => {
        const name = item.getAttribute('data-name') || '';
        const matches = name.includes(q);
        item.classList.toggle('hidden', !matches);
        if (matches) matchCount++;
      });
      noCategoryMatch.classList.toggle('hidden', matchCount > 0);
    });

    clearCatSearchBtn.addEventListener('click', () => {
      categorySearchInput.value = '';
      clearCatSearchBtn.classList.add('hidden');
      categoryGrid.querySelectorAll('.category-checkbox-item').forEach(item => item.classList.remove('hidden'));
      noCategoryMatch.classList.add('hidden');
      categorySearchInput.focus();
    });
  }

  // Update selected categories display
  function updateCategoryState() {
    const checkboxes = categoryGrid.querySelectorAll('.category-checkbox');
    const checked = Array.from(checkboxes).filter(cb => cb.checked);

    checkboxes.forEach(cb => {
      const parent = cb.closest('.category-checkbox-item');
      if (!parent) return;
      parent.classList.toggle('checked', cb.checked);
      if (cb.checked) {
        parent.classList.add('bg-amber-500/10', 'border-amber-500/40', 'text-white', 'font-semibold');
        parent.classList.remove('bg-slate-900/60', 'border-slate-800', 'text-slate-300');
      } else {
        parent.classList.remove('bg-amber-500/10', 'border-amber-500/40', 'text-white', 'font-semibold');
        parent.classList.add('bg-slate-900/60', 'border-slate-800', 'text-slate-300');
      }
    });

    selectedCategoryCountBadge.textContent = `${checked.length} Selected`;

    // Render chips
    selectedCategoryChips.innerHTML = '';
    if (checked.length === 0) {
      selectedCategoryChips.innerHTML = '<span class="text-[11px] text-slate-500 italic">No industry categories selected yet. Pick from list below.</span>';
    } else {
      checked.forEach(cb => {
        const chip = document.createElement('span');
        chip.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-500/15 text-amber-300 border border-amber-500/30';
        chip.innerHTML = `
          <span>${cb.value}</span>
          <button type="button" class="text-amber-400 hover:text-white transition-colors" title="Remove">&times;</button>
        `;
        chip.querySelector('button').addEventListener('click', () => {
          cb.checked = false;
          updateCategoryState();
        });
        selectedCategoryChips.appendChild(chip);
      });
    }
  }

  function bindCheckbox(cb) {
    cb.addEventListener('change', updateCategoryState);
  }

  categoryGrid.querySelectorAll('.category-checkbox').forEach(bindCheckbox);
  updateCategoryState();

  // Icon preview and setter
  const iconInput = document.getElementById('iconInput');
  const iconPreview = document.getElementById('iconLivePreview');

  function setIcon(iconClass) {
    iconInput.value = iconClass;
    iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
  }

  iconInput.addEventListener('input', () => {
    iconPreview.innerHTML = `<i class="${iconInput.value}"></i>`;
  });

  // Dynamic Features List Repeater
  function addFeatureRow() {
    const container = document.getElementById('featuresContainer');
    const count = container.querySelectorAll('.feature-row').length + 1;
    const div = document.createElement('div');
    div.className = 'feature-row flex items-center gap-2';
    div.innerHTML = `
      <span class="w-6 text-center text-slate-500 text-xs font-mono">${String(count).padStart(2, '0')}</span>
      <input type="text" name="features[]" placeholder="Key service feature capability..."
             class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm">
      <button type="button" onclick="removeFeatureRow(this)"
              class="p-2 text-slate-500 hover:text-red-400 transition-colors" title="Remove feature">
        <i class="fas fa-times"></i>
      </button>
    `;
    container.appendChild(div);
  }

  function removeFeatureRow(btn) {
    const row = btn.closest('.feature-row');
    const container = document.getElementById('featuresContainer');
    if (container.querySelectorAll('.feature-row').length > 1) {
      row.remove();
      // re-index numbers
      container.querySelectorAll('.feature-row').forEach((r, idx) => {
        r.querySelector('span').textContent = String(idx + 1).padStart(2, '0');
      });
    } else {
      row.querySelector('input').value = '';
    }
  }

  // FAQ Repeater
  function addFaqRow() {
    const container = document.getElementById('faqContainer');
    const div = document.createElement('div');
    div.className = 'faq-item p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-2';
    div.innerHTML = `
      <div class="flex items-center justify-between gap-2">
        <input type="text" name="faq_questions[]" placeholder="Question: e.g. How long does implementation take?"
               class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white placeholder-slate-600 text-xs focus:outline-none focus:border-[#ff3b30] font-semibold">
        <button type="button" onclick="removeFaqRow(this)" class="text-slate-500 hover:text-red-400 p-1">
          <i class="fas fa-times text-xs"></i>
        </button>
      </div>
      <textarea name="faq_answers[]" rows="2" placeholder="Answer: e.g. Typically 2 to 4 weeks depending on scope..."
                class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white placeholder-slate-600 text-xs focus:outline-none focus:border-[#ff3b30]"></textarea>
    `;
    container.appendChild(div);
  }

  function removeFaqRow(btn) {
    const item = btn.closest('.faq-item');
    const container = document.getElementById('faqContainer');
    if (container.querySelectorAll('.faq-item').length > 1) {
      item.remove();
    } else {
      item.querySelectorAll('input, textarea').forEach(el => el.value = '');
    }
  }

  // Meta character counters
  const metaTitleInput = document.getElementById('metaTitleInput');
  const metaTitleCount = document.getElementById('metaTitleCount');
  if (metaTitleInput && metaTitleCount) {
    metaTitleInput.addEventListener('input', () => {
      metaTitleCount.textContent = `${metaTitleInput.value.length} / 60`;
    });
  }

  const metaDescInput = document.getElementById('metaDescInput');
  const metaDescCount = document.getElementById('metaDescCount');
  if (metaDescInput && metaDescCount) {
    metaDescInput.addEventListener('input', () => {
      metaDescCount.textContent = `${metaDescInput.value.length} / 160`;
    });
  }


  // Service Dual Editor (Visual & Source)
  let classicEditorInstance = null;
  let currentServiceEditorTab = 'visual';

  const serviceSourceInput = document.getElementById('serviceSourceCodeInput');
  const serviceMasterInput = document.getElementById('masterDetailedContentInput');

  if (serviceSourceInput) {
    serviceSourceInput.value = serviceMasterInput?.value || '';
    updateServiceSourceCharCount();
    serviceSourceInput.addEventListener('input', () => {
      updateServiceSourceCharCount();
      if (currentServiceEditorTab === 'source' && serviceMasterInput) {
        serviceMasterInput.value = serviceSourceInput.value;
      }
    });
  }

  function updateServiceSourceCharCount() {
    const countEl = document.getElementById('serviceSourceCharCount');
    if (countEl && serviceSourceInput) {
      countEl.textContent = `${serviceSourceInput.value.length.toLocaleString()} characters`;
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
          if (currentServiceEditorTab === 'visual' && serviceMasterInput) {
            serviceMasterInput.value = editor.getData();
          }
        });
      })
      .catch(error => {
        console.error('Classic Editor failed to initialize:', error);
      });
  }

  function switchServiceEditorTab(mode) {
    const visualWrapper = document.getElementById('serviceVisualTabWrapper');
    const sourceWrapper = document.getElementById('serviceSourceTabWrapper');
    const tabVisualBtn = document.getElementById('tabServiceVisualBtn');
    const tabSourceBtn = document.getElementById('tabServiceSourceBtn');
    const formatHtmlBtn = document.getElementById('formatServiceHtmlBtn');

    if (mode === 'source') {
      currentServiceEditorTab = 'source';
      if (classicEditorInstance && serviceSourceInput) {
        serviceSourceInput.value = classicEditorInstance.getData();
      }
      if (serviceMasterInput && serviceSourceInput) {
        serviceMasterInput.value = serviceSourceInput.value;
      }
      updateServiceSourceCharCount();

      visualWrapper.classList.add('hidden');
      sourceWrapper.classList.remove('hidden');
      formatHtmlBtn.classList.remove('hidden');

      tabVisualBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 text-slate-400 hover:text-white hover:bg-slate-900 cursor-pointer';
      tabSourceBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-[#ff3b30] text-white shadow-sm cursor-pointer';
    } else {
      currentServiceEditorTab = 'visual';
      if (classicEditorInstance && serviceSourceInput) {
        classicEditorInstance.setData(serviceSourceInput.value);
      }
      if (serviceMasterInput && serviceSourceInput) {
        serviceMasterInput.value = serviceSourceInput.value;
      }

      sourceWrapper.classList.add('hidden');
      visualWrapper.classList.remove('hidden');
      formatHtmlBtn.classList.add('hidden');

      tabSourceBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 text-slate-400 hover:text-white hover:bg-slate-900 cursor-pointer';
      tabVisualBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-[#ff3b30] text-white shadow-sm cursor-pointer';
    }
  }

  function formatServiceSourceHtml() {
    if (!serviceSourceInput || !serviceSourceInput.value.trim()) return;
    let html = serviceSourceInput.value.trim();
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
        if (trimmed) formatted += tab.repeat(indent) + trimmed + '\n';
      }
    });

    serviceSourceInput.value = formatted.trim();
    updateServiceSourceCharCount();
  }

  function copyServiceSourceHtml() {
    const content = currentServiceEditorTab === 'visual' && classicEditorInstance ? classicEditorInstance.getData() : (serviceSourceInput?.value || '');
    navigator.clipboard.writeText(content).then(() => {
      alert('HTML markup copied to clipboard!');
    }).catch(() => {
      if (serviceSourceInput) {
        serviceSourceInput.select();
        document.execCommand('copy');
      }
      alert('HTML markup copied to clipboard!');
    });
  }

  // Hook into form submit to guarantee sync
  const serviceEditForm = document.querySelector('form');
  if (serviceEditForm) {
    serviceEditForm.addEventListener('submit', () => {
      if (serviceMasterInput) {
        if (currentServiceEditorTab === 'source' && serviceSourceInput) {
          serviceMasterInput.value = serviceSourceInput.value;
        } else if (classicEditorInstance) {
          serviceMasterInput.value = classicEditorInstance.getData();
        }
      }
    });
  }

  function insertSampleSchema() {
    const serviceTitle = document.getElementById('titleInput')?.value || "Custom Enterprise Solution";
    const atContext = '@' + 'context';
    const atType = '@' + 'type';
    const sample = {
      [atContext]: "https://schema.org",
      [atType]: "SoftwareApplication",
      "name": serviceTitle,
      "operatingSystem": "All modern web browsers, Cloud",
      "applicationCategory": "BusinessApplication",
      "offers": {
        [atType]: "Offer",
        "price": "0",
        "priceCurrency": "USD"
      }
    };
    const textarea = document.getElementById('customSchemaInput');
    if (textarea) {
      textarea.value = JSON.stringify(sample, null, 2);
      validateCustomJson();
    }
  }

  function formatCustomJson() {
    const textarea = document.getElementById('customSchemaInput');
    if (!textarea || !textarea.value.trim()) return;
    try {
      const parsed = JSON.parse(textarea.value.trim());
      textarea.value = JSON.stringify(parsed, null, 2);
      validateCustomJson();
    } catch(err) {
      validateCustomJson();
    }
  }

  function validateCustomJson() {
    const textarea = document.getElementById('customSchemaInput');
    const badge = document.getElementById('customSchemaBadge');
    if (!textarea || !badge) return;
    const val = textarea.value.trim();
    if (!val) {
      badge.className = 'hidden';
      badge.textContent = '';
      return;
    }
    try {
      JSON.parse(val);
      badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
      badge.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Valid JSON-LD';
    } catch (e) {
      badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-red-500/20 text-red-300 border border-red-500/30';
      badge.innerHTML = '<i class="fas fa-triangle-exclamation mr-1"></i> Invalid JSON';
    }
  }

  // Validate on load if custom schema already contains value
  if (document.getElementById('customSchemaInput')?.value.trim()) {
    validateCustomJson();
  }

  // Safe external form submission for delete
  function confirmDeleteService() {
    if (confirm("Are you sure you want to permanently delete '{{ addslashes($service->title) }}'? This action cannot be undone.")) {
      document.getElementById('deleteServiceForm').submit();
    }
  }
</script>
@endpush

@push('admin_styles')
<style>
  .ck.ck-editor {
    width: 100% !important;
  }
  .ck.ck-editor__main > .ck-editor__editable {
    min-height: 250px !important;
    max-height: 380px !important;
    overflow-y: auto !important;
    border-bottom-left-radius: 0.75rem !important;
    border-bottom-right-radius: 0.75rem !important;
    font-size: 0.875rem !important;
    line-height: 1.6 !important;
    scrollbar-width: thin !important;
  }
  .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar {
    width: 8px !important;
  }
  .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-track {
    border-bottom-right-radius: 0.75rem !important;
  }
  .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-thumb {
    border-radius: 4px !important;
  }
  .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-thumb:hover {
    background-color: #ff3b30 !important;
  }
  #serviceSourceCodeInput {
    height: 380px !important;
    min-height: 250px !important;
    max-height: 480px !important;
    overflow-y: auto !important;
    scrollbar-width: thin !important;
    scrollbar-color: #ff3b30 #030712 !important;
  }
  #serviceSourceCodeInput::-webkit-scrollbar {
    width: 8px !important;
  }
  #serviceSourceCodeInput::-webkit-scrollbar-track {
    background: #030712 !important;
    border-bottom-right-radius: 0.75rem !important;
  }
  #serviceSourceCodeInput::-webkit-scrollbar-thumb {
    background-color: #334155 !important;
    border-radius: 4px !important;
  }
  #serviceSourceCodeInput::-webkit-scrollbar-thumb:hover {
    background-color: #ff3b30 !important;
  }
  #detailedContentInput {
    max-height: 380px !important;
    overflow-y: auto !important;
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

  /* Link Styling inside Editor - Theme Red (#ff3b30) */
  .ck-content a,
  .ck.ck-editor__main .ck-content a {
    color: #ff3b30 !important;
    text-decoration: underline !important;
    text-decoration-color: rgba(255, 59, 48, 0.6) !important;
    text-underline-offset: 3px !important;
    font-weight: 700 !important;
    cursor: pointer !important;
  }
  .ck-content a:hover,
  .ck.ck-editor__main .ck-content a:hover {
    color: #dc2626 !important;
    text-decoration-color: #dc2626 !important;
  }
  .ck.ck-balloon-panel a.ck-link-actions__preview {
    color: #ff3b30 !important;
    text-decoration: underline !important;
    font-weight: 700 !important;
  }

  /* Dark Theme Specific (when not in light mode) */
  html:not(.theme-light) .ck.ck-editor__main > .ck-editor__editable {
    background-color: #020617 !important;
    color: #e2e8f0 !important;
    border-color: #334155 !important;
    scrollbar-color: #ff3b30 #0f172a !important;
  }
  html:not(.theme-light) .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-track {
    background: #0f172a !important;
  }
  html:not(.theme-light) .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-thumb {
    background-color: #334155 !important;
  }
  html:not(.theme-light) .ck.ck-toolbar {
    background-color: #0f172a !important;
    border-color: #334155 !important;
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
    background-color: #0f172a !important;
    border-color: #334155 !important;
  }
  html:not(.theme-light) .ck.ck-list__item .ck-button {
    color: #cbd5e1 !important;
  }
  html:not(.theme-light) .ck.ck-list__item .ck-button:hover {
    background-color: #1e293b !important;
    color: #ffffff !important;
  }
  html:not(.theme-light) .ck.ck-toolbar .ck-toolbar__separator {
    background-color: #334155 !important;
  }
  html:not(.theme-light) .ck.ck-balloon-panel {
    background-color: #0f172a !important;
    border-color: #334155 !important;
    color: #ffffff !important;
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
  html.theme-light .ck.ck-toolbar .ck-toolbar__separator {
    background-color: #e2e8f0 !important;
  }
  html.theme-light .ck.ck-button {
    color: #475569 !important;
  }
  html.theme-light .ck.ck-button:hover,
  html.theme-light .ck.ck-button.ck-on {
    background-color: #e2e8f0 !important;
    color: #0f172a !important;
  }
  html.theme-light .ck.ck-dropdown__panel {
    background-color: #ffffff !important;
    border-color: #cbd5e1 !important;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1) !important;
  }
  html.theme-light .ck.ck-list__item .ck-button {
    color: #334155 !important;
  }
  html.theme-light .ck.ck-list__item .ck-button:hover {
    background-color: #f1f5f9 !important;
    color: #0f172a !important;
  }
  html.theme-light .ck.ck-balloon-panel {
    background-color: #ffffff !important;
    border-color: #cbd5e1 !important;
    color: #0f172a !important;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1) !important;
  }
  html.theme-light .ck.ck-balloon-panel .ck-button {
    color: #475569 !important;
  }
  html.theme-light .ck.ck-balloon-panel .ck-button:hover {
    background-color: #f1f5f9 !important;
    color: #0f172a !important;
  }
  html.theme-light .ck.ck-labeled-field-view > .ck-input {
    background-color: #f8fafc !important;
    color: #0f172a !important;
    border-color: #cbd5e1 !important;
  }
</style>
@endpush
@endsection
