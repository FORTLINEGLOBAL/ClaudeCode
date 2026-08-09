<?php
/**
 * Template Name: Facility Assessment
 * Description: Facility Assessment page
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

/* ===== HERO ===== */
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

.hero-breadcrumb{
position:absolute;top:5.5rem;left:2.5rem;z-index:3;
font-size:0.82rem;color:rgba(255,255,255,0.7);
}
.hero-breadcrumb a{color:rgba(255,255,255,0.7);transition:color 0.3s}
.hero-breadcrumb a:hover{color:#fff}
.hero-breadcrumb span{margin:0 0.4rem;opacity:0.5}

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
.hero-stat-num sup{font-size:1.2rem;font-weight:400;vertical-align:super;margin-left:2px}
.hero-stat-label{font-size:0.88rem;color:rgba(255,255,255,0.7);margin-top:0.3rem;line-height:1.35;font-weight:400}

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

/* ===== OVERVIEW SECTION ===== */
.overview{padding:5rem 0;background:var(--bg-light)}
.overview-top{
display:grid;grid-template-columns:1fr 1fr;gap:3rem;
margin-bottom:3rem;
}
.overview-badge{
display:inline-flex;align-items:center;gap:0.5rem;
background:var(--gold-dim);border:1px solid var(--gold-border);
padding:0.35rem 0.9rem;border-radius:4px;
margin-bottom:1rem;
}
.overview-badge-text{font-size:0.78rem;font-weight:700;color:var(--gold);letter-spacing:0.1em;text-transform:uppercase}
.overview h2{
font-family:var(--font-heading);font-size:2.2rem;font-weight:700;
line-height:1.2;margin-bottom:1rem;color:var(--text-dark);
}
.overview-text{font-size:0.95rem;color:var(--text-mid);line-height:1.7;margin-bottom:1.5rem}
.overview-features{display:grid;grid-template-columns:1fr 1fr;gap:0.8rem}
.overview-feat{
background:var(--bg-card);border:1px solid var(--border);
border-radius:10px;padding:1.1rem;
transition:all 0.3s;
}
.overview-feat:hover{border-color:var(--gold-border);box-shadow:var(--shadow)}
.overview-feat h4{font-size:0.95rem;font-weight:600;margin-bottom:0.25rem;color:var(--text-dark)}
.overview-feat p{font-size:0.85rem;color:var(--text-light);line-height:1.55}

.overview-image{
border-radius:14px;overflow:hidden;
border:1px solid var(--border);
box-shadow:var(--shadow-lg);
height:100%;min-height:300px;
}
.overview-image img{width:100%;height:100%;object-fit:cover}

/* ===== SECTORS ===== */
.sectors{padding:5rem 0;background:var(--bg)}
.sectors-header{text-align:center;margin-bottom:3.5rem}
.sectors-header .section-subtitle{margin:0 auto}
.sectors-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem}
.sector-card{
background:var(--bg-card);
border:1px solid var(--border);
border-radius:16px;overflow:hidden;
transition:all 0.4s;
}
.sector-card:hover{border-color:var(--gold-border);box-shadow:var(--shadow-lg)}
.sector-img{height:200px;overflow:hidden;position:relative}
.sector-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s}
.sector-card:hover .sector-img img{transform:scale(1.06)}
.sector-body{padding:1.5rem}
.sector-body h3{
font-family:var(--font-heading);font-size:1.15rem;font-weight:700;
margin-bottom:0.5rem;color:var(--text-dark);
}
.sector-body p{font-size:0.88rem;color:var(--text-mid);line-height:1.65}

/* ===== PROCESS ===== */
.process{padding:5rem 0;background:var(--bg-light)}
.process-header{text-align:center;margin-bottom:3.5rem}
.timeline{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;position:relative}
.timeline::before{
content:'';position:absolute;
top:100px;left:12.5%;right:12.5%;
height:2px;
background:linear-gradient(90deg,transparent,var(--gold-light),var(--gold-light),transparent);
}
.tl-step{text-align:center;position:relative}
.tl-img{width:100%;height:150px;border-radius:12px;overflow:hidden;margin-bottom:1.2rem;box-shadow:var(--shadow)}
.tl-img img{width:100%;height:100%;object-fit:cover}
.tl-num{
width:44px;height:44px;border-radius:50%;
background:var(--bg);border:2px solid var(--gold-light);
display:flex;align-items:center;justify-content:center;
font-family:var(--font-heading);font-weight:700;font-size:1rem;color:var(--gold);
margin:0 auto 0.8rem;position:relative;z-index:2;
box-shadow:var(--shadow);
}
.tl-step h3{font-family:var(--font-heading);font-size:1.05rem;font-weight:600;margin-bottom:0.4rem;color:var(--text-dark)}
.tl-step p{font-size:0.85rem;color:var(--text-light);line-height:1.55;max-width:240px;margin:0 auto}

