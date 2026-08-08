/**
 * Fortline Global - Auto-Matching Language System
 * Translates page content by matching English text to translation keys.
 * No data-i18n attributes needed — works by walking the DOM.
 *
 * Usage:
 * 1. Include page translation file: <script src="translations/home.js"></script>
 * 2. Include shared translations: <script src="translations/shared.js"></script>
 * 3. Include this file: <script src="lang-system.js"></script>
 * 4. Add <div id="lang-toggle"></div> in your nav
 * 5. Google Fonts for Arabic/Hebrew loaded via CSS
 */

(function () {
  'use strict';

  const CONFIG = {
    DEFAULT_LANG: 'en',
    COOKIE_NAME: 'fortline_lang',
    COOKIE_DAYS: 30,
    SUPPORTED: ['en', 'he'],
    RTL_LANGS: ['he'],
    MIN_TEXT_LENGTH: 2
  };

  const LANG_META = {
    en: { label: 'EN', native: 'English', flag: '🇬🇧' },
    he: { label: 'עב', native: 'עברית', flag: '🇮🇱' },
    ar: { label: 'عر', native: 'العربية', flag: '🇦🇪' }
  };

  // Storage for original English content
  let originalTextMap = new Map();  // element → original text
  let originalHTMLMap = new Map();  // element → original innerHTML (for complex elements)
  let originalPlaceholders = new Map();
  let originalAlts = new Map();
  let reverseLookup = {};  // normalized English text → key
  let mergedTranslations = {};  // { he: {...}, ar: {...} }
  let currentLang = CONFIG.DEFAULT_LANG;
  let initialized = false;

  // ─── Cookie helpers ───
  function getCookie() {
    const c = document.cookie.split(';').find(c => c.trim().startsWith(CONFIG.COOKIE_NAME + '='));
    if (c) { const v = c.split('=')[1]; if (CONFIG.SUPPORTED.includes(v)) return v; }
    return CONFIG.DEFAULT_LANG;
  }
  function setCookie(lang) {
    const d = new Date(); d.setTime(d.getTime() + CONFIG.COOKIE_DAYS * 864e5);
    document.cookie = `${CONFIG.COOKIE_NAME}=${lang};expires=${d.toUTCString()};path=/;SameSite=Lax`;
  }

  // ─── Normalize text for matching ───
  function normalize(text) {
    if (!text) return '';
    return text.replace(/\s+/g, ' ').trim().toLowerCase()
      .replace(/[→\u2192\u2190→←]/g, '')  // arrows
      .replace(/[*\u00a0]/g, ' ')  // nbsp, asterisks
      .replace(/\s+/g, ' ').trim();
  }

  // ─── Flatten nested objects into dot-notation keys ───
  function flattenObj(obj, prefix) {
    var result = {};
    for (var k in obj) {
      if (!obj.hasOwnProperty(k)) continue;
      var newKey = prefix != null ? prefix + '.' + k : k;
      if (typeof obj[k] === 'object' && obj[k] !== null && !Array.isArray(obj[k])) {
        var nested = flattenObj(obj[k], newKey);
        for (var nk in nested) result[nk] = nested[nk];
      } else {
        result[newKey] = obj[k];
      }
    }
    return result;
  }

  // ─── Merge all translation sources ───
  function mergeTranslations() {
    const sources = [];
    // Collect all window.*_TRANSLATIONS objects
    for (const key of Object.keys(window)) {
      if (key.endsWith('_TRANSLATIONS') && typeof window[key] === 'object') {
        sources.push(window[key]);
      }
    }
    // Also check SHARED_TRANSLATIONS specifically
    if (window.SHARED_TRANSLATIONS) sources.push(window.SHARED_TRANSLATIONS);

    mergedTranslations = { he: {}, ar: {} };
    window.ENGLISH_MAP = window.ENGLISH_MAP || {};
    for (const src of sources) {
      if (src.he) Object.assign(mergedTranslations.he, flattenObj(src.he, null));
      if (src.ar) Object.assign(mergedTranslations.ar, flattenObj(src.ar, null));
      if (src.en) Object.assign(window.ENGLISH_MAP, flattenObj(src.en, null));
    }
  }

  // ─── Build reverse lookup from translation keys to English text ───
  // Since translation files have key→hebrew/arabic, we need to know
  // what English text each key maps to. We build this from the DOM.
  function buildEnglishMap() {
    reverseLookup = {};

    // Walk all text-containing elements
    const elements = document.querySelectorAll(
      'h1, h2, h3, h4, h5, h6, p, a, span, li, button, label, option, ' +
      'div.hero-stat-num, div.hero-stat-label, div.section-label, div.section-title, ' +
      'div.section-subtitle, div.svc-badge, div.pillar-tag, div.cert-pill, ' +
      'strong, em, sup, td, th, figcaption, blockquote, dt, dd'
    );

    // For each translated key, try to find matching DOM element
    // We do this by comparing normalized element text to what we can infer
    // The translations object keys give us semantic info but not English text directly
    // So we store element → text for later replacement
    elements.forEach(el => {
      // Skip elements with children that also match (avoid duplicating parent + child)
      const text = getDirectText(el);
      if (text && text.length >= CONFIG.MIN_TEXT_LENGTH) {
        originalTextMap.set(el, text);
      }
    });

    // Store placeholders
    document.querySelectorAll('input[placeholder], textarea[placeholder]').forEach(el => {
      originalPlaceholders.set(el, el.getAttribute('placeholder'));
    });

    // Store alt text
    document.querySelectorAll('img[alt]').forEach(el => {
      if (el.alt.length >= CONFIG.MIN_TEXT_LENGTH) {
        originalAlts.set(el, el.alt);
      }
    });
  }

  // Get only the direct text of an element (not children's text)
  function getDirectText(el) {
    // For simple elements (no children or only inline children), use textContent
    if (el.children.length === 0) {
      return el.textContent.trim();
    }
    // For elements with children, get direct text nodes
    let text = '';
    for (const node of el.childNodes) {
      if (node.nodeType === 3) { // text node
        text += node.textContent;
      }
    }
    text = text.trim();
    // If direct text is too short, fall back to full textContent for matching
    if (text.length < CONFIG.MIN_TEXT_LENGTH) {
      return el.textContent.trim();
    }
    return text;
  }

  // ─── Find best translation match for English text ───
  function findTranslation(englishText, lang) {
    if (!mergedTranslations[lang]) return null;
    const translations = mergedTranslations[lang];
    const normalizedEn = normalize(englishText);

    // Build a mapping of English text variants → keys if not done
    if (!reverseLookup._built) {
      // For each key in he translations, we know the key name
      // Try to infer English from key name or from the original text
      reverseLookup._built = true;
    }

    // Strategy: try exact match on key values with the English text
    // We check if any key's English original matches our text
    // Since we don't have en translations, we match by key name heuristics
    // and store results the first time

    // Direct lookup by common patterns
    for (const key of Object.keys(translations)) {
      // Skip if already used
      if (!reverseLookup[key]) {
        reverseLookup[key] = true; // mark as processed
      }
    }

    return null; // Fallback - auto-match didn't find it
  }

  // ─── Apply translations using text-content matching ───
  function applyLanguage(lang) {
    if (lang === 'en') {
      // Restore original English
      originalTextMap.forEach((text, el) => {
        if (el.isConnected) el.textContent = text;
      });
      originalPlaceholders.forEach((ph, el) => {
        if (el.isConnected) el.setAttribute('placeholder', ph);
      });
      originalAlts.forEach((alt, el) => {
        if (el.isConnected) el.alt = alt;
      });
      return;
    }

    const translations = mergedTranslations[lang];
    if (!translations) return;

    // Build a lookup: normalized English → { key, translation }
    // We need to match DOM text to translation keys.
    // Strategy: create a map from English text → translated text
    // using the ENGLISH_MAP if available, otherwise use data-i18n fallback

    if (window.ENGLISH_MAP) {
      // ENGLISH_MAP: { 'translation_key': 'Original English text' }
      const englishToKey = {};
      for (const [key, enText] of Object.entries(window.ENGLISH_MAP)) {
        englishToKey[normalize(enText)] = key;
      }

      // Replace text in all stored elements
      originalTextMap.forEach((originalText, el) => {
        if (!el.isConnected) return;
        const norm = normalize(originalText);
        const key = englishToKey[norm];
        if (key && translations[key]) {
          el.textContent = translations[key];
        }
      });

      // Replace placeholders
      originalPlaceholders.forEach((originalPh, el) => {
        if (!el.isConnected) return;
        const norm = normalize(originalPh);
        const key = englishToKey[norm];
        if (key && translations[key]) {
          el.setAttribute('placeholder', translations[key]);
        }
      });

      // Replace alt text
      originalAlts.forEach((originalAlt, el) => {
        if (!el.isConnected) return;
        const norm = normalize(originalAlt);
        const key = englishToKey[norm];
        if (key && translations[key]) {
          el.alt = translations[key];
        }
      });
    }

    // Also process data-i18n elements (if any exist)
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      if (translations[key]) el.textContent = translations[key];
    });
  }

  // ─── Direction and styling ───
  function setDirection(lang) {
    const html = document.documentElement;
    const body = document.body;
    html.setAttribute('dir', CONFIG.RTL_LANGS.includes(lang) ? 'rtl' : 'ltr');
    html.setAttribute('lang', lang);
    body.classList.remove('lang-en', 'lang-he', 'lang-ar');
    body.classList.add('lang-' + lang);
  }

  // ─── Language dropdown ───
  function createDropdown() {
    const container = document.getElementById('lang-toggle');
    if (!container) return;

    container.innerHTML = '';
    container.style.cssText = 'position:relative;display:inline-block;margin-left:0.8rem;z-index:1000;';

    const btn = document.createElement('button');
    btn.className = 'lang-btn';
    btn.style.cssText = `
      background:transparent;border:1px solid rgba(255,255,255,0.2);
      color:inherit;padding:0.35rem 0.7rem;border-radius:6px;
      cursor:pointer;font-size:0.82rem;font-weight:500;
      display:flex;align-items:center;gap:0.35rem;
      transition:all 0.2s;white-space:nowrap;
    `;
    const meta = LANG_META[currentLang];
    btn.innerHTML = `${meta.flag} ${meta.label} <span style="font-size:0.6rem;opacity:0.7">▾</span>`;

    const menu = document.createElement('div');
    menu.className = 'lang-menu';
    menu.style.cssText = `
      display:none;position:absolute;top:calc(100% + 4px);right:0;
      background:#1a1a2e;border:1px solid rgba(255,255,255,0.12);
      border-radius:8px;overflow:hidden;min-width:140px;
      box-shadow:0 8px 32px rgba(0,0,0,0.3);
    `;

    CONFIG.SUPPORTED.forEach(lang => {
      const m = LANG_META[lang];
      const item = document.createElement('button');
      item.style.cssText = `
        display:flex;align-items:center;gap:0.5rem;width:100%;
        padding:0.6rem 1rem;background:${lang === currentLang ? 'rgba(255,255,255,0.08)' : 'transparent'};
        border:none;color:#fff;cursor:pointer;font-size:0.85rem;
        text-align:left;transition:background 0.15s;
      `;
      item.innerHTML = `${m.flag} <span>${m.native}</span>${lang === currentLang ? ' <span style="margin-left:auto;opacity:0.5">✓</span>' : ''}`;
      item.addEventListener('mouseenter', () => item.style.background = 'rgba(255,255,255,0.1)');
      item.addEventListener('mouseleave', () => item.style.background = lang === currentLang ? 'rgba(255,255,255,0.08)' : 'transparent');
      item.addEventListener('click', (e) => {
        e.stopPropagation();
        menu.style.display = 'none';
        window.switchLanguage(lang);
      });
      menu.appendChild(item);
    });

    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    });

    document.addEventListener('click', () => menu.style.display = 'none');

    container.appendChild(btn);
    container.appendChild(menu);
  }

  // ─── Public API ───
  window.switchLanguage = function (lang) {
    if (!CONFIG.SUPPORTED.includes(lang)) return;
    currentLang = lang;
    applyLanguage(lang);
    setDirection(lang);
    setCookie(lang);
    createDropdown(); // refresh display
  };

  // ─── Initialize ───
  function init() {
    if (initialized) return;
    initialized = true;

    mergeTranslations();
    buildEnglishMap();
    createDropdown();

    // Check for saved language
    const saved = getCookie();
    if (saved !== 'en') {
      currentLang = saved;
      setDirection(saved);
      applyLanguage(saved);
      createDropdown();
    }
  }

  // Run on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
