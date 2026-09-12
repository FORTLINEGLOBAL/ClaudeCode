/* בסיס כתובות המדיה מוזרק על ידי התבנית (ראו functions.php) */
var KHM_MEDIA = (window.KHM && window.KHM.media) || 'media/';

/* ==========================================================================
   נתוני העבודות — לעדכון תוכן, ערכו רק את המערך הזה.
   image: נתיב לתמונה | video: נתיב לסרטון (אופציונלי, אפשר null)
   ========================================================================== */
var WORKS = [
  {
    cat:'vrf home', type:'מזגן VRF',
    title:'מערכת VRF של סמסונג בווילה דו-קומתית',
    text:'מערכת VRF של סמסונג בווילה בת שתי קומות, עם שליטה נפרדת בכל חלל. בווילה דו-קומתית ' +
         'האתגר המרכזי הוא מסלולי הצנרת בין הקומות ושמירה על שיפוע ניקוז רציף לאורך כל המסלול — ' +
         'שני דברים שנקבעים בשלב התכנון ולא ניתן לתקן אותם אחר כך.',
    tags:['VRF סמסונג','וילה דו-קומתית'],
    image:null, video:KHM_MEDIA+'work-01.mp4'
  },
  {
    cat:'vrf', type:'מזגן VRF',
    title:'מערכת VRF מורכבת בדירה',
    text:'מערכת VRF בדירה — יחידת חוץ אחת המזינה כמה יחידות פנים, עם שליטה נפרדת בכל חדר. ' +
         'בדירה האתגר הוא להעביר את הצנרת בתוך תקרות הגבס בלי לרדת בגובה יותר מהנדרש, ' +
         'ולהשאיר גישה לתחזוקה בכל נקודת חיבור.',
    tags:['VRF','דירה','שליטה נפרדת בכל חדר'],
    image:null, video:KHM_MEDIA+'work-02.mp4'
  },
  {
    cat:'vrf', type:'מזגן VRF',
    title:'מערכת VRF של אלקטרה בדירת 5 חדרים',
    text:'מערכת VRF של אלקטרה בדירת 5 חדרים — יחידת חוץ אחת המזינה יחידות פנים בכל החדרים, ' +
         'עם שליטה נפרדת בכל חדר. בדירה בגודל כזה זה ההבדל בין מערכת שמקררת את כל הדירה יחד ' +
         'לבין מערכת שבה כל חדר עובד לפי מה שנדרש בו בפועל — וזה גם מה שחוסך בחשמל.',
    tags:['VRF אלקטרה','דירת 5 חדרים','שליטה נפרדת בכל חדר'],
    image:null, video:KHM_MEDIA+'work-03.mp4'
  },
  {
    cat:'finish', type:'גבס וגמרים',
    title:'צביעה מקצועית בגמר של התקנה',
    text:'הגמר הוא חלק מהעבודה, לא שלב שמישהו אחר יסגור. אחרי ההתקנה אנחנו סוגרים בגבס, ' +
         'מיישרים וצובעים בספריי — כך שהמערכת נעלמת בתוך התקרה והחלל נמסר מוגמר ' +
         'ברמה יוקרתית, בלי להזמין בעל מקצוע נוסף ובלי לחכות לו.',
    tags:['צביעה בספריי','עבודות גבס','מסירה מוגמרת'],
    image:null, video:KHM_MEDIA+'work-04.mp4'
  },
  {
    cat:'home', type:'בית פרטי',
    title:'התקנת מערכת מיזוג מתקדמת בבית פרטי',
    text:'בבית פרטי יש חופש תכנוני שאין בדירה — אפשר לקבוע מראש את מיקומי היחידות, ' +
         'את מסלולי הצנרת ואת נקודות הניקוז לפי מה שנכון למערכת, ולא לפי מה שהמבנה מכתיב. ' +
         'זה מה שמאפשר מערכת שמוסתרת לגמרי ועדיין נגישה לתחזוקה בכל נקודה.',
    tags:['בית פרטי','מערכת מתקדמת'],
    image:null, video:KHM_MEDIA+'work-05.mp4'
  },
  {
    cat:'vrf home', type:'מזגן VRF',
    title:'מערכת VRF של סמסונג בבית מורכב במיוחד',
    text:'ככל שהמבנה מורכב יותר — יותר מפלסים, יותר חללים, פחות מסלולים ישרים — כך התכנון ' +
         'המוקדם קובע יותר. בבית כזה כל מסלול צנרת וכל נקודת ניקוז צריכים להיקבע לפני שמתחילים, ' +
         'כי בדיעבד אין דרך לתקן אותם בלי לפתוח את מה שכבר נסגר.',
    tags:['VRF סמסונג','בית מורכב','תכנון מוקדם'],
    image:null, video:KHM_MEDIA+'work-06.mp4'
  },
  {
    cat:'vrf', type:'מזגן VRF',
    title:'מערכת VRF של תדיראן בחלל בתקרה גבוהה',
    text:'תקרה גבוהה משנה את כל חישוב המיזוג: האוויר החם עולה ונאסף למעלה, ' +
         'ומערכת שתוכננה לגובה תקרה רגיל פשוט תעבוד בלי להפסיק ולא תגיע לטמפרטורה. ' +
         'הפתרון הוא בחירת יחידות ומיקומן לפי הגובה בפועל ולפי כיוון זרימת האוויר בחלל.',
    tags:['VRF תדיראן','תקרה גבוהה','תכנון לפי נפח'],
    image:null, video:KHM_MEDIA+'work-07.mp4'
  },
  {
    cat:'finish', type:'גבס וגמרים',
    title:'ביצוע גמרים ברמה הגבוהה ביותר',
    text:'הגמר הוא מה שרואים אחרי שהמערכת כבר עובדת. סגירת גבס ישרה, פינות נקיות, ' +
         'מסתורים שנפתחים כשצריך וצביעה אחידה — זה מה שמפריד בין התקנה שנראית כמו ' +
         'עבודה שנעשתה בבית, לבין חלל שנראה כאילו המערכת תוכננה לתוכו מלכתחילה.',
    tags:['גמרים','סגירת גבס','מסתורים'],
    image:null, video:KHM_MEDIA+'work-08.mp4'
  },
  {
    cat:'finish', type:'גבס וגמרים',
    title:'גמרים ברמה הגבוהה ביותר — התוצר הסופי',
    text:'ככה נראה החלל אחרי שהכול נסגר: תקרת גבס ישרה, צביעה בספריי בגוון אחיד, ' +
         'ואף סימן לכך שעברה שם מערכת מיזוג שלמה. זה השלב שבו נמדדת העבודה — ' +
         'לא בשלב הצנרת שאף אחד לא רואה, אלא בתוצאה שנשארת מול העיניים.',
    tags:['תוצר סופי','צביעה בספריי','תקרת גבס'],
    image:null, video:KHM_MEDIA+'work-09.mp4'
  },
  {
    cat:'vrf', type:'מזגן VRF',
    title:'מערכת VRF של מיצובישי',
    text:'מיצובישי היא המערכת המתקדמת והטובה ביותר שיש היום בשוק, וזו גם המערכת שאנחנו ' +
         'ממליצים עליה כשהתקציב מאפשר. היתרון שלה הוא בדיוק במה שנמדד לאורך שנים: ' +
         'שקט בעבודה, יציבות בטמפרטורה ואורך חיים של המדחס. מערכת כזו מצדיקה את עצמה רק ' +
         'כשהיא מותקנת ומתוכננת בהתאם — אחרת שילמתם על רכיב מצוין שמותקן בינוני.',
    tags:['VRF מיצובישי','המערכת המובילה בשוק'],
    image:null, video:KHM_MEDIA+'work-10.mp4'
  },
  {
    cat:'home', type:'בית חכם',
    title:'מערכת סמסונג שמתחברת לבית החכם',
    text:'המערכת של סמסונג מתחברת למערכת הבית החכם — שליטה בכל יחידה מהטלפון או מהמסך ' +
         'המרכזי, תרחישים לפי שעה ולפי חדר, ובקרה על מה שבאמת צורך חשמל בבית. ' +
         'החיבור הזה צריך להילקח בחשבון כבר בשלב התכנון, כי הוא משפיע על בחירת היחידות ' +
         'ועל התשתית שמונחת בקירות עוד לפני שסוגרים אותם.',
    tags:['סמסונג','בית חכם','שליטה מהטלפון'],
    image:null, video:KHM_MEDIA+'work-11.mp4'
  }
];

