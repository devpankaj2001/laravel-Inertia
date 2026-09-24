import React, { useEffect } from 'react';
import { router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function Home({
  contentHtml,
  seo = {},
}) {
  useEffect(() => {
    // 1. Initialize WEBRANKER SERVICES Interactive Matrix Tabs
    const svcCards = document.querySelectorAll('#svcCardsContainer .svc-grid-card');
    const activeNum = document.getElementById('activeSvcNum');
    const activeCategory = document.getElementById('activeSvcCategory');
    const activeTitle = document.getElementById('activeSvcTitle');
    const activeDesc = document.getElementById('activeSvcDesc');
    const activeTags = document.getElementById('activeSvcTags');
    const activeLink = document.getElementById('activeSvcLink');
    const stageGraphicImg = document.getElementById('stageGraphicImg');
    const stageImgBadge = document.getElementById('stageImgBadge');
    const stageGraphicLink = document.getElementById('stageGraphicLink');

    const handleSvcCardClick = (card) => {
      svcCards.forEach((c) => c.classList.remove('active'));
      card.classList.add('active');

      if (card.dataset.svcTitle && activeTitle) {
        activeTitle.textContent = card.dataset.svcTitle;
      }
      if (card.dataset.svcDesc && activeDesc) {
        activeDesc.textContent = card.dataset.svcDesc;
      }
      if (card.dataset.svcNum && activeNum) {
        activeNum.textContent = card.dataset.svcNum;
      }
      if (card.dataset.svcCategory && activeCategory) {
        activeCategory.textContent = card.dataset.svcCategory;
      }
      if (card.dataset.svcLink) {
        if (activeLink) activeLink.href = card.dataset.svcLink;
        if (stageGraphicLink) stageGraphicLink.href = card.dataset.svcLink;
      }
      if (card.dataset.svcImg && stageGraphicImg) {
        stageGraphicImg.style.opacity = '0.3';
        stageGraphicImg.style.transform = 'scale(0.98)';
        setTimeout(() => {
          stageGraphicImg.src = card.dataset.svcImg;
          stageGraphicImg.alt = card.dataset.svcTitle || 'Service Graphic Preview';
          stageGraphicImg.style.opacity = '1';
          stageGraphicImg.style.transform = 'scale(1)';
        }, 150);
      }
      if (card.dataset.svcTitle && stageImgBadge) {
        stageImgBadge.textContent = card.dataset.svcTitle;
      }
      if (card.dataset.svcTags && activeTags) {
        try {
          const tags = JSON.parse(card.dataset.svcTags);
          if (Array.isArray(tags) && tags.length > 0) {
            activeTags.innerHTML = tags.map((t) => `<span class="svc-pill-tag">${t}</span>`).join('');
          }
        } catch (e) {
          // ignore
        }
      }
    };

    const cardListeners = [];
    svcCards.forEach((card) => {
      const listener = () => handleSvcCardClick(card);
      card.addEventListener('click', listener);
      cardListeners.push({ card, listener });
    });

    const handleGraphicLinkClick = (e) => {
      const targetUrl = stageGraphicLink?.getAttribute('href') || activeLink?.getAttribute('href');
      if (targetUrl) {
        e.preventDefault();
        router.visit(targetUrl, {
          preserveScroll: false,
        });
      }
    };

    if (stageGraphicLink) {
      stageGraphicLink.addEventListener('click', handleGraphicLinkClick);
    }
    if (stageGraphicImg) {
      stageGraphicImg.style.cursor = 'pointer';
      stageGraphicImg.addEventListener('click', handleGraphicLinkClick);
    }

    const handleActiveLinkClick = (e) => {
      const targetUrl = activeLink?.getAttribute('href');
      if (targetUrl && !targetUrl.startsWith('#')) {
        e.preventDefault();
        router.visit(targetUrl, {
          preserveScroll: false,
        });
      }
    };
    if (activeLink) {
      activeLink.addEventListener('click', handleActiveLinkClick);
    }

    // 2. Initialize Growth Engine Tabs
    const geRoot = document.getElementById('growth-engine');
    const geListeners = [];
    if (geRoot) {
      const geTabs = geRoot.querySelectorAll('.wr-engine-tab');
      const gePanes = geRoot.querySelectorAll('.wr-engine-pane');
      geTabs.forEach((tab) => {
        const listener = () => {
          const key = tab.getAttribute('data-engine');
          geTabs.forEach((item) => {
            const on = item === tab;
            item.classList.toggle('is-active', on);
            item.setAttribute('aria-selected', on ? 'true' : 'false');
          });
          gePanes.forEach((pane) => {
            pane.classList.toggle('is-active', pane.getAttribute('data-engine-pane') === key);
          });
        };
        tab.addEventListener('click', listener);
        geListeners.push({ tab, listener });
      });
    }

    // 3. Initialize 25+ Working Domains Filter Tabs
    const domRoot = document.getElementById('domains');
    const domListeners = [];
    if (domRoot) {
      const domTabs = domRoot.querySelectorAll('.domain-tab-btn');
      const domCards = domRoot.querySelectorAll('.domain-card-item');
      domTabs.forEach((tab) => {
        const listener = () => {
          const filter = tab.getAttribute('data-domain-filter');
          domTabs.forEach((item) => {
            item.classList.toggle('is-active', item === tab);
          });
          domCards.forEach((card) => {
            const show = filter === 'all' || card.getAttribute('data-domain-cat') === filter;
            card.classList.toggle('is-hidden', !show);
          });
        };
        tab.addEventListener('click', listener);
        domListeners.push({ tab, listener });
      });
    }

    // 4. Initialize Office Locations Tabs
    const locCards = document.querySelectorAll('.offices-loc-card');
    const locTitle = document.getElementById('officesLocTitle');
    const locAddress = document.getElementById('officesLocAddress');
    const locPhone = document.getElementById('officesLocPhone');
    const locRegion = document.getElementById('officesLocRegion');

    const officesData = {
      jaipur: {
        region: 'INDIA · RAJASTHAN',
        title: 'WR Jaipur Headquarters',
        address: 'Plot no. 51, Shaheed Amit Bhardwaj Marg, opp. 8/1, Sector 8, Malviya Nagar, Jaipur, Rajasthan 302017',
        phone: '+91 97185 70218',
      },
      noida: {
        region: 'INDIA · NCR',
        title: 'WR Delhi NCR Tech Campus',
        address: 'Sector 62, Electronic City, Noida, Uttar Pradesh 201309',
        phone: '+91 97185 70218',
      },
      sf: {
        region: 'UNITED STATES · CALIFORNIA',
        title: 'WR San Francisco Client Hub',
        address: '535 Mission St, 14th Floor, San Francisco, CA 94105',
        phone: '+1 (415) 890-4288',
      },
    };

    const locListeners = [];
    locCards.forEach((c) => {
      const listener = () => {
        locCards.forEach((x) => x.classList.remove('active'));
        c.classList.add('active');
        const id = c.getAttribute('data-office-id');
        if (id && officesData[id]) {
          if (locRegion) locRegion.textContent = officesData[id].region;
          if (locTitle) locTitle.textContent = officesData[id].title;
          if (locAddress) locAddress.textContent = officesData[id].address;
          if (locPhone) {
            locPhone.href = `tel:${officesData[id].phone.replace(/[^0-9+]/g, '')}`;
            const span = locPhone.querySelector('span');
            if (span) span.textContent = officesData[id].phone;
          }
        }
      };
      c.addEventListener('click', listener);
      locListeners.push({ card: c, listener });
    });

    // 5. Initialize Why WebRanker Feature Showcase Tabs
    const featureTabs = document.querySelectorAll('.ai-feature-tab-btn');
    const featurePanes = document.querySelectorAll('.ai-feature-pane');
    const featureListeners = [];

    featureTabs.forEach((btn) => {
      const listener = () => {
        const targetId = btn.getAttribute('data-tab');
        featureTabs.forEach((b) => b.classList.remove('active'));
        btn.classList.add('active');

        featurePanes.forEach((pane) => {
          if (pane.id === targetId) {
            pane.classList.remove('hidden');
            pane.classList.add('block');
          } else {
            pane.classList.remove('block');
            pane.classList.add('hidden');
          }
        });
      };
      btn.addEventListener('click', listener);
      featureListeners.push({ btn, listener });
    });

    // 6. Initialize Homepage Consultation Lead Form & Security Verification Captcha
    const homeForm = document.getElementById('dsContactForm');
    const captchaBox = document.getElementById('captchaBox');
    const captchaRefreshBtn = document.getElementById('captchaRefreshBtn');
    let currentCaptchaCode = '';

    const generateCaptcha = () => {
      const chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';
      let code = '';
      for (let i = 0; i < 6; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      currentCaptchaCode = code;

      if (captchaBox) {
        captchaBox.innerHTML = '';
        const mark = document.createElement('span');
        mark.textContent = code;
        mark.style.letterSpacing = '0.22em';
        mark.style.fontWeight = '700';
        mark.style.fontFamily = 'Georgia, "Times New Roman", serif';
        mark.style.fontSize = '1.15rem';
        mark.style.fontStyle = 'italic';
        mark.style.userSelect = 'none';
        mark.style.color = '#161514';
        mark.style.display = 'inline-block';
        mark.style.textShadow = '1px 1px 0 rgba(0,0,0,0.08)';
        captchaBox.appendChild(mark);
      }
    };

    const handleCaptchaRefresh = (e) => {
      if (e) e.preventDefault();
      if (captchaRefreshBtn) {
        const icon = captchaRefreshBtn.querySelector('i');
        if (icon) {
          icon.classList.add('fa-spin');
          setTimeout(() => icon.classList.remove('fa-spin'), 450);
        }
      }
      generateCaptcha();
      const captchaInput = homeForm?.querySelector('input[name="captcha"]');
      if (captchaInput) {
        captchaInput.value = '';
        captchaInput.focus();
      }
    };

    if (captchaBox) {
      generateCaptcha();
    }

    if (captchaRefreshBtn) {
      captchaRefreshBtn.addEventListener('click', handleCaptchaRefresh);
    }

    const handleHomeFormSubmit = (e) => {
      e.preventDefault();
      const submitBtn = homeForm?.querySelector('button[type="submit"]');
      const successMsg = document.getElementById('formSuccessMsg');
      const errorMsg = document.getElementById('formErrorMsg');
      const captchaInput = homeForm?.querySelector('input[name="captcha"]');

      if (successMsg) successMsg.classList.add('hidden');
      if (errorMsg) errorMsg.classList.add('hidden');

      // Security Verification Captcha Validation
      if (captchaInput && currentCaptchaCode) {
        const userEntered = captchaInput.value.trim();
        if (!userEntered || userEntered.toLowerCase() !== currentCaptchaCode.toLowerCase()) {
          if (errorMsg) {
            errorMsg.textContent = 'Security captcha code does not match. Please try again.';
            errorMsg.classList.remove('hidden');
          } else {
            alert('Security captcha code does not match. Please try again.');
          }
          handleCaptchaRefresh();
          return;
        }
      }

      const origBtnText = submitBtn ? submitBtn.innerHTML : '';
      if (submitBtn) {
        submitBtn.innerHTML = '<span>Submitting...</span> <i class="fas fa-spinner fa-spin ml-2"></i>';
        submitBtn.disabled = true;
      }

      const formData = new FormData(homeForm);
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

      fetch(homeForm.action || '/inquiry', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {})
        },
        body: formData,
      })
        .then((r) => r.json())
        .then((data) => {
          if (submitBtn) {
            submitBtn.innerHTML = origBtnText;
            submitBtn.disabled = false;
          }
          if (data.success) {
            homeForm.reset();
            generateCaptcha();
            if (successMsg) {
              successMsg.classList.remove('hidden');
              successMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
          } else {
            generateCaptcha();
            if (errorMsg) {
              errorMsg.textContent = data.message || 'Please verify your details and try again.';
              errorMsg.classList.remove('hidden');
            }
          }
        })
        .catch(() => {
          if (submitBtn) {
            submitBtn.innerHTML = origBtnText;
            submitBtn.disabled = false;
          }
          generateCaptcha();
          if (errorMsg) {
            errorMsg.textContent = 'Network connection error. Please call or email us directly.';
            errorMsg.classList.remove('hidden');
          }
        });
    };

    if (homeForm) {
      homeForm.addEventListener('submit', handleHomeFormSubmit);
    }

    // Trigger window events for third-party libraries (OwlCarousel, Leaflet, etc.)
    try {
      window.dispatchEvent(new Event('DOMContentLoaded'));
      window.dispatchEvent(new Event('load'));
      window.dispatchEvent(new Event('resize'));
    } catch (e) {
      // ignore
    }

    return () => {
      cardListeners.forEach(({ card, listener }) => card.removeEventListener('click', listener));
      geListeners.forEach(({ tab, listener }) => tab.removeEventListener('click', listener));
      domListeners.forEach(({ tab, listener }) => tab.removeEventListener('click', listener));
      locListeners.forEach(({ card, listener }) => card.removeEventListener('click', listener));
      featureListeners.forEach(({ btn, listener }) => btn.removeEventListener('click', listener));
      if (stageGraphicLink) stageGraphicLink.removeEventListener('click', handleGraphicLinkClick);
      if (stageGraphicImg) stageGraphicImg.removeEventListener('click', handleGraphicLinkClick);
      if (activeLink) activeLink.removeEventListener('click', handleActiveLinkClick);
      if (captchaRefreshBtn) captchaRefreshBtn.removeEventListener('click', handleCaptchaRefresh);
      if (homeForm) homeForm.removeEventListener('submit', handleHomeFormSubmit);
    };
  }, [contentHtml]);

  return (
    <AppLayout seo={seo}>
      {({ openInquiry, openLinkModal }) => (
        <div
          id="homeBladeContent"
          className="w-full"
          dangerouslySetInnerHTML={{ __html: contentHtml }}
        />
      )}
    </AppLayout>
  );
}
