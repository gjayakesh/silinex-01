/* ============================================================
   Silinex Global – main.js  (brand-matched to silinexglobal.com)
   ============================================================ */
(function () {
  'use strict';

  /* ── Page loader ─────────────────────────────────────── */
  window.addEventListener('load', () => {
    const loader = document.getElementById('pageLoader');
    if (loader) loader.classList.add('hidden');
  });

  /* ── Sticky header ───────────────────────────────────── */
  const header = document.getElementById('siteHeader');
  const whatsappFloat = document.querySelector('.wa-float');
  function onScroll() {
    if (!header) return;
    header.classList.toggle('scrolled', window.scrollY > 40);
    whatsappFloat?.classList.toggle('is-visible', window.innerWidth > 720 || window.scrollY > window.innerHeight * 0.65);
    
    // Dynamic Header Background based on current section
    const headerBottom = header.getBoundingClientRect().bottom;
    const elements = document.querySelectorAll('section, footer');
    let currentElement = null;
    
    for (let i = 0; i < elements.length; i++) {
      const rect = elements[i].getBoundingClientRect();
      if (rect.top <= headerBottom && rect.bottom >= headerBottom) {
        currentElement = elements[i];
        break;
      }
    }

    if (currentElement) {
      let bg = window.getComputedStyle(currentElement).backgroundColor;
      let bgImg = window.getComputedStyle(currentElement).backgroundImage;
      
      // Fallback for transparent backgrounds
      if (bg === 'rgba(0, 0, 0, 0)' || bg === 'transparent') {
         bg = 'var(--white)';
      }
      
      // Special case for sections with absolute background elements
      const bgElement = currentElement.querySelector('.hero-bg-gradient, .hero-bg');
      if (bgElement) {
         let computedStyle = window.getComputedStyle(bgElement);
         if (computedStyle.backgroundImage && computedStyle.backgroundImage !== 'none') {
             bgImg = computedStyle.backgroundImage;
         } else if (computedStyle.backgroundColor !== 'rgba(0, 0, 0, 0)') {
             bg = computedStyle.backgroundColor;
         }
      }

      if (bgImg && bgImg !== 'none') {
          header.style.background = bgImg;
      } else {
          header.style.background = bg;
      }

      // Check if background is dark
      let isDark = false;
      let parseBg = bg;
      
      if (bgImg && bgImg !== 'none') {
        const rgbMatches = bgImg.match(/rgb\(\d+,\s*\d+,\s*\d+\)/g) || bgImg.match(/rgba\(\d+,\s*\d+,\s*\d+,\s*[\d.]+\)/g);
        if (rgbMatches && rgbMatches.length > 0) {
          let totalHsp = 0;
          rgbMatches.forEach(rgbStr => {
            const rgb = rgbStr.match(/\d+/g);
            const r = parseInt(rgb[0]);
            const g = parseInt(rgb[1]);
            const b = parseInt(rgb[2]);
            totalHsp += Math.sqrt(0.299 * (r * r) + 0.587 * (g * g) + 0.114 * (b * b));
          });
          const avgHsp = totalHsp / rgbMatches.length;
          isDark = avgHsp < 127.5;
        } else {
          // Fallback if gradient uses variable names or hexes instead of raw RGBs
          if (bgImg.includes('var(--navy)') || bgImg.includes('#0b1c3d') || bgImg.includes('#040c1e')) {
            isDark = true;
          }
        }
      } else {
        if (parseBg === 'var(--white)') parseBg = 'rgb(255, 255, 255)';
        const rgb = parseBg.match(/\d+/g);
        if (rgb && rgb.length >= 3) {
          const r = parseInt(rgb[0]);
          const g = parseInt(rgb[1]);
          const b = parseInt(rgb[2]);
          const hsp = Math.sqrt(
            0.299 * (r * r) +
            0.587 * (g * g) +
            0.114 * (b * b)
          );
          isDark = hsp < 127.5;
        }
      }
      header.classList.toggle('header-dark', isDark);

    } else {
      header.style.background = 'var(--white)';
      header.classList.remove('header-dark');
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
  window.addEventListener('resize', onScroll, { passive: true });

  /* ── Mobile menu ─────────────────────────────────────── */
  const toggle  = document.getElementById('menuToggle');
  const nav     = document.getElementById('mainNav');
  const overlay = document.getElementById('navOverlay');

  function closeDropdowns() {
    document.querySelectorAll('.has-dropdown.open').forEach(item => {
      item.classList.remove('open');
      item.querySelector('.nav-link')?.setAttribute('aria-expanded', 'false');
    });
  }

  function closeMenu() {
    nav?.classList.remove('open');
    toggle?.classList.remove('open');
    overlay?.classList.remove('open');
    document.body.classList.remove('menu-open');
    toggle?.setAttribute('aria-expanded', 'false');
    closeDropdowns();
  }

  toggle?.addEventListener('click', () => {
    const open = nav?.classList.toggle('open');
    toggle.classList.toggle('open', open);
    overlay?.classList.toggle('open', open);
    document.body.classList.toggle('menu-open', Boolean(open));
    toggle.setAttribute('aria-expanded', open);
  });
  overlay?.addEventListener('click', closeMenu);

  /* Tablet/mobile: tap has-dropdown parent to expand */
  document.querySelectorAll('.has-dropdown > .nav-link').forEach(link => {
    link.addEventListener('click', e => {
      if (window.innerWidth <= 980) {
        e.preventDefault();
        const item = link.closest('.has-dropdown');
        const willOpen = !item?.classList.contains('open');
        closeDropdowns();
        item?.classList.toggle('open', willOpen);
        link.setAttribute('aria-expanded', String(willOpen));
      }
    });
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeMenu();
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 980) closeMenu();
  });

  /* ── Hero slider ─────────────────────────────────────── */
  const slides   = document.querySelectorAll('.hero-slide');
  const allDots  = document.querySelectorAll('.hero-dot');
  let   current  = 0, timer;

  function goSlide(idx) {
    slides[current]?.classList.remove('active');
    current = (idx + slides.length) % slides.length;
    slides[current]?.classList.add('active');
    /* Sync every set of dots (each slide has its own dot row) */
    document.querySelectorAll('.hero-dots').forEach(dotsRow => {
      dotsRow.querySelectorAll('.hero-dot').forEach((d, i) => {
        d.classList.toggle('active', i === current);
      });
    });
  }

  function startAuto() {
    clearInterval(timer);
    timer = setInterval(() => goSlide(current + 1), 5500);
  }

  if (slides.length) {
    startAuto();
    /* Attach click to every dot in every set */
    document.querySelectorAll('.hero-dot').forEach((d, i) => {
      /* index within its own dotsRow */
      const dotsRow  = d.closest('.hero-dots');
      const localIdx = Array.from(dotsRow?.querySelectorAll('.hero-dot') ?? []).indexOf(d);
      d.addEventListener('click', () => { goSlide(localIdx); startAuto(); });
    });
  }

  /* ── Industry tabs ───────────────────────────────────── */
  document.querySelectorAll('.ind-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      const target = tab.dataset.tab;
      document.querySelectorAll('.ind-tab').forEach(t => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
      });
      document.querySelectorAll('.ind-panel').forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      tab.setAttribute('aria-selected', 'true');
      document.getElementById(target)?.classList.add('active');
    });
  });

  /* ── Technology tabs ─────────────────────────────────── */
  function initTechTabs() {
    const tabs  = document.querySelectorAll('.tech-tab');
    const cards = document.querySelectorAll('.tech-card');
    if (!tabs.length) return;

    function applyTab(cat) {
      tabs.forEach(t => t.classList.toggle('active', t.dataset.cat === cat));
      cards.forEach(c => {
        const show = cat === 'all' || c.dataset.cat === cat;
        c.classList.toggle('visible', show);
      });
    }
    tabs.forEach(tab => tab.addEventListener('click', () => applyTab(tab.dataset.cat)));
    /* Activate first tab (All) */
    applyTab(tabs[0]?.dataset.cat ?? 'all');
  }
  initTechTabs();

  /* ── Testimonial slider ──────────────────────────────── */
  const track   = document.querySelector('.testi-track');
  const btns    = document.querySelectorAll('.testi-btn');
  let   testiI  = 0;

  function moveTestis(dir) {
    if (!track) return;
    const cards   = track.querySelectorAll('.testi-card');
    const perView = window.innerWidth <= 768 ? 1 : 2;
    const maxI    = Math.max(0, cards.length - perView);
    testiI        = Math.min(Math.max(testiI + dir, 0), maxI);
    const w       = (cards[0]?.offsetWidth ?? 0) + 24;
    track.style.transform = `translateX(-${testiI * w}px)`;
  }
  btns[0]?.addEventListener('click', () => moveTestis(-1));
  btns[1]?.addEventListener('click', () => moveTestis(1));

  /* Auto-advance testimonials every 6s */
  let testiTimer = setInterval(() => moveTestis(1), 6000);
  document.querySelector('.testi-slider')?.addEventListener('mouseenter', () => clearInterval(testiTimer));
  document.querySelector('.testi-slider')?.addEventListener('mouseleave', () => { testiTimer = setInterval(() => moveTestis(1), 6000); });

  /* ── FAQ accordion ───────────────────────────────────── */
  document.querySelectorAll('.faq-q').forEach(q => {
    q.addEventListener('click', () => {
      const item   = q.closest('.faq-item');
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach(i => {
        i.classList.remove('open');
        i.querySelector('.faq-q')?.setAttribute('aria-expanded', 'false');
      });
      if (!isOpen) {
        item.classList.add('open');
        q.setAttribute('aria-expanded', 'true');
      }
    });
  });

  /* ── Search autocomplete ─────────────────────────────── */
  const searchInput = document.getElementById('searchInput');
  const acBox       = document.getElementById('searchAutocomplete');
  let   acIdx       = -1;

  if (searchInput && acBox) {
    searchInput.addEventListener('input', debounce(async function () {
      const q = this.value.trim();
      if (q.length < 2) { closeAC(); return; }
      try {
        const res  = await fetch(`/api/search.php?q=${encodeURIComponent(q)}&limit=7`);
        const data = await res.json();
        renderAC(data, q);
      } catch (_) { closeAC(); }
    }, 220));

    searchInput.addEventListener('keydown', e => {
      const items = acBox.querySelectorAll('.ac-item');
      if (!items.length) return;
      if (e.key === 'ArrowDown') { acIdx = Math.min(acIdx + 1, items.length - 1); hlAC(items); e.preventDefault(); }
      if (e.key === 'ArrowUp')   { acIdx = Math.max(acIdx - 1, -1); hlAC(items); e.preventDefault(); }
      if (e.key === 'Enter' && acIdx >= 0) { items[acIdx]?.click(); e.preventDefault(); }
      if (e.key === 'Escape') closeAC();
    });

    document.addEventListener('click', e => {
      if (!e.target.closest('.site-search')) closeAC();
    });
  }

  function renderAC(results, q) {
    acIdx = -1;
    if (!results.length) {
      acBox.innerHTML = `<div class="ac-empty">No results for "<b>${esc(q)}</b>"</div>`;
    } else {
      acBox.innerHTML = results.map(r =>
        `<div class="ac-item" role="option" tabindex="-1" data-href="${esc(r.url)}">
           <strong>${hlStr(r.title, q)}</strong>
           <span>${esc(r.desc)}</span>
         </div>`
      ).join('');
      acBox.querySelectorAll('.ac-item').forEach(item => {
        item.addEventListener('click', () => window.location.href = item.dataset.href);
      });
    }
    acBox.classList.add('open');
  }

  function hlAC(items) {
    items.forEach((el, i) => el.classList.toggle('highlighted', i === acIdx));
    items[acIdx]?.scrollIntoView({ block: 'nearest' });
  }

  function closeAC() {
    if (acBox) { acBox.classList.remove('open'); acBox.innerHTML = ''; }
    acIdx = -1;
  }

  /* ── Contact form AJAX ───────────────────────────────── */
  const contactForm = document.getElementById('contactForm');
  contactForm?.addEventListener('submit', async function (e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const msg = document.getElementById('formMsg');
    if (!btn || !msg) return;
    btn.disabled    = true;
    btn.textContent = 'Sending…';
    try {
      const res  = await fetch('/api/contact.php', { method: 'POST', body: new FormData(this) });
      const data = await res.json();
      msg.className   = 'form-msg ' + (data.ok ? 'success' : 'error');
      msg.textContent = data.message;
      if (data.ok) this.reset();
    } catch (_) {
      msg.className   = 'form-msg error';
      msg.textContent = 'Something went wrong. Please try again.';
    }
    btn.disabled    = false;
    btn.textContent = 'Send Message';
  });

  /* ── Animate on scroll (IntersectionObserver) ────────── */
  if ('IntersectionObserver' in window) {
    const aoStyle = document.createElement('style');
    aoStyle.textContent = `
      .ao{opacity:0;transform:translateY(22px);transition:opacity .55s ease,transform .55s ease}
      .ao.in{opacity:1!important;transform:none!important}
    `;
    document.head.appendChild(aoStyle);

    const io = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) { entry.target.classList.add('in'); io.unobserve(entry.target); }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll(
      '.service-card,.blog-card,.value-card,.count-box,.testi-card,.mv-card,.acc-row,.ind-card'
    ).forEach(el => { el.classList.add('ao'); io.observe(el); });
  }

  /* ── Number counter animation ────────────────────────── */
  const counters = document.querySelectorAll('.count-num[data-target]');
  if (counters.length && 'IntersectionObserver' in window) {
    const cio = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el     = entry.target;
        const target = parseInt(el.dataset.target, 10);
        const suffix = el.textContent.replace(/[0-9]/g,'');
        let   cur    = 0;
        const step   = Math.ceil(target / 60);
        const tick   = setInterval(() => {
          cur = Math.min(cur + step, target);
          el.textContent = cur + '+';
          if (cur >= target) clearInterval(tick);
        }, 28);
        cio.unobserve(el);
      });
    }, { threshold: 0.5 });
    counters.forEach(c => cio.observe(c));
  }

  /* ── Helpers ─────────────────────────────────────────── */
  function debounce(fn, ms) {
    let t;
    return function (...a) { clearTimeout(t); t = setTimeout(() => fn.apply(this, a), ms); };
  }

  function esc(str) {
    return String(str).replace(/[&<>"']/g, c => (
      { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[c]
    ));
  }

  function hlStr(str, q) {
    const re = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`, 'gi');
    return esc(str).replace(re, '<mark style="background:rgba(39,99,255,.12);color:var(--blue);border-radius:2px">$1</mark>');
  }

})();
