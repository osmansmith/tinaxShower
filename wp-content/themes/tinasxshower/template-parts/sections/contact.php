<?php
/**
 * Template part for displaying the contact section
 *
 * @package TinasXShower
 */

// Obtener los servicios para el select
$services_args = array(
    'post_type' => 'servicio',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
);

$services_query = new WP_Query($services_args);

// Si no hay servicios, usar datos predeterminados
if (!$services_query->have_posts()) {
    $default_services = [
        'Instalación de Duchas',
        'Reparación de Duchas',
        'Renovación de Baños',
        'Mantenimiento',
        'Consultoría',
    ];
}
?>

<section id="contact" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-800 mb-4">
                <?php echo get_theme_mod('contact_title', 'Contacta con Nosotros'); ?>
            </h2>
            <p class="text-lg text-secondary-600 max-w-3xl mx-auto">
                <?php echo get_theme_mod('contact_subtitle', 'Estamos aquí para ayudarte. Envíanos un mensaje y te responderemos lo antes posible.'); ?>
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Formulario de contacto -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-bold text-secondary-800 mb-6">Envíanos un mensaje</h3>
                
                <form id="contact-form" class="space-y-6" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                    <input type="hidden" name="action" value="contact_form_submit">
                    <?php wp_nonce_field('contact_form_nonce', 'contact_nonce'); ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-secondary-700 mb-1">Nombre *</label>
                            <input type="text" id="name" name="name" class="input w-full" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-secondary-700 mb-1">Email *</label>
                            <input type="email" id="email" name="email" class="input w-full" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-secondary-700 mb-1">Teléfono</label>
                            <input type="tel" id="phone" name="phone" class="input w-full">
                        </div>
                        <div>
                            <label for="service" class="block text-sm font-medium text-secondary-700 mb-1">Servicio de interés</label>
                            <select id="service" name="service" class="input w-full">
                                <option value="">Selecciona un servicio</option>
                                <?php 
                                if ($services_query->have_posts()) :
                                    while ($services_query->have_posts()) : $services_query->the_post();
                                        echo '<option value="' . esc_attr(get_the_title()) . '">' . esc_html(get_the_title()) . '</option>';
                                    endwhile;
                                    wp_reset_postdata();
                                else :
                                    foreach ($default_services as $service) :
                                        echo '<option value="' . esc_attr($service) . '">' . esc_html($service) . '</option>';
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-secondary-700 mb-1">Mensaje *</label>
                        <textarea id="message" name="message" rows="5" class="input w-full" required></textarea>
                    </div>
                    
                    <div class="flex items-start">
                        <input type="checkbox" id="privacy" name="privacy" class="mt-1" required>
                        <label for="privacy" class="ml-2 text-sm text-secondary-600">
                            He leído y acepto la <a href="<?php echo esc_url(home_url('/politica-de-privacidad')); ?>" class="text-primary-600 hover:text-primary-800">Política de Privacidad</a> *
                        </label>
                    </div>
                    
                    <div id="form-response" class="hidden"></div>
                    
                    <div>
                        <button type="submit" class="btn-primary w-full" id="submit-button">
                            Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Información de contacto -->
            <div>
                <div class="bg-secondary-800 text-white rounded-lg shadow-md p-8 mb-8">
                    <h3 class="text-2xl font-bold mb-6">Información de Contacto</h3>
                    
                    <ul class="space-y-6">
                        <?php if (get_theme_mod('contact_phone')) : ?>
                            <li class="flex items-start">
                                <div class="bg-primary-600 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold mb-1">Teléfono</h4>
                                    <p><?php echo esc_html(get_theme_mod('contact_phone')); ?></p>
                                </div>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('contact_whatsapp')) : ?>
                            <li class="flex items-start">
                                <div class="bg-primary-600 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold mb-1">WhatsApp</h4>
                                    <p><?php echo esc_html(get_theme_mod('contact_whatsapp')); ?></p>
                                </div>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('contact_email')) : ?>
                            <li class="flex items-start">
                                <div class="bg-primary-600 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold mb-1">Email</h4>
                                    <p><?php echo esc_html(get_theme_mod('contact_email')); ?></p>
                                </div>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('contact_address')) : ?>
                            <li class="flex items-start">
                                <div class="bg-primary-600 rounded-full p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold mb-1">Dirección</h4>
                                    <p><?php echo esc_html(get_theme_mod('contact_address')); ?></p>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <?php if (get_theme_mod('contact_map_embed')) : ?>
                    <div class="rounded-lg shadow-md overflow-hidden h-80">
                        <?php echo get_theme_mod('contact_map_embed'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contact-form');
        const formResponse = document.getElementById('form-response');
        const submitButton = document.getElementById('submit-button');
        
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validar el formulario
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const message = document.getElementById('message').value;
                const privacy = document.getElementById('privacy').checked;
                
                let hasErrors = false;
                let errors = [];
                
                if (!name) {
                    errors.push('El nombre es obligatorio');
                    hasErrors = true;
                }
                
                if (!email) {
                    errors.push('El email es obligatorio');
                    hasErrors = true;
                } else if (!isValidEmail(email)) {
                    errors.push('El email no es válido');
                    hasErrors = true;
                }
                
                if (!message) {
                    errors.push('El mensaje es obligatorio');
                    hasErrors = true;
                }
                
                if (!privacy) {
                    errors.push('Debes aceptar la política de privacidad');
                    hasErrors = true;
                }
                
                if (hasErrors) {
                    showFormResponse('error', 'Por favor, corrige los siguientes errores:<br>' + errors.join('<br>'));
                    return;
                }
                
                // Deshabilitar el botón de envío
                submitButton.disabled = true;
                submitButton.textContent = 'Enviando...';
                
                // Enviar el formulario mediante AJAX
                const formData = new FormData(contactForm);
                
                fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showFormResponse('success', data.data.message);
                        contactForm.reset();
                    } else {
                        showFormResponse('error', data.data.message || 'Ha ocurrido un error al enviar el formulario. Por favor, inténtalo de nuevo.');
                    }
                })
                .catch(error => {
                    showFormResponse('error', 'Ha ocurrido un error al enviar el formulario. Por favor, inténtalo de nuevo.');
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Habilitar el botón de envío
                    submitButton.disabled = false;
                    submitButton.textContent = 'Enviar Mensaje';
                });
            });
        }
        
        // Función para validar email
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        // Función para mostrar respuesta del formulario
        function showFormResponse(type, message) {
            formResponse.innerHTML = message;
            formResponse.classList.remove('hidden', 'bg-green-100', 'text-green-800', 'bg-red-100', 'text-red-800');
            
            if (type === 'success') {
                formResponse.classList.add('bg-green-100', 'text-green-800', 'p-4', 'rounded-md', 'mb-6');
            } else {
                formResponse.classList.add('bg-red-100', 'text-red-800', 'p-4', 'rounded-md', 'mb-6');
            }
            
            // Scroll to the response
            formResponse.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });
</script>