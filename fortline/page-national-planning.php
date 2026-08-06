<?php
/**
 * Template Name: National Planning
 * Description: National Planning page
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
.nav-logo svg{width:36px;height:36px}
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
font-size:6rem;font-weight:300;line-height:1.05;
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

/* ===== SCOPE CARDS ===== */
.scope{padding:5rem 0;background:var(--bg)}
.scope-header{text-align:center;margin-bottom:3.5rem}
.scope-header .section-subtitle{margin:0 auto}
.scope-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem}
.scope-card{
background:var(--bg-card);
border:1px solid var(--border);
border-radius:16px;overflow:hidden;
transition:all 0.4s;
padding:2rem;
}
.scope-card:hover{border-color:var(--gold-border);box-shadow:var(--shadow-lg)}
.scope-icon{
width:56px;height:56px;border-radius:12px;
background:var(--gold-dim);border:1px solid var(--gold-border);
display:flex;align-items:center;justify-content:center;
margin-bottom:1.2rem;
font-size:1.5rem;
}
.scope-card h3{
font-family:var(--font-heading);font-size:1.15rem;font-weight:700;
margin-bottom:0.5rem;color:var(--text-dark);
}
.scope-card p{font-size:0.88rem;color:var(--text-mid);line-height:1.65}

/* ===== DARK SECTION - ISRAELI MODEL ===== */
.model{padding:5rem 0;background:var(--bg-dark);color:#fff}
.model .section-label{color:var(--gold-bright)}
.model .section-title{color:#fff}
.model-grid{display:grid;grid-template-columns:1fr 1fr;gap:3rem;margin-top:2rem}
.model-cards{display:flex;flex-direction:column;gap:1rem}
.model-card{
background:rgba(255,255,255,0.05);
border:1px solid rgba(255,255,255,0.08);
border-radius:12px;padding:1.4rem;
transition:all 0.3s;
}
.model-card:hover{background:rgba(255,255,255,0.08);border-color:rgba(37,99,235,0.3)}
.model-card h3{font-family:var(--font-heading);font-size:1.1rem;font-weight:600;margin-bottom:0.4rem;color:#fff}
.model-card p{font-size:0.9rem;color:rgba(255,255,255,0.65);line-height:1.7}
.model-right{display:flex;flex-direction:column;gap:1.2rem}
.model-image{border-radius:12px;overflow:hidden;height:240px;position:relative}
.model-image img{width:100%;height:100%;object-fit:cover}
.compare-box{
background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);
border-radius:12px;padding:1.4rem;
}
.compare-box h3{font-family:var(--font-heading);font-size:1rem;font-weight:600;margin-bottom:1rem;color:var(--gold-bright)}
.cmp-row{display:flex;justify-content:space-between;align-items:center;padding:0.7rem 0;border-bottom:1px solid rgba(255,255,255,0.06)}
.cmp-row:last-child{border-bottom:none}
.cmp-label{font-size:0.82rem;color:rgba(255,255,255,0.6);flex:1}
.cmp-val{
font-family:var(--font-heading);font-weight:700;font-size:0.85rem;
padding:0.25rem 0.7rem;border-radius:6px;
}
.cmp-val.green{color:#4ade80;background:rgba(74,222,128,0.1)}
.cmp-val.red{color:#f87171;background:rgba(248,113,113,0.1)}

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
.hero h1{font-size:4.5rem}
.hero-stat{padding:1.5rem 1.5rem}
.hero-stat-num{font-size:2.4rem}
.overview-top{grid-template-columns:1fr}
.scope-grid{grid-template-columns:1fr}
.model-grid{grid-template-columns:1fr}
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
.overview,.scope,.model,.process,.contact{padding:2.5rem 0}
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
.scope-grid{gap:1.5rem;grid-template-columns:1fr}
.model-grid{gap:1.5rem;grid-template-columns:1fr}
.timeline{gap:1.5rem;grid-template-columns:1fr}
.contact-grid{gap:1.5rem;grid-template-columns:1fr}
.contact-form-box{padding:1.5rem}



div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr !important}
div[style*="grid-template-columns:repeat(6"]{grid-template-columns:1fr !important}

.nav-links{display:none}
.hamburger{display:flex}
.hamburger span{background:var(--text-dark)!important}
.hero h1{font-size:3rem}
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
.model-cards{flex-direction:column}
.cmp-row{flex-direction:column;gap:0.8rem;border-bottom:1px solid rgba(255,255,255,0.06) !important;padding:0.8rem 0 !important}
.cmp-label{margin-bottom:0.3rem}

.timeline{grid-template-columns:1fr;max-width:300px;margin:0 auto}
.hero-stats{flex-direction:row;flex-wrap:wrap}
.hero-stat{flex:1 1 50%;border-bottom:1px solid rgba(255,255,255,0.1);padding:1.2rem 1rem}
.hero-stat-num{font-size:2rem}
#strategy div[style*="grid-template-columns:repeat(3"]{grid-template-columns:1fr !important}
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
<svg viewBox="0 0 40 40" fill="none"><path d="M20 2L36 11V29L20 38L4 29V11L20 2Z" stroke="#3b82f6" stroke-width="1.5" fill="rgba(37,99,235,0.1)"/><path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" stroke="#3b82f6" stroke-width="1" fill="none"/><line x1="20" y1="14" x2="20" y2="26" stroke="#3b82f6" stroke-width="1"/><line x1="14" y1="18" x2="26" y2="18" stroke="#3b82f6" stroke-width="0.8"/><line x1="14" y1="22" x2="26" y2="22" stroke="#3b82f6" stroke-width="0.8"/></svg>
<div class="nav-logo-text">Fort<span>line</span></div>
</a>
<div class="nav-links">
<a href="<?php echo home_url('/'); ?>#pillars">Solutions</a>
<a href="<?php echo home_url('/facility-assessment/'); ?>">Protection Advisory</a>
<a href="<?php echo home_url('/execution/'); ?>">Execution</a>
<a href="<?php echo home_url('/national-planning/'); ?>">National Regulation</a>
<a href="<?php echo home_url('/unique-technology/'); ?>">Unique Tech</a>
<a href="<?php echo home_url('/customers/'); ?>">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>">About</a>
<a href="<?php echo home_url('/articles/'); ?>">Articles</a>
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
<a href="<?php echo home_url('/unique-technology/'); ?>" onclick="this.parentElement.classList.remove('open')">Unique Tech</a>
<a href="<?php echo home_url('/customers/'); ?>" onclick="this.parentElement.classList.remove('open')">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>" onclick="this.parentElement.classList.remove('open')">About</a>
<a href="<?php echo home_url('/articles/'); ?>" onclick="this.parentElement.classList.remove('open')">Articles</a>
<a href="<?php echo home_url('/customers/'); ?>#contact" onclick="this.parentElement.classList.remove('open')" class="btn-gold" style="margin-top:1rem">Contact Us</a>
</div>
<!-- ===== HERO ===== -->
<section class="hero" id="hero">
<div class="hero-video-wrap">
<video autoplay muted loop playsinline>
<source src="<?php echo get_template_directory_uri(); ?>/images/national-bg.mp4" type="video/mp4">
</video>
</div>

<div class="hero-breadcrumb fade-in">
<a href="<?php echo home_url('/'); ?>">Home</a><span>/</span>
<a href="<?php echo home_url('/'); ?>#pillars">Defense Solutions</a><span>/</span>
<strong style="color:#fff">NATIONAL REGULATION ADVISORY</strong>
</div>

<div class="hero-content">
<div class="hero-left fade-in fade-in-delay-2">
<div class="defense-badges">
<div class="defense-badge gold-badge">
<span class="defense-badge-text">Government Advisory</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">National-Scale Programs</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Civil Defense Framework</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Israeli Model Transfer</span>
</div>
</div>
</div>

<div class="hero-right">
<h1 class="fade-in">
National Regulation<span class="red-dot">.</span>
</h1>
<p class="hero-sub fade-in fade-in-delay-1">
Government-Level Service<br>Developing Mandatory Protection Building Codes
</p>
<div class="hero-btns fade-in fade-in-delay-3">
<a href="#contact" class="btn-gold">Start a Conversation</a>
<a href="#overview" class="btn-white">Our Framework &rarr;</a>
</div>
</div>
</div>

<div class="hero-stats fade-in fade-in-delay-3">
<div class="hero-stat">
<div class="hero-stat-num" data-count="25" data-suffix="+">0</div>
<div class="hero-stat-label">Years Home Front<br>Command Experience</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num" data-count="15" data-suffix=",000+">0</div>
<div class="hero-stat-label">Protected Spaces<br>Delivered Nationally</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num" data-count="350" data-suffix="+">0</div>
<div class="hero-stat-label">Schools &amp; Public<br>Buildings Protected</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num">9M</div>
<div class="hero-stat-label">Citizens Under<br>Israeli Shelter System</div>
</div>
</div>
</section>

<!-- ===== NATIONAL CIVIL PROTECTION STRATEGY ===== -->
<section style="padding:5rem 0;background:var(--bg-dark);position:relative;overflow:hidden" id="strategy">
<div style="position:absolute;top:0;left:0;right:0;bottom:0;opacity:0.04;background:url('https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=1200&q=60') center/cover no-repeat"></div>
<div class="container" style="position:relative;z-index:1">
  <div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)">National Strategy</div>
  <div class="section-title fade-in" style="text-align:center;color:#fff;max-width:900px;margin:0 auto 1rem">National Civil Protection Strategy</div>
  <p class="fade-in" style="color:rgba(255,255,255,0.5);text-align:center;font-size:0.82rem;text-transform:uppercase;letter-spacing:2px;font-weight:600;margin-bottom:2.5rem">Protecting Populations and Critical Infrastructure</p>

  <div style="max-width:800px;margin:0 auto 3rem;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:2.5rem;text-align:center">
    <p class="fade-in" style="font-size:1.1rem;color:rgba(255,255,255,0.85);line-height:1.8;font-weight:400">Countries facing evolving missile and drone threats should consider establishing a <strong style="color:#fff;font-weight:700">National Civil Protection and Protective Infrastructure Program</strong> built on six key pillars.</p>
  </div>

  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;margin-bottom:2.5rem">
    <div class="fade-in" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-top:3px solid var(--gold-bright);border-radius:0 0 12px 12px;padding:1.5rem;text-align:left">
            <h4 style="font-family:var(--font-heading);font-size:0.9rem;color:#fff;margin-bottom:0.4rem">Mandatory Regulations</h4>
      <p style="font-size:0.8rem;color:rgba(255,255,255,0.5);line-height:1.5">Protection building codes integrated into national construction law</p>
    </div>
    <div class="fade-in fade-in-delay-1" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-top:3px solid var(--gold-bright);border-radius:0 0 12px 12px;padding:1.5rem;text-align:left">
            <h4 style="font-family:var(--font-heading);font-size:0.9rem;color:#fff;margin-bottom:0.4rem">National Survey</h4>
      <p style="font-size:0.8rem;color:rgba(255,255,255,0.5);line-height:1.5">Comprehensive mapping of protection gaps across all infrastructure</p>
    </div>
    <div class="fade-in fade-in-delay-2" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-top:3px solid var(--gold-bright);border-radius:0 0 12px 12px;padding:1.5rem;text-align:left">
            <h4 style="font-family:var(--font-heading);font-size:0.9rem;color:#fff;margin-bottom:0.4rem">Structural Upgrades</h4>
      <p style="font-size:0.8rem;color:rgba(255,255,255,0.5);line-height:1.5">Protection upgrades for existing buildings and critical facilities</p>
    </div>
    <div class="fade-in" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-top:3px solid var(--gold-bright);border-radius:0 0 12px 12px;padding:1.5rem;text-align:left">
            <h4 style="font-family:var(--font-heading);font-size:0.9rem;color:#fff;margin-bottom:0.4rem">Municipal Programs</h4>
      <p style="font-size:0.8rem;color:rgba(255,255,255,0.5);line-height:1.5">Local civil defense preparedness and emergency management systems</p>
    </div>
    <div class="fade-in fade-in-delay-1" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-top:3px solid var(--gold-bright);border-radius:0 0 12px 12px;padding:1.5rem;text-align:left">
            <h4 style="font-family:var(--font-heading);font-size:0.9rem;color:#fff;margin-bottom:0.4rem">Training &amp; Awareness</h4>
      <p style="font-size:0.8rem;color:rgba(255,255,255,0.5);line-height:1.5">Professional capacity building and public preparedness culture</p>
    </div>
    <div class="fade-in fade-in-delay-2" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-top:3px solid var(--gold-bright);border-radius:0 0 12px 12px;padding:1.5rem;text-align:left">
            <h4 style="font-family:var(--font-heading);font-size:0.9rem;color:#fff;margin-bottom:0.4rem">National Data System</h4>
      <p style="font-size:0.8rem;color:rgba(255,255,255,0.5);line-height:1.5">Centralized protection infrastructure monitoring and analysis</p>
    </div>
  </div>

  <div class="fade-in" style="text-align:center">
    <a href="#framework" style="display:inline-block;padding:0.7rem 2rem;border:1px solid rgba(255,255,255,0.25);color:rgba(255,255,255,0.85);border-radius:8px;font-size:0.88rem;font-weight:500;transition:all 0.3s;letter-spacing:0.02em" onmouseover="this.style.borderColor='rgba(255,255,255,0.6)';this.style.color='#fff'" onmouseout="this.style.borderColor='rgba(255,255,255,0.25)';this.style.color='rgba(255,255,255,0.85)'">Explore the Full Framework &rarr;</a>
  </div>
</div>
</section>

<!-- ===== OVERVIEW ===== -->
<section class="overview" id="overview">
<div class="container">
<div class="overview-top">
<div class="fade-in">
<div class="overview-badge">
<span class="overview-badge-text">National Regulation Advisory</span>
</div>
<h2>Creating National Regulation: Building Codes Based on Israel's Civil Defense Law</h2>
<p class="overview-text">Israel's Civil Defense Law (enacted 1990/1991) created the world's most comprehensive mandatory building code system for civilian protection. Every new construction must include certified protective infrastructure. The Home Front Command developed the standards, certification processes, and enforcement mechanisms that work at national scale. We help nations develop similar regulatory frameworks—adapted for your specific threat profile and national requirements. This is creating a new regulatory framework from scratch, not just planning.</p>
<div class="overview-features">
<div class="overview-feat">
<h4>Mandatory Building Code Development</h4>
<p>Create national building codes requiring certified protective infrastructure in all new construction</p>
</div>
<div class="overview-feat">
<h4>Emergency Protocol Systems</h4>
<p>Warning systems, public alert infrastructure, and population behavior training programs</p>
</div>
<div class="overview-feat">
<h4>Regulatory Implementation Planning</h4>
<p>Phase-by-phase rollout of building codes, municipal compliance systems, and integration of standards into construction permitting</p>
</div>
<div class="overview-feat">
<h4>Capacity Building</h4>
<p>Training local engineers, inspectors, and civil defense personnel to sustain the program</p>
</div>
</div>
</div>
<div class="fade-in fade-in-delay-1">
<div class="overview-image">
<img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800&q=80" alt="City skyline strategic planning" loading="lazy">
</div>
</div>
</div>
</div>
</section>

<!-- ===== SCOPE OF SERVICES ===== -->
<section class="scope" id="scope">
<div class="container">
<div class="scope-header">
<div class="section-label fade-in">Regulatory Framework</div>
<div class="section-title fade-in">Building Mandatory National Protection Codes</div>
<div class="section-subtitle fade-in fade-in-delay-1">We develop building codes and regulations that make certified protective infrastructure mandatory in all construction—modeled on Israel Civil Defense Law.</div>
</div>
<div class="scope-grid">
<div class="scope-card fade-in">
<div class="scope-icon">&#9881;</div>
<h3>Mandatory Building Code Development</h3>
<p>Develop mandatory shelter requirements integrated into national building codes, following the model of Israel's building code 4422. Create engineering standards, certification processes, and compliance enforcement for all new construction.</p>
</div>
<div class="scope-card fade-in fade-in-delay-1">
<div class="scope-icon">&#9888;</div>
<h3>Early Warning Infrastructure</h3>
<p>Specification and planning for national alert systems, siren coverage mapping, mobile notification systems, and response time optimization based on threat scenarios.</p>
</div>
<div class="scope-card fade-in fade-in-delay-2">
<div class="scope-icon">&#127963;</div>
<h3>Public Shelter Distribution</h3>
<p>Strategic placement of community shelters, underground parking conversions, metro station hardening, and public building designation. Coverage modeling for population density.</p>
</div>
<div class="scope-card fade-in">
<div class="scope-icon">&#128218;</div>
<h3>Public Awareness Programs</h3>
<p>Population education campaigns, school drill programs, workplace emergency training, and public signage systems. Building a culture of preparedness like Israel's.</p>
</div>
<div class="scope-card fade-in fade-in-delay-1">
<div class="scope-icon">&#128736;</div>
<h3>Technical Standards</h3>
<p>Blast resistance specifications, ventilation and filtration requirements, structural reinforcement standards, and door/window protection certifications for protected spaces.</p>
</div>
<div class="scope-card fade-in fade-in-delay-2">
<div class="scope-icon">&#127891;</div>
<h3>Personnel Training</h3>
<p>Train-the-trainer programs for local civil defense, building inspectors, emergency responders, and military engineers. Knowledge transfer for long-term program sustainability.</p>
</div>
</div>
</div>
</section>

<!-- ===== ISRAELI MODEL (DARK) ===== -->
<section class="model" id="model">
<div class="container">
<div class="section-label fade-in">The Israeli Model</div>
<div class="section-title fade-in">Proven Under the Most Demanding Conditions</div>
<div class="model-grid">
<div class="model-cards">
<div class="model-card fade-in">
<h3>Mandatory Protected Spaces</h3>
<p>Every new building in Israel must include certified protected spaces. This regulation, developed over decades of operational experience, ensures universal coverage and has saved thousands of lives.</p>
</div>
<div class="model-card fade-in fade-in-delay-1">
<h3>90-Second Warning Doctrine</h3>
<p>The entire Israeli system is designed around a 90-second warning window. Everything -siren placement, shelter distance, population training -is engineered for this response time.</p>
</div>
<div class="model-card fade-in fade-in-delay-2">
<h3>Continuous Improvement</h3>
<p>After every conflict, the Home Front Command conducts systematic reviews. Protection standards are continuously updated based on real-world performance data -not theoretical models.</p>
</div>
<div class="model-card fade-in fade-in-delay-3">
<h3>Full Population Coverage</h3>
<p>From kibbutzim near the border to high-rise apartments in Tel Aviv -the system covers 9 million citizens across every geography, building type, and population density.</p>
</div>
</div>
<div class="model-right">
<div class="model-image fade-in">
<img src="https://images.unsplash.com/photo-1590069261209-f8e9b8642343?w=800&q=80" alt="Defense systems" loading="lazy">
</div>
<div class="compare-box fade-in fade-in-delay-1">
<h3>Readiness Comparison</h3>
<div class="cmp-row">
<div class="cmp-label">Mandatory shelter building codes</div>
<div class="cmp-val green">Israel: Yes</div>
</div>
<div class="cmp-row">
<div class="cmp-label">National early warning system</div>
<div class="cmp-val green">Israel: Full</div>
</div>
<div class="cmp-row">
<div class="cmp-label">Population drill programs</div>
<div class="cmp-val green">Israel: Annual</div>
</div>
<div class="cmp-row">
<div class="cmp-label">Gulf region shelter mandates</div>
<div class="cmp-val red">None</div>
</div>
<div class="cmp-row">
<div class="cmp-label">Gulf population training</div>
<div class="cmp-val red">Minimal</div>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- ===== 6-PILLAR FRAMEWORK ===== -->
<section style="padding:5rem 0;background:var(--bg-section)" id="framework">
<div class="container">
<div class="section-label fade-in" style="text-align:center">The Framework</div>
<div class="section-title fade-in" style="text-align:center">Six Pillars of National Regulation Framework</div>
<div style="max-width:700px;margin:0.5rem auto 3rem;text-align:center;color:var(--text-light);font-size:0.95rem" class="fade-in">Based on Israel's Civil Defense Law, we help nations develop mandatory regulatory frameworks with six key pillars that ensure every new construction includes certified protective infrastructure.</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-bottom:4rem">
<div style="background:#fff;border-radius:12px;padding:2rem;box-shadow:var(--shadow);border-top:3px solid var(--gold)" class="fade-in">
<div style="font-size:2rem;font-weight:800;color:var(--gold-border);font-family:var(--font-heading);margin-bottom:0.5rem">01</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;margin-bottom:0.8rem;color:var(--text-dark)">National Protection Regulations</h4>
<p style="font-size:0.88rem;color:var(--text-mid);line-height:1.6">Establish a national regulatory framework integrated into building codes: mandatory protected spaces, engineering standards for blast and fragmentation, and protection requirements for public buildings and critical infrastructure.</p>
</div>
<div style="background:#fff;border-radius:12px;padding:2rem;box-shadow:var(--shadow);border-top:3px solid var(--gold)" class="fade-in fade-in-delay-1">
<div style="font-size:2rem;font-weight:800;color:var(--gold-border);font-family:var(--font-heading);margin-bottom:0.5rem">02</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;margin-bottom:0.8rem;color:var(--text-dark)">National Survey of Protection Gaps</h4>
<p style="font-size:0.88rem;color:var(--text-mid);line-height:1.6">Conduct comprehensive mapping of shelters and protected spaces, vulnerability analysis of critical infrastructure, identification of urban protection gaps, and national prioritization of investments.</p>
</div>
<div style="background:#fff;border-radius:12px;padding:2rem;box-shadow:var(--shadow);border-top:3px solid var(--gold)" class="fade-in fade-in-delay-2">
<div style="font-size:2rem;font-weight:800;color:var(--gold-border);font-family:var(--font-heading);margin-bottom:0.5rem">03</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;margin-bottom:0.8rem;color:var(--text-dark)">Protection Upgrades for Existing Structures</h4>
<p style="font-size:0.88rem;color:var(--text-mid);line-height:1.6">Implement programs to improve protection in existing buildings: structural reinforcement, installation of external protection elements, conversion of spaces into shelters, and deployment of modular systems like Shield 6000.</p>
</div>
<div style="background:#fff;border-radius:12px;padding:2rem;box-shadow:var(--shadow);border-top:3px solid var(--gold)" class="fade-in">
<div style="font-size:2rem;font-weight:800;color:var(--gold-border);font-family:var(--font-heading);margin-bottom:0.5rem">04</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;margin-bottom:0.8rem;color:var(--text-dark)">Municipal Civil Defense Programs</h4>
<p style="font-size:0.88rem;color:var(--text-mid);line-height:1.6">Strengthen local authorities with protection mapping, emergency preparedness plans, public shelter management systems, and civilian preparedness programs at the municipal level.</p>
</div>
<div style="background:#fff;border-radius:12px;padding:2rem;box-shadow:var(--shadow);border-top:3px solid var(--gold)" class="fade-in fade-in-delay-1">
<div style="font-size:2rem;font-weight:800;color:var(--gold-border);font-family:var(--font-heading);margin-bottom:0.5rem">05</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;margin-bottom:0.8rem;color:var(--text-dark)">Training &amp; Public Awareness</h4>
<p style="font-size:0.88rem;color:var(--text-mid);line-height:1.6">Professional training for civil defense personnel and emergency responders, combined with public education campaigns to build a culture of preparedness across all segments of society.</p>
</div>
<div style="background:#fff;border-radius:12px;padding:2rem;box-shadow:var(--shadow);border-top:3px solid var(--gold)" class="fade-in fade-in-delay-2">
<div style="font-size:2rem;font-weight:800;color:var(--gold-border);font-family:var(--font-heading);margin-bottom:0.5rem">06</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;margin-bottom:0.8rem;color:var(--text-dark)">National Protection Data System</h4>
<p style="font-size:0.88rem;color:var(--text-mid);line-height:1.6">Develop a centralized national protection database providing real-time infrastructure mapping, vulnerability analysis, prioritization models, and monitoring of protection investments and implementation.</p>
</div>
</div>

<!-- 3-Phase Implementation -->
<div style="background:var(--bg-dark);border-radius:16px;padding:3rem;color:#fff">
<h3 style="font-family:var(--font-heading);font-size:1.4rem;font-weight:700;text-align:center;margin-bottom:2rem" class="fade-in">Three-Phase Implementation Strategy</h3>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2rem" class="fade-in">
<div style="border-left:3px solid var(--gold-bright);padding-left:1.5rem">
<div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--gold-bright);margin-bottom:0.5rem">Phase 1</div>
<h4 style="font-size:1.1rem;margin-bottom:0.8rem">National Assessment</h4>
<p style="font-size:0.88rem;color:rgba(255,255,255,0.7);line-height:1.6">Nationwide protection surveys, risk and vulnerability mapping, and development of the regulatory framework.</p>
</div>
<div style="border-left:3px solid var(--gold-bright);padding-left:1.5rem">
<div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--gold-bright);margin-bottom:0.5rem">Phase 2</div>
<h4 style="font-size:1.1rem;margin-bottom:0.8rem">Infrastructure Development</h4>
<p style="font-size:0.88rem;color:rgba(255,255,255,0.7);line-height:1.6">Large-scale protection upgrades, integration of standards into construction, and implementation of municipal civil defense programs.</p>
</div>
<div style="border-left:3px solid var(--gold-bright);padding-left:1.5rem">
<div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.12em;color:var(--gold-bright);margin-bottom:0.5rem">Phase 3</div>
<h4 style="font-size:1.1rem;margin-bottom:0.8rem">Long-Term National Resilience</h4>
<p style="font-size:0.88rem;color:rgba(255,255,255,0.7);line-height:1.6">Continuous infrastructure upgrades, integration of new protection technologies, and alignment with national security and defense planning.</p>
</div>
</div>
</div>
</div>
</section>

