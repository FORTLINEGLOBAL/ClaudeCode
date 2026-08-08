<?php
/**
 * Template Name: Unique Technology
 * Description: Unique Technology page
 */

get_header(); ?>

<style>

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
--bg:#ffffff;
--bg-light:#f7f8fa;
--bg-section:#f0f2f5;
--bg-dark:#0a1628;
--bg-card:#ffffff;
--gold:#1e3a5f;
--gold-light:#2563eb;
--gold-bright:#3b82f6;
--gold-dim:rgba(37,99,235,0.06);
--gold-border:rgba(37,99,235,0.18);
--red:#dc2626;
--red-dim:rgba(220,38,38,0.08);
--green:#16a34a;
--green-dim:rgba(22,163,74,0.08);
--blue-dark:#0f1d32;
--text-dark:#111827;
--text-mid:#374151;
--text-light:#6b7280;
--text-white:#ffffff;
--border:#e5e7eb;
--border-light:#f3f4f6;
--shadow:0 1px 3px rgba(0,0,0,0.06),0 1px 2px rgba(0,0,0,0.04);
--shadow-md:0 4px 12px rgba(0,0,0,0.08);
--shadow-lg:0 10px 40px rgba(0,0,0,0.1);
--font-heading:'Space Grotesk',sans-serif;
--font-body:'Inter',sans-serif;
}
html{scroll-behavior:smooth;overflow-x:hidden}
body{font-family:var(--font-body);background:var(--bg);color:var(--text-dark);line-height:1.6;overflow-x:hidden}
img{max-width:100%;height:auto;display:block}
a{color:var(--gold);text-decoration:none}

