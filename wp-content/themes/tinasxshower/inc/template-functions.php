<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package TinaXShower
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function tinasxshower_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'tinasxshower_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function tinasxshower_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'tinasxshower_pingback_header');

/**
 * Modify the excerpt length
 */
function tinasxshower_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'tinasxshower_excerpt_length');

/**
 * Modify the excerpt more string
 */
function tinasxshower_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'tinasxshower_excerpt_more');

/**
 * Add SVG support
 */
function tinasxshower_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'tinasxshower_mime_types');

/**
 * Get social links from theme options
 */
function tinasxshower_get_social_links() {
    $social_links = array();
    
    $networks = array('facebook', 'twitter', 'instagram', 'youtube', 'linkedin', 'pinterest', 'tiktok');
    
    foreach ($networks as $network) {
        $url = get_theme_mod('tinasxshower_social_' . $network, '');
        if (!empty($url)) {
            $social_links[$network] = $url;
        }
    }
    
    return $social_links;
}

/**
 * Get contact information from theme options
 */
function tinasxshower_get_contact_info() {
    $contact_info = array(
        'phone' => get_theme_mod('tinasxshower_contact_phone', ''),
        'whatsapp' => get_theme_mod('tinasxshower_contact_whatsapp', ''),
        'email' => get_theme_mod('tinasxshower_contact_email', ''),
        'address' => get_theme_mod('tinasxshower_contact_address', ''),
        'map_embed' => get_theme_mod('tinasxshower_contact_map_embed', ''),
    );
    
    return $contact_info;
}

/**
 * Get hero slides from theme options
 */
function tinasxshower_get_hero_slides() {
    $slides = array();
    $slide_count = 3; // Number of slides to check for
    
    for ($i = 1; $i <= $slide_count; $i++) {
        $image_id = get_theme_mod('tinasxshower_hero_slide_' . $i . '_image', '');
        $title = get_theme_mod('tinasxshower_hero_slide_' . $i . '_title', '');
        $subtitle = get_theme_mod('tinasxshower_hero_slide_' . $i . '_subtitle', '');
        $button_text = get_theme_mod('tinasxshower_hero_slide_' . $i . '_button_text', '');
        $button_url = get_theme_mod('tinasxshower_hero_slide_' . $i . '_button_url', '');
        
        // Only add slide if it has an image
        if (!empty($image_id)) {
            $slides[] = array(
                'image_id' => $image_id,
                'image_url' => wp_get_attachment_image_url($image_id, 'full'),
                'title' => $title,
                'subtitle' => $subtitle,
                'button_text' => $button_text,
                'button_url' => $button_url,
            );
        }
    }
    
    return $slides;
}

/**
 * Format WhatsApp number for link
 */
function tinasxshower_format_whatsapp_number($number) {
    // Remove any non-numeric characters
    $clean_number = preg_replace('/[^0-9]/', '', $number);
    
    return $clean_number;
}

/**
 * Add custom image sizes
 */
function tinasxshower_add_image_sizes() {
    add_image_size('tinasxshower-hero', 1920, 800, true);
    add_image_size('tinasxshower-service', 600, 400, true);
    add_image_size('tinasxshower-gallery', 400, 400, true);
}
add_action('after_setup_theme', 'tinasxshower_add_image_sizes');