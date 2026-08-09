<?php /* ARI: legacy page — send visitors to the single-page site */ if (function_exists("wp_safe_redirect") && !is_admin()) { wp_safe_redirect( home_url("/") ); exit; } ?>
<?php
/**
 * Template Name: Customers
 * Description: Customers page
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

/* Mobile */
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

@media (max-width: 768px) {
.footer-inner{grid-template-columns:1fr 1fr;gap:2rem}
.footer-brand{grid-column:1/-1}

.nav{background:#fff!important;box-shadow:0 1px 4px rgba(0,0,0,0.08)}.nav .nav-logo-light{display:none}.nav .nav-logo-dark{display:block}
.nav-logo-text{color:var(--text-dark)!important}
.nav-links{display:none}
.hamburger{display:flex}
.hamburger span{background:var(--text-dark)!important}
.nav-cta{display:none}
}

        /* Sections */
        section {
            padding: 5rem 2rem;
        }

        .section-label {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold-bright);
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .section-subtitle {
            font-size: 1.125rem;
            color: var(--text-mid);
            max-width: 700px;
            margin-bottom: 2rem;
        }

        /* All elements visible by default */
        .fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(10, 22, 40, 0.85), rgba(10, 22, 40, 0.92)), url('credentials-image.jpg') center/cover no-repeat;
            color: var(--text-white);
            padding: 10rem 2rem;
            text-align: center;
            margin-top: 0;
        }

        .breadcrumb {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
        }

        .breadcrumb a {
            color: var(--gold-bright);
            text-decoration: none;
        }

        .hero .section-title {
            color: var(--text-white);
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }

        .hero .section-subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 1.25rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 2.5rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-family: var(--font-body);
        }

        .btn-primary {
            background: var(--gold-bright);
            color: var(--text-white);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            background: var(--gold-light);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-white);
            border: 2px solid var(--gold-bright);
        }

        .btn-secondary:hover {
            background: var(--gold-bright);
        }

        /* Service Model Section */
        .service-model {
            background: var(--bg);
        }

        .service-cards-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .service-card {
            padding: 2.5rem;
            border-radius: 1rem;
            background: var(--bg-light);
            border: 2px solid var(--border);
            transition: all 0.3s ease;
        }

        .service-card.featured {
            border: 2px solid var(--gold-bright);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.03) 0%, transparent 100%);
            position: relative;
        }

        .service-card.featured::before {
            content: 'PRIMARY SERVICE';
            position: absolute;
            top: -12px;
            left: 2rem;
            background: var(--gold-bright);
            color: var(--text-white);
            padding: 0.4rem 0.8rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            border-radius: 0.3rem;
        }

        .service-card h3 {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .service-card .subtitle {
            color: var(--gold-bright);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .service-card p {
            color: var(--text-mid);
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .service-card ul {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        .service-card li {
            color: var(--text-mid);
            padding: 0.75rem 0;
            padding-left: 1.5rem;
            position: relative;
        }

        .service-card li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--gold-bright);
            font-weight: 700;
        }

        .service-card .note {
            background: var(--gold-dim);
            border-left: 3px solid var(--gold-bright);
            padding: 1rem;
            margin: 1.5rem 0;
            font-size: 0.95rem;
            color: var(--text-mid);
            border-radius: 0.3rem;
        }

        .service-card .btn {
            width: 100%;
            text-align: center;
            margin-top: auto;
        }

        /* National Regulation Banner */
        .national-banner {
            background: linear-gradient(135deg, var(--bg-dark) 0%, #1a2f4a 100%);
            color: var(--text-white);
            padding: 2.5rem;
            border-radius: 1rem;
            position: relative;
            margin-top: 2rem;
        }

        .national-banner::before {
            content: 'GOVERNMENT-LEVEL SERVICE';
            position: absolute;
            top: -12px;
            left: 2rem;
            background: var(--red);
            color: var(--text-white);
            padding: 0.4rem 0.8rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            border-radius: 0.3rem;
        }

        .national-banner h3 {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            margin-top: 0.5rem;
        }

        .national-banner p {
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.7;
        }

        /* Customer Types Section */
        .customer-types {
            background: var(--bg-section);
        }

        .customer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }

        .customer-card {
            background: var(--bg);
            padding: 0;
            border-radius: 1rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .customer-card-img {
            height: 200px;
            overflow: hidden;
            position: relative;
            border-radius: 16px 16px 0 0;
        }

        .customer-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .customer-card-img::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: linear-gradient(transparent, rgba(255,255,255,0.95));
        }

        .customer-card.premium .customer-card-img::after {
            background: linear-gradient(transparent, rgba(10, 22, 40, 0.95));
        }

        .customer-card > * {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .customer-card > :first-of-type {
            padding-top: 2rem;
        }

        .customer-card > :last-of-type {
            padding-bottom: 2rem;
        }

        .customer-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .customer-card.premium {
            border: 2px solid #d4af37;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05) 0%, transparent 100%);
        }

        .customer-number {
            font-family: var(--font-heading);
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--gold-bright) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .customer-card.premium .customer-number {
            background: linear-gradient(135deg, #d4af37 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .customer-card h3 {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-dark);
        }

        .customer-card > p {
            color: var(--text-mid);
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .client-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .tag {
            display: inline-block;
            background: var(--gold-dim);
            color: var(--gold-bright);
            padding: 0.4rem 0.8rem;
            border-radius: 0.25rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .customer-card.premium .tag {
            background: rgba(212, 175, 55, 0.15);
            color: #d4af37;
        }

        .services-list {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        .services-list li {
            color: var(--text-mid);
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
            font-size: 0.95rem;
        }

        .services-list li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--gold-bright);
            font-weight: 700;
        }

        .customer-card.premium .services-list li::before {
            color: #d4af37;
        }

        .premium-note {
            background: rgba(212, 175, 55, 0.1);
            border-left: 3px solid #d4af37;
            padding: 1rem;
            margin: 1.5rem 0;
            font-size: 0.9rem;
            color: var(--text-mid);
            border-radius: 0.3rem;
            font-style: italic;
        }

        .customer-card .btn {
            width: 100%;
            text-align: center;
            margin-top: auto;
            padding: 0.875rem 1.5rem;
        }

        /* How We Work Section */
        .how-we-work {
            background: var(--bg);
        }

        .timeline {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 12.5%;
            right: 12.5%;
            height: 2px;
            background: var(--border);
            z-index: 0;
        }

        .timeline-step {
            position: relative;
            z-index: 1;
        }

        .timeline-step::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            background: var(--gold-bright);
            border: 4px solid var(--bg);
            border-radius: 50%;
            box-shadow: 0 0 0 2px var(--gold-bright);
        }

        .timeline-content {
            background: var(--bg-light);
            padding: 2rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border);
            margin-top: 2.5rem;
            height: calc(100% - 2.5rem);
            display: flex;
            flex-direction: column;
        }

        .timeline-content h4 {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-dark);
        }

        .timeline-content p {
            color: var(--text-mid);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .timeline-note {
            text-align: center;
            margin-top: 2.5rem;
            padding: 1.5rem;
            background: var(--gold-dim);
            border-radius: 0.75rem;
            border: 1px solid var(--gold-border);
            color: var(--text-mid);
            font-style: italic;
        }

        /* Contact Section */
        .contact {
            background: var(--bg-light);
        }

        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-top: 3rem;
        }

        .contact-form {
            background: var(--bg);
            padding: 2rem;
            border-radius: 1rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-md);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.875rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--text-dark);
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--gold-bright);
            box-shadow: 0 0 0 3px var(--gold-dim);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .contact-form .btn {
            width: 100%;
        }

        .contact-cards {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-card {
            background: var(--bg);
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .info-card h4 {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .info-card p {
            color: var(--text-mid);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background: var(--bg-dark);
            color: var(--text-white);
            padding: 3rem 2rem;
        }

        

        .footer-section h4 {
            font-family: var(--font-heading);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.75rem;
        }

        .footer-section a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--gold-bright);
        }

        

        /* Tablet Responsive (1024px) */
        @media (max-width: 1024px) {
            .customer-grid {
                grid-template-columns: 1fr;
            }

            .timeline {
                grid-template-columns: repeat(2, 1fr);
            }

            .timeline::before {
                display: none;
            }

            .contact-container {
                grid-template-columns: 1fr;
            }
        }

        /* Mobile Responsive (768px) */
        @media (max-width: 768px) {
            section {
                padding: 2.5rem 1rem;
            }

            .hero {
                padding: 6rem 1.5rem;
                margin-top: 60px;
            }

            .hero .section-title {
                font-size: 2rem;
            }

            .hero .section-subtitle {
                font-size: 1rem;
                max-width: 100%;
            }

            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .hero-buttons .btn {
                width: 100%;
            }

            .hero-buttons .btn-secondary {
                display: none;
            }

            .section-title {
                font-size: 1.6rem;
            }

            .section-subtitle {
                max-width: 100%;
            }

            .customer-number {
                font-size: 2rem;
            }

            .service-cards-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .timeline {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .timeline::before {
                display: none;
            }

            .customer-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .client-tags {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .contact-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                max-width: 100%;
            }

            .contact-form {
                padding: 1.5rem;
            }

            .btn {
                padding: 0.875rem 1.5rem;
                font-size: 0.95rem;
            }

            

            div[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
        }

        /* Small Mobile (480px) */
        @media (max-width: 480px) {
.footer-inner{grid-template-columns:1fr}

            .hero .section-title {
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
<a href="<?php echo home_url('/'); ?>" class="nav-logo" aria-label="A.R.I. Faberman Engineering Solutions Ltd.">
<img src="<?php echo get_template_directory_uri(); ?>/images/brand/ari-logo-horizontal-reversed.svg" alt="A.R.I. Faberman Engineering Solutions Ltd." class="nav-logo-img nav-logo-light">
<img src="<?php echo get_template_directory_uri(); ?>/images/brand/ari-logo-horizontal.svg" alt="" aria-hidden="true" class="nav-logo-img nav-logo-dark">
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

    <!-- Hero Section -->
    <section class="hero fade-in">
        <div class="breadcrumb">
            <a href="<?php echo home_url('/'); ?>">Home</a> > Who We Serve
        </div>
        <h1 class="section-title">Who We Serve</h1>
        <p class="section-subtitle">From government ministries to private estates — we protect every organization that must operate during emergencies. Israeli defense-grade consulting and technology, tailored to your sector.</p>
        <div class="hero-buttons">
            <a href="#contact" class="btn btn-primary">Request Assessment</a>
            <a href="<?php echo home_url('/'); ?>#pillars" class="btn btn-secondary">Our Solutions</a>
        </div>
    </section>


    <!-- Customer Types Section -->
    <section class="customer-types fade-in">
        <div class="section-label">Who We Serve</div>
        <h2 class="section-title">Three Markets. One Standard of Protection.</h2>
        <p class="section-subtitle">Every organization that holds real estate and must continue operating during emergencies.</p>

        <div class="customer-grid">
            <!-- Private Sector & High-Value Assets -->
            <div class="customer-card premium fade-in">
                <div class="customer-card-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/fortified-compound.jpg" alt="Fortified compound">
                </div>
                <div class="customer-number">01</div>
                <h3>Private Sector & High-Value Assets</h3>
                <p>Private developers, high-net-worth individuals, and organizations with irreplaceable assets. When protection is not just about safety — it's about preserving legacy, wealth, and way of life.</p>
                <div class="client-tags">
                    <span class="tag">Private Estates & Villas</span>
                    <span class="tag">Luxury Residential</span>
                    <span class="tag">Office Towers</span>
                    <span class="tag">Data Centers</span>
                    <span class="tag">Aircraft Hangars</span>
                    <span class="tag">Luxury Vehicle Collections</span>
                    <span class="tag">Family Compounds</span>
                    <span class="tag">Fine Art & Jewelry Vaults</span>
                </div>
                <ul class="services-list">
                    <li>Discreet, NDA-protected engagements</li>
                    <li>Bespoke residential safe room design</li>
                    <li>Asset protection consulting</li>
                    <li>Shield 6000 integration into luxury interiors</li>
                    <li>Full turnkey protection with zero disruption</li>
                </ul>
                <a href="#contact" class="btn btn-primary">Request Private Consultation →</a>
            </div>

            <!-- Essential Services & Civilian Infrastructure -->
            <div class="customer-card fade-in">
                <div class="customer-card-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/hospital-blueprint.jpg" alt="Hospital blueprint">
                </div>
                <div class="customer-number">02</div>
                <h3>Essential Services & Civilian Infrastructure</h3>
                <p>Organizations delivering essential services to civilian populations — healthcare, hospitality, and critical civilian infrastructure that cannot shut down during crises.</p>
                <div class="client-tags">
                    <span class="tag">Hospitals & Medical Centers</span>
                    <span class="tag">Clinic Networks</span>
                    <span class="tag">Hotel Chains & Resorts</span>
                    <span class="tag">Airport Authorities</span>
                    <span class="tag">Seaport Facilities</span>
                    <span class="tag">Transportation Networks</span>
                </div>
                <ul class="services-list">
                    <li>Facility protection assessment & gap analysis</li>
                    <li>Emergency continuity planning</li>
                    <li>Safe room design for operational buildings</li>
                    <li>Shield 6000 rapid-deploy protection</li>
                    <li>Staff emergency protocol training</li>
                </ul>
                <a href="<?php echo home_url('/facility-assessment/'); ?>" class="btn btn-primary">Explore Facility Solutions →</a>
            </div>

            <!-- Government & Municipal -->
            <div class="customer-card fade-in">
                <div class="customer-card-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/national-thumb.jpg" alt="National facilities">
                </div>
                <div class="customer-number">03</div>
                <h3>Government & Municipal</h3>
                <p>National and local government bodies responsible for critical public infrastructure and continuity of essential services during emergencies.</p>
                <div class="client-tags">
                    <span class="tag">Government Ministries</span>
                    <span class="tag">Municipal Authorities</span>
                    <span class="tag">Ministry of Education</span>
                    <span class="tag">Defense Establishments</span>
                    <span class="tag">Public Utilities</span>
                    <span class="tag">State-Owned Factories</span>
                </div>
                <ul class="services-list">
                    <li>National protection regulation development</li>
                    <li>Municipal emergency preparedness planning</li>
                    <li>Public building protection surveys</li>
                    <li>School & institutional shelter programs</li>
                    <li>Underground domain utilization</li>
                </ul>
                <a href="<?php echo home_url('/national-planning/'); ?>" class="btn btn-primary">Explore Government Solutions →</a>
            </div>
        </div>
    </section>

    <!-- How We Work Section -->
    <section class="how-we-work fade-in">
        <div class="section-label">The Process</div>
        <h2 class="section-title">Every Project Starts With Strategy</h2>

        <div class="timeline">
            <div class="timeline-step fade-in">
                <div class="timeline-content">
                    <h4>Confidential Intake</h4>
                    <p>NDA-protected initial conversation. We understand your assets, threat profile, and objectives.</p>
                </div>
            </div>

            <div class="timeline-step fade-in">
                <div class="timeline-content">
                    <h4>Engineering Advisory</h4>
                    <p>Comprehensive survey, vulnerability mapping, and protection strategy development by Israeli defense engineers. This is the core deliverable.</p>
                </div>
            </div>

            <div class="timeline-step fade-in">
                <div class="timeline-content">
                    <h4>Decision Point</h4>
                    <p>You receive a complete protection plan. Choose to implement with our execution team, or use the advisory with your own contractors.</p>
                </div>
            </div>

            <div class="timeline-step fade-in">
                <div class="timeline-content">
                    <h4>Execution (Optional)</h4>
                    <p>Shield 6000 deployment by Israeli specialists, structural work by local contractors, full project management and certification.</p>
                </div>
            </div>
        </div>

        <div class="timeline-note fade-in">
            Most clients start with advisory and expand to execution. The strategy always comes first.
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact fade-in" id="contact">
        <div class="section-label">Get Started</div>
        <h2 class="section-title">Request a Confidential Assessment</h2>

        <div class="contact-container">
            <form class="contact-form" id="contactForm">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="organization">Organization</label>
                    <input type="text" id="organization" name="organization" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone">
                </div>

                <div class="form-group">
                    <label for="clientType">Client Type</label>
                    <select id="clientType" name="clientType" required>
                        <option value="">Select a category...</option>
                        <option value="Government/Municipal">Government/Municipal</option>
                        <option value="Essential Services">Essential Services</option>
                        <option value="Private/VIP">Private/VIP</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Tell us about your needs..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Send Assessment Request</button>
            </form>

            <div class="contact-cards">
                <div class="info-card fade-in">
                    <h4>Confidential by Default</h4>
                    <p>All assessments are NDA-protected. Your threat profile, assets, and strategy remain strictly confidential. No public reference to our engagement without your explicit written consent.</p>
                </div>

                <div class="info-card fade-in">
                    <h4>Fast SLA</h4>
                    <p>We prioritize every inquiry with speed and discretion. Initial consultations are brief, confidential, and designed to understand your specific protection needs.</p>
                </div>

                <div class="info-card fade-in">
                    <h4>Global Deployment</h4>
                    <p>Israeli defense engineers deployed worldwide. Whether your assets are domestic or international, we bring proven expertise to every engagement, regardless of location or complexity.</p>
                </div>
            </div>
        </div>
    </section>

  <footer>
<div class="footer-inner">
<div class="footer-brand">
<div class="footer-logo">
<img src="<?php echo get_template_directory_uri(); ?>/images/brand/ari-logo-horizontal-reversed.svg" alt="A.R.I. Faberman Engineering Solutions Ltd." class="footer-logo-img">
</div>
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
        // Sticky Navigation (runs first, before anything that might fail)
        const nav = document.getElementById('nav');
        window.addEventListener('scroll', () => {
          if (window.scrollY > 80) {
            nav.classList.add('scrolled');
          } else {
            nav.classList.remove('scrolled');
          }
        });

        // Fade-in animations with IntersectionObserver
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.05,
                rootMargin: '0px 0px 0px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in').forEach((el) => {
                observer.observe(el);
            });

            // Fallback: make all elements visible after 1.5s if observer didn't trigger
            setTimeout(() => {
                document.querySelectorAll('.fade-in:not(.visible)').forEach((el) => {
                    el.classList.add('visible');
                });
            }, 1500);
        } else {
            // No IntersectionObserver support — show everything immediately
            document.querySelectorAll('.fade-in').forEach((el) => {
                el.classList.add('visible');
            });
        }

        // Contact Form Submission
        const contactForm = document.getElementById('contactForm');

        contactForm?.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = {
                name: document.getElementById('name').value,
                organization: document.getElementById('organization').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                clientType: document.getElementById('clientType').value,
                message: document.getElementById('message').value
            };

            emailjs.send('service_fortline', 'template_contact', formData)
                .then(() => {
                    alert('Assessment request sent. We will contact you within 24 hours.');
                    contactForm.reset();
                })
                .catch((error) => {
                    console.error('Error sending form:', error);
                    alert('There was an error sending your request. Please try again.');
                });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Set active nav link
        const currentPage = 'customers.html';
        document.querySelectorAll('.nav-links a').forEach((link) => {
            if (link.getAttribute('href') === currentPage || link.getAttribute('href').includes('customers')) {
                link.classList.add('active');
            }
        });
    </script>

<?php get_footer(); ?>