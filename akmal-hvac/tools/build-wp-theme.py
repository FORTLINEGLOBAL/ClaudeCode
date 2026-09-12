#!/usr/bin/env python3
"""Generate the WordPress theme from index.html.

index.html stays the single source of truth: the CSS, the JavaScript and the
markup are all lifted out of it and split into WordPress template files, so a
change to the site is one re-run away from being a theme change too. Nothing
about the design, the fonts or the copy is re-authored here.

  python3 tools/build-wp-theme.py           # build wp-theme/kol-hamizug/
  python3 tools/build-wp-theme.py --zip     # also produce the installable .zip
"""
import io, os, re, sys, shutil, zipfile

SITE  = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
OUT   = os.path.join(SITE, "wp-theme")
SLUG  = "kol-hamizug"
THEME = os.path.join(OUT, SLUG)

VERSION = "1.0.0"

src   = io.open(os.path.join(SITE, "index.html"), encoding="utf-8").read()
css   = re.search(r"<style>\n?(.*?)</style>", src, re.S).group(1)
js    = re.search(r"<script>\n?(.*?)</script>\s*</body>", src, re.S).group(1)
body  = re.search(r"<body>(.*)</body>", src, re.S).group(1)

nav      = body[: body.index("</header>") + len("</header>")]
sections = body[body.index("</header>") + len("</header>") : body.index("<footer")]
footer   = body[body.index("<footer") : body.index("<script>")]

# ---------------------------------------------------------------- media paths
# The page refers to media/... relative to itself; in a theme those files live
# under assets/media/ and must be addressed through the theme URL.
def php_media(rel):
    return "<?php echo esc_url( get_theme_file_uri( 'assets/media/%s' ) ); ?>" % rel

def rewrite_markup(html):
    html = re.sub(r'src="media/([^"]+)"', lambda m: 'src="%s"' % php_media(m.group(1)), html)
    return html

nav, sections, footer = (rewrite_markup(x) for x in (nav, sections, footer))

# The phone number and the brand appear in several places; route them through
# helpers so they are changed once, in functions.php.
def php_calls(html):
    html = html.replace('href="tel:+972533346759"', 'href="tel:<?php echo esc_attr( khm_phone( "e164" ) ); ?>"')
    html = html.replace('href="https://wa.me/972533346759"',
                        'href="https://wa.me/<?php echo esc_attr( khm_phone( "wa" ) ); ?>"')
    html = html.replace('<span dir="ltr">053-334-6759</span>',
                        '<span dir="ltr"><?php echo esc_html( khm_phone() ); ?></span>')
    return html

nav, sections, footer = (php_calls(x) for x in (nav, sections, footer))

# ------------------------------------------------------------------------ JS
# WORKS still lives in the script, but its media paths are resolved against a
# base URL the theme hands over, instead of being relative to the document.
js = re.sub(r"(video|image):'media/([^']+)'", r"\1:KHM_MEDIA+'\2'", js)
js = ("/* בסיס כתובות המדיה מוזרק על ידי התבנית (ראו functions.php) */\n"
      "var KHM_MEDIA = (window.KHM && window.KHM.media) || 'media/';\n\n" + js)

os.path.exists(THEME) and shutil.rmtree(THEME)
for d in ("", "inc", "js", "assets/media"):
    os.makedirs(os.path.join(THEME, d), exist_ok=True)

def write(rel, text):
    io.open(os.path.join(THEME, rel), "w", encoding="utf-8", newline="\n").write(text)

# --------------------------------------------------------------- style.css
write("style.css", """/*
Theme Name: כל המיזוג
Theme URI: https://github.com/FORTLINEGLOBAL/ClaudeCode
Author: כל המיזוג
Description: תבנית חד-עמודית ל"כל המיזוג" — תכנון וביצוע מיזוג מתקדם. עברית ו-RTL מלא, ללא תלויות בנייה.
Version: %s
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: %s
Tags: one-page, rtl, hebrew, business, custom-colors
*/

%s""" % (VERSION, SLUG, css))