/* ===== NAV ===== */
.nav{
position:fixed;top:0;left:0;right:0;z-index:1000;
padding:0.9rem 2rem;
transition:all 0.4s;
background:transparent;
}
.nav.scrolled{
background:rgba(255,255,255,0.97);
backdrop-filter:blur(20px);
border-bottom:1px solid var(--border);
box-shadow:var(--shadow);
}
.nav.scrolled .nav-logo-text,.nav.scrolled .nav-links a{color:var(--text-dark)}
.nav.scrolled .nav-logo-text span{color:var(--gold-bright)}
.nav.scrolled .nav-links a:hover{color:var(--gold)}
.nav-inner{max-width:1320px;margin:0 auto;display:flex;align-items:center;justify-content:space-between}
.nav-logo{display:flex;align-items:center;gap:0.6rem}
.nav-logo svg{width:40px;height:38px;color:#fff}.nav.scrolled .nav-logo svg{color:var(--bg-dark)}
.nav-logo-text{font-family:var(--font-heading);font-size:1.25rem;font-weight:700;color:#fff;transition:color 0.4s}
.nav-logo-text span{color:var(--gold-bright)}
.nav-links{display:flex;gap:1.2rem;align-items:center}
.nav-links a{font-size:0.78rem;color:rgba(255,255,255,0.85);font-weight:500;transition:all 0.3s;letter-spacing:0.01em;white-space:nowrap}
.nav-links a:hover{color:#fff}
.nav-cta{
background:var(--gold-light) !important;color:#fff !important;
padding:0.5rem 1.3rem;border-radius:6px;
font-weight:600 !important;transition:all 0.3s;
}
.nav-cta:hover{background:var(--gold-bright) !important;transform:translateY(-1px)}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:4px}
.hamburger span{width:24px;height:2px;background:#fff;transition:0.3s}
.nav.scrolled .hamburger span{background:var(--text-dark)}
.mobile-menu{
display:none;position:fixed;top:0;left:0;right:0;bottom:0;
background:rgba(255,255,255,0.98);z-index:1001;
flex-direction:column;align-items:center;justify-content:center;gap:2rem;
}
.mobile-menu.open{display:flex}
.mobile-menu a{font-size:1.2rem;color:var(--text-dark);font-weight:500}
.mobile-close{position:absolute;top:1.5rem;right:1.5rem;font-size:1.8rem;color:var(--text-dark);cursor:pointer}

/* ===== HERO -Rafael Iron Dome Style ===== */
.hero{
position:relative;
min-height:100vh;
display:flex;flex-direction:column;
justify-content:center;align-items:center;
overflow:hidden;
background:#1a2a4a;
}
.hero-video-wrap{
position:absolute;inset:0;
overflow:hidden;
}
.hero-video-wrap video{
width:100%;height:100%;object-fit:cover;
}
.hero-video-wrap::after{
content:'';position:absolute;inset:0;
background:linear-gradient(180deg,
rgba(5,12,30,0.72) 0%,
rgba(5,12,30,0.65) 30%,
rgba(5,12,30,0.68) 60%,
rgba(2,6,18,0.82) 100%
);
}

/* Breadcrumb trail */
.hero-breadcrumb{
position:absolute;top:5.5rem;left:2.5rem;z-index:3;
font-size:0.82rem;color:rgba(255,255,255,0.7);
}
.hero-breadcrumb a{color:rgba(255,255,255,0.7);transition:color 0.3s}
.hero-breadcrumb a:hover{color:#fff}
.hero-breadcrumb span{margin:0 0.4rem;opacity:0.5}

/* Hero content -two-column */
.hero-content{
position:relative;z-index:2;
width:100%;
max-width:1320px;
padding:0 2rem;
padding-bottom:10rem;
margin-top:2rem;
display:flex;
align-items:center;
gap:3.5rem;
}
.hero-left{
display:flex;flex-direction:column;gap:0.7rem;
flex-shrink:0;
}
.hero-right{
text-align:left;
flex:1;
}
.hero h1{
font-family:var(--font-heading);
font-size:7rem;font-weight:300;line-height:1.05;
color:#fff;
margin-bottom:0.6rem;
letter-spacing:-0.02em;
}
.hero h1 .red-dot{
color:#e53e3e;
font-weight:400;
}
.hero-sub{
font-size:1.2rem;color:rgba(255,255,255,0.85);line-height:1.6;
max-width:700px;margin:0;font-weight:400;
letter-spacing:0.02em;
}

/* Buttons */
.hero-btns{
display:flex;gap:1rem;flex-wrap:wrap;
justify-content:flex-start;
margin-top:2.5rem;
}
.btn-gold{
background:var(--gold-light);color:#fff;
padding:0.85rem 2rem;border-radius:8px;
font-weight:700;font-size:0.95rem;border:none;cursor:pointer;
transition:all 0.3s;display:inline-block;letter-spacing:0.02em;
}
.btn-gold:hover{background:var(--gold-bright);transform:translateY(-2px);box-shadow:0 8px 30px rgba(37,99,235,0.35)}
.btn-white{
border:2px solid rgba(255,255,255,0.5);color:#fff;
padding:0.85rem 2rem;border-radius:8px;
font-weight:600;font-size:0.95rem;background:transparent;cursor:pointer;
transition:all 0.3s;display:inline-block;
}
.btn-white:hover{border-color:#fff;background:rgba(255,255,255,0.1)}

/* Stats bar */
.hero-stats{
position:absolute;bottom:0;left:0;right:0;z-index:3;
display:flex;
background:rgba(0,0,0,0.15);
backdrop-filter:blur(8px);
border-top:1px solid rgba(255,255,255,0.12);
}
.hero-stat{
flex:1;
padding:2rem 2.5rem;
text-align:left;
border-right:1px solid rgba(255,255,255,0.1);
}
.hero-stat:last-child{border-right:none}
.hero-stat-num{
font-family:var(--font-heading);font-size:3rem;font-weight:300;
color:#fff;
letter-spacing:-0.01em;
}
.hero-stat-label{font-size:0.88rem;color:rgba(255,255,255,0.7);margin-top:0.3rem;line-height:1.35;font-weight:400}

/* Defense badges */
.defense-badges{
display:flex;flex-direction:column;gap:0.7rem;
margin-top:0;
}
.defense-badge{
display:inline-flex;align-items:center;gap:0.4rem;
background:rgba(255,255,255,0.08);
backdrop-filter:blur(12px);
border:1px solid rgba(255,255,255,0.15);
padding:0.35rem 0.9rem;border-radius:4px;
}
.defense-badge-text{
font-size:0.7rem;font-weight:700;color:rgba(255,255,255,0.9);
letter-spacing:0.08em;text-transform:uppercase;
}
.defense-badge.gold-badge{
background:rgba(37,99,235,0.12);
border-color:rgba(37,99,235,0.3);
}
.defense-badge.gold-badge .defense-badge-text{color:var(--gold-bright)}

/* ===== COMMON ===== */
section{position:relative;overflow:hidden}
.container{max-width:1320px;margin:0 auto;padding:0 2rem}
.section-label{
font-size:0.8rem;font-weight:700;color:var(--gold);
letter-spacing:0.18em;text-transform:uppercase;
margin-bottom:0.6rem;
}
.section-title{
font-family:var(--font-heading);font-size:2.8rem;font-weight:700;
line-height:1.15;color:var(--text-dark);margin-bottom:0.8rem;
}
.section-subtitle{font-size:1.05rem;color:var(--text-light);line-height:1.7;max-width:620px}

.fade-in{opacity:1;transform:translateY(0);transition:opacity 0.7s ease,transform 0.7s ease}
.fade-in.visible{opacity:1;transform:translateY(0)}
.fade-in-delay-1{transition-delay:0.12s}
.fade-in-delay-2{transition-delay:0.24s}
.fade-in-delay-3{transition-delay:0.36s}

/* ===== SHIELD DEEP DIVE ===== */
.shield{padding:5rem 0;background:var(--bg-light)}
.shield-top{
display:grid;grid-template-columns:1fr 1fr;gap:3rem;
margin-bottom:3rem;
}
.shield-badge{
display:inline-flex;align-items:center;gap:0.5rem;
background:var(--gold-dim);border:1px solid var(--gold-border);
padding:0.35rem 0.9rem;border-radius:4px;
margin-bottom:1rem;
}
.shield-badge-text{font-size:0.78rem;font-weight:700;color:var(--gold);letter-spacing:0.1em;text-transform:uppercase}
.shield h2{
font-family:var(--font-heading);font-size:2.2rem;font-weight:700;
line-height:1.2;margin-bottom:1rem;color:var(--text-dark);
}
.shield-text{font-size:0.95rem;color:var(--text-mid);line-height:1.7;margin-bottom:1.5rem}
.shield-features{display:grid;grid-template-columns:1fr 1fr;gap:0.8rem}
.shield-feat{
background:var(--bg-card);border:1px solid var(--border);
border-radius:10px;padding:1.1rem;
transition:all 0.3s;
}
.shield-feat:hover{border-color:var(--gold-border);box-shadow:var(--shadow)}
.shield-feat h4{font-size:0.95rem;font-weight:600;margin-bottom:0.25rem;color:var(--text-dark)}
.shield-feat p{font-size:0.85rem;color:var(--text-light);line-height:1.55}

.shield-video{
border-radius:14px;overflow:hidden;
border:1px solid var(--border);
box-shadow:var(--shadow-lg);
}
.shield-video iframe{width:100%;aspect-ratio:16/9;border:none;display:block}

/* Certs row */
.shield-certs{
display:flex;flex-wrap:wrap;gap:0.8rem;margin-top:1.5rem;
}
.cert-pill{
display:flex;align-items:center;gap:0.4rem;
background:var(--green-dim);border:1px solid rgba(22,163,74,0.2);
padding:0.35rem 0.9rem;border-radius:20px;
font-size:0.8rem;color:var(--green);font-weight:600;
}
.cert-pill .dot{width:6px;height:6px;background:var(--green);border-radius:50%}

/* Before/After */
.ba-row{
display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;
margin-bottom:2rem;
}
.ba-item{
border-radius:14px;overflow:hidden;position:relative;
height:240px;border:1px solid var(--border);
}
.ba-item img{width:100%;height:100%;object-fit:cover}
.ba-tag{
position:absolute;top:1rem;left:1rem;
background:rgba(255,255,255,0.9);backdrop-filter:blur(8px);
padding:0.3rem 0.8rem;border-radius:6px;
font-size:0.72rem;font-weight:700;color:var(--text-dark);letter-spacing:0.05em;
}
.ba-tag.after{background:var(--gold-light);color:#fff}

/* Video Gallery */
.vid-gallery{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem}
.vid-card{
background:var(--bg-card);border:1px solid var(--border);
border-radius:12px;overflow:hidden;
transition:all 0.3s;box-shadow:var(--shadow);
}
.vid-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-3px)}
.vid-card iframe{width:100%;aspect-ratio:16/9;border:none;display:block}
.vid-card-info{padding:0.9rem}
.vid-card-info h4{font-size:0.85rem;font-weight:600;color:var(--text-dark);margin-bottom:0.15rem}
.vid-card-info p{font-size:0.75rem;color:var(--text-light)}

/* ===== CONTACT ===== */
.contact{padding:5rem 0;background:var(--bg)}
.contact-grid{display:grid;grid-template-columns:1.2fr 0.8fr;gap:3rem}
.contact-form-box{
background:var(--bg-card);border:1px solid var(--border);
border-radius:16px;padding:2.5rem;
box-shadow:var(--shadow-lg);
}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:0.8rem}
.form-group{margin-bottom:0.8rem}
.form-group label{display:block;font-size:0.76rem;color:var(--text-light);font-weight:500;margin-bottom:0.3rem}
.form-group input,.form-group select,.form-group textarea{
width:100%;background:var(--bg-light);
border:1px solid var(--border);border-radius:8px;
padding:0.7rem 1rem;color:var(--text-dark);
font-family:var(--font-body);font-size:0.88rem;
transition:border-color 0.3s;
}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:var(--gold-light)}
.form-group textarea{resize:vertical;min-height:90px}
.form-group select{appearance:none;cursor:pointer}
.form-submit{
width:100%;background:var(--gold-light);color:#fff;
border:none;padding:0.8rem;border-radius:8px;
font-weight:700;font-size:0.95rem;cursor:pointer;
transition:all 0.3s;font-family:var(--font-body);
}
.form-submit:hover{background:var(--gold-bright);transform:translateY(-1px)}

.contact-info{display:flex;flex-direction:column;gap:1rem}
.info-card{
background:var(--bg-card);border:1px solid var(--border);
border-radius:12px;padding:1.2rem 1.4rem;
display:flex;align-items:flex-start;gap:0.8rem;
transition:all 0.3s;box-shadow:var(--shadow);
}
.info-card:hover{border-color:var(--gold-border)}
.info-card h4{font-size:0.95rem;font-weight:600;color:var(--text-dark);margin-bottom:0.2rem}
.info-card p{font-size:0.88rem;color:var(--text-light);line-height:1.5}

/* ===== FOOTER ===== */
footer{background:#0a1628;padding:4rem 2rem 2rem;color:#fff}
.footer-inner{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:3rem}
.footer-brand{display:flex;flex-direction:column;gap:1rem}
.footer-logo{display:flex;align-items:center;gap:0.6rem}
.footer-logo svg{width:32px;height:32px}
.footer-logo-text{font-family:var(--font-heading);font-size:1.2rem;font-weight:700}
.footer-logo-text span{color:var(--gold-bright)}
.footer-tagline{font-size:0.85rem;color:rgba(255,255,255,0.5);line-height:1.6;max-width:280px}
.footer-col h4{font-family:var(--font-heading);font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--gold-bright);margin-bottom:1.2rem}
.footer-col a{display:block;font-size:0.88rem;color:rgba(255,255,255,0.65);padding:0.35rem 0;transition:all 0.3s}
.footer-col a:hover{color:#fff;padding-left:4px}
.footer-bar{border-top:1px solid rgba(255,255,255,0.08);margin-top:3rem;padding-top:1.5rem;max-width:1200px;margin-left:auto;margin-right:auto}
.footer-bar p{font-size:0.75rem;color:rgba(255,255,255,0.35);text-align:center}

/* ===== RESPONSIVE ===== */
@media(max-width:1024px){
.hero h1{font-size:5rem}
.hero-stat{padding:1.5rem 1.5rem}
.hero-stat-num{font-size:2.4rem}
.shield-top{grid-template-columns:1fr}
.vid-gallery{grid-template-columns:1fr}
.contact-grid{grid-template-columns:1fr}
.hero-stats{flex-wrap:wrap}
.hero-stat{min-width:50%;border-bottom:1px solid rgba(255,255,255,0.1)}
}
@media(max-width:768px){
.footer-inner{grid-template-columns:1fr 1fr;gap:2rem}
.footer-brand{grid-column:1/-1}

.nav{background:#fff!important;box-shadow:0 1px 4px rgba(0,0,0,0.08)}
.nav-logo-text{color:var(--text-dark)!important}
.container{padding:0 1rem}
.shield,.contact{padding:2.5rem 0}
.section-title{font-size:1.6rem}
.section-subtitle{max-width:100%}
.shield6000-media-strip{grid-template-columns:1fr!important}
.hero{min-height:auto;padding:6rem 0 0}
.hero h1{font-size:2.2rem}
.hero-sub{font-size:0.9rem}
.hero-content{flex-direction:column;align-items:flex-start;gap:1.5rem;padding-bottom:1.5rem}
.hero-left{display:none!important}
.hero-left a,.hero-left span{font-size:0.7rem;padding:0.4rem 0.8rem}
.hero-right{order:1}
.hero-stats{position:relative;flex-direction:row;flex-wrap:wrap}
.hero-stat{flex:1 1 50%;padding:1rem;border-bottom:1px solid rgba(255,255,255,0.1)}
.hero-stat-num{font-size:1.6rem}
.hero-stat-label{font-size:0.72rem}
.hero-btns{display:flex!important;flex-direction:column;gap:0.8rem;align-items:stretch}
.hero-btns .btn-gold,.hero-btns .btn-white{width:100%;text-align:center}
.hero-breadcrumb{display:none}
.shield-top{gap:1.5rem;grid-template-columns:1fr}
.shield-features{gap:1.5rem;grid-template-columns:1fr}
.shield-certs{flex-wrap:wrap;flex-direction:row}
.cert-pill{flex-shrink:0}
.vid-gallery{gap:1.5rem;grid-template-columns:1fr}
.contact-grid{gap:1.5rem;grid-template-columns:1fr}
.ba-row{grid-template-columns:1fr}
.form-row{grid-template-columns:1fr}
.contact-form-box{padding:1.5rem}



div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr !important}

.nav-links{display:none}
.hamburger{display:flex}
.hamburger span{background:var(--text-dark)!important}
.hero h1{font-size:3.2rem}
.hero-sub{font-size:0.95rem}
.hero-sub br{display:none}
.hero-breadcrumb{display:none}
.hero-content{flex-direction:column;align-items:flex-start;gap:1.5rem}
.hero-left{flex-direction:row;flex-wrap:wrap;gap:0.5rem}
.hero-btns{flex-direction:column;width:100%}
.hero-btns .btn-gold,.hero-btns .btn-white{width:100%}
.defense-badges{flex-direction:row;flex-wrap:wrap}
.hero-right{text-align:left}
.hero-stats{flex-direction:row;flex-wrap:wrap;padding:1.5rem 0}
.hero-stat{flex:1 1 50%;border-bottom:1px solid rgba(255,255,255,0.1);padding:1.2rem 1rem;min-width:50%}
.hero-stat-num{font-size:2rem}

div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr !important}
}
/* MG6000 section responsive */
@media(max-width:1024px){
.mg6000-multiplier-grid{grid-template-columns:1fr !important}
.mg6000-props-grid{grid-template-columns:1fr !important}
}
@media(max-width:768px){
.mg6000-econ-grid{grid-template-columns:1fr 1fr !important}
}
@media(max-width:480px){
.mg6000-econ-grid{grid-template-columns:1fr !important}
}
@media(max-width:768px){
.product-section-grid{grid-template-columns:1fr !important}
.product-features-grid{grid-template-columns:1fr !important}
}

@media(max-width:480px){
.footer-inner{grid-template-columns:1fr}

.hero h1{font-size:1.8rem}
.hero-stat-num{font-size:1.3rem}
.hero-stat{flex:1 1 50%;padding:0.8rem}
.hero-stat-label{font-size:0.7rem}
.hero-left a,.hero-left span{font-size:0.65rem;padding:0.35rem 0.7rem}
.section-title{font-size:1.4rem}
}

</style>



<!-- ===== NAVIGATION ===== -->
<nav class="nav" id="nav">
<div class="nav-inner">
<a href="<?php echo home_url('/'); ?>" class="nav-logo">
<svg viewBox="0 0 44 40" fill="none" aria-hidden="true"><rect x="2" y="24" width="7" height="16" rx="1" fill="currentColor" opacity="0.5"/><rect x="11" y="18" width="7" height="22" rx="1" fill="currentColor" opacity="0.7"/><rect x="20" y="11" width="7" height="29" rx="1" fill="currentColor" opacity="0.92"/><polygon points="30,8 37,2 37,40 30,40" fill="#C8A84B"/></svg>
<div class="nav-logo-text">A.R.I.<span> Faberman</span></div>
</a>
<div class="nav-links">
<a href="<?php echo home_url('/'); ?>#pillars">Solutions</a>
<a href="<?php echo home_url('/facility-assessment/'); ?>">Protection Advisory</a>
<a href="<?php echo home_url('/execution/'); ?>">Execution</a>
<a href="<?php echo home_url('/national-planning/'); ?>">National Regulation</a>
<a href="shield6000.html#mg6000">Technology</a>
<a href="<?php echo home_url('/customers/'); ?>">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>">About</a>
<a href="<?php echo home_url('/articles/'); ?>">Articles</a>
<div id="lang-toggle"></div>
<a href="<?php echo home_url('/customers/'); ?>#contact" class="nav-cta">Contact Us</a>
</div>
<div class="hamburger" onclick="document.getElementById('mobileMenu').classList.add('open')">
<span></span><span></span><span></span>
</div>
</div>
</nav>

<div class="mobile-menu" id="mobileMenu">
<div class="mobile-close" onclick="this.parentElement.classList.remove('open')">&times;</div>
<a href="<?php echo home_url('/'); ?>#pillars" onclick="this.parentElement.classList.remove('open')">Solutions</a>
<a href="<?php echo home_url('/facility-assessment/'); ?>" onclick="this.parentElement.classList.remove('open')">Protection Advisory</a>
<a href="<?php echo home_url('/execution/'); ?>" onclick="this.parentElement.classList.remove('open')">Execution</a>
<a href="<?php echo home_url('/national-planning/'); ?>" onclick="this.parentElement.classList.remove('open')">National Regulation</a>
<a href="shield6000.html#mg6000" onclick="this.parentElement.classList.remove('open')">Technology</a>
<a href="<?php echo home_url('/customers/'); ?>" onclick="this.parentElement.classList.remove('open')">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>" onclick="this.parentElement.classList.remove('open')">About</a>
<a href="<?php echo home_url('/articles/'); ?>" onclick="this.parentElement.classList.remove('open')">Articles</a>
<a href="<?php echo home_url('/customers/'); ?>#contact" onclick="this.parentElement.classList.remove('open')" class="btn-gold" style="margin-top:1rem">Contact Us</a>
</div>
<!-- ===== HERO -Shield 6000 Dedicated ===== -->
<section class="hero" id="hero">
<div class="hero-video-wrap">
<video autoplay muted loop playsinline>
<source src="<?php echo get_template_directory_uri(); ?>/images/shield-bg.mp4" type="video/mp4">
</video>
</div>

<!-- Breadcrumb -->
<div class="hero-breadcrumb fade-in">
<a href="<?php echo home_url('/'); ?>">Home</a><span>/</span>
<a href="<?php echo home_url('/'); ?>#pillars">Defense Solutions</a><span>/</span>
<strong style="color:#fff">SHIELD (MAGEN) 6000</strong>
</div>

<div class="hero-content">
<!-- Left column -credential badges -->
<div class="hero-left fade-in fade-in-delay-2">
<div class="defense-badges">
<div class="defense-badge gold-badge">
<span class="defense-badge-text">Patented Technology</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Ministry of Defense Approved</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Military Certified</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Standard 4422 Compliant</span>
</div>
<div class="defense-badge gold-badge">
<span class="defense-badge-text">MG6000 Super-Polymer</span>
</div>
</div>
</div>

<!-- Right column -main text -->
<div class="hero-right">
<h1 class="fade-in">
SHIELD (MAGEN)<br>6000<span class="red-dot">.</span>
</h1>
<p class="hero-sub fade-in fade-in-delay-1">
Warzone Tested, Cilivian Defense-Certified Protection System Against<br>Ballistic, Blast &amp; Fragmentation Threats<br><span style="font-size:0.85rem;color:rgba(255,255,255,0.6);font-weight:400;letter-spacing:0.04em;margin-top:0.3rem;display:inline-block">Powered by MG6000  -  Patented Super-Polymer Technology</span>
</p>
<div class="hero-btns fade-in fade-in-delay-3">
<a href="#contact" class="btn-gold">Contact Us</a>
<a href="#overview" class="btn-white">Explore Technology &rarr;</a>
</div>
</div>
</div>

<!-- Stats bar -->
<div class="hero-stats fade-in fade-in-delay-3">
<div class="hero-stat">
<div class="hero-stat-num">8-10mm</div>
<div class="hero-stat-label">Spray Layer<br>Thickness</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num">&lt;5 Days</div>
<div class="hero-stat-label">To Fortify Any<br>Existing Room</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num">25<sup>+</sup></div>
<div class="hero-stat-label">Year Certified<br>Lifespan</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num">2&times;</div>
<div class="hero-stat-label">Wall Strength<br>From 8-10mm Layer</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num">0</div>
<div class="hero-stat-label">Permits<br>Required</div>
</div>
</div>
</section>

<!-- ===== SHIELD DEEP DIVE ===== -->
<section class="shield" id="overview">
<div class="container">
<div class="shield-top">
<div class="fade-in">
<div class="shield-badge">
<span class="shield-badge-text">MG6000  -  Patented &amp; Defense-Certified Technology</span>
</div>
<h2>The Only Spray System Certified as a Safe Room</h2>
<p class="shield-text">No other product in the world holds defense-ministry certification for converting a standard room into a certified protected space using spray application. Shield 6000  -  built on a patented super-polymer known as MG6000 (Magen 6000)  -  is an 8-10mm-thick polymeric silicone compound sprayed directly onto the internal surfaces of a room's walls, combined with certified protective frames for all door and window openings. The result delivers ballistic and blast protection equivalent to a reinforced concrete safe room  -  while remaining completely invisible in daily use.</p>
<div class="shield-features">
<div class="shield-feat">
<h4>Defense-Grade Protection</h4>
<p>8-10mm polymeric silicone spray layer  -  certified equivalent to reinforced concrete safe room. Compliant with international Standard 4422 (protective frames) and Standard 4577 (sealed room requirements).</p>
</div>
<div class="shield-feat">
<h4>Rapid Installation</h4>
<p>Full room protected in approximately 5 working days, not months of construction. No demolition required.</p>
</div>
<div class="shield-feat">
<h4>Invisible in Daily Life</h4>
<p>The system becomes an integral part of the room and is not felt during daily use. Aesthetic finish with walls painted in the customer's color of choice. No need to change existing furnishings.</p>
</div>
<div class="shield-feat">
<h4>Zero Structural Modifications</h4>
<p>Applied directly to existing walls  -  only a few millimeters added to room circumference. Non-toxic, no radiation, no disruption to building operations. No permits required.</p>
</div>
</div>
</div>
<div class="fade-in fade-in-delay-1">
<div class="shield-video">
<a href="https://www.youtube.com/watch?v=PyMtkEq0LvE" target="_blank" rel="noopener" style="display:block;position:relative;width:100%;aspect-ratio:16/9;background:#000;border-radius:14px;overflow:hidden">
<img src="https://img.youtube.com/vi/SFgS8FJUKCs/maxresdefault.jpg" alt="Shield 6000 Application Video" style="width:100%;height:100%;object-fit:cover;display:block">
<div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.25);transition:background 0.3s">
<div style="width:68px;height:48px;background:rgba(255,0,0,0.85);border-radius:12px;display:flex;align-items:center;justify-content:center">
<svg width="24" height="24" viewBox="0 0 24 24" fill="#fff"><polygon points="8,5 20,12 8,19"/></svg>
</div>
</div>
</a>
</div>
<div class="shield-certs">
<div class="cert-pill"><div class="dot"></div>Military Home Front Command Certified</div>
<div class="cert-pill"><div class="dot"></div>Ministry of Defense Approved</div>
<div class="cert-pill"><div class="dot"></div>International Patent</div>
<div class="cert-pill"><div class="dot"></div>Standard 4422 Compliant</div>
<div class="cert-pill"><div class="dot"></div>Standard 4577 Sealed Room</div>
</div>
</div>
</div>

<!-- Shield 6000 Media Strip -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:2.5rem" class="shield6000-media-strip fade-in">
<div>
<img src="<?php echo get_template_directory_uri(); ?>/images/shield6000-spray.jpg" alt="Shield 6000 polymeric silicone spray application" style="width:100%;display:block;aspect-ratio:16/9;object-fit:cover;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.1)">
<p style="margin-top:0.5rem;font-size:0.75rem;color:var(--text-light);text-align:center;font-style:italic">Polymeric silicone compound being applied to wall surface</p>
</div>
<div>
<a href="https://www.youtube.com/watch?v=xlzZqeQjzHw" target="_blank" rel="noopener" style="display:block;position:relative;width:100%;aspect-ratio:16/9;border-radius:12px;overflow:hidden;background:#000;box-shadow:0 4px 20px rgba(0,0,0,0.1)">
<img src="https://img.youtube.com/vi/xlzZqeQjzHw/hqdefault.jpg" alt="Shield 6000  -  Explosive Testing" style="width:100%;height:100%;object-fit:cover;opacity:0.85">
<div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:60px;height:60px;background:rgba(255,0,0,0.85);border-radius:50%;display:flex;align-items:center;justify-content:center">
<div style="width:0;height:0;border-top:12px solid transparent;border-bottom:12px solid transparent;border-left:20px solid #fff;margin-left:4px"></div>
</div>
</a>
<p style="margin-top:0.5rem;font-size:0.75rem;color:var(--text-light);text-align:center;font-style:italic">Explosive Test  -  click to watch</p>
</div>
</div>
<!-- Regulatory Context -->
<div style="margin-top:4rem;display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center" class="fade-in">
<div>
<div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--gold);margin-bottom:0.8rem">The Standard We Build To</div>
<h3 style="font-family:var(--font-heading);font-size:1.6rem;font-weight:700;margin-bottom:1rem;color:var(--text-dark)"> Civil Defense Law  -  Protected Spaces</h3>
<p style="color:var(--text-mid);line-height:1.7;margin-bottom:1rem">Under the Civil Defense Law, every building constructed in should be required to include a designated protected space. These spaces are designed to withstand blast waves and shrapnel from ballistic missile impacts at varying ranges.</p>
<p style="color:var(--text-mid);line-height:1.7;margin-bottom:1rem">Shield 6000 is certified to meet these same exacting standards  -  allowing any existing room to be transformed into a compliant protected space without traditional construction.</p>
<p style="color:var(--text-mid);line-height:1.7">Our engineering team uses proprietary automated review technology to verify every Shield 6000 installation against official Mamad construction plans, ensuring full regulatory compliance.</p>
</div>
<div style="border-radius:12px;overflow:hidden;box-shadow:var(--shadow-lg)">
<img src="<?php echo get_template_directory_uri(); ?>/images/mamad-cad-review.png" alt="Automated review of safe room construction plans" loading="lazy" style="width:100%;display:block">
<div style="padding:0.8rem 1rem;background:var(--bg-section);font-size:0.78rem;color:var(--text-light)">Automated Mamad (Safe Room) construction plan review system</div>
</div>
</div>
</div>
</section>


