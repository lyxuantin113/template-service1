<?php

/**
 * Posts archive - Custom by shortcode.
 *
 * @package Flatsome\Templates
 * @flatsome-version 3.16.0
 */

if (have_posts()) : ?>
    <div id="post-list">
        <?php
        echo do_shortcode('[my_blog_posts
            columns="1"
            type="row"
            posts="10"
            excerpt="visible"
            excerpt_length="20"
            readmore="Chi tiết"
            show_date="text"
            image_size="medium"
            image_hover="zoom"
            image_overlay="rgba(0,0,0,0.1)"
            text_pos="bottom"
            text_align="left"
            title_size="large"
            class="archive-normal"
        ]');
        ?>
    </div>
<?php else: ?>
    <?php get_template_part('template-parts/posts/content', 'none'); ?>
<?php endif; ?>