<?php
/**
 * כל המיזוג — פונקציות התבנית.
 *
 * @package kol-hamizug
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KHM_VERSION', '1.0.0' );

/**
 * מספר הטלפון של העסק, בשלושה פורמטים.
 *
 * לשינוי המספר — ערכו כאן, או השתמשו במסנן khm_phone בתוסף/תבנית-בת.
 *
 * @param string $format display | e164 | wa
 * @return string
 */
function khm_phone( $format = 'display' ) {
	$numbers = array(
		'display' => '053-334-6759',
		'e164'    => '+972533346759',
		'wa'      => '972533346759',
	);

	$number = isset( $numbers[ $format ] ) ? $numbers[ $format ] : $numbers['display'];

	return apply_filters( 'khm_phone', $number, $format );
}

/**
 * תמיכות תבנית.
 *
 * שימו לב: אין כאן title-tag בכוונה — כותרת העמוד כתובה ב-header.php כדי
 * שהאתר ייראה בדיוק כמו הגרסה הסטטית מיד עם ההפעלה. ראו readme.txt למי
 * שמעדיף שכותרת האתר מההגדרות של וורדפרס תנצח.
 */
function khm_setup() {
	add_theme_support( 'html5', array( 'style', 'script' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'khm_setup' );

/**
 * סגנונות וסקריפטים.
 */
function khm_assets() {
	// Heebo — אותו גופן בדיוק כמו בגרסה הסטטית.
	wp_enqueue_style(
		'khm-heebo',
		'https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;700;900&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'khm-style', get_stylesheet_uri(), array( 'khm-heebo' ), KHM_VERSION );

	wp_enqueue_script( 'khm-site', get_theme_file_uri( 'js/site.js' ), array(), KHM_VERSION, true );

	// בסיס כתובות המדיה — כך ש-WORKS ב-js/site.js יטען את הקבצים מתוך התבנית.
	wp_localize_script(
		'khm-site',
		'KHM',
		array( 'media' => trailingslashit( get_theme_file_uri( 'assets/media' ) ) )
	);
}
add_action( 'wp_enqueue_scripts', 'khm_assets' );

/**
 * preconnect לשרתי הגופנים — חוסך זמן בטעינה הראשונה.
 */
function khm_resource_hints( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = array( 'href' => 'https://fonts.googleapis.com' );
		$hints[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $hints;
}
add_filter( 'wp_resource_hints', 'khm_resource_hints', 10, 2 );
