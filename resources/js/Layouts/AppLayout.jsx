import React, { useState, useEffect } from 'react';
import { router } from '@inertiajs/react';
import FloatingHeader from '@/Components/FloatingHeader';
import Footer from '@/Components/Footer';
import InquiryDrawer from '@/Components/InquiryDrawer';
import LinkRequestModal from '@/Components/LinkRequestModal';
import FreeAuditModal from '@/Components/FreeAuditModal';
import AIChatbot from '@/Components/AIChatbot';
import SeoHead from '@/Components/SeoHead';

export default function AppLayout({
  children,
  seo = {},
}) {
  const [inquiryOpen, setInquiryOpen] = useState(false);
  const [auditOpen, setAuditOpen] = useState(false);
  const [linkModalData, setLinkModalData] = useState({
    isOpen: false,
    targetPageUrl: '',
    targetPageTitle: '',
  });

  const handleOpenInquiry = () => {
    setInquiryOpen(true);
  };

  const handleOpenAudit = () => {
    setAuditOpen(true);
  };

  const handleOpenLinkModal = (url = '', title = '') => {
    setLinkModalData({
      isOpen: true,
      targetPageUrl: url || (typeof window !== 'undefined' ? window.location.href : ''),
      targetPageTitle: title || 'WebRanker Page',
    });
  };

  // Universal SPA Navigation Interceptor for HTML links rendered inside Blade/contentHtml
  useEffect(() => {
    const handleGlobalLinkClick = (e) => {
      // Ignore if event already handled or not primary click
      if (e.defaultPrevented) return;
      if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

      const anchor = e.target.closest('a');
      if (!anchor) return;

      // Ignore explicit new tab, download or non-navigational links
      if (anchor.target && anchor.target !== '_self') return;
      if (anchor.hasAttribute('download')) return;

      const rawHref = anchor.getAttribute('href');
      if (!rawHref) return;

      // Skip hash jumps and special protocols
      if (rawHref.startsWith('#') || rawHref.startsWith('mailto:') || rawHref.startsWith('tel:') || rawHref.startsWith('javascript:')) {
        return;
      }

      let urlObj;
      try {
        urlObj = new URL(anchor.href, window.location.origin);
      } catch (err) {
        return;
      }

      // Only handle same-origin internal links
      if (urlObj.origin !== window.location.origin) return;

      // Skip backend admin endpoints and static assets
      if (
        urlObj.pathname.startsWith('/admin') ||
        urlObj.pathname.startsWith('/asset') ||
        urlObj.pathname.startsWith('/storage') ||
        urlObj.pathname.startsWith('/css') ||
        urlObj.pathname.startsWith('/js') ||
        urlObj.pathname.match(/\.(pdf|zip|png|jpe?g|svg|webp|ico|mp4)$/i)
      ) {
        return;
      }

      // If clicking the current exact URL without hash change, do nothing
      if (urlObj.pathname === window.location.pathname && urlObj.search === window.location.search && !urlObj.hash) {
        return;
      }

      // Handle #consultation / #inquiryForm on-page form scrolls
      const rawHash = anchor.getAttribute('href');
      if (rawHash === '#consultation' || rawHash === '#inquiryForm') {
        const targetId = rawHash.substring(1);
        const targetEl = document.getElementById(targetId);
        if (targetEl) {
          e.preventDefault();
          targetEl.scrollIntoView({ behavior: 'smooth' });
          return;
        } else {
          e.preventDefault();
          router.visit('/' + rawHash, {
            preserveScroll: false,
            onSuccess: () => {
              setTimeout(() => {
                const el = document.getElementById(targetId);
                if (el) el.scrollIntoView({ behavior: 'smooth' });
              }, 350);
            },
          });
          return;
        }
      }

      // Explicit modal popup triggers (Get in Touch)
      if (rawHash === '#inquiryDrawer' || rawHash === '#getInTouch') {
        e.preventDefault();
        setInquiryOpen(true);
        return;
      }

      // Explicit modal popup triggers (Free Audit)
      if (rawHash === '#freeAudit' || rawHash === '#auditModal' || rawHash === '#audit') {
        e.preventDefault();
        setAuditOpen(true);
        return;
      }

      // Intercept and route via Inertia SPA router
      e.preventDefault();
      router.visit(urlObj.pathname + urlObj.search + urlObj.hash, {
        preserveScroll: false,
      });
    };

    const handleGlobalInquiryClick = (e) => {
      const auditTrigger = e.target.closest('[data-open-audit], a[href="#freeAudit"], a[href="#auditModal"]');
      if (auditTrigger) {
        e.preventDefault();
        setAuditOpen(true);
        return;
      }

      const trigger = e.target.closest('[data-open-inquiry], a[href="#inquiryDrawer"], a[href="#getInTouch"]');
      if (trigger) {
        if (trigger.id === 'dsGitTabBtn') return;
        e.preventDefault();
        setInquiryOpen(true);
      }
    };

    document.addEventListener('click', handleGlobalLinkClick);
    document.addEventListener('click', handleGlobalInquiryClick);
    return () => {
      document.removeEventListener('click', handleGlobalLinkClick);
      document.removeEventListener('click', handleGlobalInquiryClick);
    };
  }, []);

  return (
    <div className="min-h-screen flex flex-col bg-[#faf7f2] text-[#1a1816]">
      {/* Dynamic SEO Meta & Schema JSON-LD Head */}
      <SeoHead
        title={seo.metaTitle}
        description={seo.metaDescription}
        keywords={seo.metaKeywords}
        canonical={seo.canonicalUrl}
        ogImage={seo.ogImage}
        schemas={seo.schemas}
        customJsonLd={seo.customJsonLd}
        googleVerification={seo.googleVerification}
        bingVerification={seo.bingVerification}
      />

      {/* Floating Curved Pill Header with Mega Menus */}
      <FloatingHeader onOpenInquiry={handleOpenInquiry} onOpenAudit={handleOpenAudit} />

      {/* Main Page Body */}
      <main id="main-content" className="flex-1">
        {typeof children === 'function'
          ? children({ openInquiry: handleOpenInquiry, openAudit: handleOpenAudit, openLinkModal: handleOpenLinkModal })
          : React.Children.map(children, (child) => {
              if (React.isValidElement(child)) {
                return React.cloneElement(child, {
                  openInquiry: handleOpenInquiry,
                  openAudit: handleOpenAudit,
                  openLinkModal: handleOpenLinkModal,
                });
              }
              return child;
            })}
      </main>

      {/* Persistent Footer */}
      <Footer onOpenInquiry={handleOpenInquiry} onOpenAudit={handleOpenAudit} />

      {/* Slide-out Inquiry Drawer */}
      <InquiryDrawer
        isOpen={inquiryOpen}
        onClose={() => setInquiryOpen(false)}
        onOpen={() => setInquiryOpen(true)}
        onToggle={() => setInquiryOpen((prev) => !prev)}
      />

      {/* Sponsored Link Request Modal */}
      <LinkRequestModal
        isOpen={linkModalData.isOpen}
        onClose={() => setLinkModalData({ ...linkModalData, isOpen: false })}
        targetPageUrl={linkModalData.targetPageUrl}
        targetPageTitle={linkModalData.targetPageTitle}
      />

      {/* Free Instant SEO & Performance Auditor Modal (Feature 2) */}
      <FreeAuditModal
        isOpen={auditOpen}
        onClose={() => setAuditOpen(false)}
        onOpenInquiry={handleOpenInquiry}
      />

      {/* Floating AI Chat Assistant */}
      <AIChatbot onOpenInquiry={handleOpenInquiry} onOpenAudit={handleOpenAudit} />
    </div>
  );
}
