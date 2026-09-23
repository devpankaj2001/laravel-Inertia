@extends('admin.layouts.admin')

@section('title', 'Home Page & Schema JSON-LD Manager')
@section('page_title', 'Home Page Management')

@section('admin_content')
<div class="space-y-6">

  <!-- Header Banner -->
  <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-6 rounded-2xl border border-slate-700/60 shadow-xl flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="space-y-1">
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold uppercase tracking-wider">
        <i class="fas fa-house-laptop"></i> Dynamic Home &amp; SEO Engine
      </div>
      <h2 class="text-2xl font-extrabold text-white tracking-tight">Home Page &amp; Schema JSON-LD Center</h2>
      <p class="text-slate-400 text-sm max-w-2xl">
        Manage dynamic home page hero copy, proofs, and high-impact Schema.org structured data (Local Business, Organization, and Custom JSON-LD) to dominate Google search results.
      </p>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs border border-slate-600/60 transition-all flex items-center gap-2 shadow-sm">
        <i class="fas fa-arrow-up-right-from-square"></i>
        <span>View Live Home</span>
      </a>
      <a href="https://validator.schema.org/" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 font-semibold text-xs border border-emerald-500/30 transition-all flex items-center gap-2">
        <i class="fas fa-check-double"></i>
        <span>Google Schema Test</span>
      </a>
    </div>
  </div>

  <!-- Tabs Navigation -->
  @php $activeTab = request('tab', 'content'); @endphp
  <div class="border-b border-slate-800 flex overflow-x-auto gap-2 text-sm font-semibold">
    <a href="{{ route('admin.homepage.index', ['tab' => 'content']) }}"
       class="pb-3 px-4 flex items-center gap-2 border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'content' ? 'border-[#ff3b30] text-[#ff3b30]' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
      <i class="fas fa-pen-nib"></i>
      <span>Dynamic Content &amp; Hero</span>
    </a>

    <a href="{{ route('admin.homepage.index', ['tab' => 'local']) }}"
       class="pb-3 px-4 flex items-center gap-2 border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'local' ? 'border-[#ff3b30] text-[#ff3b30]' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
      <i class="fas fa-location-dot"></i>
      <span>Local Schema (JSON-LD)</span>
    </a>

    <a href="{{ route('admin.homepage.index', ['tab' => 'business']) }}"
       class="pb-3 px-4 flex items-center gap-2 border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'business' ? 'border-[#ff3b30] text-[#ff3b30]' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
      <i class="fas fa-building"></i>
      <span>Business Schema (JSON-LD)</span>
    </a>

    <a href="{{ route('admin.homepage.index', ['tab' => 'custom']) }}"
       class="pb-3 px-4 flex items-center gap-2 border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'custom' ? 'border-[#ff3b30] text-[#ff3b30]' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
      <i class="fas fa-code"></i>
      <span>Custom Schema (JSON-LD)</span>
    </a>

    <a href="{{ route('admin.homepage.index', ['tab' => 'seo']) }}"
       class="pb-3 px-4 flex items-center gap-2 border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'seo' ? 'border-[#ff3b30] text-[#ff3b30]' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
      <i class="fas fa-magnifying-glass"></i>
      <span>Home SEO &amp; Meta</span>
    </a>

    <a href="{{ route('admin.homepage.index', ['tab' => 'toggles']) }}"
       class="pb-3 px-4 flex items-center gap-2 border-b-2 transition-colors whitespace-nowrap {{ $activeTab === 'toggles' ? 'border-[#ff3b30] text-[#ff3b30]' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
      <i class="fas fa-toggle-on"></i>
      <span>Module Toggles</span>
    </a>
  </div>

  <!-- TAB 1: DYNAMIC HERO & HOME CONTENT -->
  @if($activeTab === 'content')
  <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
    @csrf
    <input type="hidden" name="section" value="content">

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-6">
      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-base font-bold text-white flex items-center gap-2">
          <i class="fas fa-bullhorn text-[#ff3b30]"></i>
          <span>Hero Section — Headline &amp; Lead Copy</span>
        </h3>
        <p class="text-xs text-slate-400 mt-1">Changes made here reflect immediately on the frontend homepage banner.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Eyebrow / Kicker Pill</label>
          <input type="text" name="kicker" value="{{ old('kicker', $heroContent['kicker']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
          <p class="text-[11px] text-slate-500 mt-1">Displayed above the main headline.</p>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Headline Accent Highlight</label>
          <input type="text" name="title_accent" value="{{ old('title_accent', $heroContent['title_accent']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
          <p class="text-[11px] text-slate-500 mt-1">Rendered in the gradient highlight font.</p>
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Main Hero Title</label>
          <input type="text" name="title" value="{{ old('title', $heroContent['title']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Lead Paragraph Description</label>
          <textarea name="lead" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500 leading-relaxed">{{ old('lead', $heroContent['lead']) }}</textarea>
          <p class="text-[11px] text-slate-500 mt-1">Primary conversion copy explaining your agency's value proposition.</p>
        </div>
      </div>

      <div class="border-t border-slate-800 pt-6">
        <h3 class="text-base font-bold text-white flex items-center gap-2 mb-4">
          <i class="fas fa-hand-pointer text-[#ff3b30]"></i>
          <span>Calls-to-Action (Buttons)</span>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Primary CTA Text</label>
            <input type="text" name="cta_text" value="{{ old('cta_text', $heroContent['cta_text']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Primary CTA Link</label>
            <input type="text" name="cta_link" value="{{ old('cta_link', $heroContent['cta_link']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Secondary CTA Text</label>
            <input type="text" name="secondary_text" value="{{ old('secondary_text', $heroContent['secondary_text']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Secondary CTA Link</label>
            <input type="text" name="secondary_link" value="{{ old('secondary_link', $heroContent['secondary_link']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
          </div>
        </div>
      </div>

      <div class="border-t border-slate-800 pt-6">
        <h3 class="text-base font-bold text-white flex items-center gap-2 mb-4">
          <i class="fas fa-chart-simple text-[#ff3b30]"></i>
          <span>Live SERP Badge &amp; Proof Tags</span>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">SERP Badge Title</label>
            <input type="text" name="serp_badge" value="{{ old('serp_badge', $heroContent['serp_badge']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">SERP Traffic Subtitle</label>
            <input type="text" name="serp_sub" value="{{ old('serp_sub', $heroContent['serp_sub']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
          </div>
        </div>

        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Hero Proof Bullets</label>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          @foreach($heroContent['proof_tags'] as $idx => $tag)
            <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700 space-y-2">
              <span class="text-[10px] font-mono text-slate-400">Proof #{{ $idx + 1 }}</span>
              <input type="text" name="proof_labels[]" value="{{ $tag['label'] ?? '' }}" placeholder="Label (e.g. SEO)" class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-red-500">
              <input type="text" name="proof_descs[]" value="{{ $tag['desc'] ?? '' }}" placeholder="Subtext (e.g. Organic rankings)" class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-slate-300 text-xs focus:outline-none focus:border-red-500">
            </div>
          @endforeach
        </div>
      </div>

      <div class="pt-4 flex justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save Home Page Content</span>
        </button>
      </div>
    </div>
  </form>
  @endif

  <!-- TAB 2: LOCAL SCHEMA (JSON-LD) -->
  @if($activeTab === 'local')
  <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
    @csrf
    <input type="hidden" name="section" value="local">

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-6">
      <div class="border-b border-slate-800 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
          <h3 class="text-base font-bold text-white flex items-center gap-2">
            <i class="fas fa-location-dot text-[#ff3b30]"></i>
            <span>LocalBusiness Schema (JSON-LD)</span>
          </h3>
          <p class="text-xs text-slate-400 mt-1">Target Google Maps 3-Pack, local Knowledge Graph, and voice search for your Jaipur HQ.</p>
        </div>
        <span class="px-2.5 py-1 rounded-full text-xs font-mono bg-blue-500/10 text-blue-400 border border-blue-500/20 self-start">
          &#64;type: ProfessionalService / LocalBusiness
        </span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Display Business Name</label>
          <input type="text" name="local_name" value="{{ old('local_name', $localBusiness['name']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Legal Registered Name</label>
          <input type="text" name="local_legal_name" value="{{ old('local_legal_name', $localBusiness['legal_name']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Street Address (Jaipur HQ)</label>
          <input type="text" name="local_street_address" value="{{ old('local_street_address', $localBusiness['street_address']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">City / Locality</label>
          <input type="text" name="local_address_locality" value="{{ old('local_address_locality', $localBusiness['address_locality']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">State / Region</label>
          <input type="text" name="local_address_region" value="{{ old('local_address_region', $localBusiness['address_region']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Postal Code (PIN)</label>
          <input type="text" name="local_postal_code" value="{{ old('local_postal_code', $localBusiness['postal_code']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Country Code (ISO 3166)</label>
          <input type="text" name="local_address_country" value="{{ old('local_address_country', $localBusiness['address_country']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Telephone</label>
          <input type="text" name="local_telephone" value="{{ old('local_telephone', $localBusiness['telephone']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Public Contact Email</label>
          <input type="email" name="local_email" value="{{ old('local_email', $localBusiness['email']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Geo Latitude</label>
          <input type="text" name="local_latitude" value="{{ old('local_latitude', $localBusiness['latitude']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm font-mono focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Geo Longitude</label>
          <input type="text" name="local_longitude" value="{{ old('local_longitude', $localBusiness['longitude']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm font-mono focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Opening Hours (Schema format)</label>
          <input type="text" name="local_opening_hours" value="{{ old('local_opening_hours', $localBusiness['opening_hours']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm font-mono focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Area Served (Locations / Reach)</label>
          <input type="text" name="local_area_served" value="{{ old('local_area_served', $localBusiness['area_served']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>
      </div>

      <!-- Live JSON-LD Code Preview -->
      <div class="border-t border-slate-800 pt-6">
        <div class="flex items-center justify-between mb-3">
          <label class="text-xs font-bold text-slate-300 uppercase tracking-wider flex items-center gap-2">
            <i class="fas fa-eye text-emerald-400"></i>
            <span>Live Generated Schema Preview</span>
          </label>
          <span class="text-[11px] text-slate-500 font-mono">Rendered automatically in &lt;head&gt;</span>
        </div>
        <pre class="p-4 rounded-xl bg-slate-950 border border-slate-800 text-emerald-400 font-mono text-xs overflow-x-auto"><code>{
  "&#64;context": "https://schema.org",
  "&#64;type": "ProfessionalService",
  "&#64;id": "{{ url('/') }}/#localbusiness",
  "name": "{{ $localBusiness['name'] }}",
  "legalName": "{{ $localBusiness['legal_name'] }}",
  "telephone": "{{ $localBusiness['telephone'] }}",
  "email": "{{ $localBusiness['email'] }}",
  "address": {
    "&#64;type": "PostalAddress",
    "streetAddress": "{{ $localBusiness['street_address'] }}",
    "addressLocality": "{{ $localBusiness['address_locality'] }}",
    "addressRegion": "{{ $localBusiness['address_region'] }}",
    "postalCode": "{{ $localBusiness['postal_code'] }}",
    "addressCountry": "{{ $localBusiness['address_country'] }}"
  },
  "geo": {
    "&#64;type": "GeoCoordinates",
    "latitude": {{ $localBusiness['latitude'] }},
    "longitude": {{ $localBusiness['longitude'] }}
  },
  "areaServed": "{{ $localBusiness['area_served'] }}"
}</code></pre>
      </div>

      <div class="pt-4 flex justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save Local Business Schema</span>
        </button>
      </div>
    </div>
  </form>
  @endif

  <!-- TAB 3: BUSINESS / ORGANIZATION SCHEMA (JSON-LD) -->
  @if($activeTab === 'business')
  <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
    @csrf
    <input type="hidden" name="section" value="business">

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-6">
      <div class="border-b border-slate-800 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
          <h3 class="text-base font-bold text-white flex items-center gap-2">
            <i class="fas fa-building text-[#ff3b30]"></i>
            <span>Business / Organization Schema (JSON-LD)</span>
          </h3>
          <p class="text-xs text-slate-400 mt-1">Powers brand authority in the Google Knowledge Graph and brand entity recognition.</p>
        </div>
        <span class="px-2.5 py-1 rounded-full text-xs font-mono bg-purple-500/10 text-purple-400 border border-purple-500/20 self-start">
          &#64;type: Organization
        </span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Brand Entity Name</label>
          <input type="text" name="org_name" value="{{ old('org_name', $organization['name']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Legal Registered Name</label>
          <input type="text" name="org_legal_name" value="{{ old('org_legal_name', $organization['legal_name']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Alternate Brand Names</label>
          <input type="text" name="org_alternate_name" value="{{ old('org_alternate_name', $organization['alternate_name']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Founding Date (YYYY-MM-DD)</label>
          <input type="date" name="org_founding_date" value="{{ old('org_founding_date', $organization['founding_date']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Founder Name</label>
          <input type="text" name="org_founder_name" value="{{ old('org_founder_name', $organization['founder_name']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Logo Asset Path / URL</label>
          <input type="text" name="org_logo_url" value="{{ old('org_logo_url', $organization['logo_url']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Customer Service Phone</label>
          <input type="text" name="org_phone" value="{{ old('org_phone', $organization['customer_service_phone']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Customer Service Email</label>
          <input type="email" name="org_email" value="{{ old('org_email', $organization['customer_service_email']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
            Social Profile Links (<code class="text-red-400">sameAs</code>) — 1 URL per line
          </label>
          <textarea name="org_social_links" rows="4" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm font-mono focus:outline-none focus:border-red-500 leading-relaxed">{{ old('org_social_links', implode("\n", $organization['social_links'] ?? [])) }}</textarea>
          <p class="text-[11px] text-slate-500 mt-1">Used by Google to connect your brand entity to official LinkedIn, Twitter/X, GitHub, and Facebook profiles.</p>
        </div>
      </div>

      <div class="pt-4 flex justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save Business Schema</span>
        </button>
      </div>
    </div>
  </form>
  @endif

  <!-- TAB 4: CUSTOM SCHEMA JSON-LD -->
  @if($activeTab === 'custom')
  <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
    @csrf
    <input type="hidden" name="section" value="custom">

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-6">
      <div class="border-b border-slate-800 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
          <h3 class="text-base font-bold text-white flex items-center gap-2">
            <i class="fas fa-code text-[#ff3b30]"></i>
            <span>Custom JSON-LD Microdata Editor</span>
          </h3>
          <p class="text-xs text-slate-400 mt-1">Inject custom Schema.org microdata directly into the &lt;head&gt; of your home page.</p>
        </div>

        <div class="flex items-center gap-2">
          <button type="button" id="btnBeautifyJson" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-semibold border border-slate-700 flex items-center gap-1.5 transition-colors">
            <i class="fas fa-wand-magic-sparkles text-amber-400"></i>
            <span>Beautify JSON</span>
          </button>
        </div>
      </div>

      <!-- Quick Template Injection Chips -->
      <div>
        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Click to Append Schema Template:</span>
        <div class="flex flex-wrap gap-2">
          <button type="button" class="btn-insert-template px-3 py-1 rounded-lg text-xs font-mono bg-slate-800 hover:bg-slate-700 text-blue-400 border border-slate-700 transition-colors" data-template="aggregate_rating">
            + AggregateRating (4.9/5)
          </button>
          <button type="button" class="btn-insert-template px-3 py-1 rounded-lg text-xs font-mono bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-slate-700 transition-colors" data-template="software_app">
            + SoftwareApplication
          </button>
          <button type="button" class="btn-insert-template px-3 py-1 rounded-lg text-xs font-mono bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 transition-colors" data-template="service">
            + Service (SEO &amp; Engineering)
          </button>
          <button type="button" class="btn-insert-template px-3 py-1 rounded-lg text-xs font-mono bg-slate-800 hover:bg-slate-700 text-purple-400 border border-slate-700 transition-colors" data-template="faq_custom">
            + Custom FAQ Item
          </button>
        </div>
      </div>

      <!-- JSON Code Editor -->
      <div class="space-y-2">
        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">JSON-LD Code (<code class="text-red-400">&lt;script type="application/ld+json"&gt;</code>)</label>
        <textarea id="customJsonEditor" name="custom_jsonld" rows="14" class="w-full p-4 rounded-xl bg-slate-950 border border-slate-800 text-emerald-400 font-mono text-xs leading-relaxed focus:outline-none focus:border-red-500" placeholder="Paste or type your JSON-LD array or object here...">{{ old('custom_jsonld', $customJsonLdRaw) }}</textarea>
        <div class="flex items-center justify-between text-xs">
          <span id="jsonStatus" class="font-mono text-emerald-400 flex items-center gap-1.5">
            <i class="fas fa-circle-check"></i> JSON Syntax Valid
          </span>
          <span class="text-slate-500">Supports single Schema objects or arrays of Schemas.</span>
        </div>
      </div>

      <div class="pt-4 flex justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save &amp; Validate Custom Schema</span>
        </button>
      </div>
    </div>
  </form>
  @endif

  <!-- TAB 5: HOME SEO & META -->
  @if($activeTab === 'seo')
  <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
    @csrf
    <input type="hidden" name="section" value="seo">

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-6">
      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-base font-bold text-white flex items-center gap-2">
          <i class="fas fa-magnifying-glass text-[#ff3b30]"></i>
          <span>Home Page SEO &amp; Social Meta Tags</span>
        </h3>
        <p class="text-xs text-slate-400 mt-1">Configure SERP titles, snippets, keywords, and OpenGraph share cards.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Meta Title (SERP Headline)</label>
          <input type="text" name="meta_title" value="{{ old('meta_title', $seo['meta_title']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Meta Description (SERP Snippet)</label>
          <textarea name="meta_description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500 leading-relaxed">{{ old('meta_description', $seo['meta_description']) }}</textarea>
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Target SEO Keywords (Comma-separated)</label>
          <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $seo['meta_keywords']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">OpenGraph Title</label>
          <input type="text" name="og_title" value="{{ old('og_title', $seo['og_title']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">OpenGraph Share Image</label>
          <input type="text" name="og_image" value="{{ old('og_image', $seo['og_image']) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Google Site Verification Token</label>
          <input type="text" name="google_site_verification" value="{{ old('google_site_verification', $seo['google_site_verification']) }}" placeholder="e.g. dZ1a8-..." class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm font-mono focus:outline-none focus:border-red-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Bing Webmaster Token</label>
          <input type="text" name="bing_site_verification" value="{{ old('bing_site_verification', $seo['bing_site_verification']) }}" placeholder="e.g. 4C189..." class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm font-mono focus:outline-none focus:border-red-500">
        </div>
      </div>

      <div class="pt-4 flex justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save Home SEO &amp; Meta</span>
        </button>
      </div>
    </div>
  </form>
  @endif

  <!-- TAB 6: MODULE TOGGLES -->
  @if($activeTab === 'toggles')
  <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
    @csrf
    <input type="hidden" name="section" value="toggles">

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-6">
      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-base font-bold text-white flex items-center gap-2">
          <i class="fas fa-toggle-on text-[#ff3b30]"></i>
          <span>Schema Module Switches</span>
        </h3>
        <p class="text-xs text-slate-400 mt-1">Selectively enable or disable individual structured data blocks for Google search engine crawlers.</p>
      </div>

      <div class="space-y-4">
        <label class="flex items-center justify-between p-4 rounded-xl bg-slate-800/60 border border-slate-700 cursor-pointer hover:bg-slate-800 transition-colors">
          <div>
            <span class="block text-sm font-bold text-white">LocalBusiness Schema</span>
            <span class="text-xs text-slate-400">Jaipur HQ address, coordinates, opening hours, local radius</span>
          </div>
          <input type="checkbox" name="enable_local_business" value="1" {{ ($toggles['enable_local_business'] ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded text-red-600 focus:ring-red-500 bg-slate-900 border-slate-700">
        </label>

        <label class="flex items-center justify-between p-4 rounded-xl bg-slate-800/60 border border-slate-700 cursor-pointer hover:bg-slate-800 transition-colors">
          <div>
            <span class="block text-sm font-bold text-white">Organization Schema</span>
            <span class="text-xs text-slate-400">Global enterprise brand entity, logo, social links, customer service</span>
          </div>
          <input type="checkbox" name="enable_organization" value="1" {{ ($toggles['enable_organization'] ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded text-red-600 focus:ring-red-500 bg-slate-900 border-slate-700">
        </label>

        <label class="flex items-center justify-between p-4 rounded-xl bg-slate-800/60 border border-slate-700 cursor-pointer hover:bg-slate-800 transition-colors">
          <div>
            <span class="block text-sm font-bold text-white">Custom JSON-LD Schema</span>
            <span class="text-xs text-slate-400">Arbitrary microdata injected from the Custom Schema tab</span>
          </div>
          <input type="checkbox" name="enable_custom_jsonld" value="1" {{ ($toggles['enable_custom_jsonld'] ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded text-red-600 focus:ring-red-500 bg-slate-900 border-slate-700">
        </label>

        <label class="flex items-center justify-between p-4 rounded-xl bg-slate-800/60 border border-slate-700 cursor-pointer hover:bg-slate-800 transition-colors">
          <div>
            <span class="block text-sm font-bold text-white">WebSite &amp; Searchbox Schema</span>
            <span class="text-xs text-slate-400">Sitelinks search box rich snippet</span>
          </div>
          <input type="checkbox" name="enable_website" value="1" {{ ($toggles['enable_website'] ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded text-red-600 focus:ring-red-500 bg-slate-900 border-slate-700">
        </label>

        <label class="flex items-center justify-between p-4 rounded-xl bg-slate-800/60 border border-slate-700 cursor-pointer hover:bg-slate-800 transition-colors">
          <div>
            <span class="block text-sm font-bold text-white">FAQPage Schema</span>
            <span class="text-xs text-slate-400">Automated Q&amp;A rich accordion snippet on Google SERPs</span>
          </div>
          <input type="checkbox" name="enable_faq" value="1" {{ ($toggles['enable_faq'] ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded text-red-600 focus:ring-red-500 bg-slate-900 border-slate-700">
        </label>

        <label class="flex items-center justify-between p-4 rounded-xl bg-slate-800/60 border border-slate-700 cursor-pointer hover:bg-slate-800 transition-colors">
          <div>
            <span class="block text-sm font-bold text-white">ItemList Services Schema</span>
            <span class="text-xs text-slate-400">Full catalog of active services and architecture offerings</span>
          </div>
          <input type="checkbox" name="enable_services" value="1" {{ ($toggles['enable_services'] ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded text-red-600 focus:ring-red-500 bg-slate-900 border-slate-700">
        </label>
      </div>

      <div class="pt-4 flex justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save Module Toggles</span>
        </button>
      </div>
    </div>
  </form>
  @endif

</div>

<!-- Client-side Schema Editor Helpers -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const editor = document.getElementById('customJsonEditor');
  const status = document.getElementById('jsonStatus');
  const btnBeautify = document.getElementById('btnBeautifyJson');

  function validateJson() {
    if (!editor || !status) return;
    const val = editor.value.trim();
    if (!val) {
      status.innerHTML = '<span class="text-slate-500"><i class="fas fa-minus"></i> Empty (Optional)</span>';
      return;
    }
    try {
      JSON.parse(val);
      status.innerHTML = '<span class="text-emerald-400"><i class="fas fa-circle-check"></i> JSON Syntax Valid</span>';
    } catch (e) {
      status.innerHTML = '<span class="text-red-400"><i class="fas fa-circle-xmark"></i> Syntax Error: ' + e.message + '</span>';
    }
  }

  if (editor) {
    editor.addEventListener('input', validateJson);
    validateJson();
  }

  if (btnBeautify && editor) {
    btnBeautify.addEventListener('click', function() {
      try {
        const parsed = JSON.parse(editor.value);
        editor.value = JSON.stringify(parsed, null, 2);
        validateJson();
      } catch (e) {
        alert('Cannot beautify: Invalid JSON syntax! ' + e.message);
      }
    });
  }

  const templates = {
    aggregate_rating: {
      "@@context": "https://schema.org",
      "@@type": "AggregateRating",
      "ratingValue": "4.9",
      "bestRating": "5",
      "worstRating": "1",
      "ratingCount": "142",
      "reviewCount": "142"
    },
    software_app: {
      "@@context": "https://schema.org",
      "@@type": "SoftwareApplication",
      "name": "WebRanker Audit Engine",
      "operatingSystem": "All Web Browsers",
      "applicationCategory": "BusinessApplication",
      "offers": {
        "@@type": "Offer",
        "price": "0.00",
        "priceCurrency": "USD"
      }
    },
    service: {
      "@@context": "https://schema.org",
      "@@type": "Service",
      "serviceType": "Search Engine Optimization & Next.js Web Engineering",
      "provider": {
        "@@type": "LocalBusiness",
        "name": "WebRanker Technologies HQ"
      },
      "areaServed": "Global"
    },
    faq_custom: {
      "@@context": "https://schema.org",
      "@@type": "Question",
      "name": "How quickly can WebRanker audit my site?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "Our technical SEO audit engine scans your full site architecture and delivers an actionable roadmap within 48 hours."
      }
    }
  };

  document.querySelectorAll('.btn-insert-template').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const type = btn.getAttribute('data-template');
      const tmpl = templates[type];
      if (!tmpl || !editor) return;

      let current = editor.value.trim();
      if (!current) {
        editor.value = JSON.stringify([tmpl], null, 2);
      } else {
        try {
          let parsed = JSON.parse(current);
          if (Array.isArray(parsed)) {
            parsed.push(tmpl);
          } else {
            parsed = [parsed, tmpl];
          }
          editor.value = JSON.stringify(parsed, null, 2);
        } catch (e) {
          editor.value = current + '\n\n' + JSON.stringify(tmpl, null, 2);
        }
      }
      validateJson();
    });
  });
});
</script>
@endsection