<!-- ===== STRATEGIC BENEFITS ===== -->
<section style="padding:4rem 0;background:#fff" id="benefits">
<div class="container">
<div class="section-label fade-in" style="text-align:center">Strategic Impact</div>
<div class="section-title fade-in" style="text-align:center">What This Framework Delivers for Your Nation</div>
<p class="fade-in" style="color:var(--text-light);max-width:700px;margin:0.5rem auto 2.5rem;font-size:0.95rem;text-align:center">Implementation of this framework enables countries to achieve measurable strategic outcomes that protect populations and strengthen national standing.</p>

<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:1rem" class="fade-in">
<div style="background:var(--bg-section);border-radius:12px;padding:1.5rem;text-align:center">
<div style="font-size:1.5rem;margin-bottom:0.6rem">&#128737;</div>
<h4 style="font-family:var(--font-heading);font-size:0.85rem;margin-bottom:0.4rem;color:var(--text-dark)">Reduce Civilian Casualties</h4>
<p style="font-size:0.78rem;color:var(--text-mid);line-height:1.5">During missile and drone attacks through proven passive protection</p>
</div>
<div style="background:var(--bg-section);border-radius:12px;padding:1.5rem;text-align:center">
<div style="font-size:1.5rem;margin-bottom:0.6rem">&#9881;</div>
<h4 style="font-family:var(--font-heading);font-size:0.85rem;margin-bottom:0.4rem;color:var(--text-dark)">Protect Critical Infrastructure</h4>
<p style="font-size:0.78rem;color:var(--text-mid);line-height:1.5">Safeguard energy, transportation, and essential services from disruption</p>
</div>
<div style="background:var(--bg-section);border-radius:12px;padding:1.5rem;text-align:center">
<div style="font-size:1.5rem;margin-bottom:0.6rem">&#127963;</div>
<h4 style="font-family:var(--font-heading);font-size:0.85rem;margin-bottom:0.4rem;color:var(--text-dark)">Municipal Preparedness</h4>
<p style="font-size:0.78rem;color:var(--text-mid);line-height:1.5">Strengthen local response capabilities and emergency management</p>
</div>
<div style="background:var(--bg-section);border-radius:12px;padding:1.5rem;text-align:center">
<div style="font-size:1.5rem;margin-bottom:0.6rem">&#128170;</div>
<h4 style="font-family:var(--font-heading);font-size:0.85rem;margin-bottom:0.4rem;color:var(--text-dark)">National Resilience</h4>
<p style="font-size:0.78rem;color:var(--text-mid);line-height:1.5">Improve continuity during prolonged conflicts and crises</p>
</div>
<div style="background:var(--bg-section);border-radius:12px;padding:1.5rem;text-align:center">
<div style="font-size:1.5rem;margin-bottom:0.6rem">&#128200;</div>
<h4 style="font-family:var(--font-heading);font-size:0.85rem;margin-bottom:0.4rem;color:var(--text-dark)">Economic Continuity</h4>
<p style="font-size:0.78rem;color:var(--text-mid);line-height:1.5">Maintain economic activity and societal function during crises</p>
</div>
</div>
</div>
</section>

