<?php
/**
 * Template Name: Home
 * Description: Home page
 */
get_header(); ?>

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
<a href="<?php echo home_url('/contact/'); ?>" class="btn-gold" data-i18n="hero.cta1">Schedule a Consultation</a>
<a href="<?php echo home_url('/services/'); ?>" class="btn-white" data-i18n="hero.cta2">Our Services &rarr;</a>
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
<a href="<?php echo home_url('/contact/'); ?>" class="btn-gold" style="display:inline-block;width:100%;max-width:400px;padding:1rem 2rem;font-size:1rem;text-align:center">Contact Us &rarr;</a>
</div>

</section>


<!-- ===== SERVICES: STRATEGIC PROTECTION ===== -->
<section class="pillars" id="pillars" style="padding:5rem 0;background:var(--bg-section)">
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
<a href="<?php echo home_url('/contact/'); ?>" class="svc-cta" data-i18n="pil.cta">Talk to Us →</a>
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
<a href="<?php echo home_url('/contact/'); ?>" class="svc-cta" data-i18n="pil.cta">Talk to Us →</a>
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
<a href="<?php echo home_url('/contact/'); ?>" class="svc-cta" data-i18n="pil.cta">Talk to Us →</a>
</div>
</div>
</div>

</div>
</section>



<!-- ===== HOME CTA BAND ===== -->
<section style="padding:4.5rem 0;background:var(--bg-dark);position:relative;overflow:hidden">
<div class="container" style="text-align:center;position:relative;z-index:1">
<div class="section-title fade-in" style="color:#fff;margin-bottom:0.6rem" data-i18n="cta.title">Ready to protect what matters most?</div>
<p class="fade-in" style="color:rgba(255,255,255,0.7);max-width:640px;margin:0 auto 1.8rem;font-size:0.98rem;line-height:1.7" data-i18n="cta.sub">Book a free, no-obligation consultation. We visit, check your eligibility for state funding, and give you a clear plan and quote.</p>
<div class="fade-in" style="display:flex;gap:0.9rem;justify-content:center;flex-wrap:wrap">
<a href="<?php echo home_url('/contact/'); ?>" class="btn-gold" data-i18n="cta.b1">Schedule a Consultation</a>
<a href="https://wa.me/972544757201" target="_blank" rel="noopener" class="btn-white" data-i18n="cta.b2">Message on WhatsApp</a>
</div>
</div>
</section>


<?php get_footer(); ?>
