@extends('layouts.app')

@section('content')
  <!-- ======= HERO SECTION — RANKING COMMAND CENTER ======= -->
  <section id="home" class="wr-hero is-ready">
    <div class="wr-hero-bg" aria-hidden="true">
      <div class="wr-hero-grid"></div>
      <div class="wr-hero-glow wr-hero-glow--a"></div>
      <div class="wr-hero-glow wr-hero-glow--b"></div>
    </div>

    <div class="wr-hero-inner">
      <div class="wr-hero-copy">
        <p class="wr-hero-kicker">
          <span class="wr-hero-kicker-dot"></span>
          {{ $homeContent['kicker'] ?? 'SEO, Web Design & Digital Marketing' }}
        </p>
        <h1>
          {!! nl2br(e($homeContent['title'] ?? 'Smooth and grow your business.')) !!}
          <span>{{ $homeContent['title_accent'] ?? 'From search to sales.' }}</span>
        </h1>
        <p class="wr-hero-lead">
          {{ $homeContent['lead'] ?? 'WebRanker is a results-driven digital agency. We design fast, conversion-ready websites and grow brands with SEO, PPC, social, content, and email — so you rank higher, attract the right traffic, and convert it into revenue.' }}
        </p>
        <div class="wr-hero-ctas">
          <a href="{{ $homeContent['cta_link'] ?? '#consultation' }}" class="hero-lab-btn hero-lab-btn--primary">
            <span>{{ $homeContent['cta_text'] ?? 'Claim Free Growth Audit' }}</span>
            <i class="fas fa-arrow-trend-up text-xs"></i>
          </a>
          <a href="{{ $homeContent['secondary_link'] ?? '#services' }}" class="hero-lab-btn hero-lab-btn--ghost">
            <span>{{ $homeContent['secondary_text'] ?? 'See our services' }}</span>
          </a>
        </div>
        <ul class="wr-hero-proof">
          @if(!empty($homeContent['proof_tags']))
            @foreach($homeContent['proof_tags'] as $proof)
              <li><strong>{{ $proof['label'] ?? '' }}</strong><em>{{ $proof['desc'] ?? '' }}</em></li>
            @endforeach
          @else
            <li><strong>SEO</strong><em>Organic rankings</em></li>
            <li><strong>Web</strong><em>Design &amp; build</em></li>
            <li><strong>PPC</strong><em>Paid growth</em></li>
            <li><strong>SMO</strong><em>Social presence</em></li>
          @endif
        </ul>
      </div>

      <div class="wr-hero-visual">
        <div class="rank-hero-dashboard" id="rankHeroDashboard">
          <div class="rank-dashboard-top">
            <div class="flex items-center gap-2">
              <span class="rank-pill-badge">
                <span class="rank-pill-pulse"></span>
                {{ $homeContent['serp_badge'] ?? 'LIVE SERP POSITION #1' }}
              </span>
              <span class="text-xs font-mono text-[#6e675f]">Google search preview</span>
            </div>
            <div class="flex items-center gap-2 text-xs font-bold text-[#10b981]">
              <i class="fas fa-arrow-trend-up"></i>
              <span>{{ $homeContent['serp_sub'] ?? '+318% organic traffic' }}</span>
            </div>
          </div>

          <div class="rank-metrics-row">
            <div class="rank-metric-box">
              <small>Google Rank</small>
              <strong>#1 <span class="trend-up">▲ Top</span></strong>
            </div>
            <div class="rank-metric-box">
              <small>Top 3 SERPs</small>
              <strong>84.6% <span class="trend-up">+142</span></strong>
            </div>
            <div class="rank-metric-box">
              <small>Organic CTR</small>
              <strong>28.4% <span class="trend-up">3.4x</span></strong>
            </div>
            <div class="rank-metric-box">
              <small>PageSpeed</small>
              <strong>99/100 <span class="trend-up">Green</span></strong>
            </div>
          </div>

          <div class="serp-preview-card">
            <div class="serp-header">
              <div class="serp-favicon">
                <i class="fas fa-chart-line text-xs"></i>
              </div>
              <div class="serp-url-meta">
                <strong>WebRanker</strong>
                <span class="serp-url-cite">https://webranker.in › digital-growth</span>
              </div>
              <span class="serp-rank-badge"><i class="fas fa-trophy"></i> Position 1</span>
            </div>
            <h3 class="serp-title">WebRanker — SEO, Web Design &amp; Digital Marketing Agency</h3>
            <p class="serp-snippet">
              Grow online with SEO, PPC, social media, content, email, and high-converting websites. Data-driven strategies for startups, local businesses, and growing brands.
            </p>
            <div class="serp-rich-row">
              <span class="serp-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
              <span><strong>4.9/5</strong> reviews</span>
              <span>·</span>
              <span>USA · Canada · India · Dubai</span>
            </div>
            <div class="serp-sitelinks-grid">
              <div class="serp-sitelink-item">
                <a href="{{ route('services.show', 'seo-services') }}">SEO Services</a>
                <p>Technical audits, local SEO &amp; #1 rankings.</p>
              </div>
              <div class="serp-sitelink-item">
                <a href="{{ route('services.show', 'web-development') }}">Web Design</a>
                <p>Responsive, fast, conversion-focused sites.</p>
              </div>
              <div class="serp-sitelink-item">
                <a href="{{ route('services.show', 'seo-services') }}">Content &amp; SMO</a>
                <p>Authority content and social that converts.</p>
              </div>
              <div class="serp-sitelink-item">
                <a href="#consultation">Free Growth Audit</a>
                <p>Get a 48-hour ranking &amp; website roadmap.</p>
              </div>
            </div>
          </div>

          <form action="#consultation" method="GET" class="rank-audit-bar" onsubmit="event.preventDefault(); document.getElementById('consultation').scrollIntoView({behavior: 'smooth'});">
            <i class="fas fa-magnifying-glass text-[#6e675f] text-sm"></i>
            <input type="text" placeholder="Enter your website or target keyword..." aria-label="Website or keyword audit input">
            <button type="submit" class="rank-audit-btn">
              <span>Check ranking</span>
              <i class="fas fa-arrow-trend-up"></i>
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="wr-hero-footer">
      <div class="marquee-container hero-ai-framework-marquee">
        <div class="marquee-track">
          <div class="tech-marquee-pill"><i class="fas fa-magnifying-glass-chart text-[#ff3b30]"></i><span>SEO Services</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-pen-nib"></i><span>Web Design</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bullseye"></i><span>Pay-Per-Click</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-share-nodes"></i><span>SMO &amp; Social</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-envelope-open-text"></i><span>Email Marketing</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-palette"></i><span>Graphic Design</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-gauge-high"></i><span>Site Speed</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-cart-shopping"></i><span>eCommerce</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-magnifying-glass-chart text-[#ff3b30]"></i><span>SEO Services</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-pen-nib"></i><span>Web Design</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bullseye"></i><span>Pay-Per-Click</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-share-nodes"></i><span>SMO &amp; Social</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-envelope-open-text"></i><span>Email Marketing</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-palette"></i><span>Graphic Design</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-gauge-high"></i><span>Site Speed</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-cart-shopping"></i><span>eCommerce</span></div>
        </div>
      </div>
      <div class="hero-ai-presence">
        <span class="hero-ai-presence-label">Serving clients across</span>
        <span class="hero-ai-presence-item">🇺🇸 USA</span>
        <span class="hero-ai-presence-dot">&middot;</span>
        <span class="hero-ai-presence-item">🇨🇦 Canada</span>
        <span class="hero-ai-presence-dot">&middot;</span>
        <span class="hero-ai-presence-item">🇮🇳 India</span>
        <span class="hero-ai-presence-dot">&middot;</span>
        <span class="hero-ai-presence-item">🇦🇪 Dubai</span>
      </div>
    </div>
  </section>

    <!-- ======= HOW WEBRANKER GROWS YOU ======= -->
    <section id="growth-engine" class="wr-engine">
      <div class="max-w-7xl mx-auto px-6">
        <header class="text-center max-w-3xl mx-auto mb-12 space-y-4">
          <div class="badge-pill-eyebrow mx-auto"><span>HOW WE GROW YOU</span></div>
          <h2 class="text-3xl sm:text-5xl font-extrabold text-[#464f79] tracking-tight text-gradient-3">
            Rank. Design. Convert. Repeat.
          </h2>
          <p class="text-[#6e675f] text-base sm:text-lg leading-relaxed">
            Every WebRanker engagement is built around four growth levers — the same services we deliver for startups, local businesses, and scaling brands.
          </p>
        </header>

        <div class="wr-engine-layout">
          <div class="wr-engine-tabs" role="tablist" aria-label="Growth levers">
            <button type="button" class="wr-engine-tab is-active" data-engine="seo" role="tab" aria-selected="true">
              <span class="wr-engine-tab-num">01</span>
              <span>
                <strong>SEO Services</strong>
                <em>Technical, local &amp; content rankings</em>
              </span>
            </button>
            <button type="button" class="wr-engine-tab" data-engine="web" role="tab" aria-selected="false">
              <span class="wr-engine-tab-num">02</span>
              <span>
                <strong>Web Design &amp; Development</strong>
                <em>Fast, mobile, conversion-first sites</em>
              </span>
            </button>
            <button type="button" class="wr-engine-tab" data-engine="paid" role="tab" aria-selected="false">
              <span class="wr-engine-tab-num">03</span>
              <span>
                <strong>PPC, SMO &amp; Email</strong>
                <em>Paid ads, social, and campaigns</em>
              </span>
            </button>
            <button type="button" class="wr-engine-tab" data-engine="brand" role="tab" aria-selected="false">
              <span class="wr-engine-tab-num">04</span>
              <span>
                <strong>Branding &amp; Graphic Design</strong>
                <em>Identity that earns trust on sight</em>
              </span>
            </button>
          </div>

          <div class="wr-engine-stage ds-clip">
            <article class="wr-engine-pane is-active" data-engine-pane="seo">
              <div class="wr-engine-pane-copy">
                <p class="wr-engine-kicker">Organic search</p>
                <h3>Move from page 4 to position #1</h3>
                <p>Technical audits, Google Business Profile, keyword clusters, and on-page structure that search engines — and shoppers — actually trust.</p>
                <ul>
                  <li>Crawl, index &amp; Core Web Vitals fixes</li>
                  <li>Local SEO + map pack visibility</li>
                  <li>Content that ranks and converts</li>
                </ul>
                <a href="{{ route('services.show', 'seo-services') }}" class="wr-engine-link">Explore SEO services <i class="fas fa-arrow-right"></i></a>
              </div>
              <div class="wr-serp-ladder" aria-hidden="true">
                <div class="wr-serp-row"><span>14</span><b>Competitor local plumber</b></div>
                <div class="wr-serp-row"><span>08</span><b>Generic directory listing</b></div>
                <div class="wr-serp-row"><span>03</span><b>Paid ad overlay</b></div>
                <div class="wr-serp-row is-you"><span>01</span><b>Your brand — WebRanker SEO</b><i>Featured snippet</i></div>
              </div>
            </article>
            <article class="wr-engine-pane" data-engine-pane="web">
              <div class="wr-engine-pane-copy">
                <p class="wr-engine-kicker">Web design</p>
                <h3>Websites that look premium and load fast</h3>
                <p>Responsive WordPress and custom builds, eCommerce stores, landing pages, and redesigns engineered for leads — not just aesthetics.</p>
                <ul>
                  <li>Mobile-first UI/UX &amp; branding</li>
                  <li>SEO-friendly structure from day one</li>
                  <li>Landing pages built to convert</li>
                </ul>
                <a href="{{ route('services.show', 'web-development') }}" class="wr-engine-link">Explore web design <i class="fas fa-arrow-right"></i></a>
              </div>
              <div class="wr-web-preview" aria-hidden="true">
                <div class="wr-web-chrome"><span></span><span></span><span></span><em>yoursite.com</em></div>
                <div class="wr-web-hero-block">
                  <small>LCP 1.2s · 99 PageSpeed</small>
                  <b>Book more customers this week</b>
                  <i></i>
                </div>
                <div class="wr-web-tiles"><span></span><span></span><span></span></div>
              </div>
            </article>
            <article class="wr-engine-pane" data-engine-pane="paid">
              <div class="wr-engine-pane-copy">
                <p class="wr-engine-kicker">Paid &amp; social</p>
                <h3>Traffic you can turn on — and measure</h3>
                <p>Google Ads, Meta campaigns, social creative, and email sequences that capture demand while SEO compounds in the background.</p>
                <ul>
                  <li>PPC with clear ROAS tracking</li>
                  <li>SMO that builds a memorable brand</li>
                  <li>Email that reactivates buyers</li>
                </ul>
                <a href="#consultation" class="wr-engine-link">Plan a campaign <i class="fas fa-arrow-right"></i></a>
              </div>
              <div class="wr-paid-preview" aria-hidden="true">
                <div class="wr-paid-card"><small>Google Ads</small><b>4.8x ROAS</b><em>Search + Performance Max</em></div>
                <div class="wr-paid-card"><small>Meta SMO</small><b>+62% reach</b><em>Creative + community</em></div>
                <div class="wr-paid-card"><small>Email</small><b>31% open rate</b><em>Lifecycle sequences</em></div>
              </div>
            </article>
            <article class="wr-engine-pane" data-engine-pane="brand">
              <div class="wr-engine-pane-copy">
                <p class="wr-engine-kicker">Brand identity</p>
                <h3>Design that makes the ranking worth it</h3>
                <p>Logos, social creatives, and visual systems so every SERP click, ad, and landing page feels like the same trusted brand.</p>
                <ul>
                  <li>Logo &amp; brand systems</li>
                  <li>Social and ad creative</li>
                  <li>UI that supports conversion</li>
                </ul>
                <a href="{{ route('services.show', 'ui-ux-design') }}" class="wr-engine-link">Explore design <i class="fas fa-arrow-right"></i></a>
              </div>
              <div class="wr-brand-preview" aria-hidden="true">
                <div class="wr-brand-swatch is-red"></div>
                <div class="wr-brand-swatch is-ink"></div>
                <div class="wr-brand-swatch is-cream"></div>
                <div class="wr-brand-mark">WR</div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <!-- ======= GLOBAL ACCREDITATIONS & CERTIFICATIONS ======= -->
    <section id="certifications" class="py-20 bg-white border-y border-[#e6dfd3] relative">
      <div class="max-w-7xl mx-auto px-6">
        <header class="text-center max-w-3xl mx-auto mb-14 space-y-3">
          <div class="badge-pill-eyebrow mx-auto">
            <span>OFFICIAL CERTIFICATIONS &amp; ACCREDITATIONS</span>
          </div>
          <h2 class="text-3xl sm:text-4xl font-extrabold text-[#111827] tracking-tight">
            Certified by the World's Leading Tech &amp; Search Authorities
          </h2>
          <p class="text-[#6e675f] text-base leading-relaxed">
            Our search engineers and developers hold verified global credentials from Google, Meta, AWS, ISO, and Semrush.
          </p>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5">
          <!-- Cert 1: Google Partner -->
          <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm text-red-500 text-2xl mb-3">
              <i class="fab fa-google"></i>
            </div>
            <strong class="text-xs font-black text-[#111827] uppercase tracking-wider">Google Partner</strong>
            <span class="text-[11px] text-[#6e675f] mt-1">Premier Certified</span>
          </div>

          <!-- Cert 2: Meta Certified -->
          <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm text-blue-600 text-2xl mb-3">
              <i class="fab fa-meta"></i>
            </div>
            <strong class="text-xs font-black text-[#111827] uppercase tracking-wider">Meta Certified</strong>
            <span class="text-[11px] text-[#6e675f] mt-1">Growth &amp; Media</span>
          </div>

          <!-- Cert 3: ISO 9001:2015 -->
          <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm text-emerald-600 text-xl mb-3">
              <i class="fas fa-award"></i>
            </div>
            <strong class="text-xs font-black text-[#111827] uppercase tracking-wider">ISO 9001:2015</strong>
            <span class="text-[11px] text-[#6e675f] mt-1">Quality Assured</span>
          </div>

          <!-- Cert 4: HubSpot Certified -->
          <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm text-orange-500 text-2xl mb-3">
              <i class="fab fa-hubspot"></i>
            </div>
            <strong class="text-xs font-black text-[#111827] uppercase tracking-wider">HubSpot</strong>
            <span class="text-[11px] text-[#6e675f] mt-1">Inbound Certified</span>
          </div>

          <!-- Cert 5: AWS Certified -->
          <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm text-amber-500 text-2xl mb-3">
              <i class="fab fa-aws"></i>
            </div>
            <strong class="text-xs font-black text-[#111827] uppercase tracking-wider">AWS Cloud</strong>
            <span class="text-[11px] text-[#6e675f] mt-1">Solutions Architect</span>
          </div>

          <!-- Cert 6: Semrush Partner -->
          <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-[#faf7f2] border border-[#e6dfd3] text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm text-rose-500 text-xl mb-3">
              <i class="fas fa-shield-halved"></i>
            </div>
            <strong class="text-xs font-black text-[#111827] uppercase tracking-wider">Semrush Agency</strong>
            <span class="text-[11px] text-[#6e675f] mt-1">Technical SEO Elite</span>
          </div>
        </div>
      </div>
    </section>

  <section id="consultation" class="consult-section">
    <div class="consult-shell-shadow">
      <div class="consult-shell">
        <div class="consult-shell-inner">

          <aside class="consult-stage">
            <div class="consult-stage-grid" aria-hidden="true"></div>
            <div class="consult-stage-inner">
              <div class="consult-kicker">
                <span class="consult-kicker-dot"></span>
                Free 48-Hour Growth Audit
              </div>

              <h2 class="consult-heading">
                Start ranking and converting<br>
                <span>TODAY</span>
              </h2>

              <p class="consult-lead">
                Tell us about your website, rankings, or campaigns. We’ll map SEO, design, ads, and content into a practical 48-hour growth roadmap.
              </p>

              <ol class="consult-steps">
                <li><span>01</span> Technical Audit</li>
                <li><span>02</span> Strategy</li>
                <li><span>03</span> Growth Roadmap</li>
              </ol>

              <div class="consult-contacts">
                <a href="mailto:info@webranker.in" class="consult-contact">
                  <span class="consult-contact-icon"><i class="far fa-envelope"></i></span>
                  <span>
                    <small>E-mail address</small>
                    info@webranker.in
                  </span>
                </a>
                <a href="tel:+919718570218" class="consult-contact">
                  <span class="consult-contact-icon"><i class="fas fa-headset"></i></span>
                  <span>
                    <small>Phone number</small>
                    +91 97185 70218
                  </span>
                </a>
              </div>

              <div class="consult-meta">
                <span>Typical reply within 24h</span>
                <span>USA · Canada · India · Dubai</span>
              </div>
            </div>
          </aside>

          <div class="consult-form-wrap">
            <div class="consult-form-card">
              <div class="consult-form-head">
                <!-- <span class="consult-form-idx">01</span> -->
                <div>
                  <p class="consult-form-label">Inquiry</p>
                  <h3>Send Us a Message</h3>
                </div>
              </div>

              <form id="dsContactForm" class="consult-form" method="POST" action="{{ route('inquiry.store') }}">
                @csrf
                <label class="consult-field">
                  <span>Your Full Name</span>
                  <input type="text" name="name" required placeholder="Enter name here">
                </label>

                <div class="consult-field-row">
                  <label class="consult-field">
                    <span>Phone Number</span>
                    <input type="tel" name="phone" required placeholder="Phone Number">
                  </label>
                  <label class="consult-field">
                    <span>Email Address</span>
                    <input type="email" name="email" required placeholder="Email Address">
                  </label>
                </div>

                <label class="consult-field">
                  <span>Project Message</span>
                  <textarea name="message" rows="4" required placeholder="Drop project details here"></textarea>
                </label>

                <div class="consult-captcha">
                  <span class="consult-field-label">Security Verification</span>
                  <div class="consult-captcha-row">
                    <div id="captchaBox" class="consult-captcha-code"></div>
                    <button type="button" id="captchaRefreshBtn" class="consult-captcha-refresh"
                      aria-label="Refresh captcha">
                      <i class="fas fa-sync-alt"></i>
                    </button>
                    <input type="text" name="captcha" required placeholder="Enter code">
                  </div>
                </div>

                <button type="submit" class="consult-submit">
                  <span>Submit Inquiry</span>
                </button>

                <div id="formSuccessMsg" class="consult-success hidden">
                  Thank you! A WebRanker strategist will contact you shortly.
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <section id="why-webranker" class="py-24 bg-[#fff] border-t border-[#e6dfd3] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
      <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
        <div class="badge-pill-eyebrow"><span>WHY WEBRANKER</span></div>
        <h2 class="text-3xl sm:text-5xl font-extrabold text-[#464f79] tracking-tight text-gradient-3">
          Building digital experiences that deliver real results
        </h2>
        <p class="text-[#6e675f] text-base sm:text-lg leading-relaxed">
          We are a full-service digital agency specializing in Web Design, SEO, Social Media, PPC, Branding, and content — tailored to help businesses succeed online.
        </p>
      </div>

      <div class="ai-feature-showcase space-y-4">
        <div class="ai-feature-tabs-row grid grid-cols-1 sm:grid-cols-2 gap-3">
          <button type="button" data-tab="tab-pane-2"
            class="ai-feature-tab-btn active w-full text-left p-4 sm:p-5 bg-white border border-[#e6dfd3] shadow-sm hover:border-[#161514] transition-all flex items-center justify-between group">
            <div class="flex items-center gap-3 sm:gap-4 min-w-0">
              <div class="w-10 h-10 sm:w-11 sm:h-11 shrink-0 ds-clip-sm bg-[#faf7f2] text-[#161514] flex items-center justify-center text-base sm:text-lg font-bold group-hover:bg-[#161514] transition-all shadow-2xs">
                <i class="fas fa-chart-line"></i>
              </div>
              <div class="min-w-0">
                <h4 class="text-sm sm:text-base font-extrabold text-[#161514] truncate">Result-driven growth consulting</h4>
                <p class="text-xs text-[#6e675f] font-medium truncate">SEO, web, and paid under one roof</p>
              </div>
            </div>
            <i class="fas fa-chevron-right text-xs text-[#6e675f] group-hover:translate-x-1 transition-transform shrink-0 ml-2"></i>
          </button>

          <button type="button" data-tab="tab-pane-3"
            class="ai-feature-tab-btn w-full text-left p-4 sm:p-5 bg-white border border-[#e6dfd3] shadow-sm hover:border-[#161514] transition-all flex items-center justify-between group">
            <div class="flex items-center gap-3 sm:gap-4 min-w-0">
              <div class="w-10 h-10 sm:w-11 sm:h-11 shrink-0 ds-clip-sm bg-[#faf7f2] text-[#161514] flex items-center justify-center text-base sm:text-lg font-bold group-hover:bg-[#161514] transition-all shadow-2xs">
                <i class="fas fa-globe"></i>
              </div>
              <div class="min-w-0">
                <h4 class="text-sm sm:text-base font-extrabold text-[#161514] truncate">Trusted across 4 markets</h4>
                <p class="text-xs text-[#6e675f] font-medium truncate">USA · Canada · India · Dubai</p>
              </div>
            </div>
            <i class="fas fa-chevron-right text-xs text-[#6e675f] group-hover:translate-x-1 transition-transform shrink-0 ml-2"></i>
          </button>
        </div>

        <div class="ai-feature-stage w-full min-h-[420px]">
          <div id="tab-pane-2" class="ai-feature-pane block bg-white border border-[#e6dfd3] ds-clip p-8 sm:p-12 shadow-xl space-y-8 animate-fade-in">
            <div class="flex items-center justify-between flex-wrap gap-4 border-b border-[#e6dfd3] pb-6">
              <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#faf7f2] text-[#e65c00] text-xs font-bold border border-[#e6dfd3]">
                <i class="fas fa-bullseye text-[#e65c00]"></i>
                <span>Growth system, not random tactics</span>
              </div>
              <span class="text-xs font-extrabold text-[#e65c00] uppercase tracking-widest">Transparent reporting</span>
            </div>
            <div class="space-y-3">
              <h3 class="text-2xl sm:text-4xl font-extrabold text-[#161514] leading-snug">
                One team for your website, rankings, and campaigns
              </h3>
              <p class="text-[#6e675f] text-base leading-relaxed font-normal">
                Most brands split web, SEO, and ads across vendors. WebRanker connects them: a site that can rank, content that earns clicks, and campaigns that fill the gaps — with monthly reporting you can actually use.
              </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex items-center gap-3 text-[#161514] text-sm font-semibold bg-[#faf7f2] border border-[#e6dfd3] ds-clip p-4">
                <i class="fas fa-check-circle text-[#e65c00] text-lg"></i>
                <span>SEO + web + paid in one roadmap</span>
              </div>
              <div class="flex items-center gap-3 text-[#161514] text-sm font-semibold bg-[#faf7f2] border border-[#e6dfd3] ds-clip p-4">
                <i class="fas fa-check-circle text-[#e65c00] text-lg"></i>
                <span>Local &amp; national search programs</span>
              </div>
              <div class="flex items-center gap-3 text-[#161514] text-sm font-semibold bg-[#faf7f2] border border-[#e6dfd3] ds-clip p-4">
                <i class="fas fa-check-circle text-[#e65c00] text-lg"></i>
                <span>Industry-specific landing pages</span>
              </div>
              <div class="flex items-center gap-3 text-[#161514] text-sm font-semibold bg-[#faf7f2] border border-[#e6dfd3] ds-clip p-4">
                <i class="fas fa-check-circle text-[#e65c00] text-lg"></i>
                <span>Clear KPIs: traffic, leads, revenue</span>
              </div>
            </div>
            <div class="pt-4">
              <a href="#consultation" class="ai-feature-cta hero-btn-primary-white bg-[#161514] text-white hover:bg-black w-full py-4 text-center justify-center font-extrabold text-sm transition-all duration-300 text-decoration-none inline-flex items-center gap-2">
                <span>Start a project</span>
                <i class="fas fa-rocket text-xs"></i>
              </a>
            </div>
          </div>

          <div id="tab-pane-3" class="ai-feature-pane hidden bg-white border border-[#e6dfd3] ds-clip p-8 sm:p-12 shadow-xl space-y-8 animate-fade-in">
            <div class="flex items-center justify-between flex-wrap gap-4 border-b border-[#e6dfd3] pb-6">
              <span class="text-xs font-extrabold text-[#9c958c] uppercase tracking-wider">CLIENT TRUST</span>
              <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3.5 py-1 rounded-full border border-emerald-200">Verified delivery</span>
            </div>
            <div class="space-y-3">
              <h3 class="text-2xl sm:text-3xl font-extrabold text-[#161514]">Helping brands get found — and chosen</h3>
              <p class="text-[#6e675f] text-base leading-relaxed font-normal">
                From eCommerce catalogs to healthcare and fintech sites, we improve visibility, lead quality, and on-site conversion with strategies matched to each market.
              </p>
            </div>
            <div id="counterSection" class="grid grid-cols-2 gap-6 p-6 ds-clip bg-[#faf7f2] border border-[#e6dfd3] text-center">
              <div>
                <p class="text-4xl sm:text-5xl font-black text-[#161514]"><span class="counter-val" data-target="25">0</span>+</p>
                <p class="text-xs sm:text-sm font-bold text-[#6e675f] mt-2">Industries served</p>
              </div>
              <div>
                <p class="text-4xl sm:text-5xl font-black text-[#e65c00]"><span class="counter-val" data-target="99">0</span>%</p>
                <p class="text-xs sm:text-sm font-bold text-[#6e675f] mt-2">Client satisfaction</p>
              </div>
            </div>
            <div class="pt-4 border-t border-[#e6dfd3] flex items-start gap-4">
              <div class="w-10 h-10 rounded-full bg-[#161514] text-amber-400 flex items-center justify-center text-sm shrink-0 shadow-sm mt-0.5">
                <i class="fas fa-quote-left"></i>
              </div>
              <div>
                <p class="text-sm text-[#6e675f] italic leading-relaxed">"Working with WebRanker has been a game-changer. Their SEO strategies improved our rankings and increased website traffic."</p>
                <p class="text-xs font-extrabold text-[#161514] mt-1.5">Growth client · Local services</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="services" class="py-24 bg-[#faf7f2] border-t border-[#e6dfd3] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Section Sub-Header -->
      <div class="text-center max-w-3xl mx-auto mb-12 space-y-4">
        <div class="badge-pill-eyebrow">
          <span>WEBRANKER SERVICES</span>
        </div>

        <h2 class="text-3xl sm:text-5xl font-extrabold text-[#464f79] tracking-tight text-gradient-3">
          Digital marketing, web, and search — under one roof
        </h2>
        <p class="text-[#6e675f] text-base">
          SEO, web design, PPC, social, content, eCommerce, and ongoing support — the services WebRanker actually delivers to grow traffic and conversions.
        </p>
      </div>

      <!-- Side-by-Side Interactive Service Matrix -->
      <div class="flex flex-col lg:flex-row gap-8 items-stretch">
        <div class="grid grid-cols-1 gap-3 lg:w-[32%] shrink-0 max-h-[620px] overflow-y-auto pr-2" id="svcCardsContainer">
          @forelse($services as $idx => $svc)
            @php
              $svcImg = !empty($svc->og_image) ? asset($svc->og_image) : asset('asset/services/' . $svc->slug . '.jpg');
            @endphp
            <div class="svc-grid-card {{ $idx === 0 ? 'active' : '' }} cursor-pointer"
                 data-svc-title="{{ $svc->title }}"
                 data-svc-desc="{{ $svc->short_description ?? $svc->tagline }}"
                 data-svc-num="({{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }})"
                 data-svc-category="{{ $svc->category }}"
                 data-svc-tags="{{ json_encode($svc->features ?? []) }}"
                 data-svc-link="{{ route('services.show', $svc->slug) }}"
                 data-svc-img="{{ $svcImg }}">
              <div class="flex items-center justify-between mb-2">
                <span class="svc-card-num text-xs font-extrabold px-2.5 py-0.5 rounded-full bg-[#f5efe6] text-[#9c958c]">({{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }})</span>
                <i class="{{ $svc->icon }} text-sm opacity-70 svc-card-icon"></i>
              </div>
              <h4 class="svc-card-title text-[16px] font-extrabold text-[#161514]">{{ $svc->title }}</h4>
            </div>
          @empty
            <div class="svc-grid-card active cursor-pointer"
                 data-svc-title="Web Development Services"
                 data-svc-desc="Full-stack web applications in PHP, Laravel, Next.js, MERN stack, Python, FastAPI, Django, WordPress, Shopify & Headless CMS architectures."
                 data-svc-num="(01)"
                 data-svc-category="Engineering & Architecture"
                 data-svc-tags='["PHP & Laravel", "Next.js & MERN", "Python & FastAPI", "Headless CMS"]'
                 data-svc-link="/services/web-development"
                 data-svc-img="{{ asset('asset/services/web-development.jpg') }}">
              <div class="flex items-center justify-between mb-2">
                <span class="svc-card-num text-xs font-extrabold px-2.5 py-0.5 rounded-full bg-[#f5efe6] text-[#9c958c]">(01)</span>
                <i class="fas fa-code text-sm opacity-70 svc-card-icon"></i>
              </div>
              <h4 class="svc-card-title text-[16px] font-extrabold text-[#161514]">Web Development Services</h4>
            </div>
          @endforelse
        </div>

        @php
          $firstSvc = $services->first();
          $firstSvcImg = $firstSvc && !empty($firstSvc->og_image) 
            ? asset($firstSvc->og_image) 
            : asset('asset/services/web-development.jpg');
        @endphp
        <div class="bg-[#fff] p-8 sm:p-12 ds-clip border border-[#e6dfd3] flex-1">
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

            <!-- Left Stage Details -->
            <div class="lg:col-span-6 space-y-6">
              <div class="flex items-center gap-3">
                <span id="activeSvcNum"
                  class="text-xs font-extrabold text-[#cfa86e] bg-[#161514] px-3.5 py-1 rounded-full">(01)</span>
                <span id="activeSvcCategory" class="text-xs font-bold text-[#6e675f] uppercase tracking-wider">{{ $firstSvc->category ?? 'ENTERPRISE SERVICE' }}</span>
              </div>

              <h3 id="activeSvcTitle" class="text-3xl sm:text-4xl font-extrabold text-[#161514] tracking-tight">
                {{ $firstSvc->title ?? 'Web Development Services' }}
              </h3>

              <p id="activeSvcDesc" class="text-[#6e675f] text-base leading-relaxed">
                {{ $firstSvc->short_description ?? ($firstSvc->tagline ?? 'High-performance web applications, Next.js/React engineering, headless CMS, and scalable SaaS portals built for speed and enterprise velocity.') }}
              </p>

              <div id="activeSvcTags" class="pt-2 flex flex-wrap gap-2">
                @if($firstSvc && !empty($firstSvc->features) && is_array($firstSvc->features))
                  @foreach(array_slice($firstSvc->features, 0, 3) as $f)
                    <span class="svc-pill-tag">{{ $f }}</span>
                  @endforeach
                @else
                  <span class="svc-pill-tag">Next.js &amp; React</span>
                  <span class="svc-pill-tag">Headless Commerce</span>
                  <span class="svc-pill-tag">High-Concurrency APIs</span>
                @endif
              </div>

              <div class="pt-4 flex flex-wrap gap-3">
                <a id="activeSvcLink" href="{{ $firstSvc ? route('services.show', $firstSvc->slug) : '/services/web-development' }}" class="hero-btn-primary-white bg-[#161514] text-white hover:bg-black">
                  <span>Explore Service Details</span>
                  <i class="fas fa-arrow-right text-xs"></i>
                </a>
                <a href="#consultation" class="hero-btn-glass-pill bg-[#faf7f2] text-[#161514] border border-[#e6dfd3] hover:bg-[#161514] hover:text-white">
                  <span>Claim Free Audit</span>
                </a>
              </div>
            </div>

            <!-- Right Stage Graphic Preview Image -->
            <div class="lg:col-span-6">
              <div
                class="ds-clip overflow-hidden border border-[#e6dfd3] shadow-2xl bg-slate-950 h-[340px] flex items-center justify-center p-2 relative group rounded-2xl">
                <img id="stageGraphicImg" src="{{ $firstSvcImg }}" alt="{{ $firstSvc->title ?? 'Service Graphic Preview' }}"
                  class="w-full h-full object-cover rounded-xl transition-all duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent pointer-events-none rounded-xl"></div>
                <div class="absolute bottom-4 left-5 right-5 flex items-center justify-between pointer-events-none">
                  <span id="stageImgBadge" class="px-3 py-1 rounded-full text-[11px] font-bold bg-[#161514]/90 text-white border border-white/10 backdrop-blur-md">
                    {{ $firstSvc->title ?? 'Web Development Services' }}
                  </span>
                  <span class="w-8 h-8 rounded-full bg-white/10 backdrop-blur-md text-white flex items-center justify-center text-xs border border-white/20">
                    <i class="fas fa-arrow-up-right-from-square"></i>
                  </span>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('#svcCardsContainer .svc-grid-card');
      const activeNum = document.getElementById('activeSvcNum');
      const activeCategory = document.getElementById('activeSvcCategory');
      const activeTitle = document.getElementById('activeSvcTitle');
      const activeDesc = document.getElementById('activeSvcDesc');
      const activeTags = document.getElementById('activeSvcTags');
      const activeLink = document.getElementById('activeSvcLink');
      const stageGraphicImg = document.getElementById('stageGraphicImg');
      const stageImgBadge = document.getElementById('stageImgBadge');

      cards.forEach((card) => {
        card.addEventListener('click', function() {
          cards.forEach(c => c.classList.remove('active'));
          card.classList.add('active');

          if (card.dataset.svcTitle && activeTitle) {
            activeTitle.textContent = card.dataset.svcTitle;
          }
          if (card.dataset.svcDesc && activeDesc) {
            activeDesc.textContent = card.dataset.svcDesc;
          }
          if (card.dataset.svcNum && activeNum) {
            activeNum.textContent = card.dataset.svcNum;
          }
          if (card.dataset.svcCategory && activeCategory) {
            activeCategory.textContent = card.dataset.svcCategory;
          }
          if (card.dataset.svcLink && activeLink) {
            activeLink.href = card.dataset.svcLink;
          }
          if (card.dataset.svcImg && stageGraphicImg) {
            stageGraphicImg.style.opacity = '0.3';
            stageGraphicImg.style.transform = 'scale(0.98)';
            setTimeout(() => {
              stageGraphicImg.src = card.dataset.svcImg;
              stageGraphicImg.alt = card.dataset.svcTitle || 'Service Graphic Preview';
              stageGraphicImg.style.opacity = '1';
              stageGraphicImg.style.transform = 'scale(1)';
            }, 180);
          }
          if (card.dataset.svcTitle && stageImgBadge) {
            stageImgBadge.textContent = card.dataset.svcTitle;
          }
          if (card.dataset.svcTags && activeTags) {
            try {
              const tags = JSON.parse(card.dataset.svcTags);
              if (Array.isArray(tags) && tags.length > 0) {
                activeTags.innerHTML = tags.map(t => `<span class="svc-pill-tag">${t}</span>`).join('');
              }
            } catch(e) {}
          }
        });
      });
    });
  </script>

  <!-- ======= 25+ INDUSTRY DOMAINS WE TRANSFORM SECTION ======= -->
  <section id="domains" class="py-24 bg-[#fff] border-t border-[#e6dfd3] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">

      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-12 space-y-4">
        <div class="badge-pill-eyebrow mx-auto">
          <span>25+ WORKING DOMAINS</span>
        </div>
        <h2 class="text-3xl sm:text-5xl font-extrabold text-[#464f79] tracking-tight text-gradient-3">
          Industries We Engineer &amp; Rank
        </h2>
        <p class="text-[#6e675f] text-base sm:text-lg">
          We bring deep domain compliance, high-intent search strategies, and industry-specific architectures to ambitious businesses across every sector.
        </p>

        <!-- Category Filter Tabs -->
        <div class="domain-tabs-nav pt-4">
          <button type="button" class="domain-tab-btn is-active" data-domain-filter="all">All Industries (25+)</button>
          <button type="button" class="domain-tab-btn" data-domain-filter="finance">Finance &amp; Commerce</button>
          <button type="button" class="domain-tab-btn" data-domain-filter="health">Health &amp; Life Sciences</button>
          <button type="button" class="domain-tab-btn" data-domain-filter="enterprise">Tech &amp; Enterprise</button>
          <button type="button" class="domain-tab-btn" data-domain-filter="logistics">Logistics &amp; Industrial</button>
          <button type="button" class="domain-tab-btn" data-domain-filter="lifestyle">Lifestyle &amp; Services</button>
        </div>
      </div>

      <!-- Domains Matrix Grid -->
      <div class="domains-grid-matrix" id="domainsGrid">

        <!-- 1. E-commerce & Retail -->
        <div class="domain-card-item" data-domain-cat="finance">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-bag-shopping"></i></div>
            <span class="domain-tag-badge">Commerce</span>
          </div>
          <h3 class="domain-card-title">E-commerce &amp; Retail</h3>
          <p class="domain-card-desc">Headless Shopify Plus, sub-500ms catalog filtering, checkout CRO, and multi-tier omnichannel POS integrations.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">+42% Checkout CR</span>
            <a href="{{ route('blogs.index', ['category' => 'ecommerce']) }}" class="domain-card-link"><span>Case Guide</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 2. FinTech & Banking -->
        <div class="domain-card-item" data-domain-cat="finance">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-building-columns"></i></div>
            <span class="domain-tag-badge">Finance</span>
          </div>
          <h3 class="domain-card-title">FinTech &amp; Banking</h3>
          <p class="domain-card-desc">Bank-grade PCI-DSS compliance, real-time ledger sync, zero-trust tokenization, and biometric authentication wallets.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Zero-Trust / SOC2</span>
            <a href="{{ route('blogs.index', ['category' => 'fintech']) }}" class="domain-card-link"><span>Case Guide</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 3. Healthcare & Medical -->
        <div class="domain-card-item" data-domain-cat="health">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-heart-pulse"></i></div>
            <span class="domain-tag-badge">Healthcare</span>
          </div>
          <h3 class="domain-card-title">Healthcare &amp; Medical</h3>
          <p class="domain-card-desc">HIPAA-compliant patient portals, WebRTC telehealth video, automated EHR/FHIR integrations, and medical SEO.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">HIPAA BAA</span>
            <a href="{{ route('blogs.index', ['category' => 'healthcare']) }}" class="domain-card-link"><span>Case Guide</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 4. Real Estate & Property (PropTech) -->
        <div class="domain-card-item" data-domain-cat="finance">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-city"></i></div>
            <span class="domain-tag-badge">PropTech</span>
          </div>
          <h3 class="domain-card-title">Real Estate &amp; PropTech</h3>
          <p class="domain-card-desc">Interactive RESO MLS property feeds, map-based search, 3D digital tours, and localized geo-targeted SEO dominance.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">MLS / IDX Feeds</span>
            <a href="#consultation" class="domain-card-link"><span>Build Portal</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 5. Legal & Law -->
        <div class="domain-card-item" data-domain-cat="enterprise">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-scale-balanced"></i></div>
            <span class="domain-tag-badge">Legal</span>
          </div>
          <h3 class="domain-card-title">Legal &amp; Law</h3>
          <p class="domain-card-desc">Secure client matter intake, encrypted document vaults, digital signatures, and practice-area organic ranking.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">E-Sign &amp; Vaults</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 6. Education & E-Learning -->
        <div class="domain-card-item" data-domain-cat="lifestyle">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-graduation-cap"></i></div>
            <span class="domain-tag-badge">EdTech</span>
          </div>
          <h3 class="domain-card-title">Education &amp; E-Learning</h3>
          <p class="domain-card-desc">Custom LMS architectures, SCORM compliance, live virtual classroom streaming, and student progress tracking.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">LMS / SCORM</span>
            <a href="#consultation" class="domain-card-link"><span>Build LMS</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 7. Travel & Hospitality -->
        <div class="domain-card-item" data-domain-cat="lifestyle">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-plane-departure"></i></div>
            <span class="domain-tag-badge">Travel</span>
          </div>
          <h3 class="domain-card-title">Travel &amp; Hospitality</h3>
          <p class="domain-card-desc">Central booking engines, GDS/OTA channel managers, dynamic seasonal pricing algorithms, and mobile guest keys.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">OTA / GDS Sync</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 8. Logistics & Transportation -->
        <div class="domain-card-item" data-domain-cat="logistics">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-truck-fast"></i></div>
            <span class="domain-tag-badge">Logistics</span>
          </div>
          <h3 class="domain-card-title">Logistics &amp; Transportation</h3>
          <p class="domain-card-desc">Real-time GPS fleet telematics, dispatch route optimization, warehouse WMS systems, and carrier load boards.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">GPS Telematics</span>
            <a href="#consultation" class="domain-card-link"><span>Optimize</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 9. Insurance -->
        <div class="domain-card-item" data-domain-cat="finance">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-shield-halved"></i></div>
            <span class="domain-tag-badge">InsurTech</span>
          </div>
          <h3 class="domain-card-title">Insurance</h3>
          <p class="domain-card-desc">Instant policy quoting engines, automated FNOL claim submission, underwriting risk calculators, and policyholder portals.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Instant Quotes</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 10. Automotive -->
        <div class="domain-card-item" data-domain-cat="logistics">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-car"></i></div>
            <span class="domain-tag-badge">AutoTech</span>
          </div>
          <h3 class="domain-card-title">Automotive</h3>
          <p class="domain-card-desc">VIN-decoding inventory portals, dealer management DMS sync, digital test-drive booking, and EV charger network maps.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">VIN / DMS Feeds</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 11. Food & Restaurant -->
        <div class="domain-card-item" data-domain-cat="lifestyle">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-utensils"></i></div>
            <span class="domain-tag-badge">FoodTech</span>
          </div>
          <h3 class="domain-card-title">Food &amp; Restaurant</h3>
          <p class="domain-card-desc">Commission-free online ordering, kitchen KDS display routing, table reservation sync, and multi-location menus.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">0% Commission</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 12. Entertainment & Media -->
        <div class="domain-card-item" data-domain-cat="lifestyle">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-film"></i></div>
            <span class="domain-tag-badge">Media</span>
          </div>
          <h3 class="domain-card-title">Entertainment &amp; Media</h3>
          <p class="domain-card-desc">Low-latency HLS video streaming, digital rights DRM licensing, paid subscription paywalls, and high-traffic landers.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">HLS Streaming</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 13. Manufacturing -->
        <div class="domain-card-item" data-domain-cat="logistics">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-industry"></i></div>
            <span class="domain-tag-badge">Industry 4.0</span>
          </div>
          <h3 class="domain-card-title">Manufacturing</h3>
          <p class="domain-card-desc">IoT machine telemetry dashboards, predictive maintenance alerts, custom ERP/MRP bridges, and supplier portals.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">IoT Telemetry</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 14. Construction -->
        <div class="domain-card-item" data-domain-cat="logistics">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-trowel-bricks"></i></div>
            <span class="domain-tag-badge">ConTech</span>
          </div>
          <h3 class="domain-card-title">Construction</h3>
          <p class="domain-card-desc">Jobsite field reporting, subcontractor bid management, blueprint revision tracking, and project budget oversight.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Blueprint Sync</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 15. SaaS & Technology -->
        <div class="domain-card-item" data-domain-cat="enterprise">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-cloud"></i></div>
            <span class="domain-tag-badge">SaaS</span>
          </div>
          <h3 class="domain-card-title">SaaS &amp; Technology</h3>
          <p class="domain-card-desc">High-converting product landing engines, self-serve onboarding funnels, Stripe billing, and programmatic SEO dominance.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Product-Led Growth</span>
            <a href="{{ route('blogs.index', ['category' => 'saas']) }}" class="domain-card-link"><span>Case Guide</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 16. Government & Public Sector -->
        <div class="domain-card-item" data-domain-cat="enterprise">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-landmark"></i></div>
            <span class="domain-tag-badge">GovTech</span>
          </div>
          <h3 class="domain-card-title">Government &amp; Public Sector</h3>
          <p class="domain-card-desc">WCAG 2.1 AAA accessible citizen portals, digital permit processing, secure municipal databases, and FOIA compliance.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">WCAG 2.1 AAA</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 17. Fitness & Wellness -->
        <div class="domain-card-item" data-domain-cat="health">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-dumbbell"></i></div>
            <span class="domain-tag-badge">Wellness</span>
          </div>
          <h3 class="domain-card-title">Fitness &amp; Wellness</h3>
          <p class="domain-card-desc">Gym membership recurring billing, on-demand workout streaming, trainer booking, and wearable health tracker syncing.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Apple Health Sync</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 18. Recruitment & HR -->
        <div class="domain-card-item" data-domain-cat="enterprise">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-user-tie"></i></div>
            <span class="domain-tag-badge">HRTech</span>
          </div>
          <h3 class="domain-card-title">Recruitment &amp; HR</h3>
          <p class="domain-card-desc">ATS job board aggregators, automated AI resume parsing, candidate interview schedulers, and employee onboarding portals.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">ATS &amp; Parsing</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 19. Sports -->
        <div class="domain-card-item" data-domain-cat="lifestyle">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-baseball-bat-ball"></i></div>
            <span class="domain-tag-badge">Sports</span>
          </div>
          <h3 class="domain-card-title">Sports</h3>
          <p class="domain-card-desc">Live match scoreboards, league tournament brackets, fantasy league engines, and team merchandising stores.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Sub-Second Live</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 20. Events & Ticketing -->
        <div class="domain-card-item" data-domain-cat="lifestyle">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-ticket"></i></div>
            <span class="domain-tag-badge">Ticketing</span>
          </div>
          <h3 class="domain-card-title">Events &amp; Ticketing</h3>
          <p class="domain-card-desc">High-concurrency ticket queuing systems, interactive SVG seat pickers, QR barcode scanning apps, and anti-scalping logic.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Zero Scalping</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 21. Energy & Utilities -->
        <div class="domain-card-item" data-domain-cat="logistics">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-bolt-lightning"></i></div>
            <span class="domain-tag-badge">Energy</span>
          </div>
          <h3 class="domain-card-title">Energy &amp; Utilities</h3>
          <p class="domain-card-desc">Smart grid energy monitoring, solar production estimators, commercial utility billing, and regulatory consumption reports.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Smart Grid Sync</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 22. Agriculture & AgTech -->
        <div class="domain-card-item" data-domain-cat="logistics">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-wheat-awn"></i></div>
            <span class="domain-tag-badge">AgTech</span>
          </div>
          <h3 class="domain-card-title">Agriculture &amp; AgTech</h3>
          <p class="domain-card-desc">Satellite crop yield analysis, automated soil moisture sensor hubs, supply chain harvest tracking, and farming ERPs.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Sensor Telemetry</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 23. Pharma & Life Sciences -->
        <div class="domain-card-item" data-domain-cat="health">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-capsules"></i></div>
            <span class="domain-tag-badge">Pharma</span>
          </div>
          <h3 class="domain-card-title">Pharma &amp; Life Sciences</h3>
          <p class="domain-card-desc">FDA 21 CFR Part 11 electronic records, clinical trial participant portals, secure batch tracking, and pharmaceutical knowledge hubs.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">21 CFR Part 11</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

        <!-- 24. Marketing & Advertising -->
        <div class="domain-card-item" data-domain-cat="enterprise">
          <div class="domain-card-top">
            <div class="domain-card-icon"><i class="fas fa-chart-line"></i></div>
            <span class="domain-tag-badge">AdTech</span>
          </div>
          <h3 class="domain-card-title">Marketing &amp; Advertising</h3>
          <p class="domain-card-desc">Custom programmatic ad servers, attribution modeling dashboards, lead routing webhooks, and conversion tracking engines.</p>
          <div class="domain-card-footer">
            <span class="domain-metric-badge">Multi-Touch Attrib</span>
            <a href="#consultation" class="domain-card-link"><span>Explore</span><i class="fas fa-arrow-right text-xs"></i></a>
          </div>
        </div>

      </div>

      <!-- Domain Section Bottom CTA -->
      <div class="mt-16 text-center bg-[#faf7f2] border border-[#e6dfd3] ds-clip p-8 sm:p-12">
        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#161514] mb-3">Don't See Your Specific Industry Listed?</h3>
        <p class="text-[#6e675f] text-sm sm:text-base max-w-2xl mx-auto mb-6">
          Our custom software architects and enterprise SEO directors have engineered specialized solutions across 50+ unique niches. Talk directly with our senior leads.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
          <a href="{{ route('industries.index') }}" class="hero-lab-btn hero-lab-btn--primary inline-flex">
            <span>Explore All 25+ Industry Solutions</span>
            <i class="fas fa-arrow-right text-xs"></i>
          </a>
          <a href="#consultation" class="px-6 py-3.5 rounded-xl bg-white hover:bg-slate-50 text-slate-800 text-xs font-extrabold uppercase tracking-wider border border-[#e6dfd3] shadow-sm transition-all inline-flex items-center gap-2">
            <span>Discuss Custom Domain</span>
            <i class="fas fa-comments text-xs"></i>
          </a>
        </div>
      </div>

    </div>
  </section>

  <!-- ======= 7. CONNECTED AI PRODUCTS & TOOLS NODE STAGE (EXACT REFERENCE MATCH) ======= -->
  <section id="products"
    class="ai-tools-node-section py-24 bg-[#fff] border-t border-[#e6dfd3] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">

      <!-- Top Eyebrow Tag -->
      <div class="text-center mb-4">
        <div
          class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-gray-200 text-gray-700 text-xs font-bold shadow-xs">
          <span class="w-2 h-2 rounded-full bg-[#ff4500]"></span>
          <span>GROWTH STACK</span>
        </div>
      </div>

      <!-- Main Headline & Subtitle -->
      <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
        <h2 class="text-4xl sm:text-6xl font-extrabold text-[#464f79] tracking-tight leading-tight text-gradient-3">
          The WebRanker growth stack
        </h2>
        <p class="text-gray-500 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto font-normal">
          SEO, web, paid media, social, content, and speed — connected so every channel supports the same growth goal.
        </p>
      </div>

      <!-- Connected AI Node Stage Canvas (ULTRA-COMPACT LINES & FLUSH TOUCHING CENTER LOGO) -->
      <div class="ai-tools-stage-wrapper">

        <!-- SVG Connection Lines (COMPACT VERTICAL EXIT & FLUSH LOGO TOUCH POINTS) -->
        <svg class="ai-tools-connections-svg" viewBox="0 0 960 440" fill="none" xmlns="http://www.w3.org/2000/svg">

          <!-- Top Left Path: Out from Center Box Top, UP 26px -> LEFT -> UP to Top-Left Card -->
          <path d="M 410 188 L 410 162 Q 410 152 395 152 L 193 152 Q 178 152 178 134 L 178 116" stroke="#dfdfdf"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          <circle r="3" fill="#ff4500" style="filter: drop-shadow(0 0 6px #ff4500);">
            <animateMotion path="M 410 188 L 410 162 Q 410 152 395 152 L 193 152 Q 178 152 178 134 L 178 116" dur="2.5s"
              repeatCount="indefinite" />
          </circle>

          <!-- Mid Left Path: Straight Horizontal Line TOUCHING Center Box Left Flush -->
          <path d="M 382 220 L 126 220" stroke="#dfdfdf" stroke-width="1.5" stroke-linecap="round" />
          <rect x="-8" y="-1.5" width="16" height="2.5" rx="2.5" fill="#ff4500"
            style="filter: drop-shadow(0 0 6px #ff4500);">
            <animateMotion path="M 382 220 L 126 220" dur="2.5s" repeatCount="indefinite" />
          </rect>

          <!-- Bottom Left Path: Out from Center Box Bottom, DOWN 26px -> LEFT -> DOWN to Bottom-Left Card -->
          <path d="M 410 252 L 410 278 Q 410 288 395 288 L 193 288 Q 178 288 178 306 L 178 324" stroke="#dfdfdf"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          <circle r="3" fill="#ff4500" style="filter: drop-shadow(0 0 6px #ff4500);">
            <animateMotion path="M 410 252 L 410 278 Q 410 288 395 288 L 193 288 Q 178 288 178 306 L 178 324" dur="2.5s"
              repeatCount="indefinite" />
          </circle>

          <!-- Top Right Path: Out from Center Box Top, UP 26px -> RIGHT -> UP to Top-Right Card -->
          <path d="M 550 188 L 550 162 Q 550 152 565 152 L 767 152 Q 782 152 782 134 L 782 116" stroke="#dfdfdf"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          <circle r="3" fill="#ff4500" style="filter: drop-shadow(0 0 6px #ff4500);">
            <animateMotion path="M 550 188 L 550 162 Q 550 152 565 152 L 767 152 Q 782 152 782 134 L 782 116" dur="2.5s"
              repeatCount="indefinite" />
          </circle>

          <!-- Mid Right Path: Straight Horizontal Line TOUCHING Center Box Right Flush -->
          <path d="M 578 220 L 834 220" stroke="#dfdfdf" stroke-width="1.5" stroke-linecap="round" />
          <rect x="-8" y="-1.5" width="16" height="2.5" rx="2.5" fill="#ff4500"
            style="filter: drop-shadow(0 0 6px #ff4500);">
            <animateMotion path="M 578 220 L 834 220" dur="2.5s" repeatCount="indefinite" />
          </rect>

          <!-- Bottom Right Path: Out from Center Box Bottom, DOWN 26px -> RIGHT -> DOWN to Bottom-Right Card -->
          <path d="M 550 252 L 550 278 Q 550 288 565 288 L 767 288 Q 782 288 782 306 L 782 324" stroke="#dfdfdf"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          <circle r="3" fill="#ff4500" style="filter: drop-shadow(0 0 6px #ff4500);">
            <animateMotion path="M 550 252 L 550 278 Q 550 288 565 288 L 767 288 Q 782 288 782 306 L 782 324" dur="2.5s"
              repeatCount="indefinite" />
          </circle>

        </svg>

        <!-- Center Core Badge -->
        <div class="ai-tools-center-badge wr-stack-core">
          <span>Web<span>Ranker</span></span>
        </div>

        <a href="#consultation" class="ai-tools-btn-start">
          <span>Get Started</span>
        </a>

        <a href="{{ route('services.show', 'seo-services') }}" class="ai-tool-node-card wr-stack-node" style="left: 140px; top: 40px;" title="SEO Services">
          <i class="fas fa-magnifying-glass-chart"></i><em>SEO</em>
        </a>
        <a href="{{ route('services.show', 'web-development') }}" class="ai-tool-node-card wr-stack-node" style="left: 50px; top: 182px;" title="Web Design">
          <i class="fas fa-code"></i><em>Web</em>
        </a>
        <a href="{{ route('services.show', 'seo-services') }}" class="ai-tool-node-card wr-stack-node" style="left: 140px; top: 324px;" title="Content">
          <i class="fas fa-pen-nib"></i><em>Content</em>
        </a>
        <a href="#consultation" class="ai-tool-node-card wr-stack-node" style="left: 744px; top: 40px;" title="PPC">
          <i class="fas fa-bullseye"></i><em>PPC</em>
        </a>
        <a href="#consultation" class="ai-tool-node-card wr-stack-node" style="left: 834px; top: 182px;" title="SMO">
          <i class="fas fa-share-nodes"></i><em>SMO</em>
        </a>
        <a href="{{ route('services.show', 'site-optimization') }}" class="ai-tool-node-card wr-stack-node" style="left: 744px; top: 324px;" title="Speed">
          <i class="fas fa-gauge-high"></i><em>Speed</em>
        </a>
      </div>

    </div>
  </section>

    <!-- ======= AI PLAYGROUNDS — INDUSTRY & LAB SHOWCASE ======= -->
    <section id="ai-playgrounds" class="ai-playgrounds-section py-24 relative overflow-hidden">
      <div class="ai-playgrounds-bg" aria-hidden="true">
        <div class="ai-playgrounds-mesh"></div>
        <div class="ai-playgrounds-grid"></div>
        <div class="ai-playgrounds-orb ai-playgrounds-orb--1"></div>
        <div class="ai-playgrounds-orb ai-playgrounds-orb--2"></div>
        <div class="ai-playgrounds-orb ai-playgrounds-orb--3"></div>
        <svg class="ai-playgrounds-neural" viewBox="0 0 1200 600" preserveAspectRatio="xMidYMid slice">
          <circle class="ai-playgrounds-node" cx="180" cy="120" r="4"/>
          <circle class="ai-playgrounds-node" cx="420" cy="80" r="4"/>
          <circle class="ai-playgrounds-node" cx="680" cy="140" r="4"/>
          <circle class="ai-playgrounds-node" cx="920" cy="90" r="4"/>
          <circle class="ai-playgrounds-node" cx="1050" cy="220" r="4"/>
          <circle class="ai-playgrounds-node" cx="260" cy="380" r="4"/>
          <circle class="ai-playgrounds-node" cx="540" cy="420" r="4"/>
          <circle class="ai-playgrounds-node" cx="840" cy="360" r="4"/>
          <line class="ai-playgrounds-link" x1="180" y1="120" x2="420" y2="80"/>
          <line class="ai-playgrounds-link" x1="420" y1="80" x2="680" y2="140"/>
          <line class="ai-playgrounds-link" x1="680" y1="140" x2="920" y2="90"/>
          <line class="ai-playgrounds-link" x1="920" y1="90" x2="1050" y2="220"/>
          <line class="ai-playgrounds-link" x1="180" y1="120" x2="260" y2="380"/>
          <line class="ai-playgrounds-link" x1="420" y1="80" x2="540" y2="420"/>
          <line class="ai-playgrounds-link" x1="680" y1="140" x2="840" y2="360"/>
          <line class="ai-playgrounds-link" x1="540" y1="420" x2="840" y2="360"/>
        </svg>
      </div>
  
      <div class="max-w-7xl mx-auto px-6 relative z-10">
  
        <div class="ai-playgrounds-head">
          <div class="ai-playgrounds-head-copy">
            <div class="ai-playgrounds-head-badge">
              <span class="ai-playgrounds-head-badge-dot"></span>
              <span>RESULTS IN MARKET</span>
            </div>
            <h2 class="text-3xl sm:text-5xl font-extrabold text-[#464f79] tracking-tight text-gradient-3">
              Featured growth work
            </h2>
            <p class="text-[#6e675f] text-base sm:text-lg max-w-2xl leading-relaxed">
              See how we apply SEO, web, and conversion work across eCommerce, healthcare, fintech, and SaaS.
            </p>
            <div class="ai-playgrounds-chips">
              <span class="ai-playgrounds-chip"><i class="fas fa-magnifying-glass-chart"></i> SEO · Web · Paid</span>
              <span class="ai-playgrounds-chip"><i class="fas fa-bolt"></i> Fast websites</span>
              <span class="ai-playgrounds-chip"><i class="fas fa-globe"></i> USA · Canada · India · Dubai</span>
            </div>
          </div>
  
          <div class="ai-playgrounds-controls">
            <div class="ai-playgrounds-nav-pill">
              <button id="prevPlaygroundBtn" class="ai-playgrounds-nav-btn" title="Previous Playground" aria-label="Previous playground">
                <i class="fas fa-arrow-left text-xs"></i>
              </button>
              <span class="ai-playgrounds-nav-divider"></span>
              <button id="nextPlaygroundBtn" class="ai-playgrounds-nav-btn" title="Next Playground" aria-label="Next playground">
                <i class="fas fa-arrow-right text-xs"></i>
              </button>
            </div>
          </div>
        </div>
  
        <div class="ai-playgrounds-stage ds-clip">
          <div class="ai-playgrounds-stage-inner">
            <div class="ai-play-carousel-wrap">
  
              <div id="playgroundCarousel" class="owl-carousel owl-theme ai-play-carousel">
                <div class="item">
                  <a href="{{ route('blogs.show', 'ecommerce-seo-conversion-optimization-guide') }}" class="ai-play-card text-decoration-none">
                    <article class="ai-play-card-shell ds-clip-sm">
                      <div class="ai-play-card-browser">
                        <div class="ai-play-card-chrome">
                          <span class="ai-play-card-dot is-red"></span>
                          <span class="ai-play-card-dot is-amber"></span>
                          <span class="ai-play-card-dot is-green"></span>
                          <span class="ai-play-card-url">webranker.in/ecommerce</span>
                        </div>
                        <div class="ai-play-card-media">
                          <img src="{{ asset('asset/agp-lab-ecom.jpg') }}" alt="E-commerce SEO" loading="lazy">
                          <div class="ai-play-card-hover">
                            <span class="ai-play-card-hover-btn">View story <i class="fas fa-arrow-up-right-from-square"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="ai-play-card-meta">
                        <div class="ai-play-card-icon is-industry"><i class="fas fa-bag-shopping"></i></div>
                        <div class="ai-play-card-copy">
                          <span class="ai-play-card-tag ai-play-card-tag--industry">SEO + CRO</span>
                          <h3 class="ai-play-card-title">E-commerce ranking &amp; conversion</h3>
                          <p class="ai-play-card-desc">Catalog SEO, site speed, and checkout CRO for stores that need more sales.</p>
                        </div>
                        <span class="ai-play-card-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                      </div>
                    </article>
                  </a>
                </div>
                <div class="item">
                  <a href="{{ route('services.show', 'web-development') }}" class="ai-play-card text-decoration-none">
                    <article class="ai-play-card-shell ds-clip-sm">
                      <div class="ai-play-card-browser">
                        <div class="ai-play-card-chrome">
                          <span class="ai-play-card-dot is-red"></span>
                          <span class="ai-play-card-dot is-amber"></span>
                          <span class="ai-play-card-dot is-green"></span>
                          <span class="ai-play-card-url">webranker.in/web-design</span>
                        </div>
                        <div class="ai-play-card-media">
                          <img src="{{ asset('asset/svc-1.png') }}" alt="Web design" loading="lazy">
                          <div class="ai-play-card-hover">
                            <span class="ai-play-card-hover-btn">View story <i class="fas fa-arrow-up-right-from-square"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="ai-play-card-meta">
                        <div class="ai-play-card-icon is-lab"><i class="fas fa-pen-nib"></i></div>
                        <div class="ai-play-card-copy">
                          <span class="ai-play-card-tag">Web Design</span>
                          <h3 class="ai-play-card-title">High-converting business websites</h3>
                          <p class="ai-play-card-desc">Responsive, SEO-ready websites and landing pages built to generate leads.</p>
                        </div>
                        <span class="ai-play-card-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                      </div>
                    </article>
                  </a>
                </div>
                <div class="item">
                  <a href="{{ route('blogs.show', 'fintech-seo-content-marketing-strategy') }}" class="ai-play-card text-decoration-none">
                    <article class="ai-play-card-shell ds-clip-sm">
                      <div class="ai-play-card-browser">
                        <div class="ai-play-card-chrome">
                          <span class="ai-play-card-dot is-red"></span>
                          <span class="ai-play-card-dot is-amber"></span>
                          <span class="ai-play-card-dot is-green"></span>
                          <span class="ai-play-card-url">webranker.in/fintech</span>
                        </div>
                        <div class="ai-play-card-media">
                          <img src="{{ asset('asset/da-lab-finance.jpg') }}" alt="Fintech SEO" loading="lazy">
                          <div class="ai-play-card-hover">
                            <span class="ai-play-card-hover-btn">View story <i class="fas fa-arrow-up-right-from-square"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="ai-play-card-meta">
                        <div class="ai-play-card-icon is-industry"><i class="fas fa-building-columns"></i></div>
                        <div class="ai-play-card-copy">
                          <span class="ai-play-card-tag ai-play-card-tag--industry">Fintech</span>
                          <h3 class="ai-play-card-title">Fintech SEO &amp; trust content</h3>
                          <p class="ai-play-card-desc">Authority content and technical SEO for financial products that must earn trust.</p>
                        </div>
                        <span class="ai-play-card-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                      </div>
                    </article>
                  </a>
                </div>
                <div class="item">
                  <a href="{{ route('blogs.show', 'healthcare-web-development-hipaa-compliance') }}" class="ai-play-card text-decoration-none">
                    <article class="ai-play-card-shell ds-clip-sm">
                      <div class="ai-play-card-browser">
                        <div class="ai-play-card-chrome">
                          <span class="ai-play-card-dot is-red"></span>
                          <span class="ai-play-card-dot is-amber"></span>
                          <span class="ai-play-card-dot is-green"></span>
                          <span class="ai-play-card-url">webranker.in/healthcare</span>
                        </div>
                        <div class="ai-play-card-media">
                          <img src="{{ asset('asset/da-lab-health.jpg') }}" alt="Healthcare web" loading="lazy">
                          <div class="ai-play-card-hover">
                            <span class="ai-play-card-hover-btn">View story <i class="fas fa-arrow-up-right-from-square"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="ai-play-card-meta">
                        <div class="ai-play-card-icon is-industry"><i class="fas fa-heart-pulse"></i></div>
                        <div class="ai-play-card-copy">
                          <span class="ai-play-card-tag ai-play-card-tag--industry">Healthcare</span>
                          <h3 class="ai-play-card-title">Healthcare web &amp; local SEO</h3>
                          <p class="ai-play-card-desc">HIPAA-aware websites, Google Business, and patient-intent landing pages.</p>
                        </div>
                        <span class="ai-play-card-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                      </div>
                    </article>
                  </a>
                </div>
                <div class="item">
                  <a href="{{ route('blogs.show', 'technical-seo-audit-checklist-enterprise') }}" class="ai-play-card text-decoration-none">
                    <article class="ai-play-card-shell ds-clip-sm">
                      <div class="ai-play-card-browser">
                        <div class="ai-play-card-chrome">
                          <span class="ai-play-card-dot is-red"></span>
                          <span class="ai-play-card-dot is-amber"></span>
                          <span class="ai-play-card-dot is-green"></span>
                          <span class="ai-play-card-url">webranker.in/seo</span>
                        </div>
                        <div class="ai-play-card-media">
                          <img src="{{ asset('asset/awp-lab-search.jpg') }}" alt="Technical SEO" loading="lazy">
                          <div class="ai-play-card-hover">
                            <span class="ai-play-card-hover-btn">View story <i class="fas fa-arrow-up-right-from-square"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="ai-play-card-meta">
                        <div class="ai-play-card-icon is-lab"><i class="fas fa-magnifying-glass-chart"></i></div>
                        <div class="ai-play-card-copy">
                          <span class="ai-play-card-tag">Technical SEO</span>
                          <h3 class="ai-play-card-title">Enterprise technical SEO audits</h3>
                          <p class="ai-play-card-desc">Crawl, index, schema, and Core Web Vitals programs for competitive SERPs.</p>
                        </div>
                        <span class="ai-play-card-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                      </div>
                    </article>
                  </a>
                </div>
              </div>
            </div>
  
            <div class="ai-playgrounds-foot">
              <div id="playgroundCarouselDots" class="ai-play-carousel-dots"></div>
              <!-- <p class="ai-playgrounds-foot-note"><i class="fas fa-mouse-pointer"></i> Hover to preview · Click to open full experience</p> -->
            </div>
          </div>
        </div>
      </div>
    </section>

  <!-- ======= 8. TECHNOLOGY STACK 3-ROW INFINITE MARQUEE (ULTRA-WIDE 4X SEAMLESS LOOP) ======= -->
  <section id="techstack" class="py-24 bg-white border-t border-[#e6dfd3] overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 mb-12 text-center">
      <div class="badge-pill-eyebrow mb-3">
        <span>TECHNOLOGY STACK</span>
      </div>
      <h2 class="text-3xl sm:text-5xl font-extrabold text-[#464f79] tracking-tight text-gradient-3">
        The stack behind ranking websites
      </h2>
      <p class="text-[#6e675f] text-base max-w-xl mx-auto mt-2">
        Search, analytics, ads, and modern web platforms we use to design, rank, and grow your digital presence.
      </p>
    </div>

    <!-- 3-Row Ultra-Wide Infinite Marquee -->
    <div class="space-y-4">
      <div class="marquee-container">
        <div class="marquee-track">
          <!-- Set 1 -->
          <div class="tech-marquee-pill"><i class="fab fa-wordpress text-sky-700"></i><span>WordPress</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-react text-cyan-600"></i><span>React &amp; Next.js</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-shopify text-emerald-600"></i><span>Shopify</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-search text-red-500"></i><span>Google Search Console</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-chart-line text-amber-600"></i><span>GA4</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bullseye text-blue-600"></i><span>Google Ads</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-meta text-indigo-600"></i><span>Meta Ads</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bolt text-orange-500"></i><span>Core Web Vitals</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-sitemap text-emerald-600"></i><span>Schema JSON-LD</span></div>
          <!-- Set 2 -->
          <div class="tech-marquee-pill"><i class="fab fa-wordpress text-sky-700"></i><span>WordPress</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-react text-cyan-600"></i><span>React &amp; Next.js</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-shopify text-emerald-600"></i><span>Shopify</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-search text-red-500"></i><span>Google Search Console</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-chart-line text-amber-600"></i><span>GA4</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bullseye text-blue-600"></i><span>Google Ads</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-meta text-indigo-600"></i><span>Meta Ads</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bolt text-orange-500"></i><span>Core Web Vitals</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-sitemap text-emerald-600"></i><span>Schema JSON-LD</span></div>
          <!-- Set 3 -->
          <div class="tech-marquee-pill"><i class="fab fa-wordpress text-sky-700"></i><span>WordPress</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-react text-cyan-600"></i><span>React &amp; Next.js</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-shopify text-emerald-600"></i><span>Shopify</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-search text-red-500"></i><span>Google Search Console</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-chart-line text-amber-600"></i><span>GA4</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bullseye text-blue-600"></i><span>Google Ads</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-meta text-indigo-600"></i><span>Meta Ads</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bolt text-orange-500"></i><span>Core Web Vitals</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-sitemap text-emerald-600"></i><span>Schema JSON-LD</span></div>
          <!-- Set 4 -->
          <div class="tech-marquee-pill"><i class="fab fa-wordpress text-sky-700"></i><span>WordPress</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-react text-cyan-600"></i><span>React &amp; Next.js</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-shopify text-emerald-600"></i><span>Shopify</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-search text-red-500"></i><span>Google Search Console</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-chart-line text-amber-600"></i><span>GA4</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bullseye text-blue-600"></i><span>Google Ads</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-meta text-indigo-600"></i><span>Meta Ads</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-bolt text-orange-500"></i><span>Core Web Vitals</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-sitemap text-emerald-600"></i><span>Schema JSON-LD</span></div>
        </div>
      </div>
      <div class="marquee-container">
        <div class="marquee-track reverse">
          <!-- Set 1 -->
          <div class="tech-marquee-pill"><i class="fas fa-magnifying-glass-chart text-rose-500"></i><span>Ahrefs</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-chart-pie text-orange-600"></i><span>Semrush</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-map-location-dot text-emerald-600"></i><span>Google Business</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-envelope-open-text text-sky-600"></i><span>Email platforms</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-figma text-pink-500"></i><span>Figma</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-cloudflare text-orange-500"></i><span>Cloudflare</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-mobile-screen text-slate-700"></i><span>Responsive UX</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-lock text-emerald-700"></i><span>HTTPS &amp; Security</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-gauge-high text-red-500"></i><span>PageSpeed</span></div>
          <!-- Set 2 -->
          <div class="tech-marquee-pill"><i class="fas fa-magnifying-glass-chart text-rose-500"></i><span>Ahrefs</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-chart-pie text-orange-600"></i><span>Semrush</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-map-location-dot text-emerald-600"></i><span>Google Business</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-envelope-open-text text-sky-600"></i><span>Email platforms</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-figma text-pink-500"></i><span>Figma</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-cloudflare text-orange-500"></i><span>Cloudflare</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-mobile-screen text-slate-700"></i><span>Responsive UX</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-lock text-emerald-700"></i><span>HTTPS &amp; Security</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-gauge-high text-red-500"></i><span>PageSpeed</span></div>
          <!-- Set 3 -->
          <div class="tech-marquee-pill"><i class="fas fa-magnifying-glass-chart text-rose-500"></i><span>Ahrefs</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-chart-pie text-orange-600"></i><span>Semrush</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-map-location-dot text-emerald-600"></i><span>Google Business</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-envelope-open-text text-sky-600"></i><span>Email platforms</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-figma text-pink-500"></i><span>Figma</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-cloudflare text-orange-500"></i><span>Cloudflare</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-mobile-screen text-slate-700"></i><span>Responsive UX</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-lock text-emerald-700"></i><span>HTTPS &amp; Security</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-gauge-high text-red-500"></i><span>PageSpeed</span></div>
          <!-- Set 4 -->
          <div class="tech-marquee-pill"><i class="fas fa-magnifying-glass-chart text-rose-500"></i><span>Ahrefs</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-chart-pie text-orange-600"></i><span>Semrush</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-map-location-dot text-emerald-600"></i><span>Google Business</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-envelope-open-text text-sky-600"></i><span>Email platforms</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-figma text-pink-500"></i><span>Figma</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-cloudflare text-orange-500"></i><span>Cloudflare</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-mobile-screen text-slate-700"></i><span>Responsive UX</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-lock text-emerald-700"></i><span>HTTPS &amp; Security</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-gauge-high text-red-500"></i><span>PageSpeed</span></div>
        </div>
      </div>
      <div class="marquee-container">
        <div class="marquee-track">
          <!-- Set 1 -->
          <div class="tech-marquee-pill"><i class="fab fa-html5 text-orange-600"></i><span>HTML5 / CSS</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-js text-amber-500"></i><span>JavaScript</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-cart-shopping text-emerald-600"></i><span>eCommerce</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-pen-nib text-slate-700"></i><span>Content clusters</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-share-nodes text-blue-500"></i><span>Social creative</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-tags text-rose-500"></i><span>Conversion CRO</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-server text-indigo-500"></i><span>Hosting / CDN</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-google text-red-500"></i><span>Looker Studio</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-clipboard-check text-emerald-600"></i><span>Monthly reports</span></div>
          <!-- Set 2 -->
          <div class="tech-marquee-pill"><i class="fab fa-html5 text-orange-600"></i><span>HTML5 / CSS</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-js text-amber-500"></i><span>JavaScript</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-cart-shopping text-emerald-600"></i><span>eCommerce</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-pen-nib text-slate-700"></i><span>Content clusters</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-share-nodes text-blue-500"></i><span>Social creative</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-tags text-rose-500"></i><span>Conversion CRO</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-server text-indigo-500"></i><span>Hosting / CDN</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-google text-red-500"></i><span>Looker Studio</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-clipboard-check text-emerald-600"></i><span>Monthly reports</span></div>
          <!-- Set 3 -->
          <div class="tech-marquee-pill"><i class="fab fa-html5 text-orange-600"></i><span>HTML5 / CSS</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-js text-amber-500"></i><span>JavaScript</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-cart-shopping text-emerald-600"></i><span>eCommerce</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-pen-nib text-slate-700"></i><span>Content clusters</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-share-nodes text-blue-500"></i><span>Social creative</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-tags text-rose-500"></i><span>Conversion CRO</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-server text-indigo-500"></i><span>Hosting / CDN</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-google text-red-500"></i><span>Looker Studio</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-clipboard-check text-emerald-600"></i><span>Monthly reports</span></div>
          <!-- Set 4 -->
          <div class="tech-marquee-pill"><i class="fab fa-html5 text-orange-600"></i><span>HTML5 / CSS</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-js text-amber-500"></i><span>JavaScript</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-cart-shopping text-emerald-600"></i><span>eCommerce</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-pen-nib text-slate-700"></i><span>Content clusters</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-share-nodes text-blue-500"></i><span>Social creative</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-tags text-rose-500"></i><span>Conversion CRO</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-server text-indigo-500"></i><span>Hosting / CDN</span></div>
          <div class="tech-marquee-pill"><i class="fab fa-google text-red-500"></i><span>Looker Studio</span></div>
          <div class="tech-marquee-pill"><i class="fas fa-clipboard-check text-emerald-600"></i><span>Monthly reports</span></div>
        </div>
      </div>
    </div>


  <!-- ======= 10. CLIENT TESTIMONIALS (REDESIGNED CAROUSEL MATCHING REFERENCE DESIGN IN OUR THEME) ======= -->
  <section id="testimonials" class="py-24 bg-[#fff] border-t border-[#e6dfd3] overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">

      <!-- Header with Eyebrow, Title & Carousel Navigation Buttons -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div class="space-y-3">
          <div class="badge-pill-eyebrow">
            <span>WHAT OUR CLIENTS SAY</span>
          </div>
          <h2 class="text-3xl sm:text-5xl font-extrabold text-[#464f79] tracking-tight text-gradient-3">
            Client's Testimonials
          </h2>
          <p class="text-[#6e675f] text-base max-w-xl">
            Hear from founders and marketing leads who trust WebRanker for SEO, websites, and campaigns.
          </p>
        </div>

        <!-- Carousel Pill Controller (<  >) -->
        <div
          class="flex items-center gap-2 bg-[#161514] p-1.5 rounded-full border border-slate-800 shadow-lg shrink-0 self-start md:self-auto">
          <button id="prevTestimonialBtn"
            class="w-10 h-10 rounded-full bg-white/10 hover:bg-white hover:text-[#161514] text-white flex items-center justify-center transition-all cursor-pointer"
            title="Previous Testimonial">
            <i class="fas fa-arrow-left text-xs"></i>
          </button>
          <button id="nextTestimonialBtn"
            class="w-10 h-10 rounded-full bg-white/10 hover:bg-white hover:text-[#161514] text-white flex items-center justify-center transition-all cursor-pointer"
            title="Next Testimonial">
            <i class="fas fa-arrow-right text-xs"></i>
          </button>
        </div>
      </div>

      <!-- Owl Carousel Slider Track (2 Items Per View on Desktop) -->
      <div id="testimonialCarousel" class="owl-carousel owl-theme">

        <!-- Item 1 -->
        <div class="item p-2">
          <div
            class="bg-white border border-[#e6dfd3] ds-clip p-8 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between h-full">
            <div>
              <!-- 5 Gold Stars -->
              <div class="flex items-center gap-1.5 text-amber-500 mb-5 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
              <!-- Title -->
              <h3 class="text-xl font-extrabold text-[#161514] mb-3">SEO that actually moved the needle</h3>
              <!-- Review Text -->
              <p class="text-[#6e675f] text-sm sm:text-base leading-relaxed mb-8 font-normal">
                "Working with WebRanker has been a game-changer. Their SEO strategies improved our search rankings and increased website traffic. Highly recommend."
              </p>
            </div>
            <!-- Card Footer -->
            <div class="flex items-center justify-between pt-5 border-t border-[#e6dfd3]">
              <div class="flex items-center gap-3">
                <div
                  class="w-11 h-11 rounded-full bg-[#161514] text-white font-extrabold flex items-center justify-center text-xs shadow-sm">
                  AM
                </div>
                <div>
                  <h4 class="text-sm font-extrabold text-[#161514]">Priya Sharma</h4>
                  <p class="text-xs font-semibold text-[#6e675f]">Founder, local services</p>
                </div>
              </div>
              <div class="text-[#ff3b30] text-3xl opacity-90 me-1">
                <i class="fas fa-quote-right"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Item 2 -->
        <div class="item p-2">
          <div
            class="bg-white border border-[#e6dfd3] ds-clip p-8 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between h-full">
            <div>
              <!-- 5 Gold Stars -->
              <div class="flex items-center gap-1.5 text-amber-500 mb-5 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
              <!-- Title -->
              <h3 class="text-xl font-extrabold text-[#161514] mb-3">A website that finally converts</h3>
              <!-- Review Text -->
              <p class="text-[#6e675f] text-sm sm:text-base leading-relaxed mb-8 font-normal">
                "Our new website looks stunning and functions flawlessly. The design team captured our vision and delivered a fast, user-friendly site."
              </p>
            </div>
            <!-- Card Footer -->
            <div class="flex items-center justify-between pt-5 border-t border-[#e6dfd3]">
              <div class="flex items-center gap-3">
                <div
                  class="w-11 h-11 rounded-full bg-[#8c6d3b] text-white font-extrabold flex items-center justify-center text-xs shadow-sm">
                  CG
                </div>
                <div>
                  <h4 class="text-sm font-extrabold text-[#161514]">James Carter</h4>
                  <p class="text-xs font-semibold text-[#6e675f]">Marketing Director</p>
                </div>
              </div>
              <div class="text-[#ff3b30] text-3xl opacity-90 me-1">
                <i class="fas fa-quote-right"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Item 3 -->
        <div class="item p-2">
          <div
            class="bg-white border border-[#e6dfd3] ds-clip p-8 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between h-full">
            <div>
              <!-- 5 Gold Stars -->
              <div class="flex items-center gap-1.5 text-amber-500 mb-5 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
              <!-- Title -->
              <h3 class="text-xl font-extrabold text-[#161514] mb-3">PPC + SEO working together</h3>
              <!-- Review Text -->
              <p class="text-[#6e675f] text-sm sm:text-base leading-relaxed mb-8 font-normal">
                "Paid campaigns filled the pipeline while SEO compounded. Reporting was clear, and we finally knew which keywords paid for themselves."
              </p>
            </div>
            <!-- Card Footer -->
            <div class="flex items-center justify-between pt-5 border-t border-[#e6dfd3]">
              <div class="flex items-center gap-3">
                <div
                  class="w-11 h-11 rounded-full bg-[#161514] text-amber-400 font-extrabold flex items-center justify-center text-xs shadow-sm">
                  CW
                </div>
                <div>
                  <h4 class="text-sm font-extrabold text-[#161514]">Aisha Rahman</h4>
                  <p class="text-xs font-semibold text-[#6e675f]">eCommerce lead</p>
                </div>
              </div>
              <div class="text-[#ff3b30] text-3xl opacity-90 me-1">
                <i class="fas fa-quote-right"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Item 4 -->
        <div class="item p-2">
          <div
            class="bg-white border border-[#e6dfd3] ds-clip p-8 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between h-full">
            <div>
              <!-- 5 Gold Stars -->
              <div class="flex items-center gap-1.5 text-amber-500 mb-5 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                  class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
              <!-- Title -->
              <h3 class="text-xl font-extrabold text-[#161514] mb-3">Consistent ranking reports</h3>
              <!-- Review Text -->
              <p class="text-[#6e675f] text-sm sm:text-base leading-relaxed mb-8 font-normal">
                "Transparent monthly reports, faster pages, and content that ranks. WebRanker feels like an in-house growth team."
              </p>
            </div>
            <!-- Card Footer -->
            <div class="flex items-center justify-between pt-5 border-t border-[#e6dfd3]">
              <div class="flex items-center gap-3">
                <div
                  class="w-11 h-11 rounded-full bg-[#cfa86e] text-black font-extrabold flex items-center justify-center text-xs shadow-sm">
                  EM
                </div>
                <div>
                  <h4 class="text-sm font-extrabold text-[#161514]">Daniel Cole</h4>
                  <p class="text-xs font-semibold text-[#6e675f]">SaaS founder</p>
                </div>
              </div>
              <div class="text-[#ff3b30] text-3xl opacity-90 me-1">
                <i class="fas fa-quote-right"></i>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- ======= 11. ACCORDION FAQs SECTION ======= -->
  <section id="faqs" class="py-24 bg-[#f5efe6] border-t border-[#e6dfd3]">
    <div class="max-w-4xl mx-auto px-6">

      <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
        <div class="badge-pill-eyebrow">
          <span>FREQUENTLY ASKED QUESTIONS</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-[#464f79] text-gradient-3">
          Everything you need to know
        </h2>
        <p class="text-[#6e675f] text-sm">
          Got questions about SEO, websites, or campaigns? Here are answers we hear most often.
        </p>
      </div>

      <div class="space-y-4">
        @foreach($faqs as $index => $faq)
        <div class="faq-accordion-card {{ $index === 0 ? 'active' : '' }}" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
          <button class="faq-accordion-btn" type="button" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
            <span itemprop="name">{{ $faq->question }}</span>
            <span class="faq-accordion-icon"><i class="fas fa-chevron-down"></i></span>
          </button>
          <div class="faq-accordion-content" style="{{ $index === 0 ? 'max-height: 250px;' : '' }}" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
            <div itemprop="text">{{ $faq->answer }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

    <!-- ======= 10b. BLOG INSIGHTS (CAROUSEL — MATCHES TESTIMONIALS DESIGN) ======= -->
    <section id="blog" class="py-24 bg-[#fff] border-t border-[#e6dfd3] overflow-hidden">
      <div class="max-w-7xl mx-auto px-6">
  
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
          <div class="space-y-3">
            <div class="badge-pill-eyebrow">
              <span>GROWTH &amp; ENGINEERING INSIGHTS</span>
            </div>
            <h2 class="text-3xl sm:text-5xl font-extrabold text-[#464f79] tracking-tight text-gradient-3">
              Latest From Our Growth Blog
            </h2>
            <p class="text-[#6e675f] text-base max-w-xl">
              Practical playbooks, architectural deep dives, and data-backed ranking strategies across Web Dev, App Dev, SEO, and Core Web Vitals.
            </p>
          </div>
  
          <div
            class="flex items-center gap-2 bg-[#161514] p-1.5 rounded-full border border-slate-800 shadow-lg shrink-0 self-start md:self-auto">
            <button id="prevBlogBtn"
              class="w-10 h-10 rounded-full bg-white/10 hover:bg-white hover:text-[#161514] text-white flex items-center justify-center transition-all cursor-pointer"
              title="Previous Article" aria-label="Previous slide">
              <i class="fas fa-arrow-left text-xs"></i>
            </button>
            <button id="nextBlogBtn"
              class="w-10 h-10 rounded-full bg-white/10 hover:bg-white hover:text-[#161514] text-white flex items-center justify-center transition-all cursor-pointer"
              title="Next Article" aria-label="Next slide">
              <i class="fas fa-arrow-right text-xs"></i>
            </button>
          </div>
        </div>
  
        <div id="blogCarousel" class="owl-carousel owl-theme">
  
          <!-- Article 1: Ecommerce SEO & CRO -->
          <div class="item p-2">
            <article class="blog-list-card">
              <a href="{{ route('blogs.show', 'ecommerce-seo-conversion-optimization-guide') }}" class="blog-list-card-link">
                <div class="blog-card-box">
                  <div class="blog-card-top">
                    <div class="blog-list-media">
                      <img src="{{ asset('asset/agp-lab-ecom.jpg') }}" alt="Mastering E-Commerce SEO and Conversion Optimization" loading="lazy">
                    </div>
                    <p class="blog-grid-meta"><time datetime="2026-09-18">18 SEP. 2026</time> / Marcus Vance</p>
                  </div>
                  <div class="blog-list-body">
                    <h3 class="blog-grid-title">Mastering E-Commerce SEO &amp; Conversion Optimization: The 2026 Playbook</h3>
                    <p class="blog-grid-tags" aria-label="Categories"><span>E-Commerce</span><span>SEO</span></p>
                  </div>
                </div>
              </a>
            </article>
          </div>
  
          <!-- Article 2: Fintech App Development -->
          <div class="item p-2">
            <article class="blog-list-card">
              <a href="{{ route('blogs.show', 'fintech-app-development-security-ux') }}" class="blog-list-card-link">
                <div class="blog-card-box">
                  <div class="blog-card-top">
                    <div class="blog-list-media">
                      <img src="{{ asset('asset/da-lab-finance.jpg') }}" alt="Building High-Security Fintech Applications" loading="lazy">
                    </div>
                    <p class="blog-grid-meta"><time datetime="2026-09-12">12 SEP. 2026</time> / Sarah Chen</p>
                  </div>
                  <div class="blog-list-body">
                    <h3 class="blog-grid-title">Building High-Security Fintech Applications: Architecture, Compliance &amp; UX</h3>
                    <p class="blog-grid-tags" aria-label="Categories"><span>Fintech</span><span>App Dev</span></p>
                  </div>
                </div>
              </a>
            </article>
          </div>
  
          <!-- Article 3: Healthcare Web Development -->
          <div class="item p-2">
            <article class="blog-list-card">
              <a href="{{ route('blogs.show', 'healthcare-web-development-hipaa-compliance') }}" class="blog-list-card-link">
                <div class="blog-card-box">
                  <div class="blog-card-top">
                    <div class="blog-list-media">
                      <img src="{{ asset('asset/da-lab-health.jpg') }}" alt="Healthcare Web Development and HIPAA Compliance" loading="lazy">
                    </div>
                    <p class="blog-grid-meta"><time datetime="2026-09-05">05 SEP. 2026</time> / Dr. Elena Rostova</p>
                  </div>
                  <div class="blog-list-body">
                    <h3 class="blog-grid-title">Healthcare Web Development: Building HIPAA-Compliant Patient Portals</h3>
                    <p class="blog-grid-tags" aria-label="Categories"><span>Healthcare</span><span>Web Dev</span></p>
                  </div>
                </div>
              </a>
            </article>
          </div>
  
          <!-- Article 4: Site Optimization & Core Web Vitals -->
          <div class="item p-2">
            <article class="blog-list-card">
              <a href="{{ route('blogs.show', 'core-web-vitals-site-speed-optimization') }}" class="blog-list-card-link">
                <div class="blog-card-box">
                  <div class="blog-card-top">
                    <div class="blog-list-media">
                      <img src="{{ asset('asset/ml-lab-analytics.jpg') }}" alt="Core Web Vitals Site Speed Optimization" loading="lazy">
                    </div>
                    <p class="blog-grid-meta"><time datetime="2026-08-28">28 AUG. 2026</time> / David Miller</p>
                  </div>
                  <div class="blog-list-body">
                    <h3 class="blog-grid-title">Demystifying Core Web Vitals: How Sub-Second Speed Drives Real Revenue</h3>
                    <p class="blog-grid-tags" aria-label="Categories"><span>Site Optimization</span><span>Speed</span></p>
                  </div>
                </div>
              </a>
            </article>
          </div>
  
          <!-- Article 5: SEO Content Writing -->
          <div class="item p-2">
            <article class="blog-list-card">
              <a href="{{ route('blogs.show', 'high-ranking-seo-content-writing-strategy') }}" class="blog-list-card-link">
                <div class="blog-card-box">
                  <div class="blog-card-top">
                    <div class="blog-list-media">
                      <img src="{{ asset('asset/gap-lab-content.jpg') }}" alt="High-Ranking SEO Content Writing Strategy" loading="lazy">
                    </div>
                    <p class="blog-grid-meta"><time datetime="2026-08-20">20 AUG. 2026</time> / Maya Lin</p>
                  </div>
                  <div class="blog-list-body">
                    <h3 class="blog-grid-title">The Semantic Content Blueprint: Crafting High-Ranking SEO Content</h3>
                    <p class="blog-grid-tags" aria-label="Categories"><span>Content</span><span>SEO</span></p>
                  </div>
                </div>
              </a>
            </article>
          </div>
  
          <!-- Article 6: Cross-Platform Mobile Apps -->
          <div class="item p-2">
            <article class="blog-list-card">
              <a href="{{ route('blogs.show', 'cross-platform-mobile-app-development-trends') }}" class="blog-list-card-link">
                <div class="blog-card-box">
                  <div class="blog-card-top">
                    <div class="blog-list-media">
                      <img src="{{ asset('asset/cv-lab-traffic.jpg') }}" alt="Cross-Platform Mobile App Development" loading="lazy">
                    </div>
                    <p class="blog-grid-meta"><time datetime="2026-08-14">14 AUG. 2026</time> / Sarah Chen</p>
                  </div>
                  <div class="blog-list-body">
                    <h3 class="blog-grid-title">Flutter vs. React Native in 2026: Choosing the Right Mobile Architecture</h3>
                    <p class="blog-grid-tags" aria-label="Categories"><span>App Dev</span><span>Mobile</span></p>
                  </div>
                </div>
              </a>
            </article>
          </div>
  
        </div>
  
      </div>
    </section>

  <!-- ======= 11.5 READY TO AUTOMATE CTA BANNER CAPSULE ======= -->
  <section class="py-16 bg-[#faf7f2] border-t border-[#e6dfd3]">
    <div class="max-w-6xl mx-auto px-6">
      <div class="bg-[#101424] text-white ds-clip p-10 sm:p-16 text-center shadow-2xl relative overflow-hidden">

        <!-- Top Pill Tag -->
        <div
          class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-slate-200 text-xs font-bold uppercase tracking-wider mb-6 border border-white/15">
          <span>READY TO GROW?</span>
        </div>

        <!-- Headline -->
        <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight max-w-3xl mx-auto mb-6">
          Still not sure which channel will grow your business first?
        </h2>

        <!-- Subtitle -->
        <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
          Talk to a WebRanker strategist about SEO, web design, PPC, or social — we’ll recommend the shortest path to more visibility and leads.
        </p>

        <!-- Enquiry Button -->
        <div>
          <a href="#consultation" class="header-btn-white">
            <span>Send Us An Enquiry</span>
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- ======= OFFICE — JAIPUR + 3D EARTH MAP ======= -->
  <section id="offices" class="offices-locations-section offices-globe-section py-24 bg-[#faf7f2] border-t border-[#e6dfd3] relative">
    <div class="max-w-7xl mx-auto px-6">

      <header class="offices-locations-header space-y-4 mb-12">
        <div class="badge-pill-eyebrow mx-auto">
          <span>VISIT US</span>
        </div>
        <h2 class="text-3xl sm:text-5xl font-extrabold text-[#464f79] tracking-tight text-gradient-3">
          Our office in Jaipur
        </h2>
        <p class="text-[#6e675f] text-base leading-relaxed">
          Explore our Jaipur Global Capability Center on the interactive 3D satellite globe.
        </p>
      </header>

      <div class="offices-locations-layout">

        <div class="offices-locations-nav">
          <div class="offices-loc-list">
            <div class="svc-grid-card offices-loc-card active" data-office-id="jaipur" tabindex="0" role="button"
              aria-label="View Jaipur office on the globe and zoom into satellite building view">
              <div class="flex items-center justify-between mb-2">
                <span class="svc-card-num text-xs font-extrabold px-2.5 py-0.5 rounded-full bg-[#f5efe6] text-[#9c958c]">01</span>
                <i class="fas fa-location-dot text-sm opacity-70 svc-card-icon"></i>
              </div>
              <h4 class="svc-card-title text-base font-extrabold text-[#161514]">WR, Jaipur HQ</h4>
              <p class="text-xs text-[#6e675f] mt-1 font-medium">Plot no. 51, Sector 8, Malviya Nagar</p>
              <span class="inline-flex items-center gap-1 text-[11px] text-[#0284c7] font-semibold mt-2">
                <i class="fas fa-satellite text-[10px]"></i>
                <span>Zoom to Building</span>
              </span>
            </div>
          </div>
        </div>

        <div class="offices-locations-map-wrap">
          <div class="offices-loc-detail" id="officesLocDetail">
            <span class="offices-loc-detail-region" id="officesLocRegion">INDIA · RAJASTHAN</span>
            <h3 class="offices-loc-detail-title" id="officesLocTitle">WR Jaipur Headquarters</h3>
            <p class="offices-loc-detail-address" id="officesLocAddress">Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar, Jaipur, Rajasthan 302017</p>
            <a class="offices-loc-detail-phone" id="officesLocPhone" href="tel:+919718570218">
              <i class="fas fa-phone-alt"></i>
              <span>+91 97185 70218</span>
            </a>
          </div>
          <iframe
            id="officesGlobeFrame"
            class="offices-globe-frame"
            title="WebRanker Jaipur office on the globe"
            src="{{ asset('globe/offices-map.html?embed=1') }}"
            data-src="{{ asset('globe/offices-map.html?embed=1') }}"
            loading="lazy"
            allowfullscreen>
          </iframe>

          <div class="offices-map-top">
            <div class="offices-map-tour-pill">
              <span class="offices-map-status-dot" id="dsOfficesMapStatusDot"></span>
              <span id="dsOfficesMapStatusText">WR, Jaipur · Satellite View</span>
            </div>
          </div>

          <div class="offices-map-bottom">
            <div class="offices-map-hints">
              <span><span class="offices-map-hint">Drag</span> Rotate / Pan</span>
              <span>·</span>
              <span><span class="offices-map-hint">Scroll</span> Zoom to Building</span>
            </div>
            <div class="offices-map-controls">
              <button type="button" class="offices-map-btn" id="dsOfficesBtnTour">
                <span id="dsOfficesIconTour">⏸</span>
                <span id="dsOfficesTextTour">Pause</span>
              </button>
              <button type="button" class="offices-map-btn" id="dsOfficesBtnRotate">
                <span id="dsOfficesTextRotate">Orbit: On</span>
              </button>
              <button type="button" class="offices-map-btn is-accent" id="dsOfficesBtnReset">
                <span>🌐</span>
                <span>Reset Globe</span>
              </button>
            </div>
          </div>

          <div class="offices-map-attribution">Satellite Imagery © Esri, Maxar, Earthstar Geographics</div>
        </div>

        <script>
          (function() {
            var frame = document.getElementById('officesGlobeFrame');
            var btnTour = document.getElementById('dsOfficesBtnTour');
            var btnRotate = document.getElementById('dsOfficesBtnRotate');
            var btnReset = document.getElementById('dsOfficesBtnReset');
            var statusText = document.getElementById('dsOfficesMapStatusText');
            var statusDot = document.getElementById('dsOfficesMapStatusDot');
            var iconTour = document.getElementById('dsOfficesIconTour');
            var textTour = document.getElementById('dsOfficesTextTour');
            var textRotate = document.getElementById('dsOfficesTextRotate');

            var autoOrbit = true;

            function postMsg(data) {
              if (frame && frame.contentWindow) {
                frame.contentWindow.postMessage(Object.assign({ source: 'ds-offices-parent' }, data), '*');
              }
            }

            if (btnTour) {
              btnTour.addEventListener('click', function() {
                postMsg({ type: 'toggleTour' });
              });
            }

            if (btnRotate) {
              btnRotate.addEventListener('click', function() {
                autoOrbit = !autoOrbit;
                if (textRotate) {
                  textRotate.textContent = autoOrbit ? 'Orbit: On' : 'Orbit: Off';
                }
                postMsg({ type: 'toggleRotate' });
              });
            }

            if (btnReset) {
              btnReset.addEventListener('click', function() {
                postMsg({ type: 'resetGlobe' });
              });
            }

            var locCard = document.querySelector('.offices-loc-card[data-office-id="india"], .offices-loc-card[data-office-id="jaipur"]');
            if (locCard) {
              locCard.addEventListener('click', function() {
                postMsg({ type: 'selectOffice', id: 'jaipur' });
              });
            }

            window.addEventListener('message', function(e) {
              if (!e.data || e.data.source !== 'ds-offices-map') return;
              if (e.data.type === 'tourStatusChanged') {
                if (statusText && e.data.message) {
                  statusText.textContent = e.data.message;
                }
                if (statusDot) {
                  statusDot.classList.toggle('paused', !e.data.active);
                }
                if (textTour) {
                  textTour.textContent = e.data.active ? 'Pause' : 'Resume';
                }
                if (iconTour) {
                  iconTour.textContent = e.data.active ? '⏸' : '▶';
                }
              }
            });
          })();
        </script>

      </div>
    </div>
  </section>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var root = document.getElementById('growth-engine');
      if (!root) return;
      var tabs = root.querySelectorAll('.wr-engine-tab');
      var panes = root.querySelectorAll('.wr-engine-pane');
      tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
          var key = tab.getAttribute('data-engine');
          tabs.forEach(function (item) {
            var on = item === tab;
            item.classList.toggle('is-active', on);
            item.setAttribute('aria-selected', on ? 'true' : 'false');
          });
          panes.forEach(function (pane) {
            pane.classList.toggle('is-active', pane.getAttribute('data-engine-pane') === key);
          });
        });
      });

      var domainRoot = document.getElementById('domains');
      if (domainRoot) {
        var domainTabs = domainRoot.querySelectorAll('.domain-tab-btn');
        var domainCards = domainRoot.querySelectorAll('.domain-card-item');
        domainTabs.forEach(function (tab) {
          tab.addEventListener('click', function () {
            var filter = tab.getAttribute('data-domain-filter');
            domainTabs.forEach(function (item) {
              item.classList.toggle('is-active', item === tab);
            });
            domainCards.forEach(function (card) {
              var show = filter === 'all' || card.getAttribute('data-domain-cat') === filter;
              card.classList.toggle('is-hidden', !show);
            });
          });
        });
      }
    });
  </script>
  @endpush

@endsection
