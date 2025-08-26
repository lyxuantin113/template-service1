<?php

/**
 * Post-entry header bottom.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

?>
<header class="entry-header">
	<?php if (has_post_thumbnail()) : ?>
		<?php if (! is_single() || (is_single() && get_theme_mod('blog_single_featured_image', 1))) : ?>
			<div class="entry-image relative">
				<?php get_template_part('template-parts/posts/partials/entry-image', 'default'); ?>
				<!-- ✅ Meta info dưới ảnh -->
				<div class="entry-meta-below-thumb mt-10 text-left text-sm">
					<span class="meta-item  meta-item-comment">
						<i class="fa-solid fa-user"></i> by
						<?php echo get_the_author(); ?></span>
					<span class="meta-item meta-item-date mr-3">
						<i class="fa-solid fa-calendar-days"></i>
						<?php echo get_the_date('d/m/Y'); ?>
					</span>

					<span class="meta-item meta-item-cat mr-3">
						<i class="fa-solid fa-tags"></i>
						<?php the_category(', '); ?>
					</span>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="entry-header-text entry-header-text-bottom text-<?php echo get_theme_mod('blog_posts_title_align', 'center'); ?>">
		<?php get_template_part('template-parts/posts/partials/entry', 'title'); ?>
	</div>
</header>