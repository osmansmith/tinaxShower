<?php
/**
 * Custom Post Types for TinaXShower Theme
 *
 * @package TinaXShower
 */

/**
 * Register Custom Post Types
 */
function tinasxshower_register_post_types() {
    // Servicios CPT
    $labels = array(
        'name'                  => _x('Servicios', 'Post type general name', 'tinasxshower'),
        'singular_name'         => _x('Servicio', 'Post type singular name', 'tinasxshower'),
        'menu_name'             => _x('Servicios', 'Admin Menu text', 'tinasxshower'),
        'name_admin_bar'        => _x('Servicio', 'Add New on Toolbar', 'tinasxshower'),
        'add_new'               => __('Añadir Nuevo', 'tinasxshower'),
        'add_new_item'          => __('Añadir Nuevo Servicio', 'tinasxshower'),
        'new_item'              => __('Nuevo Servicio', 'tinasxshower'),
        'edit_item'             => __('Editar Servicio', 'tinasxshower'),
        'view_item'             => __('Ver Servicio', 'tinasxshower'),
        'all_items'             => __('Todos los Servicios', 'tinasxshower'),
        'search_items'          => __('Buscar Servicios', 'tinasxshower'),
        'not_found'             => __('No se encontraron servicios.', 'tinasxshower'),
        'not_found_in_trash'    => __('No hay servicios en la papelera.', 'tinasxshower'),
        'featured_image'        => _x('Imagen del Servicio', 'Overrides the "Featured Image" phrase', 'tinasxshower'),
        'set_featured_image'    => _x('Establecer imagen del servicio', 'Overrides the "Set featured image" phrase', 'tinasxshower'),
        'remove_featured_image' => _x('Quitar imagen del servicio', 'Overrides the "Remove featured image" phrase', 'tinasxshower'),
        'use_featured_image'    => _x('Usar como imagen del servicio', 'Overrides the "Use as featured image" phrase', 'tinasxshower'),
        'archives'              => _x('Archivo de Servicios', 'The post type archive label used in nav menus', 'tinasxshower'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'servicio'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-admin-tools',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('servicio', $args);
}
add_action('init', 'tinasxshower_register_post_types');

/**
 * Register Custom Taxonomies
 */
function tinasxshower_register_taxonomies() {
    // Categoría de Galería
    $labels = array(
        'name'              => _x('Categorías de Galería', 'taxonomy general name', 'tinasxshower'),
        'singular_name'     => _x('Categoría de Galería', 'taxonomy singular name', 'tinasxshower'),
        'search_items'      => __('Buscar Categorías', 'tinasxshower'),
        'all_items'         => __('Todas las Categorías', 'tinasxshower'),
        'parent_item'       => __('Categoría Padre', 'tinasxshower'),
        'parent_item_colon' => __('Categoría Padre:', 'tinasxshower'),
        'edit_item'         => __('Editar Categoría', 'tinasxshower'),
        'update_item'       => __('Actualizar Categoría', 'tinasxshower'),
        'add_new_item'      => __('Añadir Nueva Categoría', 'tinasxshower'),
        'new_item_name'     => __('Nuevo Nombre de Categoría', 'tinasxshower'),
        'menu_name'         => __('Categorías de Galería', 'tinasxshower'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categoria-galeria'),
        'show_in_rest'      => true,
    );

    register_taxonomy('categoria-galeria', array('attachment'), $args);
}
add_action('init', 'tinasxshower_register_taxonomies');

/**
 * Add custom meta boxes for Servicios
 */
function tinasxshower_add_meta_boxes() {
    add_meta_box(
        'servicio_details',
        __('Detalles del Servicio', 'tinasxshower'),
        'tinasxshower_servicio_details_callback',
        'servicio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tinasxshower_add_meta_boxes');

/**
 * Meta box callback function
 */
function tinasxshower_servicio_details_callback($post) {
    // Add nonce for security
    wp_nonce_field('tinasxshower_save_meta_box_data', 'tinasxshower_meta_box_nonce');

    // Retrieve current values
    $icon = get_post_meta($post->ID, '_servicio_icon', true);
    $price = get_post_meta($post->ID, '_servicio_price', true);
    $duration = get_post_meta($post->ID, '_servicio_duration', true);
    $features = get_post_meta($post->ID, '_servicio_features', true);
    
    if (!is_array($features)) {
        $features = array('');
    }
    
    // Display the form
    ?>
    <p>
        <label for="servicio_icon"><?php _e('Icono (clase Font Awesome)', 'tinasxshower'); ?>:</label><br>
        <input type="text" id="servicio_icon" name="servicio_icon" value="<?php echo esc_attr($icon); ?>" class="widefat" placeholder="fa-shower">
        <small><?php _e('Ejemplo: fa-shower, fa-bath, etc.', 'tinasxshower'); ?></small>
    </p>
    <p>
        <label for="servicio_price"><?php _e('Precio', 'tinasxshower'); ?>:</label><br>
        <input type="text" id="servicio_price" name="servicio_price" value="<?php echo esc_attr($price); ?>" class="widefat" placeholder="$99.99">
    </p>
    <p>
        <label for="servicio_duration"><?php _e('Duración', 'tinasxshower'); ?>:</label><br>
        <input type="text" id="servicio_duration" name="servicio_duration" value="<?php echo esc_attr($duration); ?>" class="widefat" placeholder="2 horas">
    </p>
    <div class="servicio-features">
        <label><?php _e('Características (una por línea)', 'tinasxshower'); ?>:</label><br>
        <div id="feature-fields">
            <?php foreach ($features as $index => $feature) : ?>
                <div class="feature-field">
                    <input type="text" name="servicio_features[]" value="<?php echo esc_attr($feature); ?>" class="widefat">
                    <?php if ($index > 0) : ?>
                        <button type="button" class="button remove-feature"><?php _e('Eliminar', 'tinasxshower'); ?></button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button add-feature"><?php _e('Añadir Característica', 'tinasxshower'); ?></button>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.add-feature').on('click', function() {
                var field = '<div class="feature-field"><input type="text" name="servicio_features[]" value="" class="widefat"><button type="button" class="button remove-feature"><?php _e('Eliminar', 'tinasxshower'); ?></button></div>';
                $('#feature-fields').append(field);
            });
            
            $(document).on('click', '.remove-feature', function() {
                $(this).parent('.feature-field').remove();
            });
        });
    </script>
    <?php
}

/**
 * Save meta box data
 */
function tinasxshower_save_meta_box_data($post_id) {
    // Check if nonce is set
    if (!isset($_POST['tinasxshower_meta_box_nonce'])) {
        return;
    }

    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['tinasxshower_meta_box_nonce'], 'tinasxshower_save_meta_box_data')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions
    if (isset($_POST['post_type']) && 'servicio' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Save the data
    if (isset($_POST['servicio_icon'])) {
        update_post_meta($post_id, '_servicio_icon', sanitize_text_field($_POST['servicio_icon']));
    }
    
    if (isset($_POST['servicio_price'])) {
        update_post_meta($post_id, '_servicio_price', sanitize_text_field($_POST['servicio_price']));
    }
    
    if (isset($_POST['servicio_duration'])) {
        update_post_meta($post_id, '_servicio_duration', sanitize_text_field($_POST['servicio_duration']));
    }
    
    if (isset($_POST['servicio_features'])) {
        $features = array_map('sanitize_text_field', $_POST['servicio_features']);
        $features = array_filter($features); // Remove empty values
        update_post_meta($post_id, '_servicio_features', $features);
    }
}
add_action('save_post', 'tinasxshower_save_meta_box_data');