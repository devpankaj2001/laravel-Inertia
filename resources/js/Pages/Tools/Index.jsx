import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function ToolsIndex({ seo, recentKeywords = [], recentAudits = [] }) {
  const tools = [
    {
      id: 'calculator',
      title: 'Website & Web App Project Cost Estimator',
      badge: 'Instant PDF Quotation',
      icon: 'fa-calculator',
      color: 'from-red-500 to-rose-600',
      description: 'Configure your custom scope (Corporate site, SaaS, E-Commerce, Portals), select architecture modules, and download a transparent, branded vector PDF proposal instantly.',
      metrics: ['INR (₹) & USD ($) Pricing Engine', 'Milestone Payment Schedule', 'Instant Vector PDF Proposal', 'Core Web Vitals & IP Guarantee'],
      link: '/calculator',
      ctaText: 'Calculate Project Cost',
      isAuditModal: false,
    },
    {
      id: 'schema-generator',
      title: 'Google SERP Simulator & Schema Generator',
      badge: 'Live Rich Results',
      icon: 'fa-code',
      color: 'from-blue-500 to-indigo-500',
      description: 'Simulate Google desktop and mobile search snippets with pixel-perfect accuracy. Generate clean Schema JSON-LD for FAQ, Local Business, Articles, and Products.',
      metrics: ['Desktop & Mobile SERP Preview', '580px Title Pixel Width Counter', '1-Click Schema JSON-LD Generator', 'Direct Google Rich Results Test'],
      link: '/tools/schema-generator',
      ctaText: 'Simulate SERP & Schema',
      isAuditModal: false,
    },
    {
      id: 'rank-checker',
      title: 'Google Keyword Ranking Checker',
      badge: 'Live SERP Position',
      icon: 'fa-search',
      color: 'from-orange-500 to-amber-500',
      description: 'Check your exact Google search position, inspect top 3 ranking competitors, and get an AI-generated ranking roadmap to jump to Page 1.',
      metrics: ['Exact SERP Rank (#1 - #50)', 'Page 1 vs Page 2 Indicator', 'Top 3 Competitor URLs', 'AI Keyword Difficulty & Tips'],
      link: '/tools/google-ranking-checker',
      ctaText: 'Check Google Rank',
      isAuditModal: false,
    },
    {
      id: 'backlink-checker',
      title: 'Backlink & Domain Authority Checker',
      badge: 'PageRank & Link Equity',
      icon: 'fa-link',
      color: 'from-amber-500 to-yellow-500',
      description: 'Analyze Domain Authority (0-100), PageRank score, Dofollow vs Nofollow ratio, and unlock 5 AI high-impact backlink acquisition strategies.',
      metrics: ['Domain Authority (0-100)', 'Dofollow / Nofollow Ratio', 'Toxic Link Risk Meter', '5 High DA Link Opportunities'],
      link: '/tools/backlink-checker',
      ctaText: 'Audit Backlinks & DA',
      isAuditModal: false,
    },
    {
      id: 'speed-auditor',
      title: 'Instant SEO & Core Web Vitals Auditor',
      badge: 'Real-Time Lighthouse',
      icon: 'fa-bolt',
      color: 'from-emerald-500 to-teal-500',
      description: 'Run real-time Google Mobile Lighthouse scans to measure FCP, LCP, CLS, TTFB, and receive a customized 48-Hour AI speed optimization roadmap.',
      metrics: ['Core Web Vitals Diagnostics', 'Mobile Performance Score', 'Technical Schema Audit', '48-Hour AI Action Roadmap'],
      link: '#freeAudit',
      ctaText: 'Launch Live Audit',
      isAuditModal: true,
    },
  ];

  return (
    <AppLayout seo={seo}>
      {({ openInquiry, openAudit }) => (
        <div className="bg-[#161514] text-white min-h-screen">
          {/* Hero Section */}
          <section className="relative pt-32 pb-20 overflow-hidden border-b border-white/10">
            {/* Background glowing ambient orbs */}
            <div className="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-red-600/15 rounded-full blur-[140px] pointer-events-none"></div>
            <div className="absolute top-10 right-10 w-72 h-72 bg-orange-600/10 rounded-full blur-[120px] pointer-events-none"></div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
              <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300 mb-6 backdrop-blur-sm">
                <span className="w-2 h-2 rounded-full bg-[#ff3b30] animate-pulse"></span>
                <span>100% FREE SEO &amp; ARCHITECTURE TOOLS • NO SUBSCRIPTION REQUIRED</span>
              </div>

              <h1
                className="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight max-w-4xl mx-auto mb-6 !text-white"
                style={{ color: '#ffffff' }}
              >
                <span className="text-white" style={{ color: '#ffffff' }}>
                  Rank Higher &amp; Scale Faster with
                </span>{' '}
                <span className="bg-gradient-to-r from-[#ff3b30] via-orange-400 to-red-400 bg-clip-text text-transparent">
                  Rankexa Free Tools
                </span>
              </h1>

              <p className="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed mb-10">
                Enterprise-grade search intelligence to check real-time Google keyword rankings, calculate custom project costs, simulate SERP CTR snippets, and audit Core Web Vitals speed.
              </p>

              {/* Quick Actions Bar */}
              <div className="flex flex-wrap items-center justify-center gap-3">
                <Link
                  href="/calculator"
                  className="px-6 py-3.5 rounded-xl bg-[#ff3b30] hover:bg-[#e03126] text-white font-bold text-xs uppercase tracking-wider flex items-center gap-2 transition-all shadow-lg shadow-red-500/20 active:scale-95"
                >
                  <i className="fas fa-calculator"></i>
                  <span>Cost Estimator &amp; Proposal</span>
                </Link>

                <Link
                  href="/tools/schema-generator"
                  className="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/15 text-white font-bold text-xs uppercase tracking-wider flex items-center gap-2 transition-all border border-white/10 active:scale-95"
                >
                  <i className="fas fa-code"></i>
                  <span>SERP Simulator &amp; Schema</span>
                </Link>

                <Link
                  href="/tools/google-ranking-checker"
                  className="px-6 py-3.5 rounded-xl bg-white/5 hover:bg-white/10 text-slate-200 font-bold text-xs uppercase tracking-wider flex items-center gap-2 transition-all border border-white/10 active:scale-95"
                >
                  <i className="fas fa-search"></i>
                  <span>Google Keyword Rank</span>
                </Link>

                <Link
                  href="/tools/backlink-checker"
                  className="px-6 py-3.5 rounded-xl bg-white/5 hover:bg-white/10 text-slate-200 font-bold text-xs uppercase tracking-wider flex items-center gap-2 transition-all border border-white/10 active:scale-95"
                >
                  <i className="fas fa-link"></i>
                  <span>Backlinks &amp; DA</span>
                </Link>
              </div>
            </div>
          </section>

          {/* Tools Grid Section */}
          <section className="py-20 relative">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              <div className="text-center mb-16">
                <h2
                  className="text-2xl sm:text-3xl font-extrabold tracking-tight mb-3 !text-white"
                  style={{ color: '#ffffff' }}
                >
                  All-In-One Free Growth &amp; Diagnostic Suite
                </h2>
                <p className="text-slate-400 text-sm max-w-xl mx-auto">
                  Select any tool below to run instant diagnostics. No credit card, no sign-up barrier.
                </p>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                {tools.map((tool) => (
                  <div
                    key={tool.id}
                    className="p-6 sm:p-8 rounded-3xl bg-[#1e1c1a] border border-white/10 hover:border-[#ff3b30]/40 transition-all duration-300 relative group flex flex-col justify-between shadow-xl"
                  >
                    <div>
                      {/* Card Header */}
                      <div className="flex items-center justify-between gap-4 mb-5">
                        <div className="w-12 h-12 rounded-2xl bg-gradient-to-tr from-[#ff3b30] to-orange-500 flex items-center justify-center text-white text-lg shadow-lg shadow-red-500/20 group-hover:scale-105 transition-transform">
                          <i className={`fas ${tool.icon}`}></i>
                        </div>
                        <span className="text-[10px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full bg-white/5 text-slate-300 border border-white/10">
                          {tool.badge}
                        </span>
                      </div>

                      <h3
                        className="text-xl font-black !text-white mb-2 group-hover:text-[#ff3b30] transition-colors"
                        style={{ color: '#ffffff' }}
                      >
                        {tool.title}
                      </h3>
                      <p className="text-slate-300 text-xs sm:text-sm leading-relaxed mb-6">
                        {tool.description}
                      </p>

                      {/* Feature Bullet Points */}
                      <div className="space-y-2 mb-8 border-t border-white/5 pt-5">
                        {tool.metrics.map((metric, idx) => (
                          <div key={idx} className="flex items-center gap-2 text-xs text-slate-300">
                            <i className="fas fa-check text-emerald-400 text-[10px]"></i>
                            <span>{metric}</span>
                          </div>
                        ))}
                      </div>
                    </div>

                    {/* Action Button */}
                    <div>
                      {tool.isAuditModal ? (
                        <button
                          type="button"
                          onClick={openAudit}
                          className="w-full py-3.5 px-5 rounded-2xl bg-white/5 hover:bg-[#ff3b30] text-white font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-all border border-white/10 hover:border-transparent cursor-pointer"
                        >
                          <span>{tool.ctaText}</span>
                          <i className="fas fa-arrow-right text-[10px]"></i>
                        </button>
                      ) : (
                        <Link
                          href={tool.link}
                          className="w-full py-3.5 px-5 rounded-2xl bg-white/5 hover:bg-[#ff3b30] text-white font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-all border border-white/10 hover:border-transparent text-center"
                        >
                          <span>{tool.ctaText}</span>
                          <i className="fas fa-arrow-right text-[10px]"></i>
                        </Link>
                      )}
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </section>

          {/* CTA Lead Card */}
          <section className="py-20 relative overflow-hidden">
            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
              <div className="p-8 sm:p-12 rounded-3xl bg-gradient-to-b from-[#22201e] to-[#1a1816] border border-[#ff3b30]/30 shadow-2xl relative">
                <div className="w-14 h-14 rounded-2xl bg-[#ff3b30]/10 text-[#ff3b30] flex items-center justify-center text-2xl mx-auto mb-6 border border-[#ff3b30]/30">
                  <i className="fas fa-chart-line"></i>
                </div>
                <h3
                  className="text-2xl sm:text-4xl font-black mb-4 !text-white"
                  style={{ color: '#ffffff' }}
                >
                  Need Page 1 Google Rankings or a High-Speed Redesign?
                </h3>
                <p className="text-slate-300 text-sm max-w-xl mx-auto mb-8 leading-relaxed">
                  Our principal engineers and technical SEO architects build custom full-stack web platforms and execute data-driven keyword ranking sprints.
                </p>
                <div className="flex flex-wrap items-center justify-center gap-4">
                  <button
                    type="button"
                    onClick={openInquiry}
                    className="px-8 py-4 rounded-2xl bg-[#ff3b30] hover:bg-[#e03126] text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-xl shadow-red-500/25 active:scale-95 cursor-pointer"
                  >
                    Schedule Free Strategy Session
                  </button>
                  <a
                    href="https://wa.me/919414790938?text=Hi%20Rankexa%20Team%2C%20I%20would%20like%20to%20discuss%20an%20SEO%20and%20Web%20Development%20project."
                    target="_blank"
                    rel="noopener noreferrer"
                    className="px-6 py-4 rounded-2xl bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 font-extrabold text-xs uppercase tracking-wider transition-all border border-emerald-500/30 flex items-center gap-2 cursor-pointer"
                  >
                    <i className="fab fa-whatsapp text-sm"></i>
                    <span>WhatsApp Direct (+91 94147 90938)</span>
                  </a>
                </div>
              </div>
            </div>
          </section>
        </div>
      )}
    </AppLayout>
  );
}
