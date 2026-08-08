<?php
/**
 * Template Name: About
 * Description: About page
 */

get_header(); ?>

<style>

    :root {
      --bg: #ffffff;
      --bg-light: #f7f8fa;
      --bg-section: #f0f2f5;
      --bg-dark: #0a1628;
      --gold: #1e3a5f;
      --gold-light: #2563eb;
      --gold-bright: #3b82f6;
      --gold-dim: rgba(37, 99, 235, 0.06);
      --gold-border: rgba(37, 99, 235, 0.18);
      --red: #dc2626;
      --text-dark: #111827;
      --text-mid: #374151;
      --text-light: #6b7280;
      --text-white: #ffffff;
      --border: #e5e7eb;
      --shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
      --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
      --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);
      --font-heading: 'Space Grotesk', sans-serif;
      --font-body: 'Inter', sans-serif;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-body);
      color: var(--text-dark);
      background: var(--bg);
      line-height: 1.6;
    }

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

    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, var(--bg-dark) 0%, #1a2d4a 100%);
      color: var(--text-white);
      padding: 160px 40px 80px;
      margin-top: 0;
      text-align: center;
    }

    .breadcrumb {
      font-size: 0.85rem;
      color: rgba(255, 255, 255, 0.7);
      margin-bottom: 30px;
    }

    .breadcrumb a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
    }

    .breadcrumb a:hover {
      color: var(--gold-bright);
    }

    .hero h1 {
      font-family: var(--font-heading);
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 20px;
      line-height: 1.2;
    }

    .hero p {
      font-size: 1.2rem;
      color: rgba(255, 255, 255, 0.9);
      max-width: 700px;
      margin: 0 auto;
      line-height: 1.6;
    }

    /* Section Styling */
    section {
      padding: 80px 40px;
    }

    section:nth-child(even) {
      background: var(--bg);
    }

    section:nth-child(odd) {
      background: var(--bg-section);
    }

    section.hero {
      background: linear-gradient(135deg, var(--bg-dark) 0%, #1a2d4a 100%);
    }

    section.contact {
      background: var(--bg-section);
    }

    .section-label {
      font-size: 0.72rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--gold-bright);
      margin-bottom: 12px;
    }

    .section-title {
      font-family: var(--font-heading);
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 40px;
      color: var(--text-dark);
      line-height: 1.2;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Fade-in Animation */
    .fade-in {
      opacity: 1;
      transform:translateY(0);
    }

    .fade-in.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* Partnership Section */
    .partnership-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
    }

    .partnership-text p {
      font-size: 1rem;
      color: var(--text-mid);
      line-height: 1.8;
      margin-bottom: 20px;
    }

    .partnership-image {
      width: 100%;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: var(--shadow-lg);
    }

    .partnership-image img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* Leadership Section */
    .leadership-card {
      background: var(--bg);
      padding: 40px;
      border-radius: 12px;
      box-shadow: var(--shadow);
      margin-bottom: 40px;
      border: 1px solid var(--border);
    }

    .leadership-card p {
      font-size: 1rem;
      color: var(--text-mid);
      line-height: 1.8;
    }

    .capabilities-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 30px;
    }

    .capability-card {
      background: var(--bg);
      padding: 30px;
      border-radius: 12px;
      box-shadow: var(--shadow);
      border: 1px solid var(--border);
    }

    .capability-card h4 {
      font-family: var(--font-heading);
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 15px;
    }

    .capability-card p {
      font-size: 0.95rem;
      color: var(--text-mid);
      line-height: 1.6;
    }

    /* Projects Section */
    .projects-intro {
      font-size: 1rem;
      color: var(--text-mid);
      margin-bottom: 40px;
      line-height: 1.8;
    }

    .projects-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 30px;
      margin-bottom: 60px;
    }

    .project-card {
      background: var(--bg-light);
      padding: 40px;
      border-radius: 12px;
      border: 1px solid var(--border);
      text-align: center;
    }

    .project-card h4 {
      font-family: var(--font-heading);
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 15px;
    }

    .project-card p {
      font-size: 0.95rem;
      color: var(--text-mid);
    }

    .underground-title {
      font-family: var(--font-heading);
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--text-dark);
      margin: 60px 0 30px 0;
    }

    .underground-images {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      margin-top: 30px;
    }

    .underground-image-container {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: var(--shadow-lg);
    }

    .underground-image-container img {
      width: 100%;
      height: auto;
      display: block;
    }

    .image-caption {
      font-size: 0.85rem;
      color: var(--text-light);
      margin-top: 10px;
      text-align: center;
      font-style: italic;
    }

    /* Digital Innovation Section */
    .digital-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
    }

    .digital-text p {
      font-size: 1rem;
      color: var(--text-mid);
      line-height: 1.8;
      margin-bottom: 20px;
    }

    .digital-list {
      margin-top: 20px;
      padding-left: 0;
      list-style: none;
    }

    .digital-list li {
      font-size: 0.95rem;
      color: var(--text-mid);
      margin-bottom: 10px;
      padding-left: 25px;
      position: relative;
    }

    .digital-list li:before {
      content: "•";
      color: var(--gold-bright);
      font-weight: bold;
      position: absolute;
      left: 0;
    }

    /* Contact Section */
    .contact-wrapper {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
    }

    .contact-form {
      flex: 1;
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: var(--text-dark);
      font-size: 0.95rem;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid var(--border);
      border-radius: 6px;
      font-family: var(--font-body);
      font-size: 0.95rem;
      color: var(--text-dark);
      transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: var(--gold-bright);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 120px;
    }

    .submit-btn {
      background: var(--gold-bright);
      color: var(--text-white);
      padding: 14px 28px;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
      width: 100%;
    }

    .submit-btn:hover {
      background: var(--gold-light);
    }

    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .info-card {
      background: var(--bg);
      padding: 30px;
      border-radius: 12px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
    }

    .info-card h4 {
      font-family: var(--font-heading);
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 10px;
    }

    .info-card p {
      font-size: 0.95rem;
      color: var(--text-mid);
    }

    /* Footer */
    footer {
      background: var(--bg-dark);
      color: var(--text-white);
      padding: 60px 40px 30px;
    }

    

    .footer-section h4 {
      font-family: var(--font-heading);
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .footer-section a {
      display: block;
      margin-bottom: 12px;
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.3s;
    }

    .footer-section a:hover {
      color: var(--gold-bright);
    }

    

    /* Tablet Responsive (1024px) */
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

@media (max-width: 1024px) {
      .hero h1 {
        font-size: 2.4rem;
      }

      .section-title {
        font-size: 2rem;
      }

      .partnership-content,
      .digital-content {
        grid-template-columns: 1fr;
        gap: 40px;
      }

      .capabilities-grid {
        grid-template-columns: 1fr;
      }

      .projects-grid {
        grid-template-columns: 1fr;
      }

      .digital-content {
        grid-template-columns: 1fr;
      }

      .contact-wrapper {
        grid-template-columns: 1fr;
      }
    }

    /* Mobile Responsive (768px) */
    @media (max-width: 768px) {
      .leadership-highlights { grid-template-columns: 1fr !important; }
    }
    @media (max-width: 768px) {
.footer-inner{grid-template-columns:1fr 1fr;gap:2rem}
.footer-brand{grid-column:1/-1}

      .container {
        padding: 0 1rem;
        max-width: 100%;
      }

      .nav{background:#fff!important;box-shadow:0 1px 4px rgba(0,0,0,0.08)}
      .nav-logo-text{color:var(--text-dark)!important}
      .nav-links{display:none}
      .hamburger{display:flex}
      .hamburger span{background:var(--text-dark)!important}
      .nav-cta{display:none}

      .hero {
        padding: 120px 20px 60px;
      }

      .hero h1 {
        font-size: 2rem;
      }

      .hero p {
        font-size: 1rem;
      }

      section {
        padding: 2.5rem 1rem;
      }

      .section-title {
        font-size: 1.6rem;
      }

      .section-subtitle {
        max-width: 100%;
      }

      .partnership-content,
      .digital-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      .capabilities-grid,
      .projects-grid,
      .underground-images {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      .contact-wrapper {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      .contact-form {
        padding: 1.5rem;
      }

      

      footer {
        padding: 2rem 0;
      }

      div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
      }
    }

    /* Small Mobile (480px) */
    @media (max-width: 480px) {
.footer-inner{grid-template-columns:1fr}

      .hero h1 {
        font-size: 1.8rem;
      }

      .section-title {
        font-size: 1.4rem;
      }
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
<a href="<?php echo home_url('/customers/'); ?>" onclick="this.parentElement.classList.remove('open')">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>" onclick="this.parentElement.classList.remove('open')">About</a>
<a href="<?php echo home_url('/articles/'); ?>" onclick="this.parentElement.classList.remove('open')">Articles</a>
<a href="<?php echo home_url('/customers/'); ?>#contact" onclick="this.parentElement.classList.remove('open')" class="btn-gold" style="margin-top:1rem">Contact Us</a>
</div>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <div class="breadcrumb fade-in">
        <a href="<?php echo home_url('/'); ?>">Home</a> > About
      </div>
      <h1 class="fade-in">About Fortline Global</h1>
      <p class="fade-in">Combining Israel's leading protection technology and advisory companies to deliver defense-grade civilian protection worldwide.</p>
    </div>
  </section>

  <!-- Partnership Section -->
  <section>
    <div class="container fade-in">
      <div class="section-label">Our Approach</div>
      <h2 class="section-title">The Best of Israeli Defense Innovation</h2>
      <div class="partnership-content">
        <div class="partnership-text">
          <p>Fortline Global brings together Israel's top protection technology and engineering advisory companies into a single, integrated offering. We combine patented rapid-deploy fortification systems with decades of military-grade engineering, regulatory expertise, and hands-on experience protecting critical national infrastructure.</p>
          <p>Our team includes retired senior military officers, licensed engineers specializing in protective construction, and regulatory experts with deep experience in Home Front Command certification processes. From a single room to an entire nation  -  we deliver the full spectrum of civilian protection consulting and technology.</p>
        </div>
        <div class="partnership-image">
          <img src="<?php echo get_template_directory_uri(); ?>/images/credentials-image.jpg" alt="Engineering team reviewing blueprints">
        </div>
      </div>
    </div>
  </section>

  <!-- Leadership Section -->
  <section>
    <div class="container fade-in">
      <div class="section-label">Leadership</div>
      <h2 class="section-title">Military-Grade Expertise, Civilian Application</h2>
      <div class="leadership-card">
        <p>Led by a retired Lt. Colonel (Res.) with 25 years of military experience, degrees in Architecture and Economics/Management, and extensive experience directing national shelter programs within the Home Front Command.</p>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:1.5rem;margin-bottom:2rem" class="leadership-highlights">
        <div style="background:var(--bg-light);border:1px solid var(--border);border-radius:12px;padding:1.4rem">
          <h4 style="font-family:var(--font-heading);font-size:0.88rem;font-weight:700;color:var(--text-dark);margin-bottom:0.4rem">Technology Leadership</h4>
          <p style="font-size:0.85rem;color:var(--text-mid);line-height:1.6">Our technology partner&rsquo;s leadership includes a former Director at the Israeli Ministry of Defense and seasoned professionals from the defense-industrial complex  -  bringing strategic-level understanding of national protection requirements and procurement processes.</p>
        </div>
        <div style="background:var(--bg-light);border:1px solid var(--border);border-radius:12px;padding:1.4rem">
          <h4 style="font-family:var(--font-heading);font-size:0.88rem;font-weight:700;color:var(--text-dark);margin-bottom:0.4rem">Continuous R&amp;D Investment</h4>
          <p style="font-size:0.85rem;color:var(--text-mid);line-height:1.6">Backed by a privately-held, self-funded technology company with over 18 years of continuous R&amp;D investment in protection and sealing innovation. No external investors  -  ensuring independence and long-term commitment to product excellence.</p>
        </div>
      </div>
      <div class="capabilities-grid">
        <div class="capability-card fade-in">
          <h4>Public & Institutional Projects</h4>
          <p>Planning and implementation of protective infrastructure projects within governmental and private sectors</p>
        </div>
        <div class="capability-card fade-in">
          <h4>Safe Rooms (Mamadim)</h4>
          <p>Design and certification of protected spaces meeting the highest Israeli defense standards</p>
        </div>
        <div class="capability-card fade-in">
          <h4>Strategic Facility Protection</h4>
          <p>Physical protection of energy infrastructure, critical installations, and defense-related facilities</p>
        </div>
        <div class="capability-card fade-in">
          <h4>Regulatory Expertise</h4>
          <p>Accelerated licensing with Home Front Command and Fire Authority, saving clients significant time and costs</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Key Projects Section -->
  <section>
    <div class="container fade-in">
      <div class="section-label">Track Record</div>
      <h2 class="section-title">Key Projects & References</h2>
      <p class="projects-intro">Our engineering partners have delivered protection solutions across some of Israel's most significant infrastructure projects.</p>
      <div class="projects-grid">
        <div class="project-card fade-in">
          <h4>Carmel Tunnels</h4>
          <p>Major transportation tunnel infrastructure protection</p>
        </div>
        <div class="project-card fade-in">
          <h4>Tel Aviv Light Rail</h4>
          <p>Protection integration into mass transit systems</p>
        </div>
        <div class="project-card fade-in">
          <h4>Jerusalem Binyanei HaUma Station</h4>
          <p>Train station protective infrastructure</p>
        </div>
        <div class="project-card fade-in">
          <h4>Municipal Protection Programs</h4>
          <p>Underground spaces and shelter systems for municipalities</p>
        </div>
      </div>

      <h3 class="underground-title">Underground Domain Utilization</h3>
      <p style="font-size: 1rem; color: var(--text-mid); line-height: 1.8; margin-bottom: 30px;">One of our most innovative approaches is the use of existing underground infrastructure to create new shelter spaces  -  reducing shelter gaps across municipalities and enabling the operation of essential activities within a short timeframe and at low cost, ensuring continuity of daily life during emergencies.</p>
      <div class="underground-images">
        <div>
          <div class="underground-image-container">
            <img src="<?php echo get_template_directory_uri(); ?>/images/tunnel-cross-section.jpg" alt="Underground shelter space cross-section engineering">
          </div>
          <p class="image-caption">Underground shelter space cross-section engineering</p>
        </div>
        <div>
          <div class="underground-image-container">
            <img src="<?php echo get_template_directory_uri(); ?>/images/tunnel-engineering.jpg" alt="Tunnel protection space utilization blueprint">
          </div>
          <p class="image-caption">Tunnel protection space utilization blueprint</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Digital Innovation Section -->
  <section>
    <div class="container fade-in">
      <div class="section-label">Innovation</div>
      <h2 class="section-title">Technology-Driven Protection Engineering</h2>
      <div class="digital-content">
        <div class="digital-text">
          <p>Our approach integrates advanced digital tools into every phase of protection engineering. We developed a proprietary <strong>Digital Building-Permit Approval System</strong> for the Military Home Front Command  -  the national authority responsible for civilian protection  -  streamlining the entire process from registration through final certification.</p>
          <p>We also deploy <strong>Automated Safe Room Construction Plan Review</strong> technology that digitally compares and verifies construction blueprints against certified standards, catching deviations before they reach the field.</p>
          <p>Key capabilities:</p>
          <ul class="digital-list">
            <li>Digital permit system: registration, submission, automated feedback, and certification</li>
            <li>Automated plan review: digital comparison of 2D construction sheets against protection standards</li>
            <li>Remote screen-sharing sessions with engineers prior to submission</li>
            <li>Live consultation and real-time correction capabilities</li>
            <li>Full digital audit trail from initial application to final verification</li>
          </ul>
        </div>
        <div class="partnership-image">
          <img src="<?php echo get_template_directory_uri(); ?>/images/digital-permit-system.jpg" alt="Digital building-permit approval system for Home Front Command">
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="contact">
    <div class="container fade-in">
      <div class="section-label">Get Started</div>
      <h2 class="section-title">Begin a Conversation</h2>
      <div class="contact-wrapper">
        <form class="contact-form" id="contactForm">
          <div class="form-group">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" required>
          </div>
          <div class="form-group">
            <label for="organization">Organization</label>
            <input type="text" id="organization" name="organization" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" required></textarea>
          </div>
          <button type="submit" class="submit-btn">Submit Inquiry →</button>
        </form>

        <div class="contact-info">
          <div class="info-card">
            <h4>Confidential by Default</h4>
            <p>All inquiries and communications are treated with the highest level of confidentiality and security.</p>
          </div>
          <div class="info-card">
            <h4>Fast SLA</h4>
            <p>We commit to rapid response times on all inquiries, ensuring your protection consultation begins without delay.</p>
          </div>
          <div class="info-card">
            <h4>Global Deployment</h4>
            <p>Whether local or international, we bring Israeli defense-grade expertise to protection projects worldwide.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

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

  <!-- EmailJS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
  <script>try { emailjs.init('gHP8ZucvB2iLEtPVU'); } catch(e) {}</script>

  <script>
    // Sticky Navigation (runs first, before anything that might fail)
    const nav = document.getElementById('nav');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 80) {
        nav.classList.add('scrolled');
      } else {
        nav.classList.remove('scrolled');
      }
    });

    // Intersection Observer for Fade-in
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, observerOptions);

    document.querySelectorAll('.fade-in').forEach(el => {
      observer.observe(el);
    });

    // Contact Form Submission
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const fullName = document.getElementById('fullName').value;
      const organization = document.getElementById('organization').value;
      const email = document.getElementById('email').value;
      const phone = document.getElementById('phone').value;
      const message = document.getElementById('message').value;

      emailjs.send('service_fortline', 'template_contact', {
        from_name: fullName,
        organization: organization,
        from_email: email,
        phone: phone,
        message: message,
        to_email: 'contact@fortlineglobal.com'
      }).then(function(response) {
        alert('Thank you! Your inquiry has been submitted successfully.');
        document.getElementById('contactForm').reset();
      }, function(error) {
        alert('Error sending inquiry. Please try again.');
        console.log('FAILED...', error);
      });
    });
  </script>

<?php get_footer(); ?>