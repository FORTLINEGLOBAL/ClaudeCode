/**
 * A.R.I. Faberman — EN/HE language engine.
 * English is the source in the markup; Hebrew comes from window.ARI_I18N.
 * Translatable elements carry one of:
 *   data-i18n       -> textContent
 *   data-i18n-html  -> innerHTML (for strings with <br>/<span>)
 *   data-i18n-ph    -> placeholder
 *   data-i18n-alt   -> alt
 *   data-i18n-aria  -> aria-label
 * Switching to EN restores the original markup; switching to HE applies the dictionary
 * and flips <html dir/lang>. Choice is remembered in a cookie.
 */
(function () {
  'use strict';
  var DICT = window.ARI_I18N || {};
  var SUPPORTED = ['en', 'he'], RTL = ['he'], DEFAULT = 'en', COOKIE = 'ari_lang';
  var current = DEFAULT, captured = false;

  var orig = { text: [], html: [], ph: [], alt: [], aria: [] };

  function getCookie() {
    var m = document.cookie.match(/(?:^|;)\s*ari_lang=(en|he)/);
    return m ? m[1] : DEFAULT;
  }
  function setCookie(l) {
    var d = new Date(); d.setTime(d.getTime() + 30 * 864e5);
    document.cookie = COOKIE + '=' + l + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
  }

  // Snapshot the original English once, so EN is always a faithful restore.
  function capture() {
    if (captured) return; captured = true;
    document.querySelectorAll('[data-i18n]').forEach(function (el) { orig.text.push([el, el.getAttribute('data-i18n'), el.textContent]); });
    document.querySelectorAll('[data-i18n-html]').forEach(function (el) { orig.html.push([el, el.getAttribute('data-i18n-html'), el.innerHTML]); });
    document.querySelectorAll('[data-i18n-ph]').forEach(function (el) { orig.ph.push([el, el.getAttribute('data-i18n-ph'), el.getAttribute('placeholder')]); });
    document.querySelectorAll('[data-i18n-alt]').forEach(function (el) { orig.alt.push([el, el.getAttribute('data-i18n-alt'), el.getAttribute('alt')]); });
    document.querySelectorAll('[data-i18n-aria]').forEach(function (el) { orig.aria.push([el, el.getAttribute('data-i18n-aria'), el.getAttribute('aria-label')]); });
  }

  function apply(lang) {
    var he = (lang === 'he');
    orig.text.forEach(function (r) { var t = he ? DICT[r[1]] : r[2]; if (t != null) r[0].textContent = t; });
    orig.html.forEach(function (r) { var t = he ? DICT[r[1]] : r[2]; if (t != null) r[0].innerHTML = t; });
    orig.ph.forEach(function (r) { var t = he ? DICT[r[1]] : r[2]; if (t != null) r[0].setAttribute('placeholder', t); });
    orig.alt.forEach(function (r) { var t = he ? DICT[r[1]] : r[2]; if (t != null) r[0].setAttribute('alt', t); });
    orig.aria.forEach(function (r) { var t = he ? DICT[r[1]] : r[2]; if (t != null) r[0].setAttribute('aria-label', t); });
  }

  function setDir(lang) {
    var html = document.documentElement;
    html.setAttribute('lang', lang);
    html.setAttribute('dir', RTL.indexOf(lang) >= 0 ? 'rtl' : 'ltr');
    document.body.classList.toggle('lang-he', lang === 'he');
    document.body.classList.toggle('lang-en', lang === 'en');
  }

  function renderToggle() {
    var conts = document.querySelectorAll('#lang-toggle, .js-lang-toggle');
    var other = current === 'en' ? 'he' : 'en';
    conts.forEach(function (c) {
      c.innerHTML = '';
      var b = document.createElement('button');
      b.type = 'button'; b.className = 'lang-btn';
      // Show the language you can switch TO, in its own script.
      b.textContent = current === 'en' ? 'עברית' : 'English';
      b.setAttribute('aria-label', current === 'en' ? 'עבור לעברית' : 'Switch to English');
      b.setAttribute('lang', other);
      b.addEventListener('click', function () { window.switchLanguage(other); });
      c.appendChild(b);
    });
  }

  window.switchLanguage = function (lang) {
    if (SUPPORTED.indexOf(lang) < 0) return;
    current = lang; apply(lang); setDir(lang); setCookie(lang); renderToggle();
  };

  // The applied language is the source of truth for direction. If anything else
  // on the page (e.g. a translation plugin) flips the document out of sync,
  // restore it to match `current` so we never end up English-in-RTL.
  function wantDir() { return RTL.indexOf(current) >= 0 ? 'rtl' : 'ltr'; }
  function enforceConsistency() {
    var html = document.documentElement, w = wantDir();
    if (html.getAttribute('dir') !== w) html.setAttribute('dir', w);
    if (html.getAttribute('lang') !== current) html.setAttribute('lang', current);
    // Some plugins set direction on <body> instead of <html>; keep it in sync too.
    if (document.body) {
      var bd = document.body.getAttribute('dir');
      if (bd && bd !== w) document.body.setAttribute('dir', w);
    }
  }

  function init() {
    capture();
    var saved = getCookie();
    current = saved; apply(saved); setDir(saved); renderToggle();
    enforceConsistency();
    // Re-assert across the load lifecycle to beat late plugin scripts, plus bfcache.
    [50, 200, 500, 1200].forEach(function (t) { setTimeout(enforceConsistency, t); });
    window.addEventListener('load', enforceConsistency);
    window.addEventListener('pageshow', enforceConsistency);
    // Guard against an external script flipping direction post-load.
    // (Only re-asserts on a genuine mismatch, so it settles in one pass — no loop.)
    try {
      var mo = new MutationObserver(function () {
        var html = document.documentElement, w = wantDir();
        if (html.getAttribute('dir') !== w || html.getAttribute('lang') !== current ||
            (document.body && document.body.getAttribute('dir') && document.body.getAttribute('dir') !== w)) {
          enforceConsistency();
        }
      });
      mo.observe(document.documentElement, { attributes: true, attributeFilter: ['dir', 'lang'] });
      if (document.body) mo.observe(document.body, { attributes: true, attributeFilter: ['dir'] });
    } catch (e) {}
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