<!-- ===== MG6000 TECHNOLOGY SECTION ===== -->
<section style="padding:5rem 0;background:var(--bg-dark);color:#fff;position:relative;overflow:hidden" id="mg6000">
<div class="container">

<!-- Section Header -->
<div style="text-align:center;margin-bottom:3.5rem" class="fade-in">
<div style="font-size:0.8rem;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:var(--gold-bright);margin-bottom:0.6rem">The Technology</div>
<h2 style="font-family:var(--font-heading);font-size:2.8rem;font-weight:700;line-height:1.15;color:#fff;margin-bottom:0.8rem">MG6000  -  Patented Super-Polymer</h2>
<p style="font-size:1.05rem;color:rgba(255,255,255,0.6);max-width:650px;margin:0 auto;line-height:1.7">Developed by Rotem Magen Protective Technologies, MG6000 (Magen 6000) is the core material behind Shield 6000. A spray-applied super-polymer that creates a nanometric network delivering defense-grade protection in a fraction of the thickness.</p>
</div>

<!-- Concrete Thickness Multiplier -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center;margin-bottom:4rem" class="mg6000-multiplier-grid fade-in">
<div>
<h3 style="font-family:var(--font-heading);font-size:1.8rem;font-weight:700;margin-bottom:1.2rem;color:#fff">8-10mm That Doubles Your Wall Strength</h3>
<p style="color:rgba(255,255,255,0.7);line-height:1.7;margin-bottom:1.5rem">An 8-10mm layer of MG6000 applied to a standard 20cm concrete wall upgrades its protective capacity to the equivalent of 40cm solid reinforced concrete  -  without adding significant weight, space, or construction time.</p>
<div style="display:flex;flex-direction:column;gap:0.7rem">
<div style="display:flex;align-items:center;gap:0.6rem">
<div style="width:8px;height:8px;background:var(--gold-bright);border-radius:50%;flex-shrink:0"></div>
<span style="font-size:0.9rem;color:rgba(255,255,255,0.85)"><strong style="color:#fff">IDF Validated</strong>  -  Tested and confirmed by Militaries and Ministries of Defense</span>
</div>
<div style="display:flex;align-items:center;gap:0.6rem">
<div style="width:8px;height:8px;background:var(--gold-bright);border-radius:50%;flex-shrink:0"></div>
<span style="font-size:0.9rem;color:rgba(255,255,255,0.85)"><strong style="color:#fff">120mm Mortar Impact</strong>  -  Withstood direct mortar fragment impact in live testing</span>
</div>
<div style="display:flex;align-items:center;gap:0.6rem">
<div style="width:8px;height:8px;background:var(--gold-bright);border-radius:50%;flex-shrink:0"></div>
<span style="font-size:0.9rem;color:rgba(255,255,255,0.85)"><strong style="color:#fff">Corps of Engineers Approved</strong>  -  Meets military engineering standards</span>
</div>
<div style="display:flex;align-items:center;gap:0.6rem">
<div style="width:8px;height:8px;background:var(--gold-bright);border-radius:50%;flex-shrink:0"></div>
<span style="font-size:0.9rem;color:rgba(255,255,255,0.85)"><strong style="color:#fff">Home Front Command Certified</strong>  -  Full compliance with any civil defense requirements</span>
</div>
</div>
</div>
<div style="border-radius:14px;overflow:hidden;border:1px solid rgba(255,255,255,0.1);box-shadow:0 10px 40px rgba(0,0,0,0.3)">
<img src="<?php echo get_template_directory_uri(); ?>/images/mg6000-multiplier.png" alt="MG6000 Concrete Thickness Multiplier  -  8-10mm layer upgrades 20cm wall to 40cm equivalent" loading="lazy" style="width:100%;display:block">
<div style="padding:0.8rem 1rem;background:rgba(255,255,255,0.05);font-size:0.78rem;color:rgba(255,255,255,0.5)">MG6000 concrete thickness multiplier  -  8-10mm spray layer doubles wall protection capacity</div>
</div>
</div>

