<?php
/**
 * TinasXShower functions and definitions
 *
 * @package TinasXShower
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define constants
define('TINASXSHOWER_VERSION', '1.0.0');
define('TINASXSHOWER_DIR', get_template_directory());
define('TINASXSHOWER_URI', get_template_directory_uri());

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function tinasxshower_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Register menu locations
    register_nav_menus(array(
        'primary' => esc_html__('Menú Principal', 'tinasxshower'),
        'footer' => esc_html__('Menú Footer', 'tinasxshower'),
    ));

    // Switch default core markup to output valid HTML5.
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Add support for responsive embeds.
    add_theme_support('responsive-embeds');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
}
add_action('after_setup_theme', 'tinasxshower_setup');

/**
 * Enqueue scripts and styles.
 */
function tinasxshower_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('tinasxshower-style', get_stylesheet_uri(), array(), TINASXSHOWER_VERSION);
    
    // Enqueue custom styles
    wp_enqueue_style('tinasxshower-main', TINASXSHOWER_URI . '/assets/css/main.css', array(), TINASXSHOWER_VERSION);
    
    // Enqueue Tailwind CSS
    wp_enqueue_style('tinasxshower-tailwind', TINASXSHOWER_URI . '/assets/css/tailwind.css', array(), TINASXSHOWER_VERSION);
    
    // Enqueue Google Fonts
    wp_enqueue_style('tinasxshower-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap', array(), null);
    
    // Enqueue main JavaScript file
    wp_enqueue_script('tinasxshower-main', TINASXSHOWER_URI . '/assets/js/main.js', array('jquery'), TINASXSHOWER_VERSION, true);

    // Localize script for AJAX
    wp_localize_script('tinasxshower-main', 'tinasxshower_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('tinasxshower-nonce'),
    ));

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'tinasxshower_scripts');

/**
 * Register widget area.
 */
function tinasxshower_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'tinasxshower'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Añade widgets aquí.', 'tinasxshower'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'tinasxshower'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Añade widgets aquí.', 'tinasxshower'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer 2', 'tinasxshower'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Añade widgets aquí.', 'tinasxshower'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer 3', 'tinasxshower'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Añade widgets aquí.', 'tinasxshower'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'tinasxshower_widgets_init');

/**
 * Custom template tags for this theme.
 */
require TINASXSHOWER_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require TINASXSHOWER_DIR . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require TINASXSHOWER_DIR . '/inc/customizer.php';

/**
 * Load custom post types.
 */
require TINASXSHOWER_DIR . '/inc/post-types.php';

/**
 * Load shortcodes.
 */
require TINASXSHOWER_DIR . '/inc/shortcodes.php';

/**
 * AJAX handlers.
 */
require TINASXSHOWER_DIR . '/inc/ajax-handlers.php';