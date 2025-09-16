<?php
/**
 * Template part for displaying the gallery section
 *
 * @package TinasXShower
 */

// Obtener las imágenes de la galería
$gallery_args = array(
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => 'galeria',
            'operator' => 'IN',
        ),
    ),
);

$gallery_query = new WP_Query($gallery_args);

// Si no hay imágenes, usar datos predeterminados
if (!$gallery_query->have_posts()) {
    $default_gallery = [
        [
            'image' => get_template_directory_uri() . '/assets/images/gallery-1.jpg',
            'title' => 'Ducha Moderna',
            'category' => 'instalacion',
        ],
        [
            'image' => get_template_directory_uri() . '/assets/images/gallery-2.jpg',
            'title' => 'Baño Completo',
            'category' => 'renovacion',
        ],
        [
            'image' => get_template_directory_uri() . '/assets/images/gallery-3.jpg',
            'title' => 'Ducha de Cristal',
            'category' => 'instalacion',
        ],
        [
            'image' => get_template_directory_uri() . '/assets/images/gallery-4.jpg',
            'title' => 'Reparación de Grifo',
            'category' => 'reparacion',
        ],
        [
            'image' => get_template_directory_uri() . '/assets/images/gallery-5.jpg',
            'title' => 'Baño Minimalista',
            'category' => 'renovacion',
        ],
        [
            'image' => get_template_directory_uri() . '/assets/images/gallery-6.jpg',
            'title' => 'Ducha con Mampara',
            'category' => 'instalacion',
        ],
    ];
    
    $categories = ['todos', 'instalacion', 'reparacion', 'renovacion'];
} else {
    // Obtener categorías de las imágenes
    $categories = ['todos'];
    $gallery_items = [];
    
    foreach ($gallery_query->posts as $post) {
        $image_categories = get_the_terms($post->ID, 'category');
        $image_cats = [];
        
        if ($image_categories && !is_wp_error($image_categories)) {
            foreach ($image_categories as $cat) {
                $image_cats[] = $cat->slug;
                if (!in_array($cat->slug, $categories)) {
                    $categories[] = $cat->slug;
                }
            }
        }
        
        $gallery_items[] = [
            'image' => wp_get_attachment_image_url($post->ID, 'large'),
            'title' => get_the_title($post->ID),
            'category' => implode(' ', $image_cats),
        ];
    }
}
?>

