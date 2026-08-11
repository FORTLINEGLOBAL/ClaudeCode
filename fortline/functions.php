<?php
/**
 * ARI Engineering Theme - Functions and Definitions
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
 * English-only build: the multilingual engine, translation files, RTL styles and
 * the language toggle are intentionally NOT loaded. The pages render from their
 * inline English content; any leftover data-i18n attributes are inert without the
 * engine. (To re-enable EN/HE, restore lang-system.js + translations + lang-rtl.css
 * and re-add the enqueue hook here, and the #lang-toggle in header.php.)
 */

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
    // Multi-page site: one real page per menu item, each with its own template.
    $pages = array(
        'home'          => array('title' => 'Home',         'template' => 'front-page.php'),
        'services'      => array('title' => 'Services',     'template' => 'page-services.php'),
        'projects'      => array('title' => 'Projects',     'template' => 'page-projects.php'),
        'who-we-serve'  => array('title' => 'Who We Serve', 'template' => 'page-customers.php'),
        'about'         => array('title' => 'About',        'template' => 'page-about.php'),
        'faq'           => array('title' => 'FAQ',          'template' => 'page-faq.php'),
        'contact'       => array('title' => 'Contact',      'template' => 'page-contact.php'),
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
            echo '<strong>ARI Engineering theme activated!</strong> All pages have been created automatically. ';
            echo '<a href="' . esc_url(home_url('/')) . '">View your site &rarr;</a>';
            echo '</p></div>';
        }
    }
}
add_action('admin_notices', 'fortline_activation_notice');

/**
 * Client roster + reusable "Trusted By" logo wall.
 * Single source of truth so the wall can appear on multiple pages (home + about).
 * To add a client: drop a logo into images/clients/ and add a line below.
 * If the file is missing, the name renders as a text tile so the wall stays full.
 */
function fortline_clients_list() {
    return array(
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
        array('name' => 'Elite Safety Engineering',       'file' => 'elite.png'),
        array('name' => 'Eldar',                          'file' => 'eldar.png'),
        array('name' => 'Afi Capital',                    'file' => 'afi-capital.png'),
        array('name' => 'Electra Living',                 'file' => 'electra-living.png'),
        array('name' => 'Ackerstein',                     'file' => 'ackerstein.jpg'),
        array('name' => 'H.L.M - Business Licensing',     'file' => 'hlm.png'),
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
}

function fortline_render_client_wall($args = array()) {
    $d = array_merge(array(
        'label' => 'Our Clients',
        'title' => 'Trusted By Leading Organizations',
        'sub'   => 'Authorities, municipalities, developers, public institutions and private clients rely on us for civil-protection planning and construction.',
        'bg'    => '#ffffff',
    ), $args);
    $clients = fortline_clients_list();
    $dir = get_template_directory() . '/images/clients/';
    $uri = get_template_directory_uri() . '/images/clients/';
    ?>
<section class="fl-clients" id="clients" style="background:<?php echo esc_attr($d['bg']); ?>">
<div class="container">
<div class="section-label fade-in" style="text-align:center;color:var(--gold-bright)"><?php echo esc_html($d['label']); ?></div>
<div class="section-title fade-in" style="text-align:center"><?php echo esc_html($d['title']); ?></div>
<p class="fade-in" style="color:var(--text-light);max-width:680px;margin:0.5rem auto 0;font-size:0.95rem;text-align:center;line-height:1.7"><?php echo esc_html($d['sub']); ?></p>
<div class="fl-clients-grid fade-in">
<?php foreach ($clients as $c):
    $has = !empty($c['file']) && file_exists($dir . $c['file']); ?>
  <div class="fl-client-tile">
    <?php if ($has): ?>
      <img src="<?php echo esc_url($uri . $c['file']); ?>" alt="<?php echo esc_attr($c['name']); ?>" loading="lazy">
    <?php else: ?>
      <span class="fl-client-name"><?php echo esc_html($c['name']); ?></span>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
</div>
</div>
</section>
<?php
}
