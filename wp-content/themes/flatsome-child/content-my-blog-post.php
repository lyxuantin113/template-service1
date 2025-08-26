<?php
// $post phải là đối tượng WP_Post
if (!isset($post)) global $post;
// Các biến như $col_class, $animate, $classes_box, ... phải được truyền từ ngoài vào
?>
<div class="col <?php echo esc_attr(implode(' ', $col_class)); ?>">
    <div class="col-inner">
        <a href="<?php the_permalink(); ?>">
            <div class="blog-card mb-32">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="blog-image">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>

                    </div>
                <?php endif; ?>

                <div class="blog-content">
                    <div class="blog-meta-box">
                        <div class="blog-author">
                            <i class="fa-solid fa-user"></i> by
                            <?php echo get_the_author(); ?>
                        </div>
                        <div class="blog-date">
                            <i class="fa-solid fa-calendar-days"></i>
                            <?php echo get_the_date('d/m/Y'); ?>
                        </div>
                        <div class="blog-category">
                            <i class="fa-solid fa-tags"></i>
                            <?php the_category(', '); ?>
                        </div>
                    </div>
                    <h3 class="blog-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>

                    <div class="blog-excerpt mb-16">
                        <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                    </div>

                    <div class="relative">
                        <a class="blog-readmore" href="<?php the_permalink(); ?>">Xem chi tiết <span class="icon"><i class="fa-sharp fa-regular fa-paper-plane"></i></span></a>

                    </div>

                </div>
            </div>
        </a>
    </div>
</div>