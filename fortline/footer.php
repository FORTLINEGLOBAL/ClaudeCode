<?php /** Footer Template */ ?>
<!-- ===== FOOTER ===== -->
<footer>
<div class="footer-inner">
<div class="footer-brand">
<div class="footer-logo">
<img src="<?php echo get_template_directory_uri(); ?>/images/brand/ari-logo-horizontal-reversed.svg" alt="A.R.I. Faberman Engineering Solutions Ltd." class="footer-logo-img">
</div>
<p class="footer-tagline" data-i18n="footer.tagline">Civil-protection engineering  -  safe rooms (MAMAD), shelters and building-permit licensing, planned and built end to end.</p>
</div>
<div class="footer-col">
<h4 data-i18n="footer.services_h">Services</h4>
<a href="<?php echo home_url('/services/'); ?>" data-i18n="footer.l_services">Our Services</a>
<a href="<?php echo home_url('/projects/'); ?>" data-i18n="footer.l_projects">Projects</a>
<a href="<?php echo home_url('/faq/'); ?>" data-i18n="footer.l_faq">FAQ</a>
</div>
<div class="footer-col">
<h4 data-i18n="footer.company_h">Company</h4>
<a href="<?php echo home_url('/about/'); ?>" data-i18n="footer.l_about">About Us</a>
<a href="<?php echo home_url('/who-we-serve/'); ?>" data-i18n="footer.l_serve">Who We Serve</a>
<a href="<?php echo home_url('/about/'); ?>" data-i18n="footer.l_clients">Clients</a>
</div>
<div class="footer-col">
<h4 data-i18n="footer.contact_h">Get in Touch</h4>
<a href="tel:+972544757201">054-475-7201</a>
<a href="mailto:Ari.engpm@gmail.com">Ari.engpm@gmail.com</a>
<a href="#" data-i18n="footer.addr">Shamir, HaBazelet 8</a>
</div>
</div>
<div class="footer-bar">
<p>&copy; 2026 A.R.I. Faberman Engineering Solutions Ltd. All rights reserved.</p>
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

// Sticky nav — pages without a dark hero stay solid (readable) from the top
const nav=document.getElementById('nav');
const fortlineHasHero=!!document.querySelector('.hero, .page-hero');
if(nav&&!fortlineHasHero){nav.classList.add('solid');}
window.addEventListener('scroll',()=>{if(nav)nav.classList.toggle('scrolled',window.scrollY>80);});

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
phone:form.phone.value
};

// Send via EmailJS
emailjs.send('service_py23y6a','template_lgfttoi',{
to_email:'Ari.engpm@gmail.com',
from_name:data.name,
from_email:data.email,
organization:data.organization||'Not provided',
phone:data.phone||'Not provided',
subject:'New A.R.I. Faberman Inquiry from '+data.name
}).then(function(){
form.reset();
var ok=document.getElementById('formSuccess');
if(ok){ form.style.display='none'; ok.style.display='block'; ok.scrollIntoView({behavior:'smooth',block:'center'}); }
else { btn.textContent='Inquiry Submitted Successfully'; btn.style.background='#16a34a'; btn.style.color='#fff'; }
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
/* mark the current page's nav link active */
(function(){try{var here=location.pathname.replace(/\/$/,'');document.querySelectorAll('.nav-links a,.footer-col a').forEach(function(a){var u=document.createElement('a');u.href=a.getAttribute('href')||'';if(u.pathname.replace(/\/$/,'')===here)a.classList.add('active');});}catch(e){}})();
</script>
<?php
/* WhatsApp floating contact button (site-wide).
   Replace the number with the real WhatsApp number in international format:
   country code + number, digits only (no +, spaces or dashes).
   Example: Israel 050-123-4567  ->  972501234567 */
$fortline_whatsapp = '972544757201'; // +972 54-475-7201
$fortline_wa_msg   = rawurlencode('Hello, I would like to ask about protection solutions.');
?>
<a href="https://wa.me/<?php echo preg_replace('/\D/', '', $fortline_whatsapp); ?>?text=<?php echo $fortline_wa_msg; ?>"
   class="fl-whatsapp" target="_blank" rel="noopener" aria-label="Contact us on WhatsApp" title="Chat on WhatsApp">
  <svg viewBox="0 0 32 32" width="30" height="30" aria-hidden="true" focusable="false">
    <path fill="#fff" d="M16.001 3.2c-7.06 0-12.8 5.74-12.8 12.8 0 2.257.59 4.46 1.712 6.402L3.2 28.8l6.57-1.72a12.74 12.74 0 0 0 6.23 1.62h.005c7.06 0 12.8-5.74 12.8-12.8 0-3.42-1.332-6.635-3.75-9.052A12.71 12.71 0 0 0 16.001 3.2zm0 23.03h-.004a10.6 10.6 0 0 1-5.4-1.48l-.387-.23-4.003 1.05 1.068-3.9-.252-.4a10.56 10.56 0 0 1-1.62-5.64c0-5.86 4.77-10.63 10.64-10.63 2.84 0 5.51 1.108 7.52 3.12a10.56 10.56 0 0 1 3.11 7.52c0 5.86-4.77 10.63-10.64 10.63zm5.83-7.96c-.32-.16-1.89-.93-2.18-1.04-.29-.107-.5-.16-.712.16-.21.32-.816 1.04-1 1.253-.184.213-.368.24-.688.08-.32-.16-1.35-.498-2.57-1.586-.95-.848-1.592-1.895-1.778-2.215-.184-.32-.02-.493.14-.652.144-.143.32-.373.48-.56.16-.187.213-.32.32-.533.107-.213.053-.4-.027-.56-.08-.16-.712-1.717-.976-2.35-.257-.617-.518-.533-.712-.543l-.606-.01c-.21 0-.553.08-.842.4-.29.32-1.104 1.08-1.104 2.635 0 1.556 1.13 3.06 1.288 3.272.16.213 2.225 3.398 5.39 4.766.753.325 1.34.52 1.798.665.755.24 1.443.206 1.987.125.606-.09 1.89-.773 2.156-1.52.266-.746.266-1.386.187-1.52-.08-.133-.29-.213-.61-.373z"/>
  </svg>
</a>
<style>
.fl-whatsapp{position:fixed;right:22px;bottom:22px;z-index:99998;width:56px;height:56px;border-radius:50%;background:#25D366;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 20px rgba(37,211,102,0.45);transition:transform .25s ease,box-shadow .25s ease}
.fl-whatsapp:hover{transform:scale(1.08);box-shadow:0 8px 26px rgba(37,211,102,0.6)}
@media(max-width:640px){.fl-whatsapp{right:16px;bottom:16px;width:52px;height:52px}}
</style>


<?php wp_footer(); ?>
</body>
</html>
