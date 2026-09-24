<main class="contact-page-main">

  <!-- ======= 1. CONTACT HERO SECTION ======= -->
  <section class="relative py-20 lg:py-24 bg-gradient-to-b from-[#f5efe6] via-[#faf7f2] to-[#faf7f2] border-b border-[#e6dfd3] overflow-hidden">
    <div class="absolute inset-0 opacity-40 pointer-events-none" style="background-image: radial-gradient(#d3c8b8 1px, transparent 1px); background-size: 24px 24px;"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#161514] text-white text-xs font-bold uppercase tracking-wider mb-6 shadow-sm">
        <span class="w-2 h-2 rounded-full bg-[#ff3b30] animate-pulse"></span>
        <span>GET IN TOUCH WITH OUR SENIOR STRATEGISTS</span>
      </div>

      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#161514] tracking-tight leading-tight max-w-4xl mx-auto">
        Let's Engineer Your <span class="text-[#ff3b30]">#1 Organic Ranking</span> Advantage.
      </h1>

      <p class="mt-6 text-base sm:text-lg text-[#6e675f] max-w-2xl mx-auto leading-relaxed">
        Whether you are seeking an enterprise technical SEO audit, high-performance web development, or a full bespoke organic growth roadmap, our principal engineers are here to help.
      </p>

      <nav class="mt-8 flex justify-center items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#8c827a]" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-[#ff3b30] transition-colors">Home</a>
        <span class="text-[#c8bfb3]">/</span>
        <span class="text-[#161514]" aria-current="page">Contact</span>
      </nav>
    </div>
  </section>

  <!-- ======= 2. MAIN CONTACT CHANNELS & INTERACTIVE FORM ======= -->
  <section class="py-16 lg:py-24 bg-[#faf7f2]" id="contactSection">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
        
        <!-- Left Column: Direct Communication Hub (5 Cols) -->
        <div class="lg:col-span-5 space-y-8">
          <div>
            <span class="text-xs font-extrabold tracking-widest text-[#ff3b30] uppercase">DIRECT ACCESS</span>
            <h2 class="text-2xl sm:text-3xl font-black text-[#161514] tracking-tight mt-1">
              Talk Directly with Our Senior Growth Architects
            </h2>
            <p class="mt-3 text-sm text-[#6e675f] leading-relaxed">
              No junior account handlers or endless sales pitches. You talk straight with engineers and digital architects who understand code, SERP mechanics, and commercial conversions.
            </p>
          </div>

          <!-- Contact Channel Cards -->
          <div class="space-y-4">
            
            <!-- Email Card -->
            <a href="mailto:{{ $contactInfo['email'] }}" class="group block p-5 rounded-2xl bg-white border border-[#e6dfd3] hover:border-[#ff3b30] hover:shadow-lg transition-all duration-300">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#f5efe6] group-hover:bg-[#ff3b30] text-[#ff3b30] group-hover:text-white flex items-center justify-center text-lg transition-colors shrink-0">
                  <i class="far fa-envelope"></i>
                </div>
                <div>
                  <span class="text-xs font-bold uppercase tracking-wider text-[#8c827a]">Direct Email</span>
                  <p class="text-base font-bold text-[#161514] group-hover:text-[#ff3b30] transition-colors mt-0.5">
                    {{ $contactInfo['email'] }}
                  </p>
                  <p class="text-xs text-[#8c827a] mt-1 flex items-center gap-1.5 font-mono">
                    <i class="far fa-clock text-[10px]"></i> Average response: {{ $contactInfo['response_time'] }}
                  </p>
                </div>
              </div>
            </a>

            <!-- Phone Card -->
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactInfo['phone']) }}" class="group block p-5 rounded-2xl bg-white border border-[#e6dfd3] hover:border-[#ff3b30] hover:shadow-lg transition-all duration-300">
              <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#f5efe6] group-hover:bg-[#ff3b30] text-[#ff3b30] group-hover:text-white flex items-center justify-center text-lg transition-colors shrink-0">
                  <i class="fas fa-headset"></i>
                </div>
                <div>
                  <span class="text-xs font-bold uppercase tracking-wider text-[#8c827a]">Direct Phone / WhatsApp</span>
                  <p class="text-base font-bold text-[#161514] group-hover:text-[#ff3b30] transition-colors mt-0.5">
                    {{ $contactInfo['phone'] }}
                  </p>
                  <p class="text-xs text-[#8c827a] mt-1 font-mono">
                    Instant strategist consultation during business hours
                  </p>
                </div>
              </div>
            </a>

            <!-- Location Card -->
            <div class="p-5 rounded-2xl bg-white border border-[#e6dfd3] flex items-start gap-4">
              <div class="w-12 h-12 rounded-xl bg-[#f5efe6] text-[#ff3b30] flex items-center justify-center text-lg shrink-0">
                <i class="fas fa-location-dot"></i>
              </div>
              <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#8c827a]">Engineering Hub &amp; Headquarters</span>
                <p class="text-sm font-bold text-[#161514] mt-0.5">
                  {{ $contactInfo['address'] }}
                </p>
                <p class="text-xs text-[#8c827a] mt-1">
                  Serving high-growth companies across the US, UK, EU, UAE &amp; APAC
                </p>
              </div>
            </div>

            <!-- Hours Card -->
            <div class="p-5 rounded-2xl bg-[#f5efe6] border border-[#e6dfd3] flex items-start gap-4">
              <div class="w-12 h-12 rounded-xl bg-[#161514] text-white flex items-center justify-center text-lg shrink-0">
                <i class="far fa-calendar-check"></i>
              </div>
              <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#6e675f]">Consultation Hours</span>
                <p class="text-xs font-bold text-[#161514] mt-0.5">
                  {{ $contactInfo['hours'] }}
                </p>
              </div>
            </div>

          </div>

          <!-- Trust Assurances Bento -->
          <div class="p-6 rounded-2xl bg-[#161514] text-white space-y-4 shadow-xl">
            <p class="text-xs font-black uppercase tracking-widest text-[#ff3b30]">The WebRanker Guarantee</p>
            <ul class="space-y-3 text-xs text-slate-300">
              <li class="flex items-center gap-2.5">
                <i class="fas fa-shield-halved text-[#ff3b30]"></i>
                <span>Strict Non-Disclosure (NDA) protection for all client domains</span>
              </li>
              <li class="flex items-center gap-2.5">
                <i class="fas fa-chart-line text-[#ff3b30]"></i>
                <span>Complimentary baseline Core Web Vitals &amp; SERP audit report</span>
              </li>
              <li class="flex items-center gap-2.5">
                <i class="fas fa-handshake-angle text-[#ff3b30]"></i>
                <span>Zero sales harassment. Honest feasibility assessment only</span>
              </li>
            </ul>
          </div>

        </div>

        <!-- Right Column: Interactive Consultation Form (7 Cols) -->
        <div class="lg:col-span-7">
          <div class="bg-white rounded-3xl border border-[#e6dfd3] p-8 sm:p-10 shadow-xl relative">
            <div class="mb-8">
              <span class="text-xs font-black tracking-widest text-[#ff3b30] uppercase">FREE DOMAIN &amp; GROWTH AUDIT</span>
              <h3 class="text-2xl sm:text-3xl font-black text-[#161514] tracking-tight mt-1">
                Tell Us About Your Goals &amp; Website
              </h3>
              <p class="text-xs sm:text-sm text-[#6e675f] mt-2">
                Fill in the details below. Our technical SEO strategists will inspect your domain benchmarks and send actionable recommendations.
              </p>
            </div>

            <!-- Contact Form -->
            <form id="mainContactPageForm" method="POST" action="{{ route('inquiry.store') }}" class="space-y-6">
              @csrf
              <!-- Anti-spam honeypot -->
              <input type="text" name="website_hp" value="" style="display:none !important;" tabindex="-1" autocomplete="off">

              <!-- Form Success & Error Notifications -->
              <div id="contactFormSuccess" class="hidden p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold">
                <i class="fas fa-circle-check mr-2 text-emerald-600"></i>
                <span>Thank you! Your inquiry has been submitted. Our senior strategist will review your domain within 24 hours.</span>
              </div>

              <div id="contactFormError" class="hidden p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-bold">
                <i class="fas fa-triangle-exclamation mr-2 text-red-600"></i>
                <span id="contactFormErrorText">Please verify all required fields and try again.</span>
              </div>

              <!-- Two Column Fields: Name & Email -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label for="contact_name" class="block text-xs font-bold uppercase tracking-wider text-[#161514] mb-2">
                    Full Name <span class="text-[#ff3b30]">*</span>
                  </label>
                  <input type="text" id="contact_name" name="name" required placeholder="e.g. Rahul Sharma"
                         class="w-full px-4 py-3 rounded-xl border border-[#e6dfd3] bg-[#faf7f2] text-sm text-[#161514] placeholder-[#8c827a] focus:bg-white focus:outline-none focus:border-[#ff3b30] transition-colors">
                </div>

                <div>
                  <label for="contact_email" class="block text-xs font-bold uppercase tracking-wider text-[#161514] mb-2">
                    Work Email <span class="text-[#ff3b30]">*</span>
                  </label>
                  <input type="email" id="contact_email" name="email" required placeholder="name@company.com"
                         class="w-full px-4 py-3 rounded-xl border border-[#e6dfd3] bg-[#faf7f2] text-sm text-[#161514] placeholder-[#8c827a] focus:bg-white focus:outline-none focus:border-[#ff3b30] transition-colors">
                </div>
              </div>

              <!-- Two Column Fields: Phone & Company/Domain -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label for="contact_phone" class="block text-xs font-bold uppercase tracking-wider text-[#161514] mb-2">
                    Phone / WhatsApp
                  </label>
                  <input type="tel" id="contact_phone" name="phone" placeholder="+91 98765 43210"
                         class="w-full px-4 py-3 rounded-xl border border-[#e6dfd3] bg-[#faf7f2] text-sm text-[#161514] placeholder-[#8c827a] focus:bg-white focus:outline-none focus:border-[#ff3b30] transition-colors">
                </div>

                <div>
                  <label for="contact_company" class="block text-xs font-bold uppercase tracking-wider text-[#161514] mb-2">
                    Website URL or Company Name
                  </label>
                  <input type="text" id="contact_company" name="company" placeholder="https://yourwebsite.com"
                         class="w-full px-4 py-3 rounded-xl border border-[#e6dfd3] bg-[#faf7f2] text-sm text-[#161514] placeholder-[#8c827a] focus:bg-white focus:outline-none focus:border-[#ff3b30] transition-colors">
                </div>
              </div>

              <!-- Service of Interest & Estimated Monthly Budget -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                  <label for="contact_service" class="block text-xs font-bold uppercase tracking-wider text-[#161514] mb-2">
                    Primary Service Needed
                  </label>
                  <select id="contact_service" name="service_interest"
                          class="w-full px-4 py-3 rounded-xl border border-[#e6dfd3] bg-[#faf7f2] text-sm text-[#161514] focus:bg-white focus:outline-none focus:border-[#ff3b30] transition-colors">
                    <option value="Enterprise SEO & Organic Growth">Enterprise SEO &amp; Organic Growth</option>
                    <option value="Modern Web & Software Development">Modern Web &amp; Software Development</option>
                    <option value="Core Web Vitals & Page Speed Fixes">Core Web Vitals &amp; Page Speed Fixes</option>
                    <option value="Programmatic SEO & Content Clusters">Programmatic SEO &amp; Content Clusters</option>
                    <option value="High-Authority Editorial Link Building">High-Authority Editorial Link Building</option>
                    <option value="Other / Full Custom Transformation">Other / Full Custom Transformation</option>
                  </select>
                </div>

                <div>
                  <div class="flex items-center justify-between mb-2">
                    <label for="contact_budget_select" class="block text-xs font-bold uppercase tracking-wider text-[#161514]">
                      Estimated Budget
                    </label>
                    <span class="text-[11px] text-[#8c827a] font-normal">Optional / Flexible</span>
                  </div>
                  <!-- Hidden final input submitted with form -->
                  <input type="hidden" id="contact_budget_final" name="budget" value="Not Decided / Flexible">

                  <select id="contact_budget_select"
                          class="w-full px-4 py-3 rounded-xl border border-[#e6dfd3] bg-[#faf7f2] text-sm text-[#161514] focus:bg-white focus:outline-none focus:border-[#ff3b30] transition-colors">
                    <option value="Not Decided / Flexible" selected>Not Decided / Flexible</option>
                    <option value="< $100">&lt; $100</option>
                    <option value="$100 - $500">$100 - $500</option>
                    <option value="$500 - $1,000">$500 - $1,000</option>
                    <option value="$1,000 - $1,500">$1,000 - $1,500</option>
                    <option value="> $2,000">&gt; $2,000</option>
                    <option value="__manual__">Custom / Enter Manual Amount...</option>
                  </select>

                  <!-- Manual text entry container, shown if __manual__ is chosen -->
                  <div id="manualBudgetContainer" class="hidden mt-2.5">
                    <div class="relative">
                      <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-[#8c827a] font-bold">$</span>
                      <input type="text" id="manualBudgetInput" placeholder="Enter custom amount (e.g. 750, 1800, etc.)"
                             class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-[#ff3b30] bg-white text-sm text-[#161514] placeholder-[#8c827a] focus:outline-none shadow-xs">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Message / Specific Challenges -->
              <div>
                <label for="contact_message" class="block text-xs font-bold uppercase tracking-wider text-[#161514] mb-2">
                  Project Scope or Current Challenges
                </label>
                <textarea id="contact_message" name="message" rows="4" placeholder="Briefly describe your traffic bottlenecks, tech stack, keyword targets, or redesign goals..."
                          class="w-full px-4 py-3 rounded-xl border border-[#e6dfd3] bg-[#faf7f2] text-sm text-[#161514] placeholder-[#8c827a] focus:bg-white focus:outline-none focus:border-[#ff3b30] transition-colors resize-none"></textarea>
              </div>

              <!-- Submit CTA Button -->
              <div>
                <button type="submit" id="contactSubmitBtn"
                        class="w-full py-4 px-8 rounded-xl bg-[#ff3b30] hover:bg-[#e0342a] text-white text-sm font-black uppercase tracking-wider shadow-lg shadow-red-500/25 transition-all duration-300 flex items-center justify-center gap-3">
                  <span>SUBMIT &amp; REQUEST FREE AUDIT</span>
                  <i class="fas fa-arrow-right text-xs"></i>
                </button>
                <p class="text-[11px] text-[#8c827a] text-center mt-3">
                  We respect your privacy. No spam. You will be contacted within 24 business hours.
                </p>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ======= 3. FREQUENTLY ASKED QUESTIONS BEFORE REACHING OUT ======= -->
  <section class="py-20 bg-[#f5efe6] border-t border-[#e6dfd3]">
    <div class="max-w-5xl mx-auto px-6">
      <div class="text-center max-w-2xl mx-auto mb-14">
        <span class="text-xs font-black tracking-widest text-[#ff3b30] uppercase">QUICK CLARIFICATIONS</span>
        <h2 class="text-3xl font-black text-[#161514] tracking-tight mt-1">
          Frequently Asked Questions
        </h2>
        <p class="text-sm text-[#6e675f] mt-2">
          Everything you need to know before initiating your growth consultation with WebRanker.
        </p>
      </div>

      <div class="space-y-4">
        @foreach($faqs as $index => $faq)
          <div class="p-6 rounded-2xl bg-white border border-[#e6dfd3] hover:border-slate-300 transition-colors shadow-sm">
            <h3 class="text-base font-bold text-[#161514] flex items-start gap-3">
              <span class="w-6 h-6 rounded-full bg-[#f5efe6] text-[#ff3b30] text-xs font-black flex items-center justify-center shrink-0 mt-0.5">
                {{ $index + 1 }}
              </span>
              <span>{{ $faq['question'] }}</span>
            </h3>
            <p class="mt-3 text-xs sm:text-sm text-[#6e675f] pl-9 leading-relaxed">
              {{ $faq['answer'] }}
            </p>
          </div>
        @endforeach
      </div>

      <!-- Still Have Questions Banner -->
      <div class="mt-12 text-center p-8 rounded-3xl bg-white border border-[#e6dfd3] shadow-sm">
        <p class="text-base font-bold text-[#161514]">
          Prefer a quick direct conversation without forms?
        </p>
        <p class="text-xs text-[#6e675f] mt-1">
          Reach our strategist desk directly via phone or WhatsApp.
        </p>
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactInfo['phone']) }}" class="inline-flex items-center gap-2 mt-4 px-6 py-2.5 rounded-full bg-[#161514] text-white text-xs font-bold hover:bg-[#ff3b30] transition-colors">
          <i class="fas fa-phone text-[10px]"></i>
          <span>Call Us: {{ $contactInfo['phone'] }}</span>
        </a>
      </div>

    </div>
  </section>

</main>

<script>
  // Handle Contact Page AJAX Form Submission
  document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('mainContactPageForm');
    if (!form) return;

    var budgetSelect = document.getElementById('contact_budget_select');
    var budgetFinal = document.getElementById('contact_budget_final');
    var manualContainer = document.getElementById('manualBudgetContainer');
    var manualInput = document.getElementById('manualBudgetInput');

    if (budgetSelect && budgetFinal) {
      budgetSelect.addEventListener('change', function() {
        if (this.value === '__manual__') {
          if (manualContainer) manualContainer.classList.remove('hidden');
          if (manualInput) {
            manualInput.focus();
            budgetFinal.value = manualInput.value ? ('$' + manualInput.value.replace(/^\$/, '')) : 'Custom Budget';
          }
        } else {
          if (manualContainer) manualContainer.classList.add('hidden');
          budgetFinal.value = this.value;
        }
      });

      if (manualInput) {
        manualInput.addEventListener('input', function() {
          budgetFinal.value = this.value ? ('$' + this.value.replace(/^\$/, '')) : 'Custom Budget';
        });
      }
    }

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      var btn = document.getElementById('contactSubmitBtn');
      var successBox = document.getElementById('contactFormSuccess');
      var errorBox = document.getElementById('contactFormError');
      var errorText = document.getElementById('contactFormErrorText');

      successBox.classList.add('hidden');
      errorBox.classList.add('hidden');

      var origContent = btn.innerHTML;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
      btn.disabled = true;

      var formData = new FormData(form);

      fetch(form.action, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        body: formData
      })
      .then(function(res) { return res.json(); })
      .then(function(data) {
        btn.innerHTML = origContent;
        btn.disabled = false;
        if (data.success) {
          successBox.classList.remove('hidden');
          form.reset();
          if (budgetSelect) budgetSelect.value = 'Not Decided / Flexible';
          if (budgetFinal) budgetFinal.value = 'Not Decided / Flexible';
          if (manualContainer) manualContainer.classList.add('hidden');
          if (manualInput) manualInput.value = '';
        } else {
          errorText.innerText = data.message || 'Validation error. Please verify your details.';
          errorBox.classList.remove('hidden');
        }
      })
      .catch(function(err) {
        btn.innerHTML = origContent;
        btn.disabled = false;
        errorText.innerText = 'Network connection error. Please try calling or emailing us directly.';
        errorBox.classList.remove('hidden');
      });
    });
  });
</script>
