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
    </style>

    <div class="container">
        <article class="fs-single">
            <?php if (has_post_thumbnail()): ?>
                <div class="fs-single__hero">
                    <?php the_post_thumbnail('large', ['class' => 'fs-single__img']); ?>
                </div>
            <?php endif; ?>

            <h1 class="fs-single__title"><?php the_title(); ?></h1>

            <div class="fs-single__content entry-content">
                <?php the_content(); ?>
            </div>

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
                    <h2 class="fs-related__title"><?php _e('Similar services', 'flatsome'); ?></h2>
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
                </section>
            <?php endif; ?>
        </article>
    </div>
</main>

<?php get_footer();
?>