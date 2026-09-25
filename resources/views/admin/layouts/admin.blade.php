<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900 text-slate-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Console') | WebRanker Control Center</title>

  <!-- Site Title Favicon (WR Monogram) -->
  <link rel="icon" type="image/svg+xml" href="{{ asset('asset/wr-favicon.svg') }}">
  <link rel="alternate icon" type="image/png" href="{{ asset('asset/wr-favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('asset/wr-favicon.png') }}">

  <!-- Google Fonts: Urbanist & JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Urbanist', 'sans-serif'],
            mono: ['JetBrains Mono', 'monospace'],
          },
          colors: {
            themeRed: '#ff3b30',
          }
        }
      }
    }
  </script>

  <!-- FontAwesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Immediate Theme Initialization to Prevent Flash of Dark/Light -->
  <script>
    (function() {
      var savedTheme = localStorage.getItem('admin_theme') || 'light';
      if (savedTheme === 'light') {
        document.documentElement.classList.add('theme-light');
      } else {
        document.documentElement.classList.remove('theme-light');
      }
    })();
  </script>

  <style>
    /* ----------------------------------------------------
       PREMIUM LIGHT MODE STYLES
       ---------------------------------------------------- */
    html.theme-light, 
    html.theme-light body {
      background-color: #f8fafc !important;
      color: #1e293b !important;
    }

    html.theme-light aside {
      background-color: #ffffff !important;
      border-color: #e2e8f0 !important;
      box-shadow: 1px 0 10px rgba(0, 0, 0, 0.03);
    }

    html.theme-light aside .border-b,
    html.theme-light aside .border-t {
      border-color: #f1f5f9 !important;
    }

    html.theme-light header {
      background-color: rgba(255, 255, 255, 0.88) !important;
      border-color: #e2e8f0 !important;
      backdrop-filter: blur(8px);
    }

    html.theme-light .bg-slate-950,
    html.theme-light .bg-slate-950\/50,
    html.theme-light .bg-slate-950\/60,
    html.theme-light .bg-slate-950\/70,
    html.theme-light .bg-slate-950\/80,
    html.theme-light .bg-slate-900 {
      background-color: #ffffff !important;
    }

    html.theme-light thead.bg-slate-950\/80,
    html.theme-light thead.bg-slate-950\/60,
    html.theme-light tr.bg-slate-950\/60 {
      background-color: #f8fafc !important;
    }

    html.theme-light .bg-slate-900\/60,
    html.theme-light .bg-slate-900\/80 {
      background-color: rgba(255, 255, 255, 0.9) !important;
    }

    html.theme-light .bg-slate-800,
    html.theme-light .bg-slate-800\/40,
    html.theme-light .bg-slate-800\/50,
    html.theme-light .bg-slate-800\/60,
    html.theme-light .bg-slate-800\/70,
    html.theme-light .bg-slate-800\/80,
    html.theme-light .bg-slate-800\/90 {
      background-color: #f1f5f9 !important;
    }

    html.theme-light .hover\:bg-slate-800:hover,
    html.theme-light .hover\:bg-slate-800\/40:hover,
    html.theme-light .hover\:bg-slate-800\/50:hover,
    html.theme-light .hover\:bg-slate-800\/60:hover,
    html.theme-light .hover\:bg-slate-800\/80:hover {
      background-color: #f8fafc !important;
    }

    html.theme-light .hover\:bg-slate-700:hover,
    html.theme-light .hover\:bg-slate-700\/80:hover {
      background-color: #e2e8f0 !important;
      color: #0f172a !important;
    }

    html.theme-light .border-slate-800,
    html.theme-light .border-slate-800\/40,
    html.theme-light .border-slate-800\/50,
    html.theme-light .border-slate-800\/60,
    html.theme-light .border-slate-800\/80,
    html.theme-light .border-slate-700,
    html.theme-light .border-slate-700\/40,
    html.theme-light .border-slate-700\/50,
    html.theme-light .border-slate-700\/60,
    html.theme-light .border-slate-700\/80 {
      border-color: #e2e8f0 !important;
    }

    html.theme-light .divide-slate-800,
    html.theme-light .divide-slate-800\/60 {
      border-color: #f1f5f9 !important;
    }

    /* Text contrast overrides */
    html.theme-light .text-white {
      color: #0f172a !important;
    }

    html.theme-light .text-slate-100,
    html.theme-light .text-slate-200 {
      color: #1e293b !important;
    }

    html.theme-light .text-slate-300 {
      color: #334155 !important;
    }

    html.theme-light .text-slate-400 {
      color: #64748b !important;
    }

    html.theme-light .text-slate-500 {
      color: #64748b !important;
    }

    /* Keep button text white when on theme red, blue, or dark buttons */
    html.theme-light .bg-\[\#ff3b30\],
    html.theme-light .bg-\[\#ff3b30\] *,
    html.theme-light a.bg-\[\#ff3b30\],
    html.theme-light button.bg-\[\#ff3b30\],
    html.theme-light a.bg-\[\#ff3b30\] *,
    html.theme-light button.bg-\[\#ff3b30\] * {
      color: #ffffff !important;
    }

    html.theme-light .bg-white\/20 {
      background-color: rgba(255, 255, 255, 0.25) !important;
      color: #ffffff !important;
    }

    /* Form Controls */
    html.theme-light input:not([type="checkbox"]):not([type="radio"]),
    html.theme-light textarea,
    html.theme-light select {
      background-color: #ffffff !important;
      color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }

    html.theme-light input:focus,
    html.theme-light textarea:focus,
    html.theme-light select:focus {
      border-color: #ff3b30 !important;
      background-color: #ffffff !important;
    }

    html.theme-light input::placeholder,
    html.theme-light textarea::placeholder {
      color: #94a3b8 !important;
    }

    /* Cards shadow in light mode */
    html.theme-light .rounded-2xl.border,
    html.theme-light .rounded-xl.border {
      box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.04), 0 1px 2px -1px rgb(0 0 0 / 0.04);
    }

    /* Status and Category chips */
    html.theme-light .category-checkbox-item {
      border-color: #e2e8f0 !important;
      background-color: #ffffff !important;
    }

    html.theme-light .category-checkbox-item:hover {
      background-color: #f8fafc !important;
      border-color: #cbd5e1 !important;
    }

    html.theme-light .category-checkbox-item.checked {
      background-color: #fef2f2 !important;
      border-color: rgba(255, 59, 48, 0.4) !important;
    }

    html.theme-light .border-l-slate-800 {
      border-left-color: #e2e8f0 !important;
    }

    /* Semi-transparent dark cards & containers in light mode (e.g. Section 4, SEO Audit card, file uploads) */
    html.theme-light .bg-slate-950\/70,
    html.theme-light .bg-slate-950\/80,
    html.theme-light .bg-slate-950\/60,
    html.theme-light .bg-slate-950\/50,
    html.theme-light .bg-slate-950\/40,
    html.theme-light .bg-slate-950\/30,
    html.theme-light .bg-slate-950\/20,
    html.theme-light .bg-slate-900\/70,
    html.theme-light .bg-slate-900\/50,
    html.theme-light .bg-slate-900\/40,
    html.theme-light .bg-slate-900\/30 {
      background-color: #f8fafc !important;
      border-color: #e2e8f0 !important;
    }

    /* Inner card text in light mode */
    html.theme-light .bg-slate-950\/70 .text-white,
    html.theme-light .bg-slate-950\/80 .text-white,
    html.theme-light .bg-slate-950 .text-white,
    html.theme-light .bg-slate-900 .text-white,
    html.theme-light .bg-slate-950\/70 [class*="text-white"],
    html.theme-light .bg-slate-950\/80 [class*="text-white"] {
      color: #0f172a !important;
    }

    html.theme-light .bg-slate-950\/70 .text-slate-400,
    html.theme-light .bg-slate-950\/80 .text-slate-400,
    html.theme-light .bg-slate-950 .text-slate-400,
    html.theme-light .bg-slate-900 .text-slate-400,
    html.theme-light .bg-slate-950\/70 [class*="text-slate-400"],
    html.theme-light .bg-slate-950\/80 [class*="text-slate-400"] {
      color: #64748b !important;
    }

    /* Switch toggles in light mode */
    html.theme-light .peer:not(:checked) ~ div.bg-slate-800 {
      background-color: #cbd5e1 !important;
    }

    /* Status badge inside Section 4 */
    html.theme-light #scheduleStatusBadge,
    html.theme-light .bg-slate-800.text-slate-400 {
      background-color: #e2e8f0 !important;
      color: #334155 !important;
    }

    /* CKEditor Universal Link Styling - Theme Color (#ff3b30) */
    .ck-content a,
    .ck.ck-editor__main .ck-content a {
      color: #ff3b30 !important;
      text-decoration: underline !important;
      text-decoration-color: rgba(255, 59, 48, 0.6) !important;
      text-underline-offset: 3px !important;
      font-weight: 700 !important;
      cursor: pointer !important;
    }
    .ck-content a:hover,
    .ck.ck-editor__main .ck-content a:hover {
      color: #dc2626 !important;
      text-decoration-color: #dc2626 !important;
    }
    .ck.ck-balloon-panel a.ck-link-actions__preview {
      color: #ff3b30 !important;
      text-decoration: underline !important;
      font-weight: 700 !important;
    }

    /* CKEditor Light Mode Styling */
    html.theme-light .ck.ck-editor__main > .ck-editor__editable {
      background-color: #ffffff !important;
      color: #0f172a !important;
      border-color: #cbd5e1 !important;
      scrollbar-color: #ff3b30 #f1f5f9 !important;
    }
    html.theme-light .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-track {
      background: #f1f5f9 !important;
    }
    html.theme-light .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-thumb {
      background-color: #cbd5e1 !important;
    }
    html.theme-light .ck.ck-editor__main > .ck-editor__editable::-webkit-scrollbar-thumb:hover {
      background-color: #ff3b30 !important;
    }
    html.theme-light .ck.ck-toolbar {
      background-color: #f8fafc !important;
      border-color: #cbd5e1 !important;
    }
    html.theme-light .ck.ck-toolbar .ck-toolbar__separator {
      background-color: #e2e8f0 !important;
    }
    html.theme-light .ck.ck-button {
      color: #475569 !important;
    }
    html.theme-light .ck.ck-button:hover,
    html.theme-light .ck.ck-button.ck-on {
      background-color: #e2e8f0 !important;
      color: #0f172a !important;
    }
    html.theme-light .ck.ck-dropdown__panel {
      background-color: #ffffff !important;
      border-color: #cbd5e1 !important;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1) !important;
    }
    html.theme-light .ck.ck-list__item .ck-button {
      color: #334155 !important;
    }
    html.theme-light .ck.ck-list__item .ck-button:hover {
      background-color: #f1f5f9 !important;
      color: #0f172a !important;
    }
    html.theme-light .ck.ck-balloon-panel {
      background-color: #ffffff !important;
      border-color: #cbd5e1 !important;
      color: #0f172a !important;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1) !important;
    }
    html.theme-light .ck.ck-balloon-panel .ck-button {
      color: #475569 !important;
    }
    html.theme-light .ck.ck-balloon-panel .ck-button:hover {
      background-color: #f1f5f9 !important;
      color: #0f172a !important;
    }
    html.theme-light .ck.ck-labeled-field-view > .ck-input {
      background-color: #f8fafc !important;
      color: #0f172a !important;
      border-color: #cbd5e1 !important;
    }

    html.theme-light footer {
      border-color: #e2e8f0 !important;
      color: #94a3b8 !important;
    }
  </style>
  @stack('admin_styles')
</head>
<body class="h-full font-sans antialiased bg-slate-950 text-slate-200">

  <div class="min-h-full flex flex-col lg:flex-row">

    <!-- Sidebar Navigation -->
    <aside class="w-full lg:w-64 bg-slate-900 border-r border-slate-800 shrink-0 flex flex-col justify-between">
      <div>
        <!-- Brand Header -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800">
          <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-extrabold text-xl text-white">
            <span class="w-8 h-8 rounded-lg bg-[#ff3b30] flex items-center justify-center text-white text-xs font-black tracking-tight shadow-md shadow-red-500/20">
              WR
            </span>
            <span>Web<span class="text-[#ff3b30]">Ranker</span> <span class="text-xs uppercase px-1.5 py-0.5 rounded bg-slate-800 text-slate-400 font-mono">Admin</span></span>
          </a>
        </div>

        <!-- Navigation Links -->
        <nav class="p-4 space-y-1.5 text-sm font-semibold">
          <a href="{{ route('admin.dashboard') }}"
             class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
            <i class="fas fa-gauge-high w-4 text-center"></i>
            <span>Overview Dashboard</span>
          </a>

          <a href="{{ route('admin.homepage.index') }}"
             class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.homepage.*') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
            <i class="fas fa-house-chimney w-4 text-center"></i>
            <span>Home Page</span>
          </a>

          <a href="{{ route('admin.schema.index') }}"
             class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.schema.*') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
            <i class="fas fa-sitemap w-4 text-center"></i>
            <span>Schema &amp; SEO Center</span>
          </a>

          <!-- Services Management Menu -->
          @php
            $isServicesActive = request()->routeIs('admin.services.*');
            $serviceCount = \App\Models\Service::count();
          @endphp
          <div class="pt-1">
            <div class="px-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-500">Services Catalog</div>
            <div class="space-y-1">
              <a href="{{ route('admin.services.index') }}"
                 class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.services.index') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : ($isServicesActive ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60') }}">
                <div class="flex items-center gap-3">
                  <i class="fas fa-layer-group w-4 text-center"></i>
                  <span>All Services</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs font-mono font-bold {{ request()->routeIs('admin.services.index') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400' }}">
                  {{ $serviceCount }}
                </span>
              </a>

              <a href="{{ route('admin.services.create') }}"
                 class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold transition-colors {{ request()->routeIs('admin.services.create') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 pl-8' }}">
                <i class="fas fa-plus-circle w-3.5 text-center text-emerald-400"></i>
                <span>Add Service</span>
              </a>

              <a href="{{ route('admin.services.categories') }}"
                 class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold transition-colors {{ request()->routeIs('admin.services.categories') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 pl-8' }}">
                <i class="fas fa-tags w-3.5 text-center text-amber-400"></i>
                <span>Dynamic Categories</span>
              </a>
            </div>
          </div>

          <!-- Industries & Verticals Menu -->
          @php
            $isIndustriesActive = request()->routeIs('admin.industries.*');
            $industryCount = \App\Models\IndustryDomain::count();
          @endphp
          <div class="pt-1">
            <div class="px-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-500">Industries &amp; Verticals</div>
            <div class="space-y-1">
              <a href="{{ route('admin.industries.index') }}"
                 class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.industries.index') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : ($isIndustriesActive ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60') }}">
                <div class="flex items-center gap-3">
                  <i class="fas fa-building w-4 text-center"></i>
                  <span>All Industries</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs font-mono font-bold {{ request()->routeIs('admin.industries.index') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400' }}">
                  {{ $industryCount }}
                </span>
              </a>

              <a href="{{ route('admin.industries.create') }}"
                 class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold transition-colors {{ request()->routeIs('admin.industries.create') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 pl-8' }}">
                <i class="fas fa-plus-circle w-3.5 text-center text-emerald-400"></i>
                <span>Add Industry</span>
              </a>
            </div>
          </div>

          <!-- Blog Management Menu -->
          @php
            $isBlogsActive = request()->routeIs('admin.blogs.*');
            $blogCount = \App\Models\BlogPost::count();
          @endphp
          <div class="pt-1">
            <div class="px-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-500">Blog Articles</div>
            <div class="space-y-1">
              <a href="{{ route('admin.blogs.index') }}"
                 class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.blogs.index') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : ($isBlogsActive ? 'bg-slate-800 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60') }}">
                <div class="flex items-center gap-3">
                  <i class="fas fa-newspaper w-4 text-center"></i>
                  <span>All Articles</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs font-mono font-bold {{ request()->routeIs('admin.blogs.index') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400' }}">
                  {{ $blogCount }}
                </span>
              </a>

              <a href="{{ route('admin.blogs.create') }}"
                 class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold transition-colors {{ request()->routeIs('admin.blogs.create') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 pl-8' }}">
                <i class="fas fa-plus-circle w-3.5 text-center text-emerald-400"></i>
                <span>Add Article</span>
              </a>

              <a href="{{ route('admin.blogs.categories') }}"
                 class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-xs font-semibold transition-colors {{ request()->routeIs('admin.blogs.categories') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60 pl-8' }}">
                <i class="fas fa-tags w-3.5 text-center text-amber-400"></i>
                <span>Categories</span>
              </a>
            </div>
          </div>

          <a href="{{ route('admin.inquiries.index') }}"
             class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.inquiries.*') ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
            <div class="flex items-center gap-3">
              <i class="fas fa-inbox w-4 text-center"></i>
              <span>Inquiries &amp; Leads</span>
            </div>
            @php $newCount = \App\Models\Inquiry::where('status', 'new')->count(); @endphp
            @if($newCount > 0)
              <span class="px-2 py-0.5 rounded-full text-xs bg-red-500/20 text-red-400 font-bold border border-red-500/30">{{ $newCount }}</span>
            @endif
          </a>

          <!-- Client Link Requests & Monetization -->
          @php
            $isLinkReqActive = request()->routeIs('admin.link_requests.*');
            $pendingLinksCount = \App\Models\LinkRequest::where('status', 'pending')->count();
          @endphp
          <a href="{{ route('admin.link_requests.index') }}"
             class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-colors {{ $isLinkReqActive ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
            <div class="flex items-center gap-3">
              <i class="fas fa-link w-4 text-center text-amber-400"></i>
              <span>Link Requests</span>
            </div>
            @if($pendingLinksCount > 0)
              <span class="px-2 py-0.5 rounded-full text-xs bg-purple-500/20 text-purple-300 font-bold border border-purple-500/30">{{ $pendingLinksCount }}</span>
            @endif
          </a>

          <!-- Free AI SEO & Speed Audits (Feature 2) -->
          @php
            $isAuditActive = request()->routeIs('admin.audits.*');
            $totalAuditsCount = \App\Models\AiAudit::count();
          @endphp
          <a href="{{ route('admin.audits.index') }}"
             class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-colors {{ $isAuditActive ? 'bg-[#ff3b30] text-white shadow-lg shadow-red-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
            <div class="flex items-center gap-3">
              <i class="fas fa-gauge-high w-4 text-center text-emerald-400"></i>
              <span>SEO &amp; Speed Audits</span>
            </div>
            @if($totalAuditsCount > 0)
              <span class="px-2 py-0.5 rounded-full text-xs bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30">{{ $totalAuditsCount }}</span>
            @endif
          </a>
        </nav>
      </div>

      <!-- Footer Quick Links -->
      <div class="p-4 border-t border-slate-800 space-y-2">
        <a href="{{ route('home') }}" target="_blank"
           class="flex items-center justify-between w-full px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800/60 transition-colors">
          <span class="flex items-center gap-2">
            <i class="fas fa-arrow-up-right-from-square"></i> Live Website
          </span>
          <i class="fas fa-chevron-right text-[10px] text-slate-600"></i>
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit"
                  class="flex items-center gap-2 w-full px-3.5 py-2 rounded-xl text-xs font-semibold text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
            <i class="fas fa-right-from-bracket"></i> Sign Out
          </button>
        </form>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 bg-slate-950">

      <!-- Top Header -->
      <header class="h-16 border-b border-slate-800 bg-slate-900/60 backdrop-blur-md px-6 flex items-center justify-between sticky top-0 z-30">
        <div class="flex items-center gap-3">
          <h1 class="text-lg font-bold text-white">@yield('page_title', 'Dashboard')</h1>
        </div>

        <div class="flex items-center gap-3 text-sm">
          <span class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-semibold border border-emerald-500/20">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Live Schema Engine Active
          </span>

          <!-- Dark / Light Theme Toggle Icon Button -->
          <button type="button" id="adminThemeToggle"
                  class="w-9 h-9 rounded-xl flex items-center justify-center transition-all border border-slate-700 bg-slate-800 text-amber-400 hover:text-amber-300 hover:scale-105 active:scale-95 shadow-sm cursor-pointer"
                  title="Toggle Light / Dark Mode">
            <i id="themeToggleIcon" class="fas fa-sun text-sm"></i>
          </button>

          <div class="flex items-center gap-2.5 pl-3 border-l border-slate-800">
            <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-slate-200">
              <i class="fas fa-user-shield"></i>
            </div>
            <span class="text-xs font-medium text-slate-300">{{ auth()->user()->name ?? 'Administrator' }}</span>
          </div>
        </div>
      </header>

      <!-- Main Body Container -->
      <main class="flex-1 p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">

        <!-- Flash Messages -->
        @if(session('success'))
          <div class="p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/30 text-emerald-200 text-sm flex items-center justify-between shadow-lg shadow-emerald-950/20">
            <div class="flex items-center gap-3">
              <i class="fas fa-circle-check text-emerald-400 text-base"></i>
              <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200"><i class="fas fa-times"></i></button>
          </div>
        @endif

        @if(isset($errors) && $errors->any())
          <div class="p-4 rounded-xl bg-red-950/60 border border-red-500/30 text-red-200 text-sm space-y-1 shadow-lg shadow-red-950/20">
            <div class="flex items-center gap-2 font-bold text-red-400">
              <i class="fas fa-triangle-exclamation"></i>
              <span>Please review the errors below:</span>
            </div>
            <ul class="list-disc list-inside text-xs pl-5 space-y-0.5 text-red-300">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if(View::hasSection('admin_content'))
          @yield('admin_content')
        @else
          @yield('content')
        @endif
      </main>

      <!-- Admin Footer -->
      <footer class="py-4 px-6 border-t border-slate-800/80 text-xs text-slate-500 text-center">
        WebRanker Schema &amp; SEO Management Console &middot; Laravel 13 Core
      </footer>
    </div>
  </div>

  <!-- Theme Switcher Interactive Handler -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var toggleBtn = document.getElementById('adminThemeToggle');
      var icon = document.getElementById('themeToggleIcon');

      function syncThemeUI(isLight) {
        if (!icon || !toggleBtn) return;
        if (isLight) {
          icon.className = 'fas fa-moon text-sm text-indigo-600';
          toggleBtn.className = 'w-9 h-9 rounded-xl flex items-center justify-center transition-all border border-slate-300 bg-white text-indigo-600 hover:bg-slate-50 hover:scale-105 active:scale-95 shadow-sm cursor-pointer';
          toggleBtn.setAttribute('title', 'Switch to Dark Mode');
        } else {
          icon.className = 'fas fa-sun text-sm text-amber-400';
          toggleBtn.className = 'w-9 h-9 rounded-xl flex items-center justify-center transition-all border border-slate-700 bg-slate-800 text-amber-400 hover:text-amber-300 hover:scale-105 active:scale-95 shadow-sm cursor-pointer';
          toggleBtn.setAttribute('title', 'Switch to Light Mode');
        }
      }

      var currentIsLight = document.documentElement.classList.contains('theme-light');
      syncThemeUI(currentIsLight);

      if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
          var isLight = document.documentElement.classList.toggle('theme-light');
          localStorage.setItem('admin_theme', isLight ? 'light' : 'dark');
          syncThemeUI(isLight);
        });
      }
    });
  </script>

  @stack('admin_scripts')
</body>
</html>
