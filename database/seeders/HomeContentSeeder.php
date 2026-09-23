<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\IndustryDomain;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HomeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Default Admin Account
        User::updateOrCreate(
            ['email' => 'admin@webranker.com'],
            [
                'name' => 'WebRanker Admin',
                'password' => Hash::make('password123'),
            ]
        );

        // 1. Site Settings (SEO & Brand)
        $settings = [
            'site_name' => 'WebRanker',
            'site_tagline' => 'Web & App Development, SEO, Content & Performance Optimization',
            'meta_title' => 'WebRanker | Web & App Development, SEO, Content & Performance Optimization',
            'meta_description' => 'WebRanker is an elite engineering and organic search agency specializing in Web Development, Mobile Apps, Technical SEO, Topical Content, and Site Speed Optimization for E-Commerce, Healthcare, and Fintech.',
            'meta_keywords' => 'web development, mobile app development, technical SEO, organic search ranking, site speed optimization, core web vitals, ecommerce development, AI automation',
            'canonical_base' => 'https://webranker.com',
            'og_image' => 'asset/logo.svg',
            'contact_email' => 'growth@webranker.com',
            'contact_phone' => '+91 (141) 234-5678',
            'contact_address' => 'Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar, Jaipur, Rajasthan 302017',
            'geo_latitude' => '26.844394',
            'geo_longitude' => '75.805302',
            'social_twitter' => 'https://twitter.com/webranker',
            'social_linkedin' => 'https://linkedin.com/company/webranker',
            'social_github' => 'https://github.com/webranker',
            'google_site_verification' => 'google-site-verification-webranker-token',
            'bing_site_verification' => 'bing-site-verification-webranker-token',

            // Structured Schema Configurations
            'schema_local_business' => json_encode([
                'name' => 'WebRanker Technologies HQ',
                'legal_name' => 'WebRanker Digital & Engineering Solutions Pvt. Ltd.',
                'image' => 'asset/logo.svg',
                'street_address' => 'Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar, Jaipur, Rajasthan 302017',
                'address_locality' => 'Jaipur',
                'address_region' => 'Rajasthan',
                'postal_code' => '302017',
                'address_country' => 'IN',
                'telephone' => '+91 97185 70218',
                'email' => 'growth@webranker.com',
                'latitude' => '26.844394',
                'longitude' => '75.805302',
                'price_range' => '$$$',
                'opening_hours' => 'Mo-Fr 09:00-19:00',
                'currencies_accepted' => 'USD, EUR, GBP, INR, AED',
                'area_served' => 'Worldwide (USA, Canada, UK, UAE, India, Australia)',
            ]),

            'schema_organization' => json_encode([
                'name' => 'WebRanker',
                'legal_name' => 'WebRanker Digital Global Enterprise Ltd.',
                'alternate_name' => 'WebRanker SEO & Tech Labs',
                'founding_date' => '2020-01-15',
                'founder_name' => 'Alexander Reed',
                'logo_url' => 'asset/logo.svg',
                'customer_service_phone' => '+91 (141) 234-5678',
                'customer_service_email' => 'support@webranker.com',
                'social_links' => [
                    'https://twitter.com/webranker',
                    'https://linkedin.com/company/webranker',
                    'https://facebook.com/webranker',
                    'https://github.com/webranker',
                    'https://youtube.com/@webranker',
                ],
            ]),

            'schema_seo' => json_encode([
                'meta_title' => 'WebRanker | Web & App Development, SEO, Content & Performance Optimization',
                'meta_description' => 'WebRanker is an elite engineering and organic search agency specializing in Web Development, Mobile Apps, Technical SEO, Topical Content, and Site Speed Optimization.',
                'meta_keywords' => 'web development, mobile app development, technical SEO, organic search ranking, site speed optimization, core web vitals, ecommerce development, AI automation',
                'og_title' => 'WebRanker | Top #1 Organic Growth & Engineering',
                'og_description' => 'Turn search traffic into revenue with sub-second web performance, custom app architectures, and high-impact SEO.',
                'og_image' => 'asset/logo.svg',
                'twitter_handle' => '@webranker',
                'robots_directive' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
                'google_site_verification' => 'google-verification-code-sample',
                'bing_site_verification' => 'bing-verification-code-sample',
            ]),

            'schema_custom_jsonld' => json_encode([
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'SoftwareApplication',
                    'name' => 'WebRanker Core Performance Audit Engine',
                    'operatingSystem' => 'All Web Platforms',
                    'applicationCategory' => 'BusinessApplication',
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => '0.00',
                        'priceCurrency' => 'USD',
                    ],
                    'aggregateRating' => [
                        '@type' => 'AggregateRating',
                        'ratingValue' => '4.9',
                        'ratingCount' => '342',
                    ],
                ]
            ], JSON_PRETTY_PRINT),

            'schema_toggles' => json_encode([
                'enable_local_business' => true,
                'enable_organization' => true,
                'enable_website' => true,
                'enable_faq' => true,
                'enable_services' => true,
                'enable_custom_jsonld' => true,
            ]),
        ];

        foreach ($settings as $k => $v) {
            $type = is_array($v) || (is_string($v) && (str_starts_with($v, '{') || str_starts_with($v, '['))) ? 'json' : 'text';
            SiteSetting::updateOrCreate(['key' => $k], ['value' => $v, 'type' => $type, 'group' => 'seo']);
        }

        // 2. Services (All 10 Core Services across 3 pillars)
        $services = [
            [
                'title' => 'Web Development Services',
                'slug' => 'web-development',
                'category' => 'Engineering & Architecture',
                'icon' => 'fa-solid fa-code',
                'tagline' => 'Next.js, React & Scalable Web Portals',
                'short_description' => 'Architecting ultra-fast, server-rendered web portals engineered for high conversion rates and sub-second Core Web Vitals.',
                'badge' => 'High Performance',
                'kpi_label' => 'Avg Load Time',
                'kpi_value' => '0.42s',
                'sort_order' => 1,
                'features' => ['Next.js App Router & SSR', 'Edge Function Caching', 'Zero-CLS Layout Engine', 'Micro-frontends Integration'],
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
                'features' => ['Flutter 3 & React Native', 'Offline SQLite Sync', 'Push Engine & Realtime WebSockets', 'App Store Optimization (ASO)'],
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
                'features' => ['Event-Driven Microservices', 'High-Throughput REST & GraphQL', 'Role-Based Access Control', 'Multi-tenant Isolation'],
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
                'features' => ['Docker & Kubernetes EKS/GKE', 'GitHub Actions CI/CD', 'Automated Failover & DR', 'Cloud Cost Optimization'],
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
                'features' => ['Topical Authority Maps', 'Deep Technical Crawl Audits', 'Entity & Schema Graphing', 'High-Tier Digital PR'],
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
                'features' => ['Custom Vector Search & RAG', 'Agentic Workflow Automation', 'OCR & Document Intelligence', 'Customer Support Chatbots'],
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
                'features' => ['Shopify Plus & Headless Commerce', '1-Click Checkout Flows', 'Real-time ERP & Inventory Sync', 'Dynamic Personalization'],
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
                'features' => ['LCP, INP & CLS Optimization', 'Next-Gen AVIF/WebP Compression', 'Critical CSS & Tree-shaking', 'Server Response Time (TTFB) < 150ms'],
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
                'features' => ['Interactive Figma Prototypes', 'Accessible WCAG 2.1 AA Standards', 'Design Tokens & Component Libraries', 'Conversion Rate Optimization (CRO) UI'],
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
                'features' => ['24/7 Realtime Health Pings', 'Continuous Security Patches', 'Speed Regression Prevention', 'Priority Emergency Escalation'],
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        // 3. 25+ Industry Domains
        $domains = [
            ['name' => 'E-Commerce & Retail', 'slug' => 'ecommerce-retail', 'icon' => 'fa-cart-shopping', 'highlight_stat' => '+310%', 'stat_label' => 'Revenue Growth', 'description' => 'High-load catalog architecture with headless checkout.'],
            ['name' => 'Healthcare & MedTech', 'slug' => 'healthcare-medtech', 'icon' => 'fa-heart-pulse', 'highlight_stat' => 'HIPAA', 'stat_label' => 'Compliant Telehealth', 'description' => 'Secure patient portals, HL7/FHIR integration and telemedicine.'],
            ['name' => 'Fintech & Banking', 'slug' => 'fintech-banking', 'icon' => 'fa-building-columns', 'highlight_stat' => '99.999%', 'stat_label' => 'Transaction Uptime', 'description' => 'PCI-DSS certified payment gateways and algorithmic risk engines.'],
            ['name' => 'Real Estate & PropTech', 'slug' => 'real-estate-proptech', 'icon' => 'fa-city', 'highlight_stat' => '4.8x', 'stat_label' => 'Lead Volume', 'description' => 'Interactive virtual tours, MLS/IDX feeds and automated valuations.'],
            ['name' => 'EdTech & Learning', 'slug' => 'edtech-learning', 'icon' => 'fa-graduation-cap', 'highlight_stat' => '500K+', 'stat_label' => 'Active Learners', 'description' => 'Gamified learning platforms, SCORM compliant LMS and live classrooms.'],
            ['name' => 'Travel & Hospitality', 'slug' => 'travel-hospitality', 'icon' => 'fa-plane-departure', 'highlight_stat' => '2.4s', 'stat_label' => 'Instant Booking', 'description' => 'GDS engine integration, dynamic pricing and itinerary generators.'],
            ['name' => 'Automotive & Mobility', 'slug' => 'automotive-mobility', 'icon' => 'fa-car-side', 'highlight_stat' => '35M+', 'stat_label' => 'Telematics Pings', 'description' => 'Connected vehicle telematics, EV charging grids and dealership portals.'],
            ['name' => 'Logistics & Supply Chain', 'slug' => 'logistics-supply-chain', 'icon' => 'fa-truck-fast', 'highlight_stat' => '-40%', 'stat_label' => 'Route Latency', 'description' => 'Real-time GPS fleet tracking, automated warehouse dispatch and IoT.'],
            ['name' => 'SaaS & Enterprise B2B', 'slug' => 'saas-enterprise', 'icon' => 'fa-server', 'highlight_stat' => '10x', 'stat_label' => 'Tenant Scaling', 'description' => 'Multi-tenant cloud architecture with usage-based billing engines.'],
            ['name' => 'Media & Entertainment', 'slug' => 'media-entertainment', 'icon' => 'fa-film', 'highlight_stat' => '4K 60fps', 'stat_label' => 'Adaptive Streaming', 'description' => 'Ultra-low latency HLS video streaming, CDN edge distribution.'],
            ['name' => 'Legal & Compliance', 'slug' => 'legal-compliance', 'icon' => 'fa-scale-balanced', 'highlight_stat' => '100%', 'stat_label' => 'Audit Trail', 'description' => 'Automated legal contract discovery, redlining and e-signatures.'],
            ['name' => 'Manufacturing & Industry 4.0', 'slug' => 'manufacturing-industry', 'icon' => 'fa-industry', 'highlight_stat' => '99.8%', 'stat_label' => 'Predictive Yield', 'description' => 'Smart factory SCADA dashboards, IoT sensor telemetries.'],
            ['name' => 'Energy & CleanTech', 'slug' => 'energy-cleantech', 'icon' => 'fa-bolt', 'highlight_stat' => '-28%', 'stat_label' => 'Grid Peak Waste', 'description' => 'Renewable energy trading algorithms and smart meter management.'],
            ['name' => 'Insurance & InsurTech', 'slug' => 'insurance-insurtech', 'icon' => 'fa-shield-halved', 'highlight_stat' => '3 Min', 'stat_label' => 'Instant Claim', 'description' => 'AI-driven computer vision claim estimation and policy underwriting.'],
            ['name' => 'Gaming & Esports', 'slug' => 'gaming-esports', 'icon' => 'fa-gamepad', 'highlight_stat' => '<15ms', 'stat_label' => 'Edge Latency', 'description' => 'Real-time multiplayer leaderboards and low-latency matchmaking.'],
            ['name' => 'Non-Profit & NGOs', 'slug' => 'non-profit-ngos', 'icon' => 'fa-hand-holding-heart', 'highlight_stat' => '+180%', 'stat_label' => 'Donation Conv.', 'description' => 'Global recurring donor portals with transparent impact dashboards.'],
            ['name' => 'Aerospace & Defense', 'slug' => 'aerospace-defense', 'icon' => 'fa-shuttle-space', 'highlight_stat' => 'Mil-Spec', 'stat_label' => 'Hardened Security', 'description' => 'Encrypted flight data management and supply part validation.'],
            ['name' => 'Agriculture & AgTech', 'slug' => 'agriculture-agtech', 'icon' => 'fa-wheat-awn', 'highlight_stat' => '+32%', 'stat_label' => 'Crop Yield', 'description' => 'Satellite NDVI imagery processing and automated drone dispatch.'],
            ['name' => 'Fashion & Luxury', 'slug' => 'fashion-luxury', 'icon' => 'fa-gem', 'highlight_stat' => '3D AR', 'stat_label' => 'Virtual Try-On', 'description' => 'Interactive 3D WebGL product customizers and virtual runway previews.'],
            ['name' => 'Food & Quick Service (QSR)', 'slug' => 'food-qsr', 'icon' => 'fa-utensils', 'highlight_stat' => '4.2s', 'stat_label' => 'Kitchen Dispatch', 'description' => 'POS integrations, geolocation delivery routing and loyalty wallets.'],
            ['name' => 'Human Resources & HRTech', 'slug' => 'hr-hrtech', 'icon' => 'fa-users', 'highlight_stat' => '65%', 'stat_label' => 'Faster Hiring', 'description' => 'AI candidate screening, automated payroll and global compliance.'],
            ['name' => 'Biotechnology & Pharma', 'slug' => 'biotech-pharma', 'icon' => 'fa-dna', 'highlight_stat' => 'FDA Part 11', 'stat_label' => 'Clinical Compliance', 'description' => 'Clinical trial data capture and molecular modeling visualization.'],
            ['name' => 'Telecom & 5G Infrastructure', 'slug' => 'telecom-5g', 'icon' => 'fa-tower-cell', 'highlight_stat' => '10Gbps', 'stat_label' => 'Network Slice', 'description' => 'Billing OSS/BSS modernization and subscriber self-service apps.'],
            ['name' => 'Architecture & Engineering', 'slug' => 'architecture-engineering', 'icon' => 'fa-compass-drafting', 'highlight_stat' => 'BIM 360', 'stat_label' => 'Integrated Sync', 'description' => 'Cloud CAD model collaboration and structural lifecycle analytics.'],
            ['name' => 'Government & Public Sector', 'slug' => 'government-public-sector', 'icon' => 'fa-landmark', 'highlight_stat' => 'GovCloud', 'stat_label' => 'Certified Access', 'description' => 'Accessible citizen services, e-governance workflows and security.'],
        ];

        foreach ($domains as $index => $dom) {
            IndustryDomain::updateOrCreate(
                ['slug' => $dom['slug']],
                array_merge($dom, ['sort_order' => $index + 1, 'is_active' => true])
            );
        }

        // 4. Client Testimonials
        $testimonials = [
            [
                'client_name' => 'David Sterling',
                'client_title' => 'Chief Technology Officer',
                'company' => 'Aether Health Technologies',
                'avatar' => 'asset/df-person1.png',
                'rating' => 5,
                'metric_highlight' => '+420%',
                'metric_label' => 'Organic Search Traffic',
                'service_used' => 'Web Development & Technical SEO',
                'review_text' => 'WebRanker transformed our fragmented clinical web presence into a blazing-fast, server-rendered Next.js portal. In less than 4 months, our organic patient inquiries quadrupled, and our Google PageSpeed score jumped from 48 to a flawless 99 on mobile.',
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Elena Rostova',
                'client_title' => 'Head of Global Growth',
                'company' => 'Vortex Fintech Solutions',
                'avatar' => 'asset/df-person2.png',
                'rating' => 5,
                'metric_highlight' => '99/100',
                'metric_label' => 'Core Web Vitals Score',
                'service_used' => 'Site Speed & Custom Software',
                'review_text' => 'The engineering rigor WebRanker brought to our fintech app was phenomenal. Their zero-CLS architecture and technical SEO clusters gave us #1 search rankings across 38 high-intent commercial terms in both the US and UK markets.',
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Marcus Vance',
                'client_title' => 'Founder & Managing Director',
                'company' => 'Solace Direct E-Commerce',
                'avatar' => 'asset/df-person3.png',
                'rating' => 5,
                'metric_highlight' => '$3.8M',
                'metric_label' => 'Incremental Organic Revenue',
                'service_used' => 'Headless E-Commerce & SEO',
                'review_text' => 'We replaced our sluggish legacy store with WebRanker’s headless architecture. Our conversion rate increased by 28%, bounce rate plummeted by 44%, and we achieved top 3 Google positions for our most profitable product lines.',
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['company' => $t['company']], $t);
        }

        // 5. Accordion FAQs (High-Intent Organic Search Queries)
        $faqs = [
            [
                'question' => 'How does WebRanker achieve guaranteed sub-second load times and 99+ Core Web Vitals?',
                'answer' => 'We utilize an advanced performance stack comprising server-side rendering (SSR), edge function caching, automated AVIF/WebP image pipelines, tree-shaken critical CSS, and zero-blocking JavaScript. Every asset is optimized to ensure Largest Contentful Paint (LCP) remains under 0.8s, Interaction to Next Paint (INP) under 50ms, and Cumulative Layout Shift (CLS) at exactly 0.00.',
                'category' => 'Performance & Engineering',
                'sort_order' => 1,
            ],
            [
                'question' => 'What is WebRanker’s approach to topical authority and #1 Google rankings?',
                'answer' => 'Rather than chasing isolated keywords, we build comprehensive semantic entity graphs. We map out full topical clusters, engineer deep internal linking networks, apply schema.org structured microdata, and resolve technical crawl bottlenecks. This signals undeniable topical authority to Google’s Helpful Content and RankBrain algorithms.',
                'category' => 'SEO & Ranking',
                'sort_order' => 2,
            ],
            [
                'question' => 'How quickly will we see measurable organic growth after launching with WebRanker?',
                'answer' => 'While organic search is an ongoing compounding asset, our technical optimizations yield immediate crawl rate spikes within 14 days. Most enterprise clients experience a 40% to 120% surge in impressions within 60 days, followed by significant top-3 rank captures and inbound lead volume scaling through months 3 to 6.',
                'category' => 'Growth & Timeline',
                'sort_order' => 3,
            ],
            [
                'question' => 'Do you build custom mobile apps or hybrid cross-platform solutions?',
                'answer' => 'We engineer both. For maximum performance and budget efficiency, we specialize in modern Flutter 3 and React Native architectures that deliver 60fps native performance on both iOS and Android from a unified codebase. We also build pure Swift and Kotlin native modules when deep hardware or sensor hooks are mandatory.',
                'category' => 'App Development',
                'sort_order' => 4,
            ],
            [
                'question' => 'How does the free 48-Hour Technical & SEO Audit work?',
                'answer' => 'When you submit your domain via our inquiry drawer, our senior architects run a comprehensive diagnostic covering 85+ ranking factors: Core Web Vitals telemetry, server TTFB, crawl budget leaks, schema coverage, semantic gap analysis, and competitor backlink profiles. You receive an actionable, executive-ready roadmap within 48 hours.',
                'category' => 'Audit & Onboarding',
                'sort_order' => 5,
            ],
        ];

        foreach ($faqs as $f) {
            Faq::updateOrCreate(['question' => $f['question']], $f);
        }

        // 6. Dynamic Blog Insights
        $blogs = [
            [
                'title' => 'Mastering Core Web Vitals in 2026: Why Interaction to Next Paint (INP) Dictates Rankings',
                'slug' => 'mastering-core-web-vitals-inp-rankings',
                'excerpt' => 'An in-depth technical analysis of Google’s latest search algorithm updates and how sub-50ms INP response times unlock dominant rankings.',
                'featured_image' => 'asset/blog-agentic-ai.jpg',
                'category' => 'Technical SEO',
                'author_name' => 'Alexander Reed',
                'read_time' => '6 min read',
                'views' => 1420,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Agentic AI in Enterprise Web Portals: Transitioning from Chatbots to Autonomous Workflows',
                'slug' => 'agentic-ai-enterprise-web-portals',
                'excerpt' => 'How leading brands embed multi-agent LLM systems directly into user interfaces to automate complex customer transactions in realtime.',
                'featured_image' => 'asset/blog-generative-ai.jpg',
                'category' => 'AI & Engineering',
                'author_name' => 'Priya Sharma',
                'read_time' => '8 min read',
                'views' => 2190,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Headless E-Commerce at Scale: How Sub-Second Checkouts Recover 30% of Abandoned Carts',
                'slug' => 'headless-ecommerce-sub-second-checkouts',
                'excerpt' => 'Case study breakdown of how migrating to a Next.js front-end with Shopify Plus back-end delivers peak conversion during traffic spikes.',
                'featured_image' => 'asset/blog-data-engineering.jpg',
                'category' => 'E-Commerce',
                'author_name' => 'Marcus Vance',
                'read_time' => '5 min read',
                'views' => 980,
                'published_at' => now()->subDays(9),
            ],
        ];

        foreach ($blogs as $b) {
            BlogPost::updateOrCreate(['slug' => $b['slug']], $b);
        }
    }
}
