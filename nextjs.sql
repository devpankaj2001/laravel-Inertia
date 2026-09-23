-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 23, 2026 at 12:49 PM
-- Server version: 8.0.33
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nextjs`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `faqs` json DEFAULT NULL,
  `custom_schema` text COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `focus_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` json DEFAULT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'WebRanker Team',
  `author_role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `read_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '5 min read',
  `views` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `excerpt`, `content`, `faqs`, `custom_schema`, `featured_image`, `meta_title`, `meta_description`, `focus_keywords`, `category`, `tags`, `author_name`, `author_role`, `author_avatar`, `read_time`, `views`, `is_published`, `is_featured`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Mastering Core Web Vitals in 2026: Why Interaction to Next Paint (INP) Dictates Rankings', 'mastering-core-web-vitals-inp-rankings', 'An in-depth technical analysis of Google’s latest search algorithm updates and how sub-50ms INP response times unlock dominant rankings.', NULL, NULL, NULL, 'asset/blog-agentic-ai.jpg', NULL, NULL, NULL, 'Technical SEO', NULL, 'Alexander Reed', NULL, NULL, '6 min read', 1424, 1, 0, '2026-09-20 08:06:05', '2026-09-21 03:59:51', '2026-09-23 01:40:11'),
(2, 'Agentic AI in Enterprise Web Portals: Transitioning from Chatbots to Autonomous Workflows', 'agentic-ai-enterprise-web-portals', 'How leading brands embed multi-agent LLM systems directly into user interfaces to automate complex customer transactions in realtime.', NULL, NULL, NULL, 'asset/blog-generative-ai.jpg', NULL, NULL, NULL, 'AI & Engineering', NULL, 'Priya Sharma', NULL, NULL, '8 min read', 2192, 1, 0, '2026-09-17 08:06:05', '2026-09-21 03:59:51', '2026-09-23 03:19:07'),
(3, 'Headless E-Commerce at Scale: How Sub-Second Checkouts Recover 30% of Abandoned Carts', 'headless-ecommerce-sub-second-checkouts', 'Case study breakdown of how migrating to a Next.js front-end with Shopify Plus back-end delivers peak conversion during traffic spikes.', NULL, NULL, NULL, 'asset/blog-data-engineering.jpg', NULL, NULL, NULL, 'E-Commerce', NULL, 'Marcus Vance', NULL, NULL, '5 min read', 982, 1, 0, '2026-09-13 08:06:05', '2026-09-21 03:59:51', '2026-09-23 03:29:15'),
(17, 'FinTech SEO & Technical Compliance: Ranking High-Trust Banking and Payment Platforms', 'fintech-seo-technical-compliance-banking-platforms', 'Navigating Your Money or Your Life (YMYL) guidelines: How neo-banks, crypto protocols, and lending platforms establish bulletproof institutional trust.', '<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">01</span>\n    <h2 id=\"ymyl-framework\">Google YMYL Standards in Financial Search</h2>\n  </div>\n  <p>Financial queries are held to Google\'s highest quality benchmarks. A single inaccurate APR calculation or missing regulatory disclosure can trigger algorithmic demotions across your entire domain. Demonstrating verifiable author credentials and institutional backing is mandatory.</p>\n  <h3 id=\"author-validation\">Author Credentials & Editorial Board Verification</h3>\n  <p>Every guide, calculator, and comparison piece must feature verified financial analysts with schema-backed biographical citations linking to LinkedIn and regulatory registers.</p>\n</section>\n\n<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">02</span>\n    <h2 id=\"programmatic-calculators\">Interactive Loan & Investment Calculators as Backlink Magnets</h2>\n  </div>\n  <p>Custom financial calculators (e.g., mortgage amortization, crypto yield staking, cross-border fee comparison) earn thousands of organic backlinks from Tier-1 financial media without manual outreach.</p>\n</section>\n\n<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">03</span>\n    <h2 id=\"technical-security\">Security Headers & SSL Encryption as Ranking Signals</h2>\n  </div>\n  <p>FinTech websites must implement Strict-Transport-Security (HSTS), Content-Security-Policy (CSP), and sub-resource integrity. Fast HTTPS handshakes preserve crawl efficiency while protecting sensitive user data.</p>\n</section>', '[{\"answer\": \"Google evaluates financial websites under the YMYL standard. High Experience, Expertise, Authoritativeness, and Trustworthiness (E-E-A-T) signals are required to rank for financial decision terms.\", \"question\": \"Why is E-E-A-T crucial for FinTech platforms?\"}]', NULL, 'asset/webranker-default-blog.jpg', 'FinTech SEO Strategy: Ranking High-Trust Financial Apps', 'A comprehensive guide to FinTech SEO: Google YMYL compliance, author credibility signals, PCI-DSS security badges, and transactional keyword ranking.', 'fintech SEO, banking platform SEO, YMYL financial services, financial software SEO', 'FinTech', '[\"FinTech\", \"E-E-A-T\", \"Financial Services\", \"Security\"]', 'WebRanker Research', 'Head of Financial Search Architecture', 'WR', '8 min read', 4, 1, 1, '2026-09-20 01:23:10', '2026-09-23 01:23:10', '2026-09-23 05:13:27'),
(18, 'Healthcare & MedTech SEO Strategy: Mastering Google E-E-A-T and HIPAA Compliance', 'healthcare-medtech-seo-eeat-hipaa-strategy', 'How digital health portals, EHR software, and telemedicine providers capture high-intent patient and hospital procurement searches.', '<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">01</span>\n    <h2 id=\"medical-eeat\">Medical E-E-A-T: Physician Editorial Oversight</h2>\n  </div>\n  <p>Google employs specialized algorithms to evaluate health claims. Clinical content must be written or reviewed by board-certified practitioners with visible license details and publication dates.</p>\n  <h3 id=\"medical-schema\">MedicalCondition & Physician Schema Markup</h3>\n  <p>Implement comprehensive schema markup specifying symptoms, differential diagnoses, and evidence-based treatments to trigger Google Knowledge Panel inclusion.</p>\n</section>\n\n<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">02</span>\n    <h2 id=\"hipaa-analytics\">HIPAA-Compliant Analytics and Conversion Tracking</h2>\n  </div>\n  <p>Never pass Protected Health Information (PHI) in URL queries or client-side marketing tags. Server-side tracking protects patient confidentiality while enabling attribution measurement.</p>\n</section>', '[{\"answer\": \"It is extremely difficult to rank for medical conditions without certified medical reviewers; Google algorithmically discounts unverified medical advice.\", \"question\": \"Can health clinics rank without physician reviews on their blogs?\"}]', NULL, 'asset/webranker-default-blog.jpg', 'Healthcare & MedTech SEO: Google E-E-A-T & HIPAA Guide', 'Learn proven Healthcare SEO strategies: physician review workflows, MedicalCondition schema markup, HIPAA-safe telemetry, and local clinic pack rankings.', 'healthcare SEO, medtech digital marketing, medical schema markup, HIPAA compliant SEO', 'Healthcare', '[\"Healthcare\", \"MedTech\", \"Medical SEO\", \"HIPAA\"]', 'WebRanker Clinical Digital', 'Medical Search Strategy Director', 'WR', '9 min read', 2, 1, 1, '2026-09-19 01:23:10', '2026-09-23 01:23:10', '2026-09-23 05:13:27'),
(19, 'Real Estate & PropTech Search Domination: Programmatic SEO for MLS Listings', 'real-estate-proptech-programmatic-seo-mls-listings', 'Generating thousands of high-converting city, neighborhood, and property type landing pages that rank above legacy real estate aggregator portals.', '<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">01</span>\n    <h2 id=\"neighborhood-hierarchy\">Building Hierarchical Neighborhood Hubs</h2>\n  </div>\n  <p>Real estate buyers search with hyper-local intent: \"Condos for sale in Downtown Austin near tech corridor\". Organizing your site taxonomy by State &rarr; City &rarr; District &rarr; Micro-Neighborhood allows you to capture long-tail search volume before buyers hit national aggregators.</p>\n  <h3 id=\"idx-speed\">Optimizing IDX & MLS Data Feeds for Crawlability</h3>\n  <p>Slow external MLS iframes destroy organic rankings. Ingest property data into your primary PostgreSQL or MySQL database and render listings natively using edge SSR.</p>\n</section>\n\n<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">02</span>\n    <h2 id=\"realestate-schema\">RealEstateListing Schema Markup</h2>\n  </div>\n  <p>Mark up price, square footage, bed/bath count, and geo-coordinates to surface interactive property carousels directly in Google search results.</p>\n</section>', '[{\"answer\": \"Instead of deleting sold listings, maintain the URL, display the sold price with nearby available listings, and retain the accumulated PageRank.\", \"question\": \"How do you keep expired real estate listings from hurting SEO?\"}]', NULL, 'asset/webranker-default-blog.jpg', 'Real Estate Programmatic SEO: Scaling MLS Rankings', 'Scale your real estate portal: programmatic neighborhood page generation, RealEstateListing schema, IDX speed optimization, and local map rankings.', 'real estate SEO, proptech programmatic SEO, MLS listing search, local real estate ranking', 'Real Estate', '[\"Real Estate\", \"PropTech\", \"Programmatic SEO\", \"Local Search\"]', 'WebRanker Growth Team', 'Enterprise SEO Specialist', 'WR', '6 min read', 4, 1, 0, '2026-09-18 01:23:10', '2026-09-23 01:23:10', '2026-09-23 05:13:27'),
(20, 'Logistics & Supply Chain Tech: High-Intent SEO for Freight & Warehouse Automation', 'logistics-supply-chain-tech-high-intent-seo', 'Capturing enterprise procurement managers searching for 3PL integrations, fleet telematics, and automated warehouse management systems (WMS).', '<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">01</span>\n    <h2 id=\"b2b-procurement\">Targeting the B2B Freight Procurement Journey</h2>\n  </div>\n  <p>Enterprise logistics buyers do not search casually; they query specific integration compatibility, API throughput limits, and cold-chain compliance. Creating detailed technical comparison matrixes wins enterprise RFP shortlists.</p>\n  <h3 id=\"software-application-schema\">SoftwareApplication & Service Schema</h3>\n  <p>Explicitly define supported transportation modes (FTL, LTL, Ocean, Air) within Service and SoftwareApplication schema types.</p>\n</section>', '[{\"answer\": \"Typically 3 to 9 months; capturing decision makers with technical whitepapers and ROI calculators speeds up contract closure.\", \"question\": \"What is the average sales cycle for logistics software leads from organic search?\"}]', NULL, 'asset/webranker-default-blog.jpg', 'Logistics & Supply Chain SEO: Enterprise B2B Growth', 'Target high-value freight and supply chain contracts with technical B2B SEO: commercial intent keyword mapping, case study schemas, and RFP lead generation.', 'logistics SEO, supply chain software marketing, 3PL digital strategy, warehouse automation SEO', 'Logistics', '[\"Logistics\", \"Supply Chain\", \"B2B SEO\", \"Freight Tech\"]', 'WebRanker Enterprise', 'Industrial Search Strategist', 'WR', '7 min read', 2, 1, 0, '2026-09-17 01:23:10', '2026-09-23 01:23:10', '2026-09-23 05:13:27'),
(21, 'Automotive & EV Tech Digital Strategy: Driving Organic Visibility for Connected Mobility', 'automotive-ev-digital-seo-strategy-connected-mobility', 'How automotive OEMs, EV charging networks, and aftermarket telemetry providers win high-value vehicle and fleet procurement search terms.', '<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">01</span>\n    <h2 id=\"ev-charging-search\">EV Station Locator SEO & Geo-Targeting</h2>\n  </div>\n  <p>With millions transitioning to electric vehicles, queries like \"High-speed DC fast charger near interstate\" require real-time status data, connector type schemas, and Google Maps Local Pack dominance.</p>\n</section>', '[{\"answer\": \"Yes, through LocalBusiness schema utilizing specialized amenities and charging station specifications.\", \"question\": \"Does Google support specific schema for electric vehicle chargers?\"}]', NULL, 'asset/webranker-default-blog.jpg', 'Automotive & EV SEO: Organic Strategy for Connected Mobility', 'Drive qualified automotive buyer traffic: Vehicle schema, EV charging station locator SEO, dealer network local packs, and fleet management search.', 'automotive SEO, EV charging SEO, vehicle schema markup, car dealer digital strategy', 'Automotive', '[\"Automotive\", \"Electric Vehicles\", \"Connected Car\", \"OEM SEO\"]', 'WebRanker Growth Team', 'Automotive Digital Director', 'WR', '7 min read', 4, 1, 0, '2026-09-16 01:23:10', '2026-09-23 01:23:10', '2026-09-23 05:18:05'),
(22, 'LegalTech & Corporate Law SEO: Capturing High-Value Enterprise Retainers', 'legaltech-corporate-law-seo-strategy-retainers', 'Converting commercial litigation, intellectual property, and M&A legal searches into multi-million dollar corporate client engagements.', '<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">01</span>\n    <h2 id=\"legal-authority\">Establishing Unshakable Legal Topical Authority</h2>\n  </div>\n  <p>Legal search keywords frequently exceed $250 CPC in Google Ads. Organic search allows firms to build authoritative content pillars addressing complex regulatory frameworks like GDPR, AI liability, and cross-border M&A.</p>\n</section>', '[{\"answer\": \"A single enterprise litigation client can generate hundreds of thousands in billings, making organic search positions extraordinarily valuable.\", \"question\": \"Why are legal keywords so competitive?\"}]', NULL, 'asset/webranker-default-blog.jpg', 'LegalTech & Law Firm SEO: Enterprise Retainer Strategy', 'Dominate high-CPC legal queries: LegalService schema, bar admission verification, practice area topical authority, and corporate client acquisition.', 'law firm SEO, legaltech marketing, corporate law search rankings, LegalService schema', 'Legal', '[\"Legal\", \"LegalTech\", \"Law Firm SEO\", \"Corporate Law\"]', 'WebRanker Legal Digital', 'Legal Practice Growth Advisor', 'WR', '8 min read', 3, 1, 0, '2026-09-15 01:23:10', '2026-09-23 01:23:10', '2026-09-23 05:19:53'),
(23, 'InsurTech Search Optimization: How Underwriting & Policy Portals Rank in Competitive SERPs', 'insurtech-search-optimization-policy-portals', 'From embedded cyber insurance to commercial fleet coverage: capturing quote requests with frictionless landing pages and transparent policy schemas.', '<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">01</span>\n    <h2 id=\"instant-quotes\">Frictionless Quote Funnels as Ranking Dwell Signals</h2>\n  </div>\n  <p>When users find an insurance portal that provides transparent estimated premiums without requiring 15-page forms, bounce rates plummet. Google detects positive user engagement and rewards the domain with higher ranking velocity.</p>\n</section>', '[{\"answer\": \"Focus on specialized emerging niches (e.g. cyber risk, crypto custody, gig-economy workers) where legacy carriers lack targeted content and user experience.\", \"question\": \"How can new InsurTech startups compete against century-old carriers?\"}]', NULL, 'asset/webranker-default-blog.jpg', 'InsurTech SEO Strategy: Ranking Policy & Quote Portals', 'Outrank traditional insurance carriers: fast quote flow architecture, InsuranceAgency schema, state licensing trust signals, and high-intent policy keywords.', 'insurtech SEO, insurance quote search, commercial insurance rankings, insurance agency schema', 'Insurance', '[\"Insurance\", \"InsurTech\", \"Underwriting\", \"Digital Claims\"]', 'WebRanker Research', 'Financial Search Director', 'WR', '7 min read', 2, 1, 0, '2026-09-14 01:23:10', '2026-09-23 01:23:10', '2026-09-23 05:13:27'),
(24, 'EdTech Organic Growth Engine: Student Acquisition & Course Catalog SEO at Scale', 'edtech-organic-growth-student-acquisition-catalog-seo', 'Scaling enrollment numbers for universities, bootcamps, and SaaS LMS platforms with Course schema, syllabus hubs, and student outcome proof.', '<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">01</span>\n    <h2 id=\"course-schema\">Course Schema for Google Course Carousel Search</h2>\n  </div>\n  <p>Google offers rich course search carousels featuring course duration, pricing, skill level, and certificate outcomes. Valid Course schema is required to appear in these prime SERP placements.</p>\n</section>', '[{\"answer\": \"Yes, Course schema supports both free open-access modules and certified paid university credentials.\", \"question\": \"Does Course schema work for free and paid tutorials?\"}]', NULL, 'asset/webranker-default-blog.jpg', 'EdTech SEO: Scaling Course Catalogs & Student Enrollment', 'Drive qualified student applications: Course schema implementation, programmatic degree catalog hierarchies, and accreditation trust markers.', 'edtech SEO, course schema markup, university student acquisition, online course rankings', 'Education', '[\"Education\", \"EdTech\", \"Course SEO\", \"E-learning\"]', 'WebRanker Growth Team', 'EdTech SEO Architect', 'WR', '7 min read', 3, 1, 0, '2026-09-13 01:23:10', '2026-09-23 01:23:10', '2026-09-23 05:13:27'),
(25, 'Travel & Hospitality Booking Engine SEO: Core Web Vitals, Schema & International Direct Bookings', 'travel-hospitality-booking-engine-seo-direct-bookings', 'Diverting high-margin reservations away from OTAs like Expedia and Booking.com with sub-second booking engines and Google Hotel Center integration.', '<section class=\"blog-detail-section\">\n  <div class=\"blog-detail-section-head\">\n    <span class=\"blog-detail-section-num\">01</span>\n    <h2 id=\"ota-independence\">Winning Direct Reservations Over High-Fee OTAs</h2>\n  </div>\n  <p>Online Travel Agencies take 15% to 25% commissions on hotel bookings. Direct organic search rankings with LodgingBusiness schema and verified Google Business Profiles allow independent boutique hotels and luxury resorts to capture direct reservations with zero commission fees.</p>\n  <h3 id=\"hreflang\">Multi-Language & Currency Localization (hreflang)</h3>\n  <p>International travelers search in their native tongue. Flawless hreflang tag implementations prevent duplicate translation penalties and match currency checkout flows seamlessly.</p>\n</section>', '[{\"answer\": \"Yes, for brand-specific searches, neighborhood experiential guides, and local map pack inquiries, properly optimized direct sites regularly outrank aggregators.\", \"question\": \"Can independent hotels outrank Booking.com on Google?\"}]', NULL, 'asset/webranker-default-blog.jpg', 'Travel & Hospitality SEO: Winning Direct Bookings', 'Maximize direct hospitality bookings: LodgingBusiness schema, hreflang multi-currency setup, Core Web Vitals optimization, and Google Hotel Ads synergy.', 'hospitality SEO, hotel booking search engine, direct reservation SEO, LodgingBusiness schema', 'Travel & Hospitality', '[\"Travel & Hospitality\", \"Direct Bookings\", \"Hotel SEO\", \"Internationalization\"]', 'WebRanker Travel Labs', 'Hospitality Search Strategist', 'WR', '8 min read', 3, 1, 0, '2026-09-12 01:23:10', '2026-09-23 01:23:10', '2026-09-23 05:13:27');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'General',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'How does WebRanker achieve guaranteed sub-second load times and 99+ Core Web Vitals?', 'We utilize an advanced performance stack comprising server-side rendering (SSR), edge function caching, automated AVIF/WebP image pipelines, tree-shaken critical CSS, and zero-blocking JavaScript. Every asset is optimized to ensure Largest Contentful Paint (LCP) remains under 0.8s, Interaction to Next Paint (INP) under 50ms, and Cumulative Layout Shift (CLS) at exactly 0.00.', 'Performance & Engineering', 1, 1, '2026-09-21 03:59:51', '2026-09-21 03:59:51'),
(2, 'What is WebRanker’s approach to topical authority and #1 Google rankings?', 'Rather than chasing isolated keywords, we build comprehensive semantic entity graphs. We map out full topical clusters, engineer deep internal linking networks, apply schema.org structured microdata, and resolve technical crawl bottlenecks. This signals undeniable topical authority to Google’s Helpful Content and RankBrain algorithms.', 'SEO & Ranking', 2, 1, '2026-09-21 03:59:51', '2026-09-21 03:59:51'),
(3, 'How quickly will we see measurable organic growth after launching with WebRanker?', 'While organic search is an ongoing compounding asset, our technical optimizations yield immediate crawl rate spikes within 14 days. Most enterprise clients experience a 40% to 120% surge in impressions within 60 days, followed by significant top-3 rank captures and inbound lead volume scaling through months 3 to 6.', 'Growth & Timeline', 3, 1, '2026-09-21 03:59:51', '2026-09-21 03:59:51'),
(4, 'Do you build custom mobile apps or hybrid cross-platform solutions?', 'We engineer both. For maximum performance and budget efficiency, we specialize in modern Flutter 3 and React Native architectures that deliver 60fps native performance on both iOS and Android from a unified codebase. We also build pure Swift and Kotlin native modules when deep hardware or sensor hooks are mandatory.', 'App Development', 4, 1, '2026-09-21 03:59:51', '2026-09-21 03:59:51'),
(5, 'How does the free 48-Hour Technical & SEO Audit work?', 'When you submit your domain via our inquiry drawer, our senior architects run a comprehensive diagnostic covering 85+ ranking factors: Core Web Vitals telemetry, server TTFB, crawl budget leaks, schema coverage, semantic gap analysis, and competitor backlink profiles. You receive an actionable, executive-ready roadmap within 48 hours.', 'Audit & Onboarding', 5, 1, '2026-09-21 03:59:51', '2026-09-21 03:59:51');

-- --------------------------------------------------------

--
-- Table structure for table `industry_domains`
--

DROP TABLE IF EXISTS `industry_domains`;
CREATE TABLE IF NOT EXISTS `industry_domains` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highlight_stat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stat_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `hero_tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detailed_content` longtext COLLATE utf8mb4_unicode_ci,
  `challenges` json DEFAULT NULL,
  `solutions` json DEFAULT NULL,
  `technologies` json DEFAULT NULL,
  `kpis` json DEFAULT NULL,
  `faqs` json DEFAULT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `focus_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_schema` text COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `industry_domains_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `industry_domains`
