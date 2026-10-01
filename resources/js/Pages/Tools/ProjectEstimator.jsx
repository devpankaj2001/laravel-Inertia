import React, { useState, useMemo } from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';
import { jsPDF } from 'jspdf';

export default function ProjectEstimator({ seo }) {
  // Currency mode: 'INR' or 'USD'
  const [currency, setCurrency] = useState('INR');

  // Selected project archetype
  const [projectType, setProjectType] = useState('saas_app');

  // Scope scale: screens / pages
  const [screensRange, setScreensRange] = useState('medium'); // 'starter' (1-5), 'medium' (6-12), 'large' (13-25), 'enterprise' (25+)

  // Traffic / infrastructure scale
  const [trafficScale, setTrafficScale] = useState('growth'); // 'starter' (<10k), 'growth' (10k-100k), 'high' (>100k)

  // Selected features
  const [selectedFeatures, setSelectedFeatures] = useState([
    'core_web_vitals',
    'advanced_seo',
    'admin_dashboard',
    'payment_gateway',
  ]);

  // Design polish level
  const [designLevel, setDesignLevel] = useState('glassmorphic');

  // Urgency sprint
  const [urgency, setUrgency] = useState('standard');

  // Proposal modal state
  const [showModal, setShowModal] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    company: '',
    notes: '',
  });
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitSuccess, setSubmitSuccess] = useState(false);
  const [submitError, setSubmitError] = useState('');
  const [downloadedProposalId, setDownloadedProposalId] = useState('');

  // 1-Click Quick Presets
  const applyPreset = (presetKey) => {
    if (presetKey === 'mvp') {
      setProjectType('landing_page');
      setScreensRange('starter');
      setTrafficScale('starter');
      setSelectedFeatures(['core_web_vitals', 'advanced_seo']);
      setDesignLevel('clean_minimal');
      setUrgency('standard');
    } else if (presetKey === 'growth') {
      setProjectType('saas_app');
      setScreensRange('medium');
      setTrafficScale('growth');
      setSelectedFeatures(['core_web_vitals', 'advanced_seo', 'admin_dashboard', 'payment_gateway', 'ai_chatbot']);
      setDesignLevel('glassmorphic');
      setUrgency('standard');
    } else if (presetKey === 'enterprise') {
      setProjectType('enterprise_portal');
      setScreensRange('large');
      setTrafficScale('high');
      setSelectedFeatures([
        'core_web_vitals',
        'advanced_seo',
        'admin_dashboard',
        'payment_gateway',
        'ai_chatbot',
        'user_auth',
        'multilingual',
        'blog_engine',
      ]);
      setDesignLevel('interactive_gsap');
      setUrgency('rush');
    }
  };

  // Project Archetypes
  const projectTypes = [
    {
      id: 'corporate_web',
      name: 'Brand & Corporate Website',
      description: 'High-conversion corporate presence with custom typography, responsive layout, and lead forms.',
      basePriceINR: 18000,
      basePriceUSD: 250,
      baseWeeks: '2-3',
      icon: 'fa-building',
    },
    {
      id: 'saas_app',
      name: 'Next.js / SaaS Web Application',
      description: 'Dynamic Full-Stack application with authentication, interactive dashboards, and API integrations.',
      basePriceINR: 45000,
      basePriceUSD: 600,
      baseWeeks: '4-6',
      icon: 'fa-rocket',
      popular: true,
    },
    {
      id: 'ecommerce_store',
      name: 'E-Commerce Online Store',
      description: 'Modern storefront with cart, payment gateway, inventory management, and automated invoices.',
      basePriceINR: 35000,
      basePriceUSD: 450,
      baseWeeks: '3-5',
      icon: 'fa-cart-shopping',
    },
    {
      id: 'landing_page',
      name: 'High-Converting Landing Page',
      description: 'Laser-focused single-page sales machine built for Google/Meta PPC ads and maximum conversions.',
      basePriceINR: 12000,
      basePriceUSD: 160,
      baseWeeks: '1-2',
      icon: 'fa-bullseye',
    },
    {
      id: 'seo_speed_overhaul',
      name: 'Technical SEO & Speed Overhaul',
      description: 'Core Web Vitals 95+ guarantee, structured Schema markup, crawl budget fix, and #1 rank roadmap.',
      basePriceINR: 16000,
      basePriceUSD: 220,
      baseWeeks: '2-3',
      icon: 'fa-bolt',
    },
    {
      id: 'enterprise_portal',
      name: 'Custom Enterprise Portal & API Hub',
      description: 'Scalable cloud infrastructure, multi-tenant RBAC, automated background jobs, and CRM integration.',
      basePriceINR: 68000,
      basePriceUSD: 880,
      baseWeeks: '6-8',
      icon: 'fa-server',
    },
  ];

  // Screen scale multipliers & names
  const screenOptions = [
    { id: 'starter', label: '1 - 5 Screens', sub: 'MVP / Lean', priceINR: 0, priceUSD: 0, weeksAdd: 0 },
    { id: 'medium', label: '6 - 12 Screens', sub: 'Standard Brand', priceINR: 8000, priceUSD: 100, weeksAdd: 1 },
    { id: 'large', label: '13 - 25 Screens', sub: 'Full Product Suite', priceINR: 18000, priceUSD: 230, weeksAdd: 2 },
    { id: 'enterprise', label: '25+ Screens', sub: 'Complex Architecture', priceINR: 32000, priceUSD: 420, weeksAdd: 3 },
  ];

  // Traffic / Hosting Architecture
  const trafficOptions = [
    { id: 'starter', label: '< 10k Monthly Visits', sub: 'Vercel / Cloud Server', priceINR: 0, priceUSD: 0 },
    { id: 'growth', label: '10k - 100k Monthly Visits', sub: 'Redis Cache + Edge CDN', priceINR: 4000, priceUSD: 50 },
    { id: 'high', label: '100k+ High Traffic', sub: 'Auto-Scaling + DDoS Shield', priceINR: 9000, priceUSD: 120 },
  ];

  // Feature Add-ons
  const featureList = [
    {
      id: 'core_web_vitals',
      name: '100/100 Core Web Vitals Guarantee',
      desc: 'Sub-second LCP (<1.2s), 0 CLS, and instant TTFB optimized architecture.',
      priceINR: 5000,
      priceUSD: 70,
      category: 'Performance',
      icon: 'fa-gauge-high',
    },
    {
      id: 'advanced_seo',
      name: 'Technical SEO & Rich Snippet Schemas',
      desc: 'Complete JSON-LD markup (FAQ, LocalBiz, Breadcrumb, Product) + OpenGraph.',
      priceINR: 6000,
      priceUSD: 80,
      category: 'SEO',
      icon: 'fa-magnifying-glass-chart',
    },
    {
      id: 'admin_dashboard',
      name: 'Custom Admin Dashboard & CMS',
      desc: 'Full CRUD control to manage articles, services, leads, and assets without coding.',
      priceINR: 12000,
      priceUSD: 150,
      category: 'Backoffice',
      icon: 'fa-table-columns',
    },
    {
      id: 'payment_gateway',
      name: 'Payment Gateway (Razorpay, Stripe & UPI)',
      desc: 'Seamless checkout, auto-invoicing, webhook handling, and refund tracking.',
      priceINR: 8000,
      priceUSD: 100,
      category: 'Finance',
      icon: 'fa-credit-card',
    },
    {
      id: 'ai_chatbot',
      name: 'AI Chatbot & Lead Automation',
      desc: 'Zero-cost Groq/Gemini conversational AI that captures and scores leads 24/7.',
      priceINR: 10000,
      priceUSD: 130,
      category: 'AI',
      icon: 'fa-robot',
    },
    {
      id: 'user_auth',
      name: 'User Authentication & RBAC Security',
      desc: 'Secure session management, 2FA, password resets, and role permissions.',
      priceINR: 8000,
      priceUSD: 100,
      category: 'Security',
      icon: 'fa-shield-halved',
    },
    {
      id: 'multilingual',
      name: 'Multilingual (i18n) Engine',
      desc: 'Seamless multi-language toggle (English, Hindi, Arabic, Spanish, etc.) with localized URLs.',
      priceINR: 7000,
      priceUSD: 90,
      category: 'Global',
      icon: 'fa-language',
    },
    {
      id: 'blog_engine',
      name: 'SEO Dynamic Blog Engine',
      desc: 'Markdown/Rich-text editor, categories, tag filtering, and dynamic sitemaps.',
      priceINR: 5000,
      priceUSD: 70,
      category: 'Content',
      icon: 'fa-newspaper',
    },
  ];

  // Design polish options
  const designOptions = [
    {
      id: 'clean_minimal',
      name: 'Modern Clean Minimalist',
      desc: 'Clean typography, responsive layout, crisp accessibility standards.',
      priceINR: 0,
      priceUSD: 0,
    },
    {
      id: 'glassmorphic',
      name: 'Sleek Dark Glassmorphism',
      desc: 'Tailored luxury gradients, frosted glass cards, subtle neon glow accents.',
      priceINR: 5000,
      priceUSD: 70,
    },
    {
      id: 'interactive_gsap',
      name: 'Interactive 3D & GSAP Micro-Animations',
      desc: 'Smooth scroll physics, magnetic buttons, and dynamic SVG particle interactions.',
      priceINR: 9000,
      priceUSD: 120,
    },
  ];

  // Urgency options
  const urgencyOptions = [
    {
      id: 'standard',
      name: 'Standard Timeline (Recommended)',
      desc: 'Structured sprints with iterative client review cycles.',
      factor: 1.0,
      timeSuffix: 'Standard',
    },
    {
      id: 'rush',
      name: 'Express Sprint (2x Dev Speed)',
      desc: 'Dedicated round-the-clock engineering priority for urgent launches.',
      factor: 1.25,
      timeSuffix: 'Fast-Track',
    },
  ];

  // Toggle Feature checkbox
  const toggleFeature = (id) => {
    setSelectedFeatures((prev) =>
      prev.includes(id) ? prev.filter((item) => item !== id) : [...prev, id]
    );
  };

  // Calculations
  const calculation = useMemo(() => {
    const curType = projectTypes.find((p) => p.id === projectType) || projectTypes[0];
    const curScreen = screenOptions.find((s) => s.id === screensRange) || screenOptions[0];
    const curTraffic = trafficOptions.find((t) => t.id === trafficScale) || trafficOptions[0];
    const curDesign = designOptions.find((d) => d.id === designLevel) || designOptions[0];
    const curUrgency = urgencyOptions.find((u) => u.id === urgency) || urgencyOptions[0];

    let base = currency === 'INR' ? curType.basePriceINR : curType.basePriceUSD;
    let screenCost = currency === 'INR' ? curScreen.priceINR : curScreen.priceUSD;
    let trafficCost = currency === 'INR' ? curTraffic.priceINR : curTraffic.priceUSD;
    let designCost = currency === 'INR' ? curDesign.priceINR : curDesign.priceUSD;

    let featuresTotal = selectedFeatures.reduce((acc, featId) => {
      const feat = featureList.find((f) => f.id === featId);
      if (!feat) return acc;
      return acc + (currency === 'INR' ? feat.priceINR : feat.priceUSD);
    }, 0);

    let rawTotal = (base + screenCost + trafficCost + designCost + featuresTotal) * curUrgency.factor;

    const minPrice = Math.round(rawTotal * 0.95);
    const maxPrice = Math.round(rawTotal * 1.08);

    const currencySymbol = currency === 'INR' ? '₹' : '$';

    // Timeline calculation
    let calculatedWeeks = curUrgency.id === 'rush' ? '2-3' : `${curType.baseWeeks}`;
    if (curScreen.weeksAdd > 0 && curUrgency.id !== 'rush') {
      const parts = curType.baseWeeks.split('-').map(Number);
      if (parts.length === 2) {
        calculatedWeeks = `${parts[0] + 1}-${parts[1] + curScreen.weeksAdd}`;
      }
    }

    return {
      curType,
      curScreen,
      curTraffic,
      curDesign,
      curUrgency,
      minPrice,
      maxPrice,
      currencySymbol,
      displayRange: `${currencySymbol}${minPrice.toLocaleString()} – ${currencySymbol}${maxPrice.toLocaleString()}`,
      timelineWeeks: `${calculatedWeeks} Weeks`,
    };
  }, [projectType, screensRange, trafficScale, selectedFeatures, designLevel, urgency, currency]);

  // Recommended Tech Stack Explanation
  const techStackBadges = useMemo(() => {
    const list = [
      { name: 'Laravel 12 / PHP 8.3', role: 'Backend & Async Jobs', icon: 'fa-brands fa-laravel' },
      { name: 'React 19 / Inertia.js', role: 'Reactive Frontend', icon: 'fa-brands fa-react' },
      { name: 'Tailwind CSS', role: 'Responsive Styling', icon: 'fa-code' },
      { name: 'PostgreSQL / MySQL', role: 'ACID Database', icon: 'fa-database' },
    ];
    if (selectedFeatures.includes('core_web_vitals')) {
      list.push({ name: 'Cloudflare Edge CDN', role: 'Sub-second Caching', icon: 'fa-bolt' });
    }
    if (selectedFeatures.includes('ai_chatbot')) {
      list.push({ name: 'Groq Cloud Llama 3.3', role: 'Free AI Engine', icon: 'fa-robot' });
    }
    return list;
  }, [selectedFeatures]);

  // Generate Branded PDF Proposal
  const generateProposalPDF = (proposalId, clientName, clientCompany) => {
    const doc = new jsPDF({
      orientation: 'portrait',
      unit: 'mm',
      format: 'a4',
    });

    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();

    // Background header banner
    doc.setFillColor(22, 21, 20); // #161514
    doc.rect(0, 0, pageWidth, 45, 'F');

    // Accent line
    doc.setFillColor(255, 59, 48); // #ff3b30
    doc.rect(0, 45, pageWidth, 2.5, 'F');

    // Header Logo Text
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(22);
    doc.setTextColor(255, 255, 255);
    doc.text('Rank', 15, 22);
    doc.setTextColor(255, 59, 48);
    doc.text('exa', 35, 22);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(9);
    doc.setTextColor(180, 180, 180);
    doc.text('Next-Gen Web Architecture & Search Dominance', 15, 29);
    doc.text('Web: https://rankexa.in • Email: contact@rankexa.in', 15, 35);

    // Proposal metadata box (Right aligned)
    doc.setFontSize(8);
    doc.setTextColor(220, 220, 220);
    doc.text(`PROPOSAL ID: ${proposalId}`, pageWidth - 15, 20, { align: 'right' });
    doc.text(`DATE: ${new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`, pageWidth - 15, 26, { align: 'right' });
    doc.text('VALIDITY: 14 Days from Issue', pageWidth - 15, 32, { align: 'right' });

    // Client Info Section
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(13);
    doc.setTextColor(22, 21, 20);
    doc.text('PROJECT PROPOSAL & SCOPE SPECIFICATION', 15, 58);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(9.5);
    doc.setTextColor(70, 70, 70);
    doc.text(`Prepared For: ${clientName || 'Valued Client'} ${clientCompany ? `(${clientCompany})` : ''}`, 15, 66);
    doc.text(`Project Category: ${calculation.curType.name} • Scale: ${calculation.curScreen.label}`, 15, 72);
    doc.text(`Estimated Timeline: ${calculation.timelineWeeks} (${calculation.curUrgency.name})`, 15, 78);

    // Decorative line
    doc.setDrawColor(230, 230, 230);
    doc.line(15, 83, pageWidth - 15, 83);

    // Deliverables Table Header
    let yPos = 91;
    doc.setFillColor(245, 245, 247);
    doc.rect(15, yPos - 5, pageWidth - 30, 8, 'F');
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(8.5);
    doc.setTextColor(30, 30, 30);
    doc.text('SCOPE DELIVERABLE / MODULE', 18, yPos);
    doc.text('CLASSIFICATION', 120, yPos);
    doc.text('STATUS', pageWidth - 20, yPos, { align: 'right' });

    yPos += 7;

    // Items
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(8.5);
    doc.setTextColor(50, 50, 50);

    const items = [
      { name: `${calculation.curType.name} (Base Architecture)`, cat: 'Core Platform' },
      { name: `Screen Scope: ${calculation.curScreen.label} (${calculation.curScreen.sub})`, cat: 'Frontend UI' },
      { name: `Traffic Capacity: ${calculation.curTraffic.label}`, cat: 'Cloud Infra' },
      { name: `Design Polish: ${calculation.curDesign.name}`, cat: 'Visual Experience' },
    ];

    selectedFeatures.forEach((featId) => {
      const feat = featureList.find((f) => f.id === featId);
      if (feat) {
        items.push({ name: feat.name, cat: feat.category });
      }
    });

    items.forEach((item) => {
      doc.text(`• ${item.name}`, 18, yPos);
      doc.text(item.cat, 120, yPos);
      doc.text('Included', pageWidth - 20, yPos, { align: 'right' });
      yPos += 6;
    });

    // Technical Guarantees box
    yPos += 3;
    doc.setFillColor(248, 250, 252);
    doc.setDrawColor(226, 232, 240);
    doc.roundedRect(15, yPos, pageWidth - 30, 30, 2, 2, 'FD');

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(8.5);
    doc.setTextColor(255, 59, 48);
    doc.text('RANKEXA ENTERPRISE QUALITY COMMITMENTS:', 20, yPos + 6);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(8);
    doc.setTextColor(70, 80, 95);
    doc.text('1. Guaranteed 95+ Google PageSpeed & Core Web Vitals score on mobile and desktop.', 20, yPos + 12);
    doc.text('2. 100% Intellectual Property & Source Code Ownership transferred upon deployment.', 20, yPos + 17);
    doc.text('3. 30 Days of complimentary post-launch technical support and bug-free warranty.', 20, yPos + 22);
    doc.text('4. Full SEO metadata, schema markup, and Google Search Console indexing ready.', 20, yPos + 27);

    // Total Estimated Investment Box
    yPos += 36;
    doc.setFillColor(22, 21, 20);
    doc.roundedRect(15, yPos, pageWidth - 30, 23, 2, 2, 'F');

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(9);
    doc.setTextColor(200, 200, 200);
    doc.text('ESTIMATED INVESTMENT RANGE:', 22, yPos + 8);

    doc.setFontSize(15);
    doc.setTextColor(255, 255, 255);
    doc.text(`${calculation.displayRange}`, 22, yPos + 17);

    doc.setFontSize(8.5);
    doc.setTextColor(255, 59, 48);
    doc.text(`Target Timeline: ${calculation.timelineWeeks}`, pageWidth - 22, yPos + 14, { align: 'right' });

    // Milestone Payment Breakdown
    yPos += 29;
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(9.5);
    doc.setTextColor(30, 30, 30);
    doc.text('TRANSPARENT MILESTONE PAYMENT SCHEDULE:', 15, yPos);

    yPos += 5;
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(8);
    doc.setTextColor(80, 80, 80);
    doc.text('• Milestone 1 (40%): Project Kickoff, Wireframes & UI/UX Design Approval', 15, yPos);
    yPos += 5;
    doc.text('• Milestone 2 (40%): Full Frontend/Backend Architecture on Private Staging Link', 15, yPos);
    yPos += 5;
    doc.text('• Milestone 3 (20%): Final Testing, Speed Optimization, DNS Switch & Production Launch', 15, yPos);

    // Footer contact bar
    doc.setDrawColor(255, 59, 48);
    doc.line(15, pageHeight - 18, pageWidth - 15, pageHeight - 18);

    doc.setFontSize(7.5);
    doc.setTextColor(120, 120, 120);
    doc.text('To approve this scope or schedule a technical call, contact contact@rankexa.in or WhatsApp +91-7891223456.', 15, pageHeight - 12);
    doc.text(`Rankexa Estimator Engine • https://rankexa.in`, pageWidth - 15, pageHeight - 12, { align: 'right' });

    // Download PDF
    const filename = `Rankexa_Project_Proposal_${(clientName || 'Client').replace(/\s+/g, '_')}_${proposalId}.pdf`;
    doc.save(filename);
  };

  // Submit form and generate proposal
  const handleSubmitProposal = async (e) => {
    e.preventDefault();
    if (!formData.name.trim() || !formData.email.trim()) {
      setSubmitError('Please enter your full name and work email address.');
      return;
    }

    setSubmitError('');
    setIsSubmitting(true);

    const proposalCode = 'RNK-' + Math.floor(100000 + Math.random() * 900000);

    try {
      const response = await fetch('/api/tools/save-estimate', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          name: formData.name.trim(),
          email: formData.email.trim(),
          phone: formData.phone.trim() || undefined,
          company: formData.company.trim() || undefined,
          project_type: `${calculation.curType.name} (${calculation.curScreen.label})`,
          estimated_price: calculation.displayRange,
          currency: currency,
          timeline: calculation.timelineWeeks,
          features: selectedFeatures.map((id) => {
            const f = featureList.find((item) => item.id === id);
            return f ? f.name : id;
          }),
          notes: formData.notes.trim() || undefined,
        }),
      });

      const data = await response.json();
      if (!response.ok || !data.success) {
        throw new Error(data.message || 'Unable to register proposal.');
      }

      setDownloadedProposalId(proposalCode);
      setSubmitSuccess(true);

      // Trigger instant PDF download in browser
      generateProposalPDF(proposalCode, formData.name, formData.company);
    } catch (err) {
      setSubmitError(err.message || 'An unexpected error occurred. Please try again.');
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <AppLayout seo={seo}>
      {({ openInquiry, openAudit }) => (
        <div className="bg-[#161514] text-white min-h-screen w-full max-w-full overflow-x-hidden">
          {/* Header Glow & Hero */}
          <section className="relative pt-28 sm:pt-32 pb-12 sm:pb-16 overflow-hidden border-b border-white/10 w-full">
            <div className="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] sm:w-[700px] h-[250px] sm:h-[350px] bg-red-600/15 rounded-full blur-[100px] sm:blur-[140px] pointer-events-none"></div>
            <div className="absolute top-10 right-10 w-48 sm:w-72 h-48 sm:h-72 bg-orange-600/10 rounded-full blur-[80px] sm:blur-[120px] pointer-events-none"></div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
              {/* Breadcrumb */}
              <div className="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 text-[11px] sm:text-xs font-semibold text-slate-400 mb-4">
                <Link href="/" className="hover:text-white transition-colors">Home</Link>
                <span>/</span>
                <Link href="/tools" className="hover:text-white transition-colors">Free Tools</Link>
                <span>/</span>
                <span className="text-[#ff3b30]">Project Cost Estimator</span>
              </div>

              <div className="inline-flex max-w-full items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-[10px] sm:text-xs font-semibold text-slate-300 mb-5 backdrop-blur-sm">
                <span className="w-2 h-2 rounded-full bg-[#ff3b30] animate-pulse shrink-0"></span>
                <span className="truncate">TRANSPARENT PRICING • INSTANT VECTOR PDF • 100% FREE</span>
              </div>

              <h1 className="text-2xl sm:text-4xl lg:text-6xl font-black tracking-tight leading-tight max-w-4xl mx-auto mb-4 text-white">
                Website &amp; Web App{' '}
                <span className="bg-gradient-to-r from-[#ff3b30] via-orange-400 to-red-400 bg-clip-text text-transparent">
                  Cost Estimator
                </span>
              </h1>

              <p className="text-xs sm:text-base lg:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed mb-6 sm:mb-8">
                Select your product scope, toggle enterprise modules, calculate transparent investment ranges, and download an official branded PDF quotation instantly.
              </p>

              {/* 1-Click Quick Preset Selector */}
              <div className="mb-6 flex flex-wrap items-center justify-center gap-2">
                <span className="text-[11px] font-bold text-slate-400 uppercase tracking-wider mr-1">Quick Presets:</span>
                <button
                  type="button"
                  onClick={() => applyPreset('mvp')}
                  className="px-3 py-1 rounded-full bg-white/5 hover:bg-white/10 text-slate-300 border border-white/10 text-xs font-semibold transition-colors cursor-pointer"
                >
                  🚀 Startup MVP
                </button>
                <button
                  type="button"
                  onClick={() => applyPreset('growth')}
                  className="px-3 py-1 rounded-full bg-red-500/15 hover:bg-red-500/25 text-[#ff3b30] border border-[#ff3b30]/30 text-xs font-bold transition-colors cursor-pointer"
                >
                  ⚡ Growth Scaler
                </button>
                <button
                  type="button"
                  onClick={() => applyPreset('enterprise')}
                  className="px-3 py-1 rounded-full bg-white/5 hover:bg-white/10 text-slate-300 border border-white/10 text-xs font-semibold transition-colors cursor-pointer"
                >
                  🏢 Enterprise Beast
                </button>
              </div>

              {/* Currency Selector Pill */}
              <div className="inline-flex items-center p-1 rounded-2xl bg-black/50 border border-white/10 backdrop-blur-md">
                <button
                  type="button"
                  onClick={() => setCurrency('INR')}
                  className={`px-4 sm:px-5 py-1.5 sm:py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer ${
                    currency === 'INR'
                      ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/30'
                      : 'text-slate-400 hover:text-white'
                  }`}
                >
                  <span>🇮🇳 INR (₹)</span>
                  <span className="text-[10px] opacity-80 hidden sm:inline">India</span>
                </button>
                <button
                  type="button"
                  onClick={() => setCurrency('USD')}
                  className={`px-4 sm:px-5 py-1.5 sm:py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer ${
                    currency === 'USD'
                      ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/30'
                      : 'text-slate-400 hover:text-white'
                  }`}
                >
                  <span>🇺🇸 USD ($)</span>
                  <span className="text-[10px] opacity-80 hidden sm:inline">Global</span>
                </button>
              </div>
            </div>
          </section>

          {/* Estimator Interactive Workspace */}
          <section className="py-10 sm:py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start w-full">
              
              {/* Left Column: Interactive Configuration (8 Cols) */}
              <div className="lg:col-span-8 space-y-8 sm:space-y-10 min-w-0 w-full">
                
                {/* Step 1: Project Archetype */}
                <div className="p-5 sm:p-7 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-sm">
                  <div className="flex items-center gap-3 mb-5">
                    <span className="w-8 h-8 rounded-xl bg-[#ff3b30]/10 border border-[#ff3b30]/30 text-[#ff3b30] flex items-center justify-center font-bold text-sm shrink-0">
                      1
                    </span>
                    <div>
                      <h2 className="text-lg sm:text-xl font-bold text-white">Select Project Archetype</h2>
                      <p className="text-xs text-slate-400">Choose the foundation that best matches your product requirements.</p>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                    {projectTypes.map((type) => {
                      const isSelected = projectType === type.id;
                      const priceVal = currency === 'INR' ? `₹${type.basePriceINR.toLocaleString()}` : `$${type.basePriceUSD}`;
                      return (
                        <div
                          key={type.id}
                          onClick={() => setProjectType(type.id)}
                          className={`relative p-4 sm:p-5 rounded-xl border transition-all cursor-pointer text-left select-none ${
                            isSelected
                              ? 'bg-red-500/10 border-[#ff3b30] shadow-lg shadow-red-500/15 ring-1 ring-[#ff3b30]'
                              : 'bg-white/[0.02] border-white/10 hover:border-white/20 hover:bg-white/[0.04]'
                          }`}
                        >
                          {type.popular && (
                            <span className="absolute top-3 right-3 text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full bg-[#ff3b30] text-white">
                              Popular
                            </span>
                          )}
                          <div className="flex items-center gap-3 mb-2">
                            <div className={`w-8 h-8 sm:w-9 sm:h-9 rounded-lg flex items-center justify-center text-sm shrink-0 ${isSelected ? 'bg-[#ff3b30] text-white' : 'bg-white/5 text-slate-300'}`}>
                              <i className={`fas ${type.icon}`}></i>
                            </div>
                            <h3 className="font-bold text-sm text-white truncate">{type.name}</h3>
                          </div>
                          <p className="text-xs text-slate-400 line-clamp-2 mb-3 leading-relaxed">{type.description}</p>
                          <div className="flex items-center justify-between text-xs pt-2 border-t border-white/5">
                            <span className="text-slate-500 text-[11px]">Starting from</span>
                            <span className="font-extrabold text-[#ff3b30] text-xs">{priceVal}</span>
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>

                {/* Step 2: Screen Scale & Traffic Tuner */}
                <div className="p-5 sm:p-7 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-sm space-y-6">
                  <div className="flex items-center gap-3">
                    <span className="w-8 h-8 rounded-xl bg-[#ff3b30]/10 border border-[#ff3b30]/30 text-[#ff3b30] flex items-center justify-center font-bold text-sm shrink-0">
                      2
                    </span>
                    <div>
                      <h2 className="text-lg sm:text-xl font-bold text-white">Scale &amp; Capacity Specifications</h2>
                      <p className="text-xs text-slate-400">Tune screen scope and infrastructure traffic demands.</p>
                    </div>
                  </div>

                  {/* Screen Scope Sub-Section */}
                  <div>
                    <label className="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-3">
                      Total Pages / Screens Scope
                    </label>
                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3">
                      {screenOptions.map((s) => {
                        const isSelected = screensRange === s.id;
                        const priceText = s.priceINR === 0 ? 'Included' : (currency === 'INR' ? `+₹${s.priceINR.toLocaleString()}` : `+$${s.priceUSD}`);
                        return (
                          <div
                            key={s.id}
                            onClick={() => setScreensRange(s.id)}
                            className={`p-3 rounded-xl border text-center cursor-pointer select-none transition-all ${
                              isSelected
                                ? 'bg-red-500/15 border-[#ff3b30] ring-1 ring-[#ff3b30]'
                                : 'bg-white/[0.02] border-white/10 hover:border-white/20'
                            }`}
                          >
                            <span className="font-bold text-xs text-white block truncate">{s.label}</span>
                            <span className="text-[10px] text-slate-400 block truncate">{s.sub}</span>
                            <span className="text-[10px] font-extrabold text-[#ff3b30] block mt-1">{priceText}</span>
                          </div>
                        );
                      })}
                    </div>
                  </div>

                  {/* Traffic / Cloud Hosting Sub-Section */}
                  <div>
                    <label className="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-3">
                      Target Monthly Traffic &amp; Cloud Infra
                    </label>
                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3">
                      {trafficOptions.map((t) => {
                        const isSelected = trafficScale === t.id;
                        const priceText = t.priceINR === 0 ? 'Included' : (currency === 'INR' ? `+₹${t.priceINR.toLocaleString()}` : `+$${t.priceUSD}`);
                        return (
                          <div
                            key={t.id}
                            onClick={() => setTrafficScale(t.id)}
                            className={`p-3 rounded-xl border text-left cursor-pointer select-none transition-all ${
                              isSelected
                                ? 'bg-red-500/15 border-[#ff3b30] ring-1 ring-[#ff3b30]'
                                : 'bg-white/[0.02] border-white/10 hover:border-white/20'
                            }`}
                          >
                            <div className="flex items-center justify-between mb-1">
                              <span className="font-bold text-xs text-white truncate">{t.label}</span>
                              <span className="text-[10px] font-bold text-[#ff3b30] shrink-0">{priceText}</span>
                            </div>
                            <span className="text-[10px] text-slate-400 block leading-tight">{t.sub}</span>
                          </div>
                        );
                      })}
                    </div>
                  </div>
                </div>

                {/* Step 3: Enterprise Modules & Feature Add-ons */}
                <div className="p-5 sm:p-7 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-sm">
                  <div className="flex items-center gap-3 mb-5">
                    <span className="w-8 h-8 rounded-xl bg-[#ff3b30]/10 border border-[#ff3b30]/30 text-[#ff3b30] flex items-center justify-center font-bold text-sm shrink-0">
                      3
                    </span>
                    <div>
                      <h2 className="text-lg sm:text-xl font-bold text-white">Select Features &amp; Modules</h2>
                      <p className="text-xs text-slate-400">Toggle specific high-performance engineering modules to fit your scope.</p>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    {featureList.map((feat) => {
                      const isChecked = selectedFeatures.includes(feat.id);
                      const priceVal = currency === 'INR' ? `+₹${feat.priceINR.toLocaleString()}` : `+$${feat.priceUSD}`;
                      return (
                        <div
                          key={feat.id}
                          onClick={() => toggleFeature(feat.id)}
                          className={`p-3.5 sm:p-4 rounded-xl border transition-all cursor-pointer flex items-start gap-3 select-none ${
                            isChecked
                              ? 'bg-red-500/10 border-[#ff3b30]/60 ring-1 ring-[#ff3b30]/40'
                              : 'bg-white/[0.02] border-white/10 hover:border-white/20'
                          }`}
                        >
                          <div className={`mt-0.5 w-5 h-5 rounded-md flex items-center justify-center text-xs transition-colors shrink-0 ${isChecked ? 'bg-[#ff3b30] text-white' : 'border border-slate-600 bg-black/40'}`}>
                            {isChecked && <i className="fas fa-check text-[10px]"></i>}
                          </div>
                          <div className="flex-1 min-w-0">
                            <div className="flex items-center justify-between gap-2 mb-1">
                              <span className="font-semibold text-xs text-white truncate">{feat.name}</span>
                              <span className="text-[11px] font-bold text-[#ff3b30] shrink-0">{priceVal}</span>
                            </div>
                            <p className="text-[11px] text-slate-400 leading-tight">{feat.desc}</p>
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>

                {/* Step 4: UI/UX & Polish Level */}
                <div className="p-5 sm:p-7 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-sm">
                  <div className="flex items-center gap-3 mb-5">
                    <span className="w-8 h-8 rounded-xl bg-[#ff3b30]/10 border border-[#ff3b30]/30 text-[#ff3b30] flex items-center justify-center font-bold text-sm shrink-0">
                      4
                    </span>
                    <div>
                      <h2 className="text-lg sm:text-xl font-bold text-white">Visual Design &amp; Aesthetics Tier</h2>
                      <p className="text-xs text-slate-400">Choose the depth of micro-animations, styling, and visual wow-factor.</p>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    {designOptions.map((opt) => {
                      const isSelected = designLevel === opt.id;
                      const priceVal = opt.priceINR === 0 ? 'Standard' : (currency === 'INR' ? `+₹${opt.priceINR.toLocaleString()}` : `+$${opt.priceUSD}`);
                      return (
                        <div
                          key={opt.id}
                          onClick={() => setDesignLevel(opt.id)}
                          className={`p-3.5 sm:p-4 rounded-xl border cursor-pointer select-none transition-all ${
                            isSelected
                              ? 'bg-red-500/10 border-[#ff3b30] ring-1 ring-[#ff3b30]'
                              : 'bg-white/[0.02] border-white/10 hover:border-white/20'
                          }`}
                        >
                          <div className="flex items-center justify-between mb-1.5">
                            <span className="font-bold text-xs text-white">{opt.name}</span>
                            <span className="text-[10px] font-semibold text-[#ff3b30] shrink-0">{priceVal}</span>
                          </div>
                          <p className="text-[11px] text-slate-400 leading-tight">{opt.desc}</p>
                        </div>
                      );
                    })}
                  </div>
                </div>

                {/* Step 5: Urgency & Delivery Sprint */}
                <div className="p-5 sm:p-7 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-sm">
                  <div className="flex items-center gap-3 mb-5">
                    <span className="w-8 h-8 rounded-xl bg-[#ff3b30]/10 border border-[#ff3b30]/30 text-[#ff3b30] flex items-center justify-center font-bold text-sm shrink-0">
                      5
                    </span>
                    <div>
                      <h2 className="text-lg sm:text-xl font-bold text-white">Launch Urgency &amp; Sprint Pace</h2>
                      <p className="text-xs text-slate-400">Do you have a fixed hard deadline or standard engineering sprints?</p>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    {urgencyOptions.map((opt) => {
                      const isSelected = urgency === opt.id;
                      return (
                        <div
                          key={opt.id}
                          onClick={() => setUrgency(opt.id)}
                          className={`p-3.5 sm:p-4 rounded-xl border cursor-pointer select-none transition-all ${
                            isSelected
                              ? 'bg-red-500/10 border-[#ff3b30] ring-1 ring-[#ff3b30]'
                              : 'bg-white/[0.02] border-white/10 hover:border-white/20'
                          }`}
                        >
                          <div className="flex items-center justify-between mb-1">
                            <span className="font-bold text-xs text-white">{opt.name}</span>
                            {opt.id === 'rush' && (
                              <span className="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-400">
                                Sprint 2x
                              </span>
                            )}
                          </div>
                          <p className="text-[11px] text-slate-400 leading-tight">{opt.desc}</p>
                        </div>
                      );
                    })}
                  </div>
                </div>

                {/* Smart Tech Stack Box */}
                <div className="p-5 sm:p-6 rounded-2xl bg-white/[0.02] border border-white/10">
                  <h3 className="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                    <i className="fas fa-microchip text-[#ff3b30]"></i>
                    <span>Tailored Production Tech Stack Recommendation</span>
                  </h3>
                  <div className="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    {techStackBadges.map((badge, idx) => (
                      <div key={idx} className="p-2.5 rounded-lg bg-black/40 border border-white/5 flex items-center gap-2.5">
                        <i className={`${badge.icon} text-slate-300 text-sm`}></i>
                        <div className="min-w-0">
                          <span className="text-xs font-bold text-white block truncate">{badge.name}</span>
                          <span className="text-[10px] text-slate-400 block truncate">{badge.role}</span>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>

              </div>

              {/* Right Column: Sticky Summary Panel (4 Cols) */}
              <div className="lg:col-span-4 lg:sticky lg:top-28 space-y-6 min-w-0 w-full">
                
                {/* Main Investment Summary Card */}
                <div className="p-5 sm:p-7 rounded-2xl bg-[#1c1b1a] border border-white/15 shadow-2xl relative overflow-hidden w-full">
                  <div className="absolute top-0 right-0 w-48 h-48 bg-red-600/10 rounded-full blur-[80px] pointer-events-none"></div>

                  <div className="flex items-center justify-between mb-4">
                    <span className="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                      Estimated Investment
                    </span>
                    <span className="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded-full">
                      Live Estimate
                    </span>
                  </div>

                  {/* Price Range Big Display */}
                  <div className="mb-4">
                    <div className="text-2xl sm:text-3xl font-black text-white tracking-tight break-words">
                      {calculation.displayRange}
                    </div>
                    <p className="text-[11px] text-slate-400 mt-1">
                      Milestone-based budget. No hidden recurring platform fees.
                    </p>
                  </div>

                  {/* Key Metrics Grid */}
                  <div className="grid grid-cols-2 gap-3 py-4 border-y border-white/10 my-4 text-left">
                    <div>
                      <span className="text-[10px] text-slate-500 block uppercase font-bold">Timeline</span>
                      <span className="text-xs sm:text-sm font-bold text-white flex items-center gap-1.5 mt-0.5 truncate">
                        <i className="fas fa-clock text-[#ff3b30] text-xs"></i>
                        {calculation.timelineWeeks}
                      </span>
                    </div>
                    <div>
                      <span className="text-[10px] text-slate-500 block uppercase font-bold">Scope</span>
                      <span className="text-xs sm:text-sm font-bold text-white flex items-center gap-1.5 mt-0.5 truncate">
                        <i className="fas fa-layer-group text-orange-400 text-xs"></i>
                        {calculation.curScreen.label}
                      </span>
                    </div>
                  </div>

                  {/* Inclusions Checklist */}
                  <div className="space-y-2 mb-6 text-left">
                    <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">
                      Included with All Deployments:
                    </span>
                    <div className="flex items-center gap-2 text-xs text-slate-300">
                      <i className="fas fa-check-circle text-emerald-400 text-xs shrink-0"></i>
                      <span className="truncate">100% Source Code &amp; Git Ownership</span>
                    </div>
                    <div className="flex items-center gap-2 text-xs text-slate-300">
                      <i className="fas fa-check-circle text-emerald-400 text-xs shrink-0"></i>
                      <span className="truncate">30-Day Post-Launch Bug-Free Warranty</span>
                    </div>
                    <div className="flex items-center gap-2 text-xs text-slate-300">
                      <i className="fas fa-check-circle text-emerald-400 text-xs shrink-0"></i>
                      <span className="truncate">Core Web Vitals &lt; 1.2s Speed Audit</span>
                    </div>
                    <div className="flex items-center gap-2 text-xs text-slate-300">
                      <i className="fas fa-check-circle text-emerald-400 text-xs shrink-0"></i>
                      <span className="truncate">Structured Schema JSON-LD Setup</span>
                    </div>
                  </div>

                  {/* Primary CTA: Generate PDF Proposal */}
                  <button
                    type="button"
                    onClick={() => {
                      setSubmitSuccess(false);
                      setShowModal(true);
                    }}
                    className="w-full py-3.5 sm:py-4 rounded-xl bg-[#ff3b30] hover:bg-[#e03126] text-white font-extrabold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-all shadow-xl shadow-red-500/25 active:scale-98 cursor-pointer"
                  >
                    <i className="fas fa-file-pdf text-sm"></i>
                    <span>Download Official PDF Proposal</span>
                  </button>

                  {/* Secondary WhatsApp Action */}
                  <a
                    href={`https://wa.me/917891223456?text=${encodeURIComponent(`Hi Rankexa, I configured a ${calculation.curType.name} (${calculation.curScreen.label}) scope on your cost estimator. Expected range: ${calculation.displayRange}. Let's discuss!`)}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="mt-3 w-full py-2.5 sm:py-3 rounded-xl bg-white/5 hover:bg-white/10 text-slate-200 font-bold text-xs flex items-center justify-center gap-2 transition-all border border-white/10"
                  >
                    <i className="fab fa-whatsapp text-emerald-400 text-sm"></i>
                    <span>Quick Discuss on WhatsApp</span>
                  </a>
                </div>

                {/* Security & NDA Badge */}
                <div className="p-4 sm:p-5 rounded-xl bg-white/[0.02] border border-white/5 text-xs text-slate-400 space-y-2 text-left">
                  <div className="flex items-center gap-2 font-bold text-white text-xs">
                    <i className="fas fa-shield-halved text-emerald-400"></i>
                    <span>Mutual Non-Disclosure Agreement</span>
                  </div>
                  <p className="text-[11px] leading-relaxed">
                    Your architecture and requirements remain confidential. We sign NDAs prior to repository provisioning.
                  </p>
                </div>
              </div>

            </div>
          </section>

          {/* Proposal Download Modal */}
          {showModal && (
            <div className="fixed inset-0 z-[10005] bg-black/80 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
              <div className="bg-[#1c1b1a] border border-white/15 rounded-2xl w-full max-w-lg p-5 sm:p-8 relative shadow-2xl my-auto text-left">
                <button
                  type="button"
                  onClick={() => setShowModal(false)}
                  className="absolute top-4 right-4 text-slate-400 hover:text-white text-lg p-1.5 rounded-full hover:bg-white/5 transition-colors cursor-pointer"
                  aria-label="Close modal"
                >
                  <i className="fas fa-times"></i>
                </button>

                {!submitSuccess ? (
                  <div>
                    <div className="flex items-center gap-2 mb-2 text-[#ff3b30] text-xs font-bold uppercase tracking-wider">
                      <i className="fas fa-file-pdf"></i>
                      <span>Instant PDF Quotation</span>
                    </div>

                    <h3 className="text-lg sm:text-xl font-bold text-white mb-2">
                      Where should we send your Proposal?
                    </h3>
                    <p className="text-xs text-slate-400 mb-5">
                      Enter your details below to generate a tailored, multi-page vector PDF containing your exact deliverables, line-item specs, and milestones.
                    </p>

                    {submitError && (
                      <div className="p-3 mb-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs">
                        {submitError}
                      </div>
                    )}

                    <form onSubmit={handleSubmitProposal} className="space-y-3.5">
                      <div>
                        <label className="block text-xs font-semibold text-slate-300 mb-1">
                          Full Name <span className="text-[#ff3b30]">*</span>
                        </label>
                        <input
                          type="text"
                          required
                          value={formData.name}
                          onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                          placeholder="e.g. Alex Morgan"
                          className="w-full px-3.5 py-2.5 rounded-xl bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] transition-colors"
                        />
                      </div>

                      <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                          <label className="block text-xs font-semibold text-slate-300 mb-1">
                            Work Email <span className="text-[#ff3b30]">*</span>
                          </label>
                          <input
                            type="email"
                            required
                            value={formData.email}
                            onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                            placeholder="alex@company.com"
                            className="w-full px-3.5 py-2.5 rounded-xl bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] transition-colors"
                          />
                        </div>
                        <div>
                          <label className="block text-xs font-semibold text-slate-300 mb-1">
                            WhatsApp / Phone
                          </label>
                          <input
                            type="tel"
                            value={formData.phone}
                            onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                            placeholder="+91 98765 43210"
                            className="w-full px-3.5 py-2.5 rounded-xl bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] transition-colors"
                          />
                        </div>
                      </div>

                      <div>
                        <label className="block text-xs font-semibold text-slate-300 mb-1">
                          Company Name / Target Website
                        </label>
                        <input
                          type="text"
                          value={formData.company}
                          onChange={(e) => setFormData({ ...formData, company: e.target.value })}
                          placeholder="e.g. Acme Tech or mybrand.com"
                          className="w-full px-3.5 py-2.5 rounded-xl bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] transition-colors"
                        />
                      </div>

                      <div>
                        <label className="block text-xs font-semibold text-slate-300 mb-1">
                          Special Requirements or Architecture Notes (Optional)
                        </label>
                        <textarea
                          rows={2}
                          value={formData.notes}
                          onChange={(e) => setFormData({ ...formData, notes: e.target.value })}
                          placeholder="e.g. Need migration from WordPress to Next.js with Razorpay integration."
                          className="w-full px-3.5 py-2 rounded-xl bg-black/50 border border-white/10 text-white text-xs focus:outline-none focus:border-[#ff3b30] transition-colors resize-none"
                        ></textarea>
                      </div>

                      <div className="pt-2">
                        <button
                          type="submit"
                          disabled={isSubmitting}
                          className="w-full py-3.5 rounded-xl bg-[#ff3b30] hover:bg-[#e03126] disabled:opacity-50 text-white font-extrabold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-all cursor-pointer shadow-lg shadow-red-500/20"
                        >
                          {isSubmitting ? (
                            <>
                              <i className="fas fa-circle-notch fa-spin text-sm"></i>
                              <span>Generating Vector PDF...</span>
                            </>
                          ) : (
                            <>
                              <i className="fas fa-file-download text-sm"></i>
                              <span>Confirm &amp; Download Proposal</span>
                            </>
                          )}
                        </button>
                      </div>
                    </form>
                  </div>
                ) : (
                  <div className="text-center py-3">
                    <div className="w-14 h-14 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-xl mx-auto mb-3">
                      <i className="fas fa-circle-check"></i>
                    </div>

                    <h3 className="text-lg sm:text-xl font-bold text-white mb-1.5">Proposal Generated &amp; Downloaded!</h3>
                    <p className="text-xs text-slate-300 max-w-sm mx-auto mb-5">
                      Your proposal <span className="font-mono text-[#ff3b30] font-bold">{downloadedProposalId}</span> has been downloaded to your device and logged with Rankexa senior architects.
                    </p>

                    <div className="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 text-left text-xs space-y-1.5 mb-5">
                      <div className="flex justify-between">
                        <span className="text-slate-400">Scope:</span>
                        <span className="font-bold text-white truncate max-w-[200px]">{calculation.curType.name}</span>
                      </div>
                      <div className="flex justify-between">
                        <span className="text-slate-400">Budget Range:</span>
                        <span className="font-bold text-emerald-400">{calculation.displayRange}</span>
                      </div>
                      <div className="flex justify-between">
                        <span className="text-slate-400">Target Timeline:</span>
                        <span className="font-bold text-white">{calculation.timelineWeeks}</span>
                      </div>
                    </div>

                    <div className="flex flex-col sm:flex-row gap-2.5">
                      <button
                        type="button"
                        onClick={() => generateProposalPDF(downloadedProposalId, formData.name, formData.company)}
                        className="flex-1 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold text-xs flex items-center justify-center gap-2 cursor-pointer transition-colors"
                      >
                        <i className="fas fa-arrow-down"></i>
                        <span>Re-download PDF</span>
                      </button>
                      <button
                        type="button"
                        onClick={() => setShowModal(false)}
                        className="flex-1 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-[#e03126] text-white font-bold text-xs cursor-pointer transition-colors"
                      >
                        Done
                      </button>
                    </div>
                  </div>
                )}
              </div>
            </div>
          )}
        </div>
      )}
    </AppLayout>
  );
}
