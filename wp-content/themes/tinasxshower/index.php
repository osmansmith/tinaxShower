<?php
/**
 * The main template file
 *
 * @package TinasXShower
 */

get_header();
?>

<main id="primary" class="site-main pt-24">
    <div class="container mx-auto px-4 py-12">
        <?php
        if (have_posts()) :

            if (is_home() && !is_front_page()) :
                ?>
                <header class="mb-12">
                    <h1 class="text-4xl font-bold text-secondary-800"><?php single_post_title(); ?></h1>
                </header>
                <?php
            endif;

            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                /* Start the Loop */
                while (have_posts()) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part('template-parts/content', get_post_type());

                endwhile;
                ?>
            </div>
            <?php

            the_posts_navigation(array(
                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Anterior:', 'tinasxshower') . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . esc_html__('Siguiente:', 'tinasxshower') . '</span> <span class="nav-title">%title</span>',
                'class' => 'flex justify-between mt-12',
            ));

        else :

            get_template_part('template-parts/content', 'none');

        endif;
        ?>
    </div>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();