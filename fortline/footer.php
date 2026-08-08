<?php
/**
 * Footer Template
 */
?>

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
