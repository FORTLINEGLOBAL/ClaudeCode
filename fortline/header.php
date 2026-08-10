<?php
/**
 * Header Template
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/brand/ari-favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/brand/ari-favicon-180w.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

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
/* solid nav state — used on every page without a dark hero (all non-home pages) */
.nav.solid{background:rgba(255,255,255,0.97);backdrop-filter:blur(20px);border-bottom:1px solid var(--border);box-shadow:var(--shadow)}
.nav.solid .nav-logo-text,.nav.solid .nav-links a{color:var(--text-dark)}
.nav.solid .nav-logo-text span{color:var(--gold-bright)}
.nav.solid .nav-links a:hover{color:var(--gold-light)}
.nav.solid .nav-links a.active{color:var(--gold-bright)}
.nav.solid .nav-logo-light{display:none}.nav.solid .nav-logo-dark{display:block}
.nav.solid .hamburger span{background:var(--text-dark)}
/* ===== visual card system (services / areas / advantages) ===== */
.vgrid{display:grid;grid-template-columns:repeat(auto-fit,minmax(258px,1fr));gap:1.6rem}
.vcard{background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden;display:flex;flex-direction:column;transition:transform .3s,box-shadow .3s,border-color .3s;text-decoration:none}
.vcard:hover{transform:translateY(-4px);box-shadow:0 14px 40px rgba(11,22,44,0.12);border-color:var(--gold-border)}
.vcard-img{position:relative;height:186px;overflow:hidden;background:var(--bg-dark)}
.vcard-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s ease}
.vcard:hover .vcard-img img{transform:scale(1.06)}
.vcard-img::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,22,40,0) 45%,rgba(10,22,40,.4))}
.vcard-kicker{position:absolute;left:1rem;bottom:.9rem;z-index:2;color:#fff;font-family:var(--font-heading);font-size:.68rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;background:var(--gold-light);padding:.26rem .7rem;border-radius:6px}
.vcard-body{padding:1.5rem 1.4rem;display:flex;flex-direction:column;gap:.55rem;flex:1}
.vcard-body h4{font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-dark);line-height:1.3;margin:0}
.vcard-body p{font-size:.88rem;color:var(--text-light);line-height:1.65;margin:0}
/* ===== stacked Who-We-Serve feature rows (replaces tabs) ===== */
.wws-stack{display:flex;flex-direction:column;gap:3.6rem;margin-top:1rem}
.wws-row{display:grid;grid-template-columns:1fr 1fr;gap:2.8rem;align-items:center}
.wws-row.rev .wws-rc{order:2}
@media(max-width:820px){.wws-row,.wws-row.rev{grid-template-columns:1fr}.wws-row.rev .wws-rc{order:0}}
/* ===== interior page hero (video banner on inner pages) ===== */
.page-hero{position:relative;min-height:50vh;display:flex;align-items:center;justify-content:center;text-align:center;overflow:hidden;background:var(--bg-dark);padding:7rem 1.5rem 4rem}
.page-hero video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0}
.page-hero::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,22,40,.72),rgba(10,22,40,.86));z-index:1}
.page-hero .ph-inner{position:relative;z-index:2;max-width:820px;margin:0 auto}
.page-hero .ph-label{font-family:var(--font-heading);font-size:.78rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--gold-bright)}
.page-hero h1{font-family:var(--font-heading);color:#fff;font-weight:700;line-height:1.12;font-size:clamp(2rem,4.6vw,3.1rem);margin:.7rem 0 0;text-wrap:balance}
.page-hero p{color:rgba(255,255,255,.78);max-width:680px;margin:1rem auto 0;font-size:1rem;line-height:1.7}
@media(max-width:640px){.page-hero{min-height:44vh;padding:6rem 1.2rem 3rem}}
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
.fl-tst-logo.has-img{background:#fff;border:1px solid rgba(11,22,44,0.08)}
.fl-tst-logo.has-img img{width:100%;height:100%;object-fit:contain;padding:6px;box-sizing:border-box}
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
<!-- ===== NAVIGATION ===== -->
<nav class="nav" id="nav">
<div class="nav-inner">
<a href="<?php echo home_url('/'); ?>" class="nav-logo" aria-label="A.R.I. Faberman Engineering Solutions Ltd.">
<img src="<?php echo get_template_directory_uri(); ?>/images/brand/ari-logo-horizontal-reversed.svg" alt="A.R.I. Faberman Engineering Solutions Ltd." class="nav-logo-img nav-logo-light">
<img src="<?php echo get_template_directory_uri(); ?>/images/brand/ari-logo-horizontal.svg" alt="" aria-hidden="true" class="nav-logo-img nav-logo-dark">
</a>
<div class="nav-links">
<a href="<?php echo home_url('/services/'); ?>" data-i18n="nav2.services">Services</a>
<a href="<?php echo home_url('/projects/'); ?>" data-i18n="nav2.projects">Projects</a>
<a href="<?php echo home_url('/who-we-serve/'); ?>" data-i18n="nav2.serve">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>" data-i18n="nav2.about">About</a>
<a href="<?php echo home_url('/faq/'); ?>" data-i18n="nav2.faq">FAQ</a>
</div>
<div class="nav-right">
<div id="lang-toggle"></div>
<a href="<?php echo home_url('/contact/'); ?>" class="nav-cta">Contact Us</a>
</div>
<div class="hamburger" onclick="document.getElementById('mobileMenu').classList.add('open')">
<span></span><span></span><span></span>
</div>
</div>
</nav>

<div class="mobile-menu" id="mobileMenu">
<div class="mobile-close" onclick="this.parentElement.classList.remove('open')">&times;</div>
<a href="<?php echo home_url('/services/'); ?>" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.services">Services</a>
<a href="<?php echo home_url('/projects/'); ?>" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.projects">Projects</a>
<a href="<?php echo home_url('/who-we-serve/'); ?>" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.serve">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.about">About</a>
<a href="<?php echo home_url('/faq/'); ?>" onclick="this.parentElement.classList.remove('open')" data-i18n="nav2.faq">FAQ</a>
<a href="<?php echo home_url('/contact/'); ?>" onclick="this.parentElement.classList.remove('open')" class="btn-gold" style="margin-top:1rem">Contact Us</a>
</div>
