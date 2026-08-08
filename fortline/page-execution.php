<?php
/**
 * Template Name: Execution
 * Description: Execution page
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

/* ===== SHIELD 6000 SECTION ===== */
.shield6000-section{padding:5rem 0;background:var(--bg-light)}
.shield6000-header{margin-bottom:2.5rem}
.shield6000-top{display:grid;grid-template-columns:1.2fr 1fr;gap:3rem;align-items:start}
.shield6000-left{display:flex;flex-direction:column;gap:1.5rem}
.shield6000-text{font-size:0.95rem;color:var(--text-mid);line-height:1.7}
.shield6000-features{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.shield6000-feat{
background:var(--bg-card);border:1px solid var(--border);
border-radius:10px;padding:1.1rem;
transition:all 0.3s;
}
.shield6000-feat:hover{border-color:var(--gold-border);box-shadow:var(--shadow)}
.shield6000-feat h4{font-size:0.95rem;font-weight:600;margin-bottom:0.3rem;color:var(--text-dark)}
.shield6000-feat p{font-size:0.85rem;color:var(--text-light);line-height:1.55}
.shield6000-tags{display:flex;flex-wrap:wrap;gap:0.7rem;margin-top:1rem}
.shield6000-tag{
display:inline-flex;align-items:center;
background:var(--gold-dim);border:1px solid var(--gold-border);
padding:0.3rem 0.8rem;border-radius:4px;
}
.shield6000-tag-text{font-size:0.75rem;font-weight:600;color:var(--gold);letter-spacing:0.05em;text-transform:uppercase}
.shield6000-cta{
display:inline-block;
background:var(--gold-light);color:#fff;
padding:0.75rem 1.5rem;border-radius:8px;
font-weight:600;font-size:0.9rem;
transition:all 0.3s;
margin-top:1rem;
}
.shield6000-cta:hover{background:var(--gold-bright);transform:translateY(-2px)}
.shield6000-media{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:2.5rem}
.shield6000-media img.spray-img{width:100%;display:block;aspect-ratio:16/9;object-fit:cover;border-radius:12px;box-shadow:var(--shadow-lg)}
.shield6000-media .video-caption{margin-top:0.5rem;font-size:0.75rem;color:var(--text-light);text-align:center;font-style:italic}
.shield6000-right iframe{width:100%;height:100%;display:block;border:none}

/* ===== CONSTRUCTION SECTION ===== */
.construction{padding:5rem 0;background:var(--bg-section)}
.construction-content{display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center}
.construction-image{border-radius:12px;overflow:hidden;box-shadow:var(--shadow-lg);height:100%;min-height:400px}
.construction-image img{width:100%;height:100%;object-fit:cover}
.construction-right h2{
font-family:var(--font-heading);font-size:2.2rem;font-weight:700;
line-height:1.2;margin-bottom:1rem;color:var(--text-dark);
}
.construction-text{font-size:0.95rem;color:var(--text-mid);line-height:1.7;margin-bottom:1.5rem}
.service-list{display:flex;flex-direction:column;gap:0.7rem;margin-bottom:1.5rem}
.service-item{
display:flex;align-items:flex-start;gap:0.7rem;
font-size:0.95rem;color:var(--text-mid);line-height:1.6;
}
.service-item::before{
content:'✓';color:var(--green);font-weight:700;font-size:1.1rem;
flex-shrink:0;margin-top:2px;
}
.construction-note{
background:var(--red-dim);border:1px solid rgba(220,38,38,0.2);
border-radius:10px;padding:1rem 1.2rem;
font-size:0.88rem;color:var(--text-dark);line-height:1.65;
}

/* ===== GALLERY SECTION ===== */
.gallery{padding:5rem 0;background:var(--bg)}
.gallery-header{text-align:center;margin-bottom:3.5rem}
.gallery-header .section-subtitle{margin:0 auto}
.gallery-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.5rem}
.gallery-card{
border-radius:12px;overflow:hidden;
box-shadow:var(--shadow);
transition:all 0.3s;
cursor:pointer;
aspect-ratio:16/9;
position:relative;
}
.gallery-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-4px)}
.gallery-card img{width:100%;height:100%;object-fit:cover;transition:transform 0.4s}
.gallery-card:hover img{transform:scale(1.05)}
.gallery-caption{
position:absolute;bottom:0;left:0;right:0;
background:linear-gradient(180deg,transparent,rgba(0,0,0,0.7));
color:#fff;padding:1.5rem;
font-size:0.95rem;font-weight:600;
}