/* ===== DARK SECTION - WHY US ===== */
.why-us{padding:5rem 0;background:var(--bg-dark);color:#fff}
.why-us .section-label{color:var(--gold-bright)}
.why-us .section-title{color:#fff}
.why-grid{display:grid;grid-template-columns:1fr 1fr;gap:3rem;margin-top:2rem}
.why-cards{display:flex;flex-direction:column;gap:1rem}
.why-card{
background:rgba(255,255,255,0.05);
border:1px solid rgba(255,255,255,0.08);
border-radius:12px;padding:1.4rem;
transition:all 0.3s;
}
.why-card:hover{background:rgba(255,255,255,0.08);border-color:rgba(37,99,235,0.3)}
.why-card h3{font-family:var(--font-heading);font-size:1.1rem;font-weight:600;margin-bottom:0.4rem;color:#fff}
.why-card p{font-size:0.9rem;color:rgba(255,255,255,0.65);line-height:1.7}
.why-right{display:flex;flex-direction:column;gap:1.2rem}
.why-image{border-radius:12px;overflow:hidden;height:240px;position:relative}
.why-image img{width:100%;height:100%;object-fit:cover}
.deliverables-box{
background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);
border-radius:12px;padding:1.4rem;
}
.deliverables-box h3{font-family:var(--font-heading);font-size:1rem;font-weight:600;margin-bottom:1rem;color:var(--gold-bright)}
.del-row{display:flex;justify-content:space-between;align-items:center;padding:0.7rem 0;border-bottom:1px solid rgba(255,255,255,0.06)}
.del-row:last-child{border-bottom:none}
.del-label{font-size:0.85rem;color:rgba(255,255,255,0.7);flex:1}
.del-val{
font-family:var(--font-heading);font-weight:700;font-size:0.85rem;
padding:0.25rem 0.7rem;border-radius:6px;
color:#4ade80;background:rgba(74,222,128,0.1);
}

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
.overview-top{grid-template-columns:1fr}
.sectors-grid{grid-template-columns:1fr}
.why-grid{grid-template-columns:1fr}
.timeline{grid-template-columns:repeat(2,1fr);gap:2.5rem}
.timeline::before{display:none}
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
.overview,.sectors,.process,.why-us,.contact{padding:2.5rem 0}
.section-title{font-size:1.6rem}
.section-subtitle{max-width:100%}
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
.overview-top{gap:1.5rem;grid-template-columns:1fr}
.overview-features{gap:1.5rem;grid-template-columns:1fr}
.sectors-grid{gap:1.5rem;grid-template-columns:1fr}
.why-grid{gap:1.5rem;grid-template-columns:1fr}
.timeline{gap:1.5rem;max-width:none;grid-template-columns:1fr}
.contact-grid{gap:1.5rem;grid-template-columns:1fr}
.contact-form-box{padding:1.5rem}



div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr !important}

.nav-links{display:none}
.hamburger{display:flex}
.hamburger span{background:var(--text-dark)!important}
.hero h1{font-size:3.2rem}
.hero-sub{font-size:0.95rem}
.hero-sub br{display:none}
.hero-breadcrumb{display:none}
.section-title{font-size:1.9rem}
.overview-features{grid-template-columns:1fr}
.form-row{grid-template-columns:1fr}
.hero-content{flex-direction:column;align-items:flex-start;gap:1.5rem}
.hero-left{flex-direction:row;flex-wrap:wrap;gap:0.5rem}
.hero-btns{flex-direction:column;gap:0.8rem}
.hero-btns .btn-gold,.hero-btns .btn-white{width:100%;text-align:center}
.defense-badges{flex-direction:row;flex-wrap:wrap}
.hero-right{text-align:left}
.del-row{flex-direction:column;gap:0.8rem;border-bottom:1px solid rgba(255,255,255,0.06) !important;padding:0.8rem 0 !important}
.del-label{margin-bottom:0.3rem}

.timeline{grid-template-columns:1fr;max-width:300px;margin:0 auto}
.hero-stats{flex-direction:row;flex-wrap:wrap}
.hero-stat{flex:1 1 50%;border-bottom:1px solid rgba(255,255,255,0.1);padding:1.2rem 1rem}
.hero-stat-num{font-size:2rem}
}
@media(max-width:480px){
.footer-inner{grid-template-columns:1fr}

.hero h1{font-size:1.8rem}
.hero-stat-num{font-size:1.3rem}
.hero-stat{flex:1 1 50%;padding:0.8rem}
.hero-stat-label{font-size:0.7rem}
.hero-left a,.hero-left span{font-size:0.65rem;padding:0.35rem 0.7rem}
.section-title{font-size:1.4rem}
.hero-btns{flex-direction:column}

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
<a href="<?php echo home_url('/'); ?>#services" data-i18n="nav2.services">Services</a>
<a href="<?php echo home_url('/'); ?>#projects" data-i18n="nav2.projects">Projects</a>
<a href="<?php echo home_url('/'); ?>#customers" data-i18n="nav2.serve">Who We Serve</a>
<a href="<?php echo home_url('/'); ?>#why" data-i18n="nav2.about">About</a>
<a href="<?php echo home_url('/'); ?>#faq" data-i18n="nav2.faq">FAQ</a>

<div id="lang-toggle"></div>
<a href="<?php echo home_url('/'); ?>#contact" class="nav-cta">Contact Us</a>
</div>
<div class="hamburger" onclick="document.getElementById('mobileMenu').classList.add('open')">
<span></span><span></span><span></span>
</div>
</div>
</nav>

<div class="mobile-menu" id="mobileMenu">
<div class="mobile-close" onclick="this.parentElement.classList.remove('open')">&times;</div>
<a href="<?php echo home_url('/'); ?>#services" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.services">Services</a>
<a href="<?php echo home_url('/'); ?>#projects" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.projects">Projects</a>
<a href="<?php echo home_url('/'); ?>#customers" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.serve">Who We Serve</a>
<a href="<?php echo home_url('/'); ?>#why" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.about">About</a>
<a href="<?php echo home_url('/'); ?>#faq" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.faq">FAQ</a>
<a href="<?php echo home_url('/'); ?>#contact" onclick="this.parentElement.classList.remove('open')" class="btn-gold" style="margin-top:1rem">Contact Us</a>
</div>
<!-- ===== HERO ===== -->
<section class="hero" id="hero">
<div class="hero-video-wrap">
<video autoplay muted loop playsinline>
<source src="<?php echo get_template_directory_uri(); ?>/images/facility-bg.mp4" type="video/mp4">
</video>
</div>

<div class="hero-breadcrumb fade-in">
<a href="<?php echo home_url('/'); ?>">Home</a><span>/</span>
<a href="<?php echo home_url('/'); ?>#pillars">Defense Solutions</a><span>/</span>
<strong style="color:#fff">PROTECTION ADVISORY</strong>
</div>

<div class="hero-content">
<div class="hero-left fade-in fade-in-delay-2">
<div class="defense-badges">
<div class="defense-badge gold-badge">
<span class="defense-badge-text">Israeli Defense Expertise</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">25 Years Military Experience</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Critical Infrastructure</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Confidential Engagement</span>
</div>
</div>
</div>

<div class="hero-right">
<h1 class="fade-in">
Strategic<br>Protection Advisory<span class="red-dot">.</span>
</h1>
<p class="hero-sub fade-in fade-in-delay-1">
The Foundation of Every Project<br>Israeli defense engineers conducting comprehensive assessments
</p>
<div class="hero-btns fade-in fade-in-delay-3">
<a href="#contact" class="btn-gold">Request Assessment</a>
<a href="#overview" class="btn-white">Our Approach &rarr;</a>
</div>
</div>
</div>

<div class="hero-stats fade-in fade-in-delay-3">
<div class="hero-stat">
<div class="hero-stat-num" data-count="25" data-suffix="+">0</div>
<div class="hero-stat-label">Years Military<br>Protection Engineering</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num" data-count="350" data-suffix="+">0</div>
<div class="hero-stat-label">Facilities<br>Assessed</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num">6</div>
<div class="hero-stat-label">Critical<br>Sectors Served</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num">100%</div>
<div class="hero-stat-label">Under NDA<br>Confidential</div>
</div>
</div>
</section>

<!-- ===== OVERVIEW ===== -->
<section class="overview" id="overview">
<div class="container">
<div class="overview-top">
<div class="fade-in">
<div class="overview-badge">
<span class="overview-badge-text">Strategic Advisory Services</span>
</div>
<h2>Where We Deliver the Most Value</h2>
<p class="overview-text">We deliver comprehensive protection advisory services that help facility operators understand their vulnerability landscape and plan strategic responses. Whether physical fortification follows or not, our assessment methodology -developed through 25 years of Military Home Front Command experience -ensures you have a complete understanding of your protection posture and options.</p>
<div class="overview-features">
<div class="overview-feat">
<h4>Engineering Surveys & Vulnerability Assessment</h4>
<p>Comprehensive analysis of structural exposure, threat vectors, and protection gaps across all facility zones</p>
</div>
<div class="overview-feat">
<h4>Protection Planning & Characterization</h4>
<p>Identification and specification of optimal protection strategies, placement, and design for your facility context</p>
</div>
<div class="overview-feat">
<h4>Emergency Operations Methodology</h4>
<p>Custom emergency operations procedures, response protocols, and staff readiness programs</p>
</div>
<div class="overview-feat">
<h4>Regulatory Compliance & Cost-Benefit Analysis</h4>
<p>Comprehensive compliance assessment with implementation priorities, cost-benefit analysis, and strategic recommendations</p>
</div>
</div>
</div>
<div class="fade-in fade-in-delay-1">
<div class="overview-image">
<img src="<?php echo get_template_directory_uri(); ?>/images/hospital-blueprint.jpg" alt="Hospital protection zone assessment blueprint" loading="lazy">
</div>
</div>
</div>
</div>
</section>

<!-- ===== SECTORS ===== -->
<section class="sectors" id="sectors">
<div class="container">
<div class="sectors-header">
<div class="section-label fade-in">Sectors We Serve</div>
<div class="section-title fade-in">Protection Across Critical Industries</div>
<div class="section-subtitle fade-in fade-in-delay-1">We bring Israeli defense-grade assessment methodology to every type of critical facility -adapting our approach to the unique requirements of each sector.</div>
</div>
<div class="sectors-grid">
<div class="sector-card fade-in">
<div class="sector-img">
<img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=600&q=80" alt="Luxury private estate" loading="lazy">
</div>
<div class="sector-body">
<h3>Private Estates &amp; Villas</h3>
<p>Discreet, defense-grade protection for high-net-worth residences. We design certified safe rooms that blend invisibly into luxury interiors &mdash; using our patented Shield 6000 spray system and protective frames. No demolition, no disruption to aesthetics, full ballistic and blast certification. Tailored for royal compounds, private villas, and family estates across the Gulf.</p>
</div>
</div>
<div class="sector-card fade-in fade-in-delay-1">
<div class="sector-img">
<img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80" alt="Luxury hotel resort" loading="lazy">
</div>
<div class="sector-body">
<h3>Hotels &amp; Hospitality</h3>
<p>Guest safety without compromising luxury. We design invisible protection layers for five-star properties, conference centers, and resort complexes -prioritizing rapid guest evacuation and safe room access.</p>
</div>
</div>
<div class="sector-card fade-in fade-in-delay-2">
<div class="sector-img">
<img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=600&q=80" alt="Modern hospital" loading="lazy">
</div>
<div class="sector-body">
<h3>Hospitals &amp; Healthcare</h3>
<p>Continuity of care under threat. Our proprietary zone-classification methodology maps every area of a facility by protection level &mdash; standard protection, minimum protection, sheltered, and non-protected &mdash; enabling prioritized upgrades based on occupancy and criticality. Designed for facilities that cannot shut down during emergencies.</p>
</div>
</div>
<div class="sector-card fade-in">
<div class="sector-img">
<img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80" alt="Modern office building" loading="lazy">
</div>
<div class="sector-body">
<h3>Commercial &amp; Office</h3>
<p>Employee safety in high-rise and campus environments. We assess floor-by-floor vulnerability, design shelter-in-place protocols, and identify optimal protected space locations for maximum coverage.</p>
</div>
</div>
<div class="sector-card fade-in fade-in-delay-1">
<div class="sector-img">
<img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600&q=80" alt="Data center servers" loading="lazy">
</div>
<div class="sector-body">
<h3>Data Centers</h3>
<p>Protecting digital infrastructure from physical threats. Assessments cover structural hardening, cooling system resilience, power redundancy under blast conditions, and personnel safe rooms.</p>
</div>
</div>
<div class="sector-card fade-in fade-in-delay-2">
<div class="sector-img">
<img src="https://images.unsplash.com/photo-1513828583688-c52646db42da?w=600&q=80" alt="Industrial energy facility" loading="lazy">
</div>
<div class="sector-body">
<h3>Energy &amp; Industrial</h3>
<p>Oil, gas, power generation, and desalination plants. We deliver end-to-end physical protection of energy infrastructure and critical installations &mdash; from perimeter hardening and control room blast protection to hazmat containment, worker shelter requirements, and engineering support for defense-related infrastructure licensing.</p>
</div>
</div>
</div>
</div>
</section>

<!-- ===== REAL-WORLD PROJECTS ===== -->
<section style="padding:5rem 0;background:var(--bg-section)" id="projects">
<div class="container">
<div class="section-label fade-in">Real-World Experience</div>
<div class="section-title fade-in">From Israeli Defense Projects to Your Facility</div>
<div style="max-width:700px;margin:0.5rem auto 3rem;text-align:center;color:var(--text-light);font-size:0.95rem" class="fade-in">Our assessment methodology is built on decades of hands-on experience protecting Israel's most critical infrastructure &mdash; from energy installations and hospitals to strategic defense facilities.</div>

<!-- Hospital Protection -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center;margin-bottom:4rem" class="fade-in">
<div style="border-radius:12px;overflow:hidden;box-shadow:var(--shadow-lg)">
<img src="<?php echo get_template_directory_uri(); ?>/images/hospital-blueprint.jpg" alt="Hospital protection zone mapping" loading="lazy" style="width:100%;display:block">
<div style="padding:0.8rem 1rem;background:#fff;font-size:0.78rem;color:var(--text-light)">Hospital protection assessment &mdash; color-coded zone mapping showing standard protection (green), minimum protection (yellow), sheltered areas (blue), and non-protected zones (red)</div>
</div>
<div>
<div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--gold);margin-bottom:0.8rem">Hospital Protection</div>
<h3 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:700;margin-bottom:1rem;color:var(--text-dark)">Protecting Unfortified Areas in Emergency Facilities</h3>
<p style="color:var(--text-mid);line-height:1.7;margin-bottom:1rem">Hospitals cannot shut down during emergencies. Our advisory uses a proprietary color-coded zone classification methodology to map every area of a healthcare facility &mdash; identifying operating theaters, ICUs, emergency rooms, and patient wards by their current protection status.</p>
<p style="color:var(--text-mid);line-height:1.7;margin-bottom:1rem">Each zone is classified into four levels:</p>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;margin-bottom:1rem">
<div style="display:flex;align-items:center;gap:0.5rem"><div style="width:14px;height:14px;border-radius:3px;background:#22c55e;flex-shrink:0"></div><span style="font-size:0.82rem;color:var(--text-mid);font-weight:500">Standard Protection</span></div>
<div style="display:flex;align-items:center;gap:0.5rem"><div style="width:14px;height:14px;border-radius:3px;background:#eab308;flex-shrink:0"></div><span style="font-size:0.82rem;color:var(--text-mid);font-weight:500">Minimum Level Protection</span></div>
<div style="display:flex;align-items:center;gap:0.5rem"><div style="width:14px;height:14px;border-radius:3px;background:#3b82f6;flex-shrink:0"></div><span style="font-size:0.82rem;color:var(--text-mid);font-weight:500">Sheltered Area</span></div>
<div style="display:flex;align-items:center;gap:0.5rem"><div style="width:14px;height:14px;border-radius:3px;background:#ef4444;flex-shrink:0"></div><span style="font-size:0.82rem;color:var(--text-mid);font-weight:500">Non-Protected (Priority)</span></div>
</div>
<p style="color:var(--text-mid);line-height:1.7">This enables facility managers to prioritize structural upgrades based on occupancy, medical criticality, and threat exposure &mdash; ensuring the most critical care areas are fortified first.</p>
</div>
</div>