/* ---------- אייקוני placeholder לפי סוג עבודה (עד שיוזנו תמונות אמיתיות) ---------- */
function svg(inner){
  return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" ' +
         'stroke-linecap="round" stroke-linejoin="round">' + inner + '</svg>';
}
var PH = {
  /* יחידת חוץ עם מאוורר */
  vrf:        {hue:190, icon:svg('<rect x="2.5" y="5" width="19" height="14" rx="2"/><circle cx="12" cy="12" r="3.6"/><path d="M12 8.4v-.9M12 16.5v-.9M8.4 12h-.9M16.5 12h-.9"/>')},
  /* בית פרטי */
  home:       {hue:320, icon:svg('<path d="M3 10.5 12 3l9 7.5"/><path d="M5.5 9.5V20h13V9.5"/><path d="M10 20v-5.5h4V20"/>')},
  /* רולר צביעה / גמרים */
  finish:     {hue:265, icon:svg('<rect x="2.5" y="4" width="12" height="5" rx="1"/><path d="M14.5 6.5h3.5a2 2 0 0 1 2 2V11a2 2 0 0 1-2 2h-6.5"/><rect x="9.5" y="13" width="4.5" height="7" rx="1.5"/>')}
};
function phFor(cat){
  var first = String(cat || '').split(' ')[0];
  return PH[first] || {hue:196, icon:svg('<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 9h4M7 13h2"/>')};
}
var ICON_PH = phFor('').icon;
var ICON_PLAY = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>';

