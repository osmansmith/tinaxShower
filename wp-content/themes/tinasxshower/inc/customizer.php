<?php
/**
 * TinaXShower Theme Customizer
 *
 * @package TinaXShower
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function tinasxshower_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'tinasxshower_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'tinasxshower_customize_partial_blogdescription',
            )
        );
    }

    // Add Hero Section
    $wp_customize->add_section(
        'tinasxshower_hero_section',
        array(
            'title'    => __('Hero Slider', 'tinasxshower'),
            'priority' => 30,
        )
    );

    // Add slides
    for ($i = 1; $i <= 3; $i++) {
        // Slide Image
        $wp_customize->add_setting(
            'tinasxshower_hero_slide_' . $i . '_image',
            array(
                'default'           => '',
                'sanitize_callback' => 'absint',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'tinasxshower_hero_slide_' . $i . '_image',
                array(
                    'label'    => sprintf(__('Slide %d Imagen', 'tinasxshower'), $i),
                    'section'  => 'tinasxshower_hero_section',
                    'settings' => 'tinasxshower_hero_slide_' . $i . '_image',
                    'mime_type' => 'image',
                )
            )
        );

        // Slide Title
        $wp_customize->add_setting(
            'tinasxshower_hero_slide_' . $i . '_title',
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control(
            'tinasxshower_hero_slide_' . $i . '_title',
            array(
                'label'    => sprintf(__('Slide %d Título', 'tinasxshower'), $i),
                'section'  => 'tinasxshower_hero_section',
                'type'     => 'text',
            )
        );

        // Slide Subtitle
        $wp_customize->add_setting(
            'tinasxshower_hero_slide_' . $i . '_subtitle',
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control(
            'tinasxshower_hero_slide_' . $i . '_subtitle',
            array(
                'label'    => sprintf(__('Slide %d Subtítulo', 'tinasxshower'), $i),
                'section'  => 'tinasxshower_hero_section',
                'type'     => 'text',
            )
        );

        // Slide Button Text
        $wp_customize->add_setting(
            'tinasxshower_hero_slide_' . $i . '_button_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control(
            'tinasxshower_hero_slide_' . $i . '_button_text',
            array(
                'label'    => sprintf(__('Slide %d Texto del Botón', 'tinasxshower'), $i),
                'section'  => 'tinasxshower_hero_section',
                'type'     => 'text',
            )
        );

        // Slide Button URL
        $wp_customize->add_setting(
            'tinasxshower_hero_slide_' . $i . '_button_url',
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control(
            'tinasxshower_hero_slide_' . $i . '_button_url',
            array(
                'label'    => sprintf(__('Slide %d URL del Botón', 'tinasxshower'), $i),
                'section'  => 'tinasxshower_hero_section',
                'type'     => 'url',
            )
        );
    }

    // Add Contact Information Section
    $wp_customize->add_section(
        'tinasxshower_contact_section',
        array(
            'title'    => __('Información de Contacto', 'tinasxshower'),
            'priority' => 40,
        )
    );

    // Phone
    $wp_customize->add_setting(
        'tinasxshower_contact_phone',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_contact_phone',
        array(
            'label'    => __('Teléfono', 'tinasxshower'),
            'section'  => 'tinasxshower_contact_section',
            'type'     => 'text',
        )
    );

    // WhatsApp
    $wp_customize->add_setting(
        'tinasxshower_contact_whatsapp',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_contact_whatsapp',
        array(
            'label'    => __('WhatsApp', 'tinasxshower'),
            'section'  => 'tinasxshower_contact_section',
            'type'     => 'text',
        )
    );

    // Email
    $wp_customize->add_setting(
        'tinasxshower_contact_email',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_email',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_contact_email',
        array(
            'label'    => __('Email', 'tinasxshower'),
            'section'  => 'tinasxshower_contact_section',
            'type'     => 'email',
        )
    );

    // Address
    $wp_customize->add_setting(
        'tinasxshower_contact_address',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_contact_address',
        array(
            'label'    => __('Dirección', 'tinasxshower'),
            'section'  => 'tinasxshower_contact_section',
            'type'     => 'textarea',
        )
    );

    // Map Embed
    $wp_customize->add_setting(
        'tinasxshower_contact_map_embed',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_contact_map_embed',
        array(
            'label'    => __('Código de Incrustación del Mapa', 'tinasxshower'),
            'description' => __('Pega el código iframe de Google Maps aquí', 'tinasxshower'),
            'section'  => 'tinasxshower_contact_section',
            'type'     => 'textarea',
        )
    );

    // Add Social Media Section
    $wp_customize->add_section(
        'tinasxshower_social_section',
        array(
            'title'    => __('Redes Sociales', 'tinasxshower'),
            'priority' => 50,
        )
    );

    // Facebook
    $wp_customize->add_setting(
        'tinasxshower_social_facebook',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_social_facebook',
        array(
            'label'    => __('Facebook', 'tinasxshower'),
            'section'  => 'tinasxshower_social_section',
            'type'     => 'url',
        )
    );

    // Instagram
    $wp_customize->add_setting(
        'tinasxshower_social_instagram',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_social_instagram',
        array(
            'label'    => __('Instagram', 'tinasxshower'),
            'section'  => 'tinasxshower_social_section',
            'type'     => 'url',
        )
    );

    // Twitter
    $wp_customize->add_setting(
        'tinasxshower_social_twitter',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_social_twitter',
        array(
            'label'    => __('Twitter', 'tinasxshower'),
            'section'  => 'tinasxshower_social_section',
            'type'     => 'url',
        )
    );

    // YouTube
    $wp_customize->add_setting(
        'tinasxshower_social_youtube',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_social_youtube',
        array(
            'label'    => __('YouTube', 'tinasxshower'),
            'section'  => 'tinasxshower_social_section',
            'type'     => 'url',
        )
    );

    // TikTok
    $wp_customize->add_setting(
        'tinasxshower_social_tiktok',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_social_tiktok',
        array(
            'label'    => __('TikTok', 'tinasxshower'),
            'section'  => 'tinasxshower_social_section',
            'type'     => 'url',
        )
    );

    // Footer Section
    $wp_customize->add_section(
        'tinasxshower_footer_section',
        array(
            'title'    => __('Footer', 'tinasxshower'),
            'priority' => 60,
        )
    );

    // Copyright Text
    $wp_customize->add_setting(
        'tinasxshower_footer_copyright',
        array(
            'default'           => sprintf(__('© %s TinaXShower. Todos los derechos reservados.', 'tinasxshower'), date('Y')),
            'sanitize_callback' => 'wp_kses_post',
        )
    );

    $wp_customize->add_control(
        'tinasxshower_footer_copyright',
        array(
            'label'    => __('Texto de Copyright', 'tinasxshower'),
            'section'  => 'tinasxshower_footer_section',
            'type'     => 'textarea',
        )
    );
}
add_action('customize_register', 'tinasxshower_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function tinasxshower_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function tinasxshower_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function tinasxshower_customize_preview_js() {
    wp_enqueue_script('tinasxshower-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), TINASXSHOWER_VERSION, true);
}
add_action('customize_preview_init', 'tinasxshower_customize_preview_js');