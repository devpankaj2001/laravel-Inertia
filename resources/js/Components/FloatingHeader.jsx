import React, { useState, useEffect } from 'react';
import { Link, usePage, router } from '@inertiajs/react';

// Helper to ensure FontAwesome icon classes always have solid/regular prefix
const normalizeIconClass = (iconStr, fallback = 'fa-solid fa-layer-group') => {
  if (!iconStr) return fallback;
  const trimmed = String(iconStr).trim();
  if (
    trimmed.startsWith('fa-solid ') ||
    trimmed.startsWith('fas ') ||
    trimmed.startsWith('far ') ||
    trimmed.startsWith('fab ')
  ) {
    return trimmed;
  }
  if (trimmed.startsWith('fa-')) {
    return `fa-solid ${trimmed}`;
  }
  return `fa-solid fa-${trimmed}`;
};

export default function FloatingHeader({ onOpenInquiry }) {
  const { url } = usePage();
  const { navServicesByCategory = {}, navIndustries = [] } = usePage().props;
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [servicesOpen, setServicesOpen] = useState(false);
  const [industriesOpen, setIndustriesOpen] = useState(false);

  // Group industries by category_group
  const groupedIndustries = React.useMemo(() => {
    if (!Array.isArray(navIndustries)) return {};
    return navIndustries.reduce((acc, item) => {
      const group = item.category_group || 'General Industries';
      if (!acc[group]) acc[group] = [];
      acc[group].push(item);
      return acc;
    }, {});
  }, [navIndustries]);

  // Close menus when route changes
  useEffect(() => {
    setMobileMenuOpen(false);
    setServicesOpen(false);
    setIndustriesOpen(false);
  }, [url]);

  // Handle Free Audit button click -> Scroll to on-page form section
  const handleFreeAuditClick = (e) => {
    if (e) e.preventDefault();
    setMobileMenuOpen(false);

    // Look for form section on current page
    const targetSection =
      document.getElementById('consultation') ||
      document.getElementById('inquiryForm') ||
      document.getElementById('contactForm') ||
      document.getElementById('dsContactForm') ||
      document.querySelector('form.consult-form');

    if (targetSection) {
      targetSection.scrollIntoView({ behavior: 'smooth' });
    } else {
      // If no form section on current page (e.g. /blogs, /industries), navigate to /#consultation
      router.visit('/#consultation', {
        preserveScroll: false,
        onSuccess: () => {
          setTimeout(() => {
            const sec = document.getElementById('consultation');
            if (sec) sec.scrollIntoView({ behavior: 'smooth' });
          }, 350);
        },
      });
    }
  };

  return (
    <>
      <header className="floating-pill-header" id="floatingHeader">
        <div className="flex items-center justify-between w-full">
          {/* Brand Logo */}
          <Link href="/" className="header-brand-wrap" aria-label="WebRanker Homepage">
            <span className="header-brand-icon-box">
              <span className="header-brand-icon-wr">WR</span>
            </span>
            <span className="header-brand-text">
              <span className="header-brand-text-web">Web</span>
              <span className="header-brand-text-ranker">Ranker</span>
            </span>
          </Link>

          {/* Desktop Navigation Menu */}
          <nav className="hidden lg:flex items-center gap-7 xl:gap-8 text-[14.5px] font-medium text-[#374151]" aria-label="Primary">
            {/* Services Dropdown */}
            <div
              className={`nav-dropdown nav-dropdown--mega ${servicesOpen ? 'is-active' : ''}`}
              onMouseEnter={() => setServicesOpen(true)}
              onMouseLeave={() => setServicesOpen(false)}
            >
              <button
                type="button"
                className={`nav-link-item nav-link-item--trigger flex items-center gap-1.5 hover:text-[#111827] transition-colors ${url.startsWith('/services') ? 'text-[#ff3b30] font-bold' : ''}`}
                aria-expanded={servicesOpen}
                onClick={() => setServicesOpen(!servicesOpen)}
              >
                <span>Services</span>
                <i className={`fas fa-chevron-down text-[10px] opacity-60 transition-transform ${servicesOpen ? 'rotate-180' : ''}`}></i>
              </button>

              <div className={`nav-dropdown-menu nav-mega ${servicesOpen ? 'block' : ''}`}>
                <div
                  className="nav-mega-grid"
                  style={{
                    gridTemplateColumns: `repeat(${Math.max(1, Math.min(Object.keys(navServicesByCategory).length || 3, 4))}, minmax(240px, 1fr))`,
                  }}
                >
                  {Object.keys(navServicesByCategory).length > 0 ? (
                    Object.entries(navServicesByCategory).map(([catName, catServices], colIdx) => (
                      <div className="nav-mega-col" key={catName}>
                        <p className="nav-mega-label">{catName}</p>
                        {Array.isArray(catServices) && catServices.map((svc) => (
                          <Link
                            key={svc.id || svc.slug}
                            href={`/services/${svc.slug}`}
                            className="nav-mega-item"
                            onClick={() => setServicesOpen(false)}
                          >
                            <span className="nav-mega-ico">
                              <i className={normalizeIconClass(svc.icon_class || svc.icon, 'fa-solid fa-code')}></i>
                            </span>
                            <span className="nav-mega-copy">
                              <strong>{svc.title}</strong>
                              <em>{svc.tagline || svc.short_description}</em>
                            </span>
                          </Link>
                        ))}

                        {colIdx === Object.keys(navServicesByCategory).length - 1 && (
                          <div className="pt-2 space-y-2">
                            <Link
                              href="/services"
                              className="flex items-center justify-between px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-xs font-bold text-slate-800 transition-colors"
                              onClick={() => setServicesOpen(false)}
                            >
                              <span>Explore All Services Catalog</span>
                              <i className="fas fa-arrow-right text-[10px]"></i>
                            </Link>
                            <a
                              href="#consultation"
                              onClick={(e) => {
                                e.preventDefault();
                                setServicesOpen(false);
                                if (onOpenInquiry) onOpenInquiry();
                              }}
                              className="nav-mega-banner"
                            >
                              <strong>Need a Complete Growth Audit?</strong>
                              <span>Claim your free 48-hour SEO &amp; Tech Roadmap.</span>
                            </a>
                          </div>
                        )}
                      </div>
                    ))
                  ) : (
                    <>
                      <div className="nav-mega-col">
                        <p className="nav-mega-label">Engineering &amp; Architecture</p>
                        <Link href="/services/web-development" className="nav-mega-item">
                          <span className="nav-mega-ico"><i className="fas fa-code"></i></span>
                          <span className="nav-mega-copy"><strong>Web Development Services</strong><em>Laravel, Next.js, MERN &amp; Headless</em></span>
                        </Link>
                        <Link href="/services/mobile-app-development" className="nav-mega-item">
                          <span className="nav-mega-ico"><i className="fas fa-mobile-screen-button"></i></span>
                          <span className="nav-mega-copy"><strong>Mobile App Development</strong><em>iOS, Android &amp; Flutter</em></span>
                        </Link>
                      </div>
                      <div className="nav-mega-col">
                        <p className="nav-mega-label">Growth &amp; Intelligence</p>
                        <Link href="/services/technical-seo-core-web-vitals" className="nav-mega-item">
                          <span className="nav-mega-ico"><i className="fas fa-magnifying-glass-chart"></i></span>
                          <span className="nav-mega-copy"><strong>Technical SEO &amp; Performance</strong><em>Technical audits &amp; #1 rankings</em></span>
                        </Link>
                        <Link href="/services/ai-automation-agents" className="nav-mega-item">
                          <span className="nav-mega-ico"><i className="fas fa-robot"></i></span>
                          <span className="nav-mega-copy"><strong>AI &amp; Automation</strong><em>Autonomous business agents</em></span>
                        </Link>
                      </div>
                    </>
                  )}
                </div>
              </div>
            </div>

            {/* Industries Dropdown */}
            <div
              className={`nav-dropdown nav-dropdown--mega ${industriesOpen ? 'is-active' : ''}`}
              onMouseEnter={() => setIndustriesOpen(true)}
              onMouseLeave={() => setIndustriesOpen(false)}
            >
              <button
                type="button"
                className={`nav-link-item nav-link-item--trigger flex items-center gap-1.5 hover:text-[#111827] transition-colors ${url.startsWith('/industries') ? 'text-[#ff3b30] font-bold' : ''}`}
                aria-expanded={industriesOpen}
                onClick={() => setIndustriesOpen(!industriesOpen)}
              >
                <span>Industries</span>
                <i className={`fas fa-chevron-down text-[10px] opacity-60 transition-transform ${industriesOpen ? 'rotate-180' : ''}`}></i>
              </button>

              <div className={`nav-dropdown-menu nav-mega ${industriesOpen ? 'block' : ''}`}>
                <div className="nav-mega-grid" style={{ gridTemplateColumns: 'repeat(3, minmax(240px, 1fr))' }}>
                  {Object.entries(groupedIndustries).slice(0, 3).map(([groupName, items]) => (
                    <div className="nav-mega-col" key={groupName}>
                      <p className="nav-mega-label">{groupName}</p>
                      {items.slice(0, 4).map((ind) => (
                        <Link
                          key={ind.id || ind.slug}
                          href={`/industries/${ind.slug}`}
                          className="nav-mega-item"
                          onClick={() => setIndustriesOpen(false)}
                        >
                          <span className="nav-mega-ico">
                            <i className={normalizeIconClass(ind.icon_class || ind.icon, 'fa-solid fa-layer-group')}></i>
                          </span>
                          <span className="nav-mega-copy">
                            <strong>{ind.name}</strong>
                            <em>{ind.hero_tagline || ind.description?.substring(0, 40) + '...'}</em>
                          </span>
                        </Link>
                      ))}
                    </div>
                  ))}
                  <div className="col-span-full pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold">
                    <span className="text-slate-500">25+ Specialized Industry Domains Engineered for Compliance &amp; Search</span>
                    <Link
                      href="/industries"
                      className="text-[#ff3b30] hover:underline flex items-center gap-1 font-bold"
                      onClick={() => setIndustriesOpen(false)}
                    >
                      <span>Explore All Industries Catalog</span>
                      <i className="fas fa-arrow-right text-[10px]"></i>
                    </Link>
                  </div>
                </div>
              </div>
            </div>

            {/* Certification */}
            <a href="/#certifications" className="nav-link-item hover:text-[#111827] transition-colors">
              Certification
            </a>

            {/* Blogs */}
            <Link
              href="/blogs"
              className={`nav-link-item hover:text-[#111827] transition-colors ${url.startsWith('/blog') ? 'text-[#ff3b30] font-bold' : ''}`}
            >
              Blogs
            </Link>

            {/* Contact */}
            <Link
              href="/contact"
              className={`nav-link-item hover:text-[#111827] transition-colors ${url.startsWith('/contact') ? 'text-[#ff3b30] font-bold' : ''}`}
            >
              Contact
            </Link>
          </nav>

          {/* CTA Action Button */}
          <div className="hidden sm:flex items-center">
            <button
              type="button"
              onClick={handleFreeAuditClick}
              className="header-chamfer-btn"
              title="Claim your free performance and organic ranking audit"
            >
              <svg className="header-chamfer-dots" viewBox="0 0 14 16" fill="currentColor">
                <circle cx="4" cy="4" r="1.4" />
                <circle cx="4" cy="8" r="1.4" />
                <circle cx="4" cy="12" r="1.4" />
                <circle cx="10" cy="8" r="1.4" />
              </svg>
              <span>FREE AUDIT</span>
            </button>
          </div>

          {/* Mobile Hamburger Button */}
          <div className="flex items-center gap-2 lg:hidden">
            <button
              onClick={() => setMobileMenuOpen(true)}
              className="text-slate-800 text-xl focus:outline-none p-1.5 rounded-full hover:bg-slate-100"
              aria-label="Toggle navigation"
            >
              <i className="fas fa-bars"></i>
            </button>
          </div>
        </div>
      </header>

      {/* Mobile Drawer Menu */}
      {mobileMenuOpen && (
        <div
          className="fixed inset-0 bg-slate-950/95 backdrop-blur-md z-[10002] flex flex-col justify-between p-8 text-white transition-all overflow-y-auto"
          id="mobileNavMenu"
        >
          <div>
            <div className="flex items-center justify-between mb-8 pb-4 border-b border-slate-800">
              <span className="font-extrabold text-2xl text-white">
                Web<span className="text-[#ff3b30]">Ranker</span>
              </span>
              <button
                onClick={() => setMobileMenuOpen(false)}
                className="text-slate-400 hover:text-white text-2xl"
                aria-label="Close menu"
              >
                <i className="fas fa-times"></i>
              </button>
            </div>

            <div className="flex flex-col gap-3 text-lg font-semibold mobile-nav-links">
              <details className="mobile-nav-group">
                <summary className="mobile-nav-link cursor-pointer py-1">Services</summary>
                <div className="mobile-nav-sub pl-4 pt-2 space-y-1">
                  {Object.entries(navServicesByCategory).map(([catName, catServices]) => (
                    <div key={catName} className="mb-3">
                      <div className="text-[11px] font-bold uppercase tracking-wider text-[#ff3b30] mt-1 border-b border-slate-800/60 pb-1">
                        {catName}
                      </div>
                      {Array.isArray(catServices) && catServices.map((svc) => (
                        <Link
                          key={svc.slug}
                          href={`/services/${svc.slug}`}
                          className="mobile-nav-sublink block text-sm text-slate-300 hover:text-white py-1"
                        >
                          {svc.title}
                        </Link>
                      ))}
                    </div>
                  ))}
                  <Link
                    href="/services"
                    className="mobile-nav-sublink block text-xs font-bold text-[#ff3b30] pt-2"
                  >
                    Explore All Services Catalog →
                  </Link>
                </div>
              </details>

              <details className="mobile-nav-group">
                <summary className="mobile-nav-link cursor-pointer py-1">Industries</summary>
                <div className="mobile-nav-sub pl-4 pt-2 space-y-1">
                  <Link href="/industries" className="mobile-nav-sublink block text-sm text-slate-300 hover:text-white py-1">
                    All Industry Verticals (25+)
                  </Link>
                  <Link href="/industries/ecommerce-retail" className="mobile-nav-sublink block text-sm text-slate-300 hover:text-white py-1">
                    E-commerce &amp; Retail
                  </Link>
                  <Link href="/industries/fintech-banking" className="mobile-nav-sublink block text-sm text-slate-300 hover:text-white py-1">
                    FinTech &amp; Banking
                  </Link>
                  <Link href="/industries/healthcare-medtech" className="mobile-nav-sublink block text-sm text-slate-300 hover:text-white py-1">
                    Healthcare &amp; MedTech
                  </Link>
                </div>
              </details>

              <a href="/#growth-engine" onClick={() => setMobileMenuOpen(false)} className="mobile-nav-link hover:text-[#ff3b30]">
                How We Grow You
              </a>
              <a href="/#testimonials" onClick={() => setMobileMenuOpen(false)} className="mobile-nav-link hover:text-[#ff3b30]">
                Client Reviews
              </a>
              <Link href="/blogs" onClick={() => setMobileMenuOpen(false)} className="mobile-nav-link hover:text-[#ff3b30]">
                Insights &amp; Blogs
              </Link>
              <Link href="/contact" onClick={() => setMobileMenuOpen(false)} className="mobile-nav-link hover:text-[#ff3b30]">
                Contact Us
              </Link>
              <a href="/#faq" onClick={() => setMobileMenuOpen(false)} className="mobile-nav-link hover:text-[#ff3b30]">
                FAQ
              </a>
              <button
                type="button"
                onClick={handleFreeAuditClick}
                className="mobile-nav-link mobile-nav-cta text-left text-[#ff3b30] font-bold"
              >
                Claim Free Audit →
              </button>
            </div>
          </div>

          <div className="pt-6 border-t border-slate-800 text-center text-xs text-slate-400">
            © {new Date().getFullYear()} WebRanker. Engineered for #1 Organic Rankings &amp; Peak Performance.
          </div>
        </div>
      )}
    </>
  );
}