/* ---------- בניית כרטיסי העבודות ---------- */
(function buildWorks(){
  var grid = document.getElementById('works-grid');
  if(!grid) return;
  var html = '';
  for(var i=0;i<WORKS.length;i++){
    var w = WORKS[i];
    var tags = '';
    for(var t=0;t<w.tags.length;t++){ tags += '<span class="tag">' + w.tags[t] + '</span>'; }
    var ph = phFor(w.cat);
    html +=
      '<article class="work reveal" data-cat="' + w.cat + '">' +
        '<button class="work__media" type="button" data-index="' + i + '" aria-label="פתיחת גלריה: ' + w.title + '" style="--ph-h:' + ph.hue + '">' +
          '<span class="work__ph">' + ph.icon + '<span>' + w.type + ' · תמונה תתווסף</span></span>' +
          (w.image
            ? '<img src="' + w.image + '" alt="' + w.title + '" loading="lazy" onerror="this.style.display=\'none\'">'
            : (w.video
                ? '<video class="work__thumb" src="' + w.video + '" muted loop playsinline preload="metadata"></video>'
                : '')) +
          '<span class="work__type">' + w.type + '</span>' +
          (w.video ? '<span class="work__play">' + ICON_PLAY + '</span>' : '') +
        '</button>' +
        '<div class="work__body">' +
          '<h3>' + w.title + '</h3>' +
          '<p>' + w.text + '</p>' +
          '<div class="work__meta">' + tags + '</div>' +
        '</div>' +
      '</article>';
  }
  grid.innerHTML = html;
})();

/* ---------- תצוגות מקדימות בכרטיסים: מתנגנות רק כשהן על המסך ---------- */
(function cardPreviews(){
  var clips = document.querySelectorAll('.work__thumb');
  if(!clips.length) return;
  var still = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* הקליפ נחשף רק אחרי שיש לו פריים אמיתי; אם הוא נכשל נשאר ה-placeholder המעוצב */
  for(var c=0;c<clips.length;c++){
    (function(v){
      if(still){ v.preload = 'metadata'; }
      v.addEventListener('loadeddata', function(){ v.classList.add('is-ready'); });
      v.addEventListener('error', function(){ v.remove(); });
    })(clips[c]);
  }

  if(still) return;
  if(!('IntersectionObserver' in window)) return;

  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(entry){
      var v = entry.target;
      if(entry.isIntersecting){
        var playing = v.play();
        if(playing && playing.catch){ playing.catch(function(){}); }
      } else if(!v.paused){
        v.pause();
      }
    });
  }, {threshold:.25});

  for(var i=0;i<clips.length;i++){ io.observe(clips[i]); }
})();

/* ---------- סינון ---------- */
(function filters(){
  var chips = document.querySelectorAll('.chip');
  for(var i=0;i<chips.length;i++){
    chips[i].addEventListener('click', function(){
      var f = this.getAttribute('data-filter');
      for(var j=0;j<chips.length;j++){ chips[j].classList.remove('is-active'); }
      this.classList.add('is-active');
      var cards = document.querySelectorAll('.work');
      for(var k=0;k<cards.length;k++){
        var cats = (cards[k].getAttribute('data-cat') || '').split(' ');
        var show = (f === 'all') || (cats.indexOf(f) !== -1);
        cards[k].hidden = !show;
      }
    });
  }
})();

