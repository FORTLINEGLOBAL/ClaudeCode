<?php
/**
 * Template Name: Contact
 */
get_header(); ?>

<!-- ===== CONTACT ===== -->
<section class="contact" id="contact">
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
<button type="submit" class="form-submit">Submit Inquiry &rarr;</button>
</form>
<div id="formSuccess" class="form-success" style="display:none" role="status" aria-live="polite">
<div class="form-success-icon" aria-hidden="true">
<svg viewBox="0 0 24 24" width="34" height="34" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
</div>
<h3 data-i18n="ct.success_t">Thank you for reaching out</h3>
<p data-i18n="ct.success_p">Your request has been received. Our team will review it and contact you shortly.</p>
</div>
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


<?php get_footer(); ?>
