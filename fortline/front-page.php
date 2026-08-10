<?php
/**
 * Template Name: Home
 * Description: Home page
 */

get_header(); ?>

<style>

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
section[id],div[id]{scroll-margin-top:86px}
.rp-hidden{display:none!important}
.nav-links a.active{color:var(--gold-bright)}
.nav.scrolled .nav-links a.active{color:var(--gold-bright)}
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
.nav-inner{max-width:1320px;margin:0 auto;display:flex;align-items:center;justify-content:flex-start;gap:0.5rem}
.nav-links{margin-inline-start:2rem}
.nav-right{display:flex;align-items:center;gap:0.7rem;margin-inline-start:auto}
.nav-logo{display:flex;align-items:center;gap:0.6rem}
.nav-logo-img{height:40px;width:auto;display:block}.nav-logo-dark{display:none}.nav.scrolled .nav-logo-light{display:none}.nav.scrolled .nav-logo-dark{display:block}.footer-logo-img{height:38px;width:auto;display:block}
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

/* ===== HERO -Rafael Iron Dome Style (Exact Copy) ===== */
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

/* Breadcrumb trail -top left like Rafael */
.hero-breadcrumb{
position:absolute;top:5.5rem;left:2.5rem;z-index:3;
font-size:0.82rem;color:rgba(255,255,255,0.7);
}
.hero-breadcrumb a{color:rgba(255,255,255,0.7);transition:color 0.3s}
.hero-breadcrumb a:hover{color:#fff}
.hero-breadcrumb span{margin:0 0.4rem;opacity:0.5}

/* Hero content -two-column: badges left, text right */
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
.hero h1 .gold{color:var(--gold-bright)}
.hero h1 .red-dot{
color:#e53e3e;
font-weight:400;
}
.hero-sub{
font-size:1.2rem;color:rgba(255,255,255,0.85);line-height:1.6;
max-width:700px;margin:0;font-weight:400;
letter-spacing:0.02em;
}

/* Buttons row -below subtitle */
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

/* Stats bar -pinned to bottom of hero, like Rafael */
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
.hero-stat-num.red{color:#f87171}
.hero-stat-label{font-size:0.88rem;color:rgba(255,255,255,0.7);margin-top:0.3rem;line-height:1.35;font-weight:400}

/* Defense credential badges -vertical column on left */
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
.defense-badge-icon{display:none}
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

.fade-in{opacity:1;transform:translateY(0)}
.fade-in-delay-1{transition-delay:0.12s}
.fade-in-delay-2{transition-delay:0.24s}
.fade-in-delay-3{transition-delay:0.36s}

/* ===== THREE PILLARS / SERVICES ===== */
.pillars{padding:5rem 0;background:var(--bg)}
.pillars-header{text-align:center;margin-bottom:3.5rem}
.pillars-header .section-subtitle{margin:0 auto}

/* ===== OPTION D: Dark Service Cards ===== */
.svc-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem}
.svc-card{
background:var(--bg-dark);border-radius:16px;overflow:hidden;color:#fff;
position:relative;transition:transform 0.3s,box-shadow 0.3s;
}
.svc-card:hover{transform:translateY(-4px);box-shadow:0 20px 50px rgba(0,0,0,0.3)}
.svc-card.primary{background:linear-gradient(135deg,#0f1d32,#1e3a5f);border:1px solid rgba(37,99,235,0.3)}
.svc-card.accent{background:linear-gradient(135deg,#0a1628,#162032)}
.svc-card.govt{background:linear-gradient(135deg,#1a0a0a,#2d1010);border:1px solid rgba(220,38,38,0.2)}
.svc-img{height:200px;overflow:hidden;position:relative}
.svc-img img{width:100%;height:100%;object-fit:cover;opacity:0.45;transition:opacity 0.4s}
.svc-card:hover .svc-img img{opacity:0.6}
.svc-img::after{
content:'';position:absolute;bottom:0;left:0;right:0;height:120px;
background:linear-gradient(transparent,var(--bg-dark));
}
.svc-card.primary .svc-img::after{background:linear-gradient(transparent,#1e3a5f)}
.svc-card.govt .svc-img::after{background:linear-gradient(transparent,#1a0a0a)}
.svc-num{
position:absolute;bottom:0.5rem;left:1.5rem;
font-family:var(--font-heading);font-size:4rem;font-weight:800;
color:rgba(255,255,255,0.08);z-index:2;
}
.svc-body{padding:1.5rem 1.8rem 2rem}
.svc-badge{
display:inline-block;font-size:0.68rem;font-weight:800;letter-spacing:0.12em;
text-transform:uppercase;padding:0.3rem 0.8rem;border-radius:4px;margin-bottom:0.8rem;
}
.svc-badge.blue{background:linear-gradient(90deg,var(--gold-light),var(--gold-bright));color:#fff}
.svc-badge.dark{background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8)}
.svc-badge.red{background:var(--red);color:#fff}
.svc-body h3{
font-family:var(--font-heading);font-size:1.15rem;font-weight:700;
color:#fff;margin-bottom:0.6rem;
}
.svc-body p{font-size:0.85rem;color:rgba(255,255,255,0.65);line-height:1.65;margin-bottom:1rem}
.svc-body ul{list-style:none;margin-bottom:1.2rem}
.svc-body ul li{
font-size:0.82rem;color:rgba(255,255,255,0.65);padding:0.25rem 0 0.25rem 1.5rem;position:relative;
}
.svc-body ul li::before{content:'✓';position:absolute;left:0;color:var(--gold-bright);font-weight:700}
.svc-card.govt .svc-body ul li::before{color:#ef4444}
.svc-body .svc-cta{font-size:0.85rem;font-weight:600;color:var(--gold-bright);transition:all 0.3s}
.svc-body .svc-cta:hover{color:#fff}
.svc-card.govt .svc-cta{color:#ef4444}
.svc-card.govt .svc-cta:hover{color:#ff6b6b}

/* Backward compat placeholder */
.solution-link{
background:var(--bg-card);
border:1px solid var(--border);
border-radius:16px;
overflow:hidden;
transition:all 0.4s;
}
.solution-link:hover{border-color:var(--gold-border);box-shadow:var(--shadow-lg)}
.solution-link-img{height:180px;overflow:hidden;position:relative}
.solution-link-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s}
.solution-link:hover .solution-link-img img{transform:scale(1.06)}
.solution-link-body{padding:1.5rem}
.solution-link-body h4{
font-family:var(--font-heading);
font-size:1.1rem;
font-weight:700;
color:var(--text-dark);
margin-bottom:0.4rem;
}
.solution-link-body p{
font-size:0.85rem;
color:var(--text-mid);
line-height:1.5;
margin-bottom:1rem;
}
.solution-link-body a{
font-size:0.85rem;
font-weight:600;
color:var(--gold);
}
.solution-link-body a:hover{color:var(--gold-bright)}

/* Old pillar styles kept for backward compatibility */
.pillar-card{
background:var(--bg-card);
border:1px solid var(--border);
border-radius:16px;overflow:hidden;
transition:all 0.4s;
position:relative;
}
.pillar-card:hover{border-color:var(--gold-border);box-shadow:var(--shadow-lg)}
.pillar-card.featured{border:2px solid var(--gold-light)}
.pillar-card.featured::before{
content:'PATENTED TECHNOLOGY';
position:absolute;top:0;left:0;right:0;
background:linear-gradient(90deg,var(--gold-light),var(--gold-bright));
color:#fff;
font-size:0.75rem;font-weight:800;letter-spacing:0.15em;
text-align:center;padding:0.45rem;
z-index:2;
}
.pillar-img{height:260px;overflow:hidden;position:relative}
.pillar-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s}
.pillar-card:hover .pillar-img img{transform:scale(1.06)}
.pillar-num{
position:absolute;bottom:1rem;left:1rem;
font-family:var(--font-heading);font-size:5rem;font-weight:800;
line-height:1;color:rgba(255,255,255,0.15);
}
.pillar-body{padding:1.8rem}
.pillar-body h3{
font-family:var(--font-heading);font-size:1.3rem;font-weight:700;
margin-bottom:0.6rem;color:var(--text-dark);
}
.pillar-body p{font-size:0.92rem;color:var(--text-mid);line-height:1.7;margin-bottom:1.2rem}
.pillar-tags{display:flex;flex-wrap:wrap;gap:0.4rem}
.pillar-tag{
font-size:0.75rem;color:var(--gold);font-weight:600;
background:var(--gold-dim);border:1px solid var(--gold-border);
padding:0.25rem 0.7rem;border-radius:4px;
}

/* ===== SHIELD 6000 DEEP DIVE ===== */
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
.ba-tag.after{background:var(--gold-light);color:var(--bg-dark)}

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

/* ===== THREAT ===== */
.threat{padding:5rem 0;background:var(--bg-dark);color:#fff}
.threat .section-label{color:var(--gold-bright)}
.threat .section-title{color:#fff}
.threat-grid{display:grid;grid-template-columns:1fr 1fr;gap:3rem}
.threat-cards{display:flex;flex-direction:column;gap:1rem}
.threat-card{
background:rgba(255,255,255,0.05);
border:1px solid rgba(255,255,255,0.08);
border-radius:12px;padding:1.4rem;
transition:all 0.3s;
}
.threat-card:hover{background:rgba(255,255,255,0.08);border-color:rgba(37,99,235,0.3)}
.threat-card h3{font-family:var(--font-heading);font-size:1.1rem;font-weight:600;margin-bottom:0.4rem;color:#fff}
.threat-card p{font-size:0.9rem;color:rgba(255,255,255,0.65);line-height:1.7}

.threat-right{display:flex;flex-direction:column}
.threat-image{border-radius:12px;overflow:hidden;height:100%;position:relative}
.threat-image img{width:100%;height:100%;object-fit:cover}
.gap-box{
background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);
border-radius:12px;padding:1.4rem;
}
.gap-box h3{font-family:var(--font-heading);font-size:1rem;font-weight:600;margin-bottom:1rem;color:var(--gold-bright)}
.gap-row{display:flex;justify-content:space-between;align-items:center;padding:0.7rem 0;border-bottom:1px solid rgba(255,255,255,0.06)}
.gap-row:last-child{border-bottom:none}
.gap-label{font-size:0.82rem;color:rgba(255,255,255,0.6);flex:1}
.gap-val{
font-family:var(--font-heading);font-weight:700;font-size:0.95rem;
padding:0.25rem 0.7rem;border-radius:6px;
}
.gap-val.green{color:#4ade80;background:rgba(74,222,128,0.1)}
.gap-val.red{color:#f87171;background:rgba(248,113,113,0.1)}

/* ===== CREDENTIALS ===== */
.credentials{padding:5rem 0;background:var(--bg)}
.cred-grid{display:grid;grid-template-columns:1fr 1fr;gap:3rem}
.cred-cards{display:flex;flex-direction:column;gap:1rem}
.cred-card{
background:var(--bg-card);border:1px solid var(--border);
border-radius:12px;padding:1.5rem;
transition:all 0.3s;box-shadow:var(--shadow);
}
.cred-card:hover{border-color:var(--gold-border);box-shadow:var(--shadow-md)}
.cred-card h3{
font-family:var(--font-heading);font-size:1.1rem;font-weight:600;
margin-bottom:0.5rem;
color:var(--text-dark);
}
.cred-card p{font-size:0.9rem;color:var(--text-mid);line-height:1.65}
.cred-stats{display:flex;gap:1.5rem;margin-top:0.7rem;padding-top:0.7rem;border-top:1px solid var(--border)}
.cred-stat{font-size:0.8rem;color:var(--gold);font-weight:700}
.cred-right{display:flex;flex-direction:column;gap:1rem}
.cred-image{border-radius:12px;overflow:hidden;height:220px}
.cred-image img{width:100%;height:100%;object-fit:cover}
.cert-box{
background:var(--bg-card);border:1px solid var(--gold-border);
border-left:3px solid var(--gold-light);
border-radius:0 10px 10px 0;padding:1.1rem 1.4rem;
box-shadow:var(--shadow);
}
.cert-box h4{font-size:0.95rem;font-weight:600;color:var(--gold);margin-bottom:0.3rem}
.cert-box p{font-size:0.85rem;color:var(--text-mid);line-height:1.55}

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
.hero h1{font-size:5rem}
.hero-stat{padding:1.5rem 1.5rem}
.hero-stat-num{font-size:2.4rem}
.pillars-grid{grid-template-columns:1fr}
.svc-grid{grid-template-columns:1fr}
.solution-links{grid-template-columns:1fr}
.shield-top{grid-template-columns:1fr}
.vid-gallery{grid-template-columns:1fr}
.threat-grid{grid-template-columns:1fr}
.cred-grid{grid-template-columns:1fr}
.timeline{grid-template-columns:repeat(2,1fr);gap:2.5rem}
.timeline::before{display:none}
.contact-grid{grid-template-columns:1fr}
.hero-stats{flex-wrap:wrap}
.hero-stat{min-width:50%;border-bottom:1px solid rgba(255,255,255,0.1)}
}
/* Areas of Activity responsive */
@media(max-width:1024px){
.areas-grid{grid-template-columns:1fr 1fr !important}
}
@media(max-width:480px){
.areas-grid{grid-template-columns:1fr !important}
}
@media(max-width:768px){
.footer-inner{grid-template-columns:1fr 1fr;gap:2rem}
.footer-brand{grid-column:1/-1}

.container{padding:0 1.2rem}
.nav{background:#fff!important;box-shadow:0 1px 4px rgba(0,0,0,0.08)}.nav .nav-logo-light{display:none}.nav .nav-logo-dark{display:block}
.nav-logo-text{color:var(--text-dark)!important}
.nav-links{display:none}
.hamburger{display:flex}
.hamburger span{background:var(--text-dark)!important}
#why .container > div[style*="grid-template-columns"]{grid-template-columns:1fr !important;gap:1.5rem !important}
#why .container > div[style*="grid-template-columns"] > div:first-child > div > div[style*="flex"]{gap:0.8rem !important;margin-bottom:1.2rem !important}
#why .container > div[style*="grid-template-columns"] > div:first-child h3{font-size:0.95rem !important}
#why .container > div[style*="grid-template-columns"] > div:first-child p{font-size:0.82rem !important}
#why .container > div[style*="grid-template-columns"] > div:last-child{padding:1.5rem !important}
#why .container > div[style*="grid-template-columns"] > div:last-child div[style*="font-size:2rem"]{font-size:1.5rem !important;min-width:45px !important}
#benefits .container > div[style*="grid-template-columns"]{grid-template-columns:1fr !important}
.pillars{padding:2.5rem 0}
.shield{padding:2.5rem 0}
.threat{padding:2.5rem 0}
.credentials{padding:2.5rem 0}
.process{padding:2.5rem 0}
.contact{padding:2.5rem 0}
.hero{min-height:auto;padding:6rem 0 0;background:var(--bg-dark)}
.hero h1{font-size:2.2rem}
.hero-stat-num{font-size:1.6rem}
.hero-stats{gap:0;flex-direction:row;flex-wrap:wrap;position:relative}
.hero-stat{flex:1 1 50%;border-bottom:1px solid rgba(255,255,255,0.1);padding:1rem}
.hero-stat-label{font-size:0.72rem}
.section-title{font-size:1.8rem}
.section-subtitle{max-width:100%;font-size:0.95rem}
.hero-sub{font-size:0.9rem}
.hero-sub br{display:none}
.hero-breadcrumb{display:none}
.hero-content{flex-direction:column;align-items:flex-start;gap:1.5rem;padding-bottom:1.5rem}
.hero-left{display:none!important}
.hero-left a,.hero-left span{font-size:0.7rem;padding:0.4rem 0.8rem}
.hero-right{text-align:left;order:1}
.hero-btns{display:flex!important;flex-direction:column;gap:0.8rem;align-items:stretch}
.hero-mobile-cta{display:none!important}
.hero-btns .btn-gold,.hero-btns .btn-white{width:100%;text-align:center}
.hero-btns .btn-white{display:none}
.defense-badges{flex-direction:row;flex-wrap:wrap;gap:0.5rem}
.shield-features{grid-template-columns:1fr}
.shield-top{grid-template-columns:1fr}
.shield-video{margin-top:1.5rem}
.ba-row{grid-template-columns:1fr}
.ba-item{height:280px}
.form-row{grid-template-columns:1fr}
.contact-form-box{padding:1.5rem}
.contact-grid{grid-template-columns:1fr}


.svc-grid{grid-template-columns:1fr}
.svc-num{font-size:3rem}
.vid-gallery{grid-template-columns:1fr}
.vid-card{margin-bottom:1rem}
.threat-grid{grid-template-columns:1fr}
.threat-right{display:flex;flex-direction:column}
.threat-cards{margin-bottom:1.5rem}
.cred-grid{grid-template-columns:1fr;gap:1.5rem}
.cred-right{margin-top:1.5rem}
.cred-stats{gap:1rem}
.timeline{grid-template-columns:repeat(2,1fr);gap:1.5rem;max-width:none;margin:0 auto}
.timeline::before{display:none}
.tl-step p{max-width:100%}
.gap-row{flex-direction:column;align-items:flex-start;padding:1rem 0}
.gap-label{margin-bottom:0.5rem}
.wws-panel.active{grid-template-columns:1fr !important}
.wws-visual{margin-top:1.5rem}
.wws-visual img{width:100%;aspect-ratio:16/9;object-fit:cover}
.wws-tabs{flex-direction:column;border-bottom:none;gap:0.3rem}
.wws-tab{border-bottom:none;border-left:3px solid transparent;text-align:left;padding:0.6rem 1rem}
.wws-tab.active{border-left-color:var(--gold-light);background:var(--gold-dim);border-radius:0 8px 8px 0}

.pillar-num{font-size:3rem}
.pillar-tags{gap:0.3rem}
.shield-certs{flex-wrap:wrap;gap:0.6rem}
.cred-stats{flex-direction:column}
}

@media(max-width:480px){
.footer-inner{grid-template-columns:1fr}

.hero h1{font-size:1.8rem;margin-bottom:0.8rem}
.hero-stat-num{font-size:1.3rem}
.hero-stat{flex:1 1 50%;padding:0.8rem}
.hero-stat-label{font-size:0.7rem}
.hero-sub{font-size:0.88rem}
.hero-left a,.hero-left span{font-size:0.65rem;padding:0.35rem 0.7rem}
.section-title{font-size:1.5rem}
.section-label{font-size:0.7rem}
#benefits .container > div[style*="grid-template-columns"]{grid-template-columns:1fr !important}
#why .container > div[style*="grid-template-columns"]{grid-template-columns:1fr !important}
#why .container > div[style*="grid-template-columns"] > div:last-child{padding:1.5rem !important}
#why .container > div[style*="grid-template-columns"] div[style*="font-size:2rem"]{font-size:1.4rem !important;min-width:40px !important}
#why .section-title{font-size:1.3rem !important}
.timeline{grid-template-columns:1fr}
.timeline::before{display:none}
.tl-step h3{font-size:0.95rem}
.tl-step p{font-size:0.8rem}
.container{padding:0 1rem}
.pillars{padding:1.5rem 0}
.shield{padding:1.5rem 0}
.threat{padding:1.5rem 0}
.credentials{padding:1.5rem 0}
.process{padding:1.5rem 0}
.contact{padding:1.5rem 0}
.shield h2{font-size:1.8rem}
.threat-card h3{font-size:1rem}
.threat-card p{font-size:0.85rem}
.cred-card h3{font-size:1rem}
.cred-card p{font-size:0.85rem}
.svc-body h3{font-size:1rem}
.svc-body p{font-size:0.8rem}
.svc-num{font-size:2.5rem}
.pillar-num{font-size:2.5rem}
.hero-stat{padding:0.8rem 0.5rem}
.hero-stat-num{font-size:1.4rem}
.shield-feat h4{font-size:0.9rem}
.shield-feat p{font-size:0.8rem}
.shield-features{gap:0.6rem}
.info-card h4{font-size:0.9rem}
.info-card p{font-size:0.8rem}
.contact-form-box{padding:1.2rem}
.form-group label{font-size:0.7rem}
.form-group input,.form-group select,.form-group textarea{font-size:0.8rem;padding:0.6rem 0.8rem}
.form-submit{font-size:0.9rem;padding:0.7rem}
.cert-pill{font-size:0.75rem;padding:0.3rem 0.7rem}
.pillar-tag{font-size:0.7rem;padding:0.2rem 0.6rem}
.hero-btns{gap:0.8rem}
.hero-btns a{font-size:0.9rem;padding:0.7rem 1rem}
}

/* ===== WHO WE SERVE TABS ===== */
.wws-tabs{display:flex;justify-content:center;gap:0;margin-bottom:2.5rem;border-bottom:2px solid #e5e7eb}
.wws-tab{
  padding:0.8rem 2rem;font-family:var(--font-heading);font-size:0.85rem;font-weight:600;
  color:var(--text-mid);cursor:pointer;border:none;background:none;
  border-bottom:3px solid transparent;margin-bottom:-2px;transition:all 0.3s;
}
.wws-tab:hover{color:var(--gold)}
.wws-tab.active{color:var(--gold);border-bottom-color:var(--gold-light)}
.wws-panel{display:none;animation:wwsFadeUp 0.4s ease}
.wws-panel.active{display:grid;grid-template-columns:1fr 1fr;gap:2.5rem;align-items:center}
@keyframes wwsFadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
.wws-content h3{font-family:var(--font-heading);font-size:1.5rem;font-weight:700;margin-bottom:0.8rem;color:var(--text-dark)}
.wws-content p{font-size:0.92rem;color:var(--text-mid);line-height:1.7;margin-bottom:1.2rem}
.wws-tags{display:flex;flex-wrap:wrap;gap:0.4rem;margin-bottom:1.5rem}
.wws-tag{font-size:0.72rem;padding:0.3rem 0.7rem;background:var(--gold-dim);color:var(--gold);border-radius:20px;font-weight:500}
.wws-tag.green{background:rgba(22,163,74,0.06);color:#16a34a}
.wws-features{list-style:none;margin-bottom:1.5rem}
.wws-features li{font-size:0.88rem;color:var(--text-mid);padding:0.35rem 0;padding-left:1.2rem;position:relative}
.wws-features li::before{content:'→';position:absolute;left:0;color:var(--gold-light);font-weight:600}
.wws-features.green li::before{color:#16a34a}
.wws-cta{display:inline-block;padding:0.6rem 1.5rem;background:var(--gold);color:#fff;border-radius:8px;font-size:0.85rem;font-weight:600;text-decoration:none;transition:all 0.3s}
.wws-cta:hover{background:var(--gold-light);transform:translateY(-1px)}
.wws-cta.green{background:#16a34a}
.wws-cta.green:hover{background:#15803d}
.wws-visual{border-radius:16px;overflow:hidden;aspect-ratio:4/3;background:#e5e7eb;position:relative}
.wws-visual img{width:100%;height:100%;object-fit:cover}
.wws-badge{position:absolute;top:1rem;left:1rem;background:rgba(10,22,40,0.85);color:#fff;padding:0.4rem 1rem;border-radius:8px;font-size:0.72rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;font-family:var(--font-heading)}
.wws-badge.green{background:rgba(22,163,74,0.85)}
@media(max-width:1024px){
.wws-panel.active{grid-template-columns:1fr}
.wws-visual{max-height:300px}
}
@media(max-width:768px){
.wws-tabs{flex-direction:column;border-bottom:none;gap:0.3rem}
.wws-tab{border-bottom:none;border-left:3px solid transparent;text-align:left;padding:0.6rem 1rem}
.wws-tab.active{border-left-color:var(--gold-light);background:var(--gold-dim);border-radius:0 8px 8px 0}
}

/* Technology section responsive */
@media(max-width:1024px){
#technology div[style*="grid-template-columns:repeat(3"]{grid-template-columns:1fr !important}
#technology div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr !important}
}
@media(max-width:768px){
#technology div[style*="grid-template-columns:repeat(3"]{grid-template-columns:1fr !important}
#technology div[style*="grid-template-columns:repeat(4"]{grid-template-columns:repeat(2,1fr) !important}
#technology div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr !important}
}
@media(max-width:480px){
#technology div[style*="grid-template-columns:repeat(4"]{grid-template-columns:1fr !important}
}

</style>



<style id="rp-init">section[data-page]:not([data-page="home"]){display:none}</style>
<!-- ===== NAVIGATION ===== -->
<nav class="nav" id="nav">
<div class="nav-inner">
<a href="#home" class="nav-logo" aria-label="A.R.I. Faberman Engineering Solutions Ltd.">
<img src="<?php echo get_template_directory_uri(); ?>/images/brand/ari-logo-horizontal-reversed.svg" alt="A.R.I. Faberman Engineering Solutions Ltd." class="nav-logo-img nav-logo-light">
<img src="<?php echo get_template_directory_uri(); ?>/images/brand/ari-logo-horizontal.svg" alt="" aria-hidden="true" class="nav-logo-img nav-logo-dark">
</a>
<div class="nav-links">
<a href="#services" data-i18n="nav2.services">Services</a>
<a href="#projects" data-i18n="nav2.projects">Projects</a>
<a href="#serve" data-i18n="nav2.serve">Who We Serve</a>
<a href="#about" data-i18n="nav2.about">About</a>
<a href="#faq" data-i18n="nav2.faq">FAQ</a>
</div>
<div class="nav-right">
<div id="lang-toggle"></div>
<a href="#contact" class="nav-cta">Contact Us</a>
</div>
<div class="hamburger" onclick="document.getElementById('mobileMenu').classList.add('open')">
<span></span><span></span><span></span>
</div>
</div>
</nav>

<div class="mobile-menu" id="mobileMenu">
<div class="mobile-close" onclick="this.parentElement.classList.remove('open')">&times;</div>
<a href="#services" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.services">Services</a>
<a href="#projects" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.projects">Projects</a>
<a href="#serve" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.serve">Who We Serve</a>
<a href="#about" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.about">About</a>
<a href="#faq" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.faq">FAQ</a>
<a href="#contact" onclick="this.parentElement.classList.remove('open')" class="btn-gold" style="margin-top:1rem">Contact Us</a>
</div>
<!-- ===== HERO -Company Level ===== -->
<section class="hero" id="hero" data-page="home">
<div class="hero-video-wrap">
<video autoplay muted loop playsinline>
<source src="<?php echo get_template_directory_uri(); ?>/images/Backgroundf.mp4" type="video/mp4">
</video>
</div>

<div class="hero-content">
<!-- Left column -credential badges stacked vertically -->
<div class="hero-left fade-in fade-in-delay-2">
<div class="defense-badges">
<div class="defense-badge gold-badge">
<span class="defense-badge-text" data-i18n="hero.badge1">25 Years HFC Experience</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text" data-i18n="hero.badge2">Home Front Command Licensing</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text" data-i18n="hero.badge3">MAMAD &amp; Safe-Room Specialists</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text" data-i18n="hero.badge4">Nationwide Delivery</span>
</div>
</div>
</div>

<!-- Right column -main text -->
<div class="hero-right">
<h1 class="fade-in" data-i18n="hero.headline">
Leaders in Civil<br>Protection &amp; Engineering<span class="red-dot">.</span>
</h1>
<p class="hero-sub fade-in fade-in-delay-1" data-i18n="hero.sub">
Protection and engineering solutions for the private, public and municipal sectors  -  from concept through permit and on-site execution.
</p>
<div class="hero-btns fade-in fade-in-delay-3">
<a href="#contact" class="btn-gold" data-i18n="hero.cta1">Schedule a Consultation</a>
<a href="#services" class="btn-white" data-i18n="hero.cta2">Our Services &rarr;</a>
</div>
</div>
</div>

<!-- Stats bar -pinned to bottom like Rafael -->
<div class="hero-stats fade-in fade-in-delay-3">
<div class="hero-stat">
<div class="hero-stat-num" data-count="25" data-suffix="+">0</div>
<div class="hero-stat-label" data-i18n="stat.years">Years of<br>Experience</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num" data-count="12" data-suffix=",000+">0</div>
<div class="hero-stat-label" data-i18n="stat.mamads">Safe Rooms<br>(MAMADs) Built</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num" data-count="3" data-suffix=",000+">0</div>
<div class="hero-stat-label" data-i18n="stat.border">Northern-Border<br>MAMADs</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num" data-count="300" data-suffix="+">0</div>
<div class="hero-stat-label" data-i18n="stat.institutional">Institutional<br>Protected Spaces</div>
</div>
</div>

<!-- Mobile CTA between stats and next section -->
<div class="hero-mobile-cta" style="display:none;padding:1.5rem 1.5rem 2rem;text-align:center;background:var(--bg-dark)">
<a href="#contact" class="btn-gold" style="display:inline-block;width:100%;max-width:400px;padding:1rem 2rem;font-size:1rem;text-align:center">Contact Us &rarr;</a>
</div>

</section>

<!-- ===== WHY: THE NEED ===== -->
<section style="padding:5rem 0;background:var(--bg-dark);position:relative;overflow:hidden" id="why" data-page="about">
<div style="position:absolute;top:0;left:0;right:0;bottom:0;opacity:0.06;background:url('threat-image.jpg') center/cover no-repeat"></div>
<div class="container" style="position:relative;z-index:1">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)" data-i18n="who.label">Who We Are</div>
<div class="section-title fade-in" style="text-align:center;color:#fff" data-i18n="who.title">Two Decades Inside Israel's Home Front Command</div>
<p class="fade-in" style="color:rgba(255,255,255,0.65);max-width:800px;margin:0.5rem auto 3rem;font-size:0.95rem;text-align:center;line-height:1.8" data-i18n="who.intro">A.R.I. Faberman Engineering Solutions Ltd. plans, licenses and delivers civil-protection projects across the residential, public and municipal sectors. We combine hands-on regulatory experience inside the Home Front Command with end-to-end engineering  -  from concept and permitting to on-site construction.</p>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:2.5rem;align-items:center">
  <div>
    <div class="fade-in" style="margin-bottom:2rem">
      <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.8rem">
        <div style="min-width:4px;width:4px;align-self:stretch;background:rgba(220,38,38,0.6);border-radius:4px;flex-shrink:0"></div>
        <div>
          <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:#fff;margin-bottom:0.4rem" data-i18n="who.b1_title">Operational Leadership</h3>
          <p style="font-size:0.88rem;color:rgba(255,255,255,0.65);line-height:1.7" data-i18n="who.b1_desc">Led by Lt. Col. (res.) Yigal Faberman  -  holder of degrees in architecture and in economics &amp; management, with 25 years in the IDF, including as head of the protection-projects branch.</p>
        </div>
      </div>
      <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.8rem">
        <div style="min-width:4px;width:4px;align-self:stretch;background:rgba(37,99,235,0.6);border-radius:4px;flex-shrink:0"></div>
        <div>
          <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:#fff;margin-bottom:0.4rem" data-i18n="who.b2_title">Home Front Command Regulation</h3>
          <p style="font-size:0.88rem;color:rgba(255,255,255,0.65);line-height:1.7" data-i18n="who.b2_desc">From 2012 to 2019, served as Dan District engineer and head of the Home Front Command's regulatory division for MAMAD licensing within building permits  -  providing planning and licensing for tens of thousands of protection units alongside municipal engineers and planning committees.</p>
        </div>
      </div>
      <div style="display:flex;align-items:flex-start;gap:1rem">
        <div style="min-width:4px;width:4px;align-self:stretch;background:rgba(22,163,74,0.6);border-radius:4px;flex-shrink:0"></div>
        <div>
          <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:#fff;margin-bottom:0.4rem" data-i18n="who.b3_title">Proven at National Scale</h3>
          <p style="font-size:0.88rem;color:rgba(255,255,255,0.65);line-height:1.7" data-i18n="who.b3_desc">Delivery record includes 12,000 MAMADs in Sderot and the Gaza-envelope communities, 150 protected kindergartens, and roughly 300 institutional protected spaces for the Ministries of Education, Health and Welfare  -  plus a program of some 3,000 MAMADs along the northern border.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="fade-in" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:2.5rem">
    <div style="font-family:var(--font-heading);font-size:0.72rem;text-transform:uppercase;letter-spacing:2px;color:var(--gold-bright);font-weight:600;margin-bottom:1.5rem" data-i18n="who.card_label">By the Numbers</div>
    <div style="display:flex;flex-direction:column;gap:1.2rem">
      <div style="display:flex;align-items:center;gap:1rem">
        <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:rgba(37,99,235,0.85);min-width:80px">25</div>
        <div style="font-size:0.85rem;color:rgba(255,255,255,0.6);line-height:1.5" data-i18n="who.card1">years of engineering and Home Front Command experience</div>
      </div>
      <div style="height:1px;background:rgba(255,255,255,0.06)"></div>
      <div style="display:flex;align-items:center;gap:1rem">
        <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:rgba(37,99,235,0.85);min-width:80px">12,000</div>
        <div style="font-size:0.85rem;color:rgba(255,255,255,0.6);line-height:1.5" data-i18n="who.card2">MAMADs built across Sderot and the Gaza-envelope communities</div>
      </div>
      <div style="height:1px;background:rgba(255,255,255,0.06)"></div>
      <div style="display:flex;align-items:center;gap:1rem">
        <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:rgba(22,163,74,0.85);min-width:80px">150</div>
        <div style="font-size:0.85rem;color:rgba(255,255,255,0.6);line-height:1.5" data-i18n="who.card3">protected kindergartens delivered for public institutions</div>
      </div>
    </div>
  </div>
</div>
</div>
</section>

<!-- ===== SERVICES: STRATEGIC PROTECTION ===== -->
<section class="pillars" id="pillars" data-page="home" style="padding:5rem 0;background:var(--bg-section)">
<div class="container">
<div class="pillars-header">
<div class="section-label fade-in" data-i18n="pil.label">How We Work</div>
<div class="section-title fade-in" data-i18n="pil.title">End to End  -  From Idea to Execution</div>
<div class="section-subtitle fade-in" style="margin:0 auto" data-i18n="pil.sub">Three service tiers that cover the whole journey: planning and consulting, licensing and permits, and construction and execution.</div>
</div>

<div class="svc-grid">
<!-- Card 1: Planning & Consulting -->
<div class="svc-card primary fade-in">
<div class="svc-img">
<img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj04.jpg" alt="Planning &amp; Consulting" loading="lazy">
<div class="svc-num">01</div>
</div>
<div class="svc-body">
<span class="svc-badge blue" data-i18n="pil.c1_badge">PLANNING</span>
<h3 data-i18n="pil.c1_t">Planning &amp; Consulting</h3>
<p data-i18n="pil.c1_p">An on-site visit, optimal safe-room placement, and a clear plan tailored to your home or facility  -  and to your budget.</p>
<ul>
<li data-i18n="pil.c1_l1">Site survey &amp; feasibility</li>
<li data-i18n="pil.c1_l2">Optimal MAMAD placement</li>
<li data-i18n="pil.c1_l3">Solution &amp; budget planning</li>
<li data-i18n="pil.c1_l4">State-funding eligibility check</li>
</ul>
<a href="#contact" class="svc-cta" data-i18n="pil.cta">Talk to Us →</a>
</div>
</div>

<!-- Card 2: Construction & Execution -->
<div class="svc-card accent fade-in fade-in-delay-1">
<div class="svc-img">
<img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj09.jpg" alt="Construction &amp; Execution" loading="lazy">
<div class="svc-num">02</div>
</div>
<div class="svc-body">
<span class="svc-badge dark" data-i18n="pil.c2_badge">EXECUTION</span>
<h3 data-i18n="pil.c2_t">Construction &amp; Execution</h3>
<p data-i18n="pil.c2_p">Approved protective technologies, structural reinforcement, safe-room (MAMAD) construction, and full project management  -  end to end.</p>
<ul>
<li data-i18n="pil.c2_l1">Room upgrades with no demolition required</li>
<li data-i18n="pil.c2_l2">Structural reinforcement &amp; blast protection</li>
<li data-i18n="pil.c2_l3">Safe-room construction &amp; certification</li>
<li data-i18n="pil.c2_l4">Project management &amp; QA</li>
</ul>
<a href="#contact" class="svc-cta" data-i18n="pil.cta">Talk to Us →</a>
</div>
</div>

<!-- Card 3: Licensing & Permits -->
<div class="svc-card govt fade-in fade-in-delay-2">
<div class="svc-img">
<img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj03.jpg" alt="Licensing &amp; Permits" loading="lazy">
<div class="svc-num">03</div>
</div>
<div class="svc-body">
<span class="svc-badge red" data-i18n="pil.c3_badge">LICENSING</span>
<h3 data-i18n="pil.c3_t">Licensing &amp; Permits</h3>
<p data-i18n="pil.c3_p">Full Home Front Command licensing and building-permit handling  -  including the accelerated "Tzav HaShaa" route that skips the usual planning committees.</p>
<ul>
<li data-i18n="pil.c3_l1">HFC model approval &amp; registry listing</li>
<li data-i18n="pil.c3_l2">Building-permit submission</li>
<li data-i18n="pil.c3_l3">Accelerated permit (Tzav HaShaa)</li>
<li data-i18n="pil.c3_l4">Liaison with authorities &amp; committees</li>
</ul>
<a href="#contact" class="svc-cta" data-i18n="pil.cta">Talk to Us →</a>
</div>
</div>
</div>

</div>
</section>


<!-- ===== HOME CTA BAND ===== -->
<section data-page="home" style="padding:4.5rem 0;background:var(--bg-dark);position:relative;overflow:hidden">
<div class="container" style="text-align:center;position:relative;z-index:1">
<div class="section-title fade-in" style="color:#fff;margin-bottom:0.6rem" data-i18n="cta.title">Ready to protect what matters most?</div>
<p class="fade-in" style="color:rgba(255,255,255,0.7);max-width:640px;margin:0 auto 1.8rem;font-size:0.98rem;line-height:1.7" data-i18n="cta.sub">Book a free, no-obligation consultation. We visit, check your eligibility for state funding, and give you a clear plan and quote.</p>
<div class="fade-in" style="display:flex;gap:0.9rem;justify-content:center;flex-wrap:wrap">
<a href="#contact" class="btn-gold" data-i18n="cta.b1">Schedule a Consultation</a>
<a href="https://wa.me/972544757201" target="_blank" rel="noopener" class="btn-white" data-i18n="cta.b2">Message on WhatsApp</a>
</div>
</div>
</section>

<!-- ===== OUR SERVICES (detailed) ===== -->
<section style="padding:5rem 0;background:#fff;border-top:1px solid var(--border)" id="services" data-page="services">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)">What We Do</div>
<div class="section-title fade-in" style="text-align:center">Our Services</div>
<p class="fade-in" style="color:var(--text-light);max-width:720px;margin:0.5rem auto 2.5rem;font-size:0.95rem;text-align:center;line-height:1.7">End-to-end civil protection  -  from Home Front Command licensing and protected-space construction to upgrades, public-shelter rehabilitation, and statutory consulting.</p>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem" class="fade-in services-grid">

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Protective Rooms &amp; Structures Supply</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">Supply of protective rooms and fortified structures, including Home Front Command licensing for model approval and registration in the official HFC (Pikud HaOref) database.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Protected Space Construction</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">End-to-end design and construction of protected spaces (safe rooms / MAMAD) for private clients, kibbutzim, moshavim and more  -  full-service coverage for individuals and organizations.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Security &amp; Existing Room Upgrades</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">Upgrading security rooms and existing rooms to protective standard using Home Front Command&ndash;approved technologies  -  no demolition required.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Public Shelter Rehabilitation</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">Rehabilitation and restoration of public shelters for municipal authorities  -  bringing communal protection back to operational, code-compliant condition.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Protection Consulting &amp; Permitting</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">Protection consulting throughout statutory processes and building-permit procedures  -  including Home Front Command approvals and exceptions committees.</p>
</div>

</div>
</div>
</section>


<!-- ===== MAMAD PROCESS DETAIL (Services page) ===== -->
<section class="fl-faq" id="mamad-process" data-page="services" style="background:var(--bg-light)">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)" data-i18n="mp.label">The Process</div>
<div class="section-title fade-in" style="text-align:center" data-i18n="mp.title">Building a MAMAD, Step by Step</div>
<p class="fade-in" style="color:var(--text-light);max-width:760px;margin:0.5rem auto 0;font-size:0.95rem;text-align:center;line-height:1.7" data-i18n="mp.sub">Since the outbreak of the war an accelerated Home Front Command track lets you add a MAMAD quickly. Here is how the process works, end to end.</p>
<div class="fl-faq-wrap fade-in">
<details open><summary data-i18n="mp.q0">The Accelerated "Tzav HaShaa" Permit</summary><p data-i18n="mp.a0">Following 7 October 2023, the Planning Administration and Home Front Command introduced an emergency order: a fast track that exempts a MAMAD from the usual building-permit process and grants approval directly from the Home Front Command. Licensing takes up to about 30 working days from signing; the HFC approval is valid for two years (extendable), and the route removes the dependence on local planning committees.</p></details>
<details><summary data-i18n="mp.q1">Stage 1 — Early Planning</summary><p data-i18n="mp.a1">A professional site visit with our planning team to determine the optimal MAMAD placement: the best opening point to minimise damage to the existing home, a review of existing infrastructure (sewage, electricity, water) and access routes, a placement sketch, and the homeowner's sign-off ("configuration freeze").</p></details>
<details><summary data-i18n="mp.q2">Stage 2 — Advanced Planning</summary><p data-i18n="mp.a2">A licensed surveyor measures the building and plot (house contour, connection facade, on-site infrastructure, plot lines, blocks &amp; parcels and the approved zoning plan) for the online permit submission, plus a soil test and report with foundation guidance for each home.</p></details>
<details><summary data-i18n="mp.q3">Stage 3 — Detailed Planning &amp; Licensing</summary><p data-i18n="mp.a3">Architectural design at 1:100 and 1:50 and structural design at 1:50, connected to the house per Home Front Command guidelines and signed by a licensed architect and structural engineer; submission to the HFC systems and liaison with the relevant officials through to final approval — then approval to begin construction.</p></details>
</div>
</div>
</section>

<!-- ===== WHO WE SERVE ===== -->
<section style="padding:5rem 0;background:#fff" id="customers" data-page="serve">
<div class="container">
<div class="section-label fade-in" style="text-align:center">Who We Serve</div>
<div class="section-title fade-in" style="text-align:center">Every Organization That Must Operate During Emergencies</div>
<p class="fade-in" style="color:var(--text-light);max-width:700px;margin:0.5rem auto 2.5rem;font-size:0.95rem;text-align:center">From private homeowners to municipalities and developers  -  we deliver civil-protection consulting, planning and construction across three core audiences.</p>

<div class="wws-tabs">
  <button class="wws-tab active" onclick="wwsShow(event,'priv')">Private Clients</button>
  <button class="wws-tab" onclick="wwsShow(event,'ess')">Public &amp; Municipal</button>
  <button class="wws-tab" onclick="wwsShow(event,'gov')">Developers &amp; Companies</button>
</div>

<!-- Private Sector Panel -->
<div class="wws-panel active" id="wws-priv">
  <div class="wws-content">
    <h3>Private Clients</h3>
    <p>Homeowners and private clients protecting their families and property  -  from safe-room design and construction to building permits and home additions.</p>
    <div class="wws-tags">
      <span class="wws-tag">Private Homes</span><span class="wws-tag">Safe Rooms (MAMAD)</span>
      <span class="wws-tag">Building Permits</span><span class="wws-tag">Home Additions</span>
    </div>
    <ul class="wws-features">
      <li>Safe room (MAMAD) design &amp; construction</li>
      <li>Building permits &amp; home additions</li>
      <li>Home Front Command&ndash;compliant protection</li>
      <li>Full turnkey delivery with minimal disruption</li>
    </ul>
    <a href="#contact" class="wws-cta">Request Private Consultation &rarr;</a>
  </div>
  <div class="wws-visual">
    <img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj03.jpg" alt="Private residence safe room" loading="lazy">
    <div class="wws-badge">Private Clients</div>
  </div>
</div>

<!-- Essential Services Panel -->
<div class="wws-panel" id="wws-ess">
  <div class="wws-content">
    <h3>Public &amp; Municipal Sector</h3>
    <p>Local authorities, kibbutzim, moshavim and public institutions  -  protection programs, public-shelter rehabilitation and community-wide preparedness.</p>
    <div class="wws-tags">
      <span class="wws-tag green">Local Authorities</span><span class="wws-tag green">Kibbutzim &amp; Moshavim</span>
      <span class="wws-tag green">Public Institutions</span><span class="wws-tag green">Public Shelters</span>
    </div>
    <ul class="wws-features green">
      <li>Public shelter rehabilitation &amp; restoration</li>
      <li>Municipal protection &amp; preparedness programs</li>
      <li>Protected spaces for public institutions</li>
      <li>End-to-end support for communities &amp; organizations</li>
    </ul>
    <a href="#contact" class="wws-cta green">Explore Public-Sector Solutions &rarr;</a>
  </div>
  <div class="wws-visual">
    <img src="<?php echo get_template_directory_uri(); ?>/images/hospital-blueprint.jpg" alt="Municipal protection planning">
    <div class="wws-badge green">Public &amp; Municipal</div>
  </div>
</div>

<!-- Government Panel -->
<div class="wws-panel" id="wws-gov">
  <div class="wws-content">
    <h3>Developers &amp; Companies</h3>
    <p>Real-estate developers, construction firms and organizations  -  engineering consulting, regulatory compliance, project management and protection-solution design.</p>
    <div class="wws-tags">
      <span class="wws-tag">Developers</span><span class="wws-tag">Construction Firms</span>
      <span class="wws-tag">Engineering</span><span class="wws-tag">Organizations</span>
    </div>
    <ul class="wws-features">
      <li>Engineering consulting &amp; protection design</li>
      <li>Regulatory compliance &amp; statutory processes</li>
      <li>Project management from planning to permit</li>
      <li>Protection solutions tailored to each project</li>
    </ul>
    <a href="#contact" class="wws-cta">Explore Developer Solutions &rarr;</a>
  </div>
  <div class="wws-visual">
    <img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj03.jpg" alt="Developments and construction projects">
    <div class="wws-badge">Developers &amp; Companies</div>
  </div>
</div>

<div class="fade-in" style="text-align:center;margin-top:2.5rem">
<a href="#contact" style="display:inline-block;padding:0.7rem 2rem;background:var(--gold);color:#fff;border-radius:8px;font-size:0.88rem;font-weight:600;transition:all 0.3s" onmouseover="this.style.background='var(--gold-light)'" onmouseout="this.style.background='var(--gold)'">See All Customer Solutions &rarr;</a>
</div>
</div>
</section>

<!-- ===== TRUSTED BY / CLIENT LOGO WALL =====
     To add a client: drop a logo file into images/clients/ and add a line to the
     $fortline_clients array below (name + file). If the file is missing, the client
     name is shown as a text tile automatically, so the wall always looks complete. -->
<?php
$fortline_clients = array(
    array('name' => 'Elite Safety Engineering',      'file' => 'elite.png'),
    array('name' => 'Eldar',                          'file' => 'eldar.png'),
    array('name' => 'Afi Capital',                    'file' => 'afi-capital.png'),
    array('name' => 'Electra Living',                 'file' => 'electra-living.png'),
    array('name' => 'Ackerstein',                     'file' => 'ackerstein.jpg'),
    array('name' => 'H.L.M – Business Licensing',     'file' => 'hlm.png'),
    array('name' => 'am:pm City Market',              'file' => 'ampm.png'),
    array('name' => 'State Comptroller of Israel',    'file' => 'state-comptroller.jpg'),
    array('name' => 'Mifram',                         'file' => 'mifram.png'),
    array('name' => 'Ashdod Port',                    'file' => 'ashdod-port.webp'),
    array('name' => 'Harish Municipality',            'file' => 'harish.png'),
    array('name' => 'Rami Sarfati Construction',      'file' => 'rami-sarfati.jpg'),
    array('name' => 'Shaviro Engineering & Construction', 'file' => 'shaviro.png'),
    array('name' => 'Shidor',                         'file' => 'shidor.webp'),
    array('name' => 'Tnuva',                          'file' => 'tnuva.jpg'),
);
$fortline_clients_dir = get_template_directory() . '/images/clients/';
$fortline_clients_uri = get_template_directory_uri() . '/images/clients/';
?>
<style>
.fl-clients{padding:4.5rem 0;background:var(--bg-light);border-top:1px solid var(--border)}
.fl-clients-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:1rem;margin-top:2rem}
.fl-client-tile{background:#fff;border:1px solid var(--border);border-radius:12px;height:104px;display:flex;align-items:center;justify-content:center;padding:1rem;transition:all 0.3s}
.fl-client-tile:hover{border-color:rgba(37,99,235,0.3);box-shadow:0 8px 24px rgba(0,0,0,0.07)}
.fl-client-tile img{max-width:100%;max-height:64px;object-fit:contain;filter:grayscale(100%);opacity:.7;transition:all 0.3s}
.fl-client-tile:hover img{filter:grayscale(0);opacity:1}
.fl-client-name{font-family:var(--font-heading);font-size:0.9rem;font-weight:600;color:var(--text-mid);text-align:center;line-height:1.35}
@media(max-width:1024px){.fl-clients-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:640px){.fl-clients-grid{grid-template-columns:repeat(2,1fr)}}
</style>
<section class="fl-clients" id="clients" data-page="about">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)">Our Clients</div>
<div class="section-title fade-in" style="text-align:center">Trusted By Leading Organizations</div>
<p class="fade-in" style="color:var(--text-light);max-width:680px;margin:0.5rem auto 0;font-size:0.95rem;text-align:center;line-height:1.7">Authorities, municipalities, developers, public institutions and private clients rely on us for civil-protection planning and construction.</p>
<div class="fl-clients-grid fade-in">
<?php foreach ($fortline_clients as $c):
    $has = !empty($c['file']) && file_exists($fortline_clients_dir . $c['file']); ?>
  <div class="fl-client-tile">
    <?php if ($has): ?>
      <img src="<?php echo esc_url($fortline_clients_uri . $c['file']); ?>" alt="<?php echo esc_attr($c['name']); ?>" loading="lazy">
    <?php else: ?>
      <span class="fl-client-name"><?php echo esc_html($c['name']); ?></span>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
</div>
</div>
</section>






<!-- ===== AREAS OF ACTIVITY ===== -->
<section style="padding:5rem 0;background:var(--bg-light)" id="sectors" data-page="serve">
<div class="container">
<div class="section-label fade-in" style="text-align:center" data-i18n="area.label">Who We Protect</div>
<div class="section-title fade-in" style="text-align:center" data-i18n="area.title">Areas of Activity</div>
<p class="fade-in" style="color:var(--text-light);max-width:700px;margin:0.5rem auto 2.5rem;font-size:0.95rem;text-align:center;line-height:1.7" data-i18n="area.sub">We protect across four core sectors  -  each with an approach tailored to its needs, regulation and constraints.</p>
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem" class="fade-in areas-grid">

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;text-align:center;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem" data-i18n="area.c1_t">Private Homes</h4>
<p style="font-size:0.85rem;color:var(--text-light);line-height:1.6" data-i18n="area.c1_p">Safe rooms (MAMAD) for houses and apartments, room upgrades, building permits and home additions  -  turnkey, with minimal disruption.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;text-align:center;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem" data-i18n="area.c2_t">Public Institutions</h4>
<p style="font-size:0.85rem;color:var(--text-light);line-height:1.6" data-i18n="area.c2_p">Protected spaces for schools, kindergartens, clinics and public buildings for the Ministries of Education, Health and Welfare.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;text-align:center;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem" data-i18n="area.c3_t">Kibbutzim &amp; Communities</h4>
<p style="font-size:0.85rem;color:var(--text-light);line-height:1.6" data-i18n="area.c3_p">Community-scale protection programs for kibbutzim, moshavim and local authorities  -  including public-shelter rehabilitation.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;text-align:center;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem" data-i18n="area.c4_t">Industry &amp; Strategic Sites</h4>
<p style="font-size:0.85rem;color:var(--text-light);line-height:1.6" data-i18n="area.c4_p">Physical protection for energy facilities, plants and strategic infrastructure  -  planned and licensed to standard.</p>
</div>

</div>
</div>
</section>

<!-- ===== WHY CHOOSE US ===== -->
<section style="padding:5rem 0;background:#fff;border-top:1px solid var(--border)" id="advantages" data-page="about">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)" data-i18n="wcu.label">Our Advantages</div>
<div class="section-title fade-in" style="text-align:center" data-i18n="wcu.title">Why Work With Us</div>
<p class="fade-in" style="color:var(--text-light);max-width:700px;margin:0.5rem auto 2.5rem;font-size:0.95rem;text-align:center;line-height:1.7" data-i18n="wcu.subtitle">A comprehensive, high-quality answer for sensitive protection projects  -  an experienced team, efficient solutions and a full-service envelope from planning to execution.</p>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.5rem" class="fade-in">

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.6rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem" data-i18n="wcu.a1_t">Professional Efficiency &amp; Sensitivity</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6" data-i18n="wcu.a1_d">Coordination, planning, licensing and management of sensitive projects  -  on tight schedules and dedicated budgets, with close personal attention throughout.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.6rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem" data-i18n="wcu.a2_t">Solutions for Every Challenge</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6" data-i18n="wcu.a2_d">Creative, cost-effective answers to any issue that arises during a project  -  while meeting the strictest standards and delivering quality results.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.6rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem" data-i18n="wcu.a3_t">Experienced Team</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6" data-i18n="wcu.a3_d">Five engineers and specialists in budgeting, scheduling, planning and execution  -  led by Yigal Faberman, with deep experience delivering national protection projects.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.6rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem" data-i18n="wcu.a4_t">Full-Service Envelope</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6" data-i18n="wcu.a4_d">Managing every stage from planning to on-site execution, working with all relevant authorities and providers  -  streamlining the process and saving valuable time.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.6rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem" data-i18n="wcu.a5_t">Uncompromising Quality</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6" data-i18n="wcu.a5_d">Working with the leading physical-protection suppliers, precise and fast Home Front Command licensing, and strict adherence to every standard.</p>
</div>

</div>
</div>
</section>

<!-- ===== SELECTED PROJECTS ===== -->
<style>
.fl-proj{padding:5rem 0;background:var(--bg-light);border-top:1px solid var(--border)}
.fl-proj-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-top:2rem}
.fl-proj-card{position:relative;border-radius:14px;overflow:hidden;aspect-ratio:4/3;box-shadow:0 6px 20px rgba(10,22,40,0.08)}
.fl-proj-card img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s ease}
.fl-proj-card:hover img{transform:scale(1.06)}
.fl-proj-cap{position:absolute;left:0;right:0;bottom:0;padding:1.4rem 1.1rem 1rem;background:linear-gradient(to top,rgba(9,20,31,0.88),rgba(9,20,31,0));color:#fff}
.fl-proj-cap h4{font-family:var(--font-heading);font-size:1rem;font-weight:700;margin:0}
@media(max-width:900px){.fl-proj-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:560px){.fl-proj-grid{grid-template-columns:1fr}}
</style>
<section class="fl-proj" id="projects" data-page="projects">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)" data-i18n="proj.label">Our Work</div>
<div class="section-title fade-in" style="text-align:center" data-i18n="proj.title">Selected Projects</div>
<p class="fade-in" style="color:var(--text-light);max-width:700px;margin:0.5rem auto 0;font-size:0.95rem;text-align:center;line-height:1.7" data-i18n="proj.subtitle">From private safe rooms to institutional protected spaces and community-scale programs  -  planned, licensed and built end to end.</p>
<div class="fl-proj-grid fade-in">
<?php
$fortline_projects = array(
    array('img' => 'proj03.jpg', 'cap' => 'Residential-Tower MAMADs'),
    array('img' => 'proj01.jpg', 'cap' => 'Mobile Protected Structures'),
    array('img' => 'proj09.jpg', 'cap' => 'Safe-Room Reinforcement'),
    array('img' => 'proj08.jpg', 'cap' => 'Cast-Concrete Safe Rooms'),
    array('img' => 'proj05.jpg', 'cap' => 'Completed Safe Rooms'),
    array('img' => 'proj07.jpg', 'cap' => 'Institutional Protected Spaces'),
);
$proj_i = 0;
foreach ($fortline_projects as $pr): $proj_i++; ?>
  <div class="fl-proj-card">
    <img src="<?php echo get_template_directory_uri(); ?>/images/projects/<?php echo $pr['img']; ?>" alt="<?php echo esc_attr($pr['cap']); ?>" loading="lazy">
    <div class="fl-proj-cap"><h4 data-i18n="proj.cap<?php echo $proj_i; ?>"><?php echo esc_html($pr['cap']); ?></h4></div>
  </div>
<?php endforeach; ?>
</div>
</div>
</section>


<!-- ===== PROCESS ===== -->
<section class="process" id="process" data-page="services">
<div class="container">
<div class="process-header">
<div class="section-label fade-in" data-i18n="proc.label">How It Works</div>
<div class="section-title fade-in" data-i18n="proc.title">From Assessment to Protection</div>
</div>
<div class="timeline">
<div class="tl-step fade-in">
<div class="tl-img"><img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj07.jpg" alt="Consultation" loading="lazy"></div>
<div class="tl-num">1</div>
<h3 data-i18n="proc.s1_t">Free, No-Obligation Consultation</h3>
<p data-i18n="proc.s1_p">We visit your home or facility, understand your needs, and check eligibility for state funding.</p>
</div>
<div class="tl-step fade-in fade-in-delay-1">
<div class="tl-img"><img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj09.jpg" alt="Engineering plans" loading="lazy"></div>
<div class="tl-num">2</div>
<h3 data-i18n="proc.s2_t">Planning &amp; Design</h3>
<p data-i18n="proc.s2_p">Optimal safe-room placement, engineering drawings, and a solution tailored to the site and budget.</p>
</div>
<div class="tl-step fade-in fade-in-delay-2">
<div class="tl-img"><img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj06.jpg" alt="Licensing" loading="lazy"></div>
<div class="tl-num">3</div>
<h3 data-i18n="proc.s3_t">Licensing &amp; Permits</h3>
<p data-i18n="proc.s3_p">Home Front Command approval and building-permit handling, including the accelerated route.</p>
</div>
<div class="tl-step fade-in fade-in-delay-3">
<div class="tl-img"><img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj05.jpg" alt="Handover" loading="lazy"></div>
<div class="tl-num">4</div>
<h3 data-i18n="proc.s4_t">Construction &amp; Handover</h3>
<p data-i18n="proc.s4_p">End-to-end construction, certification and handover  -  with ongoing support.</p>
</div>
</div>
</div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<style>
.fl-tst{padding:5rem 0;background:var(--bg-section)}
.fl-tst-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;margin-top:2rem}
.fl-tst-card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:2rem 1.8rem;box-shadow:0 4px 18px rgba(10,22,40,0.05)}
.fl-tst-quote{font-size:0.92rem;color:var(--text-mid);line-height:1.75;margin-bottom:1.2rem}
.fl-tst-quote::before{content:'\201C';font-family:Georgia,serif;font-size:2.4rem;color:var(--gold-bright);line-height:0;vertical-align:-0.4em;margin-right:0.15em}
.fl-tst-by{font-family:var(--font-heading);font-size:0.9rem;font-weight:700;color:var(--text-dark)}
.fl-tst-foot{display:flex;align-items:center;gap:0.75rem;margin-top:0.4rem}
.fl-tst-logo{width:46px;height:46px;border-radius:10px;background:#0B162C;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fl-tst-logo svg{width:24px;height:24px}
@media(max-width:760px){.fl-tst-grid{grid-template-columns:1fr}}
/* FAQ */
.fl-faq{padding:5rem 0;background:#fff;border-top:1px solid var(--border)}
.fl-faq-wrap{max-width:820px;margin:2rem auto 0}
.fl-faq details{border:1px solid var(--border);border-radius:12px;margin-bottom:0.8rem;background:var(--bg-card);overflow:hidden}
.fl-faq summary{list-style:none;cursor:pointer;padding:1.1rem 1.3rem;font-family:var(--font-heading);font-size:1rem;font-weight:600;color:var(--text-dark);display:flex;justify-content:space-between;align-items:center;gap:1rem}
.fl-faq summary::-webkit-details-marker{display:none}
.fl-faq summary::after{content:'+';font-size:1.4rem;color:var(--gold-bright);font-weight:400;flex-shrink:0}
.fl-faq details[open] summary::after{content:'\2212'}
.fl-faq p{padding:0 1.3rem 1.2rem;font-size:0.9rem;color:var(--text-light);line-height:1.7;margin:0}
</style>
<section class="fl-tst" id="testimonials" data-page="about">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)" data-i18n="tst.label">Testimonials</div>
<div class="section-title fade-in" style="text-align:center" data-i18n="tst.title">What Our Clients Say</div>
<div class="fl-tst-grid fade-in">
<div class="fl-tst-card"><p class="fl-tst-quote" data-i18n="tst.q1">ARI Faberman carried out comprehensive protection work for us across several hospitals nationwide. We were very satisfied  -  the team was professional, skilled and reliable, worked under significant time pressure, and finished on time and on budget. We highly recommend them for anyone needing quality protection services.</p><div class="fl-tst-foot"><span class="fl-tst-logo"><svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l7-4 7 4v14M10 21v-5h4v5M9 10h.01M15 10h.01M9 13h.01M15 13h.01"/></svg></span><span class="fl-tst-by" data-i18n="tst.b1">Ministry of Health</span></div></div>
<div class="fl-tst-card"><p class="fl-tst-quote" data-i18n="tst.q2">We warmly recommend ARI Faberman for upgrading MAMADs and shelters. The team was professional, efficient and courteous throughout, worked closely with us to understand our needs, and delivered a tailored solution. The results were excellent and we're confident it will protect our students in an emergency.</p><div class="fl-tst-foot"><span class="fl-tst-logo"><svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l7-4 7 4v14M10 21v-5h4v5M9 10h.01M15 10h.01M9 13h.01M15 13h.01"/></svg></span><span class="fl-tst-by" data-i18n="tst.b2">Ministry of Education</span></div></div>
<div class="fl-tst-card"><p class="fl-tst-quote" data-i18n="tst.q3">We looked for a reliable company to protect our kindergarten's MAMAD and chose ARI Faberman after reading positive reviews. We weren't disappointed  -  professional, efficient and courteous, working quietly and quickly with the children in mind. The upgraded MAMAD looks great and we feel much safer now.</p><div class="fl-tst-foot"><span class="fl-tst-logo"><svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l7-4 7 4v14M10 21v-5h4v5M9 10h.01M15 10h.01M9 13h.01M15 13h.01"/></svg></span><span class="fl-tst-by" data-i18n="tst.b3">"Rakefet" Kindergarten, Sderot</span></div></div>
<div class="fl-tst-card"><p class="fl-tst-quote" data-i18n="tst.q4">Thank you for renovating the shelter at our school. The process was smooth and easy, and the team was friendly and professional. Our upgraded space looks great and we're confident it will provide our students with optimal protection in an emergency.</p><div class="fl-tst-foot"><span class="fl-tst-logo"><svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l7-4 7 4v14M10 21v-5h4v5M9 10h.01M15 10h.01M9 13h.01M15 13h.01"/></svg></span><span class="fl-tst-by" data-i18n="tst.b4">Sde Uziya School</span></div></div>
</div>
</div>
</section>

<!-- ===== FAQ ===== -->
<section class="fl-faq" id="faq" data-page="faq">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)" data-i18n="faq.label">FAQ</div>
<div class="section-title fade-in" style="text-align:center" data-i18n="faq.title">Frequently Asked Questions</div>
<div class="fl-faq-wrap fade-in">
<details><summary data-i18n="faq.q1">Why is it important to upgrade my home's MAMAD or shelter?</summary><p data-i18n="faq.a1">A properly upgraded protected space provides real safety and peace of mind, meets Home Front Command standards, and can significantly increase your property's value.</p></details>
<details><summary data-i18n="faq.q2">What services does your company offer?</summary><p data-i18n="faq.a2">Safe-room (MAMAD) construction, security-room and existing-room upgrades, supply of Home Front Command-approved mobile protected elements, public-shelter rehabilitation, and protection consulting for building permits.</p></details>
<details><summary data-i18n="faq.q3">Do you also serve government institutions and communities in the Gaza envelope and the north?</summary><p data-i18n="faq.a3">Yes. We work extensively with government ministries, local authorities, kibbutzim and border communities  -  including a program of roughly 3,000 MAMADs along the northern border.</p></details>
<details><summary data-i18n="faq.q4">How much does a MAMAD or shelter renovation cost?</summary><p data-i18n="faq.a4">It depends on the specific room, the chosen protection method, and the scope of work. We assess the site and provide a clear, tailored quote.</p></details>
<details><summary data-i18n="faq.q5">How can I get a price quote?</summary><p data-i18n="faq.a5">Call us or message on WhatsApp, or send the contact form. We come to you, check eligibility (free of charge in confrontation-line communities) and provide a quote.</p></details>
<details><summary data-i18n="faq.q6">What is the accelerated "Order of the Hour" (Tzav HaShaa) permit?</summary><p data-i18n="faq.a6">A fast-track Home Front Command route  -  up to about 30 working days  -  for adding a MAMAD, bypassing the usual planning committees. The approval is valid for two years, with an option to extend.</p></details>
</div>
</div>
</section>

<!-- ===== CONTACT ===== -->
<section class="contact" id="contact" data-page="contact">
<div class="container">
<div class="section-label fade-in" data-i18n="ct.label">Get Started</div>
<div class="section-title fade-in" style="margin-bottom:2rem" data-i18n="ct.title">Request a Consultation</div>
<div class="contact-grid">
<div class="contact-form-box fade-in">
<form id="contactForm">
<div class="form-row">
<div class="form-group"><label>Full Name *</label><input type="text" name="name" required placeholder="Your full name"></div>
<div class="form-group"><label>Organization</label><input type="text" name="organization" placeholder="Company or government entity"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Email Address *</label><input type="email" name="email" required placeholder="you@organization.com"></div>
<div class="form-group"><label>Phone Number</label><input type="tel" name="phone" placeholder="054-000-0000"></div>
</div>
<div class="form-row">
<div class="form-group">
<label>Type of Inquiry</label>
<select name="inquiry_type"><option value="">Select type</option><option>Safe Room (MAMAD) Construction</option><option>Security Room Upgrade</option><option>Public Shelter Rehabilitation</option><option>Protection Consulting / Permit</option><option>Other</option></select>
</div>
<div class="form-group">
<label>Facility Type</label>
<select name="facility_type"><option value="">Select facility</option><option>Private Home</option><option>Apartment Building</option><option>Kibbutz / Moshav</option><option>Public Institution</option><option>Local Authority</option><option>Business / Industry</option><option>Other</option></select>
</div>
</div>
<div class="form-group"><label>Message</label><textarea name="message" placeholder="Tell us about your protection needs -all communications are strictly confidential"></textarea></div>
<button type="submit" class="form-submit">Submit Inquiry &rarr;</button>
</form>
</div>
<div class="contact-info fade-in fade-in-delay-1">
<div class="info-card">
<div><h4 data-i18n="ci.phone_t">Phone &amp; WhatsApp</h4><p><a href="tel:+972544757201" style="color:inherit">054-475-7201</a></p></div>
</div>
<div class="info-card">
<div><h4 data-i18n="ci.email_t">Email</h4><p><a href="mailto:Ari.engpm@gmail.com" style="color:inherit">Ari.engpm@gmail.com</a></p></div>
</div>
<div class="info-card">
<div><h4 data-i18n="ci.addr_t">Address</h4><p data-i18n="ci.addr_v">Shamir, HaBazelet 8</p></div>
</div>
<div class="info-card">
<div><h4 data-i18n="ci.elig_t">Free Eligibility Check</h4><p data-i18n="ci.elig_v">Homes in confrontation-line communities may be eligible for a state-funded MAMAD  -  we check at no cost.</p></div>
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
<img src="<?php echo get_template_directory_uri(); ?>/images/brand/ari-logo-horizontal-reversed.svg" alt="A.R.I. Faberman Engineering Solutions Ltd." class="footer-logo-img">
</div>
<p class="footer-tagline" data-i18n="footer.tagline">Civil-protection engineering  -  safe rooms (MAMAD), shelters and building-permit licensing, planned and built end to end.</p>
</div>
<div class="footer-col">
<h4 data-i18n="footer.services_h">Services</h4>
<a href="#services" data-i18n="footer.l_services">Our Services</a>
<a href="#projects" data-i18n="footer.l_projects">Projects</a>
<a href="#faq" data-i18n="footer.l_faq">FAQ</a>
</div>
<div class="footer-col">
<h4 data-i18n="footer.company_h">Company</h4>
<a href="#about" data-i18n="footer.l_about">About Us</a>
<a href="#serve" data-i18n="footer.l_serve">Who We Serve</a>
<a href="#about" data-i18n="footer.l_clients">Clients</a>
</div>
<div class="footer-col">
<h4 data-i18n="footer.contact_h">Get in Touch</h4>
<a href="tel:+972544757201">054-475-7201</a>
<a href="mailto:Ari.engpm@gmail.com">Ari.engpm@gmail.com</a>
<a href="#" data-i18n="footer.addr">Shamir, HaBazelet 8</a>
</div>
</div>
<div class="footer-bar">
<p>&copy; 2026 A.R.I. Faberman Engineering Solutions Ltd. All rights reserved.</p>
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script>try { emailjs.init('gHP8ZucvB2iLEtPVU'); } catch(e) {}</script>

<script>
// Who We Serve tabs
function wwsShow(e,id){
  document.querySelectorAll('.wws-tab').forEach(b=>b.classList.remove('active'));
  document.querySelectorAll('.wws-panel').forEach(p=>p.classList.remove('active'));
  e.target.classList.add('active');
  document.getElementById('wws-'+id).classList.add('active');
}

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
inquiry_type:form.inquiry_type.value,
facility_type:form.facility_type.value,
message:form.message.value
};

// Send via EmailJS
emailjs.send('service_py23y6a','template_lgfttoi',{
to_email:'Ari.engpm@gmail.com',
from_name:data.name,
from_email:data.email,
organization:data.organization,
phone:data.phone||'Not provided',
inquiry_type:data.inquiry_type||'Not specified',
facility_type:data.facility_type||'Not specified',
message:data.message||'No message provided',
subject:'New A.R.I. Faberman Inquiry from '+data.name
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



<script>
/* Simple hash router: each menu item is its own "page" (sections tagged data-page). */
(function(){
  var PAGES=['home','services','projects','serve','about','faq','contact'];
  function current(){ var h=(location.hash||'').replace(/^#\/?/,'').toLowerCase(); return PAGES.indexOf(h)>=0?h:'home'; }
  function show(pg){
    var init=document.getElementById('rp-init'); if(init){ init.remove(); }
    document.querySelectorAll('section[data-page]').forEach(function(s){
      s.classList.toggle('rp-hidden', s.getAttribute('data-page')!==pg);
    });
    document.querySelectorAll('.nav-links a, .mobile-menu a').forEach(function(a){
      var href=(a.getAttribute('href')||'').replace('#','');
      a.classList.toggle('active', href===pg);
    });
    window.scrollTo(0,0);
  }
  window.addEventListener('hashchange', function(){ show(current()); });
  function init(){ show(current()); }
  if (document.readyState==='loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
</script>

<?php get_footer(); ?>