<!-- Key Material Properties Grid -->
<div class="fade-in" style="margin-bottom:3rem">
<h3 style="font-family:var(--font-heading);font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:1.5rem;text-align:center">Key Material Properties</h3>
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:0.8rem" class="mg6000-props-grid">
<div style="background:rgba(255,255,255,0.03);border-left:3px solid var(--gold-bright);border-radius:0 8px 8px 0;padding:1.2rem 1.4rem;transition:all 0.3s" onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
<h4 style="font-size:0.95rem;font-weight:700;color:#fff;margin-bottom:0.3rem">Exceptional Strength</h4>
<p style="font-size:0.82rem;color:rgba(255,255,255,0.55);line-height:1.6">Creates a nanometric network that absorbs and dissipates blast energy across the entire surface, preventing penetration and structural failure.</p>
</div>
<div style="background:rgba(255,255,255,0.03);border-left:3px solid var(--gold-bright);border-radius:0 8px 8px 0;padding:1.2rem 1.4rem;transition:all 0.3s" onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
<h4 style="font-size:0.95rem;font-weight:700;color:#fff;margin-bottom:0.3rem">Full Communication Continuity</h4>
<p style="font-size:0.82rem;color:rgba(255,255,255,0.55);line-height:1.6">Unlike traditional steel-and-concrete reinforcement, MG6000 does not block cellular, radio, or Wi-Fi signals  -  maintaining full operational communication inside protected spaces.</p>
</div>
<div style="background:rgba(255,255,255,0.03);border-left:3px solid var(--gold-bright);border-radius:0 8px 8px 0;padding:1.2rem 1.4rem;transition:all 0.3s" onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
<h4 style="font-size:0.95rem;font-weight:700;color:#fff;margin-bottom:0.3rem">Chemical &amp; Unconventional Protection</h4>
<p style="font-size:0.82rem;color:rgba(255,255,255,0.55);line-height:1.6">Provides comprehensive sealing against chemical, biological, and unconventional threats  -  acting as both a structural reinforcement and environmental barrier.</p>
</div>
<div style="background:rgba(255,255,255,0.03);border-left:3px solid var(--gold-bright);border-radius:0 8px 8px 0;padding:1.2rem 1.4rem;transition:all 0.3s" onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
<h4 style="font-size:0.95rem;font-weight:700;color:#fff;margin-bottom:0.3rem">Non-Toxic Material</h4>
<p style="font-size:0.82rem;color:rgba(255,255,255,0.55);line-height:1.6">Safe for continuous human occupancy. No radiation, no off-gassing, no hazardous components  -  suitable for hospitals, schools, hotels, and residential buildings.</p>
</div>
<div style="background:rgba(255,255,255,0.03);border-left:3px solid var(--gold-bright);border-radius:0 8px 8px 0;padding:1.2rem 1.4rem;transition:all 0.3s" onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
<h4 style="font-size:0.95rem;font-weight:700;color:#fff;margin-bottom:0.3rem">Dual Solution</h4>
<p style="font-size:0.82rem;color:rgba(255,255,255,0.55);line-height:1.6">MG6000 serves as both a protection layer and a complete sealing solution  -  eliminating the need for separate waterproofing or chemical sealing systems.</p>
</div>
<div style="background:rgba(255,255,255,0.03);border-left:3px solid var(--gold-bright);border-radius:0 8px 8px 0;padding:1.2rem 1.4rem;transition:all 0.3s" onmouseover="this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
<h4 style="font-size:0.95rem;font-weight:700;color:#fff;margin-bottom:0.3rem">Significant CAPEX Reduction</h4>
<p style="font-size:0.82rem;color:rgba(255,255,255,0.55);line-height:1.6">Dramatically reduces required concrete and steel quantities, lowers construction weight loads, and shortens project timelines  -  delivering major capital expenditure savings.</p>
</div>
</div>
</div>