<!-- Defense Project Gallery -->
<div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--gold);margin-bottom:1rem;text-align:center" class="fade-in">Defense &amp; Security Projects</div>
<h3 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:700;margin-bottom:2rem;color:var(--text-dark);text-align:center" class="fade-in">Energy Infrastructure &amp; Strategic Facility Protection</h3>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem" class="fade-in">
<div style="border-radius:12px;overflow:hidden;box-shadow:var(--shadow)">
<img src="<?php echo get_template_directory_uri(); ?>/images/energy-facility-aerial.jpg" alt="Energy facility aerial view" loading="lazy" style="width:100%;height:220px;object-fit:cover;display:block">
<div style="padding:0.8rem 1rem;background:#fff"><p style="font-size:0.82rem;color:var(--text-mid);margin:0">Energy infrastructure protection &mdash; aerial view of industrial facility fortification</p></div>
</div>
<div style="border-radius:12px;overflow:hidden;box-shadow:var(--shadow)">
<img src="<?php echo get_template_directory_uri(); ?>/images/fortified-compound.jpg" alt="Fortified compound" loading="lazy" style="width:100%;height:220px;object-fit:cover;display:block">
<div style="padding:0.8rem 1rem;background:#fff"><p style="font-size:0.82rem;color:var(--text-mid);margin:0">Strategic facility with blast-resistant perimeter walls and protection infrastructure</p></div>
</div>
<div style="border-radius:12px;overflow:hidden;box-shadow:var(--shadow)">
<img src="<?php echo get_template_directory_uri(); ?>/images/infrastructure-protection.jpg" alt="Infrastructure protection construction" loading="lazy" style="width:100%;height:220px;object-fit:cover;display:block">
<div style="padding:0.8rem 1rem;background:#fff"><p style="font-size:0.82rem;color:var(--text-mid);margin:0">Structural reinforcement of critical energy infrastructure piping systems</p></div>
</div>
</div>
<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-top:1.5rem" class="fade-in fade-in-delay-1">
<div style="border-radius:12px;overflow:hidden;box-shadow:var(--shadow)">
<img src="<?php echo get_template_directory_uri(); ?>/images/bg-home-banner.webp" alt="Defense facility protection overview" loading="lazy" style="width:100%;height:200px;object-fit:cover;display:block">
<div style="padding:0.8rem 1rem;background:#fff"><p style="font-size:0.82rem;color:var(--text-mid);margin:0">Defense facility protection overview</p></div>
</div>
<div style="border-radius:12px;overflow:hidden;box-shadow:var(--shadow)">
<img src="<?php echo get_template_directory_uri(); ?>/images/rebar-construction.jpg" alt="Reinforcement construction" loading="lazy" style="width:100%;height:200px;object-fit:cover;display:block">
<div style="padding:0.8rem 1rem;background:#fff"><p style="font-size:0.82rem;color:var(--text-mid);margin:0">Reinforcement work at defense facility</p></div>
</div>
</div>
</div>
</section>

