import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function RankChecker({ seo }) {
  const [domain, setDomain] = useState('');
  const [keyword, setKeyword] = useState('');
  const [country, setCountry] = useState('in');
  const [email, setEmail] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState('');
  const [result, setResult] = useState(null);

  const countries = [
    { code: 'in', name: 'India (google.co.in)', flag: '🇮🇳' },
    { code: 'us', name: 'United States (google.com)', flag: '🇺🇸' },
    { code: 'uk', name: 'United Kingdom (google.co.uk)', flag: '🇬🇧' },
    { code: 'ca', name: 'Canada (google.ca)', flag: '🇨🇦' },
    { code: 'ae', name: 'UAE (google.ae)', flag: '🇦🇪' },
    { code: 'au', name: 'Australia (google.com.au)', flag: '🇦🇺' },
  ];

  const performSearch = async (targetDomain, targetKeyword, targetCountry, targetEmail) => {
    if (!targetDomain.trim() || !targetKeyword.trim()) {
      setErrorMsg('Please enter both your Target Domain and Target Keyword.');
      return;
    }

    setErrorMsg('');
    setIsLoading(true);
    setResult(null);

    try {
      const response = await fetch('/api/tools/check-ranking', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          domain: targetDomain.trim(),
          keyword: targetKeyword.trim(),
          country: targetCountry || country,
          email: (targetEmail || email).trim() || undefined,
        }),
      });

      const data = await response.json();
      if (!response.ok || !data.success) {
        throw new Error(data.message || 'Failed to fetch Google ranking. Please try again.');
      }

      setResult(data.data);
    } catch (err) {
      setErrorMsg(err.message || 'An error occurred while scanning Google SERP.');
    } finally {
      setIsLoading(false);
    }
  };

  const handleSearch = (e) => {
    if (e) e.preventDefault();
    performSearch(domain, keyword, country, email);
  };

  React.useEffect(() => {
    if (typeof window !== 'undefined') {
      const params = new URLSearchParams(window.location.search);
      const urlDomain = (params.get('domain') || '').trim();
      const urlKeyword = (params.get('keyword') || '').trim();
      const urlQ = (params.get('q') || '').trim();
      const urlCountry = (params.get('country') || '').trim();

      let d = urlDomain;
      let k = urlKeyword;

      if (urlQ) {
        if (!d && urlQ.includes('.') && !urlQ.includes(' ')) {
          d = urlQ;
        } else if (!k) {
          k = urlQ;
        }
      }

      if (d) setDomain(d);
      if (k) setKeyword(k);
      if (urlCountry) setCountry(urlCountry);

      if (d && k) {
        performSearch(d, k, urlCountry || country, email);
      }
    }
  }, []);

  return (
    <AppLayout seo={seo}>
      {({ openInquiry, openAudit }) => (
        <div className="bg-[#161514] text-white min-h-screen">
          {/* Hero & Search Header */}
          <section className="relative pt-32 pb-16 overflow-hidden border-b border-white/10">
            <div className="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[300px] bg-red-600/15 rounded-full blur-[140px] pointer-events-none"></div>

            <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
              <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300 mb-6 backdrop-blur-sm">
                <span className="w-2 h-2 rounded-full bg-[#ff3b30] animate-pulse"></span>
                <span>REAL-TIME GOOGLE SERP POSITION CHECKER • 100% FREE</span>
              </div>

              <h1
                className="text-3xl sm:text-5xl font-black tracking-tight leading-tight mb-4 !text-white"
                style={{ color: '#ffffff' }}
              >
                <span style={{ color: '#ffffff' }}>Free Google Keyword </span>
                <span className="bg-gradient-to-r from-[#ff3b30] via-orange-400 to-red-400 bg-clip-text text-transparent">
                  Ranking Checker
                </span>
              </h1>

              <p className="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed mb-8">
                Discover your exact Google SERP position, inspect top 3 ranking competitors, and get an instant AI-powered roadmap to jump to Page 1.
              </p>

              {/* Search Card */}
              <div className="p-6 sm:p-8 rounded-3xl bg-[#1e1c1a] border border-white/10 shadow-2xl text-left max-w-4xl mx-auto">
                <form onSubmit={handleSearch} className="space-y-4">
                  <div className="grid grid-cols-1 md:grid-cols-12 gap-3">
                    {/* Domain Input */}
                    <div className="md:col-span-4">
                      <label className="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                        Target Domain
                      </label>
                      <div className="relative">
                        <i className="fas fa-globe absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                        <input
                          type="text"
                          required
                          value={domain}
                          onChange={(e) => setDomain(e.target.value)}
                          placeholder="e.g. rankexa.in or mysite.com"
                          className="w-full bg-[#141312] border border-white/10 focus:border-[#ff3b30] text-white text-xs sm:text-sm pl-9 pr-3 py-3 rounded-xl outline-none transition-colors"
                        />
                      </div>
                    </div>

                    {/* Keyword Input */}
                    <div className="md:col-span-5">
                      <label className="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                        Target Keyword
                      </label>
                      <div className="relative">
                        <i className="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                        <input
                          type="text"
                          required
                          value={keyword}
                          onChange={(e) => setKeyword(e.target.value)}
                          placeholder="e.g. web development agency"
                          className="w-full bg-[#141312] border border-white/10 focus:border-[#ff3b30] text-white text-xs sm:text-sm pl-9 pr-3 py-3 rounded-xl outline-none transition-colors"
                        />
                      </div>
                    </div>

                    {/* Country Selector */}
                    <div className="md:col-span-3">
                      <label className="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">
                        Google Region
                      </label>
                      <select
                        value={country}
                        onChange={(e) => setCountry(e.target.value)}
                        className="w-full bg-[#141312] border border-white/10 focus:border-[#ff3b30] text-white text-xs sm:text-sm px-3 py-3 rounded-xl outline-none transition-colors"
                      >
                        {countries.map((c) => (
                          <option key={c.code} value={c.code} className="bg-[#1e1c1a]">
                            {c.flag} {c.name.split(' ')[0]}
                          </option>
                        ))}
                      </select>
                    </div>
                  </div>

                  {/* Optional Email & Submit Button */}
                  <div className="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                    <div className="w-full sm:w-1/2">
                      <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        placeholder="Your email (optional, for alerts)"
                        className="w-full bg-[#141312] border border-white/10 text-white text-xs px-3.5 py-2.5 rounded-xl outline-none placeholder-slate-500 focus:border-white/30"
                      />
                    </div>

                    <button
                      type="submit"
                      disabled={isLoading}
                      className="w-full sm:w-auto px-8 py-3 rounded-xl bg-[#ff3b30] hover:bg-[#e03126] text-white font-extrabold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-lg shadow-red-500/25 active:scale-95 disabled:opacity-50 cursor-pointer"
                    >
                      {isLoading ? (
                        <>
                          <i className="fas fa-spinner fa-spin"></i>
                          <span>Scanning Google SERP...</span>
                        </>
                      ) : (
                        <>
                          <i className="fas fa-bolt"></i>
                          <span>Check Ranking Now</span>
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

          {/* Loading Animation State */}
          {isLoading && (
            <div className="max-w-4xl mx-auto px-4 py-16 text-center">
              <div className="relative w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                <div className="absolute inset-0 rounded-full border-4 border-white/10 animate-ping opacity-25"></div>
                <div className="w-16 h-16 rounded-full border-4 border-[#ff3b30] border-t-transparent animate-spin flex items-center justify-center">
                  <i className="fas fa-search text-[#ff3b30]"></i>
                </div>
              </div>
              <h3 className="text-xl font-black mb-2">Analyzing Google Search Positions...</h3>
              <p className="text-slate-400 text-xs max-w-md mx-auto">
                Crawling live SERP pages, benchmarking competitors, and synthesizing Groq AI keyword difficulty roadmap.
              </p>
            </div>
          )}

          {/* Diagnostic Results Section */}
          {result && !isLoading && (
            <section className="py-12 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
              {/* Result Hero Banner */}
              <div className="p-6 sm:p-8 rounded-3xl bg-gradient-to-tr from-[#1e1c1a] to-[#252220] border border-white/10 shadow-2xl relative overflow-hidden">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-white/10">
                  <div>
                    <div className="flex items-center gap-2 text-xs font-mono text-slate-400 uppercase tracking-wider mb-1">
                      <span>Google Region: {result.country}</span>
                      <span>•</span>
                      <span>Keyword: "{result.keyword}"</span>
                    </div>
                    <h2 className="text-2xl sm:text-3xl font-black text-white flex items-center gap-3 !text-white" style={{ color: '#ffffff' }}>
                      <span style={{ color: '#ffffff' }}>{result.domain}</span>
                    </h2>
                  </div>

                  {/* Big Rank Badge */}
                  <div className="flex items-center gap-4">
                    {result.is_ranked ? (
                      <div className="flex items-center gap-3">
                        <div className="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-tr from-[#ff3b30] to-orange-500 flex flex-col items-center justify-center shadow-lg shadow-red-500/25">
                          <span className="text-xs uppercase font-extrabold text-white/80">Rank</span>
                          <span className="text-2xl sm:text-3xl font-black leading-none text-white font-mono">
                            #{result.position}
                          </span>
                        </div>
                        <div>
                          <span className={`inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider border ${
                            result.page === 1
                              ? 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30'
                              : 'bg-amber-500/15 text-amber-400 border-amber-500/30'
                          }`}>
                            {result.page === 1 ? 'Page 1 Winner' : `Page ${result.page}`}
                          </span>
                          <p className="text-xs text-slate-300 font-semibold mt-1">
                            {result.page === 1 ? 'Top 10 Organic Placement' : 'Opportunity to Push to Page 1'}
                          </p>
                        </div>
                      </div>
                    ) : (
                      <div className="flex items-center gap-3">
                        <div className="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/5 border border-white/10 flex flex-col items-center justify-center">
                          <span className="text-xs uppercase font-extrabold text-slate-400">Rank</span>
                          <span className="text-lg sm:text-xl font-black text-slate-400 leading-none">&gt; 30</span>
                        </div>
                        <div>
                          <span className="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-red-500/15 text-red-400 border border-red-500/30">
                            Not in Top 30
                          </span>
                          <p className="text-xs text-slate-400 mt-1">Requires Technical SEO Sprints</p>
                        </div>
                      </div>
                    )}
                  </div>
                </div>

                {/* AI Keyword Intelligence Strip */}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                  <div className="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-between">
                    <div>
                      <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keyword Difficulty</span>
                      <div className="text-base font-black text-white mt-0.5">{result.difficulty}</div>
                    </div>
                    <i className="fas fa-gauge-high text-slate-500 text-lg"></i>
                  </div>

                  <div className="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-between">
                    <div>
                      <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Search Intent</span>
                      <div className="text-base font-black text-white mt-0.5">{result.intent}</div>
                    </div>
                    <i className="fas fa-bullseye text-slate-500 text-lg"></i>
                  </div>
                </div>
              </div>

              {/* Simulated Google SERP Snippet Preview */}
              {result.ranking_url && (
                <div className="p-6 rounded-3xl bg-[#1e1c1a] border border-white/10">
                  <div className="flex items-center justify-between mb-4">
                    <span className="text-xs font-bold uppercase tracking-wider text-slate-400">
                      Google Search Result Snippet Preview
                    </span>
                    <span className="text-[10px] font-mono text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-md border border-emerald-500/20">
                      Indexed URL
                    </span>
                  </div>
                  <div className="p-4 rounded-2xl bg-[#141312] border border-white/5 space-y-1">
                    <div className="text-xs text-slate-400 flex items-center gap-1.5 font-mono truncate">
                      <i className="fas fa-lock text-[10px] text-emerald-400"></i>
                      <span>{result.ranking_url}</span>
                    </div>
                    <h4 className="text-base font-bold text-[#8ab4f8] hover:underline cursor-pointer">
                      {result.keyword} — {result.domain}
                    </h4>
                    <p className="text-xs text-slate-300 leading-relaxed">
                      Explore official services, technical architecture, and solutions for {result.keyword} provided by {result.domain}.
                    </p>
                  </div>
                </div>
              )}

              {/* Top 3 Competitors Benchmark */}
              {result.competitors && result.competitors.length > 0 && (
                <div className="p-6 rounded-3xl bg-[#1e1c1a] border border-white/10">
                  <h3 className="text-base font-extrabold text-white mb-4 flex items-center gap-2 !text-white" style={{ color: '#ffffff' }}>
                    <i className="fas fa-trophy text-amber-400"></i>
                    <span style={{ color: '#ffffff' }}>Top 3 Competitors Ranking in SERP</span>
                  </h3>
                  <div className="space-y-3">
                    {result.competitors.map((comp, idx) => (
                      <div
                        key={idx}
                        className="p-3.5 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-between gap-4"
                      >
                        <div className="flex items-center gap-3 min-w-0">
                          <span className="w-7 h-7 rounded-xl bg-amber-500/20 text-amber-400 font-mono font-black text-xs flex items-center justify-center shrink-0">
                            #{comp.rank}
                          </span>
                          <div className="min-w-0">
                            <h5 className="text-xs font-bold text-white truncate">{comp.title}</h5>
                            <span className="text-[11px] text-slate-400 font-mono truncate block">{comp.domain}</span>
                          </div>
                        </div>
                        <a
                          href={comp.url}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-[11px] font-semibold text-slate-300 hover:text-white shrink-0 transition-colors"
                        >
                          Visit <i className="fas fa-arrow-up-right-from-square text-[9px] ml-1"></i>
                        </a>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              {/* AI Strategic Action Plan */}
              {result.recommendations && result.recommendations.length > 0 && (
                <div className="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-[#ff3b30]/10 via-[#1e1c1a] to-[#1e1c1a] border border-[#ff3b30]/30 shadow-xl">
                  <div className="flex items-center justify-between mb-4">
                    <div className="flex items-center gap-2 font-black text-[#ff3b30] uppercase text-xs tracking-wider">
                      <i className="fas fa-robot text-sm"></i>
                      <span>AI Tactical Roadmap: How to Outrank Page 1 Competitors</span>
                    </div>
                    <span className="text-[10px] text-slate-400 font-mono hidden sm:inline-block">Groq Llama 3.3 Engine</span>
                  </div>

                  <ul className="space-y-3">
                    {result.recommendations.map((tip, idx) => (
                      <li key={idx} className="flex items-start gap-3 text-xs sm:text-sm text-slate-200">
                        <span className="w-6 h-6 rounded-full bg-[#ff3b30]/20 text-[#ff3b30] border border-[#ff3b30]/40 flex items-center justify-center text-[10px] font-bold shrink-0 mt-0.5">
                          {idx + 1}
                        </span>
                        <span className="leading-relaxed">{tip}</span>
                      </li>
                    ))}
                  </ul>
                </div>
              )}

              {/* Lead Conversion CTA Card */}
              <div className="p-8 rounded-3xl bg-gradient-to-b from-[#22201e] to-[#181615] border border-white/10 text-center space-y-4">
                <span className="text-[11px] font-bold text-[#ff3b30] uppercase tracking-wider">Target Page 1 Top 3 Positions</span>
                <h3 className="text-xl sm:text-2xl font-black !text-white" style={{ color: '#ffffff' }}>
                  Want Rankexa's SEO Engineers to Drive Your Keyword to #1?
                </h3>
                <p className="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed">
                  We deploy automated Core Web Vitals optimization, high-DA contextual backlinks, and semantic content clusters to overtake enterprise competitors.
                </p>
                <div className="flex flex-wrap items-center justify-center gap-3 pt-2">
                  <button
                    type="button"
                    onClick={openInquiry}
                    className="px-6 py-3 rounded-xl bg-[#ff3b30] hover:bg-[#e03126] text-white font-extrabold text-xs uppercase tracking-wider transition-all shadow-lg shadow-red-500/25 active:scale-95 cursor-pointer"
                  >
                    Schedule 1-on-1 Consultation
                  </button>
                  <button
                    type="button"
                    onClick={() => {
                      setResult(null);
                      window.scrollTo({ top: 0, behavior: 'smooth' });
                    }}
                    className="px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs uppercase tracking-wider transition-colors cursor-pointer"
                  >
                    Check Another Keyword
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