<!-- Economic Value Bar -->
<div class="fade-in">
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem" class="mg6000-econ-grid">
<div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);border-radius:12px;padding:1.2rem;text-align:center">
<div style="font-size:1.6rem;font-weight:800;color:var(--gold-bright);margin-bottom:0.3rem">&darr; CAPEX</div>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.55);line-height:1.5">Less concrete &amp; steel required  -  significant material savings</p>
</div>
<div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);border-radius:12px;padding:1.2rem;text-align:center">
<div style="font-size:1.6rem;font-weight:800;color:var(--gold-bright);margin-bottom:0.3rem">&uarr; Space</div>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.55);line-height:1.5">Thin-layer application preserves usable interior space</p>
</div>
<div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);border-radius:12px;padding:1.2rem;text-align:center">
<div style="font-size:1.6rem;font-weight:800;color:var(--gold-bright);margin-bottom:0.3rem">&darr; Time</div>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.55);line-height:1.5">Faster implementation with fewer construction stages</p>
</div>
<div style="background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);border-radius:12px;padding:1.2rem;text-align:center">
<div style="font-size:1.6rem;font-weight:800;color:var(--gold-bright);margin-bottom:0.3rem">&uarr; Lifespan</div>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.55);line-height:1.5">Extends asset protection life beyond 25 years</p>
</div>
</div>
</div>