<!-- ===== PROCESS ===== -->
<section class="process" id="process">
<div class="container">
<div class="process-header">
<div class="section-label fade-in">Our Process</div>
<div class="section-title fade-in">Assessment to Advisory Delivery</div>
</div>
<div class="timeline">
<div class="tl-step fade-in">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600&q=80" alt="Confidential meeting" loading="lazy"></div>
<div class="tl-num">1</div>
<h3>Confidential Intake</h3>
<p>NDA-protected initial consultation. We learn about your facility, threat concerns, and protection objectives.</p>
</div>
<div class="tl-step fade-in fade-in-delay-1">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600&q=80" alt="Site survey blueprints" loading="lazy"></div>
<div class="tl-num">2</div>
<h3>On-Site Survey</h3>
<p>Structural assessment, threat vector analysis, and occupancy mapping by our military-trained engineering team.</p>
</div>
<div class="tl-step fade-in fade-in-delay-2">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&q=80" alt="Report analysis" loading="lazy"></div>
<div class="tl-num">3</div>
<h3>Gap Analysis Report</h3>
<p>Detailed vulnerability assessment with prioritized protection recommendations and cost estimates.</p>
</div>
<div class="tl-step fade-in fade-in-delay-3">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&q=80" alt="Implementation handoff" loading="lazy"></div>
<div class="tl-num">4</div>
<h3>Advisory Delivery</h3>
<p>Strategic advisory roadmap delivery. Comprehensive assessment documentation and optional support for execution partners.</p>
</div>
</div>
</div>
</section>

