<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Dynamic Primary SEO Tags -->
  <title>{{ $metaTitle ?? 'WebRanker | Web & App Development, SEO, Content & Performance Optimization' }}</title>
  <meta name="title" content="{{ $metaTitle ?? 'WebRanker | Web & App Development, SEO, Content & Performance Optimization' }}">
  <meta name="description" content="{{ $metaDescription ?? 'WebRanker is an elite engineering and organic search agency specializing in Web Development, Mobile Apps, Technical SEO, Topical Content, and Site Speed Optimization.' }}">
  <meta name="keywords" content="{{ $metaKeywords ?? 'web development, mobile app development, technical SEO, core web vitals, ecommerce development, AI automation' }}">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">
  @if(!empty($googleVerification))
  <meta name="google-site-verification" content="{{ $googleVerification }}">
  @endif
  @if(!empty($bingVerification))
  <meta name="msvalidate.01" content="{{ $bingVerification }}">
  @endif

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ $canonicalUrl ?? url()->current() }}">
  <meta property="og:title" content="{{ $metaTitle ?? 'WebRanker | Web & App Development, SEO & Performance' }}">
  <meta property="og:description" content="{{ $metaDescription ?? 'Elite engineering and search optimization agency.' }}">
  <meta property="og:image" content="{{ $ogImage ?? asset('asset/logo.svg') }}">
  <meta property="og:site_name" content="WebRanker">
  <meta property="og:locale" content="en_US">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="{{ $canonicalUrl ?? url()->current() }}">
  <meta name="twitter:title" content="{{ $metaTitle ?? 'WebRanker | Web & App Development, SEO & Performance' }}">
  <meta name="twitter:description" content="{{ $metaDescription ?? 'Elite engineering and search optimization agency.' }}">
  <meta name="twitter:image" content="{{ $ogImage ?? asset('asset/logo.svg') }}">
  <meta name="twitter:site" content="@webranker">
  <meta name="twitter:creator" content="@webranker">

  <!-- Site Title Favicon (WR Monogram) -->
  <link rel="icon" type="image/svg+xml" href="{{ asset('asset/wr-favicon.svg') }}">
  <link rel="alternate icon" type="image/png" href="{{ asset('asset/wr-favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('asset/wr-favicon.png') }}">

  <!-- Preconnect & Google Fonts for Core Web Vitals -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script>
    (function () {
      var origWarn = console.warn;
      console.warn = function () {
        if (arguments[0] && String(arguments[0]).indexOf('cdn.tailwindcss.com') !== -1) return;
        return origWarn.apply(console, arguments);
      };
    })();
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Urbanist', 'sans-serif'],
            heading: ['Urbanist', 'sans-serif'],
          },
          colors: {
            themeRed: '#ff3b30',
            themeDark: '#161514',
            bgWarm: '#faf7f2',
            cardWarm: '#f5efe6',
            borderWarm: '#e6dfd3',
          }
        }
      }
    }
  </script>

  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- jQuery & Owl Carousel 2 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <!-- Reference Design System Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">

  <!-- Schema.org JSON-LD Structured Data for High Search Ranking -->
  @if(isset($schemas) && is_array($schemas))
    @foreach($schemas as $schema)
      <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
      </script>
    @endforeach
  @endif

  <!-- Custom Admin Injected JSON-LD Schema -->
  @if(isset($customJsonLd) && !empty($customJsonLd))
    <script type="application/ld+json">
      {!! json_encode($customJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
  @endif

  @stack('styles')
  @stack('head')
</head>

<body data-theme="red" class="bg-[#faf7f2] text-[#1a1816]">

  <!-- ======= FLOATING CURVED NAVIGATION HEADER (Matching Reference) ======= -->
  <header class="floating-pill-header" id="floatingHeader">
    <div class="flex items-center justify-between w-full">

      <!-- Brand Logo -->
      <a href="{{ route('home') }}" class="header-brand-wrap" aria-label="WebRanker Homepage">
        <span class="header-brand-icon-box">
          <span class="header-brand-icon-wr">WR</span>
        </span>
        <span class="header-brand-text">
          <span class="header-brand-text-web">Web</span><span class="header-brand-text-ranker">Ranker</span>
        </span>
      </a>

      <!-- Desktop Navigation Menu (Services ⌵, Industries ⌵, Certification, Blogs, Case Studies) -->
      <nav class="hidden lg:flex items-center gap-7 xl:gap-8 text-[14.5px] font-medium text-[#374151]" aria-label="Primary">
        <!-- Services Dropdown (Dynamic from Database) -->
        <div class="nav-dropdown nav-dropdown--mega">
          <button type="button" class="nav-link-item nav-link-item--trigger flex items-center gap-1.5 hover:text-[#111827] transition-colors" aria-expanded="false" aria-haspopup="true">
            <span>Services</span> <i class="fas fa-chevron-down text-[10px] opacity-60"></i>
          </button>
          <div class="nav-dropdown-menu nav-mega">
            <div class="nav-mega-grid" style="grid-template-columns: repeat({{ max(1, min(count($servicesByCategory ?? []), 4)) }}, minmax(240px, 1fr));">
              @forelse($servicesByCategory ?? [] as $categoryName => $catServices)
                <!-- Dynamic Category Column -->
                <div class="nav-mega-col">
                  <p class="nav-mega-label">{{ $categoryName }}</p>
                  @foreach($catServices as $svc)
                    <a href="{{ route('services.show', $svc->slug) }}" class="nav-mega-item">
                      <span class="nav-mega-ico"><i class="{{ $svc->icon }}"></i></span>
                      <span class="nav-mega-copy">
                        <strong>{{ $svc->title }}</strong>
                        <em>{{ $svc->tagline ?? $svc->short_description }}</em>
                      </span>
                    </a>
                  @endforeach
                  @if($categoryName === 'Design & Reliability' || ($loop->last && !isset($servicesByCategory['Design & Reliability'])))
                    <div class="pt-2 space-y-2">
                      <a href="{{ route('services.index') }}" class="flex items-center justify-between px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-xs font-bold text-slate-800 transition-colors">
                        <span>Explore All {{ isset($services) ? $services->count() : 'All' }} Services Catalog</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                      </a>
                      <a href="#consultation" class="nav-mega-banner">
                        <strong>Need a Complete Growth Audit?</strong>
                        <span>Claim your free 48-hour SEO &amp; Tech Roadmap.</span>
                      </a>
                    </div>
                  @endif
                </div>
              @empty
                <!-- Default fallback if no database services seeded -->
                <div class="nav-mega-col">
                  <p class="nav-mega-label">Engineering &amp; Architecture</p>
                  <a href="#services" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-code"></i></span><span class="nav-mega-copy"><strong>Web Development Services</strong><em>Laravel, Next.js, MERN &amp; Headless</em></span></a>
                  <a href="#services" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-mobile-screen-button"></i></span><span class="nav-mega-copy"><strong>Mobile App Development</strong><em>iOS, Android &amp; Flutter</em></span></a>
                </div>
                <div class="nav-mega-col">
                  <p class="nav-mega-label">Growth &amp; Intelligence</p>
                  <a href="#services" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-magnifying-glass-chart"></i></span><span class="nav-mega-copy"><strong>Digital Marketing &amp; SEO</strong><em>Technical audits &amp; #1 rankings</em></span></a>
                  <a href="#services" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-robot"></i></span><span class="nav-mega-copy"><strong>AI &amp; Automation</strong><em>Autonomous agents</em></span></a>
                </div>
                <div class="nav-mega-col">
                  <p class="nav-mega-label">Design &amp; Reliability</p>
                  <a href="#services" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-palette"></i></span><span class="nav-mega-copy"><strong>UI/UX Design</strong><em>Conversion design systems</em></span></a>
                  <a href="#consultation" class="nav-mega-banner">
                    <strong>Need a Complete Growth Audit?</strong>
                    <span>Claim your free 48-hour SEO &amp; Tech Roadmap.</span>
                  </a>
                </div>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Industries Dropdown (Dynamic from Database) -->
        <div class="nav-dropdown nav-dropdown--mega">
          <button type="button" class="nav-link-item nav-link-item--trigger flex items-center gap-1.5 hover:text-[#111827] transition-colors {{ request()->routeIs('industries.*') ? 'text-[#ff3b30] font-bold' : '' }}" aria-expanded="false" aria-haspopup="true">
            <span>Industries</span> <i class="fas fa-chevron-down text-[10px] opacity-60"></i>
          </button>
          <div class="nav-dropdown-menu nav-mega">
            <div class="nav-mega-grid">
              <div class="nav-mega-col">
                <p class="nav-mega-label">Finance &amp; Commerce</p>
                <a href="{{ route('industries.show', 'ecommerce-retail') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-bag-shopping"></i></span><span class="nav-mega-copy"><strong>E-commerce &amp; Retail</strong><em>Omnichannel stores &amp; catalog speed</em></span></a>
                <a href="{{ route('industries.show', 'fintech-banking') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-building-columns"></i></span><span class="nav-mega-copy"><strong>FinTech &amp; Banking</strong><em>PCI-DSS payments &amp; security</em></span></a>
                <a href="{{ route('industries.show', 'real-estate-proptech') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-city"></i></span><span class="nav-mega-copy"><strong>Real Estate &amp; PropTech</strong><em>MLS feeds &amp; virtual tours</em></span></a>
                <a href="{{ route('industries.show', 'insurance-insurtech') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-shield-halved"></i></span><span class="nav-mega-copy"><strong>Insurance &amp; InsurTech</strong><em>Automated claims processing</em></span></a>
              </div>
              <div class="nav-mega-col">
                <p class="nav-mega-label">Health &amp; Tech</p>
                <a href="{{ route('industries.show', 'healthcare-medtech') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-heart-pulse"></i></span><span class="nav-mega-copy"><strong>Healthcare &amp; Medical</strong><em>HIPAA portals &amp; telehealth</em></span></a>
                <a href="{{ route('industries.show', 'saas-enterprise-b2b') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-server"></i></span><span class="nav-mega-copy"><strong>SaaS &amp; Technology</strong><em>Product-led SEO &amp; subscriptions</em></span></a>
                <a href="{{ route('industries.show', 'legal-compliance') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-scale-balanced"></i></span><span class="nav-mega-copy"><strong>Legal &amp; Law</strong><em>Matter intake &amp; automated discovery</em></span></a>
                <a href="{{ route('industries.show', 'edtech-learning') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-graduation-cap"></i></span><span class="nav-mega-copy"><strong>Education &amp; E-Learning</strong><em>LMS platforms &amp; classrooms</em></span></a>
              </div>
              <div class="nav-mega-col">
                <p class="nav-mega-label">Industry &amp; Mobility</p>
                <a href="{{ route('industries.show', 'logistics-supply-chain') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-truck-fast"></i></span><span class="nav-mega-copy"><strong>Logistics &amp; Supply Chain</strong><em>Fleet tracking &amp; WMS portals</em></span></a>
                <a href="{{ route('industries.show', 'automotive-mobility') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-car"></i></span><span class="nav-mega-copy"><strong>Automotive &amp; Mobility</strong><em>Connected EV &amp; fleet portals</em></span></a>
                <a href="{{ route('industries.show', 'travel-hospitality') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-plane-departure"></i></span><span class="nav-mega-copy"><strong>Travel &amp; Hospitality</strong><em>Booking engines &amp; dynamic pricing</em></span></a>
                <a href="{{ route('industries.index') }}" class="nav-mega-item"><span class="nav-mega-ico"><i class="fas fa-arrow-right"></i></span><span class="nav-mega-copy"><strong>Explore All 25+ Domains</strong><em>Custom vertical solutions</em></span></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Certification -->
        <a href="#certifications" class="nav-link-item hover:text-[#111827] transition-colors">Certification</a>

        <!-- Blogs -->
        <a href="{{ route('blogs.index') }}" class="nav-link-item hover:text-[#111827] transition-colors {{ request()->routeIs('blogs.*') ? 'text-[#ff3b30] font-bold' : '' }}">Blogs</a>

        <!-- Case Studies -->
        <a href="#testimonials" class="nav-link-item hover:text-[#111827] transition-colors">Case Studies</a>
      </nav>

      <!-- CTA Action Button (Chamfered FREE AUDIT with dot matrix icon) -->
      <div class="hidden sm:flex items-center">
        <a href="#consultation" class="header-chamfer-btn" title="Claim your free performance and organic ranking audit">
          <svg class="header-chamfer-dots" viewBox="0 0 14 16" fill="currentColor">
            <circle cx="4" cy="4" r="1.4" />
            <circle cx="4" cy="8" r="1.4" />
            <circle cx="4" cy="12" r="1.4" />
            <circle cx="10" cy="8" r="1.4" />
          </svg>
          <span>FREE AUDIT</span>
        </a>
      </div>

      <!-- Mobile Hamburger Button -->
      <div class="flex items-center gap-2 lg:hidden">
        <button id="mobileMenuBtn"
          class="text-slate-800 text-xl focus:outline-none p-1.5 rounded-full hover:bg-slate-100" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
      </div>

    </div>
  </header>

  <!-- Mobile Drawer Menu -->
  <div id="mobileNavMenu"
    class="fixed inset-0 bg-slate-950/90 backdrop-blur-md z-[10002] hidden flex-col justify-between p-8 text-white transition-all overflow-y-auto">
    <div>
      <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-800">
        <span class="font-extrabold text-2xl text-white">Web<span class="text-[#ff3b30]">Ranker</span></span>
        <button id="mobileMenuClose" class="text-slate-400 hover:text-white text-2xl" aria-label="Close menu">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="flex flex-col gap-3 text-lg font-semibold mobile-nav-links">
        <details class="mobile-nav-group">
          <summary class="mobile-nav-link">Services ({{ isset($services) ? $services->count() : 0 }} Solutions)</summary>
          <div class="mobile-nav-sub">
            @if(isset($servicesByCategory) && count($servicesByCategory) > 0)
              @foreach($servicesByCategory as $catName => $catServices)
                <div class="px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-[#ff3b30] mt-2 border-b border-slate-800/60 flex items-center justify-between">
                  <span>{{ $catName }}</span>
                  <span class="text-[10px] text-slate-500 font-mono font-normal">({{ is_countable($catServices) ? count($catServices) : $catServices->count() }})</span>
                </div>
                @foreach($catServices as $svc)
                  <a href="{{ route('services.show', $svc->slug) }}" class="mobile-nav-sublink pl-5 flex items-center gap-2">
                    <i class="{{ $svc->icon }} text-xs opacity-70 w-3.5 text-center"></i>
                    <span>{{ $svc->title }}</span>
                  </a>
                @endforeach
              @endforeach
            @elseif(isset($services))
              @foreach($services as $svc)
                <a href="{{ route('services.show', $svc->slug) }}" class="mobile-nav-sublink">{{ $svc->title }}</a>
              @endforeach
            @endif
            <a href="{{ route('services.index') }}" class="mobile-nav-sublink text-[#ff3b30] font-bold mt-2 pt-2 border-t border-slate-800">
              Explore All Services Catalog →
            </a>
          </div>
        </details>
        <details class="mobile-nav-group">
          <summary class="mobile-nav-link">Industries (25+)</summary>
          <div class="mobile-nav-sub">
            <a href="#domains" class="mobile-nav-sublink">E-commerce &amp; Retail</a>
            <a href="#domains" class="mobile-nav-sublink">FinTech &amp; Banking</a>
            <a href="#domains" class="mobile-nav-sublink">Healthcare &amp; Medical</a>
            <a href="#domains" class="mobile-nav-sublink">Real Estate &amp; PropTech</a>
            <a href="#domains" class="mobile-nav-sublink">SaaS &amp; Technology</a>
            <a href="#domains" class="mobile-nav-sublink">Logistics &amp; Transport</a>
            <a href="#domains" class="mobile-nav-sublink">View All 25+ Industries →</a>
          </div>
        </details>
        <a href="#growth-engine" class="mobile-nav-link hover:text-[#ff3b30]">How We Grow You</a>
        <a href="#testimonials" class="mobile-nav-link hover:text-[#ff3b30]">Client Reviews</a>
        <a href="{{ route('blogs.index') }}" class="mobile-nav-link hover:text-[#ff3b30] {{ request()->routeIs('blogs.*') ? 'text-[#ff3b30] font-bold' : '' }}">Insights &amp; Blogs</a>
        <a href="#faq" class="mobile-nav-link hover:text-[#ff3b30]">FAQ</a>
        <a href="#consultation" class="mobile-nav-link mobile-nav-cta hover:text-[#ff3b30]">Claim Free Audit</a>
      </div>
    </div>
    <div class="pt-6 border-t border-slate-800 text-center text-xs text-slate-400">
      © {{ date('Y') }} WebRanker. Engineered for #1 Organic Rankings &amp; Peak Performance.
    </div>
  </div>

  <!-- MAIN PAGE CONTENT -->
  <main id="main-content">
    @yield('content')
  </main>

  <!-- ======= 13. WARM LUXURY FOOTER ======= -->
  <footer class="bg-[#f4eee5] text-[#161514] pt-16 pb-12 relative overflow-hidden border-t border-[#e6dfd3]">
    <!-- Ambient luxury top highlight glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1100px] h-72 bg-gradient-to-b from-white/70 via-[#fdfbf7]/40 to-transparent pointer-events-none rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 space-y-14">

      <!-- Top Warm Luxury Enterprise CTA Banner -->
      <div class="relative rounded-3xl bg-gradient-to-br from-white via-[#faf7f2] to-[#f5efe6] border border-[#e6dfd3] p-8 sm:p-12 shadow-xl shadow-amber-950/5 overflow-hidden">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-[#ff3b30]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 relative z-10">
          <div class="space-y-3 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-[#ff3b30]/10 text-[#ff3b30] border border-[#ff3b30]/20">
              <i class="fas fa-bolt text-[10px]"></i> 48-Hour Rapid Delivery
            </div>
            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#161514] tracking-tight leading-tight">
              Ready to dominate search rankings &amp; scale your engineering?
            </h3>
            <p class="text-[#6e675f] text-sm sm:text-base font-medium leading-relaxed">
              Claim your complimentary enterprise audit, sub-second Core Web Vitals diagnostic, and custom architecture roadmap from our senior engineering team.
            </p>
          </div>
          <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 flex-shrink-0">
            <a href="#consultation" onclick="const d = document.getElementById('dsGitDrawer'); if(d) { d.classList.add('is-open'); d.setAttribute('aria-hidden', 'false'); } const b = document.getElementById('dsGitBackdrop'); if(b) b.classList.add('is-open');"
               class="inline-flex items-center justify-center gap-2.5 px-6 py-4 rounded-2xl bg-[#ff3b30] hover:bg-red-600 text-white font-extrabold text-sm shadow-xl shadow-red-500/25 transition-all hover:scale-[1.02]">
              <span>Claim Free 48-Hour Audit</span>
              <i class="fas fa-arrow-right text-xs"></i>
            </a>
            <a href="{{ route('services.index') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-4 rounded-2xl bg-white hover:bg-slate-50 text-[#161514] font-bold text-sm border border-[#e6dfd3] shadow-sm transition-all">
              <i class="fas fa-layer-group text-slate-400"></i>
              <span>Explore All Services</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Main Enterprise 5-Column Navigation Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pt-4">

        <!-- Column 1: Brand & Enterprise Profile (Col span 4) -->
        <div class="lg:col-span-4 space-y-5">
          <!-- WebRanker Brand Logo -->
          <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-2xl font-black text-[#161514] tracking-tight group">
            <svg class="w-8 h-8 flex-shrink-0 transition-transform group-hover:scale-105" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M8 10 V40 C8 44.4 11.6 48 16 48 H48" stroke="#161514" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M14 37 L24 24 L33 32 L46 12" stroke="#ff3b30" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="font-extrabold tracking-tight">Web<span class="text-[#ff3b30]">Ranker</span></span>
          </a>

          <p class="text-xs sm:text-sm text-[#6e675f] leading-relaxed font-medium">
            WebRanker is an elite engineering and organic search agency. We architect sub-second web applications, mobile platforms, and high-impact SEO engines that drive commercial revenue scale.
          </p>

          <!-- System Status Pill -->
          <div class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/25 text-xs font-bold text-emerald-800">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>All Systems Operational · Sub-Second Edge CDN</span>
          </div>

          <!-- Trust Badges & Accreditations -->
          <div class="flex flex-wrap items-center gap-2 pt-2 text-[11px] font-bold text-[#554e46]">
            <span class="px-2.5 py-1 rounded-lg bg-white border border-[#e6dfd3] shadow-2xs">
              <i class="fab fa-google text-blue-500 mr-1"></i> Premier Partner
            </span>
            <span class="px-2.5 py-1 rounded-lg bg-white border border-[#e6dfd3] shadow-2xs">
              <i class="fas fa-gauge-high text-emerald-600 mr-1"></i> Core Web Vitals 99.8%
            </span>
            <span class="px-2.5 py-1 rounded-lg bg-white border border-[#e6dfd3] shadow-2xs">
              <i class="fab fa-laravel text-red-500 mr-1"></i> Laravel 13 Certified
            </span>
          </div>
        </div>

        <!-- Column 2: Engineering Solutions (Col span 2) -->
        <div class="lg:col-span-2 space-y-4">
          <p class="text-xs font-black uppercase tracking-wider text-[#161514]">Engineering</p>
          <ul class="space-y-2.5 text-xs font-semibold text-[#6e675f]">
            <li><a href="#services" class="hover:text-[#ff3b30] transition-colors">Web Development</a></li>
            <li><a href="#services" class="hover:text-[#ff3b30] transition-colors">Mobile Applications</a></li>
            <li><a href="#services" class="hover:text-[#ff3b30] transition-colors">Headless &amp; Next.js</a></li>
            <li><a href="#services" class="hover:text-[#ff3b30] transition-colors">E-Commerce Infrastructure</a></li>
            <li><a href="#services" class="hover:text-[#ff3b30] transition-colors">AI &amp; Autonomous Agents</a></li>
            <li><a href="#services" class="hover:text-[#ff3b30] transition-colors">UI/UX Design Systems</a></li>
            <li class="pt-1">
              <a href="{{ route('services.index') }}" class="text-[#ff3b30] font-bold hover:underline inline-flex items-center gap-1">
                <span>All Services</span> <i class="fas fa-arrow-right text-[10px]"></i>
              </a>
            </li>
          </ul>
        </div>

        <!-- Column 3: Industry Verticals (Col span 2) -->
        <div class="lg:col-span-2 space-y-4">
          <p class="text-xs font-black uppercase tracking-wider text-[#161514]">Industries</p>
          <ul class="space-y-2.5 text-xs font-semibold text-[#6e675f]">
            <li><a href="{{ route('industries.show', 'ecommerce-retail') }}" class="hover:text-[#ff3b30] transition-colors">E-Commerce &amp; Retail</a></li>
            <li><a href="{{ route('industries.show', 'fintech-banking') }}" class="hover:text-[#ff3b30] transition-colors">FinTech &amp; Banking</a></li>
            <li><a href="{{ route('industries.show', 'healthcare-medtech') }}" class="hover:text-[#ff3b30] transition-colors">Healthcare &amp; MedTech</a></li>
            <li><a href="{{ route('industries.show', 'real-estate-proptech') }}" class="hover:text-[#ff3b30] transition-colors">Real Estate &amp; PropTech</a></li>
            <li><a href="{{ route('industries.show', 'saas-enterprise-b2b') }}" class="hover:text-[#ff3b30] transition-colors">SaaS &amp; Technology</a></li>
            <li><a href="{{ route('industries.show', 'logistics-supply-chain') }}" class="hover:text-[#ff3b30] transition-colors">Logistics &amp; Supply Chain</a></li>
            <li class="pt-1">
              <a href="{{ route('industries.index') }}" class="text-[#ff3b30] font-bold hover:underline inline-flex items-center gap-1">
                <span>All 25+ Industries</span> <i class="fas fa-arrow-right text-[10px]"></i>
              </a>
            </li>
          </ul>
        </div>

        <!-- Column 4: Search & Intelligence (Col span 2) -->
        <div class="lg:col-span-2 space-y-4">
          <p class="text-xs font-black uppercase tracking-wider text-[#161514]">Search Dominance</p>
          <ul class="space-y-2.5 text-xs font-semibold text-[#6e675f]">
            <li><a href="#growth-engine" class="hover:text-[#ff3b30] transition-colors">Technical SEO Audits</a></li>
            <li><a href="#services" class="hover:text-[#ff3b30] transition-colors">Core Web Vitals Speed</a></li>
            <li><a href="#services" class="hover:text-[#ff3b30] transition-colors">Programmatic SEO</a></li>
            <li><a href="#services" class="hover:text-[#ff3b30] transition-colors">High-Intent Keywords</a></li>
            <li><a href="#certifications" class="hover:text-[#ff3b30] transition-colors">Enterprise Schema.org</a></li>
            <li><a href="{{ route('blogs.index') }}" class="hover:text-[#ff3b30] transition-colors">Insights &amp; Engineering Blog</a></li>
            <li class="pt-1">
              <a href="#testimonials" class="text-[#ff3b30] font-bold hover:underline inline-flex items-center gap-1">
                <span>Client Case Studies</span> <i class="fas fa-arrow-right text-[10px]"></i>
              </a>
            </li>
          </ul>
        </div>

        <!-- Column 5: Global Enterprise Hubs (Col span 2) -->
        <div class="lg:col-span-2 space-y-4">
          <p class="text-xs font-black uppercase tracking-wider text-[#161514]">Global Hubs</p>
          <div class="space-y-3 text-xs text-[#6e675f]">
            <div>
              <p class="font-bold text-[#161514] flex items-center gap-1.5">
                <i class="fas fa-location-dot text-[#ff3b30] text-[10px]"></i> Jaipur Tech Campus
              </p>
              <p class="text-[11px] mt-0.5 text-[#857d74]">Malviya Nagar, Sector 8, Jaipur, RJ</p>
            </div>
            <div>
              <p class="font-bold text-[#161514] flex items-center gap-1.5">
                <i class="fas fa-location-dot text-[#ff3b30] text-[10px]"></i> London Strategy Suite
              </p>
              <p class="text-[11px] mt-0.5 text-[#857d74]">Mayfair, London W1K 4QG, UK</p>
            </div>
            <div>
              <p class="font-bold text-[#161514] flex items-center gap-1.5">
                <i class="fas fa-location-dot text-[#ff3b30] text-[10px]"></i> San Francisco Desk
              </p>
              <p class="text-[11px] mt-0.5 text-[#857d74]">Financial District, SF, CA 94104</p>
            </div>
            <div class="pt-2 border-t border-[#e6dfd3] space-y-1 text-[11px]">
              <a href="mailto:growth@webranker.com" class="font-bold text-[#161514] hover:text-[#ff3b30] flex items-center gap-1.5">
                <i class="fas fa-envelope text-slate-400"></i> growth@webranker.com
              </a>
              <a href="tel:+919718570218" class="font-bold text-[#161514] hover:text-[#ff3b30] flex items-center gap-1.5">
                <i class="fas fa-phone text-slate-400"></i> +91 97185 70218
              </a>
            </div>
          </div>
        </div>

      </div>

      <!-- Social & Ecosystem Connect Bar -->
      <div class="pt-8 border-t border-[#e6dfd3] flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2.5">
          <a href="https://twitter.com/webranker" target="_blank" rel="noopener"
             class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white hover:bg-[#161514] text-[#161514] hover:text-white border border-[#e6dfd3] text-xs font-bold transition-all shadow-2xs">
            <i class="fab fa-x-twitter text-xs"></i> <span>Twitter / X</span>
          </a>
          <a href="https://linkedin.com/company/webranker" target="_blank" rel="noopener"
             class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white hover:bg-[#161514] text-[#161514] hover:text-white border border-[#e6dfd3] text-xs font-bold transition-all shadow-2xs">
            <i class="fab fa-linkedin-in text-xs text-blue-600"></i> <span>LinkedIn</span>
          </a>
          <a href="https://github.com/webranker" target="_blank" rel="noopener"
             class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white hover:bg-[#161514] text-[#161514] hover:text-white border border-[#e6dfd3] text-xs font-bold transition-all shadow-2xs">
            <i class="fab fa-github text-xs"></i> <span>GitHub</span>
          </a>
          <a href="{{ route('seo.sitemap') }}" target="_blank"
             class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white hover:bg-[#161514] text-[#161514] hover:text-white border border-[#e6dfd3] text-xs font-bold transition-all shadow-2xs">
            <i class="fas fa-sitemap text-xs text-[#ff3b30]"></i> <span>XML Sitemap</span>
          </a>
        </div>

        <div class="flex items-center gap-4 text-xs font-medium text-[#6e675f]">
          <a href="#consultation" onclick="const d = document.getElementById('dsGitDrawer'); if(d) { d.classList.add('is-open'); d.setAttribute('aria-hidden', 'false'); } const b = document.getElementById('dsGitBackdrop'); if(b) b.classList.add('is-open');" class="hover:text-[#ff3b30] font-bold">Instant Growth Inquiry</a>
          <span>·</span>
          <a href="{{ route('blogs.index') }}" class="hover:text-[#ff3b30]">Research Lab</a>
          <span>·</span>
          <a href="{{ route('seo.robots') }}" class="hover:text-[#ff3b30]">Robots.txt</a>
        </div>
      </div>

      <!-- Bottom Legal & Attribution Bar -->
      <div class="pt-6 border-t border-[#e6dfd3] flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#6e675f] font-medium">
        <div>
          © {{ date('Y') }} WebRanker Technologies Inc. All Rights Reserved. Engineered for #1 Organic Rankings &amp; Peak Performance.
        </div>

        <div class="flex items-center gap-5 text-xs text-[#7e766e]">
          <a href="#" class="hover:text-[#161514] transition-colors">Privacy Policy</a>
          <a href="#" class="hover:text-[#161514] transition-colors">Terms of Service</a>
          <a href="#" class="hover:text-[#161514] transition-colors">Security &amp; Compliance</a>
        </div>

        <a href="#main-content" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;"
           class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white hover:bg-slate-100 text-[#161514] border border-[#e6dfd3] transition-all text-xs font-bold shadow-2xs">
          <span>Back to top</span>
          <span class="w-5 h-5 rounded-full bg-[#161514] text-white flex items-center justify-center text-[10px]">
            <i class="fas fa-arrow-up"></i>
          </span>
        </a>
      </div>

    </div>
  </footer>

  <!-- ======= FIXED GET IN TOUCH TAB + DYNAMIC INQUIRY DRAWER ======= -->
  <div class="ds-git-backdrop" id="dsGitBackdrop" aria-hidden="true"></div>
  <div class="ds-git-widget" id="dsGetInTouchWidget">
    <aside class="ds-git-drawer" id="dsGitDrawer" aria-hidden="true" aria-labelledby="dsGitDrawerTitle">
      <div class="ds-git-drawer-inner">
        <div class="ds-git-drawer-head">
          <div>
            <p class="consult-form-label">Instant Growth Inquiry</p>
            <h3 id="dsGitDrawerTitle">Send Us a Message</h3>
          </div>
          <button type="button" class="ds-git-drawer-close" id="dsGitCloseBtn" aria-label="Close inquiry form">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <form id="dsContactFormDrawer" class="consult-form ds-git-form" method="POST" action="{{ route('inquiry.store') }}">
          @csrf
          <!-- Anti-spam Honeypot -->
          <input type="text" name="website_hp" style="display:none !important;" tabindex="-1" autocomplete="off">

          <label class="consult-field">
            <span>Your Full Name *</span>
            <input type="text" name="name" required placeholder="Alexander Vance">
          </label>

          <div class="consult-field-row">
            <label class="consult-field">
              <span>Email Address *</span>
              <input type="email" name="email" required placeholder="alex@company.com">
            </label>
            <label class="consult-field">
              <span>Phone Number</span>
              <input type="tel" name="phone" placeholder="+1 (555) 000-0000">
            </label>
          </div>

          <div class="consult-field-row">
            <label class="consult-field">
              <span>Company / Domain</span>
              <input type="text" name="company" placeholder="example.com">
            </label>
            <label class="consult-field">
              <span>Service Interest</span>
              <select name="service_interest" class="w-full px-3 py-2 border rounded-lg bg-white text-sm">
                <option value="Complete Growth Audit">Complete Growth Audit</option>
                <option value="Technical SEO & Rankings">Technical SEO &amp; Rankings</option>
                <option value="Web & Next.js Development">Web &amp; Next.js Development</option>
                <option value="Mobile App Development">Mobile App Development</option>
                <option value="Site Speed & Core Web Vitals">Site Speed &amp; Core Web Vitals</option>
                <option value="AI & Automation Solutions">AI &amp; Automation Solutions</option>
              </select>
            </label>
          </div>

          <label class="consult-field">
            <span>Project Details &amp; Target Keywords</span>
            <textarea name="message" rows="3" placeholder="Tell us about your target keywords, competitors, and growth objectives..."></textarea>
          </label>

          <button type="submit" class="consult-submit" id="submitInquiryBtn">
            <span>Submit Inquiry &amp; Claim Audit</span>
            <i class="fas fa-paper-plane ml-2 text-xs"></i>
          </button>

          <div id="formSuccessMsgDrawer" class="consult-success hidden p-3 mt-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm">
            <i class="fas fa-check-circle mr-1"></i> Thank you! Your inquiry has been logged. A senior architect will review your domain within 24 hours.
          </div>
          <div id="formErrorMsgDrawer" class="hidden p-3 mt-3 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
          </div>
        </form>
      </div>
    </aside>

    <button type="button" class="ds-git-tab" id="dsGitTabBtn" aria-expanded="false" aria-controls="dsGitDrawer">
      <span class="ds-git-tab-text">Get in Touch</span>
    </button>
  </div>

  <!-- ======= 14. FLOATING AI CHATBOT WIDGET ======= -->
  <div id="aiChatbotWidget" class="ds-chat-widget">
    <div id="chatWindow" class="ds-chat-window" aria-hidden="true">
      <div class="ds-chat-window-inner">
        <div class="ds-chat-header">
          <div class="ds-chat-header-id">
            <div class="ds-chat-header-avatar">
              <img src="{{ asset('asset/chatbot_icon.png') }}" alt="WebRanker Assistant" class="ds-chat-header-avatar-img">
            </div>
            <div>
              <h4 class="ds-chat-title">WebRanker Assistant</h4>
              <p class="ds-chat-status"><span class="ds-chat-status-dot"></span> Online · Instant reply</p>
            </div>
          </div>
          <button id="closeChatBtn" class="ds-chat-close" type="button" aria-label="Close chat">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <div id="chatMessages" class="ds-chat-messages">
          <div class="ds-chat-row ds-chat-row--bot">
            <div class="ds-chat-avatar">
              <img src="{{ asset('asset/chatbot_icon.png') }}" alt="Bot">
            </div>
            <div class="ds-chat-bubble ds-chat-bubble--bot">
              Hello! Welcome to WebRanker. Ask about SEO, web design, Core Web Vitals, or claiming your free 48-hour growth audit.
            </div>
          </div>
        </div>

        <div class="ds-chat-composer">
          <input type="text" id="chatInput" placeholder="Ask about SEO, speed, or a project..." autocomplete="off">
          <button type="button" id="sendBtn" class="ds-chat-send" aria-label="Send message">
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- <button id="chatToggleBtn" class="ds-chat-launcher" type="button" aria-label="Open WebRanker Assistant"
      aria-expanded="false">
      <span class="ds-chat-launcher-float">
        <img src="{{ asset('asset/chatbot_icon.png') }}" alt="Chat">
      </span>
    </button> -->
  </div>

  <!-- External JavaScript Libraries -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
  <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

  <!-- Core Custom Interactive Script -->
  <script src="{{ asset('js/custom.js') }}"></script>

  <!-- AJAX Lead Form Handler for Instant Feedback -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const contactForm = document.getElementById('dsContactFormDrawer');
      const successMsg = document.getElementById('formSuccessMsgDrawer');
      const errorMsg = document.getElementById('formErrorMsgDrawer');
      const submitBtn = document.getElementById('submitInquiryBtn');

      if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(contactForm);
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<span>Sending...</span> <i class="fas fa-spinner fa-spin ml-2"></i>';
          errorMsg.classList.add('hidden');

          fetch("{{ route('inquiry.store') }}", {
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
          })
          .then(response => response.json().then(data => ({ status: response.status, body: data })))
          .then(res => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Submit Inquiry &amp; Claim Audit</span> <i class="fas fa-paper-plane ml-2 text-xs"></i>';
            if (res.status === 200 || res.body.success) {
              contactForm.reset();
              successMsg.classList.remove('hidden');
              successMsg.scrollIntoView({ behavior: 'smooth' });
            } else {
              let msg = 'Submission error: ';
              if (res.body.errors) {
                msg += Object.values(res.body.errors).flat().join(' ');
              } else {
                msg += res.body.message || 'Please check your inputs and try again.';
              }
              errorMsg.textContent = msg;
              errorMsg.classList.remove('hidden');
            }
          })
          .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Submit Inquiry &amp; Claim Audit</span> <i class="fas fa-paper-plane ml-2 text-xs"></i>';
            errorMsg.textContent = 'A network error occurred. Please try again or email growth@webranker.com.';
            errorMsg.classList.remove('hidden');
          });
        });
      }
    });
  </script>

  @stack('scripts')
</body>
</html>