<!-- ===== PROCESS ===== -->
<section class="process" id="process">
<div class="container">
<div class="process-header">
<div class="section-label fade-in">Advisory Process</div>
<div class="section-title fade-in">From Assessment to Regulatory Implementation</div>
</div>
<div class="timeline">
<div class="tl-step fade-in">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600&q=80" alt="Government consultation" loading="lazy"></div>
<div class="tl-num">1</div>
<h3>Government Dialogue</h3>
<p>Confidential engagement with national security and civil defense leadership to define scope and objectives.</p>
</div>
<div class="tl-step fade-in fade-in-delay-1">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600&q=80" alt="Assessment study" loading="lazy"></div>
<div class="tl-num">2</div>
<h3>National Assessment</h3>
<p>Comprehensive review of existing infrastructure, threat landscape, population distribution, and regulatory gaps.</p>
</div>
<div class="tl-step fade-in fade-in-delay-2">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&q=80" alt="Strategic plan" loading="lazy"></div>
<div class="tl-num">3</div>
<h3>Regulatory Framework Delivery</h3>
<p>Comprehensive national regulations with mandatory building code standards, compliance mechanisms, implementation timeline, and integration into construction permitting.</p>
</div>
<div class="tl-step fade-in fade-in-delay-3">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&q=80" alt="Ongoing support" loading="lazy"></div>
<div class="tl-num">4</div>
<h3>Regulatory Rollout Advisory</h3>
<p>Ongoing guidance through implementation—training building inspectors, integrating codes into permitting systems, municipal compliance programs, and continuous refinement.</p>
</div>
</div>
</div>
</section>