<!-- ===== WHY US (DARK) ===== -->
<section class="why-us" id="why-us">
<div class="container">
<div class="section-label fade-in">Why Fortline</div>
<div class="section-title fade-in">The Israeli Standard of Protection Engineering</div>
<div class="why-grid">
<div class="why-cards">
<div class="why-card fade-in">
<h3>Military-Grade Methodology</h3>
<p>Our assessment framework is derived directly from Military Home Front Command standards -the most battle-tested civilian protection methodology in the world. We apply the same rigor to every commercial facility.</p>
</div>
<div class="why-card fade-in fade-in-delay-1">
<h3>Not Theory -Operational Experience</h3>
<p>Our team has designed, built, and certified thousands of protected spaces under real threat conditions. Every recommendation comes from proven operational knowledge, not academic models.</p>
</div>
<div class="why-card fade-in fade-in-delay-2">
<h3>Strategic Advisory Depth</h3>
<p>Unlike generic security consultants, our advisory goes beyond compliance reports. We develop strategic protection methodologies, guide emergency operations planning, and support execution partner coordination -delivering genuine strategic value.</p>
</div>
</div>
<div class="why-right">
<div class="why-image fade-in">
<img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800&q=80" alt="Professional consultation" loading="lazy">
</div>
<div class="deliverables-box fade-in fade-in-delay-1">
<h3>Advisory Deliverables</h3>
<div class="del-row">
<div class="del-label">Vulnerability mapping report</div>
<div class="del-val">Included</div>
</div>
<div class="del-row">
<div class="del-label">Safe room placement design</div>
<div class="del-val">Included</div>
</div>
<div class="del-row">
<div class="del-label">Emergency protocol framework</div>
<div class="del-val">Included</div>
</div>
<div class="del-row">
<div class="del-label">Implementation roadmap + costs</div>
<div class="del-val">Included</div>
</div>
<div class="del-row">
<div class="del-label">Staff training program</div>
<div class="del-val">Included</div>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- ===== CONTACT ===== -->
<section class="contact" id="contact">
<div class="container">
<div class="section-label fade-in">Get Started</div>
<div class="section-title fade-in" style="margin-bottom:2rem">Request a Protection Advisory</div>
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
<label>Number of Facilities</label>
<select name="num_facilities"><option value="">Select</option><option>Single building</option><option>2-5 buildings</option><option>6-20 buildings</option><option>Campus / compound</option><option>Multiple sites</option></select>
</div>
<div class="form-group">
<label>Facility Type</label>
<select name="facility_type"><option value="">Select facility</option><option>Hotel / Hospitality</option><option>Hospital / Healthcare</option><option>Office / Commercial</option><option>Data Center</option><option>Energy / Industrial</option><option>Airport / Transportation</option><option>Government / Military</option><option>Other</option></select>
</div>
</div>
<div class="form-group"><label>Message</label><textarea name="message" placeholder="Tell us about your facility and protection concerns -all communications are strictly confidential"></textarea></div>
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
<p class="footer-tagline">Israeli defense-grade protection technology for critical infrastructure worldwide.</p>
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
<a href="<?php echo home_url('/'); ?>#contact">Request Assessment</a>
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

