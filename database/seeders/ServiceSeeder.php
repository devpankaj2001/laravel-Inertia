<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds for services.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development Services',
                'slug' => 'web-development',
                'category' => 'Engineering & Architecture',
                'icon' => 'fa-solid fa-code',
                'tagline' => 'Custom PHP & Laravel, Next.js, MERN, Python, WordPress & Shopify Built for Humans & Ranked by Search Engines',
                'short_description' => 'Stop losing leads to sluggish load times and fragile templates. We design, architect, and deploy high-performing full-stack web applications and headless portals using PHP, Laravel, Next.js, React, MERN, Python, WordPress, and Shopify—engineered for real human conversions, sub-second speed, and Google #1 rank dominance.',
                'badge' => 'Full-Stack & Headless',
                'kpi_label' => 'Avg Load Time',
                'kpi_value' => '0.38s',
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Full-Stack Web Development Services | Laravel, Next.js, MERN & Python | WebRanker',
                'meta_description' => 'Struggling with slow, bloated websites? WebRanker engineers custom full-stack web applications in PHP/Laravel, Next.js, MERN, Python & Headless Shopify that load in under 0.4s and rank #1.',
                'focus_keywords' => 'Laravel web development, Next.js React app, hire MERN developer, Python FastAPI, headless WordPress, Shopify Plus, Core Web Vitals, custom web apps',
                'detailed_content' => '<div class="space-y-8">
  <div class="p-6 sm:p-8 rounded-3xl bg-[#faf7f2] border border-[#e6dfd3] space-y-4">
    <h3 class="text-2xl font-black text-[#161514] tracking-tight">The Reality of Modern Web Development: Why Most Websites Silently Fail</h3>
    <p class="text-base text-[#4b5563] leading-relaxed">
      If you have ever hired an agency only to receive a sluggish, cookie-cutter website stitched together with 45 third-party plugins—you are not alone. Most websites on the internet today look acceptable on the surface, but underneath, they are an engineering nightmare: bloated JavaScript bundles, unindexed dynamic routes, poor mobile responsiveness, and fragile database queries that freeze the moment traffic surges.
    </p>
    <p class="text-base text-[#4b5563] leading-relaxed">
      At <strong>WebRanker</strong>, we take a fundamentally different, human-first engineering stance. We treat your web application as a mission-critical revenue engine. Whether you are building an enterprise B2B SaaS platform, an interactive client portal, or a high-converting e-commerce store, our software architects handcraft clean, modular code that loads in under 400 milliseconds, delights real human visitors, and dominates Google search results.
    </p>
  </div>

  <div class="space-y-4">
    <h3 class="text-2xl font-black text-[#161514] tracking-tight">Our Core Multi-Stack Engineering Capabilities</h3>
    <p class="text-base text-[#4b5563] leading-relaxed">
      We believe in <em>pragmatic technology selection</em>. We don\'t force a single framework onto every problem. Instead, our senior architects match the exact right technology stack to your specific business model, team skillset, and scaling targets.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
      <!-- PHP & Laravel -->
      <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-red-50 text-[#ff3b30] flex items-center justify-center text-lg font-bold">
            <i class="fab fa-php"></i>
          </div>
          <div>
            <h4 class="font-extrabold text-[#161514] text-base">PHP 8.3 &amp; Laravel 11 Ecosystem</h4>
            <span class="text-xs text-[#ff3b30] font-bold">Enterprise SaaS &amp; Complex Business Logic</span>
          </div>
        </div>
        <p class="text-sm text-[#6e675f] leading-relaxed">
          Laravel is the gold standard for robust backends. We build enterprise-grade MVC web applications, high-concurrency background job queues with Redis, multi-tenant SaaS platforms, and secure REST/GraphQL APIs with clean architecture that your internal developers will love maintaining.
        </p>
        <ul class="text-xs text-[#4b5563] space-y-1.5 pt-1">
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Eloquent ORM &amp; Database Migration Architecture</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Laravel Octane &amp; Redis Sub-50ms API Latency</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Built-in CSRF, XSS, and SQL Injection Security</li>
        </ul>
      </div>

      <!-- Next.js & React -->
      <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-lg font-bold">
            <i class="fab fa-react"></i>
          </div>
          <div>
            <h4 class="font-extrabold text-[#161514] text-base">Next.js 15 &amp; React 19 Frontend</h4>
            <span class="text-xs text-blue-600 font-bold">Edge SSR, SSG &amp; 100/100 Core Web Vitals</span>
          </div>
        </div>
        <p class="text-sm text-[#6e675f] leading-relaxed">
          Google prioritizes instantaneous rendering and zero layout shift. Using Next.js App Router, React Server Components, and Edge middleware, we build web experiences that feel as fluid and snappy as a desktop application while feeding search engines pre-rendered semantic HTML.
        </p>
        <ul class="text-xs text-[#4b5563] space-y-1.5 pt-1">
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Hybrid Server-Side Rendering (SSR) &amp; Static Generation (SSG)</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Automated Image &amp; Font Optimization (Zero CLS)</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Edge CDN Caching &amp; Global Sub-Second Delivery</li>
        </ul>
      </div>

      <!-- MERN Stack -->
      <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold">
            <i class="fab fa-node-js"></i>
          </div>
          <div>
            <h4 class="font-extrabold text-[#161514] text-base">MERN Stack (MongoDB, Express, React, Node)</h4>
            <span class="text-xs text-emerald-600 font-bold">High-Concurrency Event-Driven Web Platforms</span>
          </div>
        </div>
        <p class="text-sm text-[#6e675f] leading-relaxed">
          When real-time collaboration, live notifications, WebSockets, or high-throughput JSON processing are required, our MERN team delivers. A single JavaScript/TypeScript codebase from client to database reduces context-switching and accelerates feature delivery.
        </p>
        <ul class="text-xs text-[#4b5563] space-y-1.5 pt-1">
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Flexible MongoDB Schema &amp; Aggregation Pipelines</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Lightweight, Scalable Express.js Microservices</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Real-Time WebSocket Dashboards &amp; Notifications</li>
        </ul>
      </div>

      <!-- Python, FastAPI & Django -->
      <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold">
            <i class="fab fa-python"></i>
          </div>
          <div>
            <h4 class="font-extrabold text-[#161514] text-base">Python, FastAPI &amp; Django</h4>
            <span class="text-xs text-indigo-600 font-bold">Data-Intensive Backends &amp; AI Integration</span>
          </div>
        </div>
        <p class="text-sm text-[#6e675f] leading-relaxed">
          Need machine learning inference, automated data scraping, complex financial modeling, or lightning-fast asynchronous REST APIs? We engineer high-performance asynchronous backends using FastAPI and robust enterprise systems with Django ORM.
        </p>
        <ul class="text-xs text-[#4b5563] space-y-1.5 pt-1">
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Asynchronous AsyncIO Non-Blocking I/O Execution</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Automatic OpenAPI &amp; Swagger Schema Documentation</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Seamless AI, LLM &amp; Vector Database Integration</li>
        </ul>
      </div>

      <!-- WordPress & Shopify -->
      <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold">
            <i class="fab fa-wordpress"></i>
          </div>
          <div>
            <h4 class="font-extrabold text-[#161514] text-base">Custom WordPress &amp; Shopify Plus</h4>
            <span class="text-xs text-amber-600 font-bold">Zero-Bloat CMS &amp; High-Converting E-Commerce</span>
          </div>
        </div>
        <p class="text-sm text-[#6e675f] leading-relaxed">
          Say goodbye to sluggish 8-second page loads. We engineer custom, ultra-lean Gutenberg block themes, tailored Shopify Plus Liquid storefronts, and headless decoupled setups that give non-technical editors full publishing freedom without sacrificing Google PageSpeed scores.
        </p>
        <ul class="text-xs text-[#4b5563] space-y-1.5 pt-1">
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Bespoke Themes Built with Zero Commercial Bloatware</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Custom Shopify Apps &amp; Checkout Extensibility</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Sub-Second Catalog Navigation &amp; Faceted Search</li>
        </ul>
      </div>

      <!-- Headless Architecture -->
      <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg font-bold">
            <i class="fas fa-cubes"></i>
          </div>
          <div>
            <h4 class="font-extrabold text-[#161514] text-base">Headless CMS &amp; Decoupled Architecture</h4>
            <span class="text-xs text-purple-600 font-bold">GraphQL, Strapi, Sanity &amp; Next.js</span>
          </div>
        </div>
        <p class="text-sm text-[#6e675f] leading-relaxed">
          Decoupling your editorial backend from your customer-facing frontend unlocks infinite scalability. Your marketing team manages rich content in Sanity, Strapi, or WordPress, while Next.js compiles blazing-fast static edge pages that withstand millions of concurrent hits.
        </p>
        <ul class="text-xs text-[#4b5563] space-y-1.5 pt-1">
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Single Content Hub Powering Web, Mobile &amp; Kiosks</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Immunity from CMS Database Vulnerabilities</li>
          <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Incremental Static Regeneration (ISR) Updates in Real Time</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="space-y-4">
    <h3 class="text-2xl font-black text-[#161514] tracking-tight">Stack Comparison: Choosing the Perfect Technology for Your Business</h3>
    <p class="text-sm text-[#6e675f]">
      Unsure which technology stack fits your roadmap? Here is our honest, engineering-grounded comparison:
    </p>

    <div class="overflow-x-auto rounded-2xl border border-[#e6dfd3] bg-white">
      <table class="w-full text-left border-collapse text-xs sm:text-sm">
        <thead>
          <tr class="bg-[#faf7f2] border-b border-[#e6dfd3] text-[#161514] font-black">
            <th class="p-3.5 sm:p-4">Stack / Technology</th>
            <th class="p-3.5 sm:p-4">Best Suited For</th>
            <th class="p-3.5 sm:p-4">SEO &amp; Indexation</th>
            <th class="p-3.5 sm:p-4">Time-to-Market</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[#e6dfd3] text-[#4b5563]">
          <tr>
            <td class="p-3.5 sm:p-4 font-bold text-[#161514]">Laravel 11 + Livewire / Inertia</td>
            <td class="p-3.5 sm:p-4">Enterprise SaaS, CRM portals, financial backends, booking platforms</td>
            <td class="p-3.5 sm:p-4 text-emerald-600 font-bold"><i class="fas fa-circle-check"></i> Exceptional (Native SSR)</td>
            <td class="p-3.5 sm:p-4">Fast (Batteries included)</td>
          </tr>
          <tr>
            <td class="p-3.5 sm:p-4 font-bold text-[#161514]">Next.js 15 + React 19</td>
            <td class="p-3.5 sm:p-4">High-traffic content portals, e-commerce frontends, marketing platforms</td>
            <td class="p-3.5 sm:p-4 text-emerald-600 font-bold"><i class="fas fa-circle-check"></i> 100/100 Lighthouse Benchmark</td>
            <td class="p-3.5 sm:p-4">Moderate to Fast</td>
          </tr>
          <tr>
            <td class="p-3.5 sm:p-4 font-bold text-[#161514]">MERN (Node + Express + React)</td>
            <td class="p-3.5 sm:p-4">Real-time collaboration tools, streaming feeds, interactive dashboards</td>
            <td class="p-3.5 sm:p-4 text-blue-600 font-bold">Good (with SSR / Vite SSG)</td>
            <td class="p-3.5 sm:p-4">Fast (Unified JS ecosystem)</td>
          </tr>
          <tr>
            <td class="p-3.5 sm:p-4 font-bold text-[#161514]">Python (FastAPI / Django)</td>
            <td class="p-3.5 sm:p-4">Data science web tools, AI microservices, algorithmic backend pipelines</td>
            <td class="p-3.5 sm:p-4 text-slate-700 font-semibold">Backend API focused</td>
            <td class="p-3.5 sm:p-4">Fast to Moderate</td>
          </tr>
          <tr>
            <td class="p-3.5 sm:p-4 font-bold text-[#161514]">Headless Shopify / WordPress</td>
            <td class="p-3.5 sm:p-4">Omnichannel retail brands and high-velocity publishing houses</td>
            <td class="p-3.5 sm:p-4 text-emerald-600 font-bold"><i class="fas fa-circle-check"></i> Maximum Organic Rank</td>
            <td class="p-3.5 sm:p-4">Moderate</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="p-6 sm:p-8 rounded-3xl bg-[#161514] text-white space-y-4">
    <h3 class="text-2xl font-black text-white tracking-tight">The WebRanker Code Quality Pledge</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-2">
      <div class="space-y-1.5">
        <div class="text-[#ff3b30] font-black text-xl">01. 100% Code Ownership</div>
        <p class="text-xs text-slate-400">You own every single commit, repository, and asset. Zero vendor lock-in, zero hostage licensing.</p>
      </div>
      <div class="space-y-1.5">
        <div class="text-[#ff3b30] font-black text-xl">02. Sub-400ms TTFB</div>
        <p class="text-xs text-slate-400">Server responses engineered for sub-second paint times on real mobile networks.</p>
      </div>
      <div class="space-y-1.5">
        <div class="text-[#ff3b30] font-black text-xl">03. Automated Schema &amp; SEO</div>
        <p class="text-xs text-slate-400">Structured JSON-LD schema, semantic tags, and canonical graph routing built into every template.</p>
      </div>
      <div class="space-y-1.5">
        <div class="text-[#ff3b30] font-black text-xl">04. Battle-Tested Security</div>
        <p class="text-xs text-slate-400">OWASP Top 10 compliance, rate-limiting, strict CORS policies, and automated security scans.</p>
      </div>
    </div>
  </div>
</div>',
                'features' => [
                    'PHP 8.3 & Laravel 11 Enterprise Application Architecture',
                    'Next.js 15 App Router, React 19 & Edge Server-Side Rendering (SSR/SSG)',
                    'MERN Stack (MongoDB, Express.js, React, Node.js) Full-Stack Engineering',
                    'Python, FastAPI & Django High-Performance Asynchronous APIs',
                    'Custom WordPress & Shopify Plus E-Commerce (Zero Bloatware)',
                    'Headless CMS, Decoupled Microservices & GraphQL Integrations',
                    'Sub-400ms Edge Delivery & 100/100 Core Web Vitals Guarantee',
                    'Automated CI/CD Pipelines, Docker Containers & OWASP Top 10 Security',
                ],
                'faqs' => [
                    [
                        'question' => 'Which web development stack is genuinely best for my business?',
                        'answer' => 'There is no one-size-fits-all answer. If you are building a data-rich SaaS or internal tool, Laravel 11 offers the fastest development cycle with bulletproof security. If your primary goal is consumer-facing SEO, extreme speed, and rich interactivity, Next.js 15 / React is unmatched. If you need real-time WebSockets or lightweight Node microservices, MERN is great. For e-commerce, custom Shopify or headless commerce ensures maximum revenue conversion. During our free discovery session, we review your exact roadmap and advise on the most cost-effective, future-proof stack.',
                    ],
                    [
                        'question' => 'How does your web development directly boost our Google search rankings?',
                        'answer' => 'Search engines favor fast, predictable, and semantically transparent websites. We optimize every layer: 1) Server-Side Rendering (SSR) ensures Googlebot crawls fully rendered HTML instead of blank JavaScript shells; 2) Sub-second TTFB and zero layout shift (CLS) directly pass Google Core Web Vitals; 3) Automated Schema.org JSON-LD structured data signals your exact brand entities and offerings; and 4) Clean URL routing prevents crawl budget waste.',
                    ],
                    [
                        'question' => 'Can you migrate our existing slow website without losing our current SEO rankings?',
                        'answer' => 'Absolutely. SEO preservation is a core discipline of our engineering team. We conduct a full pre-migration URL crawl audit, map every legacy URL to 301 redirects, preserve canonical tags, retain existing metadata structures, and test the staging environment thoroughly before DNS switchover. We have executed dozens of zero-loss migrations from legacy WordPress, Drupal, Magento, and custom PHP apps.',
                    ],
                    [
                        'question' => 'Do we own the full source code and intellectual property once built?',
                        'answer' => 'Yes, 100%. Upon project milestone completion, all Git repository rights, documentation, architecture diagrams, and custom code belong exclusively to your company. We never hold your code hostage or charge proprietary ongoing software licenses.',
                    ],
                    [
                        'question' => 'Can you integrate our web application with existing CRMs, ERPs, or payment gateways?',
                        'answer' => 'Yes. We build custom API bridges and webhooks for Stripe, PayPal, Razorpay, HubSpot, Salesforce, Zoho, SAP, QuickBooks, and proprietary internal databases. Our API endpoints are built with strict rate limiting, cryptographic validation, and error logging.',
                    ],
                    [
                        'question' => 'What does post-launch maintenance, SLAs, and technical support look like?',
                        'answer' => 'Every build includes a 30-day post-launch warranty where any defects or edge-case bugs are resolved at zero cost. After launch, we offer flexible SLA maintenance retainers that include 24/7 uptime monitoring, server security patching, dependency upgrades, monthly Core Web Vitals audits, and dedicated engineering sprint hours for new feature rollouts.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'SoftwareApplication',
                    'name' => 'WebRanker Enterprise Full-Stack Web Development Engine',
                    'operatingSystem' => 'Cloud, All Modern Browsers',
                    'applicationCategory' => 'WebApplication',
                    'description' => 'Custom full-stack web application development in PHP, Laravel, Next.js, React, MERN, Python, FastAPI, Django, WordPress, Shopify, and Headless architectures.',
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => '0',
                        'priceCurrency' => 'USD',
                        'availability' => 'https://schema.org/InStock',
                    ],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            [
                'title' => 'Mobile App Development',
                'slug' => 'app-development',
                'category' => 'Engineering & Architecture',
                'icon' => 'fa-solid fa-mobile-screen-button',
                'tagline' => 'iOS, Android, Flutter & React Native',
                'short_description' => 'Native and cross-platform mobile experiences with offline-first synchronisation and biometric security.',
                'badge' => 'Native & Hybrid',
                'kpi_label' => 'App Store Rating',
                'kpi_value' => '4.9★',
                'sort_order' => 2,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Cross-Platform & Native Mobile App Development | WebRanker',
                'meta_description' => 'High-performance iOS and Android mobile app development using Flutter and React Native with biometric security, offline sync, and real-time sockets.',
                'focus_keywords' => 'mobile app development, iOS app developer, Android app development, Flutter agency, React Native development',
                'detailed_content' => '<h3>Engineered for 60fps Native Fluidity & Offline Resilience</h3>
<p>Modern mobile users expect fluid touch interactions, instantaneous transitions, and dependable functionality even in low-connectivity environments. We design, develop, and publish enterprise-grade mobile applications for <strong>iOS</strong> and <strong>Android</strong> using <strong>Flutter</strong> and <strong>React Native</strong>.</p>

<h3>Key Mobile Engineering Capabilities</h3>
<ul>
  <li><strong>Offline-First Architecture:</strong> Local SQLite/Realm persistence engines that seamlessly sync changes with central servers upon reconnect.</li>
  <li><strong>Hardware & Biometric Integration:</strong> Secure Face ID, Touch ID, Bluetooth LE peripherals, Apple Pay, and Google Pay integration.</li>
  <li><strong>Real-Time WebSockets:</strong> Low-latency push notifications, live chat, and collaborative streaming interfaces.</li>
  <li><strong>Automated App Store CI/CD:</strong> Fastlane automated build scripts and Over-The-Air (OTA) hot updates.</li>
</ul>

<blockquote>"Great mobile apps feel weightless, intuitive, and respond instantly to human intent."</blockquote>',
                'features' => [
                    'Flutter 3 & React Native Multiplatform',
                    'Offline SQLite & Biometric Security Sync',
                    'Realtime WebSockets & Push Notifications',
                    'App Store & Play Store Compliance',
                    'OTA (Over-The-Air) Dynamic Hotfix Support',
                ],
                'faqs' => [
                    [
                        'question' => 'Should I choose Native or Cross-Platform (Flutter/React Native)?',
                        'answer' => 'For 90% of commercial applications, modern Flutter and React Native offer near-native 60fps performance with half the engineering cost and unified codebases. We help you choose based on your hardware needs.',
                    ],
                    [
                        'question' => 'Do you handle the Apple App Store and Google Play approval process?',
                        'answer' => 'Yes, our team manages end-to-end submissions, privacy manifest compliance, test flight deployments, and store listing optimization.',
                    ],
                    [
                        'question' => 'How do you secure sensitive user data on mobile devices?',
                        'answer' => 'We implement hardware-backed KeyStore/Keychain encryption, certificate pinning, biometric authentication, and strict OWASP Mobile Top 10 guidelines.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'SoftwareApplication',
                    'name' => 'WebRanker Mobile App Engineering Suite',
                    'operatingSystem' => 'iOS, Android',
                    'applicationCategory' => 'MobileApplication',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            [
                'title' => 'Custom Software Development',
                'slug' => 'custom-software-development',
                'category' => 'Engineering & Architecture',
                'icon' => 'fa-solid fa-cubes',
                'tagline' => 'Bespoke Enterprise Microservices & APIs',
                'short_description' => 'Tailored software architecture for complex enterprise workflows, multi-tenant databases, and mission-critical systems.',
                'badge' => 'Enterprise Grade',
                'kpi_label' => 'Uptime SLA',
                'kpi_value' => '99.99%',
                'sort_order' => 3,
                'is_featured' => false,
                'is_active' => true,
                'meta_title' => 'Enterprise Custom Software Development & APIs | WebRanker',
                'meta_description' => 'Scalable enterprise software development, event-driven microservices, multi-tenant SaaS architecture, and resilient API ecosystems.',
                'focus_keywords' => 'custom software development, enterprise software, microservices architecture, SaaS development, bespoke software solutions',
                'detailed_content' => '<h3>Bespoke Software Engineered for Complex Commercial Workflows</h3>
<p>Off-the-shelf software inevitably creates process compromises and costly license lock-in. WebRanker builds custom, proprietary software systems tailored directly to your operational workflows, compliance requirements, and scale goals.</p>

<h3>Enterprise Architectural Pillars</h3>
<ul>
  <li><strong>Event-Driven Microservices:</strong> Decoupled services communicating via Kafka and RabbitMQ for linear horizontal scalability.</li>
  <li><strong>Multi-Tenant Data Isolation:</strong> Schema-level segregation ensuring complete enterprise tenant privacy and compliance.</li>
  <li><strong>High-Throughput GraphQL & REST APIs:</strong> Sub-millisecond response times with Redis caching and rate-limiting gateways.</li>
  <li><strong>Role-Based Access Control (RBAC):</strong> Granular permissions, SAML/SSO authentication, and immutable audit logs.</li>
</ul>',
                'features' => [
                    'Event-Driven Microservices Architecture',
                    'High-Throughput REST & GraphQL APIs',
                    'Role-Based Access Control (RBAC) & SSO',
                    'Multi-Tenant Data Privacy Isolation',
                    'Automated CI/CD Quality Gateways',
                ],
                'faqs' => [
                    [
                        'question' => 'How does custom software compare in cost to commercial off-the-shelf software?',
                        'answer' => 'While initial development requires investment, custom software eliminates recurring seat licensing fees, adapts directly to your proprietary workflows, and creates valuable IP assets for your company.',
                    ],
                    [
                        'question' => 'Can you integrate with our legacy enterprise ERPs and databases?',
                        'answer' => 'Yes, our engineers specialize in building resilient integration layers, ESBs, and adapters for SAP, Salesforce, Oracle, and legacy SQL databases.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => 'Custom Software Engineering & Microservices',
                    'serviceType' => 'Software Development',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            [
                'title' => 'Cloud & DevOps Services',
                'slug' => 'cloud-devops',
                'category' => 'Engineering & Architecture',
                'icon' => 'fa-solid fa-cloud',
                'tagline' => 'Kubernetes, CI/CD & Zero-Downtime Infra',
                'short_description' => 'Automated cloud pipelines, Terraform infrastructure as code, and enterprise auto-scaling clusters on AWS, GCP & Azure.',
                'badge' => 'Multi-Cloud',
                'kpi_label' => 'Deploy Frequency',
                'kpi_value' => '15x/Day',
                'sort_order' => 4,
                'is_featured' => false,
                'is_active' => true,
                'meta_title' => 'Cloud Architecture, Kubernetes & DevOps CI/CD | WebRanker',
                'meta_description' => 'Enterprise cloud infrastructure, Kubernetes containerization, Terraform IaC, and automated zero-downtime CI/CD deployment pipelines on AWS & GCP.',
                'focus_keywords' => 'cloud devops services, AWS cloud consulting, Kubernetes deployment, Terraform infrastructure as code, CI/CD pipeline automation',
                'detailed_content' => '<h3>Elastic Infrastructure Engineered for Uninterrupted Availability</h3>
<p>Modern cloud infrastructure must be automated, reproducible, and self-healing. We modernize your deployment pipelines and cloud architectures using <strong>Terraform Infrastructure as Code (IaC)</strong>, <strong>Docker</strong>, and managed <strong>Kubernetes (EKS/GKE)</strong>.</p>

<h3>Core Cloud Competencies</h3>
<ul>
  <li><strong>Zero-Downtime Deployments:</strong> Blue/green and canary rollouts managed automatically through GitHub Actions and ArgoCD.</li>
  <li><strong>Automated Disaster Recovery:</strong> Multi-region replication, continuous backup verification, and 15-minute RTO/RPO targets.</li>
  <li><strong>Cloud Cost Optimization:</strong> Eliminating idle provisioned capacity, implementing spot instances, and optimizing egress traffic.</li>
</ul>',
                'features' => [
                    'Docker & Kubernetes EKS/GKE Orchestration',
                    'GitHub Actions & GitLab CI/CD Automation',
                    'Terraform & Pulumi Infrastructure as Code',
                    'Multi-Region Disaster Recovery & Failover',
                    'Cloud Cost Reduction & FinOps Optimization',
                ],
                'faqs' => [
                    [
                        'question' => 'Which cloud providers do you support?',
                        'answer' => 'We hold certifications and enterprise expertise across Amazon Web Services (AWS), Google Cloud Platform (GCP), Microsoft Azure, and Cloudflare.',
                    ],
                    [
                        'question' => 'How do you manage zero-downtime deployments?',
                        'answer' => 'We configure blue-green and canary deployment strategies with automated health verification. Traffic only shifts to new pods once internal health checks confirm stability.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => 'Cloud Infrastructure & DevOps Automation',
                    'serviceType' => 'Cloud Architecture',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            [
                'title' => 'Digital Marketing & SEO',
                'slug' => 'seo-services',
                'category' => 'Growth & Intelligence',
                'icon' => 'fa-solid fa-magnifying-glass-chart',
                'tagline' => 'Technical Audits, Topical Clusters & #1 Rankings',
                'short_description' => 'Data-backed search strategies targeting high-intent commercial keywords, entity graph optimization, and organic domain authority.',
                'badge' => '#1 Rank Strategy',
                'kpi_label' => 'Organic Lift',
                'kpi_value' => '+340%',
                'sort_order' => 5,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Enterprise Technical SEO & Organic Search Growth | WebRanker',
                'meta_description' => 'Dominate organic Google SERPs with entity schema graphing, topical authority architecture, algorithmic technical audits, and commercial rank growth.',
                'focus_keywords' => 'technical SEO services, enterprise SEO agency, topical authority mapping, JSON-LD schema optimization, organic search growth',
                'detailed_content' => '<h3>Algorithmic Search Optimization That Dominates First-Page SERPs</h3>
<p>Modern Google rankings demand much more than keyword stuffing. Search algorithms now evaluate entity graphs, topical depth, Core Web Vitals, and semantic Schema.org microdata. We deliver algorithmic search dominance through rigorous technical engineering and high-authority digital PR.</p>

<h3>The WebRanker Search Methodology</h3>
<ul>
  <li><strong>Technical Crawl Optimization:</strong> Eliminating crawl budget waste, index bloat, redirect chains, and canonical confusion.</li>
  <li><strong>Topical Authority Mapping:</strong> Architecting comprehensive pillar and cluster structures that establish undeniable niche leadership.</li>
  <li><strong>Entity & JSON-LD Structured Data:</strong> Connecting Organization, Service, FAQ, and BreadcrumbList microdata to Google\'s Knowledge Graph.</li>
  <li><strong>High-Tier Digital PR & Backlinks:</strong> Earning editorial citations from tier-1 authoritative industry publications.</li>
</ul>',
                'features' => [
                    'Topical Authority Maps & Content Silos',
                    'Deep Technical Crawl & Log File Audits',
                    'Entity Graph & JSON-LD Schema Suite',
                    'Core Web Vitals & PageSpeed Alignment',
                    'High-Tier Digital PR & Link Acquisition',
                ],
                'faqs' => [
                    [
                        'question' => 'How quickly can we expect to see ranking improvements?',
                        'answer' => 'Technical fixes and schema implementation typically trigger search bot re-indexing within 14 to 30 days. Broad topical authority rankings generally demonstrate compounding gains in months 3 to 6.',
                    ],
                    [
                        'question' => 'How do you handle Google Core Algorithm updates?',
                        'answer' => 'By strictly adhering to Google Search Essentials, EEAT guidelines, and white-hat architectural standards, our client websites consistently gain visibility during major core algorithm shifts.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => 'Technical SEO & Search Dominance Engine',
                    'serviceType' => 'Digital Marketing',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            [
                'title' => 'AI & Automation Solutions',
                'slug' => 'ai-automation',
                'category' => 'Growth & Intelligence',
                'icon' => 'fa-solid fa-robot',
                'tagline' => 'Autonomous Agents & Smart Workflow Bots',
                'short_description' => 'Deploying fine-tuned LLMs, automated retrieval-augmented generation (RAG) pipelines, and autonomous operational agents.',
                'badge' => 'GenAI Powered',
                'kpi_label' => 'Hours Saved',
                'kpi_value' => '1,200h/mo',
                'sort_order' => 6,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Enterprise AI Solutions, LLMs & Autonomous Agents | WebRanker',
                'meta_description' => 'Build enterprise AI agents, custom RAG vector search pipelines, and autonomous workflow bots to automate high-friction business operations.',
                'focus_keywords' => 'enterprise AI solutions, custom LLM development, RAG vector search, AI workflow automation, autonomous AI agents',
                'detailed_content' => '<h3>Autonomous Intelligence That Multiplies Enterprise Productivity</h3>
<p>Artificial intelligence is shifting from novelty to fundamental infrastructure. We design and deploy private, enterprise-grade AI applications including <strong>Retrieval-Augmented Generation (RAG)</strong> knowledge engines, automated document intelligence, and multi-agent workflow systems.</p>

<h3>Enterprise AI Solutions We Deploy</h3>
<ul>
  <li><strong>Proprietary Knowledge RAG:</strong> Grounding LLMs in your private corporate documents with Milvus/Pinecone vector databases and zero data leakage.</li>
  <li><strong>Autonomous Operational Agents:</strong> Bots capable of executing multi-step reasoning, interacting with internal APIs, and resolving tickets.</li>
  <li><strong>Intelligent OCR & Processing:</strong> Automated extraction and validation of financial invoices, legal agreements, and logistics manifests.</li>
</ul>',
                'features' => [
                    'Custom Vector Search & RAG Knowledge Bases',
                    'Autonomous Agentic Workflow Bots',
                    'Document Intelligence & Multimodal OCR',
                    'Private LLM Fine-Tuning & Self-Hosting',
                    'SOC-2 Compliant Zero-Retention Data Privacy',
                ],
                'faqs' => [
                    [
                        'question' => 'Is our proprietary enterprise data kept private and secure?',
                        'answer' => 'Yes. We deploy private models with zero data-retention policies, self-hosted open-source models (e.g. LLaMA 3), or enterprise Azure OpenAI environments with strict encryption.',
                    ],
                    [
                        'question' => 'What is RAG (Retrieval-Augmented Generation)?',
                        'answer' => 'RAG retrieves precise company documentation before answering a query, ensuring AI responses are 100% accurate, hallucination-free, and directly cited to source documents.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => 'Enterprise AI & Autonomous Automation',
                    'serviceType' => 'Artificial Intelligence Consulting',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            [
                'title' => 'E-commerce Solutions',
                'slug' => 'ecommerce-solutions',
                'category' => 'Growth & Intelligence',
                'icon' => 'fa-solid fa-cart-shopping',
                'tagline' => 'Shopify Plus, Headless & High-Volume Sales',
                'short_description' => 'Frictionless checkout experiences, omnichannel inventory synchronization, and high-converting headless storefronts.',
                'badge' => 'Conversion Engine',
                'kpi_label' => 'Checkout Conv.',
                'kpi_value' => '+28.4%',
                'sort_order' => 7,
                'is_featured' => false,
                'is_active' => true,
                'meta_title' => 'Headless E-Commerce & Shopify Plus Solutions | WebRanker',
                'meta_description' => 'High-conversion headless e-commerce storefronts, Shopify Plus scaling, 1-click checkout optimization, and real-time inventory ERP integrations.',
                'focus_keywords' => 'headless ecommerce development, Shopify Plus agency, custom ecommerce portals, conversion rate optimization, omnichannel retail',
                'detailed_content' => '<h3>High-Conversion Commerce Architectures for High-Growth Retailers</h3>
<p>Every millisecond of latency in an e-commerce funnel translates to abandoned carts. We architect ultra-fast headless commerce storefronts using <strong>Shopify Plus</strong>, <strong>MedusaJS</strong>, and <strong>Next.js Commerce</strong> to maximize conversion velocity.</p>

<h3>Commerce Capabilities</h3>
<ul>
  <li><strong>Sub-Second Headless Catalog:</strong> Instant product filtering, zero-lag faceted search, and edge cart synchronization.</li>
  <li><strong>1-Click Checkout Optimization:</strong> Native Apple Pay, Google Pay, Shop Pay, and Klarna integrations.</li>
  <li><strong>Real-Time ERP & Inventory Sync:</strong> Bidirectional integrations with NetSuite, SAP, and automated warehouse 3PLs.</li>
</ul>',
                'features' => [
                    'Shopify Plus & Custom Headless Storefronts',
                    'Frictionless 1-Click Optimized Checkouts',
                    'Real-Time ERP & 3PL Warehouse Inventory Sync',
                    'Dynamic AI Product Personalization',
                    'Global Multi-Currency & Localization',
                ],
                'faqs' => [
                    [
                        'question' => 'Why choose Headless E-commerce over standard themes?',
                        'answer' => 'Headless storefronts decouple frontend presentation from the commerce backend, allowing instant page transitions, bespoke checkout flows, and PageSpeed 99+ scores that boost conversion by 20-30%.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => 'Enterprise Headless E-Commerce Solutions',
                    'serviceType' => 'E-Commerce Development',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            [
                'title' => 'Site Optimization & Speed',
                'slug' => 'site-optimization',
                'category' => 'Growth & Intelligence',
                'icon' => 'fa-solid fa-gauge-high',
                'tagline' => 'Core Web Vitals, 99+ PageSpeed & CRO',
                'short_description' => 'Guaranteeing green 95+ Google PageSpeed scores, sub-second LCP, zero CLS, and instant interaction to boost Google rankings.',
                'badge' => 'PageSpeed 99+',
                'kpi_label' => 'Mobile Score',
                'kpi_value' => '99/100',
                'sort_order' => 8,
                'is_featured' => false,
                'is_active' => true,
                'meta_title' => 'Core Web Vitals & 99+ PageSpeed Optimization | WebRanker',
                'meta_description' => 'Guaranteed 95+ Google PageSpeed scores, sub-second LCP, zero CLS, and TTFB reduction to skyrocket organic rank and conversion rates.',
                'focus_keywords' => 'core web vitals optimization, website speed optimization, Google PageSpeed 99, TTFB reduction, LCP and INP fix',
                'detailed_content' => '<h3>Sub-Second Performance Engineering for Search & Conversion</h3>
<p>Google has made page speed and Core Web Vitals direct ranking criteria. We perform deep bytecode audits, asset optimization, critical CSS inlining, and edge server tuning to achieve green 95+ scores on both mobile and desktop.</p>

<h3>Core Web Vitals Targets We Guarantee</h3>
<ul>
  <li><strong>Largest Contentful Paint (LCP):</strong> Under 1.2 seconds across all cellular and broadband connections.</li>
  <li><strong>Cumulative Layout Shift (CLS):</strong> Exact 0.00 score with zero disruptive element jumps.</li>
  <li><strong>Interaction to Next Paint (INP):</strong> Sub-100ms response to taps, clicks, and keystrokes.</li>
  <li><strong>Time to First Byte (TTFB):</strong> Under 120ms globally via Cloudflare CDN edge workers.</li>
</ul>',
                'features' => [
                    'Guaranteed Green 95+ Google PageSpeed Score',
                    'LCP, INP & CLS Core Web Vitals Remediation',
                    'Next-Gen Image Pipeline (AVIF/WebP Compression)',
                    'Critical CSS Inlining & Unused JS Elimination',
                    'Server Response Time (TTFB) Reduction Under 150ms',
                ],
                'faqs' => [
                    [
                        'question' => 'Do you guarantee green scores on mobile devices?',
                        'answer' => 'Yes, our engineering contracts specify guaranteed passing Core Web Vitals scores on Google PageSpeed Insights for both mobile and desktop environments.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => 'Core Web Vitals & Speed Optimization',
                    'serviceType' => 'Performance Engineering',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            [
                'title' => 'UI/UX Design & Branding',
                'slug' => 'ui-ux-design',
                'category' => 'Design & Reliability',
                'icon' => 'fa-solid fa-palette',
                'tagline' => 'Conversion Design Systems & Premium UI',
                'short_description' => 'Human-centric user journeys, high-fidelity Figma prototypes, and modular design tokens that elevate brand prestige.',
                'badge' => 'Design System',
                'kpi_label' => 'User Engagement',
                'kpi_value' => '+76%',
                'sort_order' => 9,
                'is_featured' => false,
                'is_active' => true,
                'meta_title' => 'UI/UX Design Systems & High-Conversion Branding | WebRanker',
                'meta_description' => 'Elevate brand prestige with human-centric UX research, interactive Figma design systems, WCAG 2.1 AA accessibility, and CRO UI interfaces.',
                'focus_keywords' => 'UI UX design services, enterprise design systems, Figma prototyping, conversion rate design, digital product design',
                'detailed_content' => '<h3>Conversion-Focused Digital Interfaces That Command Respect</h3>
<p>Visual design should never be decorative; it is the fundamental bridge between human psychology and commercial conversion. We create scalable design systems, interactive prototypes, and conversion-optimized digital interfaces.</p>

<h3>Design System Architecture</h3>
<ul>
  <li><strong>Modular Figma Design Tokens:</strong> Unified color palettes, typographic scales, spacing tokens, and component states.</li>
  <li><strong>WCAG 2.1 AA Accessibility:</strong> Complete contrast validation, screen-reader semantic structures, and keyboard navigation.</li>
  <li><strong>Micro-Interactions & Motion Design:</strong> Subtle cues that guide user attention directly to conversion funnels.</li>
</ul>',
                'features' => [
                    'Interactive High-Fidelity Figma Prototypes',
                    'Comprehensive Design Tokens & Component Libraries',
                    'Full WCAG 2.1 AA Accessibility Compliance',
                    'Conversion Rate Optimization (CRO) User Journeys',
                    'Design-to-Code Developer Handoff Specifications',
                ],
                'faqs' => [
                    [
                        'question' => 'What deliverables do you provide at the end of the design phase?',
                        'answer' => 'You receive a complete production-ready Figma design library, responsive mobile/tablet/desktop layouts, interactive click-through prototypes, design tokens, and exportable SVG/image assets.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => 'UI/UX Product Design & Branding Systems',
                    'serviceType' => 'Design Services',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            [
                'title' => 'Website Maintenance & Support',
                'slug' => 'website-maintenance',
                'category' => 'Design & Reliability',
                'icon' => 'fa-solid fa-shield-heart',
                'tagline' => '24/7 SLA Uptime, Security & CWV Guard',
                'short_description' => 'Continuous monitoring, automated daily backups, security vulnerability patching, and perpetual Core Web Vitals health guards.',
                'badge' => '24/7 Guardian',
                'kpi_label' => 'Response Time',
                'kpi_value' => '< 15 Min',
                'sort_order' => 10,
                'is_featured' => false,
                'is_active' => true,
                'meta_title' => '24/7 Enterprise Website Maintenance & SLA Support | WebRanker',
                'meta_description' => 'Peace of mind with 24/7 uptime monitoring, automated hourly backups, vulnerability patching, and perpetual Core Web Vitals health guard.',
                'focus_keywords' => 'website maintenance services, 24/7 website support, web security patching, SLA uptime guarantee, enterprise web maintenance',
                'detailed_content' => '<h3>Perpetual Peace of Mind with Guaranteed Response Times</h3>
<p>Modern web applications require ongoing care to protect against newly discovered security vulnerabilities, framework deprecations, and performance regressions. Our maintenance contracts guarantee your digital assets remain protected, fast, and continuously online.</p>

<h3>Maintenance Protections Included</h3>
<ul>
  <li><strong>24/7 Global Synthetic Uptime Monitoring:</strong> Real-time alerts dispatched to senior engineers within 60 seconds of any anomaly.</li>
  <li><strong>Automated Hourly Offsite Backups:</strong> Point-in-time database restoration tested monthly for disaster recovery compliance.</li>
  <li><strong>Continuous Security Patching:</strong> Rapid deployment of dependency updates, SSL certificates, and WAF firewall rules.</li>
</ul>',
                'features' => [
                    '24/7 Continuous Synthetic Health & Uptime Pings',
                    'Automated Hourly Offsite Disaster Recovery Backups',
                    'Perpetual Core Web Vitals & Speed Regression Guards',
                    'Rapid Vulnerability Patching & Dependency Upgrades',
                    'Guaranteed 15-Minute Emergency Incident SLA',
                ],
                'faqs' => [
                    [
                        'question' => 'How quickly do you respond to an unexpected outage?',
                        'answer' => 'Our emergency on-call team responds within 15 minutes under our priority enterprise SLA, initiating failover and disaster recovery protocols immediately.',
                    ],
                ],
                'custom_schema' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => '24/7 Enterprise Website Maintenance & Health Guard',
                    'serviceType' => 'Website Maintenance',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],
        ];

        foreach ($services as $svc) {
            $svc['og_image'] = $svc['og_image'] ?? ('asset/services/' . $svc['slug'] . '.jpg');
            Service::updateOrCreate(
                ['slug' => $svc['slug']],
                $svc
            );
        }
    }
}
