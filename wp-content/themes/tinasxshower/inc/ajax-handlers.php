<?php
/**
 * AJAX Handlers for TinaXShower Theme
 *
 * @package TinaXShower
 */

/**
 * Process contact form submission via AJAX
 */
function tinasxshower_process_contact_form() {
    // Check nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tinasxshower-nonce')) {
        wp_send_json_error(array('message' => __('Error de seguridad. Por favor, recarga la página.', 'tinasxshower')));
    }
    
    // Get form data
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $service = isset($_POST['service']) ? sanitize_text_field($_POST['service']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    
    // Validate form data
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        wp_send_json_error(array('message' => __('Por favor, completa todos los campos requeridos.', 'tinasxshower')));
    }
    
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Por favor, introduce un email válido.', 'tinasxshower')));
    }
    
    // Get admin email
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');
    
    // Set email headers
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $site_name . ' <' . $admin_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Set email subject
    $subject = sprintf(__('Nuevo mensaje de contacto de %s', 'tinasxshower'), $site_name);
    
    // Build email content
    $email_content = '<p><strong>' . __('Nombre', 'tinasxshower') . ':</strong> ' . $name . '</p>';
    $email_content .= '<p><strong>' . __('Email', 'tinasxshower') . ':</strong> ' . $email . '</p>';
    $email_content .= '<p><strong>' . __('Teléfono', 'tinasxshower') . ':</strong> ' . $phone . '</p>';
    
    if (!empty($service)) {
        $email_content .= '<p><strong>' . __('Servicio', 'tinasxshower') . ':</strong> ' . $service . '</p>';
    }
    
    $email_content .= '<p><strong>' . __('Mensaje', 'tinasxshower') . ':</strong></p>';
    $email_content .= '<p>' . nl2br($message) . '</p>';
    
    // Send email
    $sent = wp_mail($admin_email, $subject, $email_content, $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => __('¡Gracias! Tu mensaje ha sido enviado correctamente.', 'tinasxshower')));
    } else {
        wp_send_json_error(array('message' => __('Lo sentimos, ha ocurrido un error al enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.', 'tinasxshower')));
    }
}
add_action('wp_ajax_tinasxshower_contact_form', 'tinasxshower_process_contact_form');
add_action('wp_ajax_nopriv_tinasxshower_contact_form', 'tinasxshower_process_contact_form');

/**
 * Load more gallery images via AJAX
 */
function tinasxshower_load_more_gallery() {
    // Check nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tinasxshower-nonce')) {
        wp_send_json_error(array('message' => __('Error de seguridad.', 'tinasxshower')));
    }
    
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 8;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    
    // Consultar imágenes
    $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    // Filtrar por categoría si se especifica
    if (!empty($category) && $category !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categoria-galeria',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    } else {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categoria-galeria',
                'operator' => 'EXISTS',
            ),
        );
    }
    
    $gallery_query = new WP_Query($args);
    $items = array();
    
    if ($gallery_query->have_posts()) {
        while ($gallery_query->have_posts()) {
            $gallery_query->the_post();
            
            // Obtener categorías de la imagen
            $image_categories = get_the_terms(get_the_ID(), 'categoria-galeria');
            $category_classes = '';
            $category_names = array();
            
            if (!empty($image_categories) && !is_wp_error($image_categories)) {
                foreach ($image_categories as $cat) {
                    $category_classes .= ' category-' . $cat->term_id;
                    $category_names[] = $cat->name;
                }
            }
            
            // Obtener URL de la imagen
            $image_full = wp_get_attachment_image_src(get_the_ID(), 'full');
            $image_thumb = wp_get_attachment_image_src(get_the_ID(), 'tinasxshower-gallery');
            
            if ($image_full && $image_thumb) {
                $items[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'full_url' => $image_full[0],
                    'thumb_url' => $image_thumb[0],
                    'category_classes' => $category_classes,
                    'category_names' => $category_names,
                );
            }
        }
        wp_reset_postdata();
    }
    
    $response = array(
        'items' => $items,
        'has_more' => ($gallery_query->max_num_pages > $page),
    );
    
    wp_send_json_success($response);
}
add_action('wp_ajax_tinasxshower_load_more_gallery', 'tinasxshower_load_more_gallery');
add_action('wp_ajax_nopriv_tinasxshower_load_more_gallery', 'tinasxshower_load_more_gallery');