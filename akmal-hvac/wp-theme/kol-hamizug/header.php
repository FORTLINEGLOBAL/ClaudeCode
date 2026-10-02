<?php
/**
 * פתיחת המסמך והניווט.
 *
 * dir ו-lang כתובים במפורש ולא דרך language_attributes(), כדי שהאתר יישאר
 * RTL בעברית גם על התקנת וורדפרס שהוגדרה לשפה אחרת.
 *
 * @package kol-hamizug
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>כל המיזוג | תכנון וביצוע מיזוג מתקדם</title>
<meta name="description" content="תכנון וביצוע מערכות מיזוג אוויר ברמה הגבוהה בשוק. VRF, מיני מרכזי, מזגנים עיליים ותכנון מיזוג לווילות. עבודה נקייה, חומרים מקוריים, בלי קיצורי דרך.">
<meta name="theme-color" content="#0b1220">
<meta property="og:title" content="כל המיזוג | תכנון וביצוע מיזוג מתקדם">
<meta property="og:description" content="התקנה טובה לא נמדדת ביום שאחרי — אלא בחודשים ובשנים שאחריה.">
<meta property="og:type" content="website">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ============================ ניווט ============================ -->
<header class="nav" id="nav">
  <div class="nav__inner">
    <a class="brand" href="#top">
      <span class="brand__mark" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9.5 5.5a2.5 2.5 0 1 1 2.5 2.5H2"/><path d="M14 17.5a2.5 2.5 0 1 0 2.5-2.5H2"/><path d="M17 4.5a3 3 0 1 1 3 3H2"/>
        </svg>
      </span>
      <span class="brand__name">כל המיזוג<span class="brand__tag">תכנון וביצוע מיזוג מתקדם</span></span>
    </a>

    <button class="nav__burger" id="burger" aria-label="תפריט" aria-expanded="false" aria-controls="navLinks"><span></span></button>

    <nav class="nav__links" id="navLinks" aria-label="ניווט ראשי">
      <a href="#about">על אקמל</a>
      <a href="#value">למה אנחנו</a>
      <a href="#works">מבחר עבודות</a>
      <a href="#principles">עקרונות עבודה</a>
      <a href="#faq">שאלות נפוצות</a>
      <a href="#contact">צור קשר</a>
    </nav>

    <a class="btn btn--ghost btn--sm nav__cta" href="#contact">לשיחת ייעוץ</a>
  </div>
</header>
