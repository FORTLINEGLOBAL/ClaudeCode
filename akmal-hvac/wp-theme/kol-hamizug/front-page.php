<?php
/**
 * העמוד הראשי — האתר החד-עמודי במלואו.
 *
 * @package kol-hamizug
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- ============================ HERO ============================ -->
<section class="hero" id="top">
  <div class="hero__media">
    <!-- החליפו את media/hero.mp4 בסרטון רקע אמיתי. עד שהקובץ קיים מוצג רקע חלופי מעוצב. -->
    <video id="heroVideo" autoplay muted loop playsinline preload="none" hidden>
      <source src="<?php echo esc_url( get_theme_file_uri( 'assets/media/hero.mp4' ) ); ?>" type="video/mp4">
    </video>
    <div class="hero__fallback" id="heroFallback" aria-hidden="true"></div>
  </div>
  <div class="hero__scrim" aria-hidden="true"></div>

  <div class="wrap hero__inner">
    <span class="hero__badge"><span class="dot" aria-hidden="true"></span>תכנון · ביצוע · אחריות מלאה</span>
    <h1>מיזוג אוויר שנשאר<br><span class="grad"><span class="nb">מושלם שנים</span> <span class="nb">אחרי ההתקנה,</span> <span class="nb">ללא פשרות</span></span></h1>
    <p class="hero__sub">
      תכנון וביצוע מערכות מיזוג ברמה הגבוהה בשוק — VRF, מיני מרכזי, מזגנים עיליים ותכנון מלא לווילות ובנייה חדשה.
      חומרים מקוריים בלבד, עבודה לפי הספר, בלי קיצורי דרך.
    </p>
    <div class="hero__actions">
      <a class="btn btn--primary" href="#contact">
        לקבלת ייעוץ ותכנון
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" aria-hidden="true"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
      </a>
      <a class="btn btn--ghost" href="#works">לצפייה בעבודות</a>
    </div>

    <ul class="hero__strip">
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>תכנון הנדסי לפני כל חציבה</li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>חומרים מהאיכות הגבוהה בשוק</li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>מסירה מתועדת ובדיקות בלחץ</li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>ליווי גם אחרי סיום העבודה</li>
    </ul>
  </div>

  <div class="hero__scroll" aria-hidden="true"><span></span></div>
</section>

<!-- ============================ על אקמל ============================ -->
<section class="section about" id="about">
  <div class="wrap">
    <div class="about__grid reveal">
      <div class="about__photo">
        <img id="akmalPhoto" src="<?php echo esc_url( get_theme_file_uri( 'assets/media/akmal.jpg' ) ); ?>" alt="אקמל, בעל החברה כל המיזוג" loading="lazy" width="953" height="960">
        <span class="about__badge"><b>20</b> שנות ניסיון</span>
      </div>
      <div class="about__body">
        <span class="eyebrow">מי עומד מאחורי העבודה</span>
        <h2>אקמל — 20 שנות ניסיון במיזוג אוויר</h2>
        <p>
          כל המיזוג היא חברה של בעל מקצוע אחד שמלווה כל פרויקט מהתכנון ועד המסירה.
          עשרים שנות ניסיון בשטח מלמדות בעיקר דבר אחד: כל קיצור דרך חוזר אחרי שנה־שנתיים,
          וכל דבר שנעשה נכון מלכתחילה פשוט ממשיך לעבוד בלי שתצטרכו לחשוב עליו.
        </p>
        <p>
          העבודה לא נגמרת ביחידה שתלויה על הקיר: אנחנו מייעצים לפני הרכישה, מתכננים,
          מתקינים, ומבצעים גם את עבודות הגבס והגמר — עד לתוצאה היפה ביותר שאפשר לקבל,
          במחירים משתלמים.
        </p>
        <ul class="about__list">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
            איכות ושירות ללא פשרות — מהשיחה הראשונה ועד אחרי המסירה
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
            ייעוץ לפני ההתקנה — איזו מערכת באמת נכונה לנכס שלכם
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
            עבודות גבס וגמר ברמה היפה ביותר שיש — הכול אצלנו, בלי בעל מקצוע נוסף
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
            מחירים משתלמים ביחס לרמת הביצוע ולחומרים
          </li>
        </ul>
        <div class="hero__actions" style="margin-block-start:2rem">
          <a class="btn btn--primary" href="tel:<?php echo esc_attr( khm_phone( "e164" ) ); ?>">
            דברו עם אקמל · <span dir="ltr"><?php echo esc_html( khm_phone() ); ?></span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================ הצעת הערך ============================ -->
<section class="section value" id="value">
  <div class="wrap">
    <div class="value__grid">
      <div class="reveal">
        <span class="eyebrow">הצעת הערך שלנו</span>
        <h2 class="section__title">איכות התקנה לא נמדדת ביום שאחרי</h2>
        <p class="value__lead">
          כל התקנה נראית טוב ביום הראשון. השאלה האמיתית היא איך היא נראית — ואיך היא עובדת — אחרי חודשים ואחרי שנים.
        </p>
        <p class="value__body">
          אנחנו עובדים בשיטה אחת: תכנון מקצועי לפני כל בורג, שימוש בחומרים הטובים ביותר שקיימים בשוק, וביצוע מלא לפי הספר.
          אין אצלנו קיצורי דרך — לא בצנרת, לא בבידוד, לא בניקוז ולא בבדיקות. כל שלב שנראה "קטן" הוא בדיוק השלב שקובע
          אם המערכת תעבוד בשקט עשר שנים או תתחיל לעשות בעיות בקיץ השני.
        </p>
        <p class="value__body">
          קיצור דרך חוסך שעה בהתקנה ועולה ימים של תיקונים, קירות פתוחים ותקרות שנפגעו. לכן אנחנו מעדיפים להשקיע את
          הזמן הזה מראש — ולמסור מערכת שפשוט עובדת.
        </p>

        <blockquote class="quote">
          <p>״התקנה טובה מונעת נזילות, ירידת ביצועים, רעשים ותקלות חוזרות. לא כי נהיה שם לתקן — אלא כי לא תצטרכו אותנו.״</p>
          <small>אקמל — תכנון וביצוע מיזוג מתקדם</small>
        </blockquote>
      </div>

      <div class="pillars reveal">
        <article class="pillar">
          <span class="pillar__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-6h6v6"/></svg>
          </span>
          <div>
            <h3>תכנון מקצועי — לא ניחוש</h3>
            <p>חישוב עומסי חום אמיתי לכל חלל, בחירת מערכת מתאימה, ותכנון מסלולי צנרת וניקוז לפני שמתחילים לעבוד.</p>
          </div>
        </article>

        <article class="pillar">
          <span class="pillar__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="M12 22V12"/><path d="m3.3 7 8.7 5 8.7-5"/></svg>
          </span>
          <div>
            <h3>החומרים הטובים בשוק</h3>
            <p>צנרת נחושת תקנית בעובי הנכון, בידוד איכותי ורציף, ניקוז מקורי וחומרי עזר מקוריים. בלי תחליפים זולים.</p>
          </div>
        </article>

        <article class="pillar">
          <span class="pillar__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/></svg>
          </span>
          <div>
            <h3>אפס קיצורי דרך</h3>
            <p>ואקום מלא, בדיקת לחץ, הלחמות בהזרמת חנקן וכמות גז מדויקת. כל מה שלא רואים — נעשה בדיוק כמו שצריך.</p>
          </div>
        </article>

        <article class="pillar">
          <span class="pillar__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          </span>
          <div>
            <h3>מבחן הזמן</h3>
            <p>אנחנו מתכננים כל מערכת כך שתהיה נגישה לתחזוקה ותמשיך לעבוד בשקט ובביצועים מלאים גם בעוד שנים.</p>
          </div>
        </article>

        <article class="pillar">
          <span class="pillar__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="13" height="5" rx="1"/><path d="M15 6.5h3a2 2 0 0 1 2 2V11a2 2 0 0 1-2 2h-6"/><rect x="9.5" y="13" width="5" height="7" rx="1.5"/></svg>
          </span>
          <div>
            <h3>לא נעצרים בהתקנה</h3>
            <p>עבודות גבס, גמרים וצביעה בספריי — הכול אצלנו. המערכת נעלמת בתוך התקרה ואתם מקבלים חלל מוגמר ברמה יוקרתית, לא אתר עבודה שצריך להזמין אליו עוד בעל מקצוע.</p>
          </div>
        </article>
      </div>
    </div>

    <div class="prevent reveal">
      <h3 class="prevent__title">מה בדיוק מונעת התקנה נכונה</h3>
      <div class="prevent__grid">
        <article class="prevent__card">
          <h4><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7Z"/></svg>נזילות ומים בתקרה</h4>
          <p>שיפוע ניקוז רציף, איטום נכון ובידוד מלא מונעים טפטופים, כתמי רטיבות וקילופי צבע בגבס ובקירות.</p>
        </article>
        <article class="prevent__card">
          <h4><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 5 6 9H2v6h4l5 4z"/><path d="M16 9a5 5 0 0 1 0 6"/><path d="M19.4 5.6a10 10 0 0 1 0 12.8"/></svg>רעשים ורעידות</h4>
          <p>עיגון יציב, בולמי רעידות ומיקום נכון של היחידות שומרים על שקט — גם בחדרי שינה ובשעות הלילה.</p>
        </article>
        <article class="prevent__card">
          <h4><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12h4l3 8 4-16 3 8h4"/></svg>ירידת ביצועים</h4>
          <p>כמות גז מדויקת, אורכי צנרת מתוכננים וזרימת אוויר נכונה שומרים על קירור וחימום מלאים לאורך זמן.</p>
        </article>
        <article class="prevent__card">
          <h4><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>תקלות חוזרות</h4>
          <p>מערכת שהותקנה נכון כמעט לא מייצרת קריאות שירות — וכשצריך תחזוקה, יש אליה גישה מסודרת.</p>
        </article>
      </div>
    </div>
  </div>
</section>

<!-- ============================ מבחר עבודות ============================ -->
<section class="section section--alt" id="works">
  <div class="wrap">
    <div class="section__head reveal">
      <span class="eyebrow">מבחר עבודות</span>
      <h2 class="section__title">פרויקטים שביצענו</h2>
      <p class="section__sub">מבחר מתוך העבודות האחרונות — מדירות ועד וילות ובתים פרטיים, כולל עבודות הגבס והגמרים שסוגרות אותן. לחצו על עבודה לצפייה בווידאו.</p>
    </div>

    <div class="filters reveal" role="group" aria-label="סינון עבודות לפי סוג">
      <button class="chip is-active" data-filter="all">הכל</button>
      <button class="chip" data-filter="vrf">מערכות VRF</button>
      <button class="chip" data-filter="home">בתים פרטיים ווילות</button>
      <button class="chip" data-filter="finish">גבס וגמרים</button>
    </div>

    <div class="works" id="works-grid"></div>
  </div>
</section>

<!-- ============================ עקרונות עבודה ============================ -->
<section class="section principles" id="principles">
  <div class="wrap">
    <div class="section__head reveal">
      <span class="eyebrow">שיטת העבודה</span>
      <h2 class="section__title">עקרונות חשובים בתכנון ובביצוע</h2>
      <p class="section__sub">אלו הכללים שלא מתגמשים אצלנו. הם מה שמפריד בין מערכת שעובדת שנים לבין מערכת שמתחילה לעשות בעיות בקיץ השני.</p>
    </div>

    <div class="principles__grid reveal">
      <article class="principle">
        <span class="principle__num">עיקרון 01</span>
        <h3>מתכננים לפני שחוצבים</h3>
        <p>חישוב עומסי חום לכל חלל, בחירת סוג המערכת והספק מתאים, ותכנון מסלולי צנרת — עוד בשלב השלד או לפני פתיחת קירות.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 02</span>
        <h3>מיקום נכון של היחידות</h3>
        <p>יחידה פנימית ממוקמת לפי זרימת אוויר אמיתית ולא לפי נוחות התקנה. יחידת חוץ ממוקמת עם אוורור, צל וגישה לשירות.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 03</span>
        <h3>צנרת בעובי תקני, במסלול קצר</h3>
        <p>נחושת איכותית בעובי הנדרש, מסלול מתוכנן עם מינימום חיבורים וכיפופים, ואורך שנשאר בטווח שהיצרן מאשר.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 04</span>
        <h3>בידוד מלא ורציף</h3>
        <p>הבידוד ממשיך לאורך כל הצנרת, כולל בנקודות החיבור ובמעברי קירות. בידוד חסר יוצר עיבוי, נזילות וירידת יעילות.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 05</span>
        <h3>ניקוז בשיפוע לכל אורכו</h3>
        <p>קו ניקוז עם שיפוע קבוע, בלי שקעים או "בטן" שאוגרת מים, עם גישה לניקוי. זו הסיבה מספר אחת לנזילות בתקרות.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 06</span>
        <h3>הלחמות בהזרמת חנקן</h3>
        <p>מונע חמצון בתוך הצנרת. פסולת חמצון פוגעת במדחס ובשסתומים — נזק שמופיע רק אחרי שנים, וכבר אי אפשר לתקן בזול.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 07</span>
        <h3>ואקום ובדיקת לחץ לפני הפעלה</h3>
        <p>שאיבת ואקום מלאה להוצאת לחות ואוויר, ובדיקת אטימות בלחץ. בלי זה — לחות במערכת, קרח, ותקלות שחוזרות.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 08</span>
        <h3>כמות גז מדויקת</h3>
        <p>תוספת גז מחושבת לפי אורך הצנרת בפועל ולפי נתוני היצרן. גז חסר או עודף שורף ביצועים ומקצר את חיי המדחס.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 09</span>
        <h3>חשמל ייעודי ומוגן</h3>
        <p>קו ייעודי בחתך הנכון, הגנות מתאימות ומפסק בטיחות נגיש ליד היחידה. בטיחות היא חלק מהתכנון, לא תוספת.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 10</span>
        <h3>גישה לתחזוקה מהיום הראשון</h3>
        <p>פתחי שירות, מסתורים ניתנים לפתיחה ומיקום מסננים בהישג יד. מערכת שאי אפשר לתחזק — תיכשל בסוף.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 11</span>
        <h3>מסירה מתועדת</h3>
        <p>מדידות טמפרטורה, לחצים, זרם עבודה ובדיקת ניקוז — מתועדים ונמסרים ללקוח יחד עם הסבר תפעול ותחזוקה.</p>
      </article>
      <article class="principle">
        <span class="principle__num">עיקרון 12</span>
        <h3>עבודה נקייה ומסודרת</h3>
        <p>הגנה על הבית בזמן העבודה, חציבות מדויקות, סגירה מסודרת וניקיון בסיום. האתר נמסר כמו שהיינו רוצים לקבל אותו.</p>
      </article>
    </div>

    <div class="principles__note reveal">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
      <p><strong>למה זה חשוב לכם?</strong> רוב העקרונות האלה מסתתרים מאחורי הגבס ואף אחד לא רואה אותם ביום המסירה. בדיוק בגלל זה קל לוותר עליהם — ובדיוק בגלל זה אנחנו לא מוותרים.</p>
    </div>
  </div>
</section>

<!-- ============================ שאלות ותשובות ============================ -->
<section class="section" id="faq">
  <div class="wrap">
    <div class="section__head reveal">
      <span class="eyebrow">שאלות ותשובות</span>
      <h2 class="section__title">שאלות נפוצות</h2>
      <p class="section__sub">12 השאלות שאנחנו הכי נשאלים — עם תשובות ישרות, בלי שיווק.</p>
    </div>

    <div class="faq reveal">
      <details class="qa">
        <summary>מה ההבדל בין VRF, מיני מרכזי ומזגן עילי — ומה מתאים לי?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p><strong>מזגן עילי</strong> הוא הפתרון הפשוט והזול ביותר, מתאים לחדר בודד או לדירה קיימת ללא תקרות גבס. <strong>מיני מרכזי</strong> מוסתר בתקרה ומחלק אוויר בתעלות — נותן מראה נקי ואחידות טמפרטורה, ומתאים לדירות ובתים בשיפוץ או בבנייה. <strong>VRF</strong> הוא מערכת מתקדמת שבה יחידת חוץ אחת מזינה הרבה יחידות פנים, כל אחת בשליטה נפרדת — הפתרון הנכון לווילות, פנטהאוזים, משרדים ועסקים.</p>
          <p>הבחירה נקבעת לפי גודל הנכס, מספר החללים, גובה התקרות, שלב הבנייה והתקציב — וזה בדיוק מה שנקבע בשיחת התכנון.</p>
        </div>
      </details>

      <details class="qa">
        <summary>מתי הזמן הנכון לתכנן מיזוג בבנייה חדשה או בשיפוץ?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>כמה שיותר מוקדם — עדיף בשלב השלד או לפני ביצוע החשמל והגבס. תכנון מוקדם מאפשר מסלולי צנרת קצרים ונקיים, מיקום נכון של יחידות, ניקוז בשיפוע טבעי ומסתורים מתוכננים מראש. תכנון מאוחר תמיד מסתיים בפשרות: מסלולים ארוכים, ירידות גבס מיותרות ומיקומים לא אידיאליים.</p>
        </div>
      </details>

      <details class="qa">
        <summary>איך קובעים את ההספק (BTU) הנכון?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>לא לפי מטרים בלבד. חישוב נכון לוקח בחשבון גם כיווני אוויר, שטח חלונות וזיגוג, בידוד המבנה, גובה תקרה, מספר אנשים בחלל ומקורות חום. מזגן קטן מדי יעבוד ללא הפסקה ולא יגיע לטמפרטורה; מזגן גדול מדי יקרר מהר מדי, לא יוריד לחות ויכבה וידלק שוב ושוב — מה שמקצר את חיי המדחס.</p>
        </div>
      </details>

      <details class="qa">
        <summary>למה מזגן מטפטף מים או יוצר רטיבות בתקרה?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>ברוב המקרים זו לא תקלה במזגן אלא תוצאה של התקנה: ניקוז ללא שיפוע מספיק או עם "בטן" שאוגרת מים, ניקוז סתום שאין אליו גישה, בידוד חסר על הצנרת שיוצר עיבוי, או יחידה שלא הותקנה מפולסת. כל אלה נמנעים לחלוטין כשמתקינים נכון מלכתחילה.</p>
        </div>
      </details>

      <details class="qa">
        <summary>למה יש רעש או רעידות מהמזגן?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>רעש נובע כמעט תמיד מעיגון לא יציב, היעדר בולמי רעידות ביחידת החוץ, צנרת שנוגעת בקיר או בגבס ומעבירה רעידות, או מיקום יחידה קרוב מדי לחדר שינה. מיקום ועיגון נכונים בזמן ההתקנה שווים הרבה יותר מכל ניסיון לתקן רעש בדיעבד.</p>
        </div>
      </details>

      <details class="qa">
        <summary>כמה זמן לוקחת התקנה?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>מזגן עילי בודד — בדרך כלל יום עבודה. מיני מרכזי בדירה — כיומיים עד שלושה, בהתאם למסלולי הצנרת. מערכת VRF לווילה או למשרד — מספר ימים, לרוב בשני שלבים: תשתיות לפני הגבס, והתקנת היחידות והפעלה בסיום. לוח הזמנים המדויק נמסר מראש, ואנחנו עומדים בו.</p>
        </div>
      </details>

      <details class="qa">
        <summary>מה החשיבות של איכות הצנרת והבידוד?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>הצנרת והבידוד הם החלק שקבור בקיר — ולכן החלק שאי אפשר לשדרג אחר כך. נחושת דקה מדי עלולה להיסדק בלחץ, ובידוד זול או קטוע יוצר עיבוי ונזילות ומוריד את היעילות. זה בדיוק המקום שבו קיצור דרך חוסך מעט מאוד כסף וגורם לנזק הגדול ביותר, ולכן אנחנו משתמשים רק בחומרים מהאיכות הגבוהה בשוק.</p>
        </div>
      </details>

      <details class="qa">
        <summary>האם צריך גם מערכת אוורור ואוויר צח?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>מזגן ממחזר את האוויר בחלל — הוא מקרר ומחמם, אך לא מכניס אוויר צח. בבתים אטומים, בממ"דים, בחדרי שינה ובעסקים, מערכת אוורור משפרת משמעותית את איכות האוויר ואת תחושת הרעננות. בתכנון אנחנו בודקים אם זה נדרש ומשלבים את התשתית מראש, כדי שלא תצטרכו לפתוח תקרות בעתיד.</p>
        </div>
      </details>

      <details class="qa">
        <summary>כל כמה זמן צריך תחזוקה, ומה היא כוללת?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>ניקוי מסננים אחת לחודש-חודשיים בעונת השימוש, ותחזוקה מקצועית אחת לשנה — לפני הקיץ. תחזוקה שנתית כוללת ניקוי מאייד ומעבה, שטיפת קו ניקוז, בדיקת לחצים וזרם, ובדיקת חיבורי חשמל. זו הדרך הזולה ביותר לשמור על ביצועים ולמנוע תקלות בשיא העומס.</p>
        </div>
      </details>

      <details class="qa">
        <summary>האם יש אחריות, ומה היא מכסה?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>על הציוד חלה אחריות היצרן המלאה, ועל עבודת ההתקנה שלנו אנחנו אחראים בעצמנו. אנחנו מוסרים תיעוד של המערכת בסיום, וזמינים גם אחרי — לשאלות, לכיוונונים ולתחזוקה. אנחנו לא נעלמים אחרי החשבונית.</p>
        </div>
      </details>

      <details class="qa">
        <summary>מה כולל המחיר, והאם צפויות הפתעות?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>ההצעה שאנחנו מגישים מפורטת: ציוד, צנרת, בידוד, ניקוז, חציבות, עבודה, הפעלה ובדיקות. הכול כתוב מראש כדי שתדעו בדיוק על מה אתם משלמים. אם מתגלה משהו במבנה שמחייב שינוי, מעדכנים אתכם לפני שממשיכים — ולא אחרי.</p>
        </div>
      </details>

      <details class="qa">
        <summary>אתם עובדים גם מול אדריכל, מעצב או קבלן?<span class="qa__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span></summary>
        <div class="qa__a">
          <p>בהחלט, וזו הדרך המומלצת. אנחנו מתאמים מול האדריכל את מיקומי היחידות והמסתורים כך שישתלבו בעיצוב, ומול הקבלן והחשמלאי את התשתיות ולוח הזמנים. תיאום מוקדם חוסך שינויים יקרים בהמשך ושומר על התוצאה העיצובית שתכננתם.</p>
        </div>
      </details>
    </div>
  </div>
</section>

<!-- ============================ צור קשר ============================ -->
<section class="cta" id="contact">
  <div class="wrap">
    <div class="cta__box reveal">
      <div class="cta__grid">
        <div>
          <h2>נדבר על הפרויקט שלכם</h2>
          <p>שיחת ייעוץ ראשונה, בדיקת התאמה והצעת מחיר מפורטת — בלי התחייבות. ספרו לנו על הנכס, ונגיד לכם בדיוק מה נכון לעשות ולמה.</p>
        </div>
        <div class="cta__actions">
          <a class="cta__line" href="tel:<?php echo esc_attr( khm_phone( "e164" ) ); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
            <span>התקשרו אלינו<small><span dir="ltr"><?php echo esc_html( khm_phone() ); ?></span></small></span>
          </a>
          <a class="cta__line" href="https://wa.me/<?php echo esc_attr( khm_phone( "wa" ) ); ?>" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/></svg>
            <span>וואטסאפ<small>שלחו תמונות ונחזור אליכם</small></span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================ פוטר ============================ -->
<?php
get_footer();