</div>
</section>

<!-- ===== E-PANEL SECTION ===== -->
<section style="padding:5rem 0;background:var(--bg-section)" id="epanel">
<div class="container">
<div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center" class="product-section-grid fade-in">
<div>
<div style="display:inline-flex;align-items:center;gap:0.5rem;background:var(--gold-dim);border:1px solid var(--gold-border);padding:0.35rem 0.9rem;border-radius:4px;margin-bottom:1rem">
<span style="font-size:0.78rem;font-weight:700;color:var(--gold);letter-spacing:0.1em;text-transform:uppercase">Modular Composite Protection</span>
</div>
<h2 style="font-family:var(--font-heading);font-size:2.2rem;font-weight:700;line-height:1.2;margin-bottom:1rem;color:var(--text-dark)">E-Panel</h2>
<p style="font-size:0.95rem;color:var(--text-mid);line-height:1.7;margin-bottom:1.5rem">Blast- and ballistic-resistant modular composite protection panels engineered for rapid deployment. E-Panel provides structural hardening without traditional construction timelines - ideal for perimeter defense, critical infrastructure reinforcement, and scenarios where speed of installation is a priority.</p>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:0.8rem" class="product-features-grid">
<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1.1rem">
<h4 style="font-size:0.88rem;font-weight:600;margin-bottom:0.25rem;color:var(--text-dark)">Modular Design</h4>
<p style="font-size:0.82rem;color:var(--text-light);line-height:1.55">Pre-fabricated panels that can be configured and installed to match any structural layout or protection requirement.</p>
</div>
<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1.1rem">
<h4 style="font-size:0.88rem;font-weight:600;margin-bottom:0.25rem;color:var(--text-dark)">Rapid Installation</h4>
<p style="font-size:0.82rem;color:var(--text-light);line-height:1.55">Dramatically faster than traditional concrete reinforcement. Minimal site disruption, no heavy machinery required.</p>
</div>
<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1.1rem">
<h4 style="font-size:0.88rem;font-weight:600;margin-bottom:0.25rem;color:var(--text-dark)">Blast &amp; Ballistic Rated</h4>
<p style="font-size:0.82rem;color:var(--text-light);line-height:1.55">Tested and certified to withstand blast waves and ballistic impact, meeting military-grade protection standards.</p>
</div>
<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1.1rem">
<h4 style="font-size:0.88rem;font-weight:600;margin-bottom:0.25rem;color:var(--text-dark)">Scalable Coverage</h4>
<p style="font-size:0.82rem;color:var(--text-light);line-height:1.55">From a single room to entire perimeters - panels can be combined and scaled to match any project scope.</p>
</div>
</div>
<div style="display:flex;flex-wrap:wrap;gap:0.6rem;margin-top:1.2rem">
<div style="display:flex;align-items:center;gap:0.4rem;background:var(--green-dim);border:1px solid rgba(22,163,74,0.2);padding:0.3rem 0.8rem;border-radius:20px;font-size:0.78rem;color:var(--green);font-weight:600"><div style="width:6px;height:6px;background:var(--green);border-radius:50%"></div>Defence Facilities</div>
<div style="display:flex;align-items:center;gap:0.4rem;background:var(--green-dim);border:1px solid rgba(22,163,74,0.2);padding:0.3rem 0.8rem;border-radius:20px;font-size:0.78rem;color:var(--green);font-weight:600"><div style="width:6px;height:6px;background:var(--green);border-radius:50%"></div>Critical Infrastructure</div>
<div style="display:flex;align-items:center;gap:0.4rem;background:var(--green-dim);border:1px solid rgba(22,163,74,0.2);padding:0.3rem 0.8rem;border-radius:20px;font-size:0.78rem;color:var(--green);font-weight:600"><div style="width:6px;height:6px;background:var(--green);border-radius:50%"></div>Perimeter Hardening</div>
</div>
</div>
<div style="border-radius:14px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-lg)">
<img src="<?php echo get_template_directory_uri(); ?>/images/epanel-blast.jpg" alt="E-Panel blast-resistant composite protection panel stopping explosion impact" loading="lazy" style="width:100%;display:block;aspect-ratio:16/10;object-fit:cover">
<div style="padding:0.8rem 1rem;background:var(--bg-section);font-size:0.78rem;color:var(--text-light)">E-Panel composite protection - blast-resistant modular panels engineered for rapid structural hardening</div>
</div>
</div>
</div>
</section>