--

INSERT INTO `industry_domains` (`id`, `name`, `slug`, `icon`, `category_group`, `highlight_stat`, `stat_label`, `description`, `hero_tagline`, `detailed_content`, `challenges`, `solutions`, `technologies`, `kpis`, `faqs`, `featured_image`, `meta_title`, `meta_description`, `focus_keywords`, `custom_schema`, `tags`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'E-Commerce & Retail', 'ecommerce-retail', 'fa-cart-shopping', 'Finance & Commerce', '+310%', 'Revenue Growth', 'High-load catalog architecture with headless checkout.', NULL, NULL, '[{\"title\": \"Sluggish Time-to-Interactive & Fragile Monoliths\", \"description\": \"Legacy CMS templates choke under traffic spikes, causing 8-second cart drops and poor Google rank.\"}, {\"title\": \"Compliance Bottlenecks & Security Debt\", \"description\": \"Unencrypted data at rest and poorly structured audit trails risk hefty regulatory fines.\"}]', '[{\"title\": \"Decoupled Edge SSR & Global CDN Microservices\", \"description\": \"Sub-400ms rendering on globally distributed edge networks with automated caching.\"}, {\"title\": \"Zero-Trust Architecture & Automated Auditing\", \"description\": \"End-to-end tokenization, OWASP Top 10 hardening, and automated CI/CD security scanning.\"}]', '[\"Next.js 15\", \"Laravel 11\", \"AWS Edge\", \"Redis\", \"GraphQL\"]', NULL, '[{\"answer\": \"We combine sub-second edge architectures, automated Schema.org entity indexing, and bulletproof security to drive both higher conversion rates and top organic Google rankings.\", \"question\": \"How does WebRanker\'s engineering approach accelerate E-Commerce & Retail growth?\"}, {\"answer\": \"Yes, our team specializes in building resilient API bridges, background webhook queues, and zero-downtime data synchronization pipelines.\", \"question\": \"Do you handle integrations with existing internal legacy software?\"}]', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2026-09-21 03:59:51', '2026-09-23 06:12:56'),
(2, 'Healthcare & MedTech', 'healthcare-medtech', 'fa-heart-pulse', 'Health & Life Sciences', 'HIPAA', 'Compliant Telehealth', 'Secure patient portals, HL7/FHIR integration and telemedicine.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(3, 'Fintech & Banking', 'fintech-banking', 'fa-building-columns', 'Finance & Commerce', '99.999%', 'Transaction Uptime', 'PCI-DSS certified payment gateways and algorithmic risk engines.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(4, 'Real Estate & PropTech', 'real-estate-proptech', 'fa-city', 'Consumer, Media & Lifestyle', '4.8x', 'Lead Volume', 'Interactive virtual tours, MLS/IDX feeds and automated valuations.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(5, 'EdTech & Learning', 'edtech-learning', 'fa-graduation-cap', 'Consumer, Media & Lifestyle', '500K+', 'Active Learners', 'Gamified learning platforms, SCORM compliant LMS and live classrooms.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(6, 'Travel & Hospitality', 'travel-hospitality', 'fa-plane-departure', 'Consumer, Media & Lifestyle', '2.4s', 'Instant Booking', 'GDS engine integration, dynamic pricing and itinerary generators.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(7, 'Automotive & Mobility', 'automotive-mobility', 'fa-car-side', 'Mobility & Logistics', '35M+', 'Telematics Pings', 'Connected vehicle telematics, EV charging grids and dealership portals.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(8, 'Logistics & Supply Chain', 'logistics-supply-chain', 'fa-truck-fast', 'Mobility & Logistics', '-40%', 'Route Latency', 'Real-time GPS fleet tracking, automated warehouse dispatch and IoT.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(9, 'SaaS & Enterprise B2B', 'saas-enterprise', 'fa-server', 'Enterprise, SaaS & Tech', '10x', 'Tenant Scaling', 'Multi-tenant cloud architecture with usage-based billing engines.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:41'),
(10, 'Media & Entertainment', 'media-entertainment', 'fa-film', 'Consumer, Media & Lifestyle', '4K 60fps', 'Adaptive Streaming', 'Ultra-low latency HLS video streaming, CDN edge distribution.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(11, 'Legal & Compliance', 'legal-compliance', 'fa-scale-balanced', 'Legal, Public & Professional', '100%', 'Audit Trail', 'Automated legal contract discovery, redlining and e-signatures.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(12, 'Manufacturing & Industry 4.0', 'manufacturing-industry', 'fa-industry', 'Enterprise, SaaS & Tech', '99.8%', 'Predictive Yield', 'Smart factory SCADA dashboards, IoT sensor telemetries.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:41'),
(13, 'Energy & CleanTech', 'energy-cleantech', 'fa-bolt', 'Enterprise, SaaS & Tech', '-28%', 'Grid Peak Waste', 'Renewable energy trading algorithms and smart meter management.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:41'),
(14, 'Insurance & InsurTech', 'insurance-insurtech', 'fa-shield-halved', 'Finance & Commerce', '3 Min', 'Instant Claim', 'AI-driven computer vision claim estimation and policy underwriting.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(15, 'Gaming & Esports', 'gaming-esports', 'fa-gamepad', 'Consumer, Media & Lifestyle', '<15ms', 'Edge Latency', 'Real-time multiplayer leaderboards and low-latency matchmaking.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(16, 'Non-Profit & NGOs', 'non-profit-ngos', 'fa-hand-holding-heart', 'Legal, Public & Professional', '+180%', 'Donation Conv.', 'Global recurring donor portals with transparent impact dashboards.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(17, 'Aerospace & Defense', 'aerospace-defense', 'fa-shuttle-space', 'Mobility & Logistics', 'Mil-Spec', 'Hardened Security', 'Encrypted flight data management and supply part validation.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(18, 'Agriculture & AgTech', 'agriculture-agtech', 'fa-wheat-awn', 'Consumer, Media & Lifestyle', '+32%', 'Crop Yield', 'Satellite NDVI imagery processing and automated drone dispatch.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 18, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(19, 'Fashion & Luxury', 'fashion-luxury', 'fa-gem', 'Consumer, Media & Lifestyle', '3D AR', 'Virtual Try-On', 'Interactive 3D WebGL product customizers and virtual runway previews.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(20, 'Food & Quick Service (QSR)', 'food-qsr', 'fa-utensils', 'Consumer, Media & Lifestyle', '4.2s', 'Kitchen Dispatch', 'POS integrations, geolocation delivery routing and loyalty wallets.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(21, 'Human Resources & HRTech', 'hr-hrtech', 'fa-users', 'Enterprise, SaaS & Tech', '65%', 'Faster Hiring', 'AI candidate screening, automated payroll and global compliance.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:41'),
(22, 'Biotechnology & Pharma', 'biotech-pharma', 'fa-dna', 'Health & Life Sciences', 'FDA Part 11', 'Clinical Compliance', 'Clinical trial data capture and molecular modeling visualization.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 22, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56'),
(23, 'Telecom & 5G Infrastructure', 'telecom-5g', 'fa-tower-cell', 'Enterprise, SaaS & Tech', '10Gbps', 'Network Slice', 'Billing OSS/BSS modernization and subscriber self-service apps.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:41'),
(24, 'Architecture & Engineering', 'architecture-engineering', 'fa-compass-drafting', 'Enterprise, SaaS & Tech', 'BIM 360', 'Integrated Sync', 'Cloud CAD model collaboration and structural lifecycle analytics.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 24, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:41'),
(25, 'Government & Public Sector', 'government-public-sector', 'fa-landmark', 'Legal, Public & Professional', 'GovCloud', 'Certified Access', 'Accessible citizen services, e-governance workflows and security.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 1, '2026-09-21 03:59:51', '2026-09-23 05:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_interest` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `source_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `link_requests`
--

DROP TABLE IF EXISTS `link_requests`;
CREATE TABLE IF NOT EXISTS `link_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_page_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requested_anchor_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_link_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'link_insertion',
  `budget_offer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proposed_context` text COLLATE utf8mb4_unicode_ci,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `link_requests_status_index` (`status`),
  KEY `link_requests_client_email_index` (`client_email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_21_092818_create_site_settings_table', 2),
(5, '2026_09_21_092819_create_services_table', 2),
(6, '2026_09_21_092820_create_industry_domains_table', 2),
(7, '2026_09_21_092821_create_testimonials_table', 2),
(8, '2026_09_21_092822_create_faqs_table', 2),
(9, '2026_09_21_092823_create_blog_posts_table', 2),
(10, '2026_09_21_092824_create_inquiries_table', 2),
(11, '2026_09_22_190000_add_seo_fields_to_services_table', 3),
(12, '2026_09_22_191000_add_advanced_schemas_to_services_table', 4),
(13, '2026_09_22_135039_add_seo_and_author_fields_to_blog_posts_table', 5),
(14, '2026_09_23_054815_add_categories_to_services_table', 6),
(15, '2026_09_23_060000_create_link_requests_table', 7),
(16, '2026_09_23_084025_add_country_and_soft_deletes_to_link_requests_table', 8),
(17, '2026_09_23_170000_add_detail_fields_to_industry_domains_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories` json DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `focus_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detailed_content` longtext COLLATE utf8mb4_unicode_ci,
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` json DEFAULT NULL,
  `faqs` json DEFAULT NULL,
  `local_schema` json DEFAULT NULL,
  `business_schema` json DEFAULT NULL,
  `custom_schema` longtext COLLATE utf8mb4_unicode_ci,
  `process_steps` json DEFAULT NULL,
  `technologies` json DEFAULT NULL,
  `kpi_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpi_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `slug`, `category`, `categories`, `icon`, `tagline`, `short_description`, `meta_title`, `meta_description`, `focus_keywords`, `og_image`, `detailed_content`, `badge`, `features`, `faqs`, `local_schema`, `business_schema`, `custom_schema`, `process_steps`, `technologies`, `kpi_label`, `kpi_value`, `sort_order`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Web Development Services', 'web-development', 'Engineering & Architecture', '[\"Engineering & Architecture\"]', 'fa-solid fa-code', 'Custom PHP & Laravel, Next.js, MERN, Python, WordPress & Shopify Built for Humans & Ranked by Search Engines', 'Stop losing leads to sluggish load times and fragile templates. We design, architect, and deploy high-performing full-stack web applications and headless portals using PHP, Laravel, Next.js, React, MERN, Python, WordPress, and Shopify—engineered for real human conversions, sub-second speed, and Google #1 rank dominance.', 'Full-Stack Web Development Services | Laravel, Next.js, MERN & Python | WebRanker', 'Struggling with slow, bloated websites? WebRanker engineers custom full-stack web applications in PHP/Laravel, Next.js, MERN, Python & Headless Shopify that load in under 0.4s and rank #1.', 'Laravel web development, Next.js React app, hire MERN developer, Python FastAPI, headless WordPress, Shopify Plus, Core Web Vitals, custom web apps', 'asset/services/web-development.jpg', '<div class=\"space-y-8\">\n  <div class=\"p-6 sm:p-8 rounded-3xl bg-[#faf7f2] border border-[#e6dfd3] space-y-4\">\n    <h3 class=\"text-2xl font-black text-[#161514] tracking-tight\">The Reality of Modern Web Development: Why Most Websites Silently Fail</h3>\n    <p class=\"text-base text-[#4b5563] leading-relaxed\">\n      If you have ever hired an agency only to receive a sluggish, cookie-cutter website stitched together with 45 third-party plugins—you are not alone. Most websites on the internet today look acceptable on the surface, but underneath, they are an engineering nightmare: bloated JavaScript bundles, unindexed dynamic routes, poor mobile responsiveness, and fragile database queries that freeze the moment traffic surges.\n    </p>\n    <p class=\"text-base text-[#4b5563] leading-relaxed\">\n      At <strong>WebRanker</strong>, we take a fundamentally different, human-first engineering stance. We treat your web application as a mission-critical revenue engine. Whether you are building an enterprise B2B SaaS platform, an interactive client portal, or a high-converting e-commerce store, our software architects handcraft clean, modular code that loads in under 400 milliseconds, delights real human visitors, and dominates Google search results.\n    </p>\n  </div>\n\n  <div class=\"space-y-4\">\n    <h3 class=\"text-2xl font-black text-[#161514] tracking-tight\">Our Core Multi-Stack Engineering Capabilities</h3>\n    <p class=\"text-base text-[#4b5563] leading-relaxed\">\n      We believe in <em>pragmatic technology selection</em>. We don\'t force a single framework onto every problem. Instead, our senior architects match the exact right technology stack to your specific business model, team skillset, and scaling targets.\n    </p>\n\n    <div class=\"grid grid-cols-1 md:grid-cols-2 gap-5 pt-2\">\n      <!-- PHP & Laravel -->\n      <div class=\"p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3\">\n        <div class=\"flex items-center gap-3\">\n          <div class=\"w-10 h-10 rounded-xl bg-red-50 text-[#ff3b30] flex items-center justify-center text-lg font-bold\">\n            <i class=\"fab fa-php\"></i>\n          </div>\n          <div>\n            <h4 class=\"font-extrabold text-[#161514] text-base\">PHP 8.3 &amp; Laravel 11 Ecosystem</h4>\n            <span class=\"text-xs text-[#ff3b30] font-bold\">Enterprise SaaS &amp; Complex Business Logic</span>\n          </div>\n        </div>\n        <p class=\"text-sm text-[#6e675f] leading-relaxed\">\n          Laravel is the gold standard for robust backends. We build enterprise-grade MVC web applications, high-concurrency background job queues with Redis, multi-tenant SaaS platforms, and secure REST/GraphQL APIs with clean architecture that your internal developers will love maintaining.\n        </p>\n        <ul class=\"text-xs text-[#4b5563] space-y-1.5 pt-1\">\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Eloquent ORM &amp; Database Migration Architecture</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Laravel Octane &amp; Redis Sub-50ms API Latency</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Built-in CSRF, XSS, and SQL Injection Security</li>\n        </ul>\n      </div>\n\n      <!-- Next.js & React -->\n      <div class=\"p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3\">\n        <div class=\"flex items-center gap-3\">\n          <div class=\"w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-lg font-bold\">\n            <i class=\"fab fa-react\"></i>\n          </div>\n          <div>\n            <h4 class=\"font-extrabold text-[#161514] text-base\">Next.js 15 &amp; React 19 Frontend</h4>\n            <span class=\"text-xs text-blue-600 font-bold\">Edge SSR, SSG &amp; 100/100 Core Web Vitals</span>\n          </div>\n        </div>\n        <p class=\"text-sm text-[#6e675f] leading-relaxed\">\n          Google prioritizes instantaneous rendering and zero layout shift. Using Next.js App Router, React Server Components, and Edge middleware, we build web experiences that feel as fluid and snappy as a desktop application while feeding search engines pre-rendered semantic HTML.\n        </p>\n        <ul class=\"text-xs text-[#4b5563] space-y-1.5 pt-1\">\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Hybrid Server-Side Rendering (SSR) &amp; Static Generation (SSG)</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Automated Image &amp; Font Optimization (Zero CLS)</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Edge CDN Caching &amp; Global Sub-Second Delivery</li>\n        </ul>\n      </div>\n\n      <!-- MERN Stack -->\n      <div class=\"p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3\">\n        <div class=\"flex items-center gap-3\">\n          <div class=\"w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold\">\n            <i class=\"fab fa-node-js\"></i>\n          </div>\n          <div>\n            <h4 class=\"font-extrabold text-[#161514] text-base\">MERN Stack (MongoDB, Express, React, Node)</h4>\n            <span class=\"text-xs text-emerald-600 font-bold\">High-Concurrency Event-Driven Web Platforms</span>\n          </div>\n        </div>\n        <p class=\"text-sm text-[#6e675f] leading-relaxed\">\n          When real-time collaboration, live notifications, WebSockets, or high-throughput JSON processing are required, our MERN team delivers. A single JavaScript/TypeScript codebase from client to database reduces context-switching and accelerates feature delivery.\n        </p>\n        <ul class=\"text-xs text-[#4b5563] space-y-1.5 pt-1\">\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Flexible MongoDB Schema &amp; Aggregation Pipelines</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Lightweight, Scalable Express.js Microservices</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Real-Time WebSocket Dashboards &amp; Notifications</li>\n        </ul>\n      </div>\n\n      <!-- Python, FastAPI & Django -->\n      <div class=\"p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3\">\n        <div class=\"flex items-center gap-3\">\n          <div class=\"w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold\">\n            <i class=\"fab fa-python\"></i>\n          </div>\n          <div>\n            <h4 class=\"font-extrabold text-[#161514] text-base\">Python, FastAPI &amp; Django</h4>\n            <span class=\"text-xs text-indigo-600 font-bold\">Data-Intensive Backends &amp; AI Integration</span>\n          </div>\n        </div>\n        <p class=\"text-sm text-[#6e675f] leading-relaxed\">\n          Need machine learning inference, automated data scraping, complex financial modeling, or lightning-fast asynchronous REST APIs? We engineer high-performance asynchronous backends using FastAPI and robust enterprise systems with Django ORM.\n        </p>\n        <ul class=\"text-xs text-[#4b5563] space-y-1.5 pt-1\">\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Asynchronous AsyncIO Non-Blocking I/O Execution</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Automatic OpenAPI &amp; Swagger Schema Documentation</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Seamless AI, LLM &amp; Vector Database Integration</li>\n        </ul>\n      </div>\n\n      <!-- WordPress & Shopify -->\n      <div class=\"p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3\">\n        <div class=\"flex items-center gap-3\">\n          <div class=\"w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold\">\n            <i class=\"fab fa-wordpress\"></i>\n          </div>\n          <div>\n            <h4 class=\"font-extrabold text-[#161514] text-base\">Custom WordPress &amp; Shopify Plus</h4>\n            <span class=\"text-xs text-amber-600 font-bold\">Zero-Bloat CMS &amp; High-Converting E-Commerce</span>\n          </div>\n        </div>\n        <p class=\"text-sm text-[#6e675f] leading-relaxed\">\n          Say goodbye to sluggish 8-second page loads. We engineer custom, ultra-lean Gutenberg block themes, tailored Shopify Plus Liquid storefronts, and headless decoupled setups that give non-technical editors full publishing freedom without sacrificing Google PageSpeed scores.\n        </p>\n        <ul class=\"text-xs text-[#4b5563] space-y-1.5 pt-1\">\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Bespoke Themes Built with Zero Commercial Bloatware</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Custom Shopify Apps &amp; Checkout Extensibility</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Sub-Second Catalog Navigation &amp; Faceted Search</li>\n        </ul>\n      </div>\n\n      <!-- Headless Architecture -->\n      <div class=\"p-6 rounded-2xl bg-white border border-[#e6dfd3] shadow-sm hover:shadow-md transition-shadow space-y-3\">\n        <div class=\"flex items-center gap-3\">\n          <div class=\"w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg font-bold\">\n            <i class=\"fas fa-cubes\"></i>\n          </div>\n          <div>\n            <h4 class=\"font-extrabold text-[#161514] text-base\">Headless CMS &amp; Decoupled Architecture</h4>\n            <span class=\"text-xs text-purple-600 font-bold\">GraphQL, Strapi, Sanity &amp; Next.js</span>\n          </div>\n        </div>\n        <p class=\"text-sm text-[#6e675f] leading-relaxed\">\n          Decoupling your editorial backend from your customer-facing frontend unlocks infinite scalability. Your marketing team manages rich content in Sanity, Strapi, or WordPress, while Next.js compiles blazing-fast static edge pages that withstand millions of concurrent hits.\n        </p>\n        <ul class=\"text-xs text-[#4b5563] space-y-1.5 pt-1\">\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Single Content Hub Powering Web, Mobile &amp; Kiosks</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Immunity from CMS Database Vulnerabilities</li>\n          <li class=\"flex items-center gap-2\"><i class=\"fas fa-check text-emerald-500\"></i> Incremental Static Regeneration (ISR) Updates in Real Time</li>\n        </ul>\n      </div>\n    </div>\n  </div>\n\n  <div class=\"space-y-4\">\n    <h3 class=\"text-2xl font-black text-[#161514] tracking-tight\">Stack Comparison: Choosing the Perfect Technology for Your Business</h3>\n    <p class=\"text-sm text-[#6e675f]\">\n      Unsure which technology stack fits your roadmap? Here is our honest, engineering-grounded comparison:\n    </p>\n\n    <div class=\"overflow-x-auto rounded-2xl border border-[#e6dfd3] bg-white\">\n      <table class=\"w-full text-left border-collapse text-xs sm:text-sm\">\n        <thead>\n          <tr class=\"bg-[#faf7f2] border-b border-[#e6dfd3] text-[#161514] font-black\">\n            <th class=\"p-3.5 sm:p-4\">Stack / Technology</th>\n            <th class=\"p-3.5 sm:p-4\">Best Suited For</th>\n            <th class=\"p-3.5 sm:p-4\">SEO &amp; Indexation</th>\n            <th class=\"p-3.5 sm:p-4\">Time-to-Market</th>\n          </tr>\n        </thead>\n        <tbody class=\"divide-y divide-[#e6dfd3] text-[#4b5563]\">\n          <tr>\n            <td class=\"p-3.5 sm:p-4 font-bold text-[#161514]\">Laravel 11 + Livewire / Inertia</td>\n            <td class=\"p-3.5 sm:p-4\">Enterprise SaaS, CRM portals, financial backends, booking platforms</td>\n            <td class=\"p-3.5 sm:p-4 text-emerald-600 font-bold\"><i class=\"fas fa-circle-check\"></i> Exceptional (Native SSR)</td>\n            <td class=\"p-3.5 sm:p-4\">Fast (Batteries included)</td>\n          </tr>\n          <tr>\n            <td class=\"p-3.5 sm:p-4 font-bold text-[#161514]\">Next.js 15 + React 19</td>\n            <td class=\"p-3.5 sm:p-4\">High-traffic content portals, e-commerce frontends, marketing platforms</td>\n            <td class=\"p-3.5 sm:p-4 text-emerald-600 font-bold\"><i class=\"fas fa-circle-check\"></i> 100/100 Lighthouse Benchmark</td>\n            <td class=\"p-3.5 sm:p-4\">Moderate to Fast</td>\n          </tr>\n          <tr>\n            <td class=\"p-3.5 sm:p-4 font-bold text-[#161514]\">MERN (Node + Express + React)</td>\n            <td class=\"p-3.5 sm:p-4\">Real-time collaboration tools, streaming feeds, interactive dashboards</td>\n            <td class=\"p-3.5 sm:p-4 text-blue-600 font-bold\">Good (with SSR / Vite SSG)</td>\n            <td class=\"p-3.5 sm:p-4\">Fast (Unified JS ecosystem)</td>\n          </tr>\n          <tr>\n            <td class=\"p-3.5 sm:p-4 font-bold text-[#161514]\">Python (FastAPI / Django)</td>\n            <td class=\"p-3.5 sm:p-4\">Data science web tools, AI microservices, algorithmic backend pipelines</td>\n            <td class=\"p-3.5 sm:p-4 text-slate-700 font-semibold\">Backend API focused</td>\n            <td class=\"p-3.5 sm:p-4\">Fast to Moderate</td>\n          </tr>\n          <tr>\n            <td class=\"p-3.5 sm:p-4 font-bold text-[#161514]\">Headless Shopify / WordPress</td>\n            <td class=\"p-3.5 sm:p-4\">Omnichannel retail brands and high-velocity publishing houses</td>\n            <td class=\"p-3.5 sm:p-4 text-emerald-600 font-bold\"><i class=\"fas fa-circle-check\"></i> Maximum Organic Rank</td>\n            <td class=\"p-3.5 sm:p-4\">Moderate</td>\n          </tr>\n        </tbody>\n      </table>\n    </div>\n  </div>\n\n  <div class=\"p-6 sm:p-8 rounded-3xl bg-[#161514] text-white space-y-4\">\n    <h3 class=\"text-2xl font-black text-white tracking-tight\">The WebRanker Code Quality Pledge</h3>\n    <div class=\"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-2\">\n      <div class=\"space-y-1.5\">\n        <div class=\"text-[#ff3b30] font-black text-xl\">01. 100% Code Ownership</div>\n        <p class=\"text-xs text-slate-400\">You own every single commit, repository, and asset. Zero vendor lock-in, zero hostage licensing.</p>\n      </div>\n      <div class=\"space-y-1.5\">\n        <div class=\"text-[#ff3b30] font-black text-xl\">02. Sub-400ms TTFB</div>\n        <p class=\"text-xs text-slate-400\">Server responses engineered for sub-second paint times on real mobile networks.</p>\n      </div>\n      <div class=\"space-y-1.5\">\n        <div class=\"text-[#ff3b30] font-black text-xl\">03. Automated Schema &amp; SEO</div>\n        <p class=\"text-xs text-slate-400\">Structured JSON-LD schema, semantic tags, and canonical graph routing built into every template.</p>\n      </div>\n      <div class=\"space-y-1.5\">\n        <div class=\"text-[#ff3b30] font-black text-xl\">04. Battle-Tested Security</div>\n        <p class=\"text-xs text-slate-400\">OWASP Top 10 compliance, rate-limiting, strict CORS policies, and automated security scans.</p>\n      </div>\n    </div>\n  </div>\n</div>', 'Full-Stack & Headless', '[\"PHP 8.3 & Laravel 11 Enterprise Application Architecture\", \"Next.js 15 App Router, React 19 & Edge Server-Side Rendering (SSR/SSG)\", \"MERN Stack (MongoDB, Express.js, React, Node.js) Full-Stack Engineering\", \"Python, FastAPI & Django High-Performance Asynchronous APIs\", \"Custom WordPress & Shopify Plus E-Commerce (Zero Bloatware)\", \"Headless CMS, Decoupled Microservices & GraphQL Integrations\", \"Sub-400ms Edge Delivery & 100/100 Core Web Vitals Guarantee\", \"Automated CI/CD Pipelines, Docker Containers & OWASP Top 10 Security\"]', '[{\"answer\": \"There is no one-size-fits-all answer. If you are building a data-rich SaaS or internal tool, Laravel 11 offers the fastest development cycle with bulletproof security. If your primary goal is consumer-facing SEO, extreme speed, and rich interactivity, Next.js 15 / React is unmatched. If you need real-time WebSockets or lightweight Node microservices, MERN is great. For e-commerce, custom Shopify or headless commerce ensures maximum revenue conversion. During our free discovery session, we review your exact roadmap and advise on the most cost-effective, future-proof stack.\", \"question\": \"Which web development stack is genuinely best for my business?\"}, {\"answer\": \"Search engines favor fast, predictable, and semantically transparent websites. We optimize every layer: 1) Server-Side Rendering (SSR) ensures Googlebot crawls fully rendered HTML instead of blank JavaScript shells; 2) Sub-second TTFB and zero layout shift (CLS) directly pass Google Core Web Vitals; 3) Automated Schema.org JSON-LD structured data signals your exact brand entities and offerings; and 4) Clean URL routing prevents crawl budget waste.\", \"question\": \"How does your web development directly boost our Google search rankings?\"}, {\"answer\": \"Absolutely. SEO preservation is a core discipline of our engineering team. We conduct a full pre-migration URL crawl audit, map every legacy URL to 301 redirects, preserve canonical tags, retain existing metadata structures, and test the staging environment thoroughly before DNS switchover. We have executed dozens of zero-loss migrations from legacy WordPress, Drupal, Magento, and custom PHP apps.\", \"question\": \"Can you migrate our existing slow website without losing our current SEO rankings?\"}, {\"answer\": \"Yes, 100%. Upon project milestone completion, all Git repository rights, documentation, architecture diagrams, and custom code belong exclusively to your company. We never hold your code hostage or charge proprietary ongoing software licenses.\", \"question\": \"Do we own the full source code and intellectual property once built?\"}, {\"answer\": \"Yes. We build custom API bridges and webhooks for Stripe, PayPal, Razorpay, HubSpot, Salesforce, Zoho, SAP, QuickBooks, and proprietary internal databases. Our API endpoints are built with strict rate limiting, cryptographic validation, and error logging.\", \"question\": \"Can you integrate our web application with existing CRMs, ERPs, or payment gateways?\"}, {\"answer\": \"Every build includes a 30-day post-launch warranty where any defects or edge-case bugs are resolved at zero cost. After launch, we offer flexible SLA maintenance retainers that include 24/7 uptime monitoring, server security patching, dependency upgrades, monthly Core Web Vitals audits, and dedicated engineering sprint hours for new feature rollouts.\", \"question\": \"What does post-launch maintenance, SLAs, and technical support look like?\"}]', NULL, NULL, '{\r\n    \"@context\": \"https://schema.org\",\r\n    \"@type\": \"SoftwareApplication\",\r\n    \"name\": \"WebRanker Enterprise Full-Stack Web Development Engine\",\r\n    \"operatingSystem\": \"Cloud, All Modern Browsers\",\r\n    \"applicationCategory\": \"WebApplication\",\r\n    \"description\": \"Custom full-stack web application development in PHP, Laravel, Next.js, React, MERN, Python, FastAPI, Django, WordPress, Shopify, and Headless architectures.\",\r\n    \"offers\": {\r\n        \"@type\": \"Offer\",\r\n        \"price\": \"0\",\r\n        \"priceCurrency\": \"USD\",\r\n        \"availability\": \"https://schema.org/InStock\"\r\n    }\r\n}', NULL, NULL, 'Avg Load Time', '0.38s', 1, 1, 1, '2026-09-21 03:59:51', '2026-09-23 04:46:11'),
(2, 'Mobile App Development', 'app-development', 'Engineering & Architecture', '[\"Engineering & Architecture\"]', 'fa-solid fa-mobile-screen-button', 'iOS, Android, Flutter & React Native', 'Native and cross-platform mobile experiences with offline-first synchronisation and biometric security.', 'Cross-Platform & Native Mobile App Development | WebRanker', 'High-performance iOS and Android mobile app development using Flutter and React Native with biometric security, offline sync, and real-time sockets.', 'mobile app development, iOS app developer, Android app development, Flutter agency, React Native development', 'asset/services/app-development.jpg', '<h3>Engineered for 60fps Native Fluidity & Offline Resilience</h3>\n<p>Modern mobile users expect fluid touch interactions, instantaneous transitions, and dependable functionality even in low-connectivity environments. We design, develop, and publish enterprise-grade mobile applications for <strong>iOS</strong> and <strong>Android</strong> using <strong>Flutter</strong> and <strong>React Native</strong>.</p>\n\n<h3>Key Mobile Engineering Capabilities</h3>\n<ul>\n  <li><strong>Offline-First Architecture:</strong> Local SQLite/Realm persistence engines that seamlessly sync changes with central servers upon reconnect.</li>\n  <li><strong>Hardware & Biometric Integration:</strong> Secure Face ID, Touch ID, Bluetooth LE peripherals, Apple Pay, and Google Pay integration.</li>\n  <li><strong>Real-Time WebSockets:</strong> Low-latency push notifications, live chat, and collaborative streaming interfaces.</li>\n  <li><strong>Automated App Store CI/CD:</strong> Fastlane automated build scripts and Over-The-Air (OTA) hot updates.</li>\n</ul>\n\n<blockquote>\"Great mobile apps feel weightless, intuitive, and respond instantly to human intent.\"</blockquote>', 'Native & Hybrid', '[\"Flutter 3 & React Native Multiplatform\", \"Offline SQLite & Biometric Security Sync\", \"Realtime WebSockets & Push Notifications\", \"App Store & Play Store Compliance\", \"OTA (Over-The-Air) Dynamic Hotfix Support\"]', '[{\"answer\": \"For 90% of commercial applications, modern Flutter and React Native offer near-native 60fps performance with half the engineering cost and unified codebases. We help you choose based on your hardware needs.\", \"question\": \"Should I choose Native or Cross-Platform (Flutter/React Native)?\"}, {\"answer\": \"Yes, our team manages end-to-end submissions, privacy manifest compliance, test flight deployments, and store listing optimization.\", \"question\": \"Do you handle the Apple App Store and Google Play approval process?\"}, {\"answer\": \"We implement hardware-backed KeyStore/Keychain encryption, certificate pinning, biometric authentication, and strict OWASP Mobile Top 10 guidelines.\", \"question\": \"How do you secure sensitive user data on mobile devices?\"}]', NULL, NULL, '{\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"SoftwareApplication\",\n    \"name\": \"WebRanker Mobile App Engineering Suite\",\n    \"operatingSystem\": \"iOS, Android\",\n    \"applicationCategory\": \"MobileApplication\"\n}', NULL, NULL, 'App Store Rating', '4.9★', 2, 1, 1, '2026-09-21 03:59:51', '2026-09-23 04:23:15'),
(3, 'Custom Software Development', 'custom-software-development', 'Engineering & Architecture', '[\"Engineering & Architecture\"]', 'fa-solid fa-cubes', 'Bespoke Enterprise Microservices & APIs', 'Tailored software architecture for complex enterprise workflows, multi-tenant databases, and mission-critical systems.', 'Enterprise Custom Software Development & APIs | WebRanker', 'Scalable enterprise software development, event-driven microservices, multi-tenant SaaS architecture, and resilient API ecosystems.', 'custom software development, enterprise software, microservices architecture, SaaS development, bespoke software solutions', 'asset/services/custom-software-development.jpg', '<h3>Bespoke Software Engineered for Complex Commercial Workflows</h3>\n<p>Off-the-shelf software inevitably creates process compromises and costly license lock-in. WebRanker builds custom, proprietary software systems tailored directly to your operational workflows, compliance requirements, and scale goals.</p>\n\n<h3>Enterprise Architectural Pillars</h3>\n<ul>\n  <li><strong>Event-Driven Microservices:</strong> Decoupled services communicating via Kafka and RabbitMQ for linear horizontal scalability.</li>\n  <li><strong>Multi-Tenant Data Isolation:</strong> Schema-level segregation ensuring complete enterprise tenant privacy and compliance.</li>\n  <li><strong>High-Throughput GraphQL & REST APIs:</strong> Sub-millisecond response times with Redis caching and rate-limiting gateways.</li>\n  <li><strong>Role-Based Access Control (RBAC):</strong> Granular permissions, SAML/SSO authentication, and immutable audit logs.</li>\n</ul>', 'Enterprise Grade', '[\"Event-Driven Microservices Architecture\", \"High-Throughput REST & GraphQL APIs\", \"Role-Based Access Control (RBAC) & SSO\", \"Multi-Tenant Data Privacy Isolation\", \"Automated CI/CD Quality Gateways\"]', '[{\"answer\": \"While initial development requires investment, custom software eliminates recurring seat licensing fees, adapts directly to your proprietary workflows, and creates valuable IP assets for your company.\", \"question\": \"How does custom software compare in cost to commercial off-the-shelf software?\"}, {\"answer\": \"Yes, our engineers specialize in building resilient integration layers, ESBs, and adapters for SAP, Salesforce, Oracle, and legacy SQL databases.\", \"question\": \"Can you integrate with our legacy enterprise ERPs and databases?\"}]', NULL, NULL, '{\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"Service\",\n    \"name\": \"Custom Software Engineering & Microservices\",\n    \"serviceType\": \"Software Development\"\n}', NULL, NULL, 'Uptime SLA', '99.99%', 3, 0, 1, '2026-09-21 03:59:51', '2026-09-23 04:23:15'),
(4, 'Cloud & DevOps Services', 'cloud-devops', 'Engineering & Architecture', '[\"Engineering & Architecture\"]', 'fa-solid fa-cloud', 'Kubernetes, CI/CD & Zero-Downtime Infra', 'Automated cloud pipelines, Terraform infrastructure as code, and enterprise auto-scaling clusters on AWS, GCP & Azure.', 'Cloud Architecture, Kubernetes & DevOps CI/CD | WebRanker', 'Enterprise cloud infrastructure, Kubernetes containerization, Terraform IaC, and automated zero-downtime CI/CD deployment pipelines on AWS & GCP.', 'cloud devops services, AWS cloud consulting, Kubernetes deployment, Terraform infrastructure as code, CI/CD pipeline automation', 'asset/services/cloud-devops.jpg', '<h3>Elastic Infrastructure Engineered for Uninterrupted Availability</h3>\n<p>Modern cloud infrastructure must be automated, reproducible, and self-healing. We modernize your deployment pipelines and cloud architectures using <strong>Terraform Infrastructure as Code (IaC)</strong>, <strong>Docker</strong>, and managed <strong>Kubernetes (EKS/GKE)</strong>.</p>\n\n<h3>Core Cloud Competencies</h3>\n<ul>\n  <li><strong>Zero-Downtime Deployments:</strong> Blue/green and canary rollouts managed automatically through GitHub Actions and ArgoCD.</li>\n  <li><strong>Automated Disaster Recovery:</strong> Multi-region replication, continuous backup verification, and 15-minute RTO/RPO targets.</li>\n  <li><strong>Cloud Cost Optimization:</strong> Eliminating idle provisioned capacity, implementing spot instances, and optimizing egress traffic.</li>\n</ul>', 'Multi-Cloud', '[\"Docker & Kubernetes EKS/GKE Orchestration\", \"GitHub Actions & GitLab CI/CD Automation\", \"Terraform & Pulumi Infrastructure as Code\", \"Multi-Region Disaster Recovery & Failover\", \"Cloud Cost Reduction & FinOps Optimization\"]', '[{\"answer\": \"We hold certifications and enterprise expertise across Amazon Web Services (AWS), Google Cloud Platform (GCP), Microsoft Azure, and Cloudflare.\", \"question\": \"Which cloud providers do you support?\"}, {\"answer\": \"We configure blue-green and canary deployment strategies with automated health verification. Traffic only shifts to new pods once internal health checks confirm stability.\", \"question\": \"How do you manage zero-downtime deployments?\"}]', NULL, NULL, '{\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"Service\",\n    \"name\": \"Cloud Infrastructure & DevOps Automation\",\n    \"serviceType\": \"Cloud Architecture\"\n}', NULL, NULL, 'Deploy Frequency', '15x/Day', 4, 0, 1, '2026-09-21 03:59:51', '2026-09-23 04:23:15'),
(5, 'Digital Marketing & SEO', 'seo-services', 'Growth & Intelligence', '[\"Growth & Intelligence\"]', 'fa-solid fa-magnifying-glass-chart', 'Technical Audits, Topical Clusters & #1 Rankings', 'Data-backed search strategies targeting high-intent commercial keywords, entity graph optimization, and organic domain authority.', 'Enterprise Technical SEO & Organic Search Growth | WebRanker', 'Dominate organic Google SERPs with entity schema graphing, topical authority architecture, algorithmic technical audits, and commercial rank growth.', 'technical SEO services, enterprise SEO agency, topical authority mapping, JSON-LD schema optimization, organic search growth', 'asset/services/seo-services.jpg', '<h3>Algorithmic Search Optimization That Dominates First-Page SERPs</h3>\n<p>Modern Google rankings demand much more than keyword stuffing. Search algorithms now evaluate entity graphs, topical depth, Core Web Vitals, and semantic Schema.org microdata. We deliver algorithmic search dominance through rigorous technical engineering and high-authority digital PR.</p>\n\n<h3>The WebRanker Search Methodology</h3>\n<ul>\n  <li><strong>Technical Crawl Optimization:</strong> Eliminating crawl budget waste, index bloat, redirect chains, and canonical confusion.</li>\n  <li><strong>Topical Authority Mapping:</strong> Architecting comprehensive pillar and cluster structures that establish undeniable niche leadership.</li>\n  <li><strong>Entity & JSON-LD Structured Data:</strong> Connecting Organization, Service, FAQ, and BreadcrumbList microdata to Google\'s Knowledge Graph.</li>\n  <li><strong>High-Tier Digital PR & Backlinks:</strong> Earning editorial citations from tier-1 authoritative industry publications.</li>\n</ul>', '#1 Rank Strategy', '[\"Topical Authority Maps & Content Silos\", \"Deep Technical Crawl & Log File Audits\", \"Entity Graph & JSON-LD Schema Suite\", \"Core Web Vitals & PageSpeed Alignment\", \"High-Tier Digital PR & Link Acquisition\"]', '[{\"answer\": \"Technical fixes and schema implementation typically trigger search bot re-indexing within 14 to 30 days. Broad topical authority rankings generally demonstrate compounding gains in months 3 to 6.\", \"question\": \"How quickly can we expect to see ranking improvements?\"}, {\"answer\": \"By strictly adhering to Google Search Essentials, EEAT guidelines, and white-hat architectural standards, our client websites consistently gain visibility during major core algorithm shifts.\", \"question\": \"How do you handle Google Core Algorithm updates?\"}]', NULL, NULL, '{\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"Service\",\n    \"name\": \"Technical SEO & Search Dominance Engine\",\n    \"serviceType\": \"Digital Marketing\"\n}', NULL, NULL, 'Organic Lift', '+340%', 5, 1, 1, '2026-09-21 03:59:51', '2026-09-23 04:23:15'),
(6, 'AI & Automation Solutions', 'ai-automation', 'Growth & Intelligence', '[\"Growth & Intelligence\"]', 'fa-solid fa-robot', 'Autonomous Agents & Smart Workflow Bots', 'Deploying fine-tuned LLMs, automated retrieval-augmented generation (RAG) pipelines, and autonomous operational agents.', 'Enterprise AI Solutions, LLMs & Autonomous Agents | WebRanker', 'Build enterprise AI agents, custom RAG vector search pipelines, and autonomous workflow bots to automate high-friction business operations.', 'enterprise AI solutions, custom LLM development, RAG vector search, AI workflow automation, autonomous AI agents', 'asset/services/ai-automation.jpg', '<h3>Autonomous Intelligence That Multiplies Enterprise Productivity</h3>\n<p>Artificial intelligence is shifting from novelty to fundamental infrastructure. We design and deploy private, enterprise-grade AI applications including <strong>Retrieval-Augmented Generation (RAG)</strong> knowledge engines, automated document intelligence, and multi-agent workflow systems.</p>\n\n<h3>Enterprise AI Solutions We Deploy</h3>\n<ul>\n  <li><strong>Proprietary Knowledge RAG:</strong> Grounding LLMs in your private corporate documents with Milvus/Pinecone vector databases and zero data leakage.</li>\n  <li><strong>Autonomous Operational Agents:</strong> Bots capable of executing multi-step reasoning, interacting with internal APIs, and resolving tickets.</li>\n  <li><strong>Intelligent OCR & Processing:</strong> Automated extraction and validation of financial invoices, legal agreements, and logistics manifests.</li>\n</ul>', 'GenAI Powered', '[\"Custom Vector Search & RAG Knowledge Bases\", \"Autonomous Agentic Workflow Bots\", \"Document Intelligence & Multimodal OCR\", \"Private LLM Fine-Tuning & Self-Hosting\", \"SOC-2 Compliant Zero-Retention Data Privacy\"]', '[{\"answer\": \"Yes. We deploy private models with zero data-retention policies, self-hosted open-source models (e.g. LLaMA 3), or enterprise Azure OpenAI environments with strict encryption.\", \"question\": \"Is our proprietary enterprise data kept private and secure?\"}, {\"answer\": \"RAG retrieves precise company documentation before answering a query, ensuring AI responses are 100% accurate, hallucination-free, and directly cited to source documents.\", \"question\": \"What is RAG (Retrieval-Augmented Generation)?\"}]', NULL, NULL, '{\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"Service\",\n    \"name\": \"Enterprise AI & Autonomous Automation\",\n    \"serviceType\": \"Artificial Intelligence Consulting\"\n}', NULL, NULL, 'Hours Saved', '1,200h/mo', 6, 1, 1, '2026-09-21 03:59:51', '2026-09-23 04:23:15'),
(7, 'E-commerce Solutions', 'ecommerce-solutions', 'Growth & Intelligence', '[\"Growth & Intelligence\"]', 'fa-solid fa-cart-shopping', 'Shopify Plus, Headless & High-Volume Sales', 'Frictionless checkout experiences, omnichannel inventory synchronization, and high-converting headless storefronts.', 'Headless E-Commerce & Shopify Plus Solutions | WebRanker', 'High-conversion headless e-commerce storefronts, Shopify Plus scaling, 1-click checkout optimization, and real-time inventory ERP integrations.', 'headless ecommerce development, Shopify Plus agency, custom ecommerce portals, conversion rate optimization, omnichannel retail', 'asset/services/ecommerce-solutions.jpg', '<h3>High-Conversion Commerce Architectures for High-Growth Retailers</h3>\n<p>Every millisecond of latency in an e-commerce funnel translates to abandoned carts. We architect ultra-fast headless commerce storefronts using <strong>Shopify Plus</strong>, <strong>MedusaJS</strong>, and <strong>Next.js Commerce</strong> to maximize conversion velocity.</p>\n\n<h3>Commerce Capabilities</h3>\n<ul>\n  <li><strong>Sub-Second Headless Catalog:</strong> Instant product filtering, zero-lag faceted search, and edge cart synchronization.</li>\n  <li><strong>1-Click Checkout Optimization:</strong> Native Apple Pay, Google Pay, Shop Pay, and Klarna integrations.</li>\n  <li><strong>Real-Time ERP & Inventory Sync:</strong> Bidirectional integrations with NetSuite, SAP, and automated warehouse 3PLs.</li>\n</ul>', 'Conversion Engine', '[\"Shopify Plus & Custom Headless Storefronts\", \"Frictionless 1-Click Optimized Checkouts\", \"Real-Time ERP & 3PL Warehouse Inventory Sync\", \"Dynamic AI Product Personalization\", \"Global Multi-Currency & Localization\"]', '[{\"answer\": \"Headless storefronts decouple frontend presentation from the commerce backend, allowing instant page transitions, bespoke checkout flows, and PageSpeed 99+ scores that boost conversion by 20-30%.\", \"question\": \"Why choose Headless E-commerce over standard themes?\"}]', NULL, NULL, '{\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"Service\",\n    \"name\": \"Enterprise Headless E-Commerce Solutions\",\n    \"serviceType\": \"E-Commerce Development\"\n}', NULL, NULL, 'Checkout Conv.', '+28.4%', 7, 0, 1, '2026-09-21 03:59:51', '2026-09-23 04:23:15'),
(8, 'Site Optimization & Speed', 'site-optimization', 'Growth & Intelligence', '[\"Growth & Intelligence\"]', 'fa-solid fa-gauge-high', 'Core Web Vitals, 99+ PageSpeed & CRO', 'Guaranteeing green 95+ Google PageSpeed scores, sub-second LCP, zero CLS, and instant interaction to boost Google rankings.', 'Core Web Vitals & 99+ PageSpeed Optimization | WebRanker', 'Guaranteed 95+ Google PageSpeed scores, sub-second LCP, zero CLS, and TTFB reduction to skyrocket organic rank and conversion rates.', 'core web vitals optimization, website speed optimization, Google PageSpeed 99, TTFB reduction, LCP and INP fix', 'asset/services/site-optimization.jpg', '<h3>Sub-Second Performance Engineering for Search & Conversion</h3>\n<p>Google has made page speed and Core Web Vitals direct ranking criteria. We perform deep bytecode audits, asset optimization, critical CSS inlining, and edge server tuning to achieve green 95+ scores on both mobile and desktop.</p>\n\n<h3>Core Web Vitals Targets We Guarantee</h3>\n<ul>\n  <li><strong>Largest Contentful Paint (LCP):</strong> Under 1.2 seconds across all cellular and broadband connections.</li>\n  <li><strong>Cumulative Layout Shift (CLS):</strong> Exact 0.00 score with zero disruptive element jumps.</li>\n  <li><strong>Interaction to Next Paint (INP):</strong> Sub-100ms response to taps, clicks, and keystrokes.</li>\n  <li><strong>Time to First Byte (TTFB):</strong> Under 120ms globally via Cloudflare CDN edge workers.</li>\n</ul>', 'PageSpeed 99+', '[\"Guaranteed Green 95+ Google PageSpeed Score\", \"LCP, INP & CLS Core Web Vitals Remediation\", \"Next-Gen Image Pipeline (AVIF/WebP Compression)\", \"Critical CSS Inlining & Unused JS Elimination\", \"Server Response Time (TTFB) Reduction Under 150ms\"]', '[{\"answer\": \"Yes, our engineering contracts specify guaranteed passing Core Web Vitals scores on Google PageSpeed Insights for both mobile and desktop environments.\", \"question\": \"Do you guarantee green scores on mobile devices?\"}]', NULL, NULL, '{\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"Service\",\n    \"name\": \"Core Web Vitals & Speed Optimization\",\n    \"serviceType\": \"Performance Engineering\"\n}', NULL, NULL, 'Mobile Score', '99/100', 8, 0, 1, '2026-09-21 03:59:51', '2026-09-23 04:23:15'),
(9, 'UI/UX Design & Branding', 'ui-ux-design', 'Design & Reliability', '[\"Design & Reliability\"]', 'fa-solid fa-palette', 'Conversion Design Systems & Premium UI', 'Human-centric user journeys, high-fidelity Figma prototypes, and modular design tokens that elevate brand prestige.', 'UI/UX Design Systems & High-Conversion Branding | WebRanker', 'Elevate brand prestige with human-centric UX research, interactive Figma design systems, WCAG 2.1 AA accessibility, and CRO UI interfaces.', 'UI UX design services, enterprise design systems, Figma prototyping, conversion rate design, digital product design', 'asset/services/ui-ux-design.jpg', '<h3>Conversion-Focused Digital Interfaces That Command Respect</h3>\n<p>Visual design should never be decorative; it is the fundamental bridge between human psychology and commercial conversion. We create scalable design systems, interactive prototypes, and conversion-optimized digital interfaces.</p>\n\n<h3>Design System Architecture</h3>\n<ul>\n  <li><strong>Modular Figma Design Tokens:</strong> Unified color palettes, typographic scales, spacing tokens, and component states.</li>\n  <li><strong>WCAG 2.1 AA Accessibility:</strong> Complete contrast validation, screen-reader semantic structures, and keyboard navigation.</li>\n  <li><strong>Micro-Interactions & Motion Design:</strong> Subtle cues that guide user attention directly to conversion funnels.</li>\n</ul>', 'Design System', '[\"Interactive High-Fidelity Figma Prototypes\", \"Comprehensive Design Tokens & Component Libraries\", \"Full WCAG 2.1 AA Accessibility Compliance\", \"Conversion Rate Optimization (CRO) User Journeys\", \"Design-to-Code Developer Handoff Specifications\"]', '[{\"answer\": \"You receive a complete production-ready Figma design library, responsive mobile/tablet/desktop layouts, interactive click-through prototypes, design tokens, and exportable SVG/image assets.\", \"question\": \"What deliverables do you provide at the end of the design phase?\"}]', NULL, NULL, '{\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"Service\",\n    \"name\": \"UI/UX Product Design & Branding Systems\",\n    \"serviceType\": \"Design Services\"\n}', NULL, NULL, 'User Engagement', '+76%', 9, 0, 1, '2026-09-21 03:59:51', '2026-09-23 04:23:15'),
(10, 'Website Maintenance & Support', 'website-maintenance', 'Design & Reliability', '[\"Design & Reliability\"]', 'fa-solid fa-shield-heart', '24/7 SLA Uptime, Security & CWV Guard', 'Continuous monitoring, automated daily backups, security vulnerability patching, and perpetual Core Web Vitals health guards.', '24/7 Enterprise Website Maintenance & SLA Support | WebRanker', 'Peace of mind with 24/7 uptime monitoring, automated hourly backups, vulnerability patching, and perpetual Core Web Vitals health guard.', 'website maintenance services, 24/7 website support, web security patching, SLA uptime guarantee, enterprise web maintenance', 'asset/services/website-maintenance.jpg', '<h3>Perpetual Peace of Mind with Guaranteed Response Times</h3>\n<p>Modern web applications require ongoing care to protect against newly discovered security vulnerabilities, framework deprecations, and performance regressions. Our maintenance contracts guarantee your digital assets remain protected, fast, and continuously online.</p>\n\n<h3>Maintenance Protections Included</h3>\n<ul>\n  <li><strong>24/7 Global Synthetic Uptime Monitoring:</strong> Real-time alerts dispatched to senior engineers within 60 seconds of any anomaly.</li>\n  <li><strong>Automated Hourly Offsite Backups:</strong> Point-in-time database restoration tested monthly for disaster recovery compliance.</li>\n  <li><strong>Continuous Security Patching:</strong> Rapid deployment of dependency updates, SSL certificates, and WAF firewall rules.</li>\n</ul>', '24/7 Guardian', '[\"24/7 Continuous Synthetic Health & Uptime Pings\", \"Automated Hourly Offsite Disaster Recovery Backups\", \"Perpetual Core Web Vitals & Speed Regression Guards\", \"Rapid Vulnerability Patching & Dependency Upgrades\", \"Guaranteed 15-Minute Emergency Incident SLA\"]', '[{\"answer\": \"Our emergency on-call team responds within 15 minutes under our priority enterprise SLA, initiating failover and disaster recovery protocols immediately.\", \"question\": \"How quickly do you respond to an unexpected outage?\"}]', NULL, NULL, '{\n    \"@context\": \"https://schema.org\",\n    \"@type\": \"Service\",\n    \"name\": \"24/7 Enterprise Website Maintenance & Health Guard\",\n    \"serviceType\": \"Website Maintenance\"\n}', NULL, NULL, 'Response Time', '< 15 Min', 10, 0, 1, '2026-09-21 03:59:51', '2026-09-23 04:23:15');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('lGZcokL0ImfXHJqOJSBwtPuqBmFLYLyboSj6lWHD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'eyJfdG9rZW4iOiJ4VXlKSkQ5Q0FoSHRQdUFYTXBDdFUyWWxIZXVydG95cHN2NFdUcVN3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvc2NoZW1hIiwicm91dGUiOiJhZG1pbi5zY2hlbWEuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJ1cmwiOltdLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1790167631);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `group`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'WebRanker', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(2, 'site_tagline', 'Web & App Development, SEO, Content & Performance Optimization', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(3, 'meta_title', 'WebRanker | Web & App Development, SEO, Content & Performance Optimization', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(4, 'meta_description', 'WebRanker is an elite engineering and organic search agency specializing in Web Development, Mobile Apps, Technical SEO, Topical Content, and Site Speed Optimization for E-Commerce, Healthcare, and Fintech.', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(5, 'meta_keywords', 'web development, mobile app development, technical SEO, organic search ranking, site speed optimization, core web vitals, ecommerce development, AI automation', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(6, 'canonical_base', 'https://webranker.com', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(7, 'og_image', 'asset/logo.svg', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(8, 'contact_email', 'growth@webranker.com', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(9, 'contact_phone', '+91 (141) 234-5678', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(10, 'contact_address', 'Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar, Jaipur, Rajasthan 302017', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 05:32:31'),
(11, 'geo_latitude', '26.844394', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 05:32:31'),
(12, 'geo_longitude', '75.805302', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 05:32:31'),
(13, 'social_twitter', 'https://twitter.com/webranker', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(14, 'social_linkedin', 'https://linkedin.com/company/webranker', 'text', 'seo', '2026-09-21 03:59:50', '2026-09-21 04:30:01'),
(15, 'social_github', 'https://github.com/webranker', 'text', 'seo', '2026-09-21 03:59:51', '2026-09-21 04:30:01'),
(16, 'google_site_verification', 'google-site-verification-webranker-token', 'text', 'seo', '2026-09-21 04:30:01', '2026-09-21 04:30:01'),
(17, 'bing_site_verification', 'bing-site-verification-webranker-token', 'text', 'seo', '2026-09-21 04:30:01', '2026-09-21 04:30:01'),
(18, 'schema_local_business', '{\"name\":\"WebRanker Technologies HQ\",\"legal_name\":\"WebRanker Digital & Engineering Solutions Pvt. Ltd.\",\"image\":\"asset\\/logo.svg\",\"street_address\":\"Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8\\/1, Sector 8, Malviya Nagar, Jaipur, Rajasthan 302017\",\"address_locality\":\"Jaipur\",\"address_region\":\"Rajasthan\",\"postal_code\":\"302017\",\"address_country\":\"IN\",\"telephone\":\"+91 97185 70218\",\"email\":\"growth@webranker.com\",\"latitude\":\"26.844394\",\"longitude\":\"75.805302\",\"price_range\":\"$$$\",\"opening_hours\":\"Mo-Fr 09:00-19:00\",\"currencies_accepted\":\"USD, EUR, GBP, INR, AED\",\"area_served\":\"Worldwide (USA, Canada, UK, UAE, India, Australia)\"}', 'json', 'seo', '2026-09-21 04:30:01', '2026-09-21 05:32:31'),
(19, 'schema_organization', '{\"name\":\"WebRanker\",\"legal_name\":\"WebRanker Digital Global Enterprise Ltd.\",\"alternate_name\":\"WebRanker SEO & Tech Labs\",\"founding_date\":\"2020-01-15\",\"founder_name\":\"Alexander Reed\",\"logo_url\":\"asset\\/logo.svg\",\"customer_service_phone\":\"+91 (141) 234-5678\",\"customer_service_email\":\"support@webranker.com\",\"social_links\":[\"https:\\/\\/twitter.com\\/webranker\",\"https:\\/\\/linkedin.com\\/company\\/webranker\",\"https:\\/\\/facebook.com\\/webranker\",\"https:\\/\\/github.com\\/webranker\",\"https:\\/\\/youtube.com\\/@webranker\"]}', 'json', 'seo', '2026-09-21 04:30:01', '2026-09-21 04:30:01'),
(20, 'schema_seo', '{\"meta_title\":\"WebRanker | Web & App Development, SEO, Content & Performance Optimization\",\"meta_description\":\"WebRanker is an elite engineering and organic search agency specializing in Web Development, Mobile Apps, Technical SEO, Topical Content, and Site Speed Optimization.\",\"meta_keywords\":\"web development, mobile app development, technical SEO, organic search ranking, site speed optimization, core web vitals, ecommerce development, AI automation\",\"og_title\":\"WebRanker | Top #1 Organic Growth & Engineering\",\"og_description\":\"Turn search traffic into revenue with sub-second web performance, custom app architectures, and high-impact SEO.\",\"og_image\":\"asset\\/logo.svg\",\"twitter_handle\":\"@webranker\",\"robots_directive\":\"index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1\",\"google_site_verification\":\"google-verification-code-sample\",\"bing_site_verification\":\"bing-verification-code-sample\"}', 'json', 'seo', '2026-09-21 04:30:01', '2026-09-21 04:30:01'),
(21, 'schema_custom_jsonld', '[\n    {\n        \"@context\": \"https:\\/\\/schema.org\",\n        \"@type\": \"SoftwareApplication\",\n        \"name\": \"WebRanker Core Performance Audit Engine\",\n        \"operatingSystem\": \"All Web Platforms\",\n        \"applicationCategory\": \"BusinessApplication\",\n        \"offers\": {\n            \"@type\": \"Offer\",\n            \"price\": \"0.00\",\n            \"priceCurrency\": \"USD\"\n        },\n        \"aggregateRating\": {\n            \"@type\": \"AggregateRating\",\n            \"ratingValue\": \"4.9\",\n            \"ratingCount\": \"342\"\n        }\n    }\n]', 'json', 'seo', '2026-09-21 04:30:01', '2026-09-21 05:32:31'),
(22, 'schema_toggles', '{\"enable_local_business\":true,\"enable_organization\":true,\"enable_website\":true,\"enable_faq\":true,\"enable_services\":true,\"enable_custom_jsonld\":true}', 'json', 'seo', '2026-09-21 04:30:01', '2026-09-21 04:30:01'),
(23, 'home_hero_kicker', 'SEO, Web Design & Digital Marketing', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(24, 'home_hero_title', 'Smooth and grow your business.', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(25, 'home_hero_title_accent', 'From search to sales.', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(26, 'home_hero_lead', 'WebRanker is a results-driven digital agency. We design fast, conversion-ready websites and grow brands with SEO, PPC, social, content, and email — so you rank higher, attract the right traffic, and convert it into revenue.', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(27, 'home_hero_cta_text', 'Claim Free Growth Audit', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(28, 'home_hero_cta_link', '#consultation', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(29, 'home_hero_secondary_text', 'See our services', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(30, 'home_hero_secondary_link', '#services', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(31, 'home_hero_serp_badge', 'LIVE SERP POSITION #1', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(32, 'home_hero_serp_sub', '+318% organic traffic', 'text', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44'),
(33, 'home_proof_tags', '[{\"label\":\"SEO\",\"desc\":\"Organic rankings\"},{\"label\":\"Web\",\"desc\":\"Design & build\"},{\"label\":\"PPC\",\"desc\":\"Paid growth\"},{\"label\":\"SMO\",\"desc\":\"Social presence\"}]', 'json', 'homepage', '2026-09-21 05:31:44', '2026-09-21 05:31:44');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint NOT NULL DEFAULT '5',
  `review_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metric_highlight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metric_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_used` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `client_title`, `company`, `avatar`, `rating`, `review_text`, `metric_highlight`, `metric_label`, `service_used`, `sort_order`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'David Sterling', 'Chief Technology Officer', 'Aether Health Technologies', 'asset/df-person1.png', 5, 'WebRanker transformed our fragmented clinical web presence into a blazing-fast, server-rendered Next.js portal. In less than 4 months, our organic patient inquiries quadrupled, and our Google PageSpeed score jumped from 48 to a flawless 99 on mobile.', '+420%', 'Organic Search Traffic', 'Web Development & Technical SEO', 1, 1, '2026-09-21 03:59:51', '2026-09-21 03:59:51'),
(2, 'Elena Rostova', 'Head of Global Growth', 'Vortex Fintech Solutions', 'asset/df-person2.png', 5, 'The engineering rigor WebRanker brought to our fintech app was phenomenal. Their zero-CLS architecture and technical SEO clusters gave us #1 search rankings across 38 high-intent commercial terms in both the US and UK markets.', '99/100', 'Core Web Vitals Score', 'Site Speed & Custom Software', 2, 1, '2026-09-21 03:59:51', '2026-09-21 03:59:51'),
(3, 'Marcus Vance', 'Founder & Managing Director', 'Solace Direct E-Commerce', 'asset/df-person3.png', 5, 'We replaced our sluggish legacy store with WebRanker’s headless architecture. Our conversion rate increased by 28%, bounce rate plummeted by 44%, and we achieved top 3 Google positions for our most profitable product lines.', '$3.8M', 'Incremental Organic Revenue', 'Headless E-Commerce & SEO', 3, 1, '2026-09-21 03:59:51', '2026-09-21 03:59:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'WebRanker Admin', 'admin@webranker.com', NULL, '$2y$12$BmGpDjUrR8Az/8UAk5Q/EOunT57cX0RFNlkvSEdnx/E1XgDcVchIm', NULL, '2026-09-21 04:30:01', '2026-09-22 23:54:23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
