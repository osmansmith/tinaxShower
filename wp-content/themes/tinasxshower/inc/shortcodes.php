<?php
/**
 * Custom Shortcodes for TinaXShower Theme
 *
 * @package TinaXShower
 */

/**
 * Shortcode para mostrar servicios
 * Uso: [tinasxshower_services limit="3" columns="3"]
 */
function tinasxshower_services_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'limit' => 3,
            'columns' => 3,
        ),
        $atts,
        'tinasxshower_services'
    );
    
    $limit = intval($atts['limit']);
    $columns = intval($atts['columns']);
    
    // Validar columnas
    if ($columns < 1 || $columns > 4) {
        $columns = 3;
    }
    
    // Definir clase de columnas
    $column_class = 'md:grid-cols-' . $columns;
    
    // Consultar servicios
    $args = array(
        'post_type' => 'servicio',
        'posts_per_page' => $limit,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    $services_query = new WP_Query($args);
    
    ob_start();
    
    if ($services_query->have_posts()) :
        ?>
        <div class="services-grid grid grid-cols-1 <?php echo esc_attr($column_class); ?> gap-6">
            <?php while ($services_query->have_posts()) : $services_query->the_post(); 
                // Obtener metadatos
                $icon = get_post_meta(get_the_ID(), '_servicio_icon', true);
                $price = get_post_meta(get_the_ID(), '_servicio_price', true);
                $duration = get_post_meta(get_the_ID(), '_servicio_duration', true);
                $features = get_post_meta(get_the_ID(), '_servicio_features', true);
                
                if (!is_array($features)) {
                    $features = array();
                }
            ?>
                <div class="service-card bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="service-image relative">
                            <?php the_post_thumbnail('tinasxshower-service', array('class' => 'w-full h-48 object-cover')); ?>
                            <?php if (!empty($icon)) : ?>
                                <div class="service-icon absolute -bottom-5 right-5 w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center text-2xl shadow-md">
                                    <i class="fas <?php echo esc_attr($icon); ?>"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="service-content p-6">
                        <h3 class="text-xl font-bold mb-3"><?php the_title(); ?></h3>
                        <div class="service-excerpt text-gray-600 mb-4"><?php the_excerpt(); ?></div>
                        
                        <?php if (!empty($features)) : ?>
                            <ul class="service-features mb-4">
                                <?php foreach ($features as $feature) : ?>
                                    <li class="flex items-start mb-2">
                                        <i class="fas fa-check text-primary mr-2 mt-1"></i>
                                        <span><?php echo esc_html($feature); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        
                        <div class="service-meta flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                            <?php if (!empty($price)) : ?>
                                <div class="service-price text-primary font-bold"><?php echo esc_html($price); ?></div>
                            <?php endif; ?>
                            
                            <?php if (!empty($duration)) : ?>
                                <div class="service-duration text-gray-500">
                                    <i class="far fa-clock mr-1"></i> <?php echo esc_html($duration); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="btn-primary block text-center mt-4"><?php esc_html_e('Ver Detalles', 'tinasxshower'); ?></a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    else :
        ?>
        <p><?php esc_html_e('No se encontraron servicios.', 'tinasxshower'); ?></p>
        <?php
    endif;
    
    return ob_get_clean();
}
add_shortcode('tinasxshower_services', 'tinasxshower_services_shortcode');

/**
 * Shortcode para mostrar la galería
 * Uso: [tinasxshower_gallery limit="8" columns="4" category=""]
 */
