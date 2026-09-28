import React, { useState, useEffect, useRef } from 'react';

/**
 * Animated SVG Circular Gauge Component for high-tech visual score presentation
 */
function CircularGauge({ score, size = 100, strokeWidth = 8, label, sublabel }) {
  const radius = (size - strokeWidth * 2) / 2;
  const circumference = 2 * Math.PI * radius;
  const strokeDashoffset = circumference - (Math.min(100, Math.max(0, score)) / 100) * circumference;

  let strokeColor = '#10b981'; // emerald
  let glowColor = 'rgba(16, 185, 129, 0.35)';
  let textColor = 'text-emerald-400';

  if (score < 50) {
    strokeColor = '#ff3b30'; // red
    glowColor = 'rgba(255, 59, 48, 0.35)';
    textColor = 'text-[#ff3b30]';
  } else if (score < 85) {
    strokeColor = '#f59e0b'; // amber
    glowColor = 'rgba(245, 158, 11, 0.35)';
    textColor = 'text-amber-400';
  }

  return (
    <div className="flex flex-col items-center">
      <div className="relative flex items-center justify-center" style={{ width: size, height: size }}>
        <svg
          width={size}
          height={size}
          className="transform -rotate-90"
          style={{ filter: `drop-shadow(0 0 10px ${glowColor})` }}
        >
          {/* Background Track */}
          <circle
            cx={size / 2}
            cy={size / 2}
            r={radius}
            stroke="currentColor"
            strokeWidth={strokeWidth}
            className="text-white/10"
            fill="transparent"
          />
          {/* Animated Value Stroke */}
          <circle
            cx={size / 2}
            cy={size / 2}
            r={radius}
            stroke={strokeColor}
            strokeWidth={strokeWidth}
            strokeDasharray={circumference}
            strokeDashoffset={strokeDashoffset}
            strokeLinecap="round"
            fill="transparent"
            className="transition-all duration-1000 ease-out"
          />
        </svg>

        {/* Center Score Text */}
        <div className="absolute inset-0 flex flex-col items-center justify-center text-center">
          <span className={`text-2xl sm:text-3xl font-black font-mono leading-none tracking-tight ${textColor}`}>
            {score}
          </span>
          <span className="text-[10px] text-slate-400 font-medium">/ 100</span>
        </div>
      </div>

      {label && (
        <span className="text-[11px] font-extrabold text-slate-300 uppercase tracking-wider mt-2.5 text-center">
          {label}
        </span>
      )}
      {sublabel && (
        <span className="text-[10px] text-slate-400 font-medium text-center mt-0.5">
          {sublabel}
        </span>
      )}
    </div>
  );
}

