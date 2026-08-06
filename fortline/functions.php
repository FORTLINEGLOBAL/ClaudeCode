<?php
/**
 * Fortline Global Theme - Functions and Definitions
 */

if (!defined('FORTLINE_THEME_VERSION')) {
    define('FORTLINE_THEME_VERSION', '2.0.0');
}

/**
 * Enqueue scripts and styles
 */
function fortline_scripts() {
    wp_enqueue_style('fortline-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'fortline_scripts');

/**
 * Theme support
 */
function fortline_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    register_nav_menu('primary', esc_html__('Primary Menu', 'fortline'));
}
add_action('after_setup_theme', 'fortline_setup');

/**
 * Auto-create all pages on theme activation
 * This makes the theme work out of the box - no manual page creation needed
 */
function fortline_activate() {
    // Define all pages: slug => [title, template file]
    $pages = array(
        'home' => array(
            'title'    => 'Home',
            'template' => 'front-page.php',
        ),
        'about' => array(
            'title'    => 'About',
            'template' => 'page-about.php',
        ),
        'unique-technology' => array(
            'title'    => 'Unique Technology',
            'template' => 'page-shield6000.php',
        ),
        'customers' => array(
            'title'    => 'Who We Serve',
            'template' => 'page-customers.php',
        ),
        'execution' => array(
            'title'    => 'Execution',
            'template' => 'page-execution.php',
        ),
        'facility-assessment' => array(
            'title'    => 'Facility Assessment',
            'template' => 'page-facility-assessment.php',
        ),
        'national-planning' => array(
            'title'    => 'National Planning',
            'template' => 'page-national-planning.php',
        ),
        'articles' => array(
            'title'    => 'Articles',
            'template' => 'page-articles.php',
        ),
        'article-critical-infrastructure-uae' => array(
            'title'    => 'Critical Infrastructure Protection UAE',
            'template' => 'page-article-critical-infrastructure-uae.php',
        ),
        'article-blast-resistant-fortification' => array(
            'title'    => 'Blast Resistant Building Fortification',
            'template' => 'page-article-blast-resistant-fortification.php',
        ),
        'article-safe-room-retrofit' => array(
            'title'    => 'Safe Room Retrofit Technology',
            'template' => 'page-article-safe-room-retrofit.php',
        ),
        'article-passive-protection-gcc' => array(
            'title'    => 'Passive Protection Defense GCC',
            'template' => 'page-article-passive-protection-gcc.php',
        ),
        'article-qatar-infrastructure' => array(
            'title'    => 'Building Fortification Spray System Qatar',
            'template' => 'page-article-qatar-infrastructure.php',
        ),
    );

    foreach ($pages as $slug => $page_data) {
        // Check if page already exists
        $existing = get_page_by_path($slug);
        if (!$existing) {
            $page_id = wp_insert_post(array(
                'post_title'   => $page_data['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ));
            if ($page_id && !is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        } else {
            // Page exists but maybe template is not set - ensure it is
            update_post_meta($existing->ID, '_wp_page_template', $page_data['template']);
            // Make sure it's published
            if ($existing->post_status !== 'publish') {
                wp_update_post(array(
                    'ID'          => $existing->ID,
                    'post_status' => 'publish',
                ));
            }
        }
    }

    // Set the homepage to "Home" page
    $home_page = get_page_by_path('home');
    if ($home_page) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page->ID);
    }

    // Flush rewrite rules so slugs work immediately
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'fortline_activate');

/**
 * Also run page creation on theme init if pages don't exist yet
 * (handles cases where theme was already active but pages were deleted)
 */
function fortline_check_pages() {
    // Only run in admin and only once per session
    if (!is_admin()) return;

    $check_done = get_transient('fortline_pages_checked');
    if ($check_done) return;

    // Check if home page exists
    $home_page = get_page_by_path('home');
    if (!$home_page) {
        fortline_activate();
    }

    set_transient('fortline_pages_checked', true, DAY_IN_SECONDS);
}
add_action('admin_init', 'fortline_check_pages');

/**
 * Disable WordPress default styles that can interfere with theme
 */
function fortline_dequeue_defaults() {
    // Remove block library CSS (Gutenberg defaults)
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('global-styles');
    // Remove classic theme styles
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'fortline_dequeue_defaults', 100);

/**
 * Remove admin bar margin on frontend
 */
function fortline_admin_bar_style() {
    if (is_admin_bar_showing()) {
        echo '<style>html { margin-top: 0 !important; } #wpadminbar { display: none !important; }</style>';
    }
}
add_action('wp_head', 'fortline_admin_bar_style', 99);

/**
 * Show admin notice after activation
 */
function fortline_activation_notice() {
    $screen = get_current_screen();
    if ($screen && $screen->id === 'themes') {
        $home_page = get_page_by_path('home');
        if ($home_page) {
            echo '<div class="notice notice-success is-dismissible"><p>';
            echo '<strong>Fortline Global theme activated!</strong> All pages have been created automatically. ';
            echo '<a href="' . esc_url(home_url('/')) . '">View your site &rarr;</a>';
            echo '</p></div>';
        }
    }
}
add_action('admin_notices', 'fortline_activation_notice');