<!-- All Products CTA -->
<div class="fade-in" style="margin-top:4rem;text-align:center;padding-top:2.5rem;border-top:1px solid rgba(255,255,255,0.06)">
<p style="font-size:0.9rem;color:rgba(255,255,255,0.5);margin-bottom:1rem">Both MG6000 and E-Panel are developed by Rotem Magen Protective Technologies, our exclusive technology partner.</p>
<a href="#contact" style="display:inline-block;padding:0.8rem 2rem;background:var(--gold-light);color:#fff;border-radius:8px;font-weight:700;font-size:0.9rem;transition:all 0.3s" onmouseover="this.style.background='var(--gold-bright)'" onmouseout="this.style.background='var(--gold-light)'">Discuss Your Protection Requirements</a>
</div>

<!-- ===== CONTACT ===== -->
<section class="contact" id="contact">
<div class="container">
<div class="section-label fade-in">Get Started</div>
<div class="section-title fade-in" style="margin-bottom:2rem">Request a Shield 6000 Assessment</div>
<div class="contact-grid">
<div class="contact-form-box fade-in">
<form id="contactForm">
<div class="form-row">
<div class="form-group"><label>Full Name *</label><input type="text" name="name" required placeholder="Your full name"></div>
<div class="form-group"><label>Organization</label><input type="text" name="organization" placeholder="Company or government entity"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Email Address *</label><input type="email" name="email" required placeholder="you@organization.com"></div>
<div class="form-group"><label>Phone Number</label><input type="tel" name="phone" placeholder="+971 XX XXX XXXX"></div>
</div>
<div class="form-row">
<div class="form-group">
<label>Number of Rooms</label>
<select name="num_rooms"><option value="">Select</option><option>1-5 rooms</option><option>6-20 rooms</option><option>21-50 rooms</option><option>50+ rooms</option><option>Full facility</option></select>
</div>
<div class="form-group">
<label>Facility Type</label>
<select name="facility_type"><option value="">Select facility</option><option>Hotel / Hospitality</option><option>Hospital / Healthcare</option><option>Office / Commercial</option><option>Data Center</option><option>Energy / Industrial</option><option>Government / Military</option><option>Residential</option><option>Other</option></select>
</div>
</div>
<div class="form-group"><label>Message</label><textarea name="message" placeholder="Tell us about your protection needs -all communications are strictly confidential"></textarea></div>
<button type="submit" class="form-submit">Submit Inquiry &rarr;</button>
</form>
</div>
<div class="contact-info fade-in fade-in-delay-1">
<div class="info-card">
<div><h4>Confidential by Default</h4><p>All inquiries under strict NDA. Every engagement begins with mutual confidentiality agreements.</p></div>
</div>
<div class="info-card">
<div><h4>Fast SLA</h4><p>We prioritize every inquiry. Mark urgent for expedited handling.</p></div>
</div>
<div class="info-card">
<div><h4>Global Deployment</h4><p>Based in the Middle East, deployable across the Gulf, Southeast Asia, and worldwide.</p></div>
</div>
</div>
</div>
</div>
</section>

