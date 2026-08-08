<?php
/**
 * Template Name: Home
 * Description: Home page
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
.nav{background:#fff!important;box-shadow:0 1px 4px rgba(0,0,0,0.08)}
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
<a href="<?php echo home_url('/'); ?>#technology">Technology</a>
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
<a href="<?php echo home_url('/unique-technology/'); ?>" onclick="this.parentElement.classList.remove('open')">Unique Tech</a>
<a href="<?php echo home_url('/'); ?>#technology" onclick="this.parentElement.classList.remove('open')">Technology</a>
<a href="<?php echo home_url('/customers/'); ?>" onclick="this.parentElement.classList.remove('open')">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>" onclick="this.parentElement.classList.remove('open')">About</a>
<a href="<?php echo home_url('/articles/'); ?>" onclick="this.parentElement.classList.remove('open')">Articles</a>
<a href="<?php echo home_url('/customers/'); ?>#contact" onclick="this.parentElement.classList.remove('open')" class="btn-gold" style="margin-top:1rem">Contact Us</a>
</div>
<!-- ===== HERO -Company Level ===== -->
<section class="hero" id="hero">
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
<span class="defense-badge-text">Tested in Warzones</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Ministry of Defense Approved</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Military Certified</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Patent Protected</span>
</div>
</div>
</div>

<!-- Right column -main text -->
<div class="hero-right">
<h1 class="fade-in">
Fortline<br>Global<span class="red-dot">.</span>
</h1>
<p class="hero-sub fade-in fade-in-delay-1">
World-Class Civilian Defense Technology<br>for Any Private, Commercial or Government Facility
</p>
<div class="hero-btns fade-in fade-in-delay-3">
<a href="#contact" class="btn-gold">Contact Us</a>
<a href="#pillars" class="btn-white">Our Solutions &rarr;</a>
</div>
</div>
</div>

<!-- Stats bar -pinned to bottom like Rafael -->
<div class="hero-stats fade-in fade-in-delay-3">
<div class="hero-stat">
<div class="hero-stat-num" data-count="25" data-suffix="+">0</div>
<div class="hero-stat-label">Years Military<br>Experience</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num" data-count="15" data-suffix=",000+">0</div>
<div class="hero-stat-label">Protected Spaces<br>Delivered</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num">&lt;5 Days</div>
<div class="hero-stat-label">To Fortify Any<br>Existing Room</div>
</div>
<div class="hero-stat">
<div class="hero-stat-num" data-count="300" data-suffix="+">0</div>
<div class="hero-stat-label">Strategic<br>Advisories</div>
</div>
</div>

<!-- Mobile CTA between stats and next section -->
<div class="hero-mobile-cta" style="display:none;padding:1.5rem 1.5rem 2rem;text-align:center;background:var(--bg-dark)">
<a href="<?php echo home_url('/customers/'); ?>#contact" class="btn-gold" style="display:inline-block;width:100%;max-width:400px;padding:1rem 2rem;font-size:1rem;text-align:center">Contact Us &rarr;</a>
</div>

</section>

<!-- ===== WHY: THE NEED ===== -->
<section style="padding:5rem 0;background:var(--bg-dark);position:relative;overflow:hidden" id="why">
<div style="position:absolute;top:0;left:0;right:0;bottom:0;opacity:0.06;background:url('threat-image.jpg') center/cover no-repeat"></div>
<div class="container" style="position:relative;z-index:1">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)">The Need</div>
<div class="section-title fade-in" style="text-align:center;color:#fff">Why Passive Civilian Protection Is Needed More Than Ever</div>
<p class="fade-in" style="color:rgba(255,255,255,0.65);max-width:800px;margin:0.5rem auto 3rem;font-size:0.95rem;text-align:center;line-height:1.8">Recent conflicts have demonstrated the evolving nature of modern warfare. Ballistic missiles, cruise missiles, precision-guided weapons, and long-range unmanned aerial systems (UAS) are increasingly used against civilian populations and critical infrastructure. Countries face a particularly acute threat environment  -  with drone warfare rapidly evolving, critical energy infrastructure exposed to asymmetric attacks, and the strategic imperative to protect high-value economic zones.</p>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:2.5rem;align-items:center">
  <div>
    <div class="fade-in" style="margin-bottom:2rem">
      <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.8rem">
        <div style="min-width:4px;width:4px;align-self:stretch;background:rgba(220,38,38,0.6);border-radius:4px;flex-shrink:0"></div>
        <div>
          <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:#fff;margin-bottom:0.4rem">Active Defense Has Limits</h3>
          <p style="font-size:0.88rem;color:rgba(255,255,255,0.65);line-height:1.7">Even the most advanced missile interception systems cannot guarantee full protection. During large-scale coordinated attacks, active defense alone cannot completely prevent damage to civilian areas.</p>
        </div>
      </div>
      <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.8rem">
        <div style="min-width:4px;width:4px;align-self:stretch;background:rgba(37,99,235,0.6);border-radius:4px;flex-shrink:0"></div>
        <div>
          <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:#fff;margin-bottom:0.4rem">The Proven Doctrine</h3>
          <p style="font-size:0.88rem;color:rgba(255,255,255,0.65);line-height:1.7">Battle-tested experience has produced a comprehensive civil defense doctrine that combines active defense with extensive passive protection infrastructure  -  mandatory protective construction standards, municipal preparedness systems, and national civil defense management.</p>
        </div>
      </div>
      <div style="display:flex;align-items:flex-start;gap:1rem">
        <div style="min-width:4px;width:4px;align-self:stretch;background:rgba(22,163,74,0.6);border-radius:4px;flex-shrink:0"></div>
        <div>
          <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:#fff;margin-bottom:0.4rem">Energy &amp; Infrastructure at Stake</h3>
          <p style="font-size:0.88rem;color:rgba(255,255,255,0.65);line-height:1.7">Energy facilities, desalination plants, hospitals, and transportation networks are high-value targets. Nations investing in economic growth cannot afford to leave critical infrastructure unprotected. Traditional protection methods are heavy, consume critical space, lack proper sealing, block communication signals, and disrupt operational continuity. A new generation of protection technology is required.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="fade-in" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:2.5rem">
    <div style="font-family:var(--font-heading);font-size:0.72rem;text-transform:uppercase;letter-spacing:2px;color:var(--gold-bright);font-weight:600;margin-bottom:1.5rem">The Protection Gap</div>
    <div style="display:flex;flex-direction:column;gap:1.2rem">
      <div style="display:flex;align-items:center;gap:1rem">
        <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:rgba(220,38,38,0.8);min-width:60px">Zero</div>
        <div style="font-size:0.85rem;color:rgba(255,255,255,0.6);line-height:1.5">equivalent to comprehensive blast-resistant protected space building codes internationally</div>
      </div>
      <div style="height:1px;background:rgba(255,255,255,0.06)"></div>
      <div style="display:flex;align-items:center;gap:1rem">
        <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:rgba(37,99,235,0.8);min-width:60px">30+</div>
        <div style="font-size:0.85rem;color:rgba(255,255,255,0.6);line-height:1.5">years of battle-tested passive protection engineering behind our methodology</div>
      </div>
      <div style="height:1px;background:rgba(255,255,255,0.06)"></div>
      <div style="display:flex;align-items:center;gap:1rem">
        <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:rgba(22,163,74,0.8);min-width:60px">&lt;5d</div>
        <div style="font-size:0.85rem;color:rgba(255,255,255,0.6);line-height:1.5">to convert any existing room into a certified protected space using Shield 6000</div>
      </div>
    </div>
  </div>
</div>
</div>
</section>

<!-- ===== SERVICES: STRATEGIC PROTECTION ===== -->
<section class="pillars" id="pillars" style="padding:5rem 0;background:var(--bg-section)">
<div class="container">
<div class="pillars-header">
<div class="section-label fade-in">Our Solutions</div>
<div class="section-title fade-in">Three Pillars of Civilian Defense Protection Programs</div>
<div class="section-subtitle fade-in" style="margin:0 auto">From strategic consulting to national regulation  -  each pillar represents a complete service tier.</div>
</div>

<div class="svc-grid">
<!-- Card 1: Protection Advisory -->
<div class="svc-card primary fade-in">
<div class="svc-img">
<img src="<?php echo get_template_directory_uri(); ?>/images/facility-thumb.jpg" alt="Strategic Protection Advisory" loading="lazy">
<div class="svc-num">01</div>
</div>
<div class="svc-body">
<span class="svc-badge blue">PRIMARY SERVICE</span>
<h3>Strategic Protection Advisory</h3>
<p>Comprehensive assessments, emergency operations methodology, and integrated protection strategies from defense engineers.</p>
<ul>
<li>Engineering surveys &amp; vulnerability assessment</li>
<li>Emergency operations methodology</li>
<li>Protection planning &amp; characterization</li>
<li>Regulatory compliance roadmaps</li>
<li>Cost-benefit analysis</li>
</ul>
<a href="<?php echo home_url('/facility-assessment/'); ?>" class="svc-cta">Explore Advisory →</a>
</div>
</div>

<!-- Card 2: Execution -->
<div class="svc-card accent fade-in fade-in-delay-1">
<div class="svc-img">
<img src="<?php echo get_template_directory_uri(); ?>/images/shield-thumb.jpg" alt="Execution &amp; Physical Protection" loading="lazy">
<div class="svc-num">02</div>
</div>
<div class="svc-body">
<span class="svc-badge dark">EXECUTION</span>
<h3>Execution &amp; Physical Protection</h3>
<p>Shield 6000 (MG6000) spray-applied systems, structural reinforcement, safe room construction, and full project management.</p>
<ul>
<li>Shield 6000 (no demolition required)</li>
<li>Structural reinforcement &amp; blast protection</li>
<li>Safe room construction &amp; certification</li>
<li>Project management &amp; QA</li>
</ul>
<a href="<?php echo home_url('/execution/'); ?>" class="svc-cta">Explore Execution →</a>
</div>
</div>

<!-- Card 3: National Regulation -->
<div class="svc-card govt fade-in fade-in-delay-2">
<div class="svc-img">
<img src="<?php echo get_template_directory_uri(); ?>/images/national-thumb.jpg" alt="National Regulation Advisory" loading="lazy">
<div class="svc-num">03</div>
</div>
<div class="svc-body">
<span class="svc-badge red">GOVERNMENT</span>
<h3>National Regulation Advisory</h3>
<p>Developing mandatory protection building codes and regulatory frameworks. Modeled after the Civil Defense Law.</p>
<ul>
<li>Building code creation</li>
<li>6-pillar protection framework</li>
<li>Municipal programs</li>
<li>National resilience strategy</li>
</ul>
<a href="<?php echo home_url('/national-planning/'); ?>" class="svc-cta">Explore Regulation →</a>
</div>
</div>
</div>

</div>
</section>


<!-- ===== OUR SERVICES (detailed) ===== -->
<section style="padding:5rem 0;background:#fff;border-top:1px solid var(--border)" id="services">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)">What We Do</div>
<div class="section-title fade-in" style="text-align:center">Our Services</div>
<p class="fade-in" style="color:var(--text-light);max-width:720px;margin:0.5rem auto 2.5rem;font-size:0.95rem;text-align:center;line-height:1.7">End-to-end civil protection  -  from Home Front Command licensing and protected-space construction to upgrades, public-shelter rehabilitation, and statutory consulting.</p>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem" class="fade-in services-grid">

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<div style="width:56px;height:56px;background:rgba(37,99,235,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem">&#128737;</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Protective Rooms &amp; Structures Supply</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">Supply of protective rooms and fortified structures, including Home Front Command licensing for model approval and registration in the official HFC (Pikud HaOref) database.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<div style="width:56px;height:56px;background:rgba(22,163,74,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem">&#127968;</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Protected Space Construction</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">End-to-end design and construction of protected spaces (safe rooms / MAMAD) for private clients, kibbutzim, moshavim and more  -  full-service coverage for individuals and organizations.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<div style="width:56px;height:56px;background:rgba(200,168,75,0.10);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem">&#128295;</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Security &amp; Existing Room Upgrades</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">Upgrading security rooms and existing rooms to protective standard using Home Front Command&ndash;approved technologies  -  no demolition required.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<div style="width:56px;height:56px;background:rgba(220,38,38,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem">&#127963;</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Public Shelter Rehabilitation</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">Rehabilitation and restoration of public shelters for municipal authorities  -  bringing communal protection back to operational, code-compliant condition.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<div style="width:56px;height:56px;background:rgba(139,92,246,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem">&#128203;</div>
<h4 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);margin-bottom:0.6rem">Protection Consulting &amp; Permitting</h4>
<p style="font-size:0.88rem;color:var(--text-light);line-height:1.6">Protection consulting throughout statutory processes and building-permit procedures  -  including Home Front Command approvals and exceptions committees.</p>
</div>

</div>
</div>
</section>


<!-- ===== WHO WE SERVE ===== -->
<section style="padding:5rem 0;background:#fff" id="customers">
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
    <a href="<?php echo home_url('/customers/'); ?>#private" class="wws-cta">Request Private Consultation &rarr;</a>
  </div>
  <div class="wws-visual">
    <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80" alt="Private residence safe room" loading="lazy">
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
    <a href="<?php echo home_url('/customers/'); ?>#services" class="wws-cta green">Explore Public-Sector Solutions &rarr;</a>
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
    <a href="<?php echo home_url('/customers/'); ?>#gov" class="wws-cta">Explore Developer Solutions &rarr;</a>
  </div>
  <div class="wws-visual">
    <img src="<?php echo get_template_directory_uri(); ?>/images/national-thumb.jpg" alt="Developments and construction projects">
    <div class="wws-badge">Developers &amp; Companies</div>
  </div>
</div>

<div class="fade-in" style="text-align:center;margin-top:2.5rem">
<a href="<?php echo home_url('/customers/'); ?>" style="display:inline-block;padding:0.7rem 2rem;background:var(--gold);color:#fff;border-radius:8px;font-size:0.88rem;font-weight:600;transition:all 0.3s" onmouseover="this.style.background='var(--gold-light)'" onmouseout="this.style.background='var(--gold)'">See All Customer Solutions &rarr;</a>
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
<section class="fl-clients" id="clients">
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

<!-- ===== THREAT -Dark dramatic section ===== -->
<section class="threat" id="threat">
<div class="container">
<div class="section-label fade-in">The Threat</div>
<div class="section-title fade-in">An Operational Reality  -  Not a Theoretical Risk</div>
<p class="fade-in" style="color:rgba(255,255,255,0.7);max-width:700px;margin:0.5rem auto 2rem;font-size:0.95rem;text-align:center">Missile and drone attacks on civilian populations are no longer a theoretical risk but an operational reality for many countries. Strengthening civil protection and protective infrastructure has become a critical component of national resilience.</p>
<div class="threat-grid">
<div class="threat-cards">
<div class="threat-card fade-in">
<h3>Evolving Regional Missile &amp; Drone Threats</h3>
<p>Ballistic missiles, cruise missiles, precision-guided weapons, and long-range unmanned aerial systems are increasingly targeting civilian populations and critical infrastructure. Coordinated mass attacks can overwhelm even the most advanced air defense systems.</p>
</div>
<div class="threat-card fade-in fade-in-delay-1">
<h3>No Passive Protection Infrastructure</h3>
<p>Unlike nations with decades of conflict experience, most countries in the region have no mandatory protective construction standards, no shelter requirements, and no civil defense building codes. Buildings are designed for comfort  -  not survivability.</p>
</div>
<div class="threat-card fade-in fade-in-delay-2">
<h3>Critical Infrastructure at Risk</h3>
<p>Energy installations, desalination plants, transportation networks, hospitals, government institutions, and economic hubs remain unprotected. A single strike on energy infrastructure or critical facilities can cascade into national-level disruption affecting millions.</p>
</div>
<div class="threat-card fade-in fade-in-delay-3">
<h3>The Cost of Inaction</h3>
<p>For nations positioning as global business and investment destinations, protection gaps threaten economic continuity, foreign investment confidence, and long-term national resilience during prolonged conflicts.</p>
</div>
</div>
<div class="threat-right">
<div class="threat-image fade-in">
<img src="<?php echo get_template_directory_uri(); ?>/images/threat-image.jpg" alt="Shield 6000 fortified room under construction" loading="lazy">
</div>
</div>
</div>
<div class="fade-in" style="text-align:center;margin-top:2.5rem">
<a href="<?php echo home_url('/'); ?>#threat" style="display:inline-block;padding:0.7rem 2rem;border:1px solid rgba(255,255,255,0.3);border-radius:8px;color:rgba(255,255,255,0.85);font-size:0.88rem;font-weight:500;transition:all 0.3s;letter-spacing:0.02em" onmouseover="this.style.borderColor='rgba(255,255,255,0.6)';this.style.color='#fff'" onmouseout="this.style.borderColor='rgba(255,255,255,0.3)';this.style.color='rgba(255,255,255,0.85)'">Read the Full Strategic Brief &rarr;</a>
</div>
</div>
</section>

<!-- ===== CREDENTIALS ===== -->
<section class="credentials" id="credentials">
<div class="container">
<div class="section-label fade-in">Why Us</div>
<div class="section-title fade-in">Battle-Tested Credentials By Militaries and Ministries of Defense</div>
<p class="fade-in" style="color:var(--text-light);max-width:700px;margin:0.5rem auto 2rem;font-size:0.95rem;text-align:center">Fortline Global combines the most advanced leading protection technology and advisory companies  -  bringing decades of military-grade engineering, regulatory expertise, and active operational experience to every project. Backed by continuous R&amp;D investment from a privately-held, self-funded technology partner with over 18 years of innovation in protection and sealing solutions.</p>
<div class="cred-grid">
<div class="cred-cards">
<div class="cred-card fade-in">
<h3>Military &amp; Engineering Leadership</h3>
<p>Our core team is led by a retired Lt. Colonel (Res.) with 25 years of military experience and degrees in Architecture and Economics. Supported by a team of 5 senior engineers specializing in protective infrastructure, regulatory licensing, and project management  -  delivering end-to-end service from planning through execution.</p>
<div class="cred-stats">
<span class="cred-stat">25 Years Military</span>
<span class="cred-stat">5 Senior Engineers</span>
<span class="cred-stat">End-to-End Delivery</span>
</div>
</div>
<div class="cred-card fade-in fade-in-delay-1">
<h3>Proven Track Record</h3>
<p>Currently delivering protection for energy infrastructure, strategic facilities, public institutions, and residential projects. Key references include the Underground Tunnels, Rail Infra, municipal and national protection programs across.</p>
</div>
<div class="cred-card fade-in fade-in-delay-2">
<h3>Exclusive Patented Technology</h3>
<p>Rotem Shield Protection Technologies holds the international patent for Shield 6000  -  a patented super-polymer known as MG6000. Combined with our engineering advisory partner's Home Front Command licensing expertise, we offer a complete protection ecosystem  -  from rapid-deploy spray systems to full structural fortification.</p>
</div>
</div>
<div class="cred-right">
<div class="cred-image fade-in">
<img src="<?php echo get_template_directory_uri(); ?>/images/credentials-image.jpg" alt="Engineering team reviewing blueprints" loading="lazy">
</div>
<div class="cert-box fade-in fade-in-delay-1">
<h4>Military Home Front Command Certification</h4>
<p>The national military authority responsible for civilian protection. Their certification is the gold standard -requiring rigorous ballistic, blast, and durability testing equivalent to reinforced concrete safe rooms.</p>
</div>
<div class="cert-box fade-in fade-in-delay-2">
<h4>Ministry of Defense Approval</h4>
<p>Oversees all national defense procurement and technology validation. Confirms military-grade protection standards and classified testing protocols.</p>
</div>
<div class="cert-box fade-in fade-in-delay-3">
<h4>International Patent &amp; Standard 4422</h4>
<p>Globally registered patent protection. Certified under Standard 4422 for protected space door and window frames -ensuring full regulatory compliance.</p>
</div>
</div>
</div>
<div class="fade-in" style="text-align:center;margin-top:2.5rem">
<a href="<?php echo home_url('/about/'); ?>" style="display:inline-block;padding:0.7rem 2rem;border:1px solid var(--gold-border);border-radius:8px;color:var(--gold);font-size:0.88rem;font-weight:600;transition:all 0.3s" onmouseover="this.style.background='var(--gold)';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='var(--gold)'">Meet Our Team &rarr;</a>
</div>
</div>
</section>




<!-- ===== AREAS OF ACTIVITY ===== -->
<section style="padding:5rem 0;background:var(--bg-light)" id="sectors">
<div class="container">
<div class="section-label fade-in" style="text-align:center">Who We Protect</div>
<div class="section-title fade-in" style="text-align:center">Areas of Activity</div>
<p class="fade-in" style="color:var(--text-light);max-width:700px;margin:0.5rem auto 2.5rem;font-size:0.95rem;text-align:center;line-height:1.7">Our protection solutions span four key sectors  -  each with tailored approaches based on threat profiles, regulatory requirements, and operational constraints.</p>
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem" class="fade-in areas-grid">

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;text-align:center;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<div style="width:56px;height:56px;background:rgba(220,38,38,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 1rem">&#127981;</div>
<h4 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem">Defence</h4>
<p style="font-size:0.85rem;color:var(--text-light);line-height:1.6">Military installations, fortifications, border infrastructure, and strategic defense facilities requiring the highest protection standards.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;text-align:center;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<div style="width:56px;height:56px;background:rgba(37,99,235,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 1rem">&#127968;</div>
<h4 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem">Private</h4>
<p style="font-size:0.85rem;color:var(--text-light);line-height:1.6">Residential safe rooms, luxury properties, and private compounds. Discreet protection that integrates seamlessly with existing architecture.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;text-align:center;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<div style="width:56px;height:56px;background:rgba(22,163,74,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 1rem">&#9881;</div>
<h4 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem">Industrial</h4>
<p style="font-size:0.85rem;color:var(--text-light);line-height:1.6">Energy plants, desalination facilities, data centers, oil &amp; gas infrastructure, and critical industrial assets across the Gulf region.</p>
</div>

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 1.5rem;text-align:center;transition:all 0.3s" onmouseover="this.style.borderColor='rgba(37,99,235,0.3)';this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
<div style="width:56px;height:56px;background:rgba(139,92,246,0.08);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 1rem">&#127963;</div>
<h4 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--text-dark);margin-bottom:0.5rem">Institutional</h4>
<p style="font-size:0.85rem;color:var(--text-light);line-height:1.6">Hospitals, schools, government buildings, embassies, and public institutions where continuity of operations and civilian safety are paramount.</p>
</div>

</div>
</div>
</section>

<!-- ===== THE TECHNOLOGY ===== -->
<section style="padding:5rem 0;background:var(--bg-dark);position:relative;border-top:1px solid rgba(255,255,255,0.06)" id="technology">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)">The Technology</div>
<div class="section-title fade-in" style="text-align:center;color:#fff">Breakthrough Protection Solutions</div>
<p class="fade-in" style="color:rgba(255,255,255,0.6);max-width:700px;margin:0.5rem auto 3rem;font-size:0.95rem;text-align:center;line-height:1.8">Powered by Rotem Magen Protective Technologies  -  pioneers in protection and sealing with over 18 years of engineering patented solutions for defense, industrial, and civilian applications.</p>

<!-- Product Portfolio -->
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.5rem;margin-bottom:4rem;max-width:900px;margin-left:auto;margin-right:auto" class="fade-in">
<div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:2rem;text-align:center">
<div style="font-family:var(--font-heading);font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:0.6rem">E-Panel</div>
<div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--gold-bright);margin-bottom:1rem;font-weight:600">Modular Composite</div>
<p style="font-size:0.85rem;color:rgba(255,255,255,0.6);line-height:1.6">Blast- and ballistic-resistant modular composite protection panel. Rapid installation for perimeter and structural hardening.</p>
</div>
<div style="background:rgba(37,99,235,0.08);border:2px solid rgba(37,99,235,0.25);border-radius:16px;padding:2rem;text-align:center;position:relative">
<div style="position:absolute;top:-10px;left:50%;transform:translateX(-50%);background:var(--gold-bright);color:#fff;font-size:0.65rem;font-weight:700;padding:0.2rem 0.8rem;border-radius:20px;letter-spacing:1px;text-transform:uppercase">Flagship</div>
<div style="font-family:var(--font-heading);font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:0.6rem">Magen 6000 <span style="font-size:0.75rem;color:var(--gold-bright)">(MG6000)</span></div>
<div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:1.5px;color:var(--gold-bright);margin-bottom:1rem;font-weight:600">Shield 6000 Spray System</div>
<p style="font-size:0.85rem;color:rgba(255,255,255,0.6);line-height:1.6">Converts standard spaces and facilities into highly protected zones. A patented super-polymer that creates a dense nanometric network, bonding with walls from within.</p>
</div>
</div>

<!-- Concrete Thickness Multiplier -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center;margin-bottom:4rem" class="fade-in">
<div>
<div style="font-family:var(--font-heading);font-size:0.72rem;text-transform:uppercase;letter-spacing:2px;color:var(--gold-bright);font-weight:600;margin-bottom:1rem">Concrete Thickness Multiplier</div>
<h3 style="font-family:var(--font-heading);font-size:1.6rem;font-weight:700;color:#fff;margin-bottom:1rem;line-height:1.3">8-10mm That Doubles Your Wall Strength</h3>
<p style="font-size:0.92rem;color:rgba(255,255,255,0.65);line-height:1.7;margin-bottom:1.5rem">Validated through official tests by the IDF Corps of Engineers and the Home Front Command. A thin application layer of MG6000 transforms standard construction into military-grade protection.</p>
<div style="display:flex;flex-direction:column;gap:0.8rem">
<div style="display:flex;align-items:center;gap:0.8rem">
<div style="width:8px;height:8px;background:#3b82f6;border-radius:50%;flex-shrink:0"></div>
<span style="font-size:0.85rem;color:rgba(255,255,255,0.7)">8-10mm Magen 6000 layer upgrades a 20cm wall to 40cm concrete equivalent</span>
</div>
<div style="display:flex;align-items:center;gap:0.8rem">
<div style="width:8px;height:8px;background:#dc2626;border-radius:50%;flex-shrink:0"></div>
<span style="font-size:0.85rem;color:rgba(255,255,255,0.7)">Withstood direct 120mm mortar impact  -  zero penetration, no spalling</span>
</div>
<div style="display:flex;align-items:center;gap:0.8rem">
<div style="width:8px;height:8px;background:#16a34a;border-radius:50%;flex-shrink:0"></div>
<span style="font-size:0.85rem;color:rgba(255,255,255,0.7)">IDF Corps of Engineers approved as a concrete thickness multiplier</span>
</div>
<div style="display:flex;align-items:center;gap:0.8rem">
<div style="width:8px;height:8px;background:var(--gold-bright);border-radius:50%;flex-shrink:0"></div>
<span style="font-size:0.85rem;color:rgba(255,255,255,0.7)">Home Front Command certified for enhanced frontline protection standard</span>
</div>
</div>
</div>
<div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:1.5rem;text-align:center">
<img src="<?php echo get_template_directory_uri(); ?>/images/mg6000-multiplier.png" alt="MG6000 Concrete Thickness Multiplier - 8-10mm layer equals 40cm concrete" loading="lazy" style="max-width:100%;border-radius:8px">
<p style="font-size:0.75rem;color:rgba(255,255,255,0.4);margin-top:0.8rem">Validated by IDF Corps of Engineers &amp; Home Front Command</p>
</div>
</div>

<!-- Key Properties Grid -->
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:4rem" class="fade-in">
<div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:1.2rem;display:flex;align-items:flex-start;gap:0.8rem">
<div style="min-width:36px;height:36px;background:rgba(37,99,235,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem">&#128170;</div>
<div>
<div style="font-family:var(--font-heading);font-size:0.82rem;font-weight:600;color:#fff;margin-bottom:0.2rem">Exceptional Strength</div>
<p style="font-size:0.75rem;color:rgba(255,255,255,0.5);line-height:1.5">Patented super-polymer creates a dense nanometric network bonding with the structure</p>
</div>
</div>
<div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:1.2rem;display:flex;align-items:flex-start;gap:0.8rem">
<div style="min-width:36px;height:36px;background:rgba(22,163,74,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem">&#128225;</div>
<div>
<div style="font-family:var(--font-heading);font-size:0.82rem;font-weight:600;color:#fff;margin-bottom:0.2rem">Full Communication Continuity</div>
<p style="font-size:0.75rem;color:rgba(255,255,255,0.5);line-height:1.5">Signals pass through  -  critical for command centers, data centers, and operational facilities</p>
</div>
</div>
<div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:1.2rem;display:flex;align-items:flex-start;gap:0.8rem">
<div style="min-width:36px;height:36px;background:rgba(220,38,38,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem">&#9879;</div>
<div>
<div style="font-family:var(--font-heading);font-size:0.82rem;font-weight:600;color:#fff;margin-bottom:0.2rem">Chemical &amp; Unconventional Protection</div>
<p style="font-size:0.75rem;color:rgba(255,255,255,0.5);line-height:1.5">Seals and reinforces against both conventional threats and chemical exposure</p>
</div>
</div>
<div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:1.2rem;display:flex;align-items:flex-start;gap:0.8rem">
<div style="min-width:36px;height:36px;background:rgba(37,99,235,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem">&#127793;</div>
<div>
<div style="font-family:var(--font-heading);font-size:0.82rem;font-weight:600;color:#fff;margin-bottom:0.2rem">Non-Toxic Material</div>
<p style="font-size:0.75rem;color:rgba(255,255,255,0.5);line-height:1.5">Safe for hospitals, hotels, schools, and residential applications</p>
</div>
</div>
<div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:1.2rem;display:flex;align-items:flex-start;gap:0.8rem">
<div style="min-width:36px;height:36px;background:rgba(22,163,74,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem">&#9889;</div>
<div>
<div style="font-family:var(--font-heading);font-size:0.82rem;font-weight:600;color:#fff;margin-bottom:0.2rem">Dual Solution</div>
<p style="font-size:0.75rem;color:rgba(255,255,255,0.5);line-height:1.5">Protection AND sealing in a single system  -  reducing work stages and overall cost</p>
</div>
</div>
<div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:1.2rem;display:flex;align-items:flex-start;gap:0.8rem">
<div style="min-width:36px;height:36px;background:rgba(220,38,38,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem">&#128176;</div>
<div>
<div style="font-family:var(--font-heading);font-size:0.82rem;font-weight:600;color:#fff;margin-bottom:0.2rem">Significant CAPEX Reduction</div>
<p style="font-size:0.75rem;color:rgba(255,255,255,0.5);line-height:1.5">Reduces concrete and steel requirements, enabling faster and more cost-effective construction</p>
</div>
</div>
</div>

<!-- Economic Value Bar -->
<div style="background:linear-gradient(135deg,rgba(37,99,235,0.08),rgba(37,99,235,0.02));border:1px solid rgba(37,99,235,0.15);border-radius:16px;padding:2rem 2.5rem;display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;text-align:center" class="fade-in">
<div>
<div style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--gold-bright);margin-bottom:0.3rem">&#8595; CAPEX</div>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.5)">Less concrete &amp; steel needed</p>
</div>
<div>
<div style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--gold-bright);margin-bottom:0.3rem">&#8593; Space</div>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.5)">Thin layer preserves interior</p>
</div>
<div>
<div style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--gold-bright);margin-bottom:0.3rem">&#8595; Time</div>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.5)">Fast implementation, fewer stages</p>
</div>
<div>
<div style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--gold-bright);margin-bottom:0.3rem">&#8593; Lifespan</div>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.5)">Protects concrete, extends asset life</p>
</div>
</div>
</div>
</section>

<!-- ===== STRATEGIC BENEFITS ===== -->
<section style="padding:5rem 0;background:var(--bg-dark);position:relative" id="benefits">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)">Strategic Impact</div>
<div class="section-title fade-in" style="text-align:center;color:#fff">What This Framework Delivers</div>
<p class="fade-in" style="color:rgba(255,255,255,0.6);max-width:700px;margin:0.5rem auto 3rem;font-size:0.95rem;text-align:center">Implementation of a national civil protection program enables countries to achieve measurable, strategic outcomes.</p>

<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:1.2rem" class="fade-in">
<div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:1.5rem;text-align:center">
<div style="width:48px;height:48px;background:rgba(220,38,38,0.12);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin:0 auto 0.8rem">&#128737;</div>
<h4 style="font-family:var(--font-heading);font-size:0.88rem;color:#fff;margin-bottom:0.4rem;font-weight:600">Reduce Casualties</h4>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.5);line-height:1.5">Proven protection of civilian populations during missile and drone attacks</p>
</div>
<div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:1.5rem;text-align:center">
<div style="width:48px;height:48px;background:rgba(37,99,235,0.12);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin:0 auto 0.8rem">&#9881;</div>
<h4 style="font-family:var(--font-heading);font-size:0.88rem;color:#fff;margin-bottom:0.4rem;font-weight:600">Protect Infrastructure</h4>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.5);line-height:1.5">Safeguard energy, transportation, and essential services from disruption</p>
</div>
<div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:1.5rem;text-align:center">
<div style="width:48px;height:48px;background:rgba(22,163,74,0.12);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin:0 auto 0.8rem">&#127963;</div>
<h4 style="font-family:var(--font-heading);font-size:0.88rem;color:#fff;margin-bottom:0.4rem;font-weight:600">Municipal Readiness</h4>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.5);line-height:1.5">Strengthen local preparedness and emergency response capabilities</p>
</div>
<div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:1.5rem;text-align:center">
<div style="width:48px;height:48px;background:rgba(37,99,235,0.12);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin:0 auto 0.8rem">&#128170;</div>
<h4 style="font-family:var(--font-heading);font-size:0.88rem;color:#fff;margin-bottom:0.4rem;font-weight:600">National Resilience</h4>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.5);line-height:1.5">Maintain continuity and stability during prolonged conflicts</p>
</div>
<div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:1.5rem;text-align:center">
<div style="width:48px;height:48px;background:rgba(22,163,74,0.12);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin:0 auto 0.8rem">&#128200;</div>
<h4 style="font-family:var(--font-heading);font-size:0.88rem;color:#fff;margin-bottom:0.4rem;font-weight:600">Economic Continuity</h4>
<p style="font-size:0.78rem;color:rgba(255,255,255,0.5);line-height:1.5">Preserve economic activity, investment confidence, and societal function</p>
</div>
</div>
</div>
</section>

<!-- ===== PROCESS ===== -->
<section class="process" id="process">
<div class="container">
<div class="process-header">
<div class="section-label fade-in">How It Works</div>
<div class="section-title fade-in">From Assessment to Protection</div>
</div>
<div class="timeline">
<div class="tl-step fade-in">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600&q=80" alt="Assessment meeting" loading="lazy"></div>
<div class="tl-num">1</div>
<h3>Confidential Assessment</h3>
<p>Initial consultation under strict NDA. We understand your facility, threat profile, and objectives.</p>
</div>
<div class="tl-step fade-in fade-in-delay-1">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600&q=80" alt="Engineering blueprints" loading="lazy"></div>
<div class="tl-num">2</div>
<h3>Gap Analysis &amp; Design</h3>
<p>Structural assessment, protection gap identification, custom fortification plan.</p>
</div>
<div class="tl-step fade-in fade-in-delay-2">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=600&q=80" alt="Solution delivery" loading="lazy"></div>
<div class="tl-num">3</div>
<h3>Solution Delivery</h3>
<p>Consulting, regulatory framework, or Shield 6000 installation on accelerated timelines.</p>
</div>
<div class="tl-step fade-in fade-in-delay-3">
<div class="tl-img"><img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&q=80" alt="Certification handshake" loading="lazy"></div>
<div class="tl-num">4</div>
<h3>Certification &amp; Training</h3>
<p>Full documentation, staff emergency protocol training, ongoing support.</p>
</div>
</div>
</div>
</section>

<!-- ===== CONTACT ===== -->
<section class="contact" id="contact">
<div class="container">
<div class="section-label fade-in">Get Started</div>
<div class="section-title fade-in" style="margin-bottom:2rem">Request a Confidential Assessment</div>
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
<label>Type of Inquiry</label>
<select name="inquiry_type"><option value="">Select type</option><option>Shield 6000 Installation</option><option>Protection Advisory</option><option>National Regulation</option><option>Government / Regulatory</option><option>Other</option></select>
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
<div><h4>Fast SLA</h4><p>We commit to rapid response times on all inquiries. Mark urgent for priority handling.</p></div>
</div>
<div class="info-card">
<div><h4>Global Deployment</h4><p>Based in the Middle East, deployable across the Gulf, Southeast Asia, and worldwide.</p></div>
</div>
<div class="info-card">
<div><h4>Warzone Defense Heritage</h4><p>Built on 25 years of Military Home Front Command protection engineering and the most battle-tested civilian protection program in the world.</p></div>
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
<p class="footer-tagline">Warzone defense-grade protection technology for critical infrastructure worldwide.</p>
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
to_email:'eddie.nudel@gmail.com',
from_name:data.name,
from_email:data.email,
organization:data.organization,
phone:data.phone||'Not provided',
inquiry_type:data.inquiry_type||'Not specified',
facility_type:data.facility_type||'Not specified',
message:data.message||'No message provided',
subject:'New Fortline Global Inquiry from '+data.name
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

</script>

<?php get_footer(); ?>