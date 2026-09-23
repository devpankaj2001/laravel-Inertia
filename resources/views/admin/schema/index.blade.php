@extends('admin.layouts.admin')

@section('title', 'Schema & SEO Management Center')
@section('page_title', 'Advanced Schema.org & SEO Ranking Center')

@section('admin_content')

<div class="space-y-6">

  <!-- Header Banner -->
  <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 lg:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div class="space-y-1">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/20 text-xs font-bold">
        <i class="fas fa-code"></i>
        <span>GOOGLE RICH SNIPPETS &amp; KNOWLEDGE GRAPH CONTROLS</span>
      </div>
      <h2 class="text-2xl font-extrabold text-white">Schema.org Microdata &amp; SEO Architecture</h2>
      <p class="text-slate-400 text-sm max-w-3xl">
        Manage how search engines perceive your entity graph. Configure LocalBusiness maps, corporate organization data, meta tags, and inject bespoke custom JSON-LD schemas.
      </p>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('home') }}" target="_blank"
         class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold transition-colors inline-flex items-center gap-2">
        <i class="fas fa-eye"></i>
        <span>Inspect Live Schemas</span>
      </a>
    </div>
  </div>

  <!-- Tab Navigation -->
  <div class="flex items-center gap-2 border-b border-slate-800 pb-2 overflow-x-auto" id="schemaTabsNav">
    <button type="button" onclick="switchSchemaTab('local')" id="tabBtn-local"
            class="schema-tab-btn active px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 bg-[#ff3b30] text-white">
      <i class="fas fa-location-dot"></i>
      <span>LocalBusiness Schema</span>
    </button>
    <button type="button" onclick="switchSchemaTab('organization')" id="tabBtn-organization"
            class="schema-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 text-slate-400 hover:text-white hover:bg-slate-800">
      <i class="fas fa-building"></i>
      <span>Organization Schema</span>
    </button>
    <button type="button" onclick="switchSchemaTab('seo')" id="tabBtn-seo"
            class="schema-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 text-slate-400 hover:text-white hover:bg-slate-800">
      <i class="fas fa-magnifying-glass-chart"></i>
      <span>Global SEO &amp; Meta</span>
    </button>
    <button type="button" onclick="switchSchemaTab('custom')" id="tabBtn-custom"
            class="schema-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 text-slate-400 hover:text-white hover:bg-slate-800">
      <i class="fas fa-file-code"></i>
      <span>Custom JSON-LD Schema</span>
    </button>
    <button type="button" onclick="switchSchemaTab('toggles')" id="tabBtn-toggles"
            class="schema-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 text-slate-400 hover:text-white hover:bg-slate-800">
      <i class="fas fa-toggle-on"></i>
      <span>Module Toggles</span>
    </button>
  </div>

  <!-- Forms Container -->

  <!-- TAB 1: LOCAL BUSINESS SCHEMA -->
  <div id="tabContent-local" class="schema-tab-content space-y-6">
    <form method="POST" action="{{ route('admin.schema.update') }}" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 lg:p-8 space-y-6">
      @csrf
      <input type="hidden" name="section" value="local">

      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
          <i class="fas fa-location-dot text-[#ff3b30]"></i>
          <span>LocalBusiness Schema.org Configuration</span>
        </h3>
        <p class="text-xs text-slate-400 mt-1">
          Feeds Google Maps, Local 3-Pack, and Voice Assistant search queries with verified location &amp; contact metadata.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Display Business Name *</label>
          <input type="text" name="local_name" value="{{ old('local_name', $localBusiness['name'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Legal Business Name</label>
          <input type="text" name="local_legal_name" value="{{ old('local_legal_name', $localBusiness['legal_name'] ?? '') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5 md:col-span-2">
          <label class="block text-xs font-bold uppercase text-slate-300">Street Address *</label>
          <input type="text" name="local_street_address" value="{{ old('local_street_address', $localBusiness['street_address'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">City / Locality *</label>
          <input type="text" name="local_address_locality" value="{{ old('local_address_locality', $localBusiness['address_locality'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">State / Region *</label>
          <input type="text" name="local_address_region" value="{{ old('local_address_region', $localBusiness['address_region'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Postal / ZIP Code *</label>
          <input type="text" name="local_postal_code" value="{{ old('local_postal_code', $localBusiness['postal_code'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Country Code (ISO 2-letter) *</label>
          <input type="text" name="local_address_country" value="{{ old('local_address_country', $localBusiness['address_country'] ?? 'IN') }}" required maxlength="2"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none uppercase">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Primary Telephone *</label>
          <input type="text" name="local_telephone" value="{{ old('local_telephone', $localBusiness['telephone'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Contact Email *</label>
          <input type="email" name="local_email" value="{{ old('local_email', $localBusiness['email'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Geo Latitude *</label>
          <input type="text" name="local_latitude" value="{{ old('local_latitude', $localBusiness['latitude'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm font-mono focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Geo Longitude *</label>
          <input type="text" name="local_longitude" value="{{ old('local_longitude', $localBusiness['longitude'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm font-mono focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Opening Hours (Schema format)</label>
          <input type="text" name="local_opening_hours" value="{{ old('local_opening_hours', $localBusiness['opening_hours'] ?? 'Mo-Fr 09:00-19:00') }}"
                 placeholder="Mo-Fr 09:00-19:00"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Price Range</label>
          <input type="text" name="local_price_range" value="{{ old('local_price_range', $localBusiness['price_range'] ?? '$$$') }}"
                 placeholder="$$$"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Currencies Accepted</label>
          <input type="text" name="local_currencies_accepted" value="{{ old('local_currencies_accepted', $localBusiness['currencies_accepted'] ?? 'USD, EUR, GBP, INR') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Area Served</label>
          <input type="text" name="local_area_served" value="{{ old('local_area_served', $localBusiness['area_served'] ?? 'Worldwide') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>
      </div>

      <div class="pt-4 border-t border-slate-800 flex items-center justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save LocalBusiness Schema</span>
        </button>
      </div>
    </form>
  </div>

  <!-- TAB 2: ORGANIZATION SCHEMA -->
  <div id="tabContent-organization" class="schema-tab-content space-y-6 hidden">
    <form method="POST" action="{{ route('admin.schema.update') }}" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 lg:p-8 space-y-6">
      @csrf
      <input type="hidden" name="section" value="organization">

      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
          <i class="fas fa-building text-[#ff3b30]"></i>
          <span>Organization &amp; Corporate Entity Schema</span>
        </h3>
        <p class="text-xs text-slate-400 mt-1">
          Powers Google Knowledge Panel, authoritative entity recognition, brand social profiles, and corporate trust signals.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Brand / Organization Name *</label>
          <input type="text" name="org_name" value="{{ old('org_name', $organization['name'] ?? 'WebRanker') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Legal Corporate Name</label>
          <input type="text" name="org_legal_name" value="{{ old('org_legal_name', $organization['legal_name'] ?? '') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Alternate / Trading Name</label>
          <input type="text" name="org_alternate_name" value="{{ old('org_alternate_name', $organization['alternate_name'] ?? '') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Founding Date (YYYY-MM-DD)</label>
          <input type="date" name="org_founding_date" value="{{ old('org_founding_date', $organization['founding_date'] ?? '2020-01-15') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Founder Name</label>
          <input type="text" name="org_founder_name" value="{{ old('org_founder_name', $organization['founder_name'] ?? '') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Logo Asset URL</label>
          <input type="text" name="org_logo_url" value="{{ old('org_logo_url', $organization['logo_url'] ?? 'asset/logo.svg') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Customer Support Phone</label>
          <input type="text" name="org_customer_service_phone" value="{{ old('org_customer_service_phone', $organization['customer_service_phone'] ?? '') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Customer Support Email</label>
          <input type="email" name="org_customer_service_email" value="{{ old('org_customer_service_email', $organization['customer_service_email'] ?? '') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="space-y-1.5 md:col-span-2">
          <label class="block text-xs font-bold uppercase text-slate-300">Verified Social Profiles (`sameAs` URLs, one per line)</label>
          @php
            $socialLines = is_array($organization['social_links'] ?? null) ? implode("\n", $organization['social_links']) : '';
          @endphp
          <textarea name="org_social_links" rows="5"
                    class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono focus:border-[#ff3b30] focus:outline-none"
                    placeholder="https://twitter.com/webranker&#10;https://linkedin.com/company/webranker&#10;https://facebook.com/webranker">{{ old('org_social_links', $socialLines) }}</textarea>
          <p class="text-[11px] text-slate-500">Google uses these URLs to link social accounts to your official Knowledge Graph panel.</p>
        </div>
      </div>

      <div class="pt-4 border-t border-slate-800 flex items-center justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save Organization Schema</span>
        </button>
      </div>
    </form>
  </div>

  <!-- TAB 3: GLOBAL SEO & META -->
  <div id="tabContent-seo" class="schema-tab-content space-y-6 hidden">
    <form method="POST" action="{{ route('admin.schema.update') }}" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 lg:p-8 space-y-6">
      @csrf
      <input type="hidden" name="section" value="seo">

      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
          <i class="fas fa-magnifying-glass-chart text-[#ff3b30]"></i>
          <span>Global SEO, Open Graph &amp; Verification Directives</span>
        </h3>
        <p class="text-xs text-slate-400 mt-1">
          Controls organic search snippet titles, descriptions, social card previews, and webmaster verification tokens.
        </p>
      </div>

      <div class="space-y-5">
        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Default Meta Title *</label>
          <input type="text" name="seo_meta_title" value="{{ old('seo_meta_title', $seo['meta_title'] ?? '') }}" required
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
          <p class="text-[11px] text-slate-500">Recommended length: 50–60 characters for optimal Google SERP display.</p>
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Default Meta Description *</label>
          <textarea name="seo_meta_description" rows="3" required
                    class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">{{ old('seo_meta_description', $seo['meta_description'] ?? '') }}</textarea>
          <p class="text-[11px] text-slate-500">Recommended length: 140–160 characters with high-intent keywords.</p>
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold uppercase text-slate-300">Target Keywords (Comma Separated)</label>
          <input type="text" name="seo_meta_keywords" value="{{ old('seo_meta_keywords', $seo['meta_keywords'] ?? '') }}"
                 class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase text-slate-300">OpenGraph Title</label>
            <input type="text" name="seo_og_title" value="{{ old('seo_og_title', $seo['og_title'] ?? '') }}"
                   class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase text-slate-300">OpenGraph Image Path</label>
            <input type="text" name="seo_og_image" value="{{ old('seo_og_image', $seo['og_image'] ?? 'asset/logo.svg') }}"
                   class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase text-slate-300">Twitter Handle</label>
            <input type="text" name="seo_twitter_handle" value="{{ old('seo_twitter_handle', $seo['twitter_handle'] ?? '@webranker') }}"
                   class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase text-slate-300">Robots Directive</label>
            <input type="text" name="seo_robots_directive" value="{{ old('seo_robots_directive', $seo['robots_directive'] ?? 'index, follow, max-image-preview:large') }}"
                   class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm focus:border-[#ff3b30] focus:outline-none">
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase text-slate-300">Google Search Console Verification Token</label>
            <input type="text" name="seo_google_site_verification" value="{{ old('seo_google_site_verification', $seo['google_site_verification'] ?? '') }}"
                   placeholder="google-site-verification token"
                   class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm font-mono focus:border-[#ff3b30] focus:outline-none">
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase text-slate-300">Bing Webmaster Verification Token</label>
            <input type="text" name="seo_bing_site_verification" value="{{ old('seo_bing_site_verification', $seo['bing_site_verification'] ?? '') }}"
                   placeholder="msvalidate.01 token"
                   class="w-full px-4 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-sm font-mono focus:border-[#ff3b30] focus:outline-none">
          </div>
        </div>
      </div>

      <div class="pt-4 border-t border-slate-800 flex items-center justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save Global SEO &amp; Meta</span>
        </button>
      </div>
    </form>
  </div>

  <!-- TAB 4: CUSTOM JSON-LD SCHEMA INJECTOR -->
  <div id="tabContent-custom" class="schema-tab-content space-y-6 hidden">
    <form method="POST" action="{{ route('admin.schema.update') }}" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 lg:p-8 space-y-6">
      @csrf
      <input type="hidden" name="section" value="custom">

      <div class="border-b border-slate-800 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-file-code text-[#ff3b30]"></i>
            <span>Raw Custom Schema.org JSON-LD Injector</span>
          </h3>
          <p class="text-xs text-slate-400 mt-1">
            Inject ANY bespoke Schema.org JSON-LD directly into the home page &lt;head&gt; (e.g. SoftwareApplication, Review, AggregateRating, Product, Course, Event).
          </p>
        </div>

        <button type="button" onclick="formatCustomJson()" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-300 hover:text-white transition-colors flex items-center gap-1.5 self-start sm:self-auto">
          <i class="fas fa-wand-magic-sparkles text-amber-400"></i>
          <span>Validate &amp; Format JSON</span>
        </button>
      </div>

      <div class="space-y-3">
        <div class="relative">
          <textarea id="custom_jsonld_editor" name="custom_jsonld" rows="18"
                    class="w-full p-4 bg-slate-950 border border-slate-800 rounded-2xl text-emerald-400 font-mono text-xs leading-relaxed focus:border-[#ff3b30] focus:outline-none shadow-inner"
                    placeholder='[&#10;  {&#10;    "@@context": "https://schema.org",&#10;    "@@type": "SoftwareApplication",&#10;    "name": "WebRanker Engine",&#10;    "applicationCategory": "BusinessApplication"&#10;  }&#10;]'>{{ old('custom_jsonld', $customJsonLdRaw) }}</textarea>
        </div>

        <div id="jsonValidationStatus" class="text-xs px-3 py-2 rounded-xl bg-slate-950 border border-slate-800 text-slate-400 flex items-center gap-2">
          <i class="fas fa-circle-info text-blue-400"></i>
          <span>JSON is validated automatically upon saving. You can also click "Validate &amp; Format JSON" above.</span>
        </div>
      </div>

      <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
        <div class="text-xs text-slate-500">
          <i class="fas fa-shield text-emerald-500 mr-1"></i> Validated JSON will be dynamically output inside <code>&lt;script type="application/ld+json"&gt;</code> on the live site.
        </div>
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save &amp; Inject Custom Schema</span>
        </button>
      </div>
    </form>
  </div>

  <!-- TAB 5: SCHEMA MODULE TOGGLES -->
  <div id="tabContent-toggles" class="schema-tab-content space-y-6 hidden">
    <form method="POST" action="{{ route('admin.schema.update') }}" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 lg:p-8 space-y-6">
      @csrf
      <input type="hidden" name="section" value="toggles">

      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
          <i class="fas fa-toggle-on text-[#ff3b30]"></i>
          <span>Global Schema Modules Activation</span>
        </h3>
        <p class="text-xs text-slate-400 mt-1">
          Enable or disable specific Schema.org microdata modules across the frontend application.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        <label class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start justify-between gap-4 cursor-pointer hover:border-slate-700 transition-colors">
          <div class="space-y-1">
            <span class="text-sm font-bold text-white block">LocalBusiness / ProfessionalService Schema</span>
            <span class="text-xs text-slate-400 block">Injects Jaipur HQ office, physical address, map geo coordinates, opening hours, and phone number.</span>
          </div>
          <input type="checkbox" name="enable_local_business" value="1" {{ ($toggles['enable_local_business'] ?? true) ? 'checked' : '' }}
                 class="w-5 h-5 rounded bg-slate-900 border-slate-700 text-[#ff3b30] focus:ring-0 cursor-pointer mt-1">
        </label>

        <label class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start justify-between gap-4 cursor-pointer hover:border-slate-700 transition-colors">
          <div class="space-y-1">
            <span class="text-sm font-bold text-white block">Organization &amp; Brand Schema</span>
            <span class="text-xs text-slate-400 block">Injects legal corporate entity data, sameAs social links, founder info, and support contact point.</span>
          </div>
          <input type="checkbox" name="enable_organization" value="1" {{ ($toggles['enable_organization'] ?? true) ? 'checked' : '' }}
                 class="w-5 h-5 rounded bg-slate-900 border-slate-700 text-[#ff3b30] focus:ring-0 cursor-pointer mt-1">
        </label>

        <label class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start justify-between gap-4 cursor-pointer hover:border-slate-700 transition-colors">
          <div class="space-y-1">
            <span class="text-sm font-bold text-white block">WebSite &amp; Sitelinks Searchbox Schema</span>
            <span class="text-xs text-slate-400 block">Enables Google to recognize your canonical search action and display a direct search input in SERPs.</span>
          </div>
          <input type="checkbox" name="enable_website" value="1" {{ ($toggles['enable_website'] ?? true) ? 'checked' : '' }}
                 class="w-5 h-5 rounded bg-slate-900 border-slate-700 text-[#ff3b30] focus:ring-0 cursor-pointer mt-1">
        </label>

        <label class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start justify-between gap-4 cursor-pointer hover:border-slate-700 transition-colors">
          <div class="space-y-1">
            <span class="text-sm font-bold text-white block">FAQPage Rich Snippet Schema</span>
            <span class="text-xs text-slate-400 block">Transforms dynamic database FAQs into accordion rich snippet results in Google search results.</span>
          </div>
          <input type="checkbox" name="enable_faq" value="1" {{ ($toggles['enable_faq'] ?? true) ? 'checked' : '' }}
                 class="w-5 h-5 rounded bg-slate-900 border-slate-700 text-[#ff3b30] focus:ring-0 cursor-pointer mt-1">
        </label>

        <label class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start justify-between gap-4 cursor-pointer hover:border-slate-700 transition-colors">
          <div class="space-y-1">
            <span class="text-sm font-bold text-white block">ItemList (Core Services) Schema</span>
            <span class="text-xs text-slate-400 block">Maps your 10 core offerings (Web Dev, SEO, Apps, etc.) into structured Service entities.</span>
          </div>
          <input type="checkbox" name="enable_services" value="1" {{ ($toggles['enable_services'] ?? true) ? 'checked' : '' }}
                 class="w-5 h-5 rounded bg-slate-900 border-slate-700 text-[#ff3b30] focus:ring-0 cursor-pointer mt-1">
        </label>

        <label class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start justify-between gap-4 cursor-pointer hover:border-slate-700 transition-colors">
          <div class="space-y-1">
            <span class="text-sm font-bold text-white block">Custom Injected JSON-LD Schema</span>
            <span class="text-xs text-slate-400 block">Toggles injection of whatever custom Schema.org code is configured in the Custom Schema editor.</span>
          </div>
          <input type="checkbox" name="enable_custom_jsonld" value="1" {{ ($toggles['enable_custom_jsonld'] ?? true) ? 'checked' : '' }}
                 class="w-5 h-5 rounded bg-slate-900 border-slate-700 text-[#ff3b30] focus:ring-0 cursor-pointer mt-1">
        </label>

      </div>

      <div class="pt-4 border-t border-slate-800 flex items-center justify-end">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff3b30] hover:bg-red-600 text-white font-bold text-sm shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
          <i class="fas fa-save"></i>
          <span>Save Module Toggles</span>
        </button>
      </div>
    </form>
  </div>

</div>

@push('admin_scripts')
<script>
  function switchSchemaTab(tabKey) {
    // Hide all contents
    document.querySelectorAll('.schema-tab-content').forEach(el => el.classList.add('hidden'));
    // Remove active styles from buttons
    document.querySelectorAll('.schema-tab-btn').forEach(btn => {
      btn.classList.remove('bg-[#ff3b30]', 'text-white');
      btn.classList.add('text-slate-400');
    });

    // Show selected content
    const targetContent = document.getElementById('tabContent-' + tabKey);
    if (targetContent) {
      targetContent.classList.remove('hidden');
    }

    // Set active button
    const targetBtn = document.getElementById('tabBtn-' + tabKey);
    if (targetBtn) {
      targetBtn.classList.remove('text-slate-400');
      targetBtn.classList.add('bg-[#ff3b30]', 'text-white');
    }
  }

  function formatCustomJson() {
    const editor = document.getElementById('custom_jsonld_editor');
    const status = document.getElementById('jsonValidationStatus');
    const raw = editor.value.trim();

    if (!raw) {
      status.innerHTML = '<i class="fas fa-circle-info text-blue-400"></i> <span>Editor is currently empty.</span>';
      return;
    }

    try {
      const parsed = JSON.parse(raw);
      editor.value = JSON.stringify(parsed, null, 2);
      status.innerHTML = '<i class="fas fa-circle-check text-emerald-400"></i> <span class="text-emerald-300 font-semibold">Valid JSON! Formatted successfully. Ready to inject into live site.</span>';
    } catch (e) {
      status.innerHTML = '<i class="fas fa-triangle-exclamation text-red-400"></i> <span class="text-red-300 font-semibold">Syntax Error: ' + e.message + '</span>';
    }
  }
</script>
@endpush

@endsection