/* ---------- תמונת אקמל: תחליף מעוצב עד שהקובץ קיים ---------- */
(function akmalPhoto(){
  var img = document.getElementById('akmalPhoto');
  if(!img) return;
  img.addEventListener('error', function(){
    var holder = img.parentNode;
    img.remove();
    var ph = document.createElement('div');
    ph.className = 'about__ph';
    ph.innerHTML = '<span>א</span><small>תמונה של אקמל<br>תתווסף כאן</small>';
    holder.insertBefore(ph, holder.firstChild);
  });
})();

/* ---------- לייטבוקס ---------- */
(function lightbox(){
  var box = document.getElementById('lightbox');
  var media = document.getElementById('lbMedia');
  var title = document.getElementById('lbTitle');
  var text = document.getElementById('lbText');
  var closeBtn = document.getElementById('lbClose');
  var lastFocus = null;

  function open(i){
    var w = WORKS[i];
    lastFocus = document.activeElement;
    title.textContent = w.type + ' — ' + w.title;
    text.textContent = w.text;
    if(w.video){
      media.innerHTML = '<video src="' + w.video + '" controls autoplay playsinline' +
                        (w.image ? ' poster="' + w.image + '"' : '') + '></video>';
    } else if(!w.image){
      var p0 = phFor(w.cat);
      media.innerHTML = '<div class="lightbox__ph" style="--ph-h:' + p0.hue + '">' + p0.icon +
                        '<span>' + w.type + ' — תמונה תתווסף בקרוב</span></div>';
    } else {
      media.innerHTML = '<img src="' + w.image + '" alt="' + w.title + '">';
      var img = media.querySelector('img');
      img.addEventListener('error', function(){
        var ph = phFor(w.cat);
        media.innerHTML = '<div class="lightbox__ph" style="--ph-h:' + ph.hue + '">' + ph.icon +
                          '<span>' + w.type + ' — תמונה תתווסף בקרוב</span></div>';
      });
    }
    box.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    closeBtn.focus();
  }
  function close(){
    box.classList.remove('is-open');
    media.innerHTML = '';
    document.body.style.overflow = '';
    if(lastFocus){ lastFocus.focus(); }
  }

  document.addEventListener('click', function(e){
    if(!e.target.closest) return;
    var card = e.target.closest('.work');
    if(!card) return;
    var trigger = card.querySelector('.work__media');
    if(trigger){ open(parseInt(trigger.getAttribute('data-index'),10)); }
  });
  closeBtn.addEventListener('click', close);
  box.addEventListener('click', function(e){ if(e.target === box){ close(); } });
  document.addEventListener('keydown', function(e){ if(e.key === 'Escape' && box.classList.contains('is-open')){ close(); } });
})();

/* ---------- ניווט: מצב "נדבק" + תפריט נייד ---------- */
(function navBehavior(){
  var nav = document.getElementById('nav');
  var burger = document.getElementById('burger');
  var links = document.getElementById('navLinks');

  function onScroll(){
    if(window.scrollY > 40){ nav.classList.add('is-stuck'); }
    else { nav.classList.remove('is-stuck'); }
  }
  window.addEventListener('scroll', onScroll, {passive:true});
  onScroll();

  burger.addEventListener('click', function(){
    var open = links.classList.toggle('is-open');
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  links.addEventListener('click', function(e){
    if(e.target.tagName === 'A'){
      links.classList.remove('is-open');
      burger.setAttribute('aria-expanded','false');
    }
  });
})();

/* ---------- וידאו רקע: מוצג רק אם הקובץ באמת קיים ---------- */
(function heroVideo(){
  var video = document.getElementById('heroVideo');
  var fallback = document.getElementById('heroFallback');
  if(!video) return;
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if(reduced) return;

  video.addEventListener('loadeddata', function(){
    video.hidden = false;
    fallback.style.opacity = '0';
    fallback.style.transition = 'opacity .8s ease';
  });
  video.addEventListener('error', function(){ video.hidden = true; }, true);
  video.preload = 'auto';
  video.load();
})();

/* ---------- אנימציית חשיפה בגלילה ---------- */
(function reveal(){
  var items = document.querySelectorAll('.reveal');
  if(!('IntersectionObserver' in window)){
    for(var i=0;i<items.length;i++){ items[i].classList.add('is-in'); }
    return;
  }
  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(entry){
      if(entry.isIntersecting){
        entry.target.classList.add('is-in');
        io.unobserve(entry.target);
      }
    });
  }, {threshold:.12, rootMargin:'0px 0px -60px'});
  for(var j=0;j<items.length;j++){ io.observe(items[j]); }
})();
