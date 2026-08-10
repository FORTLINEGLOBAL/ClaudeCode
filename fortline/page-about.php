<?php
/**
 * Template Name: About
 */
get_header(); ?>

<!-- ===== WHY: THE NEED ===== -->
<section style="padding:5rem 0;background:var(--bg-dark);position:relative;overflow:hidden" id="why">
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


<!-- ===== TRUSTED BY / CLIENT LOGO WALL =====
     To add a client: drop a logo file into images/clients/ and add a line to the
     $fortline_clients array below (name + file). If the file is missing, the client
     name is shown as a text tile automatically, so the wall always looks complete. -->
<?php
$fortline_clients = array(
    array('name' => 'Home Front Command',             'file' => 'pikud-haoref.png'),
    array('name' => 'Israel Airports Authority',      'file' => 'israel-airports-authority.png'),
    array('name' => 'Ministry of Health',             'file' => 'health.png'),
    array('name' => 'Ministry of Education',          'file' => 'education.png'),
    array('name' => 'Ministry of Welfare',            'file' => 'welfare.png'),
    array('name' => 'Kfar Blum',                      'file' => 'kfar-blum.png'),
    array('name' => 'Kibbutz Shamir',                 'file' => 'kibbutz-shamir.png'),
    array('name' => 'Kibbutz Dafna',                  'file' => 'kibbutz-dafna.png'),
    array('name' => 'Arim',                           'file' => 'arim.png'),
    array('name' => 'Gesem',                          'file' => 'gesham.png'),
    array('name' => 'Betonix',                        'file' => 'betonix.png'),
    array('name' => 'Tempo',                          'file' => 'tampo.png'),
    array('name' => 'Victory',                        'file' => 'victory.png'),
    array('name' => 'Plaston',                        'file' => 'plaston.png'),
    array('name' => 'Hadish',                         'file' => 'hadish.png'),
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







<!-- ===== WHY CHOOSE US ===== -->
<section style="padding:5rem 0;background:#fff;border-top:1px solid var(--border)" id="advantages">
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


<section class="fl-tst" id="testimonials">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)" data-i18n="tst.label">Testimonials</div>
<div class="section-title fade-in" style="text-align:center" data-i18n="tst.title">What Our Clients Say</div>
<div class="fl-tst-grid fade-in">
<div class="fl-tst-card"><p class="fl-tst-quote" data-i18n="tst.q1">ARI Faberman carried out comprehensive protection work for us across several hospitals nationwide. We were very satisfied  -  the team was professional, skilled and reliable, worked under significant time pressure, and finished on time and on budget. We highly recommend them for anyone needing quality protection services.</p><div class="fl-tst-foot"><span class="fl-tst-logo has-img"><img src="<?php echo get_template_directory_uri(); ?>/images/clients/health.png" alt="Ministry of Health" loading="lazy"></span><span class="fl-tst-by" data-i18n="tst.b1">Ministry of Health</span></div></div>
<div class="fl-tst-card"><p class="fl-tst-quote" data-i18n="tst.q2">We warmly recommend ARI Faberman for upgrading MAMADs and shelters. The team was professional, efficient and courteous throughout, worked closely with us to understand our needs, and delivered a tailored solution. The results were excellent and we're confident it will protect our students in an emergency.</p><div class="fl-tst-foot"><span class="fl-tst-logo has-img"><img src="<?php echo get_template_directory_uri(); ?>/images/clients/education.png" alt="Ministry of Education" loading="lazy"></span><span class="fl-tst-by" data-i18n="tst.b2">Ministry of Education</span></div></div>
<div class="fl-tst-card"><p class="fl-tst-quote" data-i18n="tst.q3">We looked for a reliable company to protect our kindergarten's MAMAD and chose ARI Faberman after reading positive reviews. We weren't disappointed  -  professional, efficient and courteous, working quietly and quickly with the children in mind. The upgraded MAMAD looks great and we feel much safer now.</p><div class="fl-tst-foot"><span class="fl-tst-logo"><svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l7-4 7 4v14M10 21v-5h4v5M9 10h.01M15 10h.01M9 13h.01M15 13h.01"/></svg></span><span class="fl-tst-by" data-i18n="tst.b3">"Rakefet" Kindergarten, Sderot</span></div></div>
<div class="fl-tst-card"><p class="fl-tst-quote" data-i18n="tst.q4">Thank you for renovating the shelter at our school. The process was smooth and easy, and the team was friendly and professional. Our upgraded space looks great and we're confident it will provide our students with optimal protection in an emergency.</p><div class="fl-tst-foot"><span class="fl-tst-logo"><svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l7-4 7 4v14M10 21v-5h4v5M9 10h.01M15 10h.01M9 13h.01M15 13h.01"/></svg></span><span class="fl-tst-by" data-i18n="tst.b4">Sde Uziya School</span></div></div>
</div>
</div>
</section>


<?php get_footer(); ?>
