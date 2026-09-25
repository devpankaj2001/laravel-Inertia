import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Footer({ onOpenInquiry, onOpenAudit }) {
  const { siteConfig = {}, navServicesByCategory = {} } = usePage().props;
  const [newsletterEmail, setNewsletterEmail] = useState('');
  const [newsletterSubmitted, setNewsletterSubmitted] = useState(false);

  const handleNewsletterSubmit = (e) => {
    e.preventDefault();
    if (!newsletterEmail) return;
    setNewsletterSubmitted(true);
    setTimeout(() => {
      setNewsletterEmail('');
    }, 3000);
  };

  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <footer className="bg-[#faf7f2] border-t border-[#e6dfd3] pt-16 pb-12 mt-20 text-[#1a1816]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Top Newsletter & Brand Banner */}
        <div className="bg-[#161514] text-white rounded-3xl p-8 sm:p-12 mb-16 relative overflow-hidden shadow-xl">
          <div className="absolute -right-20 -bottom-20 w-80 h-80 bg-[#ff3b30]/15 rounded-full blur-3xl pointer-events-none"></div>
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
            <div className="lg:col-span-7">
              <span className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-[#ff3b30] text-xs font-bold uppercase tracking-wider mb-4 border border-white/10">
                <i className="fas fa-bolt text-[11px]"></i> Weekly Engineering Briefing
              </span>
              <h3 className="text-2xl sm:text-3xl font-extrabold text-white mb-2 tracking-tight">
                Stay Ahead of Search Engine Algorithms &amp; Tech Shifts
              </h3>
              <p className="text-slate-400 text-sm max-w-xl">
                Get our weekly tear-down of Google Core updates, Next.js / Laravel architectures, and conversion-tested SEO playbooks delivered to your inbox.
              </p>
            </div>
            <div className="lg:col-span-5">
              {newsletterSubmitted ? (
                <div className="bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 p-4 rounded-xl text-sm font-semibold flex items-center gap-2">
                  <i className="fas fa-check-circle text-lg"></i>
                  <span>You're subscribed! Check your inbox for our latest SEO playbook.</span>
                </div>
              ) : (
                <form onSubmit={handleNewsletterSubmit} className="flex flex-col sm:flex-row gap-3">
                  <input
                    type="email"
                    value={newsletterEmail}
                    onChange={(e) => setNewsletterEmail(e.target.value)}
                    required
                    placeholder="Enter your corporate email"
                    className="flex-1 px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 text-sm focus:outline-none focus:border-[#ff3b30]"
                  />
                  <button
                    type="submit"
                    className="px-6 py-3 rounded-xl bg-[#ff3b30] hover:bg-[#d6281f] text-white font-bold text-sm transition-all shadow-md hover:shadow-lg whitespace-nowrap"
                  >
                    Subscribe Free
                  </button>
                </form>
              )}
            </div>
          </div>
        </div>

        {/* 4-Column Directory Grid */}
        <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 mb-16">
          {/* Brand Col */}
          <div className="col-span-2">
            <Link href="/" className="inline-flex items-center gap-2 mb-4">
              <span className="w-9 h-9 rounded-xl bg-[#161514] text-white flex items-center justify-center font-black text-sm tracking-wider shadow-sm">
                WR
              </span>
              <span className="text-xl font-black text-[#161514]">
                Web<span className="text-[#ff3b30]">Ranker</span>
              </span>
            </Link>
            <p className="text-sm text-[#6e675f] mb-6 max-w-sm leading-relaxed">
              Elite digital engineering, headless Next.js architecture, and organic search dominance. We build conversion-ready applications and rank them #1 globally.
            </p>
            <div className="flex items-center gap-3">
              <a
                href={siteConfig.twitter || 'https://twitter.com/webranker'}
                target="_blank"
                rel="noreferrer"
                className="w-9 h-9 rounded-full bg-white border border-[#e6dfd3] flex items-center justify-center text-[#161514] hover:bg-[#ff3b30] hover:text-white hover:border-[#ff3b30] transition-colors shadow-2xs"
                aria-label="Twitter"
              >
                <i className="fab fa-x-twitter text-sm"></i>
              </a>
              <a
                href={siteConfig.linkedin || 'https://linkedin.com/company/webranker'}
                target="_blank"
                rel="noreferrer"
                className="w-9 h-9 rounded-full bg-white border border-[#e6dfd3] flex items-center justify-center text-[#161514] hover:bg-[#ff3b30] hover:text-white hover:border-[#ff3b30] transition-colors shadow-2xs"
                aria-label="LinkedIn"
              >
                <i className="fab fa-linkedin-in text-sm"></i>
              </a>
              <a
                href={siteConfig.github || 'https://github.com/webranker'}
                target="_blank"
                rel="noreferrer"
                className="w-9 h-9 rounded-full bg-white border border-[#e6dfd3] flex items-center justify-center text-[#161514] hover:bg-[#ff3b30] hover:text-white hover:border-[#ff3b30] transition-colors shadow-2xs"
                aria-label="GitHub"
              >
                <i className="fab fa-github text-sm"></i>
              </a>
            </div>
          </div>

          {/* Solutions Col */}
          <div>
            <h4 className="text-xs font-bold uppercase tracking-wider text-[#161514] mb-4">
              Core Capabilities
            </h4>
            <ul className="space-y-2.5 text-sm text-[#6e675f]">
              <li>
                <Link href="/services" className="hover:text-[#ff3b30] transition-colors font-medium">
                  All Services Catalog
                </Link>
              </li>
              <li>
                <Link href="/services/web-development" className="hover:text-[#ff3b30] transition-colors">
                  Web &amp; Next.js Systems
                </Link>
              </li>
              <li>
                <Link href="/services/mobile-app-development" className="hover:text-[#ff3b30] transition-colors">
                  Mobile App Engineering
                </Link>
              </li>
              <li>
                <Link href="/services/technical-seo-core-web-vitals" className="hover:text-[#ff3b30] transition-colors">
                  Technical SEO &amp; CWV
                </Link>
              </li>
              <li>
                <Link href="/services/ai-automation-agents" className="hover:text-[#ff3b30] transition-colors">
                  AI &amp; Business Agents
                </Link>
              </li>
              <li>
                <Link href="/services/ui-ux-design-systems" className="hover:text-[#ff3b30] transition-colors">
                  UI/UX &amp; CRO Systems
                </Link>
              </li>
            </ul>
          </div>

          {/* Industry Verticals Col */}
          <div>
            <h4 className="text-xs font-bold uppercase tracking-wider text-[#161514] mb-4">
              Industry Verticals
            </h4>
            <ul className="space-y-2.5 text-sm text-[#6e675f]">
              <li>
                <Link href="/industries" className="hover:text-[#ff3b30] transition-colors font-medium">
                  All 25+ Industry Domains
                </Link>
              </li>
              <li>
                <Link href="/industries/ecommerce-retail" className="hover:text-[#ff3b30] transition-colors">
                  E-commerce &amp; Retail
                </Link>
              </li>
              <li>
                <Link href="/industries/fintech-banking" className="hover:text-[#ff3b30] transition-colors">
                  FinTech &amp; Banking
                </Link>
              </li>
              <li>
                <Link href="/industries/healthcare-medtech" className="hover:text-[#ff3b30] transition-colors">
                  Healthcare &amp; MedTech
                </Link>
              </li>
              <li>
                <Link href="/industries/saas-enterprise-b2b" className="hover:text-[#ff3b30] transition-colors">
                  SaaS &amp; Technology
                </Link>
              </li>
              <li>
                <Link href="/industries/logistics-supply-chain" className="hover:text-[#ff3b30] transition-colors">
                  Logistics &amp; Transport
                </Link>
              </li>
            </ul>
          </div>

          {/* Quick Directives & Contact */}
          <div>
            <h4 className="text-xs font-bold uppercase tracking-wider text-[#161514] mb-4">
              Direct Contact
            </h4>
            <div className="space-y-3 text-sm text-[#6e675f]">
              <p className="flex items-start gap-2">
                <i className="fas fa-envelope text-[#ff3b30] mt-1 text-xs"></i>
                <a href={`mailto:${siteConfig.email || 'info@webranker.in'}`} className="hover:text-[#161514] font-medium break-all">
                  {siteConfig.email || 'info@webranker.in'}
                </a>
              </p>
              <p className="flex items-start gap-2">
                <i className="fas fa-phone text-[#ff3b30] mt-1 text-xs"></i>
                <a href={`tel:${(siteConfig.phone || '+91 97185 70218').replace(/[^0-9+]/g, '')}`} className="hover:text-[#161514] font-medium">
                  {siteConfig.phone || '+91 97185 70218'}
                </a>
              </p>
              <p className="flex items-start gap-2 text-xs leading-relaxed text-[#7e766e]">
                <i className="fas fa-location-dot text-[#ff3b30] mt-0.5 text-xs"></i>
                <span>{siteConfig.address || 'Jaipur Tech Campus / Delhi NCR Hub, India'}</span>
              </p>
              {siteConfig.timing && (
                <p className="flex items-start gap-2 text-xs leading-relaxed text-[#7e766e]">
                  <i className="far fa-clock text-[#ff3b30] mt-0.5 text-xs"></i>
                  <span>{siteConfig.timing}</span>
                </p>
              )}
              <div className="pt-2 flex flex-wrap items-center gap-2">
                <button
                  type="button"
                  onClick={onOpenInquiry}
                  className="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#161514] hover:bg-[#ff3b30] text-white text-xs font-bold transition-all shadow-sm"
                >
                  <i className="fas fa-calendar-check text-[11px]"></i>
                  <span>Schedule Consultation</span>
                </button>
                {onOpenAudit && (
                  <button
                    type="button"
                    onClick={onOpenAudit}
                    className="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-[#ff3b30]/10 hover:bg-[#ff3b30] text-[#ff3b30] hover:text-white border border-[#ff3b30]/30 text-xs font-bold transition-all shadow-sm"
                  >
                    <i className="fas fa-bolt text-[10px]"></i>
                    <span>Free Audit</span>
                  </button>
                )}
              </div>
            </div>
          </div>
        </div>

        {/* SEO Directives Row */}
        <div className="py-6 border-t border-[#e6dfd3] flex flex-wrap items-center justify-between gap-4 text-xs text-[#6e675f]">
          <div className="flex flex-wrap items-center gap-3">
            <a
              href="/sitemap.xml"
              target="_blank"
              rel="noreferrer"
              className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-[#e6dfd3] hover:text-[#ff3b30] font-semibold transition-colors"
            >
              <i className="fas fa-sitemap text-[#ff3b30] text-[10px]"></i>
              <span>XML Sitemap</span>
            </a>
            <a
              href="/robots.txt"
              target="_blank"
              rel="noreferrer"
              className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-[#e6dfd3] hover:text-[#ff3b30] font-semibold transition-colors"
            >
              <i className="fas fa-robot text-[#6e675f] text-[10px]"></i>
              <span>Robots.txt</span>
            </a>
            <Link
              href="/blogs"
              className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-[#e6dfd3] hover:text-[#ff3b30] font-semibold transition-colors"
            >
              <i className="fas fa-newspaper text-[10px]"></i>
              <span>Engineering Lab</span>
            </Link>
          </div>

          <div className="flex items-center gap-4 text-xs">
            <span className="text-slate-400">SOC2 &amp; HIPAA Certified Agency</span>
            <span>·</span>
            <span className="text-emerald-700 font-bold flex items-center gap-1">
              <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Systems 100% Operational
            </span>
          </div>
        </div>

        {/* Bottom Legal & Attribution */}
        <div className="pt-6 border-t border-[#e6dfd3] flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#6e675f]">
          <div>
            © {new Date().getFullYear()} WebRanker Technologies Inc. All Rights Reserved. Engineered with Laravel &amp; Inertia React.
          </div>

          <div className="flex items-center gap-5 text-[#7e766e]">
            <a href="#" className="hover:text-[#161514] transition-colors">Privacy Policy</a>
            <a href="#" className="hover:text-[#161514] transition-colors">Terms of Service</a>
            <a href="#" className="hover:text-[#161514] transition-colors">Security</a>
          </div>

          <button
            type="button"
            onClick={scrollToTop}
            className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white hover:bg-slate-100 text-[#161514] border border-[#e6dfd3] transition-all text-xs font-bold shadow-2xs"
          >
            <span>Back to top</span>
            <span className="w-5 h-5 rounded-full bg-[#161514] text-white flex items-center justify-center text-[10px]">
              <i className="fas fa-arrow-up"></i>
            </span>
          </button>
        </div>
      </div>
    </footer>
  );
}