<!-- ===== FOOTER ===== -->
<footer>
<div class="footer-inner">
<div class="footer-brand">
<div class="footer-logo">
<svg viewBox="0 0 44 40" fill="none" aria-hidden="true"><rect x="2" y="24" width="7" height="16" rx="1" fill="currentColor" opacity="0.5"/><rect x="11" y="18" width="7" height="22" rx="1" fill="currentColor" opacity="0.7"/><rect x="20" y="11" width="7" height="29" rx="1" fill="currentColor" opacity="0.92"/><polygon points="30,8 37,2 37,40 30,40" fill="#C8A84B"/></svg>
<div class="footer-logo-text">Fort<span>line</span></div>
</div>
<p class="footer-tagline">Civilian defense-grade protection technology for critical infrastructure worldwide.</p>
</div>
<div class="footer-col">
<h4>Solutions</h4>
<a href="<?php echo home_url('/facility-assessment/'); ?>">Protection Advisory</a>
<a href="<?php echo home_url('/execution/'); ?>">Execution</a>
<a href="<?php echo home_url('/national-planning/'); ?>">National Regulation</a>
</div>
<div class="footer-col">
<h4>Company</h4>
<a href="<?php echo home_url('/customers/'); ?>">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>">About</a>
<a href="<?php echo home_url('/articles/'); ?>">Articles</a>
</div>
<div class="footer-col">
<h4>Get in Touch</h4>
<a href="<?php echo home_url('/customers/'); ?>#contact">Request Assessment</a>
</div>
</div>
<div class="footer-bar">
<p>&copy; 2026 ARI Engineering. All rights reserved.</p>
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script>try { emailjs.init('gHP8ZucvB2iLEtPVU'); } catch(e) {}</script>

<script>
// Sticky nav
const nav=document.getElementById('nav');
window.addEventListener('scroll',()=>nav.classList.toggle('scrolled',window.scrollY>80));

// Scroll fade-in
const obs=new IntersectionObserver(entries=>{
entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target)}});
},{threshold:0.08,rootMargin:'0px 0px -30px 0px'});
document.querySelectorAll('.fade-in').forEach(el=>obs.observe(el));

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a=>{
a.addEventListener('click',e=>{
e.preventDefault();
const t=document.querySelector(a.getAttribute('href'));
if(t)t.scrollIntoView({behavior:'smooth',block:'start'});
});
});

// Contact form -send email via EmailJS
(function(){
const form=document.getElementById('contactForm');
if(!form)return;
form.addEventListener('submit',function(e){
e.preventDefault();
const btn=form.querySelector('.form-submit');
const origText=btn.textContent;
btn.textContent='Sending...';btn.disabled=true;

const data={
name:form.name.value,
organization:form.organization.value,
email:form.email.value,
phone:form.phone.value,
num_rooms:form.num_rooms.value,
facility_type:form.facility_type.value,
message:form.message.value
};

emailjs.send('service_py23y6a','template_lgfttoi',{
to_email:'eddie.nudel@gmail.com',
from_name:data.name,
from_email:data.email,
organization:data.organization,
phone:data.phone||'Not provided',
inquiry_type:'Shield 6000',
facility_type:data.facility_type||'Not specified',
num_rooms:data.num_rooms||'Not specified',
message:data.message||'No message provided',
subject:'Shield 6000 Inquiry from '+data.name
}).then(function(){
btn.textContent='Inquiry Submitted Successfully';
btn.style.background='#16a34a';btn.style.color='#fff';
form.reset();
setTimeout(()=>{btn.textContent=origText;btn.style.background='';btn.style.color='';btn.disabled=false;},5000);
},function(err){
console.error('EmailJS error:',err);
btn.textContent='Error -Please Try Again';
btn.style.background='#dc2626';btn.style.color='#fff';
btn.disabled=false;
setTimeout(()=>{btn.textContent=origText;btn.style.background='';btn.style.color='';},4000);
});
});
})();
</script>

<?php get_footer(); ?>