<?php
/**
 * Custom template tags for this theme
 *
 * @package TinasXShower
 */

if (!function_exists('tinasxshower_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function tinasxshower_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Publicado el %s', 'post date', 'tinasxshower'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if ( ! function_exists( 'tinasxshower_display_hero_slider' ) ) :
	/**
	 * Displays the hero slider from customizer settings
	 */
	function tinasxshower_display_hero_slider() {
		$slides = array();
		
		for ($i = 1; $i <= 3; $i++) {
			$image = get_theme_mod('hero_slide' . $i . '_image');
			$title = get_theme_mod('hero_slide' . $i . '_title');
			$subtitle = get_theme_mod('hero_slide' . $i . '_subtitle');
			$button_text = get_theme_mod('hero_slide' . $i . '_button_text');
			$button_url = get_theme_mod('hero_slide' . $i . '_button_url');
			
			if ($image) {
				$slides[] = array(
					'image' => $image,
					'title' => $title,
					'subtitle' => $subtitle,
					'button_text' => $button_text,
					'button_url' => $button_url
				);
			}
		}
		
		if (empty($slides)) {
			return;
		}
		?>
		<div class="hero-slider swiper-container">
			<div class="swiper-wrapper">
				<?php foreach ($slides as $slide) : ?>
				<div class="swiper-slide" style="background-image: url('<?php echo esc_url($slide['image']); ?>')">
					<div class="slide-content">
						<?php if ($slide['title']) : ?>
						<h2><?php echo esc_html($slide['title']); ?></h2>
						<?php endif; ?>
						
						<?php if ($slide['subtitle']) : ?>
						<p><?php echo esc_html($slide['subtitle']); ?></p>
						<?php endif; ?>
						
						<?php if ($slide['button_text'] && $slide['button_url']) : ?>
						<a href="<?php echo esc_url($slide['button_url']); ?>" class="btn"><?php echo esc_html($slide['button_text']); ?></a>
						<?php endif; ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="swiper-pagination"></div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'tinasxshower_display_social_links' ) ) :
	/**
	 * Displays social media links from customizer settings
	 */
	function tinasxshower_display_social_links() {
		$facebook = get_theme_mod('social_facebook');
		$instagram = get_theme_mod('social_instagram');
		$twitter = get_theme_mod('social_twitter');
		$youtube = get_theme_mod('social_youtube');
		$tiktok = get_theme_mod('social_tiktok');
		
		if (!$facebook && !$instagram && !$twitter && !$youtube && !$tiktok) {
			return;
		}
		?>
		<div class="social-links">
			<?php if ($facebook) : ?>
			<a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
				<i class="fab fa-facebook-f"></i>
			</a>
			<?php endif; ?>
			
			<?php if ($instagram) : ?>
			<a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
				<i class="fab fa-instagram"></i>
			</a>
			<?php endif; ?>
			
			<?php if ($twitter) : ?>
			<a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
				<i class="fab fa-twitter"></i>
			</a>
			<?php endif; ?>
			
			<?php if ($youtube) : ?>
			<a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
				<i class="fab fa-youtube"></i>
			</a>
			<?php endif; ?>
			
			<?php if ($tiktok) : ?>
			<a href="<?php echo esc_url($tiktok); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
				<i class="fab fa-tiktok"></i>
			</a>
			<?php endif; ?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'tinasxshower_display_contact_info' ) ) :
	/**
	 * Displays contact information from customizer settings
	 */
	function tinasxshower_display_contact_info() {
		$phone = get_theme_mod('contact_phone');
		$whatsapp = get_theme_mod('contact_whatsapp');
		$email = get_theme_mod('contact_email');
		$address = get_theme_mod('contact_address');
		
		if (!$phone && !$whatsapp && !$email && !$address) {
			return;
		}
		?>
		<div class="contact-info">
			<?php if ($phone) : ?>
			<div class="contact-item">
				<i class="fas fa-phone"></i>
				<a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
					<?php echo esc_html($phone); ?>
				</a>
			</div>
			<?php endif; ?>
			
			<?php if ($whatsapp) : ?>
			<div class="contact-item">
				<i class="fab fa-whatsapp"></i>
				<a href="https://wa.me/<?php echo esc_attr(tinasxshower_format_whatsapp_number($whatsapp)); ?>" target="_blank" rel="noopener noreferrer">
					<?php echo esc_html($whatsapp); ?>
				</a>
			</div>
			<?php endif; ?>
			
			<?php if ($email) : ?>
			<div class="contact-item">
				<i class="fas fa-envelope"></i>
				<a href="mailto:<?php echo esc_attr($email); ?>">
					<?php echo esc_html($email); ?>
				</a>
			</div>
			<?php endif; ?>
			
			<?php if ($address) : ?>
			<div class="contact-item">
				<i class="fas fa-map-marker-alt"></i>
				<span><?php echo esc_html($address); ?></span>
			</div>
			<?php endif; ?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'tinasxshower_display_map' ) ) :
	/**
	 * Displays Google Maps embed from customizer settings
	 */
	function tinasxshower_display_map() {
		$map_embed = get_theme_mod('contact_map_embed');
		
		if (!$map_embed) {
			return;
		}
		?>
		<div class="map-container">
			<?php echo wp_kses($map_embed, array(
				'iframe' => array(
					'src' => array(),
					'width' => array(),
					'height' => array(),
					'frameborder' => array(),
					'style' => array(),
					'allowfullscreen' => array(),
					'aria-hidden' => array(),
					'tabindex' => array(),
				),
			)); ?>
		</div>
		<?php
	}
endif;

if (!function_exists('tinasxshower_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function tinasxshower_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('por %s', 'post author', 'tinasxshower'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('tinasxshower_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function tinasxshower_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'tinasxshower'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Publicado en %1$s', 'tinasxshower') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'tinasxshower'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Etiquetado %1$s', 'tinasxshower') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Deja un comentario<span class="screen-reader-text"> en %s</span>', 'tinasxshower'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Editar<span class="screen-reader-text">%s</span>', 'tinasxshower'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('tinasxshower_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function tinasxshower_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <div class="post-thumbnail mb-6">
                <?php the_post_thumbnail('large', ['class' => 'rounded-lg w-full h-auto']); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail block mb-4" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'medium_large',
                    array(
                        'class' => 'rounded-lg w-full h-auto',
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
                ?>
            </a>

        <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('wp_body_open')) :
    /**
     * Shim for sites older than 5.2.
     *
     * @link https://core.trac.wordpress.org/ticket/12563
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }
endif;