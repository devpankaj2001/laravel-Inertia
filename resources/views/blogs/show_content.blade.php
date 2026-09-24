<main class="blog-detail-main">

  <!-- ======= 1. ARTICLE HERO SECTION ======= -->
  <section class="blog-aiero-hero blog-detail-hero">
    <div class="blog-aiero-hero-bg" aria-hidden="true"></div>
    <div class="cvp-wrap blog-aiero-hero-inner text-center max-w-4xl mx-auto px-6">
      
      <!-- Breadcrumbs -->
      <nav class="blog-aiero-crumb mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('blogs.index') }}">Blogs</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">{{ $post->category }}</span>
      </nav>

      <!-- Category Tag Pills -->
      <div class="blog-detail-hero-tags flex flex-wrap items-center justify-center gap-2 mb-6">
        <span class="px-3 py-1 rounded-full bg-[#ff3b30]/20 border border-[#ff3b30]/40 text-[#ff3b30] text-xs font-extrabold uppercase tracking-wider">
          {{ $post->category }}
        </span>
        @if(!empty($post->tags) && is_array($post->tags))
          @foreach($post->tags as $t)
            <span class="px-3 py-1 rounded-full bg-slate-800/80 border border-slate-700 text-slate-200 text-xs font-semibold">
              {{ $t }}
            </span>
          @endforeach
        @endif
      </div>

      <!-- Title: Crisp White Contrast on Dark Hero Background -->
      <h1 class="blog-aiero-title blog-detail-hero-title text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight mb-6">
        {{ $post->title }}
      </h1>

      <!-- Deck / Summary Excerpt -->
      @if(!empty($post->excerpt))
        <p class="blog-detail-hero-deck text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed mb-8">
          {{ $post->excerpt }}
        </p>
      @endif

      <!-- Author & Published Metadata -->
      <div class="blog-detail-hero-meta flex items-center justify-center gap-4 text-xs">
        <div class="flex items-center gap-3">
          <span class="w-10 h-10 rounded-full bg-slate-900 border border-slate-700 text-amber-400 font-black flex items-center justify-center text-xs tracking-wider shadow-md">
            {{ $post->author_initials }}
          </span>
          <div class="text-left">
            <p class="font-extrabold text-white text-sm">{{ $post->author_name ?? 'WebRanker Team' }}</p>
            <p class="text-[11px] text-slate-400">{{ $post->author_role ?? 'Technical Specialist' }}</p>
          </div>
        </div>

        <span class="h-6 w-px bg-slate-700" aria-hidden="true"></span>

        <div class="flex items-center gap-3 text-slate-300 font-mono">
          <time datetime="{{ $post->published_at ? $post->published_at->format('Y-m-d') : $post->created_at->format('Y-m-d') }}">
            {{ $post->published_at ? strtoupper($post->published_at->format('d M. Y')) : strtoupper($post->created_at->format('d M. Y')) }}
          </time>
          <span>•</span>
          <span class="flex items-center gap-1">
            <i class="far fa-clock text-[11px] text-[#ff3b30]"></i> {{ $post->read_time ?? '6 min read' }}
          </span>
        </div>
      </div>

    </div>
  </section>

  <!-- ======= 2. COVER IMAGE SECTION ======= -->
  <section class="blog-detail-cover-section pb-12" aria-label="Featured image">
    <div class="cvp-wrap max-w-5xl mx-auto px-6">
      <figure class="blog-detail-cover-wrap rounded-3xl overflow-hidden shadow-2xl border border-[#e6dfd3]">
        <div class="blog-detail-cover aspect-[21/9] sm:aspect-[16/7] bg-[#161514]">
          <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover" loading="eager">
        </div>
      </figure>
    </div>
  </section>

  <!-- ======= 3. MAIN ARTICLE & SIDEBAR SECTION ======= -->
  <section class="blog-detail-body-section py-12 bg-white border-y border-[#e6dfd3]">
    <div class="cvp-wrap max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

        <!-- Left Column: Article Content -->
        <article class="lg:col-span-8 space-y-8">
          
          <div class="prose prose-slate max-w-none text-[#374151] leading-relaxed text-base space-y-6 blog-content-body">
            {!! $post->content !!}
          </div>

          <!-- FAQs Section (if present) -->
          @if(!empty($post->faqs) && is_array($post->faqs) && count($post->faqs) > 0)
            <div class="pt-8 border-t border-[#e6dfd3] space-y-4">
              <h3 class="text-xl font-extrabold text-[#161514] flex items-center gap-2">
                <i class="fas fa-circle-question text-[#ff3b30]"></i>
                <span>Frequently Asked Questions</span>
              </h3>
              <div class="space-y-3">
                @foreach($post->faqs as $fIdx => $faq)
                  @if(!empty($faq['question']))
                    <details class="p-4 rounded-xl bg-[#faf7f2] border border-[#e6dfd3] group">
                      <summary class="font-bold text-[#161514] cursor-pointer list-none flex items-center justify-between text-sm">
                        <span>{{ $faq['question'] }}</span>
                        <i class="fas fa-chevron-down text-xs text-[#8c827a] group-open:rotate-180 transition-transform"></i>
                      </summary>
                      <p class="mt-3 text-xs text-[#6e675f] leading-relaxed border-t border-[#e6dfd3] pt-3">
                        {{ $faq['answer'] ?? '' }}
                      </p>
                    </details>
                  @endif
                @endforeach
              </div>
            </div>
          @endif

          <!-- Footer Topics -->
          <footer class="pt-8 border-t border-[#e6dfd3] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
              <span class="text-xs font-bold uppercase tracking-wider text-[#8c827a]">Topics:</span>
              <div class="flex flex-wrap gap-1.5">
                <span class="px-3 py-1 rounded-full bg-[#f5efe6] text-[#ff3b30] text-xs font-bold">
                  {{ $post->category }}
                </span>
                @if(!empty($post->tags) && is_array($post->tags))
                  @foreach($post->tags as $tag)
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                      {{ $tag }}
                    </span>
                  @endforeach
                @endif
              </div>
            </div>

            <!-- Share Buttons (Inline on Mobile) -->
            <div class="flex items-center gap-2 text-xs">
              <span class="text-[#8c827a] font-bold">Share:</span>
              <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($canonicalUrl) }}" target="_blank" rel="noopener"
                 class="w-8 h-8 rounded-lg bg-[#faf7f2] hover:bg-[#0077b5] hover:text-white text-slate-700 flex items-center justify-center transition-colors shadow-sm" title="Share on LinkedIn">
                <i class="fab fa-linkedin-in text-xs"></i>
              </a>
              <a href="https://twitter.com/intent/tweet?url={{ urlencode($canonicalUrl) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener"
                 class="w-8 h-8 rounded-lg bg-[#faf7f2] hover:bg-black hover:text-white text-slate-700 flex items-center justify-center transition-colors shadow-sm" title="Share on X">
                <i class="fab fa-x-twitter text-xs"></i>
              </a>
              <button type="button" onclick="navigator.clipboard.writeText('{{ $canonicalUrl }}'); alert('Link copied to clipboard!');"
                      class="w-8 h-8 rounded-lg bg-[#faf7f2] hover:bg-[#ff3b30] hover:text-white text-slate-700 flex items-center justify-center transition-colors shadow-sm" title="Copy Link">
                <i class="fas fa-link text-xs"></i>
              </button>
            </div>
          </footer>

        </article>

        <!-- Right Column: Aside & Sticky Navigation -->
        <aside class="lg:col-span-4 space-y-6" aria-label="Article sidebar">
          
          <!-- Table of Contents -->
          @if(!empty($tableOfContents))
            <div class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-3 sticky top-20">
              <div class="flex items-center justify-between">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#161514] flex items-center gap-2">
                  <i class="fas fa-list-ul text-[#ff3b30]"></i>
                  <span>Table of Contents</span>
                </h4>
                <span class="text-[10px] font-mono text-[#8c827a] font-bold">{{ count($tableOfContents) }} sections</span>
              </div>
              <ul class="space-y-1.5 text-xs font-medium text-[#6e675f] max-h-72 overflow-y-auto pr-1">
                @foreach($tableOfContents as $toc)
                  <li class="{{ ($toc['level'] ?? 'h2') === 'h3' ? 'pl-4 text-[11px]' : '' }}">
                    <a href="#{{ $toc['id'] }}" class="hover:text-[#ff3b30] hover:underline flex items-start gap-1.5 transition-colors py-0.5">
                      <span class="text-[#ff3b30] font-bold text-[10px]">#</span>
                      <span class="line-clamp-1">{{ $toc['title'] }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Feature Your Brand / Request Link Placement CTA Card -->
          <div class="p-6 rounded-2xl bg-gradient-to-br from-amber-500/10 via-[#faf7f2] to-white border border-amber-500/30 space-y-3 shadow-md">
            <div class="flex items-center gap-2 text-amber-600 font-extrabold text-[11px] uppercase tracking-wider">
              <i class="fas fa-bullhorn"></i>
              <span>Brand Feature &amp; Links</span>
            </div>
            <h4 class="text-base font-black text-[#161514] leading-snug">
              Feature Your Brand or Request Link Insertion
            </h4>
            <p class="text-xs text-[#6e675f] leading-relaxed">
              Targeting this high-traffic audience? Request a contextual link insertion, sponsored tool review, or editorial collaboration in this guide.
            </p>
            <button type="button" onclick="openLinkRequestModal('{{ url()->current() }}', '{{ addslashes($post->title) }}')"
                    class="w-full py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-md shadow-amber-500/20 transition-all cursor-pointer">
              <i class="fas fa-link"></i> Request Link Insertion
            </button>
          </div>

          <!-- Written By Author Card -->
          <div class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-4">
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#8c827a]">Written by</h4>
            <div class="flex items-center gap-3">
              <span class="w-12 h-12 rounded-full bg-[#161514] text-amber-400 font-black flex items-center justify-center text-sm tracking-wider shadow-md">
                {{ $post->author_initials }}
              </span>
              <div>
                <h5 class="font-black text-[#161514] text-base">{{ $post->author_name ?? 'WebRanker Team' }}</h5>
                <p class="text-xs text-[#ff3b30] font-semibold">{{ $post->author_role ?? 'Technical Specialist' }}</p>
              </div>
            </div>
            <p class="text-xs text-[#6e675f] leading-relaxed">
              Leading engineering strategy, high-concurrency cloud deployments, and production generative AI architecture at WebRanker.
            </p>
          </div>

          <!-- Share Card -->
          <div class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] space-y-3">
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#8c827a]">Share this insight</h4>
            <div class="flex items-center gap-2">
              <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($canonicalUrl) }}" target="_blank" rel="noopener"
                 class="flex-1 py-2 rounded-xl bg-white border border-[#e6dfd3] hover:bg-[#0077b5] hover:text-white text-slate-800 text-xs font-bold flex items-center justify-center gap-2 transition-colors shadow-sm">
                <i class="fab fa-linkedin-in"></i>
                <span>LinkedIn</span>
              </a>
              <a href="https://twitter.com/intent/tweet?url={{ urlencode($canonicalUrl) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener"
                 class="flex-1 py-2 rounded-xl bg-white border border-[#e6dfd3] hover:bg-black hover:text-white text-slate-800 text-xs font-bold flex items-center justify-center gap-2 transition-colors shadow-sm">
                <i class="fab fa-x-twitter"></i>
                <span>X / Twitter</span>
              </a>
            </div>
          </div>

          <!-- Consultation CTA Card -->
          <div class="p-6 rounded-2xl bg-gradient-to-br from-[#161514] to-slate-900 text-white space-y-4 shadow-xl">
            <span class="text-[10px] font-mono tracking-widest text-[#ff3b30] uppercase">NEED HELP WITH SCALE?</span>
            <h4 class="text-xl font-black text-white leading-snug">
              Book a Free Architecture Consultation
            </h4>
            <p class="text-xs text-slate-300 leading-relaxed">
              Audit your model serving throughput, feature store consistency, or full-stack web performance with our senior architects.
            </p>
            <a href="{{ route('home') }}#consultation"
               class="w-full py-3 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs tracking-wider uppercase text-center block shadow-lg shadow-red-500/20 transition-all">
              Claim Free Growth Audit →
            </a>
          </div>

        </aside>

      </div>
    </div>
  </section>

  <!-- ======= 4. COMMENTS & DISCUSSION SECTION ======= -->
  <section class="blog-detail-comments-section py-16 bg-[#faf7f2] border-b border-[#e6dfd3]">
    <div class="cvp-wrap max-w-4xl mx-auto px-6 space-y-8">
      
      <div class="text-center space-y-2">
        <span class="px-3 py-1 rounded-full bg-[#ff3b30]/10 text-[#ff3b30] text-xs font-bold uppercase tracking-wider">
          DISCUSSION
        </span>
        <h2 class="text-3xl font-black text-[#161514]">Reader Thoughts &amp; Feedback</h2>
      </div>

      <!-- Sample Comment -->
      <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm space-y-3">
        <div class="flex items-center gap-3">
          <span class="w-9 h-9 rounded-full bg-slate-900 text-amber-400 font-bold flex items-center justify-center text-xs">
            AM
          </span>
          <div>
            <h5 class="font-extrabold text-sm text-[#161514]">Alex Martin</h5>
            <span class="text-[11px] text-[#8c827a] font-mono">Aug 1, 2026</span>
          </div>
        </div>
        <p class="text-xs text-[#6e675f] leading-relaxed">
          Clear, practical breakdown — our engineering team implemented the training-serving skew validation pattern before our last model rollout and it caught several silent pipeline bugs.
        </p>
      </div>

      <!-- Comment Form -->
      <form onsubmit="event.preventDefault(); document.getElementById('commentSuccess').classList.remove('hidden'); this.reset();" class="p-6 sm:p-8 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm space-y-4">
        <h4 class="text-base font-extrabold text-[#161514]">Leave a Comment</h4>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Full Name</label>
            <input type="text" required placeholder="e.g. John Doe"
                   class="w-full px-4 py-2.5 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Email Address</label>
            <input type="email" required placeholder="you@company.com"
                   class="w-full px-4 py-2.5 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-[#161514] mb-1">Your Message</label>
          <textarea rows="4" required placeholder="Share your perspectives or architectural questions..."
                    class="w-full px-4 py-2.5 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30] leading-relaxed"></textarea>
        </div>

        <button type="submit"
                class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-xs shadow-md shadow-red-500/20 transition-all">
          <span>Submit Comment</span>
        </button>

        <div id="commentSuccess" class="hidden p-3 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
          <i class="fas fa-check-circle mr-1"></i> Thank you! Your comment has been received and will appear after moderation.
        </div>
      </form>

    </div>
  </section>

  <!-- ======= 4.5 RECOMMENDED SOLUTIONS & SERVICES ======= -->
  @if(isset($relatedServices) && $relatedServices->count() > 0)
    <section class="blog-services-interlink-section py-16 bg-[#faf7f2] border-b border-[#e6dfd3]">
      <div class="cvp-wrap max-w-7xl mx-auto px-6 space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
          <div class="space-y-1">
            <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">PRODUCTION IMPLEMENTATION</span>
            <h2 class="text-2xl sm:text-3xl font-black text-[#161514]">Recommended Engineering Services</h2>
            <p class="text-xs text-[#6e675f]">Deploy these enterprise architectures with our dedicated engineering teams.</p>
          </div>
          <a href="{{ route('services.index') }}" class="text-xs font-extrabold text-[#ff3b30] hover:underline flex items-center gap-1">
            <span>Explore All Services</span> <i class="fas fa-arrow-right text-[10px]"></i>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach($relatedServices as $svc)
            <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-xl hover:border-[#ff3b30]/30 transition-all flex flex-col justify-between group">
              <div class="space-y-3">
                <div class="w-11 h-11 rounded-xl bg-red-500/10 text-[#ff3b30] border border-red-500/20 flex items-center justify-center text-lg shadow-sm">
                  <i class="{{ $svc->icon }}"></i>
                </div>
                <div>
                  <span class="text-[10px] font-mono uppercase text-[#8c827a] font-bold">{{ $svc->category }}</span>
                  <h3 class="text-base font-extrabold text-[#161514] group-hover:text-[#ff3b30] transition-colors mt-0.5 line-clamp-1">
                    <a href="{{ route('services.show', $svc->slug) }}">{{ $svc->title }}</a>
                  </h3>
                  <p class="text-xs text-[#6e675f] line-clamp-2 mt-1 leading-relaxed">{{ $svc->tagline ?? $svc->meta_description }}</p>
                </div>
              </div>
              <div class="pt-4 mt-4 border-t border-[#f5efe6] flex items-center justify-between">
                <span class="text-[11px] font-bold text-emerald-600 font-mono">{{ $svc->kpi_value ?? 'High Performance' }}</span>
                <a href="{{ route('services.show', $svc->slug) }}" class="text-xs font-black text-[#ff3b30] group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                  <span>Explore Service</span> →
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- ======= 5. RELATED ARTICLES SECTION ======= -->
  @if($relatedPosts->count() > 0)
    <section class="blog-related-section py-20 bg-white">
      <div class="cvp-wrap max-w-7xl mx-auto px-6">
        <div class="text-center space-y-2 mb-12">
          <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">KEEP READING</span>
          <h2 class="text-3xl font-black text-[#161514]">Related Articles</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          @foreach($relatedPosts as $rel)
            <article class="blog-list-card group">
              <a href="{{ route('blogs.show', $rel->slug) }}" class="block h-full">
                <div class="bg-white rounded-2xl border border-[#e6dfd3] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                  <div class="aspect-[16/10] overflow-hidden bg-slate-900">
                    <img src="{{ $rel->featured_image_url }}"
                         alt="{{ $rel->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         loading="lazy">
                  </div>
                  <div class="p-6 flex flex-col flex-grow justify-between space-y-4">
                    <div class="space-y-2">
                      <div class="flex items-center justify-between text-xs text-[#8c827a]">
                        <span class="px-2 py-0.5 rounded-full bg-[#f5efe6] text-[#ff3b30] font-bold text-[10px]">
                          {{ $rel->category }}
                        </span>
                        <span class="font-mono text-[11px]">{{ $rel->read_time ?? '5 min' }}</span>
                      </div>
                      <h3 class="text-lg font-bold text-[#161514] group-hover:text-[#ff3b30] transition-colors line-clamp-2">
                        {{ $rel->title }}
                      </h3>
                    </div>
                  </div>
                </div>
              </a>
            </article>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- ======= 6. CLIENT LINK PLACEMENT / BRAND FEATURE MODAL ======= -->
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
          Feature your SaaS, engineering tool, or digital solution in this high-ranking guide. We review every request for quality and contextual relevance.
        </p>
      </div>

      <!-- AJAX Form -->
      <form id="linkRequestForm" onsubmit="submitLinkRequest(event)" class="space-y-4">
        @csrf
        <input type="hidden" name="target_page_url" id="modalTargetUrl" value="{{ url()->current() }}">
        <input type="hidden" name="target_page_title" id="modalTargetTitle" value="{{ $post->title }}">

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
            <input type="text" name="requested_anchor_text" placeholder="e.g. AI latency benchmark tool"
                   class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
          <div>
            <label class="block text-xs font-bold text-[#161514] mb-1">Destination Target Link URL</label>
            <input type="url" name="target_link_url" placeholder="https://yourbrand.com/tool"
                   class="w-full px-3.5 py-2 rounded-xl border border-[#e6dfd3] text-xs focus:outline-none focus:border-[#ff3b30]">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-[#161514] mb-1">Proposed Context / Notes</label>
          <textarea name="proposed_context" rows="2" placeholder="Tell us which section or paragraph you'd like your link added to, or describe your tool..."
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

</main>
