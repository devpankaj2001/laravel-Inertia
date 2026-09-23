<!-- Live Real-Time SEO & Ranking Audit Bar -->
<div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 space-y-4 shadow-xl" id="seoAuditWidget">
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-800">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-lg shadow-sm">
        <i class="fas fa-chart-line"></i>
      </div>
      <div>
        <div class="flex items-center gap-2">
          <h4 class="text-sm font-extrabold text-white">Live Search Engine Ranking Score</h4>
          <span id="seoScoreBadge" class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
            60/100
          </span>
        </div>
        <p class="text-[11px] text-slate-400">Real-time on-page SEO analyzer ensuring optimal Google SERP ranking &amp; CTR.</p>
      </div>
    </div>

    <!-- Progress Meter -->
    <div class="w-full sm:w-48 space-y-1">
      <div class="flex justify-between text-[11px] font-mono font-bold">
        <span class="text-slate-400">Optimization:</span>
        <span id="seoScorePct" class="text-emerald-400">60%</span>
      </div>
      <div class="w-full h-2 rounded-full bg-slate-950 overflow-hidden border border-slate-800">
        <div id="seoScoreProgressBar" class="h-full bg-gradient-to-r from-amber-500 to-emerald-500 transition-all duration-300" style="width: 60%;"></div>
      </div>
    </div>
  </div>

  <!-- Live Checklist Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5 text-xs" id="seoChecklist">
    
    <!-- Item 1: Keyword in Title -->
    <div id="checkKwTitle" class="p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
      <span class="text-slate-400 flex items-center gap-2">
        <i class="fas fa-heading text-slate-500 text-[11px]"></i> Keyword in Title
      </span>
      <span class="status-icon text-slate-500"><i class="fas fa-circle-xmark"></i></span>
    </div>

    <!-- Item 2: Keyword in Meta Description -->
    <div id="checkKwDesc" class="p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
      <span class="text-slate-400 flex items-center gap-2">
        <i class="fas fa-align-left text-slate-500 text-[11px]"></i> Keyword in Meta Desc
      </span>
      <span class="status-icon text-slate-500"><i class="fas fa-circle-xmark"></i></span>
    </div>

    <!-- Item 3: Title Length -->
    <div id="checkTitleLength" class="p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
      <span class="text-slate-400 flex items-center gap-2">
        <i class="fas fa-ruler text-slate-500 text-[11px]"></i> Title Length (45-60)
      </span>
      <span class="status-text font-mono text-[10px] text-slate-400">0 / 60</span>
    </div>

    <!-- Item 4: Meta Description Length -->
    <div id="checkDescLength" class="p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
      <span class="text-slate-400 flex items-center gap-2">
        <i class="fas fa-ruler-horizontal text-slate-500 text-[11px]"></i> Meta Desc (120-160)
      </span>
      <span class="status-text font-mono text-[10px] text-slate-400">0 / 160</span>
    </div>

    <!-- Item 5: Keyword in Content -->
    <div id="checkKwContent" class="p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
      <span class="text-slate-400 flex items-center gap-2">
        <i class="fas fa-file-lines text-slate-500 text-[11px]"></i> Keyword in Body
      </span>
      <span class="status-icon text-slate-500"><i class="fas fa-circle-xmark"></i></span>
    </div>

    <!-- Item 6: Word Count & Depth -->
    <div id="checkWordCount" class="p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between">
      <span class="text-slate-400 flex items-center gap-2">
        <i class="fas fa-book-open text-slate-500 text-[11px]"></i> Depth (300+ words)
      </span>
      <span class="status-text font-mono text-[10px] text-slate-400">0 words</span>
    </div>

  </div>
</div>

