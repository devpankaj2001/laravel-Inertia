import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

/**
 * Animated SVG Circular Gauge for Domain Authority
 */
function CircularAuthorityGauge({ score, max = 100, size = 110, strokeWidth = 8, label, sublabel }) {
  const radius = (size - strokeWidth * 2) / 2;
  const circumference = 2 * Math.PI * radius;
  const strokeDashoffset = circumference - (Math.min(max, Math.max(0, score)) / max) * circumference;

  let strokeColor = '#10b981'; // green
  let glowColor = 'rgba(16, 185, 129, 0.35)';
  let textColor = 'text-emerald-400';

  if (score < 30) {
    strokeColor = '#ff3b30';
    glowColor = 'rgba(255, 59, 48, 0.35)';
    textColor = 'text-[#ff3b30]';
  } else if (score < 60) {
    strokeColor = '#f59e0b';
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
          <circle
            cx={size / 2}
            cy={size / 2}
            r={radius}
            stroke="currentColor"
            strokeWidth={strokeWidth}
            className="text-white/10"
            fill="transparent"
          />
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

        <div className="absolute inset-0 flex flex-col items-center justify-center text-center">
          <span className={`text-2xl sm:text-3xl font-black font-mono leading-none tracking-tight ${textColor}`}>
            {score}
          </span>
          <span className="text-[10px] text-slate-400 font-medium">/ {max}</span>
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

export default function BacklinkChecker({ seo }) {
  const [domain, setDomain] = useState('');
  const [email, setEmail] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState('');
  const [result, setResult] = useState(null);

  const performAudit = async (targetDomain, targetEmail) => {
    if (!targetDomain.trim()) {
      setErrorMsg('Please enter a target domain name.');
      return;
    }

    setErrorMsg('');
    setIsLoading(true);
    setResult(null);

    try {
      const response = await fetch('/api/tools/check-backlinks', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          domain: targetDomain.trim(),
          email: (targetEmail || email).trim() || undefined,
        }),
      });

      const data = await response.json();
      if (!response.ok || !data.success) {
        throw new Error(data.message || 'Failed to analyze backlinks. Please try again.');
      }

      setResult(data.data);
    } catch (err) {
      setErrorMsg(err.message || 'An error occurred while auditing backlinks.');
    } finally {
      setIsLoading(false);
    }
  };

  const handleAudit = (e) => {
    if (e) e.preventDefault();
    performAudit(domain, email);
  };

  React.useEffect(() => {
    if (typeof window !== 'undefined') {
      const params = new URLSearchParams(window.location.search);
      const urlDomain = (params.get('domain') || params.get('q') || '').trim();
      if (urlDomain) {
        setDomain(urlDomain);
        performAudit(urlDomain, email);
      }
    }
  }, []);

  return (
    <AppLayout seo={seo}>
      {({ openInquiry, openAudit }) => (
        <div className="bg-[#161514] text-white min-h-screen">
          {/* Hero & Search Header */}
          <section className="relative pt-32 pb-16 overflow-hidden border-b border-white/10">
            <div className="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[300px] bg-amber-600/15 rounded-full blur-[140px] pointer-events-none"></div>

            <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
              <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300 mb-6 backdrop-blur-sm">
                <span className="w-2 h-2 rounded-full bg-[#ff3b30] animate-pulse"></span>
                <span>FREE DOMAIN AUTHORITY &amp; BACKLINK PROFILE AUDITOR</span>
              </div>

              <h1
                className="text-3xl sm:text-5xl font-black tracking-tight leading-tight mb-4 !text-white"
                style={{ color: '#ffffff' }}
              >
                <span style={{ color: '#ffffff' }}>Free Backlink &amp; </span>
                <span className="bg-gradient-to-r from-amber-400 via-orange-400 to-[#ff3b30] bg-clip-text text-transparent">
                  Domain Authority Checker
                </span>
              </h1>

              <p className="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed mb-8">
                Analyze your website Domain Authority (DA), PageRank, Dofollow vs Nofollow ratio, and uncover high-impact link opportunities with AI.
              </p>

              {/* Input Card */}
              <div className="p-6 sm:p-8 rounded-3xl bg-[#1e1c1a] border border-white/10 shadow-2xl text-left max-w-3xl mx-auto">
                <form onSubmit={handleAudit} className="space-y-4">
                  <div className="grid grid-cols-1 sm:grid-cols-12 gap-3">
                    <div className="sm:col-span-7">
                      <label className="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                        Domain URL
                      </label>
                      <div className="relative">
                        <i className="fas fa-globe absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                        <input
                          type="text"
                          required
                          value={domain}
                          onChange={(e) => setDomain(e.target.value)}
                          placeholder="e.g. rankexa.in or clientbrand.com"
                          className="w-full bg-[#141312] border border-white/10 focus:border-[#ff3b30] text-white text-xs sm:text-sm pl-9 pr-3 py-3 rounded-xl outline-none transition-colors"
                        />
                      </div>
                    </div>

                    <div className="sm:col-span-5">
                      <label className="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                        Email Address <span className="text-slate-500 font-normal">(Optional)</span>
                      </label>
                      <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        placeholder="you@company.com"
                        className="w-full bg-[#141312] border border-white/10 focus:border-white/30 text-white text-xs sm:text-sm px-3.5 py-3 rounded-xl outline-none transition-colors"
                      />
                    </div>
                  </div>

                  <div className="flex items-center justify-end pt-2">
                    <button
                      type="submit"
                      disabled={isLoading}
                      className="w-full sm:w-auto px-8 py-3 rounded-xl bg-[#ff3b30] hover:bg-[#e03126] text-white font-extrabold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-lg shadow-red-500/25 active:scale-95 disabled:opacity-50 cursor-pointer"
                    >
                      {isLoading ? (
                        <>
                          <i className="fas fa-spinner fa-spin"></i>
                          <span>Auditing Backlink Graph...</span>
                        </>
                      ) : (
                        <>
                          <i className="fas fa-link"></i>
                          <span>Audit Backlinks &amp; Authority</span>
                        </>
                      )}
                    </button>
                  </div>
                </form>

                {errorMsg && (
                  <div className="mt-4 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs flex items-center gap-2">
                    <i className="fas fa-triangle-exclamation"></i>
                    <span>{errorMsg}</span>
                  </div>
                )}
              </div>
            </div>
          </section>

          {/* Loading Radar Animation */}
          {isLoading && (
            <div className="max-w-4xl mx-auto px-4 py-16 text-center">
              <div className="relative w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                <div className="absolute inset-0 rounded-full border-4 border-amber-500/20 animate-ping"></div>
                <div className="w-16 h-16 rounded-full border-4 border-amber-500 border-t-transparent animate-spin flex items-center justify-center">
                  <i className="fas fa-link text-amber-500"></i>
                </div>
              </div>
              <h3 className="text-xl font-black mb-2 !text-white" style={{ color: '#ffffff' }}>Analyzing Domain Authority &amp; Web Graph...</h3>
              <p className="text-slate-400 text-xs max-w-md mx-auto">
                Calculating PageRank, evaluating Dofollow equity ratios, and consulting Groq AI for high-authority link strategies.
              </p>
            </div>
          )}

          {/* Diagnostic Results Section */}
          {result && !isLoading && (
            <section className="py-12 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
              {/* Header Strip */}
              <div className="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-white/10">
                <div>
                  <span className="text-[10px] font-mono uppercase tracking-wider text-slate-400">Target Web Entity</span>
                  <h2 className="text-2xl sm:text-3xl font-black text-white font-mono flex items-center gap-2 !text-white" style={{ color: '#ffffff' }}>
                    <span style={{ color: '#ffffff' }}>{result.domain}</span>
                  </h2>
                </div>
                <div className="flex items-center gap-2">
                  <span className="text-[11px] font-mono text-slate-400 bg-white/5 px-3 py-1 rounded-full border border-white/10">
                    Global Rank: {result.global_rank}
                  </span>
                </div>
              </div>

              {/* Authority Metrics Scorecard (Radial Gauges) */}
              <div className="p-6 rounded-3xl bg-[#1e1c1a] border border-white/10 shadow-2xl">
                <div className="grid grid-cols-2 sm:grid-cols-4 gap-6 items-center justify-items-center">
                  <CircularAuthorityGauge
                    score={result.domain_authority}
                    max={100}
                    label="Domain Authority"
                    sublabel={result.domain_authority >= 60 ? 'High Authority' : result.domain_authority >= 30 ? 'Growing Profile' : 'Foundational'}
                  />

                  <CircularAuthorityGauge
                    score={Math.round(result.page_rank * 10)}
                    max={100}
                    label="Open PageRank"
                    sublabel={`Score: ${result.page_rank} / 10`}
                  />

                  <div className="flex flex-col items-center text-center">
                    <div className="w-[110px] h-[110px] rounded-full bg-white/5 border border-white/10 flex flex-col items-center justify-center">
                      <span className="text-2xl font-black text-white font-mono">{result.referring_domains_est}</span>
                      <span className="text-[10px] text-slate-400">Referring Sites</span>
                    </div>
                    <span className="text-[11px] font-extrabold text-slate-300 uppercase tracking-wider mt-2.5">
                      Referring Domains
                    </span>
                    <span className="text-[10px] text-slate-400 mt-0.5">~{result.total_backlinks_est} Backlinks</span>
                  </div>

                  <div className="flex flex-col items-center text-center">
                    <div className="w-[110px] h-[110px] rounded-full bg-emerald-500/10 border border-emerald-500/30 flex flex-col items-center justify-center">
                      <i className="fas fa-shield-halved text-emerald-400 text-2xl mb-1"></i>
                      <span className="text-xs font-bold text-emerald-300">{result.toxic_risk}</span>
                    </div>
                    <span className="text-[11px] font-extrabold text-slate-300 uppercase tracking-wider mt-2.5">
                      Toxic Link Risk
                    </span>
                    <span className="text-[10px] text-slate-400 mt-0.5">Spam &amp; Penalty Check</span>
                  </div>
                </div>
              </div>

              {/* Dofollow vs Nofollow Ratio Bar */}
              <div className="p-6 rounded-3xl bg-[#1e1c1a] border border-white/10">
                <div className="flex items-center justify-between text-xs font-bold mb-2">
                  <span className="text-emerald-400">Dofollow Equity: {result.dofollow_ratio}%</span>
                  <span className="text-slate-400">Nofollow / Sponsored: {result.nofollow_ratio}%</span>
                </div>
                <div className="w-full h-3 rounded-full bg-white/10 overflow-hidden flex">
                  <div
                    className="h-full bg-emerald-500 transition-all duration-1000"
                    style={{ width: `${result.dofollow_ratio}%` }}
                  ></div>
                  <div
                    className="h-full bg-slate-600 transition-all duration-1000"
                    style={{ width: `${result.nofollow_ratio}%` }}
                  ></div>
                </div>
                <p className="text-[11px] text-slate-400 mt-2">
                  Healthy link profiles maintain between 65% and 85% Dofollow links to pass PageRank equity naturally without algorithmic suspicion.
                </p>
              </div>

              {/* Sample Referring Domains Table */}
              {result.sample_links && result.sample_links.length > 0 && (
                <div className="p-6 rounded-3xl bg-[#1e1c1a] border border-white/10">
                  <h3 className="text-base font-extrabold text-white mb-4 flex items-center gap-2">
                    <i className="fas fa-network-wired text-[#ff3b30]"></i>
                    <span>Sample Live Referring Domains &amp; Link Equity</span>
                  </h3>
                  <div className="overflow-x-auto">
                    <table className="w-full text-left text-xs border-collapse">
                      <thead>
                        <tr className="border-b border-white/10 text-slate-400 font-mono uppercase tracking-wider">
                          <th className="py-2.5 px-3">Referring Source</th>
                          <th className="py-2.5 px-3">Anchor Text</th>
                          <th className="py-2.5 px-3">Source DA</th>
                          <th className="py-2.5 px-3">Link Type</th>
                        </tr>
                      </thead>
                      <tbody className="divide-y divide-white/5 text-slate-300">
                        {result.sample_links.map((link, idx) => (
                          <tr key={idx} className="hover:bg-white/5 transition-colors">
                            <td className="py-3 px-3 font-semibold text-white">
                              <div className="truncate max-w-[200px] sm:max-w-xs">{link.source_domain}</div>
                            </td>
                            <td className="py-3 px-3 text-slate-300">
                              <span className="font-mono bg-white/5 px-2 py-0.5 rounded text-[11px]">"{link.anchor}"</span>
                            </td>
                            <td className="py-3 px-3">
                              <span className="px-2 py-0.5 rounded font-black text-[11px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                DA {link.source_da}
                              </span>
                            </td>
                            <td className="py-3 px-3">
                              <span className={`px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider ${
                                link.type === 'Dofollow'
                                  ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30'
                                  : 'bg-white/10 text-slate-300'
                              }`}>
                                {link.type}
                              </span>
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>
              )}

              {/* AI Link Building Strategies */}
              {result.opportunities && result.opportunities.length > 0 && (
                <div className="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-amber-500/10 via-[#1e1c1a] to-[#1e1c1a] border border-amber-500/30 shadow-xl">
                  <div className="flex items-center justify-between mb-4">
                    <div className="flex items-center gap-2 font-black text-amber-400 uppercase text-xs tracking-wider">
                      <i className="fas fa-rocket text-sm"></i>
                      <span>AI High-Impact Backlink Opportunities for {result.domain}</span>
                    </div>
                    <span className="text-[10px] text-slate-400 font-mono hidden sm:inline-block">Groq Llama 3.3 Engine</span>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {result.opportunities.map((opp, idx) => (
                      <div key={idx} className="p-4 rounded-2xl bg-white/5 border border-white/5 space-y-2">
                        <div className="flex items-center justify-between gap-2">
                          <span className="text-xs font-bold text-white flex items-center gap-1.5">
                            <span className="w-5 h-5 rounded-full bg-amber-500/20 text-amber-400 text-[10px] flex items-center justify-center font-bold">
                              {idx + 1}
                            </span>
                            {opp.category}
                          </span>
                          <span className="text-[10px] px-2 py-0.5 rounded font-black bg-emerald-500/15 text-emerald-400 border border-emerald-500/20">
                            {opp.impact}
                          </span>
                        </div>
                        <div className="text-[11px] font-mono text-slate-400">Target: {opp.target}</div>
                        <p className="text-xs text-slate-300 leading-relaxed">{opp.strategy}</p>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              {/* Conversion CTA */}
              <div className="p-8 rounded-3xl bg-gradient-to-b from-[#22201e] to-[#181615] border border-white/10 text-center space-y-4">
                <span className="text-[11px] font-bold text-[#ff3b30] uppercase tracking-wider">High-Authority Link Velocity</span>
                <h3 className="text-xl sm:text-2xl font-black !text-white" style={{ color: '#ffffff' }}>
                  Want 50+ High DA 70+ Dofollow Backlinks for Your Domain?
                </h3>
                <p className="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed">
                  Rankexa executes custom white-hat Digital PR, editorial guest contributions, and broken-link replacement campaigns to boost your Domain Authority into the top 1%.
                </p>
                <div className="flex flex-wrap items-center justify-center gap-3 pt-2">
                  <button
                    type="button"
                    onClick={openInquiry}
                    className="px-6 py-3 rounded-xl bg-[#ff3b30] hover:bg-[#e03126] text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-lg shadow-red-500/25 active:scale-95 cursor-pointer"
                  >
                    Discuss Link Building Campaign
                  </button>
                  <button
                    type="button"
                    onClick={() => {
                      setResult(null);
                      window.scrollTo({ top: 0, behavior: 'smooth' });
                    }}
                    className="px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                  >
                    Audit Another Domain
                  </button>
                </div>
              </div>
            </section>
          )}
        </div>
      )}
    </AppLayout>
  );
}
