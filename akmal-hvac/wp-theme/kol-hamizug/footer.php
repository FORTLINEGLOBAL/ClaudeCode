<?php
/**
 * פוטר, לייטבוקס וסגירת המסמך.
 *
 * @package kol-hamizug
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="footer">
  <div class="wrap footer__inner">
    <p><strong>כל המיזוג — תכנון וביצוע מיזוג מתקדם</strong><br>אקמל — תכנון, התקנה, גבס וגמרים של מערכות מיזוג אוויר.</p>
    <nav aria-label="ניווט תחתון">
      <a href="#about">על אקמל</a>
      <a href="#value">למה אנחנו</a>
      <a href="#works">עבודות</a>
      <a href="#principles">עקרונות</a>
      <a href="#faq">שאלות נפוצות</a>
      <a href="#contact">צור קשר</a>
    </nav>
  </div>
</footer>

<!-- ============================ לייטבוקס ============================ -->
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-labelledby="lbTitle">
  <button class="lightbox__close" id="lbClose" aria-label="סגירה">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
  </button>
  <div class="lightbox__panel">
    <div class="lightbox__media" id="lbMedia"></div>
    <div class="lightbox__body">
      <h3 id="lbTitle"></h3>
      <p id="lbText"></p>
    </div>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
