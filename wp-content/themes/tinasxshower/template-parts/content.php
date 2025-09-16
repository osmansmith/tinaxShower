<?php
/**
 * Template part for displaying posts
 *
 * @package TinasXShower
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card overflow-hidden bg-white rounded-lg shadow-md transition-transform hover:shadow-lg hover:-translate-y-1'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="aspect-w-16 aspect-h-9">
            <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover']); ?>
        </div>
    <?php endif; ?>
    
    <div class="p-6">
        <header class="entry-header mb-4">
            <?php
            if (is_singular()) :
                the_title('<h1 class="entry-title text-2xl font-bold text-secondary-800">', '</h1>');
            else :
                the_title('<h2 class="entry-title text-xl font-bold text-secondary-800"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;

            if ('post' === get_post_type()) :
                ?>
                <div class="entry-meta text-sm text-secondary-500 mt-2">
                    <?php
                    tinasxshower_posted_on();
                    tinasxshower_posted_by();
                    ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->

        <div class="entry-content prose max-w-none">
            <?php
            if (is_singular()) :
                the_content(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'tinasxshower'),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        wp_kses_post(get_the_title())
                    )
                );

                wp_link_pages(
                    array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'tinasxshower'),
                        'after'  => '</div>',
                    )
                );
            else :
                the_excerpt();
                ?>
                <a href="<?php echo esc_url(get_permalink()); ?>" class="btn-primary inline-block mt-4">
                    <?php esc_html_e('Leer más', 'tinasxshower'); ?>
                </a>
                <?php
            endif;
            ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer mt-4 pt-4 border-t border-gray-200 text-sm text-secondary-500">
            <?php tinasxshower_entry_footer(); ?>
        </footer><!-- .entry-footer -->
    </div>
</article><!-- #post-<?php the_ID(); ?> -->