<section id="gallery" class="py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-800 mb-4">
                <?php echo get_theme_mod('gallery_title', 'Nuestra Galería'); ?>
            </h2>
            <p class="text-lg text-secondary-600 max-w-3xl mx-auto">
                <?php echo get_theme_mod('gallery_subtitle', 'Explora nuestros trabajos realizados y descubre la calidad de nuestros servicios.'); ?>
            </p>
        </div>
        
        <!-- Filtros de la galería -->
        <div class="flex flex-wrap justify-center mb-12 gap-2">
            <?php foreach ($categories as $category) : ?>
                <button class="gallery-filter px-6 py-2 rounded-full border border-gray-300 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-colors <?php echo $category === 'todos' ? 'active bg-primary-600 text-white border-primary-600' : ''; ?>" data-filter="<?php echo esc_attr($category); ?>">
                    <?php echo esc_html(ucfirst($category)); ?>
                </button>
            <?php endforeach; ?>
        </div>
        
        <!-- Galería de imágenes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php 
            if (isset($gallery_items) && !empty($gallery_items)) :
                foreach ($gallery_items as $index => $item) :
            ?>
                <div class="gallery-item overflow-hidden rounded-lg shadow-md cursor-pointer transition-transform hover:shadow-lg hover:-translate-y-1" data-category="<?php echo esc_attr($item['category']); ?>" data-index="<?php echo $index; ?>">
                    <div class="aspect-w-4 aspect-h-3 relative">
                        <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                            <div class="text-white text-center p-4">
                                <h3 class="text-xl font-bold"><?php echo esc_html($item['title']); ?></h3>
                                <p class="mt-2"><?php echo esc_html(ucfirst(str_replace('-', ' ', $item['category']))); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach;
            else :
                foreach ($default_gallery as $index => $item) :
            ?>
                <div class="gallery-item overflow-hidden rounded-lg shadow-md cursor-pointer transition-transform hover:shadow-lg hover:-translate-y-1" data-category="<?php echo esc_attr($item['category']); ?>" data-index="<?php echo $index; ?>">
                    <div class="aspect-w-4 aspect-h-3 relative">
                        <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                            <div class="text-white text-center p-4">
                                <h3 class="text-xl font-bold"><?php echo esc_html($item['title']); ?></h3>
                                <p class="mt-2"><?php echo esc_html(ucfirst(str_replace('-', ' ', $item['category']))); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach;
            endif; 
            ?>
        </div>
    </div>
    
    <!-- Lightbox -->
    <div id="gallery-lightbox" class="fixed inset-0 z-50 bg-black bg-opacity-90 hidden flex items-center justify-center">
        <div class="lightbox-content relative max-w-4xl w-full">
            <div class="lightbox-image-container">
                <img id="lightbox-image" src="" alt="" class="w-full h-auto">
            </div>
            <div class="lightbox-caption bg-black bg-opacity-70 text-white p-4">
                <h3 id="lightbox-title" class="text-xl font-bold"></h3>
                <p id="lightbox-category" class="mt-1"></p>
            </div>
            <button id="lightbox-prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 transition-colors p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button id="lightbox-next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 transition-colors p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <button id="lightbox-close" class="absolute top-4 right-4 bg-white/20 hover:bg-white/40 transition-colors p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtrado de la galería
        const filterButtons = document.querySelectorAll('.gallery-filter');
        const galleryItems = document.querySelectorAll('.gallery-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Quitar clase activa de todos los botones
                filterButtons.forEach(btn => btn.classList.remove('active', 'bg-primary-600', 'text-white', 'border-primary-600'));
                
                // Añadir clase activa al botón clickeado
                this.classList.add('active', 'bg-primary-600', 'text-white', 'border-primary-600');
                
                const filter = this.getAttribute('data-filter');
                
                // Filtrar elementos
                galleryItems.forEach(item => {
                    if (filter === 'todos' || item.getAttribute('data-category').includes(filter)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Lightbox
        const lightbox = document.getElementById('gallery-lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxTitle = document.getElementById('lightbox-title');
        const lightboxCategory = document.getElementById('lightbox-category');
        const lightboxClose = document.getElementById('lightbox-close');
        const lightboxPrev = document.getElementById('lightbox-prev');
        const lightboxNext = document.getElementById('lightbox-next');
        
        let currentIndex = 0;
        let galleryData = [];
        
        // Recopilar datos de la galería
        galleryItems.forEach(item => {
            const img = item.querySelector('img');
            const title = item.querySelector('h3');
            const category = item.querySelector('p');
            
            galleryData.push({
                src: img.src,
                title: title ? title.textContent : '',
                category: category ? category.textContent : '',
            });
        });
        
        // Abrir lightbox
        galleryItems.forEach((item, index) => {
            item.addEventListener('click', function() {
                currentIndex = parseInt(this.getAttribute('data-index'));
                openLightbox(currentIndex);
            });
        });
        
        // Cerrar lightbox
        lightboxClose.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
        
        // Navegación del lightbox
        lightboxPrev.addEventListener('click', function() {
            navigateLightbox('prev');
        });
        
        lightboxNext.addEventListener('click', function() {
            navigateLightbox('next');
        });
        
        // Teclas de navegación
        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('hidden')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    navigateLightbox('prev');
                } else if (e.key === 'ArrowRight') {
                    navigateLightbox('next');
                }
            }
        });
        
        // Funciones del lightbox
        function openLightbox(index) {
            const item = galleryData[index];
            
            lightboxImage.src = item.src;
            lightboxTitle.textContent = item.title;
            lightboxCategory.textContent = item.category;
            
            lightbox.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        function closeLightbox() {
            lightbox.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        function navigateLightbox(direction) {
            if (direction === 'prev') {
                currentIndex = (currentIndex - 1 + galleryData.length) % galleryData.length;
            } else {
                currentIndex = (currentIndex + 1) % galleryData.length;
            }
            
            openLightbox(currentIndex);
        }
    });
</script>