<script>
  function runLiveSeoAudit() {
    const titleEl = document.getElementById('metaTitleInput') || document.getElementById('titleInput');
    const descEl = document.getElementById('metaDescInput');
    const kwEl = document.getElementById('keywordsInput') || document.getElementById('focusKeywordsInput');
    const contentEl = document.getElementById('blogContentInput') || document.getElementById('detailedContentInput');

    const title = titleEl ? titleEl.value.trim() : '';
    const desc = descEl ? descEl.value.trim() : '';
    const rawKeywords = kwEl ? kwEl.value.trim() : '';
    const content = typeof classicEditorInstance !== 'undefined' && classicEditorInstance ? classicEditorInstance.getData() : (contentEl ? contentEl.value : '');

    const firstKw = rawKeywords.split(',')[0].trim().toLowerCase();

    let score = 0;
    const maxScore = 100;

    // Check 1: Keyword in Title (20 pts)
    const checkKwTitle = document.getElementById('checkKwTitle');
    if (checkKwTitle) {
      const hasKwTitle = firstKw && title.toLowerCase().includes(firstKw);
      if (hasKwTitle) {
        score += 20;
        checkKwTitle.className = 'p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center justify-between';
        checkKwTitle.querySelector('.status-icon').innerHTML = '<i class="fas fa-check-circle text-emerald-400"></i>';
      } else {
        checkKwTitle.className = 'p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 text-slate-400 flex items-center justify-between';
        checkKwTitle.querySelector('.status-icon').innerHTML = '<i class="fas fa-circle-xmark text-slate-500"></i>';
      }
    }

    // Check 2: Keyword in Meta Desc (20 pts)
    const checkKwDesc = document.getElementById('checkKwDesc');
    if (checkKwDesc) {
      const hasKwDesc = firstKw && desc.toLowerCase().includes(firstKw);
      if (hasKwDesc) {
        score += 20;
        checkKwDesc.className = 'p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center justify-between';
        checkKwDesc.querySelector('.status-icon').innerHTML = '<i class="fas fa-check-circle text-emerald-400"></i>';
      } else {
        checkKwDesc.className = 'p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 text-slate-400 flex items-center justify-between';
        checkKwDesc.querySelector('.status-icon').innerHTML = '<i class="fas fa-circle-xmark text-slate-500"></i>';
      }
    }

    // Check 3: Title Length (45-60) (15 pts)
    const checkTitleLength = document.getElementById('checkTitleLength');
    if (checkTitleLength) {
      const tLen = title.length;
      checkTitleLength.querySelector('.status-text').textContent = `${tLen} / 60`;
      if (tLen >= 40 && tLen <= 65) {
        score += 15;
        checkTitleLength.className = 'p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center justify-between';
      } else if (tLen > 0) {
        score += 5;
        checkTitleLength.className = 'p-2.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 flex items-center justify-between';
      } else {
        checkTitleLength.className = 'p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 text-slate-400 flex items-center justify-between';
      }
    }

    // Check 4: Meta Desc Length (120-160) (15 pts)
    const checkDescLength = document.getElementById('checkDescLength');
    if (checkDescLength) {
      const dLen = desc.length;
      checkDescLength.querySelector('.status-text').textContent = `${dLen} / 160`;
      if (dLen >= 110 && dLen <= 165) {
        score += 15;
        checkDescLength.className = 'p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center justify-between';
      } else if (dLen > 0) {
        score += 5;
        checkDescLength.className = 'p-2.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 flex items-center justify-between';
      } else {
        checkDescLength.className = 'p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 text-slate-400 flex items-center justify-between';
      }
    }

    // Check 5: Keyword in Content Body (15 pts)
    const cleanContentText = content.replace(/<[^>]*>/g, '').toLowerCase();
    const checkKwContent = document.getElementById('checkKwContent');
    if (checkKwContent) {
      const hasKwBody = firstKw && cleanContentText.includes(firstKw);
      if (hasKwBody) {
        score += 15;
        checkKwContent.className = 'p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center justify-between';
        checkKwContent.querySelector('.status-icon').innerHTML = '<i class="fas fa-check-circle text-emerald-400"></i>';
      } else {
        checkKwContent.className = 'p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 text-slate-400 flex items-center justify-between';
        checkKwContent.querySelector('.status-icon').innerHTML = '<i class="fas fa-circle-xmark text-slate-500"></i>';
      }
    }

    // Check 6: Word Count & Depth (15 pts)
    const words = cleanContentText.split(/\s+/).filter(w => w.length > 0).length;
    const checkWordCount = document.getElementById('checkWordCount');
    if (checkWordCount) {
      checkWordCount.querySelector('.status-text').textContent = `${words} words`;
      if (words >= 350) {
        score += 15;
        checkWordCount.className = 'p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center justify-between';
      } else if (words >= 100) {
        score += 8;
        checkWordCount.className = 'p-2.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 flex items-center justify-between';
      } else {
        checkWordCount.className = 'p-2.5 rounded-xl bg-slate-950/70 border border-slate-800 text-slate-400 flex items-center justify-between';
      }
    }

    // Update Overall Score & Bar
    const badge = document.getElementById('seoScoreBadge');
    const pct = document.getElementById('seoScorePct');
    const bar = document.getElementById('seoScoreProgressBar');

    if (badge && pct && bar) {
      badge.textContent = `${score}/100`;
      pct.textContent = `${score}%`;
      bar.style.width = `${score}%`;

      if (score >= 80) {
        badge.className = 'px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
        bar.className = 'h-full bg-emerald-500 transition-all duration-300';
      } else if (score >= 50) {
        badge.className = 'px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30';
        bar.className = 'h-full bg-amber-500 transition-all duration-300';
      } else {
        badge.className = 'px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-red-500/20 text-red-300 border border-red-500/30';
        bar.className = 'h-full bg-red-500 transition-all duration-300';
      }
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const inputs = ['metaTitleInput', 'titleInput', 'metaDescInput', 'keywordsInput', 'focusKeywordsInput', 'blogContentInput', 'detailedContentInput'];
    inputs.forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('input', runLiveSeoAudit);
    });

    setTimeout(runLiveSeoAudit, 500);
  });
</script>
