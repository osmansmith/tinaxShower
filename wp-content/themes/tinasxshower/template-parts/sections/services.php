<?php
/**
 * Template part for displaying the services section
 *
 * @package TinasXShower
 */

// Obtener los servicios desde el tipo de post personalizado
$services_args = array(
    'post_type' => 'servicio',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
);

$services_query = new WP_Query($services_args);

// Si no hay servicios, usar datos predeterminados
if (!$services_query->have_posts()) {
    $default_services = [
        [
            'icon' => 'shower',
            'title' => 'Instalación de Duchas',
            'description' => 'Instalación profesional de duchas con los más altos estándares de calidad.',
            'features' => ['Instalación rápida', 'Materiales de calidad', 'Garantía de 2 años', 'Servicio post-instalación'],
            'price' => '299',
            'duration' => '1-2 días',
            'image' => get_template_directory_uri() . '/assets/images/service-1.png',
        ],
        [
            'icon' => 'tool',
            'title' => 'Reparación de Duchas',
            'description' => 'Servicio de reparación para todo tipo de problemas en tu ducha.',
            'features' => ['Diagnóstico gratuito', 'Reparación rápida', 'Piezas originales', 'Garantía de servicio'],
            'price' => '149',
            'duration' => '2-4 horas',
            'image' => get_template_directory_uri() . '/assets/images/service-2.png',
        ],
        [
            'icon' => 'refresh-cw',
            'title' => 'Renovación de Baños',
            'description' => 'Renovamos tu baño completo con diseños modernos y funcionales.',
            'features' => ['Diseño personalizado', 'Materiales premium', 'Instalación profesional', 'Garantía extendida'],
            'price' => '999',
            'duration' => '5-7 días',
            'image' => get_template_directory_uri() . '/assets/images/service-3.png',
        ],
    ];
}
?>

<section id="services" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-800 mb-4">
                <?php echo get_theme_mod('services_title', 'Nuestros Servicios'); ?>
            </h2>
            <p class="text-lg text-secondary-600 max-w-3xl mx-auto">
                <?php echo get_theme_mod('services_subtitle', 'Ofrecemos soluciones profesionales para la instalación, reparación y renovación de duchas y baños.'); ?>
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
            if ($services_query->have_posts()) :
                while ($services_query->have_posts()) : $services_query->the_post();
                    // Obtener metadatos del servicio
                    $icon = get_post_meta(get_the_ID(), 'servicio_icon', true);
                    $features = get_post_meta(get_the_ID(), 'servicio_features', true);
                    $price = get_post_meta(get_the_ID(), 'servicio_price', true);
                    $duration = get_post_meta(get_the_ID(), 'servicio_duration', true);
                    
                    if (!is_array($features)) {
                        $features = explode('\n', $features);
                    }
            ?>
                <div class="service-card bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="aspect-w-16 aspect-h-9">
                            <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <?php if ($icon) : ?>
                            <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <?php 
                                    switch ($icon) {
                                        case 'shower':
                                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />';
                                            break;
                                        case 'tool':
                                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
                                            break;
                                        case 'refresh-cw':
                                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />';
                                            break;
                                        default:
                                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />';
                                    }
                                    ?>
                                </svg>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="text-xl font-bold text-secondary-800 mb-2"><?php the_title(); ?></h3>
                        <div class="text-secondary-600 mb-4"><?php the_excerpt(); ?></div>
                        
                        <?php if (!empty($features)) : ?>
                            <ul class="mb-6 space-y-2">
                                <?php foreach ($features as $feature) : ?>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <?php echo esc_html(trim($feature)); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        
                        <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
                            <?php if ($price) : ?>
                                <div>
                                    <span class="text-sm text-secondary-500">Desde</span>
                                    <p class="text-2xl font-bold text-primary-600"><?php echo esc_html($price); ?>€</p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($duration) : ?>
                                <div class="text-right">
                                    <span class="text-sm text-secondary-500">Duración</span>
                                    <p class="text-lg font-medium"><?php echo esc_html($duration); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="btn-primary w-full text-center mt-6">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else :
                // Mostrar servicios predeterminados
                foreach ($default_services as $service) :
            ?>
                <div class="service-card bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1">
                    <?php if (!empty($service['image'])) : ?>
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="<?php echo esc_url($service['image']); ?>" alt="<?php echo esc_attr($service['title']); ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <?php if (!empty($service['icon'])) : ?>
                            <div class="w-12 h-12 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <?php 
                                    switch ($service['icon']) {
                                        case 'shower':
                                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />';
                                            break;
                                        case 'tool':
                                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
                                            break;
                                        case 'refresh-cw':
                                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />';
                                            break;
                                        default:
                                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />';
                                    }
                                    ?>
                                </svg>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="text-xl font-bold text-secondary-800 mb-2"><?php echo esc_html($service['title']); ?></h3>
                        <div class="text-secondary-600 mb-4"><?php echo esc_html($service['description']); ?></div>
                        
                        <?php if (!empty($service['features'])) : ?>
                            <ul class="mb-6 space-y-2">
                                <?php foreach ($service['features'] as $feature) : ?>
                                    <li class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <?php echo esc_html($feature); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        
                        <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
                            <?php if (!empty($service['price'])) : ?>
                                <div>
                                    <span class="text-sm text-secondary-500">Desde</span>
                                    <p class="text-2xl font-bold text-primary-600"><?php echo esc_html($service['price']); ?>€</p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($service['duration'])) : ?>
                                <div class="text-right">
                                    <span class="text-sm text-secondary-500">Duración</span>
                                    <p class="text-lg font-medium"><?php echo esc_html($service['duration']); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <a href="#contact" class="btn-primary w-full text-center mt-6 scroll-to">
                            Solicitar Información
                        </a>
                    </div>
                </div>
            <?php 
                endforeach;
            endif; 
            ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll suave para los enlaces
        const scrollLinks = document.querySelectorAll('.scroll-to');
        scrollLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>