/* ===== PROCESS ===== */
.process{padding:5rem 0;background:var(--bg-light)}
.process-header{text-align:center;margin-bottom:3.5rem}
.timeline{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;position:relative}
.timeline::before{
content:'';position:absolute;
top:22px;left:12.5%;right:12.5%;
height:2px;
background:linear-gradient(90deg,transparent,var(--gold-light),var(--gold-light),transparent);
z-index:1;
}
.tl-step{text-align:center;position:relative}
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
.section-title{font-size:2.2rem}
.shield6000-section{padding:2.5rem 0}
.construction{padding:2.5rem 0}
.gallery{padding:2.5rem 0}
.process{padding:2.5rem 0}
.contact{padding:2.5rem 0}
.timeline{grid-template-columns:repeat(2, 1fr)}
.shield6000-top{grid-template-columns:1fr}
.shield6000-media{grid-template-columns:1fr}
.construction-content{grid-template-columns:1fr}
.gallery-grid{grid-template-columns:1fr}
.hero-content{gap:2rem}
}

@media(max-width:768px){
.footer-inner{grid-template-columns:1fr 1fr;gap:2rem}
.footer-brand{grid-column:1/-1}

.nav{background:#fff!important;box-shadow:0 1px 4px rgba(0,0,0,0.08)}
.nav-logo-text{color:var(--text-dark)!important}
.nav-links{display:none}
.hamburger{display:flex}
.hamburger span{background:var(--text-dark)!important}
.nav-cta{display:none}
.mobile-menu.open .btn-gold{display:inline-block;margin-top:1rem}
.container{padding:0 1rem}
.shield6000-section{padding:2.5rem 0}
.construction{padding:2.5rem 0}
.gallery{padding:2.5rem 0}
.process{padding:2.5rem 0}
.contact{padding:2.5rem 0}
.hero{min-height:auto;padding:6rem 0 0}
.hero h1{font-size:2.2rem;font-weight:400}
.hero-content{flex-direction:column;align-items:flex-start;gap:1.5rem;padding-bottom:1.5rem;padding-top:0}
.hero-sub{font-size:0.9rem}
.hero-breadcrumb{font-size:0.75rem;top:4rem;left:1rem;display:none}
.hero-left{display:none!important}
.hero-left a,.hero-left span{font-size:0.7rem;padding:0.4rem 0.8rem}
.hero-right{order:1}
.hero-stats{position:relative;flex-direction:row;flex-wrap:wrap}
.hero-stat{flex:1 1 50%;padding:1rem;border-bottom:1px solid rgba(255,255,255,0.1)}
.hero-stat-num{font-size:1.6rem}
.hero-stat-label{font-size:0.72rem}
.hero-btns{display:flex!important;flex-direction:column;gap:0.8rem;align-items:stretch}
.hero-btns .btn-gold,.hero-btns .btn-white{width:100%;text-align:center}
.section-title{font-size:1.6rem}
.section-subtitle{max-width:100%}
.shield6000-features{grid-template-columns:1fr}
.shield6000-media{grid-template-columns:1fr;gap:1.5rem}
.shield6000-tags{flex-wrap:wrap;flex-direction:row}
.shield6000-top{grid-template-columns:1fr}
.construction-content{grid-template-columns:1fr;gap:1.5rem}
.construction-image{min-height:250px}
.service-list{flex-direction:column;margin-bottom:1rem;gap:1.5rem}
.timeline{grid-template-columns:1fr}
.timeline::before{display:none}
.tl-step{text-align:left}
.tl-num{margin-left:0}
.defense-badges{flex-direction:column;gap:1rem}
.form-row{grid-template-columns:1fr}
.contact-form-box{padding:1.5rem}
.contact-grid{grid-template-columns:1fr;gap:1.5rem}
.gallery-grid{grid-template-columns:1fr;gap:1.5rem}



}

@media(max-width:480px){
.footer-inner{grid-template-columns:1fr}

.hero h1{font-size:1.8rem}
.hero-stat-num{font-size:1.3rem}
.hero-stat{flex:1 1 50%;padding:0.8rem}
.hero-stat-label{font-size:0.7rem}
.hero-left a,.hero-left span{font-size:0.65rem;padding:0.35rem 0.7rem}
.section-title{font-size:1.4rem}
.hero-btns{flex-direction:column;width:100%}
.btn-gold,.btn-white{width:100%;text-align:center;padding:0.75rem 1rem}
.hero-sub{font-size:0.95rem}
.shield6000-features{grid-template-columns:1fr}
.shield6000-media{grid-template-columns:1fr}
.shield6000-feat{padding:0.8rem}
.construction-content{grid-template-columns:1fr}
.construction-right h2{font-size:1.6rem}
.gallery-grid{grid-template-columns:1fr}
.timeline{grid-template-columns:1fr}
.form-row{grid-template-columns:1fr}
.defense-badges{gap:0.5rem}

}

</style>



<!-- ===== NAVIGATION ===== -->
<nav class="nav" id="nav">
<div class="nav-inner">
<a href="<?php echo home_url('/'); ?>" class="nav-logo">
<svg viewBox="0 0 40 40" fill="none"><path d="M20 2L36 11V29L20 38L4 29V11L20 2Z" stroke="#3b82f6" stroke-width="1.5" fill="rgba(37,99,235,0.1)"/><path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" stroke="#3b82f6" stroke-width="1" fill="none"/><line x1="20" y1="14" x2="20" y2="26" stroke="#3b82f6" stroke-width="1"/><line x1="14" y1="18" x2="26" y2="18" stroke="#3b82f6" stroke-width="0.8"/><line x1="14" y1="22" x2="26" y2="22" stroke="#3b82f6" stroke-width="0.8"/></svg>
<div class="nav-logo-text">ARI<span> Engineering</span></div>
</a>
<div class="nav-links">
<a href="<?php echo home_url('/'); ?>#pillars">Solutions</a>
<a href="<?php echo home_url('/facility-assessment/'); ?>">Protection Advisory</a>
<a href="<?php echo home_url('/execution/'); ?>">Execution</a>
<a href="<?php echo home_url('/national-planning/'); ?>">National Regulation</a>
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
<a href="<?php echo home_url('/customers/'); ?>" onclick="this.parentElement.classList.remove('open')">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>" onclick="this.parentElement.classList.remove('open')">About</a>
<a href="<?php echo home_url('/articles/'); ?>" onclick="this.parentElement.classList.remove('open')">Articles</a>
<a href="<?php echo home_url('/customers/'); ?>#contact" onclick="this.parentElement.classList.remove('open')" class="btn-gold" style="margin-top:1rem">Contact Us</a>
</div>

<!-- ===== HERO ===== -->
<section class="hero" id="hero">
<div class="hero-video-wrap">
<video autoplay muted loop playsinline>
<source src="<?php echo get_template_directory_uri(); ?>/images/execution-bg.mp4" type="video/mp4">
</video>
</div>

<div class="hero-breadcrumb fade-in">
<a href="<?php echo home_url('/'); ?>">Home</a><span>/</span>
<strong style="color:#fff">EXECUTION</strong>
</div>

<div class="hero-content">
<div class="hero-left fade-in fade-in-delay-2">
<div class="defense-badges">
<div class="defense-badge gold-badge">
<span class="defense-badge-text">Israeli Teams</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Shield 6000 Deployment</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Structural Reinforcement</span>
</div>
<div class="defense-badge">
<span class="defense-badge-text">Defense-Certified</span>
</div>
</div>
</div>

<div class="hero-right">
<h1 class="fade-in">
Execution &<br>Physical Protection<span class="red-dot">.</span>
</h1>
<p class="hero-sub fade-in fade-in-delay-1">
We Deploy Protection &mdash; From Rapid Room Fortification to Full-Scale Projects<br>Defense-grade execution from Israeli and local military engineers
</p>
<div class="hero-btns fade-in fade-in-delay-3">
<a href="#contact" class="btn-gold">Request Assessment →</a>
</div>
</div>
</div>
</section>

<!-- ===== SHIELD 6000 SECTION ===== -->
<section class="shield6000-section" id="shield6000">
<div class="container">
<div class="shield6000-header fade-in">
<div class="section-label">Our Core Deployment Capability</div>
<h2 style="font-family:var(--font-heading);font-size:2.2rem;font-weight:700;line-height:1.2;margin-bottom:1rem;color:var(--text-dark)">Shield 6000 — Fortify Any Existing Space in Days</h2>
</div>
<div class="shield6000-top">
<div class="shield6000-left fade-in fade-in-delay-1">
<p class="shield6000-text">
For private facilities, commercial buildings, and high-value assets that cannot undergo major structural work &mdash; Shield 6000 is the solution. A patented 8-10mm polymeric silicone compound is sprayed directly onto existing walls, combined with certified protective door and window frames. The result: a defense-certified safe room in approximately 5 working days, with zero demolition, no disruption to operations, and an aesthetic finish painted in the customer's color of choice. The room is sealed and invisible in daily use &mdash; no need to change furnishings.
</p>
</div>
<div class="fade-in fade-in-delay-2">
<div class="shield6000-features">
<div class="shield6000-feat">
<h4>No Demolition Required</h4>
<p>Apply directly to existing walls</p>
</div>
<div class="shield6000-feat">
<h4>Installed in Days</h4>
<p>Not months of construction</p>
</div>
<div class="shield6000-feat">
<h4>Military &amp; Defense Ministry Certified</h4>
<p>Same standards as Israeli safe rooms</p>
</div>
<div class="shield6000-feat">
<h4>Patented Technology</h4>
<p>International patent protection</p>
</div>
</div>
<div class="shield6000-tags" style="margin-top:1rem">
<div class="shield6000-tag"><span class="shield6000-tag-text">Patented Technology</span></div>
<div class="shield6000-tag"><span class="shield6000-tag-text">Military Certified</span></div>
<div class="shield6000-tag"><span class="shield6000-tag-text">No Permits</span></div>
<div class="shield6000-tag"><span class="shield6000-tag-text">Installed in Days</span></div>
</div>
</div>
</div>
<!-- Media Strip -->
<div class="shield6000-media fade-in">
<div>
<img src="<?php echo get_template_directory_uri(); ?>/images/shield6000-spray.jpg" alt="Shield 6000 polymeric silicone spray application" class="spray-img">
<div class="video-caption">Polymeric silicone compound being applied to wall surface</div>
</div>
<div>
<a href="https://www.youtube.com/watch?v=zCadsXeu5xY" target="_blank" rel="noopener" style="display:block;position:relative;width:100%;aspect-ratio:16/9;border-radius:12px;overflow:hidden;background:#000;box-shadow:var(--shadow-lg)">
<img src="https://img.youtube.com/vi/zCadsXeu5xY/maxresdefault.jpg" alt="Shield 6000 — Israeli Home Front Command Video" style="width:100%;height:100%;object-fit:cover;opacity:0.85">
<div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center">
<div style="width:68px;height:48px;background:rgba(220,38,38,0.9);border-radius:12px;display:flex;align-items:center;justify-content:center">
<div style="width:0;height:0;border-top:10px solid transparent;border-bottom:10px solid transparent;border-left:18px solid #fff;margin-left:4px"></div>
</div>
</div>
</a>
<div class="video-caption">Official Israeli Military Home Front Command video &mdash; click to watch</div>
</div>
</div>
</div>
</section>

<!-- ===== CONSTRUCTION & REINFORCEMENT ===== -->
<section class="construction" id="construction">
<div class="container">
<div class="construction-content">
<div class="construction-image fade-in">
<img src="<?php echo get_template_directory_uri(); ?>/images/rebar-construction.jpg" alt="Structural reinforcement construction" loading="lazy">
</div>
<div class="fade-in fade-in-delay-1">
<div class="section-label">Larger-Scale Projects</div>
<h2>Full Construction &amp; Structural Reinforcement</h2>
<p class="construction-text">
When the scope goes beyond room-level fortification &mdash; whether it's a new safe room build, an underground shelter, or hardening an entire facility &mdash; we manage the full execution from engineering design through completion. Our Israeli and local teams work with qualified contractors to deliver defense-grade projects of any scale.
</p>
<div class="service-list">
<div class="service-item">Structural reinforcement & blast protection</div>
<div class="service-item">Safe room construction & certification</div>
<div class="service-item">Underground shelter design</div>
<div class="service-item">Blast-resistant door & window installation</div>
<div class="service-item">Emergency infrastructure hardening</div>
</div>
<div class="construction-note">
<strong>Always paired with our advisory service.</strong> We never execute without a proper strategy in place. Every project begins with a comprehensive assessment of your facility's specific protection needs.
</div>
</div>
</div>
</div>
</section>

<!-- ===== GALLERY ===== -->
<section class="gallery" id="gallery">
<div class="container">
<div class="gallery-header">
<div class="section-label fade-in">Real-World Projects</div>
<h2 style="font-family:var(--font-heading);font-size:2.8rem;font-weight:700;line-height:1.15;color:var(--text-dark);margin-bottom:0.8rem" class="fade-in">Defense-Grade Execution, Proven in the Field</h2>
</div>
<div class="gallery-grid">
<div class="gallery-card fade-in">
<img src="<?php echo get_template_directory_uri(); ?>/images/energy-facility-aerial.jpg" alt="Energy facility protection project" loading="lazy">
<div class="gallery-caption">Energy Facility Protection</div>
</div>
<div class="gallery-card fade-in fade-in-delay-1">
<img src="<?php echo get_template_directory_uri(); ?>/images/fortified-compound.jpg" alt="Strategic compound fortification" loading="lazy">
<div class="gallery-caption">Strategic Compound Fortification</div>
</div>
<div class="gallery-card fade-in fade-in-delay-2">
<img src="<?php echo get_template_directory_uri(); ?>/images/bg-home-banner.webp" alt="Defense facility protection overview" loading="lazy">
<div class="gallery-caption">Defense Facility Protection Overview</div>
</div>
<div class="gallery-card fade-in fade-in-delay-3">
<img src="<?php echo get_template_directory_uri(); ?>/images/hospital-blueprint.jpg" alt="Hospital protection zones" loading="lazy">
<div class="gallery-caption">Hospital Protection Zones</div>
</div>
</div>
</div>
</section>

<!-- ===== PROCESS ===== -->
<section class="process" id="process">
<div class="container">
<div class="process-header">
<div class="section-label fade-in">How We Work</div>
<div class="section-title fade-in">From Strategy to Certified Protection</div>
</div>
<div class="timeline">
<div class="tl-step fade-in">
<div class="tl-num">1</div>
<h3>Advisory First</h3>
<p>Protection strategy defined by our advisory team</p>
</div>
<div class="tl-step fade-in fade-in-delay-1">
<div class="tl-num">2</div>
<h3>Engineering Design</h3>
<p>Detailed plans, specifications, and materials</p>
</div>
<div class="tl-step fade-in fade-in-delay-2">
<div class="tl-num">3</div>
<h3>Execution</h3>
<p>Shield 6000 deployment or structural construction</p>
</div>
<div class="tl-step fade-in fade-in-delay-3">
<div class="tl-num">4</div>
<h3>Certification</h3>
<p>Final inspection, testing, and compliance certification</p>
</div>
</div>
</div>
</section>

<!-- ===== CONTACT ===== -->
<section class="contact" id="contact">
<div class="container">
<div class="section-label fade-in">Get Started</div>
<div class="section-title fade-in" style="margin-bottom:2rem">Request an Execution Assessment</div>
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
<label>Inquiry Type</label>
<select name="inquiry_type">
<option value="">Select inquiry type</option>
<option>Shield 6000 Deployment</option>
<option>Structural Reinforcement</option>
<option>Safe Room Construction</option>
<option>Full Execution Project</option>
<option>Other</option>
</select>
</div>
<div class="form-group">
<label>Facility Type</label>
<select name="facility_type"><option value="">Select facility</option><option>Hotel / Hospitality</option><option>Hospital / Healthcare</option><option>Office / Commercial</option><option>Data Center</option><option>Energy / Industrial</option><option>Airport / Transportation</option><option>Government / Military</option><option>Other</option></select>
</div>
</div>
<div class="form-group"><label>Message</label><textarea name="message" placeholder="Describe your execution needs and facility requirements"></textarea></div>
<button type="submit" class="form-submit">Submit Inquiry →</button>
</form>
</div>
<div class="contact-info fade-in fade-in-delay-1">
<div class="info-card">
<div><h4>Confidential by Default</h4><p>All inquiries under strict NDA. We respect operational security at every stage.</p></div>
</div>
<div class="info-card">
<div><h4>Israeli and Local Teams Deploy Globally</h4><p>Our military-trained crews manage Shield 6000 deployment and can oversee contractor teams worldwide.</p></div>
</div>
<div class="info-card">
<div><h4>Quality Assurance</h4><p>Every project includes final certification and testing to defense-grade standards.</p></div>
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
inquiry_type:form.inquiry_type.value,
facility_type:form.facility_type.value,
message:form.message.value
};

emailjs.send('service_py23y6a','template_lgfttoi',{
to_email:'eddie.nudel@gmail.com',
from_name:data.name,
from_email:data.email,
organization:data.organization,
phone:data.phone||'Not provided',
inquiry_type:data.inquiry_type||'Execution Services',
facility_type:data.facility_type||'Not specified',
message:data.message||'No message provided',
subject:'Execution Inquiry from '+data.name
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