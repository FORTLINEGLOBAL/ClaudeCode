<?php
/**
 * Template Name: Who We Serve
 */
get_header(); ?>

<!-- ===== PAGE HERO (video banner) ===== -->
<section class="page-hero" id="hero">
<video autoplay muted loop playsinline>
<source src="<?php echo get_template_directory_uri(); ?>/images/hero-who-we-serve.mp4" type="video/mp4">
</video>
<div class="ph-inner fade-in">
<div class="ph-label">Who We Serve</div>
<h1>Every Organization That Must Operate During Emergencies</h1>
<p>From private homeowners to municipalities and developers  -  we deliver civil-protection consulting, planning and construction across three core audiences.</p>
</div>
</section>

<!-- ===== WHO WE SERVE ===== -->
<section style="padding:5rem 0;background:#fff" id="customers">
<div class="container">

<div class="wws-stack">

<!-- Private Clients -->
<div class="wws-row fade-in">
  <div class="wws-rc wws-content">
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
    <a href="<?php echo home_url('/contact/'); ?>" class="wws-cta">Request Private Consultation &rarr;</a>
  </div>
  <div class="wws-visual">
    <img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj03.jpg" alt="Private residence safe room" loading="lazy">
    <div class="wws-badge">Private Clients</div>
  </div>
</div>

<!-- Public & Municipal -->
<div class="wws-row rev fade-in">
  <div class="wws-rc wws-content">
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
    <a href="<?php echo home_url('/contact/'); ?>" class="wws-cta green">Explore Public-Sector Solutions &rarr;</a>
  </div>
  <div class="wws-visual">
    <img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj07.jpg" alt="Municipal and public-institution protection">
    <div class="wws-badge green">Public &amp; Municipal</div>
  </div>
</div>

<!-- Developers & Companies -->
<div class="wws-row fade-in">
  <div class="wws-rc wws-content">
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
    <a href="<?php echo home_url('/contact/'); ?>" class="wws-cta">Explore Developer Solutions &rarr;</a>
  </div>
  <div class="wws-visual">
    <img src="<?php echo get_template_directory_uri(); ?>/images/rebar-construction.jpg" alt="Developments and construction projects">
    <div class="wws-badge">Developers &amp; Companies</div>
  </div>
</div>

</div>

<div class="fade-in" style="text-align:center;margin-top:3rem">
<a href="<?php echo home_url('/contact/'); ?>" style="display:inline-block;padding:0.7rem 2rem;background:var(--gold);color:#fff;border-radius:8px;font-size:0.88rem;font-weight:600;transition:all 0.3s" onmouseover="this.style.background='var(--gold-light)'" onmouseout="this.style.background='var(--gold)'">See All Customer Solutions &rarr;</a>
</div>
</div>
</section>


<!-- ===== AREAS OF ACTIVITY ===== -->
<section style="padding:5rem 0;background:var(--bg-light)" id="sectors">
<div class="container">
<div class="section-label fade-in" style="text-align:center" data-i18n="area.label">Who We Protect</div>
<div class="section-title fade-in" style="text-align:center" data-i18n="area.title">Areas of Activity</div>
<p class="fade-in" style="color:var(--text-light);max-width:700px;margin:0.5rem auto 2.5rem;font-size:0.95rem;text-align:center;line-height:1.7" data-i18n="area.sub">We protect across four core sectors  -  each with an approach tailored to its needs, regulation and constraints.</p>
<div class="vgrid fade-in areas-grid">

<div class="vcard">
<div class="vcard-img"><img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj02.jpg" alt="Private homes and safe rooms" loading="lazy"></div>
<div class="vcard-body">
<h4 data-i18n="area.c1_t">Private Homes</h4>
<p data-i18n="area.c1_p">Safe rooms (MAMAD) for houses and apartments, room upgrades, building permits and home additions  -  turnkey, with minimal disruption.</p>
</div>
</div>

<div class="vcard">
<div class="vcard-img"><img src="<?php echo get_template_directory_uri(); ?>/images/facility-thumb.jpg" alt="Public institutions" loading="lazy"></div>
<div class="vcard-body">
<h4 data-i18n="area.c2_t">Public Institutions</h4>
<p data-i18n="area.c2_p">Protected spaces for schools, kindergartens, clinics and public buildings for the Ministries of Education, Health and Welfare.</p>
</div>
</div>

<div class="vcard">
<div class="vcard-img"><img src="<?php echo get_template_directory_uri(); ?>/images/projects/proj11.jpg" alt="Kibbutzim and communities" loading="lazy"></div>
<div class="vcard-body">
<h4 data-i18n="area.c3_t">Kibbutzim &amp; Communities</h4>
<p data-i18n="area.c3_p">Community-scale protection programs for kibbutzim, moshavim and local authorities  -  including public-shelter rehabilitation.</p>
</div>
</div>

<div class="vcard">
<div class="vcard-img"><img src="<?php echo get_template_directory_uri(); ?>/images/energy-facility-aerial.jpg" alt="Industry and strategic sites" loading="lazy"></div>
<div class="vcard-body">
<h4 data-i18n="area.c4_t">Industry &amp; Strategic Sites</h4>
<p data-i18n="area.c4_p">Physical protection for energy facilities, plants and strategic infrastructure  -  planned and licensed to standard.</p>
</div>
</div>

</div>
</div>
</section>


<?php get_footer(); ?>
