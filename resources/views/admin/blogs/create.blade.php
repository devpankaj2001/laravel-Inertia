@extends('admin.layouts.admin')

@section('title', 'Create Blog Article')

@section('content')
<div class="space-y-6 max-w-5xl">

  <!-- Header -->
  <div class="flex items-center justify-between pb-4 border-b border-slate-800">
    <div class="space-y-1">
      <div class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ route('admin.blogs.index') }}" class="hover:text-white transition-colors">Blogs</a>
        <span>/</span>
        <span class="text-[#ff3b30] font-bold">New Article</span>
      </div>
      <h1 class="text-2xl font-black text-white tracking-tight">Create Technical Article</h1>
    </div>
    <a href="{{ route('admin.blogs.index') }}"
       class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors">
      <i class="fas fa-arrow-left"></i>
      <span>Back to Catalog</span>
    </a>
  </div>

  @if(isset($errors) && $errors->any())
    <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs space-y-1">
      <p class="font-bold flex items-center gap-1.5">
        <i class="fas fa-triangle-exclamation"></i>
        <span>Please resolve the following errors:</span>
      </p>
      <ul class="list-disc pl-5 space-y-0.5">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- SECTION 1: CORE ARTICLE METADATA -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white">1. Article Identity</h3>
          <p class="text-xs text-slate-400">Headline, slug URL, and summary deck.</p>
        </div>
        <span class="w-7 h-7 rounded-lg bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-xs font-black">01</span>
      </div>

      <div class="space-y-4">
        <!-- Title -->
        <div class="space-y-1.5">
          <label for="titleInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Article Title <span class="text-[#ff3b30]">*</span>
          </label>
          <input type="text" id="titleInput" name="title" value="{{ old('title') }}" required
                 placeholder="e.g. Data Engineering Patterns for ML Feature Stores"
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm font-semibold">
        </div>

        <!-- Slug -->
        <div class="space-y-1.5">
          <label for="slugInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            URL Slug <span class="text-[#ff3b30]">*</span>
          </label>
          <div class="flex items-center gap-2">
            <span class="px-3 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-slate-500 text-xs font-mono">
              /blog/
            </span>
            <input type="text" id="slugInput" name="slug" value="{{ old('slug') }}" required
                   placeholder="data-engineering-ml-feature-stores"
                   class="flex-1 px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm font-mono">
          </div>
        </div>

        <!-- Excerpt / Deck -->
        <div class="space-y-1.5">
          <label for="excerptInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Short Summary / Deck <span class="text-[#ff3b30]">*</span>
          </label>
          <textarea id="excerptInput" name="excerpt" rows="2" required
                    placeholder="Batch vs streaming features, consistency between training and serving, and tooling that scales with your models..."
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm leading-relaxed">{{ old('excerpt') }}</textarea>
          <p class="text-[11px] text-slate-500">Displayed in article cards and single article hero subtitles.</p>
        </div>
      </div>
    </div>

    <!-- SECTION 2: CATEGORY, TAGS & AUTHOR -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white">2. Categorization &amp; Author</h3>
          <p class="text-xs text-slate-400">Target audience topics, tag labels, and author attribution.</p>
        </div>
        <span class="w-7 h-7 rounded-lg bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-xs font-black">02</span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Category Selector / Custom input -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300">
              Primary Category <span class="text-[#ff3b30]">*</span>
            </label>
            <button type="button" id="toggleNewCatBtn" class="text-[11px] text-[#ff3b30] hover:underline font-semibold">
              <span id="toggleCatLabel">+ Create New Category</span>
            </button>
          </div>

          <div id="existingCatGroup">
            <select id="categorySelect" name="category"
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-[#ff3b30] text-sm">
              @php
                $defaultCats = ['E-Commerce', 'FinTech', 'Healthcare', 'Real Estate', 'Logistics', 'Automotive', 'Legal', 'Insurance', 'Education', 'Travel & Hospitality', 'Technical SEO'];
              @endphp
              @foreach($defaultCats as $cat)
                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
              @endforeach
              @foreach($categories as $cat)
                @if(!in_array($cat, $defaultCats))
                  <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endif
              @endforeach
            </select>
          </div>

          <div id="newCatGroup" class="hidden">
            <input type="text" id="categoryNewInput" name="category_new" value="{{ old('category_new') }}"
                   placeholder="e.g. Cyber Security, Robotics"
                   class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-[#ff3b30] text-white placeholder-slate-600 focus:outline-none text-sm">
          </div>
        </div>

        <!-- Tags Input -->
        <div class="space-y-1.5">
          <label for="tagsInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Sub-Tags <span class="text-slate-500 font-normal lowercase">(comma-separated)</span>
          </label>
          <input type="text" id="tagsInput" name="tags" value="{{ old('tags', 'E-Commerce, Headless SEO') }}"
                 placeholder="e.g. E-Commerce, SEO, Core Web Vitals"
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm">
        </div>

        <!-- Author Name (Always Logged-in User) -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between">
            <label for="authorNameInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
              Author Name <span class="text-[#ff3b30]">*</span>
            </label>
            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
              <i class="fas fa-user-check mr-1"></i> Logged In User
            </span>
          </div>
          <div class="relative">
            <input type="text" id="authorNameInput" name="author_name"
                   value="{{ old('author_name', auth()->user()->name ?? 'Admin') }}" required readonly
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-950/70 border border-slate-800 text-slate-200 focus:outline-none text-sm font-semibold cursor-not-allowed">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-blue-400">
              <i class="fas fa-shield-alt text-xs"></i>
            </div>
          </div>
          <p class="text-[11px] text-slate-500">Automatically linked to current logged-in user ({{ auth()->user()->name ?? 'Admin' }}).</p>
        </div>

        <!-- Author Role -->
        <div class="space-y-1.5">
          <label for="authorRoleInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Author Job Role
          </label>
          <input type="text" id="authorRoleInput" name="author_role" value="{{ old('author_role', 'Technical Specialist') }}"
                 placeholder="e.g. Principal AI Architect"
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white focus:outline-none focus:border-[#ff3b30] text-sm">
        </div>

        <!-- Estimated Reading Time (Auto-calculated) -->
        <div class="space-y-1.5">
          <div class="flex items-center justify-between">
            <label for="readTimeInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
              Estimated Reading Time
            </label>
            <span id="wordCountBadge" class="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-mono">
              <i class="fas fa-calculator mr-1"></i> Auto-computed
            </span>
          </div>
          <div class="relative">
            <input type="text" id="readTimeInput" name="read_time" value="{{ old('read_time', '1 min read') }}" readonly
                   placeholder="1 min read"
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-950/70 border border-slate-800 text-slate-200 focus:outline-none text-sm font-mono cursor-not-allowed">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-400">
              <i class="fas fa-clock text-xs"></i>
            </div>
          </div>
          <p id="readTimeHint" class="text-[11px] text-slate-500">Auto-calculated based on content word count (~200 words/min).</p>
        </div>

        <!-- Cover Image Upload & Live Preview -->
        <div class="space-y-3 md:col-span-2 p-4 rounded-xl bg-slate-950 border border-slate-800/80">
          <div class="flex items-center justify-between">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-white">
                Cover Image <span class="text-[#ff3b30]">*</span>
              </label>
              <p class="text-[11px] text-slate-400">Upload an image file from your device or specify an existing asset path/URL.</p>
            </div>
            <span class="text-[10px] text-slate-500">Supports: PNG, JPG, WEBP, SVG (Max 5MB)</span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center pt-1">
            <!-- Live Preview Card -->
            <div class="sm:col-span-1">
              <div class="relative aspect-video rounded-xl overflow-hidden border border-slate-800 bg-slate-900 flex items-center justify-center shadow-inner group">
                <img id="coverPreviewImg" src="{{ asset('asset/blog_icon_bg.png') }}" alt="Cover Preview" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold pointer-events-none">
                  Live Preview
                </div>
              </div>
            </div>

            <!-- Upload File Input + Fallback URL -->
            <div class="sm:col-span-2 space-y-3">
              <div>
                <label for="coverFileInput" class="block text-xs font-semibold text-slate-300 mb-1">
                  <i class="fas fa-upload text-[#ff3b30] mr-1"></i> Upload Image File
                </label>
                <input type="file" id="coverFileInput" name="featured_image_file" accept="image/*"
                       class="block w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-500/10 file:text-[#ff3b30] hover:file:bg-red-500/20 file:cursor-pointer border border-slate-800 rounded-xl bg-slate-900 cursor-pointer">
              </div>

              <div>
                <label for="imageInput" class="block text-[11px] font-semibold text-slate-400 mb-1">
                  Or Existing File Path / Web URL
                </label>
                <input type="text" id="imageInput" name="featured_image" value="{{ old('featured_image', 'asset/blog-data-engineering.jpg') }}"
                       placeholder="e.g. asset/blog-data-engineering.jpg or https://..."
                       class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-white focus:outline-none focus:border-[#ff3b30] text-xs font-mono">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- SECTION 3: ARTICLE CONTENT (DUAL MODE: VISUAL & SOURCE WITH SCROLL) -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-800 gap-3">
        <div>
          <h3 class="text-base font-extrabold text-white flex items-center gap-2">
            <span>3. Article Body Content</span>
          </h3>
          <p class="text-xs text-slate-400">Write structured content with headings, lists, quotes, tables, and code snippets.</p>
        </div>

        <!-- Mode Tabs & Quick Actions -->
        <div class="flex items-center gap-2 flex-wrap">
          <!-- Editor Tabs -->
          <div class="inline-flex items-center p-1 bg-slate-950 rounded-xl border border-slate-800">
            <button type="button" id="tabBlogVisualBtn" onclick="switchBlogEditorTab('visual')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-[#ff3b30] text-white shadow-sm cursor-pointer">
              <i class="fas fa-pen-nib text-[10px]"></i>
              <span>Visual Editor</span>
            </button>
            <button type="button" id="tabBlogSourceBtn" onclick="switchBlogEditorTab('source')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 text-slate-400 hover:text-white hover:bg-slate-900 cursor-pointer">
              <i class="fas fa-code text-[11px]"></i>
              <span>Source &amp; HTML Code</span>
            </button>
          </div>

          <!-- Quick Action Buttons -->
          <button type="button" id="formatBlogHtmlBtn" onclick="formatBlogSourceHtml()" title="Beautify / Indent HTML Code"
                  class="hidden px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors flex items-center gap-1 cursor-pointer">
            <i class="fas fa-wand-magic-sparkles text-[11px] text-amber-400"></i>
            <span>Format HTML</span>
          </button>
          <button type="button" onclick="copyBlogSourceHtml()" title="Copy HTML"
                  class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-colors flex items-center gap-1 cursor-pointer">
            <i class="fas fa-copy text-[10px] text-[#ff3b30]"></i>
            <span>Copy</span>
          </button>
        </div>
      </div>

      <!-- Synchronized Hidden Master Textarea submitted with the form -->
      <textarea name="content" id="masterBlogContentInput" class="hidden">{{ old('content') }}</textarea>

      <!-- VISUAL TAB CONTAINER -->
      <div id="blogVisualTabWrapper" class="space-y-2">
        <div class="rounded-xl overflow-hidden border border-slate-800 bg-slate-950">
          <textarea id="ckBlogEditor">{{ old('content') }}</textarea>
        </div>
        <p class="text-[11px] text-slate-500">
          Visual mode: Use H3 headings (e.g. &lt;h3 id="anchor"&gt;) to automatically populate the "On this page" table of contents sidebar!
        </p>
      </div>

      <!-- SOURCE CODE TAB CONTAINER -->
      <div id="blogSourceTabWrapper" class="hidden space-y-2">
        <div class="relative rounded-xl overflow-hidden border border-slate-800 bg-[#030712]">
          <div class="flex items-center justify-between px-4 py-2 bg-slate-950/80 border-b border-slate-800 text-[11px] font-mono text-slate-400">
            <span class="flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
              HTML5 Source Editor • Raw Markup Mode
            </span>
            <span id="blogSourceCharCount">0 characters</span>
          </div>
          <textarea id="blogSourceCodeInput" rows="16" spellcheck="false"
                    class="w-full px-4 py-3 bg-[#030712] text-amber-200 font-mono text-xs leading-relaxed focus:outline-none focus:ring-1 focus:ring-[#ff3b30] resize-y placeholder-slate-600"
                    placeholder="<!-- Write or paste any custom HTML, article structure, or embedded rich widgets -->"></textarea>
        </div>
        <p class="text-[11px] text-slate-500">Source mode: Edit pure HTML tags, figures, custom callout boxes, or embed external media.</p>
      </div>
    </div>

    <!-- SECTION 4: PUBLISHING, SCHEDULING & FEATURED CONTROLS -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white">4. Visibility &amp; Publishing Schedule</h3>
          <p class="text-xs text-slate-400">Set instant publishing or schedule for a future date &amp; time.</p>
        </div>
        <span class="w-7 h-7 rounded-lg bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-xs font-black">04</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Publish Status Switch -->
        <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
          <div>
            <p class="text-xs font-bold text-white uppercase tracking-wider">Publish Toggle</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Draft vs Live/Scheduled</p>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_published" id="isPublishedToggle" value="1" class="sr-only peer" {{ old('is_published', '1') == '1' ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
          </label>
        </div>

        <!-- Scheduled Publish Date/Time Picker -->
        <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 space-y-2">
          <div class="flex items-center justify-between">
            <label for="publishedAtInput" class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-1.5">
              <i class="fas fa-calendar-alt text-[#ff3b30]"></i>
              <span>Schedule Date/Time</span>
            </label>
            <span id="scheduleStatusBadge" class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-slate-400">Immediate</span>
          </div>
          <input type="datetime-local" id="publishedAtInput" name="published_at" value="{{ old('published_at') }}"
                 class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-white focus:outline-none focus:border-[#ff3b30] text-xs font-mono">
          <p class="text-[10px] text-slate-500">Future date automatically hides post from frontend until that time.</p>
        </div>

        <!-- Featured Badge -->
        <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
          <div>
            <p class="text-xs font-bold text-white uppercase tracking-wider">Featured Insight</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Top spotlight carousel</p>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured') ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
          </label>
        </div>
      </div>
    </div>

    <!-- LIVE SEARCH RANKING & SEO AUDIT -->
    @include('admin.partials.seo_audit_card')

    <!-- SECTION 5: SEO & STRUCTURED DATA -->
    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-5 shadow-xl">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-extrabold text-white flex items-center gap-2">
            <span>5. SEO Metadata &amp; FAQ Schema</span>
            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">SERP Ready</span>
          </h3>
          <p class="text-xs text-slate-400">Meta tags and FAQ rich snippet markup for Google search rankings.</p>
        </div>
        <span class="w-7 h-7 rounded-lg bg-red-500/10 text-[#ff3b30] flex items-center justify-center text-xs font-black">05</span>
      </div>

      <div class="space-y-4">
        <!-- Meta Title -->
        <div class="space-y-1.5">
          <label for="metaTitleInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            SEO Title Tag <span class="text-slate-500 lowercase">(Recommended: 50-60 chars)</span>
          </label>
          <input type="text" id="metaTitleInput" name="meta_title" value="{{ old('meta_title') }}"
                 placeholder="e.g. Data Engineering Patterns for ML Feature Stores | WebRanker AI"
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm">
        </div>

        <!-- Meta Description -->
        <div class="space-y-1.5">
          <label for="metaDescInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            SEO Meta Description <span class="text-slate-500 lowercase">(Recommended: 140-160 chars)</span>
          </label>
          <textarea id="metaDescInput" name="meta_description" rows="2"
                    placeholder="High-intent snippet summarizing the article for Google search previews..."
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm leading-relaxed">{{ old('meta_description') }}</textarea>
        </div>

        <!-- Focus Keywords -->
        <div class="space-y-1.5">
          <label for="keywordsInput" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
            Focus Keywords <span class="text-slate-500 lowercase">(comma-separated)</span>
          </label>
          <input type="text" id="keywordsInput" name="focus_keywords" value="{{ old('focus_keywords') }}"
                 placeholder="e.g. laravel web development, next.js ranking, fintech seo, technical audit"
                 class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:outline-none focus:border-[#ff3b30] text-sm">
        </div>

        <!-- FAQ Schema Repeater -->
        <div class="p-5 rounded-xl bg-slate-950/70 border border-slate-800 space-y-4 pt-4">
          <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <div>
              <h4 class="text-xs font-bold uppercase tracking-wider text-amber-400 flex items-center gap-2">
                <i class="fas fa-circle-question"></i>
                <span>FAQ Schema (Google FAQPage Structured Data)</span>
              </h4>
              <p class="text-[11px] text-slate-400 mt-0.5">Creates expandable Q&amp;A rich snippets on Google search listings.</p>
            </div>
            <button type="button" onclick="addFaqRow()"
                    class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition-colors inline-flex items-center gap-1.5">
              <i class="fas fa-plus text-[10px]"></i> Add FAQ
            </button>
          </div>

          <div id="faqContainer" class="space-y-3">
            <div class="faq-item p-3.5 rounded-xl bg-slate-900 border border-slate-800 space-y-2">
              <div class="flex items-center justify-between gap-2">
                <input type="text" name="faq_questions[]" placeholder="Question: e.g. What is training-serving skew in ML feature stores?"
                       class="w-full px-3 py-2 rounded-lg bg-slate-950 border border-slate-700 text-white placeholder-slate-600 text-xs focus:outline-none focus:border-[#ff3b30] font-semibold">
                <button type="button" onclick="removeFaqRow(this)" class="text-slate-500 hover:text-red-400 p-1" title="Remove question">
                  <i class="fas fa-times text-xs"></i>
                </button>
              </div>
              <textarea name="faq_answers[]" rows="2" placeholder="Answer: e.g. Training-serving skew occurs when feature definitions differ between offline training and online inference..."
                        class="w-full px-3 py-2 rounded-lg bg-slate-950 border border-slate-700 text-white placeholder-slate-600 text-xs focus:outline-none focus:border-[#ff3b30] leading-relaxed"></textarea>
            </div>
          </div>
        </div>

        <!-- Custom Schema Raw JSON-LD -->
        <div class="p-5 rounded-xl bg-slate-950/70 border border-slate-800 space-y-3">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-800">
            <div>
              <h4 class="text-xs font-bold uppercase tracking-wider text-purple-400 flex items-center gap-2">
                <i class="fas fa-code"></i>
                <span>Custom Schema (Raw JSON-LD)</span>
              </h4>
              <p class="text-[11px] text-slate-400 mt-0.5">Paste raw JSON-LD markup to merge into header scripts.</p>
            </div>
            <div class="flex items-center gap-2">
              <span id="customSchemaBadge" class="hidden"></span>
              <button type="button" onclick="insertSampleSchema()"
                      class="px-2.5 py-1 rounded-lg bg-purple-500/10 hover:bg-purple-500/20 text-purple-300 border border-purple-500/20 text-xs font-bold transition-colors">
                <i class="fas fa-wand-magic-sparkles text-[10px]"></i> Insert Sample
              </button>
            </div>
          </div>

          <textarea id="customSchemaInput" name="custom_schema" rows="5" oninput="validateCustomJson()"
                    placeholder='{
  "@@context": "https://schema.org",
  "@@type": "BlogPosting",
  "headline": "Data Engineering Patterns for ML Feature Stores"
}'
                    class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-emerald-400 placeholder-slate-600 focus:outline-none focus:border-purple-400 text-xs font-mono leading-relaxed">{{ old('custom_schema') }}</textarea>
        </div>

      </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 pt-2">
      <a href="{{ route('admin.blogs.index') }}"
         class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition-colors">
        Cancel
      </a>
      <button type="submit"
              class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs shadow-lg shadow-red-500/30 transition-all flex items-center gap-2">
        <i class="fas fa-check"></i>
        <span>Publish Article</span>
      </button>
    </div>
  </form>

</div>

@push('admin_scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
  // Auto-slug from title
  const titleInput = document.getElementById('titleInput');
  const slugInput = document.getElementById('slugInput');
  let slugUserEdited = false;

  slugInput.addEventListener('input', () => {
    slugUserEdited = slugInput.value.trim().length > 0;
  });

  titleInput.addEventListener('input', () => {
    if (!slugUserEdited) {
      slugInput.value = titleInput.value
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-');
    }
  });

  // Category Toggle
  const toggleBtn = document.getElementById('toggleNewCatBtn');
  const toggleLabel = document.getElementById('toggleCatLabel');
  const existingCatGroup = document.getElementById('existingCatGroup');
  const newCatGroup = document.getElementById('newCatGroup');
  const categorySelect = document.getElementById('categorySelect');
  const categoryNewInput = document.getElementById('categoryNewInput');

  toggleBtn.addEventListener('click', () => {
    if (newCatGroup.classList.contains('hidden')) {
      newCatGroup.classList.remove('hidden');
      categoryNewInput.focus();
      toggleLabel.textContent = '← Choose Existing Category';
      categorySelect.value = '';
    } else {
      newCatGroup.classList.add('hidden');
      categoryNewInput.value = '';
      toggleLabel.textContent = '+ Create New Category';
    }
  });

  // Blog Dual Editor (Visual & Source) with Live Word Count / Read Time
  let classicEditorInstance = null;
  let currentBlogEditorTab = 'visual';

  const blogSourceInput = document.getElementById('blogSourceCodeInput');
  const blogMasterInput = document.getElementById('masterBlogContentInput');

  if (blogSourceInput) {
    blogSourceInput.value = blogMasterInput?.value || '';
    updateBlogSourceCharCount();
    blogSourceInput.addEventListener('input', () => {
      updateBlogSourceCharCount();
      updateReadTimeFromHtml(blogSourceInput.value);
      if (currentBlogEditorTab === 'source' && blogMasterInput) {
        blogMasterInput.value = blogSourceInput.value;
      }
    });
  }

  function updateBlogSourceCharCount() {
    const countEl = document.getElementById('blogSourceCharCount');
    if (countEl && blogSourceInput) {
      countEl.textContent = `${blogSourceInput.value.length.toLocaleString()} characters`;
    }
  }

  if (document.querySelector('#ckBlogEditor')) {
    ClassicEditor
      .create(document.querySelector('#ckBlogEditor'), {
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
          const data = editor.getData();
          updateReadTimeFromHtml(data);
          if (currentBlogEditorTab === 'visual' && blogMasterInput) {
            blogMasterInput.value = data;
          }
        });
        if (editor.getData()) {
          updateReadTimeFromHtml(editor.getData());
        }
      })
      .catch(error => {
        console.error('Classic Editor failed to initialize:', error);
      });
  }

  function switchBlogEditorTab(mode) {
    const visualWrapper = document.getElementById('blogVisualTabWrapper');
    const sourceWrapper = document.getElementById('blogSourceTabWrapper');
    const tabVisualBtn = document.getElementById('tabBlogVisualBtn');
    const tabSourceBtn = document.getElementById('tabBlogSourceBtn');
    const formatHtmlBtn = document.getElementById('formatBlogHtmlBtn');

    if (mode === 'source') {
      currentBlogEditorTab = 'source';
      if (classicEditorInstance && blogSourceInput) {
        blogSourceInput.value = classicEditorInstance.getData();
      }
      if (blogMasterInput && blogSourceInput) {
        blogMasterInput.value = blogSourceInput.value;
      }
      updateBlogSourceCharCount();
      if (blogSourceInput) updateReadTimeFromHtml(blogSourceInput.value);

      visualWrapper.classList.add('hidden');
      sourceWrapper.classList.remove('hidden');
      formatHtmlBtn.classList.remove('hidden');

      tabVisualBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 text-slate-400 hover:text-white hover:bg-slate-900 cursor-pointer';
      tabSourceBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-[#ff3b30] text-white shadow-sm cursor-pointer';
    } else {
      currentBlogEditorTab = 'visual';
      if (classicEditorInstance && blogSourceInput) {
        classicEditorInstance.setData(blogSourceInput.value);
      }
      if (blogMasterInput && blogSourceInput) {
        blogMasterInput.value = blogSourceInput.value;
      }
      if (blogSourceInput) updateReadTimeFromHtml(blogSourceInput.value);

      sourceWrapper.classList.add('hidden');
      visualWrapper.classList.remove('hidden');
      formatHtmlBtn.classList.add('hidden');

      tabSourceBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 text-slate-400 hover:text-white hover:bg-slate-900 cursor-pointer';
      tabVisualBtn.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-[#ff3b30] text-white shadow-sm cursor-pointer';
    }
  }

  function formatBlogSourceHtml() {
    if (!blogSourceInput || !blogSourceInput.value.trim()) return;
    let html = blogSourceInput.value.trim();
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

    blogSourceInput.value = formatted.trim();
    updateBlogSourceCharCount();
  }

  function copyBlogSourceHtml() {
    const content = currentBlogEditorTab === 'visual' && classicEditorInstance ? classicEditorInstance.getData() : (blogSourceInput?.value || '');
    navigator.clipboard.writeText(content).then(() => {
      alert('HTML markup copied to clipboard!');
    }).catch(() => {
      if (blogSourceInput) {
        blogSourceInput.select();
        document.execCommand('copy');
      }
      alert('HTML markup copied to clipboard!');
    });
  }

  // Hook into form submit to guarantee sync
  const blogCreateForm = document.querySelector('form');
  if (blogCreateForm) {
    blogCreateForm.addEventListener('submit', () => {
      if (blogMasterInput) {
        if (currentBlogEditorTab === 'source' && blogSourceInput) {
          blogMasterInput.value = blogSourceInput.value;
        } else if (classicEditorInstance) {
          blogMasterInput.value = classicEditorInstance.getData();
        }
      }
    });
  }

  function updateReadTimeFromHtml(html) {
    const text = (html || '').replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
    const words = text ? text.split(/\s+/).length : 0;
    const minutes = Math.max(1, Math.ceil(words / 200));
    const readTimeInput = document.getElementById('readTimeInput');
    const wordCountBadge = document.getElementById('wordCountBadge');
    const readTimeHint = document.getElementById('readTimeHint');
    if (readTimeInput) readTimeInput.value = `${minutes} min read`;
    if (wordCountBadge) wordCountBadge.innerHTML = `<i class="fas fa-calculator mr-1"></i> ${words} words (${minutes} min)`;
    if (readTimeHint) readTimeHint.textContent = `Auto-calculated: ${words} words at ~200 words/min.`;
  }

  // Cover Image Preview Handler
  const coverFileInput = document.getElementById('coverFileInput');
  const coverPreviewImg = document.getElementById('coverPreviewImg');
  const imageInput = document.getElementById('imageInput');

  if (coverFileInput && coverPreviewImg) {
    coverFileInput.addEventListener('change', (e) => {
      const file = e.target.files && e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (evt) => {
          coverPreviewImg.src = evt.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  }

  if (imageInput && coverPreviewImg) {
    imageInput.addEventListener('input', () => {
      const val = imageInput.value.trim();
      if (val && (!coverFileInput.files || !coverFileInput.files.length)) {
        coverPreviewImg.src = val.startsWith('http') || val.startsWith('/') ? val : `/${val}`;
      }
    });
  }

  // Scheduled Publishing Status Badge Handler
  const publishedAtInput = document.getElementById('publishedAtInput');
  const scheduleStatusBadge = document.getElementById('scheduleStatusBadge');

  function updateScheduleBadge() {
    if (!publishedAtInput || !scheduleStatusBadge) return;
    const val = publishedAtInput.value;
    if (!val) {
      scheduleStatusBadge.className = 'text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-800 text-slate-400';
      scheduleStatusBadge.textContent = 'Immediate';
      return;
    }
    const targetDate = new Date(val);
    const now = new Date();
    if (targetDate > now) {
      scheduleStatusBadge.className = 'text-[10px] font-bold px-1.5 py-0.5 rounded bg-purple-500/20 text-purple-300 border border-purple-500/30';
      scheduleStatusBadge.innerHTML = '<i class="fas fa-clock mr-1"></i> Scheduled';
    } else {
      scheduleStatusBadge.className = 'text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
      scheduleStatusBadge.textContent = 'Past/Now';
    }
  }

  if (publishedAtInput) {
    publishedAtInput.addEventListener('input', updateScheduleBadge);
    updateScheduleBadge();
  }

  // FAQ Repeater
  function addFaqRow() {
    const container = document.getElementById('faqContainer');
    const div = document.createElement('div');
    div.className = 'faq-item p-3.5 rounded-xl bg-slate-900 border border-slate-800 space-y-2';
    div.innerHTML = `
      <div class="flex items-center justify-between gap-2">
        <input type="text" name="faq_questions[]" placeholder="Question..."
               class="w-full px-3 py-1.5 rounded-lg bg-slate-950 border border-slate-700 text-white placeholder-slate-600 text-xs focus:outline-none focus:border-[#ff3b30] font-semibold">
        <button type="button" onclick="removeFaqRow(this)" class="text-slate-500 hover:text-red-400 p-1">
          <i class="fas fa-times text-xs"></i>
        </button>
      </div>
      <textarea name="faq_answers[]" rows="2" placeholder="Answer..."
                class="w-full px-3 py-1.5 rounded-lg bg-slate-950 border border-slate-700 text-white placeholder-slate-600 text-xs focus:outline-none focus:border-[#ff3b30]"></textarea>
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

  function insertSampleSchema() {
    const postTitle = document.getElementById('titleInput')?.value || "Data Engineering Patterns for ML Feature Stores";
    const atContext = '@' + 'context';
    const atType = '@' + 'type';
    const sample = {
      [atContext]: "https://schema.org",
      [atType]: "BlogPosting",
      "headline": postTitle,
      "datePublished": new Date().toISOString()
    };
    const textarea = document.getElementById('customSchemaInput');
    if (textarea) {
      textarea.value = JSON.stringify(sample, null, 2);
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
  #blogSourceCodeInput {
    height: 380px !important;
    min-height: 250px !important;
    max-height: 480px !important;
    overflow-y: auto !important;
    scrollbar-width: thin !important;
    scrollbar-color: #ff3b30 #030712 !important;
  }
  #blogSourceCodeInput::-webkit-scrollbar {
    width: 8px !important;
  }
  #blogSourceCodeInput::-webkit-scrollbar-track {
    background: #030712 !important;
    border-bottom-right-radius: 0.75rem !important;
  }
  #blogSourceCodeInput::-webkit-scrollbar-thumb {
    background-color: #334155 !important;
    border-radius: 4px !important;
  }
  #blogSourceCodeInput::-webkit-scrollbar-thumb:hover {
    background-color: #ff3b30 !important;
  }
  #blogContentInput {
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
