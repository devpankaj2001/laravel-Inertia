import React, { useState, useMemo } from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function SchemaGenerator({ seo, initialTab = 'serp' }) {
  const [activeTab, setActiveTab] = useState(initialTab === 'schema' ? 'schema' : 'serp');

  // ----------------------------------------------------
  // TAB 1: SERP SIMULATOR STATE
  // ----------------------------------------------------
  const [serpDevice, setSerpDevice] = useState('desktop'); // 'desktop' or 'mobile'
  const [googleTheme, setGoogleTheme] = useState('dark'); // 'dark' or 'light'
  const [showCompetitors, setShowCompetitors] = useState(false);
  const [showSitelinks, setShowSitelinks] = useState(true);

  const [serpTitle, setSerpTitle] = useState('Rankexa | Next-Gen Web Development & Performance SEO Agency');
  const [serpUrl, setSerpUrl] = useState('https://rankexa.in/services/web-development');
  const [serpDesc, setSerpDesc] = useState('Scale your brand with high-performance Next.js & Laravel web engineering. 100/100 Core Web Vitals, organic Google #1 search domination, and custom AI agents.');
  const [serpBreadcrumbs, setSerpBreadcrumbs] = useState('Rankexa > Services > Web Dev');
  const [showRating, setShowRating] = useState(true);
  const [ratingScore, setRatingScore] = useState('4.9');
  const [reviewCount, setReviewCount] = useState('142');
  const [showDate, setShowDate] = useState(true);
  const [publishDate, setPublishDate] = useState('Oct 1, 2026');

  // Extract clean domain for favicon
  const domainForFavicon = useMemo(() => {
    try {
      const urlObj = new URL(serpUrl.startsWith('http') ? serpUrl : `https://${serpUrl}`);
      return urlObj.hostname || 'rankexa.in';
    } catch {
      return 'rankexa.in';
    }
  }, [serpUrl]);

  // Approximate pixel width calculations for Google Desktop (Arial 20px for Title ~ 580px max)
  const titlePixelWidth = useMemo(() => {
    return Math.round(serpTitle.length * 9.8);
  }, [serpTitle]);

  const descPixelWidth = useMemo(() => {
    return Math.round(serpDesc.length * 6.0);
  }, [serpDesc]);

  // Truncated text previews
  const maxTitlePixels = serpDevice === 'desktop' ? 580 : 520;
  const isTitleTruncated = titlePixelWidth > maxTitlePixels;
  const displayTitle = isTitleTruncated
    ? serpTitle.slice(0, Math.floor(maxTitlePixels / 9.8) - 3) + '...'
    : serpTitle;

  const maxDescPixels = serpDevice === 'desktop' ? 960 : 750;
  const isDescTruncated = descPixelWidth > maxDescPixels;
  const displayDesc = isDescTruncated
    ? serpDesc.slice(0, Math.floor(maxDescPixels / 6.0) - 3) + '...'
    : serpDesc;

  // SERP Quality Checklist
  const serpChecks = useMemo(() => {
    const titleLen = serpTitle.length;
    const descLen = serpDesc.length;
    const powerWords = ['best', 'top', 'free', 'guide', 'agency', 'fast', 'services', '2026', 'review', 'hire'];
    const hasPowerWord = powerWords.some((pw) => serpTitle.toLowerCase().includes(pw));
    const hasBrand = serpTitle.includes('|') || serpTitle.includes('-');

    return [
      {
        label: 'Title Length (Ideal: 50-60 characters)',
        pass: titleLen >= 40 && titleLen <= 60,
        hint: `${titleLen} chars (~${titlePixelWidth}px) — ${titleLen > 60 ? 'Too long! Likely truncated by Google.' : titleLen < 40 ? 'A bit short. Add target keywords.' : 'Perfect length.'}`,
      },
      {
        label: 'Meta Description (Ideal: 120-158 characters)',
        pass: descLen >= 120 && descLen <= 160,
        hint: `${descLen} chars (~${descPixelWidth}px) — ${descLen > 160 ? 'Will be truncated on mobile.' : descLen < 120 ? 'Too short. Expand with clear call-to-action.' : 'Optimal search snippet size.'}`,
      },
      {
        label: 'CTR High-Impact Power Word',
        pass: hasPowerWord,
        hint: hasPowerWord ? 'Contains compelling action/power word.' : 'Add power words like "Best", "Top", "Services", or year.',
      },
      {
        label: 'Brand Identifier Included',
        pass: hasBrand,
        hint: hasBrand ? 'Brand separated with "|" or "-".' : 'Consider appending "| BrandName" at the end.',
      },
    ];
  }, [serpTitle, serpDesc, titlePixelWidth, descPixelWidth]);

  // ----------------------------------------------------
  // TAB 2: SCHEMA GENERATOR STATE
  // ----------------------------------------------------
  const [schemaType, setSchemaType] = useState('faq'); // 'faq', 'local_business', 'article', 'product', 'organization', 'breadcrumb', 'howto'
  const [isMinified, setIsMinified] = useState(false);
  const [copiedToast, setCopiedToast] = useState(false);

  // FAQ Schema State
  const [faqs, setFaqs] = useState([
    {
      q: 'How does Rankexa improve website Core Web Vitals to 95+?',
      a: 'We re-architect frontend code using modern SSR/SSG with Next.js or Laravel Inertia, eliminating render-blocking CSS/JS and optimizing Largest Contentful Paint (LCP) under 1.2s.',
    },
    {
      q: 'How long does it take to build a custom web application?',
      a: 'Standard projects take between 3 to 6 weeks, structured across wireframing, frontend development, database engineering, and pre-launch SEO audits.',
    },
    {
      q: 'Do you provide full source code ownership after deployment?',
      a: 'Yes, 100% of the repository, assets, and intellectual property are handed over to your organization upon project sign-off.',
    },
  ]);

  // Local Business Schema State
  const [localBiz, setLocalBiz] = useState({
    name: 'Rankexa Web Development & SEO Agency',
    type: 'ProfessionalService',
    street: 'Plot 42, Malviya Nagar Tech Zone',
    city: 'Jaipur',
    state: 'Rajasthan',
    postalCode: '302017',
    country: 'IN',
    phone: '+91-7891223456',
    email: 'contact@rankexa.in',
    website: 'https://rankexa.in',
    priceRange: '₹₹',
  });

  // Article Schema State
  const [article, setArticle] = useState({
    headline: '10 Proven Technical SEO Tactics to Rank #1 on Google in 2026',
    description: 'A comprehensive technical audit guide covering Core Web Vitals, Schema JSON-LD, crawl budget optimization, and AI search rankings.',
    author: 'Rankexa Growth Labs',
    publisher: 'Rankexa',
    publisherLogo: 'https://rankexa.in/images/logo.png',
    datePublished: '2026-10-01',
    dateModified: '2026-10-01',
    image: 'https://rankexa.in/images/seo-guide-banner.jpg',
    url: 'https://rankexa.in/blog/technical-seo-tactics-2026',
  });

  // Product / Service Schema State
  const [product, setProduct] = useState({
    name: 'Next.js & Laravel Full-Stack Web Development',
    description: 'High-speed custom web development with headless CMS, sub-second page loads, and guaranteed SEO indexing.',
    brand: 'Rankexa',
    price: '45000',
    currency: 'INR',
    ratingValue: '4.9',
    reviewCount: '128',
    availability: 'https://schema.org/InStock',
  });

  // Organization Schema State
  const [org, setOrg] = useState({
    name: 'Rankexa',
    url: 'https://rankexa.in',
    logo: 'https://rankexa.in/images/logo.png',
    facebook: 'https://facebook.com/rankexa',
    twitter: 'https://twitter.com/rankexa',
    linkedin: 'https://linkedin.com/company/rankexa',
    contactEmail: 'contact@rankexa.in',
  });

  // Breadcrumbs Schema State
  const [breadcrumbsList, setBreadcrumbsList] = useState([
    { name: 'Home', url: 'https://rankexa.in' },
    { name: 'Services', url: 'https://rankexa.in/services' },
    { name: 'Technical SEO', url: 'https://rankexa.in/services/technical-seo' },
  ]);

  // HowTo Schema State
  const [howTo, setHowTo] = useState({
    name: 'How to Fix Core Web Vitals LCP in Under 48 Hours',
    description: 'Follow this 3-step technical audit process to reduce your Largest Contentful Paint to sub-second thresholds.',
    steps: [
      { name: 'Preload Hero LCP Image', text: 'Add link rel=preload as=image fetchpriority=high in your head tags.' },
      { name: 'Eliminate Render-Blocking CSS', text: 'Inline critical CSS above the fold and defer non-critical style sheets.' },
      { name: 'Enable Edge Caching', text: 'Route requests through Cloudflare APO or Redis micro-caches for 50ms TTFB.' },
    ],
  });

  // Generate JSON-LD Object
  const generatedSchema = useMemo(() => {
    if (schemaType === 'faq') {
      return {
        '@context': 'https://schema.org',
        '@type': 'FAQPage',
        mainEntity: faqs
          .filter((f) => f.q.trim() && f.a.trim())
          .map((f) => ({
            '@type': 'Question',
            name: f.q.trim(),
            acceptedAnswer: {
              '@type': 'Answer',
              text: f.a.trim(),
            },
          })),
      };
    }

    if (schemaType === 'local_business') {
      return {
        '@context': 'https://schema.org',
        '@type': localBiz.type || 'ProfessionalService',
        name: localBiz.name,
        image: localBiz.website + '/images/og-cover.jpg',
        '@id': localBiz.website + '/#business',
        url: localBiz.website,
        telephone: localBiz.phone,
        email: localBiz.email,
        priceRange: localBiz.priceRange,
        address: {
          '@type': 'PostalAddress',
          streetAddress: localBiz.street,
          addressLocality: localBiz.city,
          addressRegion: localBiz.state,
          postalCode: localBiz.postalCode,
          addressCountry: localBiz.country,
        },
      };
    }

    if (schemaType === 'article') {
      return {
        '@context': 'https://schema.org',
        '@type': 'BlogPosting',
        mainEntityOfPage: {
          '@type': 'WebPage',
          '@id': article.url,
        },
        headline: article.headline,
        description: article.description,
        image: article.image,
        author: {
          '@type': 'Person',
          name: article.author,
        },
        publisher: {
          '@type': 'Organization',
          name: article.publisher,
          logo: {
            '@type': 'ImageObject',
            url: article.publisherLogo,
          },
        },
        datePublished: article.datePublished,
        dateModified: article.dateModified,
      };
    }

    if (schemaType === 'product') {
      return {
        '@context': 'https://schema.org',
        '@type': 'Product',
        name: product.name,
        description: product.description,
        brand: {
          '@type': 'Brand',
          name: product.brand,
        },
        offers: {
          '@type': 'Offer',
          url: serpUrl,
          priceCurrency: product.currency,
          price: product.price,
          availability: product.availability,
        },
        aggregateRating: {
          '@type': 'AggregateRating',
          ratingValue: product.ratingValue,
          reviewCount: product.reviewCount,
        },
      };
    }

    if (schemaType === 'organization') {
      return {
        '@context': 'https://schema.org',
        '@type': 'Organization',
        name: org.name,
        url: org.url,
        logo: org.logo,
        contactPoint: {
          '@type': 'ContactPoint',
          contactType: 'Customer Support',
          email: org.contactEmail,
        },
        sameAs: [org.facebook, org.twitter, org.linkedin].filter(Boolean),
      };
    }

    if (schemaType === 'breadcrumb') {
      return {
        '@context': 'https://schema.org',
        '@type': 'BreadcrumbList',
        itemListElement: breadcrumbsList.map((item, idx) => ({
          '@type': 'ListItem',
          position: idx + 1,
          name: item.name,
          item: item.url,
        })),
      };
    }

    if (schemaType === 'howto') {
      return {
        '@context': 'https://schema.org',
        '@type': 'HowTo',
        name: howTo.name,
        description: howTo.description,
        step: howTo.steps.map((st, idx) => ({
          '@type': 'HowToStep',
          position: idx + 1,
          name: st.name,
          text: st.text,
        })),
      };
    }

    return {};
  }, [schemaType, faqs, localBiz, article, product, org, breadcrumbsList, howTo, serpUrl]);

  const jsonLdString = useMemo(() => {
    return isMinified
      ? JSON.stringify(generatedSchema)
      : JSON.stringify(generatedSchema, null, 2);
  }, [generatedSchema, isMinified]);

  const fullScriptTag = useMemo(() => {
    return isMinified
      ? `<script type="application/ld+json">${jsonLdString}</script>`
      : `<script type="application/ld+json">\n${jsonLdString}\n</script>`;
  }, [jsonLdString, isMinified]);

  // Copy Schema Code
  const handleCopyCode = () => {
    navigator.clipboard.writeText(fullScriptTag);
    setCopiedToast(true);
    setTimeout(() => setCopiedToast(false), 2500);
  };

  // Download Schema File
  const handleDownloadSchema = () => {
    const blob = new Blob([jsonLdString], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `schema_${schemaType}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  };

  return (
    <AppLayout seo={seo}>
      {({ openInquiry, openAudit }) => (
        <div className="bg-[#161514] text-white min-h-screen w-full max-w-full overflow-x-hidden">
          {/* Hero Section */}
          <section className="relative pt-28 sm:pt-32 pb-12 sm:pb-16 overflow-hidden border-b border-white/10 w-full">
            <div className="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] sm:w-[700px] h-[250px] sm:h-[350px] bg-red-600/15 rounded-full blur-[100px] sm:blur-[140px] pointer-events-none"></div>
            <div className="absolute top-10 right-10 w-48 sm:w-72 h-48 sm:h-72 bg-blue-600/10 rounded-full blur-[80px] sm:blur-[120px] pointer-events-none"></div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
              {/* Breadcrumb */}
              <div className="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 text-[11px] sm:text-xs font-semibold text-slate-400 mb-4">
                <Link href="/" className="hover:text-white transition-colors">Home</Link>
                <span>/</span>
                <Link href="/tools" className="hover:text-white transition-colors">Free Tools</Link>
                <span>/</span>
                <span className="text-[#ff3b30]">SERP Simulator &amp; Schema Generator</span>
              </div>

              <div className="inline-flex max-w-full items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-[10px] sm:text-xs font-semibold text-slate-300 mb-5 backdrop-blur-sm">
                <span className="w-2 h-2 rounded-full bg-[#ff3b30] animate-pulse shrink-0"></span>
                <span className="truncate">LIVE GOOGLE SERP PREVIEW • RICH SNIPPET SCHEMA ENGINE • 100% FREE</span>
              </div>

              <h1 className="text-2xl sm:text-4xl lg:text-6xl font-black tracking-tight leading-tight max-w-4xl mx-auto mb-4 text-white">
                Google SERP Simulator &amp;{' '}
                <span className="bg-gradient-to-r from-[#ff3b30] via-orange-400 to-red-400 bg-clip-text text-transparent">
                  Schema Generator
                </span>
              </h1>

              <p className="text-xs sm:text-base lg:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed mb-6 sm:mb-8">
                Preview how your website appears on Google Desktop and Mobile with pixel-perfect accuracy, and generate clean Schema.org JSON-LD scripts for instant Rich Snippets.
              </p>

              {/* Master Tool Switcher Tabs */}
              <div className="inline-flex max-w-full items-center p-1 rounded-2xl bg-black/50 border border-white/10 backdrop-blur-md">
                <button
                  type="button"
                  onClick={() => setActiveTab('serp')}
                  className={`px-4 sm:px-6 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 sm:gap-2 cursor-pointer ${
                    activeTab === 'serp'
                      ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/30'
                      : 'text-slate-400 hover:text-white'
                  }`}
                >
                  <i className="fas fa-desktop text-xs sm:text-sm"></i>
                  <span>Live SERP Simulator</span>
                </button>
                <button
                  type="button"
                  onClick={() => setActiveTab('schema')}
                  className={`px-4 sm:px-6 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 sm:gap-2 cursor-pointer ${
                    activeTab === 'schema'
                      ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/30'
                      : 'text-slate-400 hover:text-white'
                  }`}
                >
                  <i className="fas fa-code text-xs sm:text-sm"></i>
                  <span>Schema JSON-LD Generator</span>
                </button>
              </div>
            </div>
          </section>

          {/* MAIN TOOL WORKSPACE */}
          <section className="py-10 sm:py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            
            {/* ======================================================== */}
            {/* TAB 1: LIVE GOOGLE SERP SIMULATOR */}
            {/* ======================================================== */}
            {activeTab === 'serp' && (
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start w-full">
                
                {/* Inputs Column (5 Cols) */}
                <div className="lg:col-span-5 space-y-6 min-w-0 w-full">
                  <div className="p-5 sm:p-6 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-sm">
                    <h2 className="text-base sm:text-lg font-bold text-white mb-4 flex items-center gap-2">
                      <i className="fas fa-pen-to-square text-[#ff3b30]"></i>
                      <span>SERP Metadata Inputs</span>
                    </h2>

                    <div className="space-y-4 text-left">
                      {/* Title Tag */}
                      <div>
                        <div className="flex items-center justify-between text-xs mb-1">
                          <label className="font-semibold text-slate-300">SEO Title Tag</label>
                          <span className={`font-mono text-[11px] truncate ${serpTitle.length > 60 ? 'text-red-400 font-bold' : serpTitle.length < 40 ? 'text-amber-400' : 'text-emerald-400'}`}>
                            {serpTitle.length} chars / ~{titlePixelWidth}px (Max ~580px)
                          </span>
                        </div>
                        <input
                          type="text"
                          value={serpTitle}
                          onChange={(e) => setSerpTitle(e.target.value)}
                          placeholder="Page Title | Brand Name"
                          className="w-full px-3.5 py-2.5 rounded-xl bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] transition-colors"
                        />
                        {/* Visual Progress Bar */}
                        <div className="w-full h-1.5 bg-black/60 rounded-full mt-1.5 overflow-hidden">
                          <div
                            className={`h-full transition-all duration-300 ${
                              titlePixelWidth > 580 ? 'bg-red-500' : titlePixelWidth > 500 ? 'bg-amber-500' : 'bg-emerald-500'
                            }`}
                            style={{ width: `${Math.min(100, (titlePixelWidth / 580) * 100)}%` }}
                          ></div>
                        </div>
                      </div>

                      {/* Target URL */}
                      <div>
                        <label className="block text-xs font-semibold text-slate-300 mb-1">
                          Target URL &amp; Slug
                        </label>
                        <input
                          type="text"
                          value={serpUrl}
                          onChange={(e) => setSerpUrl(e.target.value)}
                          placeholder="https://yourdomain.com/page-slug"
                          className="w-full px-3.5 py-2.5 rounded-xl bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] transition-colors"
                        />
                      </div>

                      {/* Breadcrumbs */}
                      <div>
                        <label className="block text-xs font-semibold text-slate-300 mb-1">
                          Breadcrumbs Path
                        </label>
                        <input
                          type="text"
                          value={serpBreadcrumbs}
                          onChange={(e) => setSerpBreadcrumbs(e.target.value)}
                          placeholder="Brand > Category > Page"
                          className="w-full px-3.5 py-2.5 rounded-xl bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] transition-colors"
                        />
                      </div>

                      {/* Meta Description */}
                      <div>
                        <div className="flex items-center justify-between text-xs mb-1">
                          <label className="font-semibold text-slate-300">Meta Description</label>
                          <span className={`font-mono text-[11px] truncate ${serpDesc.length > 160 ? 'text-red-400 font-bold' : serpDesc.length < 120 ? 'text-amber-400' : 'text-emerald-400'}`}>
                            {serpDesc.length} chars / ~{descPixelWidth}px (Max ~960px)
                          </span>
                        </div>
                        <textarea
                          rows={3}
                          value={serpDesc}
                          onChange={(e) => setSerpDesc(e.target.value)}
                          placeholder="Compelling meta description with target keywords and call to action..."
                          className="w-full px-3.5 py-2 rounded-xl bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] transition-colors resize-none"
                        ></textarea>
                        {/* Visual Progress Bar */}
                        <div className="w-full h-1.5 bg-black/60 rounded-full mt-1.5 overflow-hidden">
                          <div
                            className={`h-full transition-all duration-300 ${
                              descPixelWidth > 960 ? 'bg-red-500' : descPixelWidth > 850 ? 'bg-amber-500' : 'bg-emerald-500'
                            }`}
                            style={{ width: `${Math.min(100, (descPixelWidth / 960) * 100)}%` }}
                          ></div>
                        </div>
                      </div>

                      {/* Rich Snippet Enhancements */}
                      <div className="pt-2 border-t border-white/10 space-y-3">
                        <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">
                          Rich Snippet Simulation Extras
                        </span>
                        
                        {/* Star Rating toggle */}
                        <div className="flex flex-wrap items-center justify-between gap-2">
                          <label className="text-xs text-slate-300 flex items-center gap-2 cursor-pointer select-none">
                            <input
                              type="checkbox"
                              checked={showRating}
                              onChange={(e) => setShowRating(e.target.checked)}
                              className="accent-[#ff3b30]"
                            />
                            <span>Include Star Rating</span>
                          </label>
                          {showRating && (
                            <div className="flex items-center gap-1.5 text-xs">
                              <input
                                type="text"
                                value={ratingScore}
                                onChange={(e) => setRatingScore(e.target.value)}
                                className="w-12 px-2 py-1 rounded bg-black/60 border border-white/10 text-center text-xs"
                                placeholder="4.9"
                              />
                              <span className="text-slate-500">score</span>
                              <input
                                type="text"
                                value={reviewCount}
                                onChange={(e) => setReviewCount(e.target.value)}
                                className="w-14 px-2 py-1 rounded bg-black/60 border border-white/10 text-center text-xs"
                                placeholder="128"
                              />
                              <span className="text-slate-500">revs</span>
                            </div>
                          )}
                        </div>

                        {/* Date toggle */}
                        <div className="flex items-center justify-between">
                          <label className="text-xs text-slate-300 flex items-center gap-2 cursor-pointer select-none">
                            <input
                              type="checkbox"
                              checked={showDate}
                              onChange={(e) => setShowDate(e.target.checked)}
                              className="accent-[#ff3b30]"
                            />
                            <span>Include Published Date</span>
                          </label>
                          {showDate && (
                            <input
                              type="text"
                              value={publishDate}
                              onChange={(e) => setPublishDate(e.target.value)}
                              className="w-28 px-2 py-1 rounded bg-black/60 border border-white/10 text-center text-xs"
                            />
                          )}
                        </div>

                        {/* Sitelinks toggle */}
                        <div className="flex items-center justify-between">
                          <label className="text-xs text-slate-300 flex items-center gap-2 cursor-pointer select-none">
                            <input
                              type="checkbox"
                              checked={showSitelinks}
                              onChange={(e) => setShowSitelinks(e.target.checked)}
                              className="accent-[#ff3b30]"
                            />
                            <span>Simulate Brand Sitelinks</span>
                          </label>
                        </div>

                        {/* Competitor Benchmark Toggle */}
                        <div className="flex items-center justify-between">
                          <label className="text-xs text-slate-300 flex items-center gap-2 cursor-pointer select-none">
                            <input
                              type="checkbox"
                              checked={showCompetitors}
                              onChange={(e) => setShowCompetitors(e.target.checked)}
                              className="accent-[#ff3b30]"
                            />
                            <span>SERP Battle Mode (Competitor Compare)</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>

                  {/* CTR Quality Checklist */}
                  <div className="p-5 sm:p-6 rounded-2xl bg-white/[0.03] border border-white/10 text-left">
                    <h3 className="text-sm font-bold text-white mb-3 flex items-center gap-2">
                      <i className="fas fa-list-check text-emerald-400"></i>
                      <span>CTR Optimization Checklist</span>
                    </h3>
                    <div className="space-y-3">
                      {serpChecks.map((chk, i) => (
                        <div key={i} className="flex items-start gap-2.5 text-xs">
                          <i className={`fas ${chk.pass ? 'fa-circle-check text-emerald-400' : 'fa-circle-exclamation text-amber-400'} mt-0.5 text-sm shrink-0`}></i>
                          <div className="min-w-0">
                            <span className="font-semibold text-slate-200 block truncate">{chk.label}</span>
                            <span className="text-[11px] text-slate-400 leading-tight block">{chk.hint}</span>
                          </div>
                        </div>
                      ))}
                    </div>
                  </div>
                </div>

                {/* Live Preview Column (7 Cols) */}
                <div className="lg:col-span-7 space-y-6 min-w-0 w-full">
                  
                  {/* Device & Theme Selector Bar */}
                  <div className="p-3.5 sm:p-4 rounded-2xl bg-white/[0.03] border border-white/10 flex flex-wrap items-center justify-between gap-3">
                    <span className="text-xs font-bold text-slate-300 flex items-center gap-2">
                      <i className="fab fa-google text-red-400"></i>
                      <span>Simulated Google Search Result</span>
                    </span>

                    <div className="flex items-center gap-2">
                      {/* Dark/Light toggle */}
                      <div className="flex items-center gap-1 bg-black/50 p-1 rounded-xl border border-white/10">
                        <button
                          type="button"
                          onClick={() => setGoogleTheme('dark')}
                          title="Google Dark Mode"
                          className={`p-1.5 rounded-lg text-xs cursor-pointer ${
                            googleTheme === 'dark' ? 'bg-[#ff3b30] text-white' : 'text-slate-400'
                          }`}
                        >
                          <i className="fas fa-moon text-xs"></i>
                        </button>
                        <button
                          type="button"
                          onClick={() => setGoogleTheme('light')}
                          title="Google Light Mode"
                          className={`p-1.5 rounded-lg text-xs cursor-pointer ${
                            googleTheme === 'light' ? 'bg-[#ff3b30] text-white' : 'text-slate-400'
                          }`}
                        >
                          <i className="fas fa-sun text-xs"></i>
                        </button>
                      </div>

                      {/* Device switcher */}
                      <div className="flex items-center gap-1 bg-black/50 p-1 rounded-xl border border-white/10">
                        <button
                          type="button"
                          onClick={() => setSerpDevice('desktop')}
                          className={`px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1.5 transition-colors cursor-pointer ${
                            serpDevice === 'desktop' ? 'bg-[#ff3b30] text-white' : 'text-slate-400 hover:text-white'
                          }`}
                        >
                          <i className="fas fa-desktop text-xs"></i>
                          <span>Desktop</span>
                        </button>
                        <button
                          type="button"
                          onClick={() => setSerpDevice('mobile')}
                          className={`px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1.5 transition-colors cursor-pointer ${
                            serpDevice === 'mobile' ? 'bg-[#ff3b30] text-white' : 'text-slate-400 hover:text-white'
                          }`}
                        >
                          <i className="fas fa-mobile-screen text-xs"></i>
                          <span>Mobile</span>
                        </button>
                      </div>
                    </div>
                  </div>

                  {/* Simulated Google Search Results Container */}
                  <div
                    className={`p-5 sm:p-8 rounded-2xl border transition-colors shadow-2xl text-left font-sans w-full max-w-full overflow-hidden ${
                      googleTheme === 'dark'
                        ? 'bg-[#202124] border-white/15 text-[#bdc1c6]'
                        : 'bg-[#ffffff] border-slate-200 text-[#4d5156]'
                    }`}
                  >
                    
                    {/* Optional Simulated Competitor #1 above */}
                    {showCompetitors && (
                      <div className={`pb-6 mb-6 border-b opacity-60 ${googleTheme === 'dark' ? 'border-white/10' : 'border-slate-200'}`}>
                        <span className="text-[10px] uppercase font-bold text-amber-500 mb-1 block">Competitor #1 in SERP</span>
                        <div className="flex items-center gap-2 text-xs">
                          <span className={googleTheme === 'dark' ? 'text-[#dadce0]' : 'text-[#202124]'}>Industry Leader Inc</span>
                          <span className="text-[10px]">https://industryleader.com</span>
                        </div>
                        <h4 className={`text-[17px] font-normal ${googleTheme === 'dark' ? 'text-[#8ab4f8]' : 'text-[#1a0dab]'}`}>
                          Top Enterprise Web Engineering &amp; Growth Solutions
                        </h4>
                        <p className="text-[13px] line-clamp-2">
                          Discover corporate digital architectures, speed optimization, and cloud software engineering for international enterprises.
                        </p>
                      </div>
                    )}

                    {/* MAIN SEARCH RESULT CARD */}
                    {serpDevice === 'desktop' ? (
                      /* GOOGLE DESKTOP SEARCH CARD */
                      <div className="max-w-[650px] space-y-1.5 w-full">
                        {showCompetitors && (
                          <span className="text-[10px] uppercase font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full inline-block mb-1">
                            Your Listing in SERP
                          </span>
                        )}

                        {/* URL Header */}
                        <div className="flex items-center gap-3">
                          <img
                            src={`https://www.google.com/s2/favicons?domain=${domainForFavicon}&sz=64`}
                            alt="Favicon"
                            className="w-6 h-6 rounded-full bg-slate-800 p-0.5 shrink-0 object-contain"
                            onError={(e) => {
                              e.target.style.display = 'none';
                            }}
                          />
                          <div className="min-w-0">
                            <span className={`text-xs font-medium block truncate ${googleTheme === 'dark' ? 'text-[#dadce0]' : 'text-[#202124]'}`}>
                              {serpBreadcrumbs.split('>')[0]?.trim() || 'Rankexa'}
                            </span>
                            <span className={`text-[11px] font-normal truncate block ${googleTheme === 'dark' ? 'text-[#bdc1c6]' : 'text-[#5f6368]'}`}>
                              {serpUrl}
                            </span>
                          </div>
                        </div>

                        {/* Title link */}
                        <div className="pt-0.5">
                          <h3 className={`text-[18px] sm:text-[20px] font-normal leading-[1.3] hover:underline cursor-pointer break-words ${googleTheme === 'dark' ? 'text-[#8ab4f8]' : 'text-[#1a0dab]'}`}>
                            {displayTitle}
                          </h3>
                        </div>

                        {/* Rating Row (if enabled) */}
                        {showRating && (
                          <div className="flex items-center gap-2 text-xs pt-0.5">
                            <span className="text-[#fbbc04]">
                              {'★'.repeat(5)}
                            </span>
                            <span className={`font-semibold ${googleTheme === 'dark' ? 'text-[#e8eaed]' : 'text-[#202124]'}`}>Rating: {ratingScore}/5</span>
                            <span>•</span>
                            <span>{reviewCount} reviews</span>
                          </div>
                        )}

                        {/* Snippet Description */}
                        <p className={`text-[13px] sm:text-[14px] leading-[1.58] pt-1 break-words ${googleTheme === 'dark' ? 'text-[#bdc1c6]' : 'text-[#4d5156]'}`}>
                          {showDate && (
                            <span className={`mr-1.5 font-medium ${googleTheme === 'dark' ? 'text-[#9aa0a6]' : 'text-[#70757a]'}`}>{publishDate} —</span>
                          )}
                          {displayDesc}
                        </p>

                        {/* Sitelinks Simulation */}
                        {showSitelinks && (
                          <div className="pt-3 grid grid-cols-2 gap-3 max-w-[500px]">
                            {[
                              { title: 'Web Development Services', desc: 'Custom Next.js & Laravel full-stack architecture.' },
                              { title: 'Technical SEO Audits', desc: 'Sub-second Core Web Vitals & schema rankings.' },
                              { title: 'Cost Calculator', desc: 'Instant itemized scopes & vector PDF proposals.' },
                              { title: 'Contact Architects', desc: 'Free discovery consultation & timeline estimation.' },
                            ].map((site, i) => (
                              <div key={i} className="space-y-0.5">
                                <span className={`text-xs font-medium hover:underline cursor-pointer block truncate ${googleTheme === 'dark' ? 'text-[#8ab4f8]' : 'text-[#1a0dab]'}`}>
                                  {site.title}
                                </span>
                                <span className={`text-[11px] block line-clamp-1 ${googleTheme === 'dark' ? 'text-[#9aa0a6]' : 'text-[#70757a]'}`}>
                                  {site.desc}
                                </span>
                              </div>
                            ))}
                          </div>
                        )}
                      </div>
                    ) : (
                      /* GOOGLE MOBILE SEARCH CARD */
                      <div
                        className={`w-full max-w-[360px] mx-auto p-4 rounded-2xl border shadow-lg space-y-2 ${
                          googleTheme === 'dark'
                            ? 'bg-[#303134] border-white/10 text-[#bdc1c6]'
                            : 'bg-[#ffffff] border-slate-200 text-[#4d5156]'
                        }`}
                      >
                        {/* Mobile Header */}
                        <div className="flex items-center gap-2.5">
                          <img
                            src={`https://www.google.com/s2/favicons?domain=${domainForFavicon}&sz=64`}
                            alt="Favicon"
                            className="w-5 h-5 rounded-full shrink-0 object-contain"
                          />
                          <div className="min-w-0 flex-1">
                            <span className={`text-[12px] font-medium block truncate ${googleTheme === 'dark' ? 'text-[#dadce0]' : 'text-[#202124]'}`}>
                              {serpBreadcrumbs.split('>')[0]?.trim() || 'Rankexa'}
                            </span>
                            <span className={`text-[10px] truncate block ${googleTheme === 'dark' ? 'text-[#bdc1c6]' : 'text-[#5f6368]'}`}>
                              {serpUrl.replace('https://', '')}
                            </span>
                          </div>
                          <i className="fas fa-ellipsis-vertical text-slate-400 text-xs"></i>
                        </div>

                        {/* Mobile Title */}
                        <h3 className={`text-[16px] sm:text-[17px] font-medium leading-[1.3] break-words ${googleTheme === 'dark' ? 'text-[#8ab4f8]' : 'text-[#1a0dab]'}`}>
                          {displayTitle}
                        </h3>

                        {/* Rating */}
                        {showRating && (
                          <div className="flex items-center gap-1.5 text-[11px]">
                            <span className="text-[#fbbc04]">{'★'.repeat(5)}</span>
                            <span>{ratingScore} ({reviewCount})</span>
                          </div>
                        )}

                        {/* Mobile Snippet */}
                        <p className={`text-[13px] leading-[1.45] break-words ${googleTheme === 'dark' ? 'text-[#bdc1c6]' : 'text-[#4d5156]'}`}>
                          {showDate && (
                            <span className={`mr-1 ${googleTheme === 'dark' ? 'text-[#9aa0a6]' : 'text-[#70757a]'}`}>{publishDate} —</span>
                          )}
                          {displayDesc}
                        </p>
                      </div>
                    )}

                    {/* Optional Simulated Competitor #3 below */}
                    {showCompetitors && (
                      <div className={`pt-6 mt-6 border-t opacity-60 ${googleTheme === 'dark' ? 'border-white/10' : 'border-slate-200'}`}>
                        <span className="text-[10px] uppercase font-bold text-amber-500 mb-1 block">Competitor #3 in SERP</span>
                        <div className="flex items-center gap-2 text-xs">
                          <span className={googleTheme === 'dark' ? 'text-[#dadce0]' : 'text-[#202124]'}>Slow Dev Co</span>
                          <span className="text-[10px]">https://slowdevagency.com</span>
                        </div>
                        <h4 className={`text-[17px] font-normal ${googleTheme === 'dark' ? 'text-[#8ab4f8]' : 'text-[#1a0dab]'}`}>
                          Outdated WordPress Templates &amp; Basic SEO
                        </h4>
                        <p className="text-[13px] line-clamp-2">
                          Heavy page weight and unoptimized Core Web Vitals make visitors bounce.
                        </p>
                      </div>
                    )}

                  </div>

                  {/* Pro Tip Card */}
                  <div className="p-5 sm:p-6 rounded-2xl bg-white/[0.03] border border-white/10 text-left flex items-start gap-4">
                    <div className="w-10 h-10 rounded-xl bg-[#ff3b30]/10 border border-[#ff3b30]/30 text-[#ff3b30] flex items-center justify-center text-lg shrink-0">
                      <i className="fas fa-lightbulb"></i>
                    </div>
                    <div className="min-w-0">
                      <h4 className="text-sm font-bold text-white mb-1">Rankexa CTR Secret</h4>
                      <p className="text-xs text-slate-400 leading-relaxed">
                        Titles that combine an exact search keyword + specific number or year (e.g. 2026) + power emotional trigger achieve up to 32% higher organic CTR on Google Page 1.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            )}

            {/* ======================================================== */}
            {/* TAB 2: SCHEMA JSON-LD GENERATOR */}
            {/* ======================================================== */}
            {activeTab === 'schema' && (
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start w-full">
                
                {/* Schema Configuration Column (6 Cols) */}
                <div className="lg:col-span-6 space-y-6 min-w-0 w-full">
                  
                  {/* Schema Type Buttons */}
                  <div className="p-5 sm:p-6 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-sm text-left">
                    <h2 className="text-base sm:text-lg font-bold text-white mb-4 flex items-center gap-2">
                      <i className="fas fa-layer-group text-[#ff3b30]"></i>
                      <span>Select Schema.org Rich Type</span>
                    </h2>

                    <div className="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                      {[
                        { id: 'faq', name: 'FAQ Page', icon: 'fa-circle-question' },
                        { id: 'local_business', name: 'Local Business', icon: 'fa-shop' },
                        { id: 'article', name: 'Article / Blog', icon: 'fa-newspaper' },
                        { id: 'product', name: 'Product / Service', icon: 'fa-tag' },
                        { id: 'organization', name: 'Organization', icon: 'fa-building' },
                        { id: 'breadcrumb', name: 'Breadcrumbs', icon: 'fa-route' },
                      ].map((item) => {
                        const isSelected = schemaType === item.id;
                        return (
                          <button
                            key={item.id}
                            type="button"
                            onClick={() => setSchemaType(item.id)}
                            className={`p-3 rounded-xl border text-xs font-bold flex flex-col items-center gap-1.5 transition-all cursor-pointer ${
                              isSelected
                                ? 'bg-red-500/15 border-[#ff3b30] text-white shadow-lg shadow-red-500/20'
                                : 'bg-white/[0.02] border-white/10 text-slate-400 hover:text-white hover:bg-white/[0.05]'
                            }`}
                          >
                            <i className={`fas ${item.icon} text-base ${isSelected ? 'text-[#ff3b30]' : 'text-slate-400'}`}></i>
                            <span className="truncate">{item.name}</span>
                          </button>
                        );
                      })}
                    </div>
                  </div>

                  {/* Schema Dynamic Form */}
                  <div className="p-5 sm:p-6 rounded-2xl bg-white/[0.03] border border-white/10 text-left min-w-0">
                    
                    {/* 1. FAQ Schema Form */}
                    {schemaType === 'faq' && (
                      <div className="space-y-4">
                        <div className="flex items-center justify-between mb-2">
                          <h3 className="text-sm font-bold text-white">FAQ Accordion Questions &amp; Answers</h3>
                          <button
                            type="button"
                            onClick={() => setFaqs([...faqs, { q: '', a: '' }])}
                            className="px-3 py-1.5 rounded-lg bg-[#ff3b30] hover:bg-[#e03126] text-white font-bold text-xs flex items-center gap-1.5 cursor-pointer"
                          >
                            <i className="fas fa-plus"></i>
                            <span>Add Q&amp;A</span>
                          </button>
                        </div>

                        {faqs.map((faq, idx) => (
                          <div key={idx} className="p-3.5 sm:p-4 rounded-xl bg-black/40 border border-white/10 space-y-2 relative">
                            <div className="flex items-center justify-between">
                              <span className="text-[11px] font-bold text-slate-400 uppercase">Question #{idx + 1}</span>
                              {faqs.length > 1 && (
                                <button
                                  type="button"
                                  onClick={() => setFaqs(faqs.filter((_, i) => i !== idx))}
                                  className="text-slate-500 hover:text-red-400 text-xs p-1"
                                  title="Delete item"
                                >
                                  <i className="fas fa-trash"></i>
                                </button>
                              )}
                            </div>
                            <input
                              type="text"
                              value={faq.q}
                              onChange={(e) => {
                                const updated = [...faqs];
                                updated[idx].q = e.target.value;
                                setFaqs(updated);
                              }}
                              placeholder="e.g. What is the turnaround time?"
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30]"
                            />
                            <textarea
                              rows={2}
                              value={faq.a}
                              onChange={(e) => {
                                const updated = [...faqs];
                                updated[idx].a = e.target.value;
                                setFaqs(updated);
                              }}
                              placeholder="Provide the exact answer..."
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] resize-none"
                            ></textarea>
                          </div>
                        ))}
                      </div>
                    )}

                    {/* 2. Local Business Form */}
                    {schemaType === 'local_business' && (
                      <div className="space-y-3.5">
                        <h3 className="text-sm font-bold text-white mb-1">Local Business Details</h3>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Business Name</label>
                            <input
                              type="text"
                              value={localBiz.name}
                              onChange={(e) => setLocalBiz({ ...localBiz, name: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30]"
                            />
                          </div>
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Business Type</label>
                            <input
                              type="text"
                              value={localBiz.type}
                              onChange={(e) => setLocalBiz({ ...localBiz, type: e.target.value })}
                              placeholder="ProfessionalService, Restaurant, Store"
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30]"
                            />
                          </div>
                        </div>

                        <div>
                          <label className="block text-[11px] text-slate-400 mb-1">Street Address</label>
                          <input
                            type="text"
                            value={localBiz.street}
                            onChange={(e) => setLocalBiz({ ...localBiz, street: e.target.value })}
                            className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30]"
                          />
                        </div>

                        <div className="grid grid-cols-2 sm:grid-cols-4 gap-2">
                          <div>
                            <label className="block text-[10px] text-slate-400 mb-1">City</label>
                            <input
                              type="text"
                              value={localBiz.city}
                              onChange={(e) => setLocalBiz({ ...localBiz, city: e.target.value })}
                              className="w-full px-2.5 py-1.5 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                          <div>
                            <label className="block text-[10px] text-slate-400 mb-1">State</label>
                            <input
                              type="text"
                              value={localBiz.state}
                              onChange={(e) => setLocalBiz({ ...localBiz, state: e.target.value })}
                              className="w-full px-2.5 py-1.5 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                          <div>
                            <label className="block text-[10px] text-slate-400 mb-1">PIN / Zip</label>
                            <input
                              type="text"
                              value={localBiz.postalCode}
                              onChange={(e) => setLocalBiz({ ...localBiz, postalCode: e.target.value })}
                              className="w-full px-2.5 py-1.5 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                          <div>
                            <label className="block text-[10px] text-slate-400 mb-1">Country</label>
                            <input
                              type="text"
                              value={localBiz.country}
                              onChange={(e) => setLocalBiz({ ...localBiz, country: e.target.value })}
                              className="w-full px-2.5 py-1.5 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Phone Number</label>
                            <input
                              type="text"
                              value={localBiz.phone}
                              onChange={(e) => setLocalBiz({ ...localBiz, phone: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Website URL</label>
                            <input
                              type="text"
                              value={localBiz.website}
                              onChange={(e) => setLocalBiz({ ...localBiz, website: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                        </div>
                      </div>
                    )}

                    {/* 3. Article / Blog Schema Form */}
                    {schemaType === 'article' && (
                      <div className="space-y-3">
                        <h3 className="text-sm font-bold text-white mb-1">Article / Blog Post Details</h3>
                        <div>
                          <label className="block text-[11px] text-slate-400 mb-1">Article Headline</label>
                          <input
                            type="text"
                            value={article.headline}
                            onChange={(e) => setArticle({ ...article, headline: e.target.value })}
                            className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                          />
                        </div>
                        <div>
                          <label className="block text-[11px] text-slate-400 mb-1">Description</label>
                          <textarea
                            rows={2}
                            value={article.description}
                            onChange={(e) => setArticle({ ...article, description: e.target.value })}
                            className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs resize-none"
                          ></textarea>
                        </div>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Author Name</label>
                            <input
                              type="text"
                              value={article.author}
                              onChange={(e) => setArticle({ ...article, author: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Publisher</label>
                            <input
                              type="text"
                              value={article.publisher}
                              onChange={(e) => setArticle({ ...article, publisher: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                        </div>
                        <div>
                          <label className="block text-[11px] text-slate-400 mb-1">Featured Image URL</label>
                          <input
                            type="text"
                            value={article.image}
                            onChange={(e) => setArticle({ ...article, image: e.target.value })}
                            className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                          />
                        </div>
                      </div>
                    )}

                    {/* 4. Product / Service Schema Form */}
                    {schemaType === 'product' && (
                      <div className="space-y-3">
                        <h3 className="text-sm font-bold text-white mb-1">Product / Service Specification</h3>
                        <div>
                          <label className="block text-[11px] text-slate-400 mb-1">Product / Service Name</label>
                          <input
                            type="text"
                            value={product.name}
                            onChange={(e) => setProduct({ ...product, name: e.target.value })}
                            className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                          />
                        </div>
                        <div className="grid grid-cols-2 gap-3">
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Price</label>
                            <input
                              type="text"
                              value={product.price}
                              onChange={(e) => setProduct({ ...product, price: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Currency</label>
                            <input
                              type="text"
                              value={product.currency}
                              onChange={(e) => setProduct({ ...product, currency: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                        </div>
                        <div className="grid grid-cols-2 gap-3">
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Star Rating (1-5)</label>
                            <input
                              type="text"
                              value={product.ratingValue}
                              onChange={(e) => setProduct({ ...product, ratingValue: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Review Count</label>
                            <input
                              type="text"
                              value={product.reviewCount}
                              onChange={(e) => setProduct({ ...product, reviewCount: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                        </div>
                      </div>
                    )}

                    {/* 5. Organization Schema Form */}
                    {schemaType === 'organization' && (
                      <div className="space-y-3">
                        <h3 className="text-sm font-bold text-white mb-1">Organization &amp; Brand Entity</h3>
                        <div>
                          <label className="block text-[11px] text-slate-400 mb-1">Organization Name</label>
                          <input
                            type="text"
                            value={org.name}
                            onChange={(e) => setOrg({ ...org, name: e.target.value })}
                            className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                          />
                        </div>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Website URL</label>
                            <input
                              type="text"
                              value={org.url}
                              onChange={(e) => setOrg({ ...org, url: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                          <div>
                            <label className="block text-[11px] text-slate-400 mb-1">Logo URL</label>
                            <input
                              type="text"
                              value={org.logo}
                              onChange={(e) => setOrg({ ...org, logo: e.target.value })}
                              className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                            />
                          </div>
                        </div>
                        <div>
                          <label className="block text-[11px] text-slate-400 mb-1">LinkedIn Profile</label>
                          <input
                            type="text"
                            value={org.linkedin}
                            onChange={(e) => setOrg({ ...org, linkedin: e.target.value })}
                            className="w-full px-3 py-2 rounded-lg bg-black/50 border border-white/10 text-white text-xs"
                          />
                        </div>
                      </div>
                    )}

                    {/* 6. Breadcrumbs Schema Form */}
                    {schemaType === 'breadcrumb' && (
                      <div className="space-y-3">
                        <h3 className="text-sm font-bold text-white mb-1">Breadcrumb Hierarchy Trail</h3>
                        {breadcrumbsList.map((bc, idx) => (
                          <div key={idx} className="grid grid-cols-1 sm:grid-cols-2 gap-2 p-2.5 rounded-lg bg-black/30 border border-white/5">
                            <div>
                              <label className="block text-[10px] text-slate-400">Position #{idx + 1} Name</label>
                              <input
                                type="text"
                                value={bc.name}
                                onChange={(e) => {
                                  const updated = [...breadcrumbsList];
                                  updated[idx].name = e.target.value;
                                  setBreadcrumbsList(updated);
                                }}
                                className="w-full px-2.5 py-1.5 rounded bg-black/50 border border-white/10 text-white text-xs"
                              />
                            </div>
                            <div>
                              <label className="block text-[10px] text-slate-400">Target URL</label>
                              <input
                                type="text"
                                value={bc.url}
                                onChange={(e) => {
                                  const updated = [...breadcrumbsList];
                                  updated[idx].url = e.target.value;
                                  setBreadcrumbsList(updated);
                                }}
                                className="w-full px-2.5 py-1.5 rounded bg-black/50 border border-white/10 text-white text-xs"
                              />
                            </div>
                          </div>
                        ))}
                      </div>
                    )}

                  </div>
                </div>

                {/* Real-Time Code Output Column (6 Cols) */}
                <div className="lg:col-span-6 space-y-6 text-left min-w-0 w-full">
                  
                  {/* Generated Code Window */}
                  <div className="p-5 sm:p-6 rounded-2xl bg-[#1c1b1a] border border-white/15 shadow-2xl relative overflow-hidden w-full">
                    <div className="flex flex-wrap items-center justify-between gap-3 mb-4">
                      <div className="flex items-center gap-2">
                        <span className="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                        <span className="w-3 h-3 rounded-full bg-yellow-500 inline-block"></span>
                        <span className="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                        <span className="text-xs font-mono text-slate-400 ml-1">schema.jsonld</span>
                        <span className="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded-full ml-1">
                          Valid JSON-LD
                        </span>
                      </div>

                      <div className="flex items-center gap-2">
                        <button
                          type="button"
                          onClick={() => setIsMinified(!isMinified)}
                          className={`px-2.5 py-1.5 rounded-lg border text-xs font-bold transition-colors cursor-pointer ${
                            isMinified ? 'bg-[#ff3b30] border-[#ff3b30] text-white' : 'bg-white/5 border-white/10 text-slate-300'
                          }`}
                        >
                          {isMinified ? 'Minified' : 'Pretty'}
                        </button>

                        <button
                          type="button"
                          onClick={handleCopyCode}
                          className="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold text-xs flex items-center gap-1.5 transition-colors cursor-pointer"
                        >
                          <i className={`fas ${copiedToast ? 'fa-check text-emerald-400' : 'fa-copy'}`}></i>
                          <span>{copiedToast ? 'Copied!' : 'Copy'}</span>
                        </button>

                        <button
                          type="button"
                          onClick={handleDownloadSchema}
                          className="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold text-xs flex items-center gap-1.5 transition-colors cursor-pointer"
                        >
                          <i className="fas fa-download"></i>
                          <span>.json</span>
                        </button>
                      </div>
                    </div>

                    {/* Syntax Code Container with Horizontal Scrolling */}
                    <div className="p-3.5 sm:p-4 rounded-xl bg-black/70 border border-white/10 font-mono text-xs text-slate-300 max-h-[460px] overflow-y-auto overflow-x-auto leading-relaxed w-full">
                      <pre className="text-emerald-400 whitespace-pre">
                        <code>{fullScriptTag}</code>
                      </pre>
                    </div>

                    {/* Direct Google Rich Results Test Link */}
                    <div className="mt-5 pt-4 border-t border-white/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                      <span className="text-xs text-slate-400">Validate live with Google:</span>
                      <a
                        href="https://search.google.com/test/rich-results"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="px-4 py-2 rounded-xl bg-[#ff3b30] hover:bg-[#e03126] text-white font-bold text-xs flex items-center gap-2 shadow-lg shadow-red-500/20 transition-all cursor-pointer"
                      >
                        <i className="fab fa-google"></i>
                        <span>Test on Google Rich Results</span>
                        <i className="fas fa-arrow-up-right-from-square text-[10px]"></i>
                      </a>
                    </div>
                  </div>

                  {/* Installation Instructions */}
                  <div className="p-4 sm:p-5 rounded-2xl bg-white/[0.02] border border-white/5 text-xs text-slate-400 space-y-2">
                    <h4 className="font-bold text-white text-xs flex items-center gap-2">
                      <i className="fas fa-terminal text-[#ff3b30]"></i>
                      <span>How to Install on Your Website</span>
                    </h4>
                    <p className="leading-relaxed">
                      Copy the code above and paste it directly inside the <code className="text-slate-200 bg-white/10 px-1 py-0.5 rounded">&lt;head&gt;</code> section of your HTML or Next.js <code className="text-slate-200 bg-white/10 px-1 py-0.5 rounded">&lt;Head&gt;</code> component.
                    </p>
                  </div>
                </div>

              </div>
            )}

          </section>
        </div>
      )}
    </AppLayout>
  );
}
