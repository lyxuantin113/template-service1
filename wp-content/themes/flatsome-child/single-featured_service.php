<?php
/* Template: Single Featured Service */
if (! defined('ABSPATH')) exit;
get_header();
the_post(); ?>

<main id="main" class="site-main">
    <style>
        .fs-single__hero {
            margin-bottom: 1.125rem;
            border-radius: 1rem;
            overflow: hidden;
            width: 100%;
            aspect-ratio: 2;
            object-fit: cover;
        }

        .fs-single__img {
            width: 100%;
            display: block;
            object-fit: cover;
        }

        .fs-single__title {
            font-weight: 800;
            font-size: clamp(1.5rem, 3.2vw, 2.25rem);
            margin: .5rem 0 .875rem;
        }

        .fs-single__content {
            line-height: 1.8;
        }

        .fs-related {
            margin-top: 2.25rem;
        }

        .fs-related__title {
            font-weight: 800;
            font-size: clamp(1.125rem, 2.2vw, 1.5rem);
            margin-bottom: 1rem;
        }

        .fs-single__content ul {
            list-style-type: none;
            padding-left: 3rem;
        }

        .fs-single__content ul li {
            color: var(--black-color);
            margin-bottom: .625rem;
            font-weight: 600;
            position: relative;
            padding-left: 1.5rem;
            margin-left: 0 !important;
        }

        .fs-single__content ul li:before {
            content: '\2713';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            transition: 0.3s ease-in-out;
            border-radius: 100%;
            color: var(--white-color);
            background: var(--fs-color-primary);
            line-height: 1;
            padding: .25rem;
            font-size: .5rem;
        }

        /* Next/Prev */
        .fs-single-nav {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 24px;
        }

        .fs-nav {
            flex: 1;
            display: flex;
            align-items: center;
            gap: .75rem;
            background: #f8fafc;
            color: inherit;
            text-decoration: none;
            padding: .75rem .875rem;
            border-radius: .875rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .06);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .fs-nav--next {
            justify-content: flex-end;
            text-align: right;
        }

        .fs-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(0, 0, 0, .08);
        }

        .fs-nav__thumb {
            width: 4rem;
            height: 4rem;
            object-fit: cover;
            border-radius: .625rem;
            flex-shrink: 0;
        }

        .fs-nav__meta small {
            display: block;
            font-size: .75rem;
            color: #6b7280;
        }

        .fs-nav__meta strong {
            display: block;
            font-weight: 700;
            line-height: 1.25;
        }

        .fs-nav__arrow {
            color: var(--fs-color-primary);
            font-weight: 700;
        }
    </style>

    <div class="py-80 center-layout">
        <article class="fs-single">
            <?php if (has_post_thumbnail()): ?>
                <div class="fs-single__hero">
                    <?php the_post_thumbnail('large', ['class' => 'fs-single__img']); ?>
                </div>
            <?php endif; ?>

            <div class="fs-single__content entry-content">
                <?php the_content(); ?>
            </div>

            <?php
            // Prev/Next trong cùng service_cat (đổi $in_same_term = false nếu muốn toàn bộ CPT)
            $taxonomy      = 'service_cat';
            $in_same_term  = true;

            $prev = get_adjacent_post($in_same_term, '', true,  $taxonomy);  // previous
            $next = get_adjacent_post($in_same_term, '', false, $taxonomy);  // next
            ?>

            <?php if ($prev || $next) : ?>
                <nav class="fs-single-nav sm-flex-1" aria-label="<?php esc_attr_e('Service navigation', 'flatsome-child'); ?>">
                    <?php if ($prev) : ?>
                        <a class="fs-nav fs-nav--prev" href="<?php echo esc_url(get_permalink($prev->ID)); ?>">
                            <span class="fs-nav__arrow" aria-hidden="true">←</span>
                            <?php
                            echo get_the_post_thumbnail($prev->ID, 'thumbnail', [
                                'class' => 'fs-nav__thumb',
                                'loading' => 'lazy',
                                'alt' => esc_attr(get_the_title($prev->ID))
                            ]);
                            ?>
                            <span class="fs-nav__meta">
                                <small><?php _e('Previous service', 'flatsome-child'); ?></small>
                                <strong><?php echo esc_html(get_the_title($prev->ID)); ?></strong>
                            </span>
                        </a>
                    <?php endif; ?>

                    <?php if ($next) : ?>
                        <a class="fs-nav fs-nav--next" href="<?php echo esc_url(get_permalink($next->ID)); ?>">
                            <span class="fs-nav__meta">
                                <small><?php _e('Next service', 'flatsome-child'); ?></small>
                                <strong><?php echo esc_html(get_the_title($next->ID)); ?></strong>
                            </span>
                            <?php
                            echo get_the_post_thumbnail($next->ID, 'thumbnail', [
                                'class' => 'fs-nav__thumb',
                                'loading' => 'lazy',
                                'alt' => esc_attr(get_the_title($next->ID))
                            ]);
                            ?>
                            <span class="fs-nav__arrow" aria-hidden="true">→</span>
                        </a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>

            <?php
            // Similar Services: cùng category nếu có, nếu không thì lấy bài mới
            $terms = wp_get_post_terms(get_the_ID(), 'service_cat', ['fields' => 'ids']);
            $rel_args = [
                'post_type'      => 'featured_service',
                'posts_per_page' => 3,
                'post__not_in'   => [get_the_ID()],
            ];
            if (!is_wp_error($terms) && !empty($terms)) {
                $rel_args['tax_query'] = [[
                    'taxonomy' => 'service_cat',
                    'field'    => 'term_id',
                    'terms'    => $terms,
                ]];
            }
            $rel = new WP_Query($rel_args);
            if ($rel->have_posts()): ?>
                <section class="fs-related">

                    <?php echo do_shortcode('[block id="related-project"]'); ?>

                    <div class="fs-slick">
                        <div class="fs-grid" style="--fs-cols:3">
                            <?php while ($rel->have_posts()): $rel->the_post(); ?>
                                <a class="fs-item" href="<?php the_permalink(); ?>">
                                    <figure class="fs-figure">
                                        <?php if (has_post_thumbnail()) {
                                            the_post_thumbnail('large', ['class' => 'fs-img', 'loading' => 'lazy']);
                                        } else {
                                            echo '<span class="fs-img fs-img--ph"></span>';
                                        } ?>
                                        <figcaption class="fs-caption">
                                            <h3 class="fs-title"><?php the_title(); ?></h3>
                                        </figcaption>
                                    </figure>
                                </a>
                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </article>
    </div>
</main>

<?php get_footer();
?>