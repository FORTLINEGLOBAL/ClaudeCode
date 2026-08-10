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


<?php get_footer(); ?>