<!-- ===== CONTACT ===== -->
<section class="contact" id="contact">
<div class="container">
<div class="section-label fade-in">Get Started</div>
<div class="section-title fade-in" style="margin-bottom:2rem">Begin a Strategic Conversation</div>
<div class="contact-grid">
<div class="contact-form-box fade-in">
<form id="contactForm">
<div class="form-row">
<div class="form-group"><label>Full Name *</label><input type="text" name="name" required placeholder="Your full name"></div>
<div class="form-group"><label>Organization / Government Entity</label><input type="text" name="organization" placeholder="Ministry, agency, or organization"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Email Address *</label><input type="email" name="email" required placeholder="you@organization.gov"></div>
<div class="form-group"><label>Phone Number</label><input type="tel" name="phone" placeholder="+971 XX XXX XXXX"></div>
</div>
<div class="form-row">
<div class="form-group">
<label>Scope of Interest</label>
<select name="scope"><option value="">Select scope</option><option>City-level planning</option><option>Regional planning</option><option>National program</option><option>Regulatory framework</option><option>Feasibility study</option><option>Other</option></select>
</div>
<div class="form-group">
<label>Country / Region</label>
<select name="region"><option value="">Select region</option><option>UAE</option><option>Saudi Arabia</option><option>Qatar</option><option>Bahrain</option><option>Kuwait</option><option>Oman</option><option>Southeast Asia</option><option>Other</option></select>
</div>
</div>
<div class="form-group"><label>Message</label><textarea name="message" placeholder="Tell us about your national protection objectives -all communications are conducted under strict confidentiality"></textarea></div>
<button type="submit" class="form-submit">Request Advisory <button type="submit" class="form-submit">Submit Inquiry &rarr;</button>rarr;</button>
</form>
</div>
<div class="contact-info fade-in fade-in-delay-1">
<div class="info-card">
<div><h4>Government-Level Confidentiality</h4><p>All engagements under NDA with government-grade information security protocols.</p></div>
</div>
<div class="info-card">
<div><h4>Direct Senior Access</h4><p>You work directly with our retired Lt. Colonel and senior engineering team -not junior consultants.</p></div>
</div>
<div class="info-card">
<div><h4>Proven Model Transfer</h4><p>We bring the most battle-tested civilian protection program in history to your nation.</p></div>
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
<svg viewBox="0 0 40 40" fill="none"><path d="M20 2L36 11V29L20 38L4 29V11L20 2Z" stroke="#3b82f6" stroke-width="1.5" fill="rgba(37,99,235,0.15)"/><path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" stroke="#3b82f6" stroke-width="1" fill="none"/><line x1="20" y1="14" x2="20" y2="26" stroke="#3b82f6" stroke-width="1"/><line x1="14" y1="18" x2="26" y2="18" stroke="#3b82f6" stroke-width="0.8"/><line x1="14" y1="22" x2="26" y2="22" stroke="#3b82f6" stroke-width="0.8"/></svg>
<div class="footer-logo-text">Fort<span>line</span></div>
</div>
<p class="footer-tagline">Israeli defense-grade protection technology for critical infrastructure worldwide.</p>
</div>
<div class="footer-col">
<h4>Solutions</h4>
<a href="<?php echo home_url('/unique-technology/'); ?>">Unique Tech</a>
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
<p>&copy; 2026 Fortline Global. All rights reserved.</p>
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
scope:form.scope.value,
region:form.region.value,
message:form.message.value
};

emailjs.send('service_py23y6a','template_lgfttoi',{
to_email:'eddie.nudel@gmail.com',
from_name:data.name,
from_email:data.email,
organization:data.organization,
phone:data.phone||'Not provided',
inquiry_type:'Strategic National Shelter Planning',
facility_type:data.scope||'Not specified',
message:data.message||'No message provided',
subject:'National Regulation Advisory Inquiry from '+data.name
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