// Counter animation
const cObs=new IntersectionObserver(entries=>{
entries.forEach(e=>{
if(e.isIntersecting){
const el=e.target;
const target=parseInt(el.dataset.count);
if(isNaN(target))return;
const suffix=el.dataset.suffix||'';
const dur=2000;const st=performance.now();
const anim=now=>{
const p=Math.min((now-st)/dur,1);
const eased=1-Math.pow(1-p,3);
const cur=Math.floor(eased*target);
const formatted=target>=1000?cur.toLocaleString():cur;
el.textContent=formatted+suffix;
if(p<1)requestAnimationFrame(anim);
};
requestAnimationFrame(anim);
cObs.unobserve(el);
}
});
},{threshold:0.3});
document.querySelectorAll('[data-count]').forEach(el=>cObs.observe(el));

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
num_facilities:form.num_facilities.value,
facility_type:form.facility_type.value,
message:form.message.value
};

emailjs.send('service_py23y6a','template_lgfttoi',{
to_email:'eddie.nudel@gmail.com',
from_name:data.name,
from_email:data.email,
organization:data.organization,
phone:data.phone||'Not provided',
inquiry_type:'Protection Advisory',
facility_type:data.facility_type||'Not specified',
message:data.message||'No message provided',
subject:'Protection Advisory Inquiry from '+data.name
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