# ------------------------------------------------------------- functions.php
write("functions.php", """<?php
/**
 * כל המיזוג — פונקציות התבנית.
 *
 * @package kol-hamizug
 */

if ( ! defined( 'ABSPATH' ) ) {
\texit;
}

define( 'KHM_VERSION', '%s' );

/**
 * מספר הטלפון של העסק, בשלושה פורמטים.
 *
 * לשינוי המספר — ערכו כאן, או השתמשו במסנן khm_phone בתוסף/תבנית-בת.
 *
 * @param string $format display | e164 | wa
 * @return string
 */
function khm_phone( $format = 'display' ) {
\t$numbers = array(
\t\t'display' => '053-334-6759',
\t\t'e164'    => '+972533346759',
\t\t'wa'      => '972533346759',
\t);

\t$number = isset( $numbers[ $format ] ) ? $numbers[ $format ] : $numbers['display'];

\treturn apply_filters( 'khm_phone', $number, $format );
}

/**
 * תמיכות תבנית.
 *
 * שימו לב: אין כאן title-tag בכוונה — כותרת העמוד כתובה ב-header.php כדי
 * שהאתר ייראה בדיוק כמו הגרסה הסטטית מיד עם ההפעלה. ראו readme.txt למי
 * שמעדיף שכותרת האתר מההגדרות של וורדפרס תנצח.
 */
function khm_setup() {
\tadd_theme_support( 'html5', array( 'style', 'script' ) );
\tadd_theme_support( 'post-thumbnails' );
\tadd_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'khm_setup' );

/**
 * סגנונות וסקריפטים.
 */
function khm_assets() {
\t// Heebo — אותו גופן בדיוק כמו בגרסה הסטטית.
\twp_enqueue_style(
\t\t'khm-heebo',
\t\t'https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;700;900&display=swap',
\t\tarray(),
\t\tnull
\t);

\twp_enqueue_style( 'khm-style', get_stylesheet_uri(), array( 'khm-heebo' ), KHM_VERSION );

\twp_enqueue_script( 'khm-site', get_theme_file_uri( 'js/site.js' ), array(), KHM_VERSION, true );

\t// בסיס כתובות המדיה — כך ש-WORKS ב-js/site.js יטען את הקבצים מתוך התבנית.
\twp_localize_script(
\t\t'khm-site',
\t\t'KHM',
\t\tarray( 'media' => trailingslashit( get_theme_file_uri( 'assets/media' ) ) )
\t);
}
add_action( 'wp_enqueue_scripts', 'khm_assets' );

/**
 * preconnect לשרתי הגופנים — חוסך זמן בטעינה הראשונה.
 */
function khm_resource_hints( $hints, $relation ) {
\tif ( 'preconnect' === $relation ) {
\t\t$hints[] = array( 'href' => 'https://fonts.googleapis.com' );
\t\t$hints[] = array(
\t\t\t'href'        => 'https://fonts.gstatic.com',
\t\t\t'crossorigin' => 'anonymous',
\t\t);
\t}

\treturn $hints;
}
add_filter( 'wp_resource_hints', 'khm_resource_hints', 10, 2 );
""" % VERSION)

# ---------------------------------------------------------------- header.php
write("header.php", """<?php
/**
 * פתיחת המסמך והניווט.
 *
 * dir ו-lang כתובים במפורש ולא דרך language_attributes(), כדי שהאתר יישאר
 * RTL בעברית גם על התקנת וורדפרס שהוגדרה לשפה אחרת.
 *
 * @package kol-hamizug
 */

if ( ! defined( 'ABSPATH' ) ) {
\texit;
}
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>כל המיזוג | תכנון וביצוע מיזוג מתקדם</title>
<meta name="description" content="תכנון וביצוע מערכות מיזוג אוויר ברמה הגבוהה בשוק. VRF, מיני מרכזי, מזגנים עיליים ותכנון מיזוג לווילות. עבודה נקייה, חומרים מקוריים, בלי קיצורי דרך.">
<meta name="theme-color" content="#0b1220">
<meta property="og:title" content="כל המיזוג | תכנון וביצוע מיזוג מתקדם">
<meta property="og:description" content="התקנה טובה לא נמדדת ביום שאחרי — אלא בחודשים ובשנים שאחריה.">
<meta property="og:type" content="website">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

%s
""" % nav.strip())

# ---------------------------------------------------------------- footer.php
write("footer.php", """<?php
/**
 * פוטר, לייטבוקס וסגירת המסמך.
 *
 * @package kol-hamizug
 */

if ( ! defined( 'ABSPATH' ) ) {
\texit;
}
?>
%s
<?php wp_footer(); ?>
</body>
</html>
""" % footer.strip())

# ------------------------------------------------------------ front-page.php
write("front-page.php", """<?php
/**
 * העמוד הראשי — האתר החד-עמודי במלואו.
 *
 * @package kol-hamizug
 */

if ( ! defined( 'ABSPATH' ) ) {
\texit;
}

get_header();
?>

%s
<?php
get_footer();
""" % sections.strip())

write("index.php", """<?php
/**
 * נפילה אחורה: כל בקשה שאינה העמוד הראשי מקבלת את אותו עמוד אחד.
 *
 * @package kol-hamizug
 */

if ( ! defined( 'ABSPATH' ) ) {
\texit;
}

require get_theme_file_path( 'front-page.php' );
""")

write("js/site.js", js.strip() + "\n")

# ------------------------------------------------------------------- assets
for name in sorted(os.listdir(os.path.join(SITE, "media"))):
    s_ = os.path.join(SITE, "media", name)
    if os.path.isfile(s_):
        shutil.copy2(s_, os.path.join(THEME, "assets/media", name))

shot = os.path.join(SITE, "tools", "screenshot.png")
if os.path.exists(shot):
    shutil.copy2(shot, os.path.join(THEME, "screenshot.png"))

readme = os.path.join(SITE, "tools", "wp-readme.txt")
if os.path.exists(readme):
    shutil.copy2(readme, os.path.join(THEME, "readme.txt"))

# --------------------------------------------------------------------- report
total = 0
for root, _, files in os.walk(THEME):
    for f in files:
        total += os.path.getsize(os.path.join(root, f))
print("theme built at", THEME)
for root, _, files in os.walk(THEME):
    for f in sorted(files):
        p = os.path.join(root, f)
        print("  %-34s %8.1f KB" % (os.path.relpath(p, THEME), os.path.getsize(p) / 1024))
print("total: %.2f MB" % (total / 1048576))

if "--zip" in sys.argv:
    zpath = os.path.join(OUT, SLUG + ".zip")
    with zipfile.ZipFile(zpath, "w", zipfile.ZIP_DEFLATED) as z:
        for root, _, files in os.walk(THEME):
            for f in files:
                p = os.path.join(root, f)
                z.write(p, os.path.join(SLUG, os.path.relpath(p, THEME)))
    print("zip: %s  (%.2f MB)" % (zpath, os.path.getsize(zpath) / 1048576))
