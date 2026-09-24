<main class="blog-page-main">

  <!-- ======= 1. BLOG HERO SECTION ======= -->
  <section class="blog-aiero-hero">
    <div class="blog-aiero-hero-bg" aria-hidden="true"></div>
    <div class="cvp-wrap blog-aiero-hero-inner text-center">
      <p class="blog-aiero-kicker">Articles</p>
      <h1 class="blog-aiero-title">Blogs</h1>
      <nav class="blog-aiero-crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">Blogs</span>
      </nav>
    </div>
  </section>

  <!-- ======= 2. ARTICLES GRID & FILTER SECTION ======= -->
  <section class="blog-aiero-grid-section py-16" id="blog-list">
    <div class="cvp-wrap max-w-7xl mx-auto px-6">

      <!-- Toolbar (Categories Filter Bar & Search) -->
      <div class="blog-toolbar mb-10">
        <div class="blog-toolbar-row flex flex-col md:flex-row items-center justify-between gap-4 pb-6 border-b border-[#e6dfd3]">
          
          <!-- Category Tabs -->
          <div class="blog-filter-bar flex flex-wrap items-center gap-2" id="blogFilter" role="tablist" aria-label="Filter articles by topic">
            <a href="{{ route('blogs.index', array_filter(['search' => $searchQuery])) }}"
               class="blog-filter-btn {{ $selectedCategory === 'all' || empty($selectedCategory) ? 'is-on' : '' }}"
               role="tab">
              All
            </a>
            @foreach($categories as $cat)
              <a href="{{ route('blogs.index', ['category' => $cat->category, 'search' => $searchQuery]) }}"
                 class="blog-filter-btn {{ strtolower($selectedCategory) === strtolower($cat->category) ? 'is-on' : '' }}"
                 role="tab">
                {{ $cat->category }}
              </a>
            @endforeach
          </div>

          <!-- Search Box -->
          <form method="GET" action="{{ route('blogs.index') }}" class="w-full md:w-auto">
            @if(!empty($selectedCategory) && $selectedCategory !== 'all')
              <input type="hidden" name="category" value="{{ $selectedCategory }}">
            @endif
            <label class="blog-search relative block" for="blogSearch">
              <span class="sr-only">Search articles</span>
              <input type="search" id="blogSearch" name="search" value="{{ $searchQuery }}"
                     placeholder="Search articles..."
                     class="w-full md:w-64 pl-9 pr-4 py-2 rounded-full border border-[#e6dfd3] bg-[#faf7f2] text-sm text-[#161514] placeholder-[#8c827a] focus:outline-none focus:border-[#ff3b30] transition-colors">
              <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-[#8c827a]"></i>
            </label>
          </form>

        </div>
      </div>

      <!-- Articles Grid -->
      @if($posts->count() > 0)
        <div class="blog-list-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="blogGrid">
          @foreach($posts as $post)
            <article class="blog-list-card group" data-blog-cat="{{ strtolower($post->category) }}">
              <a href="{{ route('blogs.show', $post->slug) }}" class="blog-list-card-link block h-full">
                <div class="blog-card-box bg-white rounded-2xl border border-[#e6dfd3] overflow-hidden shadow-sm hover:shadow-xl hover:border-slate-400 transition-all duration-300 flex flex-col h-full">
                  
                  <div class="blog-card-top relative">
                    <div class="blog-list-media overflow-hidden aspect-[16/10] bg-[#161514]">
                      <img src="{{ $post->featured_image_url }}"
                           alt="{{ $post->title }}"
                           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                           loading="lazy">
                    </div>
                    <p class="blog-grid-meta absolute bottom-3 left-3 px-3 py-1 rounded-lg bg-black/60 backdrop-blur-md text-white text-[11px] font-mono tracking-wide">
                      <time datetime="{{ $post->published_at ? $post->published_at->format('Y-m-d') : $post->created_at->format('Y-m-d') }}">
                        {{ $post->published_at ? strtoupper($post->published_at->format('d M. Y')) : strtoupper($post->created_at->format('d M. Y')) }}
                      </time>
                      / {{ $post->author_name ?? 'WebRanker' }}
                    </p>
                  </div>

                  <div class="blog-list-body p-6 flex flex-col flex-grow justify-between space-y-4">
                    <div class="space-y-2">
                      <h3 class="blog-grid-title text-xl font-bold text-[#161514] group-hover:text-[#ff3b30] transition-colors leading-snug">
                        {{ $post->title }}
                      </h3>
                      @if(!empty($post->excerpt))
                        <p class="text-xs text-[#6e675f] line-clamp-2 leading-relaxed">
                          {{ $post->excerpt }}
                        </p>
                      @endif
                    </div>

                    <div class="pt-2 border-t border-[#f2ece1] flex items-center justify-between">
                      <p class="blog-grid-tags flex flex-wrap gap-1.5" aria-label="Categories">
                        <span class="px-2.5 py-0.5 rounded-full bg-[#f5efe6] text-[#ff3b30] text-[11px] font-bold">
                          {{ $post->category }}
                        </span>
                        @if(!empty($post->tags) && is_array($post->tags))
                          @foreach(array_slice($post->tags, 0, 1) as $tag)
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-semibold">
                              {{ $tag }}
                            </span>
                          @endforeach
                        @endif
                      </p>
                      <span class="text-[11px] text-[#8c827a] font-mono flex items-center gap-1">
                        <i class="far fa-clock text-[10px]"></i> {{ $post->read_time ?? '5 min read' }}
                      </span>
                    </div>

                  </div>

                </div>
              </a>
            </article>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="blog-pagination mt-12 flex justify-center">
          {{ $posts->links() }}
        </div>
      @else
        <div class="blog-empty text-center py-20 bg-white rounded-3xl border border-[#e6dfd3] space-y-4">
          <div class="w-16 h-16 rounded-full bg-red-50 text-[#ff3b30] flex items-center justify-center mx-auto text-2xl">
            <i class="fas fa-newspaper"></i>
          </div>
          <h3 class="text-xl font-bold text-[#161514]">No articles match your criteria</h3>
          <p class="text-sm text-[#6e675f] max-w-md mx-auto">
            Try adjusting your search query or selecting a different category to discover our engineering insights.
          </p>
          <a href="{{ route('blogs.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#ff3b30] text-white text-xs font-bold shadow-lg shadow-red-500/20">
            <span>View All Articles</span>
          </a>
        </div>
      @endif

    </div>
  </section>

  <!-- ======= 3. INSIGHTS CAROUSEL SECTION ======= -->
  @if($featuredPosts->count() > 0)
    <section class="blog-insights-section py-20 bg-[#f5efe6] border-t border-[#e6dfd3]" aria-labelledby="blogInsightsHeading">
      <div class="cvp-wrap max-w-7xl mx-auto px-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
          <div>
            <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">CURATED INSIGHTS</span>
            <h2 id="blogInsightsHeading" class="text-3xl font-black text-[#161514] tracking-tight mt-1">
              Insights from the WebRanker Lab
            </h2>
          </div>
          <div class="flex items-center gap-2">
            <button type="button" id="blogCarouselPrev" class="w-10 h-10 rounded-full border border-[#e6dfd3] bg-white hover:bg-[#ff3b30] hover:text-white hover:border-[#ff3b30] text-[#161514] flex items-center justify-center transition-colors">
              <i class="fas fa-chevron-left text-xs"></i>
            </button>
            <button type="button" id="blogCarouselNext" class="w-10 h-10 rounded-full border border-[#e6dfd3] bg-white hover:bg-[#ff3b30] hover:text-white hover:border-[#ff3b30] text-[#161514] flex items-center justify-center transition-colors">
              <i class="fas fa-chevron-right text-xs"></i>
            </button>
          </div>
        </div>

        <div class="blog-insights-slider-wrap">
          <div id="blogInsightsCarousel" class="owl-carousel owl-theme">
            @foreach($featuredPosts as $feat)
              <div class="item">
                <article class="blog-insights-card bg-white rounded-2xl border border-[#e6dfd3] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                  <a href="{{ route('blogs.show', $feat->slug) }}" class="blog-insights-card-link block">
                    <div class="blog-insights-media aspect-[16/9] overflow-hidden bg-slate-900">
                      <img src="{{ $feat->featured_image_url }}"
                           alt="{{ $feat->title }}"
                           class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                           loading="lazy">
                    </div>
                    <div class="blog-insights-body p-6 space-y-3">
                      <div class="blog-insights-meta flex items-center justify-between text-xs text-[#8c827a]">
                        <span class="px-2.5 py-0.5 rounded-full bg-[#f5efe6] text-[#ff3b30] text-[11px] font-bold">
                          {{ $feat->category }}
                        </span>
                        <span class="font-mono">{{ $feat->read_time ?? '6 min read' }}</span>
                      </div>
                      <h3 class="blog-insights-title text-lg font-bold text-[#161514] hover:text-[#ff3b30] transition-colors line-clamp-2">
                        {{ $feat->title }}
                      </h3>
                      <p class="text-xs text-[#6e675f] line-clamp-2 leading-relaxed">
                        {{ $feat->excerpt }}
                      </p>
                    </div>
                  </a>
                </article>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>
  @endif

</main>

<script>
  $(document).ready(function() {
    var owl = $('#blogInsightsCarousel');
    if (owl.length) {
      owl.owlCarousel({
        loop: true,
        margin: 24,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
          0: { items: 1 },
          640: { items: 2 },
          1024: { items: 3 }
        }
      });

      $('#blogCarouselPrev').click(function() {
        owl.trigger('prev.owl.carousel');
      });
      $('#blogCarouselNext').click(function() {
        owl.trigger('next.owl.carousel');
      });
    }
  });
</script>