function tinasxshower_gallery_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'limit' => 8,
            'columns' => 4,
            'category' => '',
        ),
        $atts,
        'tinasxshower_gallery'
    );
    
    $limit = intval($atts['limit']);
    $columns = intval($atts['columns']);
    $category = sanitize_text_field($atts['category']);
    
    // Validar columnas
    if ($columns < 1 || $columns > 6) {
        $columns = 4;
    }
    
    // Definir clase de columnas
    $column_class = 'md:grid-cols-' . $columns;
    
    // Consultar imágenes
    $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'posts_per_page' => $limit,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    // Filtrar por categoría si se especifica
    if (!empty($category)) {
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
    
    ob_start();
    
    if ($gallery_query->have_posts()) :
        // Obtener todas las categorías para los filtros
        $categories = get_terms(array(
            'taxonomy' => 'categoria-galeria',
            'hide_empty' => true,
        ));
        
        // Mostrar filtros si hay categorías
        if (!empty($categories) && !is_wp_error($categories)) :
            ?>
            <div class="gallery-filters flex flex-wrap justify-center mb-8">
                <button class="filter-btn active mx-2 mb-2 px-4 py-2 rounded-full bg-primary text-white hover:bg-primary-dark transition-colors" data-filter="*"><?php esc_html_e('Todos', 'tinasxshower'); ?></button>
                <?php foreach ($categories as $cat) : ?>
                    <button class="filter-btn mx-2 mb-2 px-4 py-2 rounded-full bg-gray-200 text-gray-800 hover:bg-gray-300 transition-colors" data-filter=".<?php echo esc_attr('category-' . $cat->term_id); ?>"><?php echo esc_html($cat->name); ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="gallery-grid grid grid-cols-2 <?php echo esc_attr($column_class); ?> gap-4">
            <?php while ($gallery_query->have_posts()) : $gallery_query->the_post(); 
                // Obtener categorías de la imagen
                $image_categories = get_the_terms(get_the_ID(), 'categoria-galeria');
                $category_classes = '';
                
                if (!empty($image_categories) && !is_wp_error($image_categories)) {
                    foreach ($image_categories as $cat) {
                        $category_classes .= ' category-' . $cat->term_id;
                    }
                }
                
                // Obtener URL de la imagen
                $image_full = wp_get_attachment_image_src(get_the_ID(), 'full');
                $image_thumb = wp_get_attachment_image_src(get_the_ID(), 'tinasxshower-gallery');
                
                if ($image_full && $image_thumb) :
            ?>
                <div class="gallery-item<?php echo esc_attr($category_classes); ?>">
                    <a href="<?php echo esc_url($image_full[0]); ?>" data-lightbox="gallery" data-title="<?php echo esc_attr(get_the_title()); ?>" class="block overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <img src="<?php echo esc_url($image_thumb[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-64 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="gallery-overlay absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <i class="fas fa-search-plus text-white text-3xl"></i>
                        </div>
                    </a>
                </div>
            <?php 
                endif;
            endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    else :
        ?>
        <p><?php esc_html_e('No se encontraron imágenes en la galería.', 'tinasxshower'); ?></p>
        <?php
    endif;
    
    return ob_get_clean();
}
add_shortcode('tinasxshower_gallery', 'tinasxshower_gallery_shortcode');

/**
 * Shortcode para mostrar el formulario de contacto
 * Uso: [tinasxshower_contact_form]
 */
function tinasxshower_contact_form_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'title' => __('Contáctanos', 'tinasxshower'),
            'show_services' => 'yes',
        ),
        $atts,
        'tinasxshower_contact_form'
    );
    
    $title = sanitize_text_field($atts['title']);
    $show_services = ($atts['show_services'] === 'yes');
    
    // Obtener servicios si se requiere
    $services = array();
    if ($show_services) {
        $services_query = new WP_Query(array(
            'post_type' => 'servicio',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ));
        
        if ($services_query->have_posts()) {
            while ($services_query->have_posts()) {
                $services_query->the_post();
                $services[get_the_ID()] = get_the_title();
            }
            wp_reset_postdata();
        }
    }
    
    ob_start();
    ?>
    <div class="contact-form-container bg-white rounded-lg shadow-md p-6">
        <?php if (!empty($title)) : ?>
            <h3 class="text-2xl font-bold mb-6"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>
        
        <form id="tinasxshower-contact-form" class="contact-form">
            <div class="form-group mb-4">
                <label for="contact-name" class="block text-gray-700 mb-2"><?php esc_html_e('Nombre *', 'tinasxshower'); ?></label>
                <input type="text" id="contact-name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
            </div>
            
            <div class="form-group mb-4">
                <label for="contact-email" class="block text-gray-700 mb-2"><?php esc_html_e('Email *', 'tinasxshower'); ?></label>
                <input type="email" id="contact-email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
            </div>
            
            <div class="form-group mb-4">
                <label for="contact-phone" class="block text-gray-700 mb-2"><?php esc_html_e('Teléfono *', 'tinasxshower'); ?></label>
                <input type="tel" id="contact-phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
            </div>
            
            <?php if ($show_services && !empty($services)) : ?>
                <div class="form-group mb-4">
                    <label for="contact-service" class="block text-gray-700 mb-2"><?php esc_html_e('Servicio de Interés', 'tinasxshower'); ?></label>
                    <select id="contact-service" name="service" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value=""><?php esc_html_e('Selecciona un servicio', 'tinasxshower'); ?></option>
                        <?php foreach ($services as $id => $title) : ?>
                            <option value="<?php echo esc_attr($title); ?>"><?php echo esc_html($title); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            
            <div class="form-group mb-4">
                <label for="contact-message" class="block text-gray-700 mb-2"><?php esc_html_e('Mensaje *', 'tinasxshower'); ?></label>
                <textarea id="contact-message" name="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required></textarea>
            </div>
            
            <?php wp_nonce_field('tinasxshower-ajax-nonce', 'contact_nonce'); ?>
            
            <div class="form-submit">
                <button type="submit" class="btn-primary w-full"><?php esc_html_e('Enviar Mensaje', 'tinasxshower'); ?></button>
            </div>
            
            <div class="form-response mt-4 hidden"></div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('tinasxshower_contact_form', 'tinasxshower_contact_form_shortcode');