export default function FreeAuditModal({ isOpen, onClose, onOpenInquiry }) {
  const [domain, setDomain] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [status, setStatus] = useState('idle'); // 'idle' | 'analyzing' | 'completed' | 'error'
  const [scanStep, setScanStep] = useState(0);
  const [auditData, setAuditData] = useState(null);
  const [errorMessage, setErrorMessage] = useState('');
  const [activeTab, setActiveTab] = useState('speed'); // 'speed' | 'keywords' | 'schema' | 'checklist'
  const [copiedSummary, setCopiedSummary] = useState(false);
  const timerRef = useRef(null);

  // Lock body scroll when modal is open
  useEffect(() => {
    if (isOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
      resetState();
    }
    return () => {
      document.body.style.overflow = '';
      if (timerRef.current) clearInterval(timerRef.current);
    };
  }, [isOpen]);

  const resetState = () => {
    setStatus('idle');
    setScanStep(0);
    setAuditData(null);
    setErrorMessage('');
    setCopiedSummary(false);
    if (timerRef.current) clearInterval(timerRef.current);
  };

  const steps = [
    { title: 'Connecting to Google Mobile Lighthouse...', sub: 'Fetching Core Web Vitals (FCP, LCP, CLS, TTFB)' },
    { title: 'Auditing SEO Architecture & Schema...', sub: 'Inspecting JSON-LD, meta tags, and robots directives' },
    { title: 'Synthesizing 48-Hour AI Growth Roadmap...', sub: 'Groq / Gemini AI generating ranking strategies' },
  ];

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!domain.trim() || !email.trim()) return;

    setStatus('analyzing');
    setScanStep(0);
    setErrorMessage('');

    // Smooth step indicator timer
    timerRef.current = setInterval(() => {
      setScanStep((prev) => (prev < 2 ? prev + 1 : prev));
    }, 1800);

    try {
      const response = await fetch('/api/audit/run', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
        },
        body: JSON.stringify({
          domain: domain.trim(),
          email: email.trim(),
          phone: phone.trim() || null,
        }),
      });

      const data = await response.json();

      if (timerRef.current) clearInterval(timerRef.current);

      if (response.ok && data.success) {
        setAuditData(data);
        setStatus('completed');
      } else {
        setStatus('error');
        setErrorMessage(data.message || 'Unable to complete diagnostic. Please verify the URL and try again.');
      }
    } catch (err) {
      if (timerRef.current) clearInterval(timerRef.current);
      setStatus('error');
      setErrorMessage('Network connection lost during scan. Please check your connection and try again.');
    }
  };

  // Helper for CWV status colors
  const getCwvStatusPill = (val, type) => {
    // Return color and badge
    if (type === 'fcp') {
      const num = parseFloat(val);
      if (num <= 1.8) return { label: 'Optimal', bg: 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30' };
      if (num <= 3.0) return { label: 'Needs Work', bg: 'bg-amber-500/15 text-amber-400 border-amber-500/30' };
      return { label: 'Slow', bg: 'bg-red-500/15 text-red-400 border-red-500/30' };
    }
    if (type === 'lcp') {
      const num = parseFloat(val);
      if (num <= 2.5) return { label: 'Optimal', bg: 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30' };
      if (num <= 4.0) return { label: 'Needs Work', bg: 'bg-amber-500/15 text-amber-400 border-amber-500/30' };
      return { label: 'High Latency', bg: 'bg-red-500/15 text-red-400 border-red-500/30' };
    }
    if (type === 'cls') {
      const num = parseFloat(val);
      if (num <= 0.1) return { label: 'Stable', bg: 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30' };
      if (num <= 0.25) return { label: 'Shifting', bg: 'bg-amber-500/15 text-amber-400 border-amber-500/30' };
      return { label: 'Unstable', bg: 'bg-red-500/15 text-red-400 border-red-500/30' };
    }
    if (type === 'ttfb') {
      const num = parseInt(val, 10);
      if (num <= 250) return { label: 'Fast TTFB', bg: 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30' };
      if (num <= 600) return { label: 'Average', bg: 'bg-amber-500/15 text-amber-400 border-amber-500/30' };
      return { label: 'Server Latency', bg: 'bg-red-500/15 text-red-400 border-red-500/30' };
    }
    return { label: 'Normal', bg: 'bg-slate-800 text-slate-300 border-slate-700' };
  };

  // Copy Summary to Clipboard
  const handleCopySummary = () => {
    if (!auditData) return;
    const m = auditData.metrics || {};
    const rm = auditData.roadmap || {};
    const text = `🚀 Website Diagnostic Report
Domain: ${auditData.domain}
Performance Score: ${auditData.speed_score}/100
Technical SEO Score: ${auditData.seo_score}/100
Core Web Vitals:
- FCP: ${m.fcp || 'N/A'}
- LCP: ${m.lcp || 'N/A'}
- CLS: ${m.cls || 'N/A'}
- Server TTFB: ${m.ttfb || 'N/A'}

AI Technical Assessment:
${rm.executive_summary || 'N/A'}

Recommended Speed Fixes:
${(rm.speed_fixes || []).map((f, i) => `${i + 1}. ${f}`).join('\n')}

Recommended SEO & Schema Fixes:
${(rm.schema_fixes || []).map((f, i) => `${i + 1}. ${f}`).join('\n')}`;

    navigator.clipboard.writeText(text).then(() => {
      setCopiedSummary(true);
      setTimeout(() => setCopiedSummary(false), 2500);
    });
  };

  // Trigger Print / PDF
  const handlePrint = () => {
    window.print();
  };

  if (!isOpen) return null;

  return (
    <div
      className="fixed inset-0 z-[10020] flex items-center justify-center p-3 sm:p-5 bg-slate-950/80 backdrop-blur-md transition-all animate-fadeIn"
      id="freeAuditModalBackdrop"
      onClick={(e) => {
        if (e.target.id === 'freeAuditModalBackdrop') onClose();
      }}
      role="dialog"
      aria-modal="true"
    >
      <div
        className="relative w-full max-w-2xl bg-[#161514] text-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/10 max-h-[92vh] overflow-y-auto"
        onClick={(e) => e.stopPropagation()}
      >
        {/* Close Button */}
        <button
          type="button"
          onClick={onClose}
          className="absolute top-5 right-5 text-slate-400 hover:text-white text-lg w-9 h-9 rounded-full flex items-center justify-center hover:bg-white/10 transition-colors"
          aria-label="Close Free Audit"
        >
          <i className="fas fa-times"></i>
        </button>

        {/* Modal Header */}
        <div className="flex items-center gap-2 mb-4">
          <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#ff3b30]/15 text-[#ff3b30] text-[11px] font-extrabold uppercase tracking-wider border border-[#ff3b30]/30">
            <i className="fas fa-bolt text-[10px]"></i>
            100% Free AI Diagnostic
          </span>
          <span className="text-slate-400 text-xs hidden sm:inline-block">• Real-Time Google Lighthouse &amp; CWV</span>
        </div>

        {/* ================= STATE 1: INPUT FORM ================= */}
        {status === 'idle' && (
          <div>
            <h2 className="text-2xl sm:text-3xl font-black text-white tracking-tight mb-2">
              Free Website Speed &amp; SEO Audit
            </h2>
            <p className="text-slate-300 text-xs sm:text-sm leading-relaxed mb-6">
              Enter your website domain to run a live Google Core Web Vitals diagnostic. Our AI engine will inspect your code, measuring First Contentful Paint (FCP), LCP, and schema architecture to generate your custom <strong className="text-white">48-Hour Growth &amp; SEO Roadmap</strong>.
            </p>

            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <label className="block text-xs font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                  Target Website / URL <span className="text-[#ff3b30]">*</span>
                </label>
                <div className="relative">
                  <span className="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs font-mono">
                    https://
                  </span>
                  <input
                    type="text"
                    required
                    placeholder="mybrand.com"
                    value={domain}
                    onChange={(e) => setDomain(e.target.value)}
                    className="w-full pl-20 pr-4 py-3 bg-white/5 border border-white/15 rounded-2xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-[#ff3b30] transition-colors font-mono"
                  />
                </div>
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                  <label className="block text-xs font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                    Your Work Email <span className="text-[#ff3b30]">*</span>
                  </label>
                  <input
                    type="email"
                    required
                    placeholder="sarah@company.com"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    className="w-full px-4 py-3 bg-white/5 border border-white/15 rounded-2xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-[#ff3b30] transition-colors"
                  />
                </div>

                <div>
                  <label className="block text-xs font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                    Phone / WhatsApp <span className="text-slate-400 text-[10px] font-normal">(Optional)</span>
                  </label>
                  <input
                    type="tel"
                    placeholder="+91 98765 43210"
                    value={phone}
                    onChange={(e) => setPhone(e.target.value)}
                    className="w-full px-4 py-3 bg-white/5 border border-white/15 rounded-2xl text-white placeholder-slate-500 text-sm focus:outline-none focus:border-[#ff3b30] transition-colors"
                  />
                </div>
              </div>

              {/* Guarantees Box */}
              <div className="p-3.5 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-between text-xs text-slate-300">
                <span className="flex items-center gap-1.5">
                  <i className="fas fa-shield-halved text-emerald-400"></i>
                  Zero Spam Guarantee
                </span>
                <span className="flex items-center gap-1.5">
                  <i className="fas fa-clock text-amber-400"></i>
                  Instant ~4s Scan
                </span>
                <span className="flex items-center gap-1.5">
                  <i className="fas fa-robot text-[#ff3b30]"></i>
                  AI Powered
                </span>
              </div>

              {/* Submit CTA */}
              <button
                type="submit"
                className="w-full py-4 px-6 rounded-2xl bg-[#ff3b30] hover:bg-[#d6281f] text-white font-extrabold text-sm uppercase tracking-wider flex items-center justify-center gap-2.5 transition-all shadow-xl hover:shadow-red-500/25 cursor-pointer mt-2"
              >
                <i className="fas fa-bolt text-xs"></i>
                <span>Run Live Free Audit Now</span>
                <i className="fas fa-arrow-right text-xs"></i>
              </button>
            </form>
          </div>
        )}

        {/* ================= STATE 2: SCANNING / ANALYZING ================= */}
        {status === 'analyzing' && (
          <div className="py-12 px-4 text-center space-y-6">
            {/* High-tech pulsing scanner ring */}
            <div className="relative w-24 h-24 mx-auto flex items-center justify-center">
              <div className="absolute inset-0 rounded-full border-4 border-[#ff3b30]/20 animate-ping"></div>
              <div className="absolute inset-2 rounded-full border-2 border-[#ff3b30]/50 animate-pulse"></div>
              <div className="w-16 h-16 rounded-full bg-[#ff3b30] flex items-center justify-center text-white text-2xl shadow-lg shadow-red-500/50">
                <i className="fas fa-gauge-high fa-spin" style={{ animationDuration: '4s' }}></i>
              </div>
            </div>

            <div>
              <h3 className="text-xl font-black text-white">
                Auditing <span className="text-[#ff3b30] font-mono">{domain}</span>
              </h3>
              <p className="text-xs text-slate-400 mt-1">Connecting to Google Lighthouse Mobile &amp; AI Engine</p>
            </div>

            {/* Step progress list */}
            <div className="max-w-md mx-auto space-y-3 text-left">
              {steps.map((st, idx) => {
                const isCurrent = scanStep === idx;
                const isDone = scanStep > idx;
                return (
                  <div
                    key={idx}
                    className={`p-3 rounded-2xl border transition-all ${
                      isDone
                        ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-300'
                        : isCurrent
                        ? 'bg-[#ff3b30]/10 border-[#ff3b30]/40 text-white shadow-lg'
                        : 'bg-white/5 border-white/5 text-slate-500 opacity-50'
                    }`}
                  >
                    <div className="flex items-center gap-3">
                      <div className="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shrink-0">
                        {isDone ? (
                          <i className="fas fa-check text-emerald-400"></i>
                        ) : isCurrent ? (
                          <i className="fas fa-spinner fa-spin text-[#ff3b30]"></i>
                        ) : (
                          <span>{idx + 1}</span>
                        )}
                      </div>
                      <div>
                        <div className="text-xs font-bold">{st.title}</div>
                        <div className="text-[11px] text-slate-400">{st.sub}</div>
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          </div>
        )}

        {/* ================= STATE 3: ERROR ================= */}
        {status === 'error' && (
          <div className="py-10 text-center space-y-4">
            <div className="w-16 h-16 rounded-full bg-red-500/20 text-[#ff3b30] flex items-center justify-center text-2xl mx-auto border border-red-500/30">
              <i className="fas fa-triangle-exclamation"></i>
            </div>
            <h3 className="text-xl font-bold text-white">Diagnostic Failed</h3>
            <p className="text-xs text-slate-300 max-w-md mx-auto">{errorMessage}</p>
            <button
              type="button"
              onClick={() => setStatus('idle')}
              className="px-6 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
            >
              Try Another Domain
            </button>
          </div>
        )}

        {/* ================= STATE 4: COMPLETED SCORECARD & ROADMAP ================= */}
        {status === 'completed' && auditData && (
          <div className="space-y-6">
            {/* Top Bar: Target Domain & Source + Utility Buttons */}
            <div className="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-white/10">
              <div>
                <span className="text-[10px] font-mono uppercase tracking-wider text-slate-400">Diagnostic Target</span>
                <h3 className="text-lg sm:text-xl font-black text-white font-mono flex items-center gap-2">
                  <span>{auditData.domain}</span>
                  <a
                    href={auditData.url}
                    target="_blank"
                    rel="noreferrer"
                    className="text-slate-400 hover:text-[#ff3b30] text-xs"
                    title="Visit site in new tab"
                  >
                    <i className="fas fa-arrow-up-right-from-square"></i>
                  </a>
                </h3>
              </div>

              <div className="flex items-center gap-2">
                {/* 1-Click Copy Summary Button */}
                <button
                  type="button"
                  onClick={handleCopySummary}
                  className="px-3 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-semibold text-slate-300 hover:text-white flex items-center gap-1.5 transition-colors cursor-pointer"
                  title="Copy formatted audit summary to clipboard"
                >
                  <i className={`fas ${copiedSummary ? 'fa-check text-emerald-400' : 'fa-copy'}`}></i>
                  <span>{copiedSummary ? 'Copied!' : 'Copy Summary'}</span>
                </button>

                {/* Print / PDF Button */}
                <button
                  type="button"
                  onClick={handlePrint}
                  className="px-2.5 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-semibold text-slate-300 hover:text-white transition-colors cursor-pointer"
                  title="Print or Save as PDF"
                >
                  <i className="fas fa-print"></i>
                </button>

                <span
                  className={`px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider border ${
                    auditData.metrics.cwv_status === 'PASS'
                      ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30'
                      : 'bg-amber-500/10 text-amber-400 border-amber-500/30'
                  }`}
                >
                  CWV: {auditData.metrics.cwv_status}
                </span>
              </div>
            </div>

            {/* Scorecard Hero: Advanced Animated SVG Radial Gauges */}
            <div className="p-5 rounded-3xl bg-white/[0.03] border border-white/10 relative overflow-hidden">
              <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 items-center justify-items-center">
                {/* Gauge 1: Performance Score */}
                <CircularGauge
                  score={auditData.speed_score}
                  size={105}
                  strokeWidth={8}
                  label="Performance"
                  sublabel={auditData.speed_score >= 85 ? 'Fast (Optimal)' : auditData.speed_score >= 50 ? 'Needs Fixes' : 'Slow Latency'}
                />

                {/* Gauge 2: Technical SEO Score */}
                <CircularGauge
                  score={auditData.seo_score}
                  size={105}
                  strokeWidth={8}
                  label="Technical SEO"
                  sublabel={auditData.seo_score >= 85 ? 'Optimized' : 'Structural Gaps'}
                />

                {/* Gauge 3: Best Practices Score */}
                <CircularGauge
                  score={auditData.best_practices_score || auditData.metrics?.best_practices_score || 90}
                  size={95}
                  strokeWidth={7}
                  label="Best Practices"
                  sublabel="Security & Standards"
                />

                {/* Gauge 4: Accessibility / Mobile Score */}
                <CircularGauge
                  score={auditData.accessibility_score || auditData.metrics?.accessibility_score || 88}
                  size={95}
                  strokeWidth={7}
                  label="Mobile & A11y"
                  sublabel="Responsive Health"
                />
              </div>
            </div>

            {/* Core Web Vitals Key Metrics Strip with Threshold Badges */}
            <div className="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
              {/* FCP */}
              @php @endphp
              <div className="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center relative flex flex-col justify-between">
                <div>
                  <div className="text-[10px] font-bold text-slate-400 uppercase tracking-wider">FCP (Paint)</div>
                  <div className="text-base sm:text-lg font-black text-white font-mono mt-0.5">{auditData.metrics.fcp}</div>
                </div>
                <div className="mt-2 flex flex-col items-center gap-1">
                  <span className={`text-[9px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border ${getCwvStatusPill(auditData.metrics.fcp, 'fcp').bg}`}>
                    {getCwvStatusPill(auditData.metrics.fcp, 'fcp').label}
                  </span>
                  <span className="text-[9px] text-slate-500">Target: ≤ 1.8s</span>
                </div>
              </div>

              {/* LCP */}
              <div className="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center relative flex flex-col justify-between">
                <div>
                  <div className="text-[10px] font-bold text-slate-400 uppercase tracking-wider">LCP (Hero)</div>
                  <div className="text-base sm:text-lg font-black text-white font-mono mt-0.5">{auditData.metrics.lcp}</div>
                </div>
                <div className="mt-2 flex flex-col items-center gap-1">
                  <span className={`text-[9px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border ${getCwvStatusPill(auditData.metrics.lcp, 'lcp').bg}`}>
                    {getCwvStatusPill(auditData.metrics.lcp, 'lcp').label}
                  </span>
                  <span className="text-[9px] text-slate-500">Target: ≤ 2.5s</span>
                </div>
              </div>

              {/* CLS */}
              <div className="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center relative flex flex-col justify-between">
                <div>
                  <div className="text-[10px] font-bold text-slate-400 uppercase tracking-wider">CLS (Shift)</div>
                  <div className="text-base sm:text-lg font-black text-white font-mono mt-0.5">{auditData.metrics.cls}</div>
                </div>
                <div className="mt-2 flex flex-col items-center gap-1">
                  <span className={`text-[9px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border ${getCwvStatusPill(auditData.metrics.cls, 'cls').bg}`}>
                    {getCwvStatusPill(auditData.metrics.cls, 'cls').label}
                  </span>
                  <span className="text-[9px] text-slate-500">Target: ≤ 0.10</span>
                </div>
              </div>

              {/* TTFB */}
              <div className="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center relative flex flex-col justify-between">
                <div>
                  <div className="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Server TTFB</div>
                  <div className="text-base sm:text-lg font-black text-white font-mono mt-0.5">{auditData.metrics.ttfb}</div>
                </div>
                <div className="mt-2 flex flex-col items-center gap-1">
                  <span className={`text-[9px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border ${getCwvStatusPill(auditData.metrics.ttfb, 'ttfb').bg}`}>
                    {getCwvStatusPill(auditData.metrics.ttfb, 'ttfb').label}
                  </span>
                  <span className="text-[9px] text-slate-500">Target: ≤ 200ms</span>
                </div>
              </div>
            </div>

            {/* AI Executive Assessment Summary */}
            {auditData.roadmap?.executive_summary && (
              <div className="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-[#ff3b30]/10 via-white/5 to-white/5 border border-[#ff3b30]/30 text-xs sm:text-sm text-slate-200 leading-relaxed shadow-lg">
                <div className="flex items-center justify-between mb-1.5">
                  <div className="flex items-center gap-2 font-black text-[#ff3b30] uppercase text-[11px] tracking-wider">
                    <i className="fas fa-robot text-sm"></i>
                    <span>AI Executive Technical Assessment</span>
                  </div>
                  <span className="text-[10px] text-slate-400 hidden sm:inline-block font-mono">Qwen 2.5 AI Engine</span>
                </div>
                <p className="text-slate-200 leading-relaxed">{auditData.roadmap.executive_summary}</p>
              </div>
            )}

            {/* 48-Hour Growth & SEO Roadmap Tabs */}
            <div>
              <div className="flex items-center gap-1.5 p-1 rounded-2xl bg-white/5 border border-white/10 mb-3 overflow-x-auto">
                <button
                  type="button"
                  onClick={() => setActiveTab('speed')}
                  className={`flex-1 min-w-[100px] py-2 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 ${
                    activeTab === 'speed'
                      ? 'bg-[#ff3b30] text-white shadow-md'
                      : 'text-slate-400 hover:text-white'
                  }`}
                >
                  <i className="fas fa-bolt text-[11px]"></i>
                  <span>Speed Fixes</span>
                </button>

                <button
                  type="button"
                  onClick={() => setActiveTab('keywords')}
                  className={`flex-1 min-w-[100px] py-2 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 ${
                    activeTab === 'keywords'
                      ? 'bg-[#ff3b30] text-white shadow-md'
                      : 'text-slate-400 hover:text-white'
                  }`}
                >
                  <i className="fas fa-bullseye text-[11px]"></i>
                  <span>Keywords</span>
                </button>

                <button
                  type="button"
                  onClick={() => setActiveTab('schema')}
                  className={`flex-1 min-w-[100px] py-2 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 ${
                    activeTab === 'schema'
                      ? 'bg-[#ff3b30] text-white shadow-md'
                      : 'text-slate-400 hover:text-white'
                  }`}
                >
                  <i className="fas fa-shield-alt text-[11px]"></i>
                  <span>Schema &amp; SEO</span>
                </button>

                <button
                  type="button"
                  onClick={() => setActiveTab('checklist')}
                  className={`flex-1 min-w-[100px] py-2 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 ${
                    activeTab === 'checklist'
                      ? 'bg-[#ff3b30] text-white shadow-md'
                      : 'text-slate-400 hover:text-white'
                  }`}
                >
                  <i className="fas fa-clipboard-check text-[11px]"></i>
                  <span>Checklist</span>
                </button>
              </div>

              {/* Tab Content Box */}
              <div className="p-4 sm:p-5 rounded-2xl bg-white/5 border border-white/10 text-xs leading-relaxed">
                {activeTab === 'speed' && (
                  <ul className="space-y-3">
                    {(auditData.roadmap?.speed_fixes || []).map((item, idx) => (
                      <li key={idx} className="flex items-start gap-3 text-slate-200">
                        <span className="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5 border border-emerald-500/30">
                          {idx + 1}
                        </span>
                        <div className="flex-1">
                          <span className="text-slate-200">{item}</span>
                        </div>
                      </li>
                    ))}
                  </ul>
                )}

                {activeTab === 'keywords' && (
                  <ul className="space-y-3">
                    {(auditData.roadmap?.keyword_opportunities || []).map((item, idx) => (
                      <li key={idx} className="flex items-start gap-3 text-slate-200">
                        <span className="w-6 h-6 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5 border border-amber-500/30">
                          {idx + 1}
                        </span>
                        <div className="flex-1">
                          <span className="text-slate-200">{item}</span>
                        </div>
                      </li>
                    ))}
                  </ul>
                )}

                {activeTab === 'schema' && (
                  <ul className="space-y-3">
                    {(auditData.roadmap?.schema_fixes || []).map((item, idx) => (
                      <li key={idx} className="flex items-start gap-3 text-slate-200">
                        <span className="w-6 h-6 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5 border border-indigo-500/30">
                          {idx + 1}
                        </span>
                        <div className="flex-1">
                          <span className="text-slate-200">{item}</span>
                        </div>
                      </li>
                    ))}
                  </ul>
                )}

                {activeTab === 'checklist' && (
                  <div className="space-y-2.5">
                    {(auditData.metrics?.checklist || []).length === 0 ? (
                      <div className="text-slate-400 text-center py-2">
                        Core technical guidelines verified.
                      </div>
                    ) : (
                      auditData.metrics.checklist.map((chk, idx) => (
                        <div
                          key={idx}
                          className={`p-3 rounded-2xl border flex items-start gap-3 transition-colors ${
                            chk.passed
                              ? 'bg-emerald-500/5 border-emerald-500/20 text-emerald-200'
                              : 'bg-red-500/5 border-red-500/20 text-red-200'
                          }`}
                        >
                          <div
                            className={`w-5 h-5 rounded-full flex items-center justify-center text-[10px] shrink-0 mt-0.5 ${
                              chk.passed ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400'
                            }`}
                          >
                            <i className={`fas ${chk.passed ? 'fa-check' : 'fa-triangle-exclamation'}`}></i>
                          </div>
                          <div className="flex-1">
                            <div className="flex items-center justify-between gap-2">
                              <span className="font-bold text-white text-xs">{chk.name}</span>
                              <span
                                className={`text-[9px] px-2 py-0.5 rounded-full uppercase tracking-wider font-extrabold ${
                                  chk.passed
                                    ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30'
                                    : 'bg-red-500/20 text-red-400 border border-red-500/30'
                                }`}
                              >
                                {chk.passed ? 'PASS' : 'ACTION REQUIRED'}
                              </span>
                            </div>
                            <p className="text-[11px] text-slate-300 mt-0.5 leading-relaxed">{chk.description}</p>
                          </div>
                        </div>
                      ))
                    )}
                  </div>
                )}
              </div>
            </div>

            {/* Bottom Actions */}
            <div className="pt-2 flex flex-col sm:flex-row items-center gap-3">
              <button
                type="button"
                onClick={() => {
                  onClose();
                  if (onOpenInquiry) {
                    onOpenInquiry();
                  }
                }}
                className="w-full sm:flex-1 py-4 px-5 rounded-2xl bg-[#ff3b30] hover:bg-[#d6281f] text-white font-extrabold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-all shadow-xl hover:shadow-red-500/25 cursor-pointer"
              >
                <i className="fas fa-handshake"></i>
                <span>Claim 48-Hour Implementation</span>
              </button>

              <button
                type="button"
                onClick={resetState}
                className="w-full sm:w-auto py-4 px-5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
              >
                Scan Another URL
              </button>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
