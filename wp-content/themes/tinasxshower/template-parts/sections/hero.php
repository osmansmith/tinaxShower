<?php
/**
 * Template part for displaying the hero section
 *
 * @package TinasXShower
 */

// Obtener las imágenes del slider desde las opciones del tema
$hero_slides = get_theme_mod('hero_slides', []);

// Si no hay slides configurados, usar valores predeterminados
if (empty($hero_slides)) {
    $hero_slides = [
        [
            'image' => get_template_directory_uri() . '/assets/images/top01.jpg',
            'title' => 'Transforma tu baño con nuestras duchas',
            'subtitle' => 'Soluciones elegantes y funcionales para tu hogar',
        ],
        [
            'image' => get_template_directory_uri() . '/assets/images/top02.jpg',
            'title' => 'Calidad y diseño en cada instalación',
            'subtitle' => 'Materiales premium y acabados perfectos',
        ],
        [
            'image' => get_template_directory_uri() . '/assets/images/top03.jpg',
            'title' => 'Servicio profesional garantizado',
            'subtitle' => 'Expertos en instalación y mantenimiento',
        ],
    ];
}
?>

<section id="hero" class="relative h-screen overflow-hidden">
    <div class="hero-slider relative h-full">
        <?php foreach ($hero_slides as $index => $slide) : ?>
            <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out <?php echo $index === 0 ? 'opacity-100' : 'opacity-0'; ?>" data-index="<?php echo $index; ?>">
                <div class="absolute inset-0 bg-black/50 z-10"></div>
                <?php if (!empty($slide['image'])) : ?>
                    <img src="<?php echo esc_url($slide['image']); ?>" alt="<?php echo esc_attr($slide['title'] ?? ''); ?>" class="absolute inset-0 w-full h-full object-cover">
                <?php endif; ?>
                
                <div class="absolute inset-0 z-20 flex items-center justify-center">
                    <div class="container mx-auto px-4 text-center text-white">
                        <?php if (!empty($slide['title'])) : ?>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 animate-slide-up">
                                <?php echo esc_html($slide['title']); ?>
                            </h1>
                        <?php endif; ?>
                        
                        <?php if (!empty($slide['subtitle'])) : ?>
                            <p class="text-xl md:text-2xl mb-8 animate-slide-up animation-delay-200">
                                <?php echo esc_html($slide['subtitle']); ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="flex justify-center space-x-4 animate-slide-up animation-delay-400">
                            <a href="#services" class="btn-primary scroll-to">
                                Ver Servicios
                            </a>
                            <a href="#contact" class="btn-outline text-white border-white hover:bg-white hover:text-secondary-800 scroll-to">
                                Contactar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <!-- Controles del slider -->
        <div class="absolute bottom-8 left-0 right-0 z-30 flex justify-center space-x-2">
            <?php foreach ($hero_slides as $index => $slide) : ?>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-colors slider-dot <?php echo $index === 0 ? 'active bg-white' : ''; ?>" data-index="<?php echo $index; ?>"></button>
            <?php endforeach; ?>
        </div>
        
        <!-- Botones de navegación -->
        <button class="absolute top-1/2 left-4 z-30 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 transition-colors p-2 rounded-full slider-prev">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button class="absolute top-1/2 right-4 z-30 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 transition-colors p-2 rounded-full slider-next">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    
    <!-- Flecha de desplazamiento -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-30 animate-bounce">
        <a href="#services" class="text-white scroll-to">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </a>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const prevBtn = document.querySelector('.slider-prev');
        const nextBtn = document.querySelector('.slider-next');
        let currentSlide = 0;
        let slideInterval;
        
        // Función para mostrar un slide específico
        function showSlide(index) {
            // Ocultar todos los slides
            slides.forEach(slide => {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
            });
            
            // Desactivar todos los dots
            dots.forEach(dot => {
                dot.classList.remove('active', 'bg-white');
                dot.classList.add('bg-white/50');
            });
            
            // Mostrar el slide actual
            slides[index].classList.remove('opacity-0');
            slides[index].classList.add('opacity-100');
            
            // Activar el dot actual
            dots[index].classList.remove('bg-white/50');
            dots[index].classList.add('active', 'bg-white');
            
            // Actualizar el índice actual
            currentSlide = index;
        }
        
        // Función para ir al siguiente slide
        function nextSlide() {
            let next = currentSlide + 1;
            if (next >= slides.length) {
                next = 0;
            }
            showSlide(next);
        }
        
        // Función para ir al slide anterior
        function prevSlide() {
            let prev = currentSlide - 1;
            if (prev < 0) {
                prev = slides.length - 1;
            }
            showSlide(prev);
        }
        
        // Iniciar el autoplay
        function startAutoplay() {
            slideInterval = setInterval(nextSlide, 5000);
        }
        
        // Detener el autoplay
        function stopAutoplay() {
            clearInterval(slideInterval);
        }
        
        // Event listeners para los dots
        dots.forEach(dot => {
            dot.addEventListener('click', function() {
                const slideIndex = parseInt(this.getAttribute('data-index'));
                showSlide(slideIndex);
                stopAutoplay();
                startAutoplay();
            });
        });
        
        // Event listeners para los botones de navegación
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                prevSlide();
                stopAutoplay();
                startAutoplay();
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                nextSlide();
                stopAutoplay();
                startAutoplay();
            });
        };
        
        // Iniciar el autoplay
        startAutoplay();
        
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