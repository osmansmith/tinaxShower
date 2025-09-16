<?php
/**
 * The header for our theme
 *
 * @package TinasXShower
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen bg-white">
    <header id="masthead" class="site-header fixed top-0 left-0 w-full z-50 transition-all duration-300">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) :
                    the_custom_logo();
                else :
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-2xl font-bold text-primary-600">
                    <?php bloginfo('name'); ?>
                </a>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="main-navigation hidden lg:flex items-center space-x-8">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'flex space-x-8',
                    'fallback_cb'    => false,
                ));
                ?>
                <!-- <div class="ml-8 flex space-x-4">
                    <a href="<?php echo esc_url(home_url('/contacto')); ?>" class="btn-primary">
                        Contactar
                    </a>
                </div> -->
            </nav>

            <button id="mobile-menu-toggle" class="lg:hidden flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="lg:hidden hidden bg-white shadow-lg absolute top-full left-0 w-full">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'mobile-menu',
                'container'      => false,
                'menu_class'     => 'py-4 px-6 space-y-4',
                'fallback_cb'    => false,
            ));
            ?>
            <div class="px-6 py-4">
                <a href="<?php echo esc_url(home_url('/contacto')); ?>" class="btn-primary block text-center">
                    Contactar
                </a>
            </div>
        </div>
    </header>