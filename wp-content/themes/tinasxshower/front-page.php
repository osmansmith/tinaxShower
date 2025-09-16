<?php
/**
 * The template for displaying the front page
 *
 * @package TinasXShower
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php get_template_part('template-parts/sections/hero'); ?>
    
    <?php get_template_part('template-parts/sections/services'); ?>
    
    <?php get_template_part('template-parts/sections/gallery'); ?>
    
    <?php get_template_part('template-parts/sections/contact'); ?>
</main><!-- #main -->

<?php
get_footer();