<?php
define('THEME_URL', get_stylesheet_directory_uri());

function devitech_scripts()
{
    wp_enqueue_script('my-script', THEME_URL . '/assets/js/script.js', array('jquery'), '1.0.0', true);
    // CSS cơ bản (child)
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array(), // hoặc array('flatsome-style') nếu muốn đảm bảo sau Flatsome
        filemtime(get_stylesheet_directory() . '/style.css'),
        'all'
    );

    // CUSTOM CSS (đảm bảo sau cùng để override)
    wp_enqueue_style(
        'custom-style',
        get_stylesheet_directory_uri() . '/custom.css',
        array('child-style'),
        filemtime(get_stylesheet_directory() . '/custom.css'),
        'all'
    );
    wp_enqueue_style('fonts-style', THEME_URL . '/assets/css/fonts.css', array(), '1.0.0', 'all');

    // Swiper CSS
    wp_enqueue_style(
        'swiper-css',
        'https://unpkg.com/swiper/swiper-bundle.min.css',
        array(),
        '8.4.2'
    );

    // Swiper JS
    wp_enqueue_script(
        'swiper-js',
        'https://unpkg.com/swiper/swiper-bundle.min.js',
        array(),
        '8.4.2',
        true // đặt ở footer
    );

    /**
     * Slick
     */
    wp_enqueue_style('slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', array(), '1.0.0', 'all');
    wp_enqueue_style('slick-theme-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css', array(), '1.0.0', 'all');
    wp_enqueue_script('jquery-migrate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.5.2/jquery-migrate.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js', array('jquery'), '1.0.0', true);

    // Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(),
        '6.5.0'
    );

    // Fontello
    wp_enqueue_style(
        'fontello-icons',
        get_stylesheet_directory_uri() . '/assets/fonts/fontelloicons/fontello.min.css',
        array(),        // dependencies (nếu cần load sau file khác)
        '1.0.0'         // version
    );

    // Trang chủ
    if (is_page(48)) {
        wp_enqueue_style('home-style', THEME_URL . '/assets/css/home.css', array(), '1.0.0', 'all');
    }

    // Giới thiệu
    if (is_page(50)) {
        wp_enqueue_style('about-style', THEME_URL . '/assets/css/about.css', array(), '1.0.0', 'all');
    }

    // Tin tức 
    if (is_home()) {
        wp_enqueue_style('news-style', THEME_URL . '/assets/css/news.css', array(), '1.0.0', 'all');
    }

    // Dịch vụ
    if (is_page(52)) {
        wp_enqueue_style('services-style', THEME_URL . '/assets/css/services.css', array(), '1.0.0', 'all');
    }

    // Liên hệ
    if (is_page(56)) {
        wp_enqueue_style('contact-style', THEME_URL . '/assets/css/contact.css', array(), '1.0.0', 'all');
    }

    // Single Post
    if (is_single() && get_post_type() === 'post') {
        wp_enqueue_style(
            'custom-single-post',
            get_stylesheet_directory_uri() . '/assets/css/single-post.css',
            array(),
            '1.0'
        );
        wp_enqueue_style('news-style', THEME_URL . '/assets/css/news.css', array(), '1.0.0', 'all');
    }
}
add_action('wp_enqueue_scripts', 'devitech_scripts', 9999);

/**
 * Dash Icons
 */
function load_dashicons_frontend()
{
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'load_dashicons_frontend');

/**
 *  Font Awesome 6
 */
add_action('wp_enqueue_scripts', function () {
    if (!wp_style_is('fa6', 'enqueued')) {
        wp_enqueue_style('fa6', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', [], '6.5.2');
    }
});


/**
 * AOS
 */
function add_aos_scripts()
{
    // Thêm CSS của AOS
    wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css');

    // Thêm JS của AOS
    wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), null, true);

    // Khởi tạo AOS sau khi load trang
    wp_add_inline_script('aos-js', 'AOS.init({ once: true });');
}
add_action('wp_enqueue_scripts', 'add_aos_scripts');

// Animation In AOS
add_action('wp_footer', function () {
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1) Map class → animation type
            const map = {
                'fade-in-animation': 'fade',
                'fade-up-animation': 'fade-up',
                'fade-left-animation': 'fade-left',
                'fade-right-animation': 'fade-right'
            };

            // 2) Gán data-aos trước hết
            Object.entries(map).forEach(([cls, aosType]) => {
                document.querySelectorAll('.' + cls).forEach(el => {
                    el.setAttribute('data-aos', aosType);
                    el.setAttribute('data-aos-duration', '700');
                    el.setAttribute('data-aos-delay', '0');
                });
            });
            // data-aos="fade-up" data-aos-duration="700"

            // 4) Quét lại AOS để chèn class aos-animate
            setTimeout(() => {
                if (typeof AOS !== 'undefined') {
                    AOS.refreshHard();
                    AOS.init({
                        once: true
                    });
                }
            }, 500);
        });
    </script>
<?php
});

/**
 * Scroll Back To Top
 */
function scroll_to_top()
{
?>


    <script>
        // Hiện nút khi cuộn xuống
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('backToTop');
            if (window.scrollY > 300) {
                btn.style.display = 'block';
            } else {
                btn.style.display = 'none';
            }
        });

        // Cuộn mượt lên đầu trang khi click
        document.getElementById('backToTop').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
<?php
}
add_action('wp_enqueue_scripts', 'scroll_to_top');

// TAG P - CF7
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * CPT
 */

// 1) CPT: Customer Reviews
add_action('init', function () {
    register_post_type('customer_review', [
        'labels' => [
            'name'               => 'Customer Reviews',
            'singular_name'      => 'Customer Review',
            'add_new_item'       => 'Thêm review',
            'edit_item'          => 'Sửa review',
            'all_items'          => 'Tất cả Reviews',
        ],
        'public'        => true,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-testimonial',
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
    ]);
});

// 2) ACF: các field cho review (nếu dùng ACF)
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key' => 'group_cr_fields',
        'title' => 'Chi tiết Review',
        'fields' => [
            ['key' => 'field_cr_name', 'label' => 'Tên khách hàng', 'name' => 'cr_name', 'type' => 'text'],
            ['key' => 'field_cr_role', 'label' => 'Chức danh', 'name' => 'cr_role', 'type' => 'text', 'placeholder' => 'Khách hàng'],
            ['key' => 'field_cr_rating', 'label' => 'Đánh giá (1–5)', 'name' => 'cr_rating', 'type' => 'number', 'min' => 1, 'max' => 5, 'step' => 1, 'default_value' => 5],
            ['key' => 'field_cr_avatar', 'label' => 'Ảnh đại diện', 'name' => 'cr_avatar', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail'],
            ['key' => 'field_cr_quote_img', 'label' => 'Ảnh quote', 'name' => 'cr_quote_img', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail'],
        ],
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'customer_review']]],
        'position' => 'acf_after_title',
    ]);
});

function mm_cr_stars_html($rating)
{
    $rating = max(0, min(5, intval($rating)));
    if ($rating <= 0) return '';
    $html = '<div class="cr-stars" aria-label="Đánh giá ' . $rating . '/5">';
    for ($i = 1; $i <= 5; $i++) {
        $html .= '<span class="cr-star' . ($i <= $rating ? ' is-on' : '') . '">★</span>';
    }
    $html .= '</div>';
    return $html;
}

// 5) Shortcode render slider
add_shortcode('customer_reviews', function ($atts) {
    $atts = shortcode_atts([
        'count'          => 6,
        'id'             => 'cr-' . wp_generate_password(6, false, false),
        'fallback_quote' => '' // ID hoặc URL, dùng khi post không có ảnh quote riêng
    ], $atts, 'customer_reviews');

    wp_enqueue_style('swiper');
    wp_enqueue_script('swiper');

    // Helper chuyển ID/URL thành <img>
    $render_img = function ($src_or_id, $class = '') {
        if (!$src_or_id) return '';
        if (is_numeric($src_or_id)) {
            return wp_get_attachment_image((int)$src_or_id, 'full', false, ['class' => $class, 'loading' => 'lazy', 'alt' => '']);
        }
        return '<img class="' . esc_attr($class) . '" loading="lazy" alt="" src="' . esc_url($src_or_id) . '"/>';
    };

    $q = new WP_Query([
        'post_type'      => 'customer_review',
        'posts_per_page' => (int)$atts['count'],
        'post_status'    => 'publish',
    ]);
    if (!$q->have_posts()) return '';

    ob_start(); ?>
    <div class="cr-slider swiper" id="<?php echo esc_attr($atts['id']); ?>">
        <div class="swiper-wrapper">
            <?php while ($q->have_posts()): $q->the_post();
                $pid  = get_the_ID();
                $name = function_exists('get_field') ? get_field('cr_name', $pid) : get_post_meta($pid, 'cr_name', true);
                $role = function_exists('get_field') ? get_field('cr_role', $pid) : get_post_meta($pid, 'cr_role', true);
                $rate = function_exists('get_field') ? get_field('cr_rating', $pid) : get_post_meta($pid, 'cr_rating', true);

                // Avatar: ưu tiên ACF, fallback featured image
                $avt_id = function_exists('get_field') ? get_field('cr_avatar', $pid) : get_post_meta($pid, 'cr_avatar', true);
                if (!$avt_id) $avt_id = get_post_thumbnail_id($pid);
                $avatar = $avt_id ? wp_get_attachment_image($avt_id, 'thumbnail', false, ['class' => 'cr-avatar', 'loading' => 'lazy']) : '';

                // Quote image: post-specific > fallback from shortcode
                $quote_id = function_exists('get_field') ? get_field('cr_quote_img', $pid) : '';
                $quote_html = $quote_id ? $render_img($quote_id, 'cr-quote-img') : $render_img($atts['fallback_quote'], 'cr-quote-img');

                // Nội dung review
                $content = apply_filters('the_content', get_the_content(null, false, $pid));
            ?>
                <div class="swiper-slide">
                    <article class="cr-card">
                        <header class="cr-head">
                            <div class="cr-author">
                                <?php echo $avatar; ?>
                                <div class="cr-person">
                                    <div class="cr-name"><?php echo esc_html($name ?: get_the_title()); ?></div>
                                    <?php if ($role): ?><div class="cr-role"><?php echo esc_html($role); ?></div><?php endif; ?>
                                </div>
                            </div>

                            <span class="cr-quote" aria-hidden="true">
                                <?php
                                // dùng ảnh quote riêng; nếu không có thì fallback Font Awesome
                                echo $quote_html ?: '<i class="fa-solid fa-quote-right"></i>';
                                ?>
                            </span>
                        </header>

                        <div class="cr-content"><?php echo $content; ?></div>

                        <div class="cr-divider"></div>

                        <footer class="cr-foot">
                            <time class="cr-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo esc_html(get_the_date('j \t\há\n\g n, Y')); ?>
                            </time>
                            <?php echo mm_cr_stars_html($rate); ?>
                        </footer>
                    </article>
                </div>

            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('#<?php echo esc_js($atts['id']); ?>', {
                loop: true,
                centeredSlides: true, // luôn canh giữa slide đang active
                slidesPerView: 1.15, // thấy lộ 2 bên
                spaceBetween: 16,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                navigation: false,
                breakpoints: {
                    768: {
                        slidesPerView: 1.35,
                        spaceBetween: 24
                    },
                    1200: {
                        slidesPerView: 1.6,
                        spaceBetween: 32
                    }
                }
            });
        });
    </script>

<?php
    return ob_get_clean();
});

// News
add_shortcode('blog_cards_swiper', function ($atts) {
    $a = shortcode_atts([
        'posts'    => 6,
        'cat'      => '',
        'tag'      => '',
        'slides'   => 3,
        'space'    => 24,
        'autoplay' => 5000,
        'id'       => 'bcs-' . wp_generate_password(6, false, false),
    ], $atts, 'blog_cards_swiper');

    wp_enqueue_style('swiper');
    wp_enqueue_script('swiper');

    $args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => (int)$a['posts'],
    ];
    if ($a['cat'] !== '') $args['category_name'] = sanitize_text_field($a['cat']);
    if ($a['tag'] !== '') $args['tag'] = sanitize_text_field($a['tag']);

    $q = new WP_Query($args);
    if (!$q->have_posts()) return '';

    ob_start(); ?>
    <div class="mm-blog-swiper swiper" id="<?php echo esc_attr($a['id']); ?>">
        <div class="swiper-wrapper">
            <?php while ($q->have_posts()): $q->the_post();
                $pid   = get_the_ID();
                $thumb = get_the_post_thumbnail($pid, 'large', ['class' => 'mm-card-img', 'loading' => 'lazy']);
                if (!$thumb) {
                    $thumb = '<div class="mm-card-img mm-img-placeholder"></div>';
                }
                $day   = get_the_date('d', $pid);
                $month = 'TH' . get_the_date('n', $pid);

                $author_id   = get_the_author_meta('ID');
                $author_name = get_the_author();
                $author_url  = get_author_posts_url($author_id);
                $avatar      = get_avatar($author_id, 24);
                $cmt_count   = get_comments_number($pid);
            ?>
                <div class="swiper-slide">
                    <article class="mm-blog-card">
                        <div class="mm-card-media">
                            <a class="mm-img-wrap" href="<?php the_permalink(); ?>"><?php echo $thumb; ?></a>

                            <div class="mm-date-badge">
                                <span class="d"><?php echo esc_html($day); ?></span>
                                <span class="m"><?php echo esc_html($month); ?></span>
                            </div>

                            <div class="mm-meta-pill">
                                <span class="mm-avatar"><?php echo $avatar; ?></span>
                                <a class="mm-by" href="<?php echo esc_url($author_url); ?>">By-<?php echo esc_html($author_name); ?></a>
                                <span class="mm-dot">•</span>
                                <a class="mm-comments" href="<?php comments_link(); ?>">Comments(<?php echo (int)$cmt_count; ?>)</a>
                            </div>
                        </div>

                        <div class="mm-card-body">
                            <h3 class="mm-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="mm-divider"></div>
                            <a class="mm-readmore" href="<?php the_permalink(); ?>">Xem Thêm <span class="arr"><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </article>
                </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('#<?php echo esc_js($a['id']); ?>', {
                slidesPerView: 1,
                spaceBetween: <?php echo (int)$a['space']; ?>,
                loop: true,
                autoplay: {
                    delay: <?php echo (int)$a['autoplay']; ?>,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '#<?php echo esc_js($a['id']); ?> .swiper-pagination',
                    clickable: true
                },
                navigation: false, // không next/prev
                breakpoints: {
                    768: {
                        slidesPerView: 2
                    },
                    1200: {
                        slidesPerView: <?php echo (int)$a['slides']; ?>
                    }
                }
            });
        });
    </script>
<?php
    return ob_get_clean();
});

// Accordion: đổi icon mặc định sang Font Awesome (eye / eye-slash)
add_action('wp_enqueue_scripts', function () {
    // Load FA6 nếu site chưa có
    if (!wp_style_is('fa6', 'enqueued') && !wp_style_is('font-awesome', 'enqueued')) {
        wp_enqueue_style(
            'fa6',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
            [],
            '6.5.2'
        );
    }

    // Inject JS (không cần jQuery)
    $js = <<<JS
(function(){
  function setIcon(title){
    var i = title.querySelector('.toggle i');
    if(!i) return;
    i.className = 'fa-solid ' + (title.classList.contains('active') ? 'fa-eye-slash' : 'fa-eye');
  }
  function init(root){
    root.querySelectorAll('.accordion-title').forEach(function(t){
      setIcon(t);
      // Theo dõi khi Flatsome toggle class .active
      new MutationObserver(function(muts){
        muts.forEach(function(m){
          if(m.type==='attributes' && m.attributeName==='class'){ setIcon(t); }
        });
      }).observe(t, { attributes:true });
    });
  }

  document.addEventListener('DOMContentLoaded', function(){ init(document); });

  // Cập nhật ngay sau khi người dùng click tiêu đề
  document.addEventListener('click', function(e){
    var t = e.target.closest('.accordion-title');
    if(!t) return;
    setTimeout(function(){ setIcon(t); }, 0);
  });
})();
JS;

    wp_register_script('mm-accordion-icons', '', [], null, true);
    wp_enqueue_script('mm-accordion-icons');
    wp_add_inline_script('mm-accordion-icons', $js);
});


// LAYOUT POST
function my_blog_posts_shortcode($atts, $content = null, $tag = '')
{

    $defined_atts = $atts;

    extract($atts = shortcode_atts(array(
        "_id" => 'row-' . rand(),
        'style' => '',
        'class' => '',
        'visibility' => '',


        // Layout
        "columns" => '1',
        "columns__sm" => '1',
        "columns__md" => '1',
        'col_spacing' => 'small',
        "type" => '', // slider, row, masonery, grid
        'width' => '',
        'grid' => '1',
        'grid_height' => '600px',
        'grid_height__md' => '500px',
        'grid_height__sm' => '400px',
        'slider_nav_style' => 'circle',
        'slider_nav_position' => '',
        'slider_nav_color' => 'light',
        'slider_bullets' => 'false',
        'slider_arrows' => 'true',
        'auto_slide' => 'false',
        'infinitive' => 'true',
        'depth' => '',
        'depth_hover' => '',
        // Relay
        'relay' => '',
        'relay_control_result_count' => 'true',
        'relay_control_position' => 'bottom',
        'relay_control_align' => 'center',
        'relay_id' => '',
        'relay_class' => '',
        // posts
        'posts' => '',
        'ids' => '', // Custom IDs
        'cat' => '',
        'category' => '', // Added for Flatsome v2 fallback
        'excerpt' => 'visible',
        'excerpt_length' => 20,
        'offset' => '',
        'orderby' => 'date',
        'order' => 'DESC',
        'tags' => '',
        'page_number' => '1',

        // Read more
        'readmore' => 'Xem thêm',


        // div meta
        'show_date' => 'text', // badge, text


        //Title
        'title_size' => 'large',
        'title_style' => '',

        // Box styles
        'animate' => '',
        'text_pos' => 'bottom',
        'text_padding' => '',
        'text_bg' => '',
        'text_size' => '',
        'text_color' => '',
        'text_hover' => '',
        'text_align' => 'left',
        'image_size' => 'medium',
        'image_width' => '',
        'image_radius' => '',
        'image_height' => '75%',
        'image_hover' => '',
        'image_hover_alt' => '',
        'image_overlay' => '',
        'image_depth' => '',
        'image_depth_hover' => '',

    ), $atts));

    // Stop if visibility is hidden
    if ($visibility == 'hidden') return;

    ob_start();

    $classes_box = array();
    $classes_image = array();
    $classes_text = array();

    // Fix overlay color
    if ($style == 'text-overlay') {
        $image_hover = 'zoom';
    }
    $style = str_replace('text-', '', $style);

    // Fix grids
    if ($type == 'grid') {
        if (!$text_pos) $text_pos = 'center';
        $columns = 0;
        $current_grid = 0;
        $grid = flatsome_get_grid($grid);
        $grid_total = count($grid);
    }

    // Fix overlay
    if ($style == 'overlay' && !$image_overlay) $image_overlay = 'rgba(0,0,0,.25)';

    // Set box style
    if ($style) $classes_box[] = 'box-' . $style;
    if ($style == 'overlay') $classes_box[] = 'dark';
    if ($style == 'shade') $classes_box[] = 'dark';
    if ($style == 'badge') $classes_box[] = 'hover-dark';
    if ($text_pos) $classes_box[] = 'box-text-' . $text_pos;

    if ($image_hover)  $classes_image[] = 'image-' . $image_hover;
    if ($image_hover_alt)  $classes_image[] = 'image-' . $image_hover_alt;
    if ($image_height) $classes_image[] = 'image-cover';

    // Text classes
    if ($text_hover) $classes_text[] = 'show-on-hover hover-' . $text_hover;
    if ($text_align) $classes_text[] = 'text-' . $text_align;
    if ($text_size) $classes_text[] = 'is-' . $text_size;
    if ($text_color == 'dark') $classes_text[] = 'dark';

    $css_args_img = array(
        array('attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%'),
        array('attribute' => 'width', 'value' => $image_width, 'unit' => '%'),
    );

    $css_image_height = array(
        array('attribute' => 'padding-top', 'value' => $image_height),
    );

    $css_args = array(
        array('attribute' => 'background-color', 'value' => $text_bg),
        array('attribute' => 'padding', 'value' => $text_padding),
    );

    // Add Animations
    if ($animate) {
        $animate = 'data-animate="' . esc_attr($animate) . '"';
    }

    $classes_text = implode(' ', $classes_text);
    $classes_image = implode(' ', $classes_image);
    $classes_box = implode(' ', $classes_box);

    // Repeater styles
    $repeater['id'] = $_id;
    $repeater['tag'] = $tag;
    $repeater['type'] = $type;
    $repeater['class'] = $class;
    $repeater['visibility'] = $visibility;
    $repeater['style'] = $style;
    $repeater['slider_style'] = $slider_nav_style;
    $repeater['slider_nav_position'] = $slider_nav_position;
    $repeater['slider_nav_color'] = $slider_nav_color;
    $repeater['slider_bullets'] = $slider_bullets;
    $repeater['auto_slide'] = $auto_slide;
    $repeater['infinitive'] = $infinitive;
    $repeater['row_spacing'] = $col_spacing;
    $repeater['row_width'] = $width;
    $repeater['columns'] = $columns;
    $repeater['columns__md'] = $columns__md;
    $repeater['columns__sm'] = $columns__sm;
    $repeater['depth'] = $depth;
    $repeater['depth_hover'] = $depth_hover;

    if (! empty($offset)) {
        $found_posts_filter_callback = function ($found_posts, $query) use ($offset) {
            return $found_posts - (int) $offset;
        };

        add_filter('found_posts', $found_posts_filter_callback, 1, 2);
    }

    $offset = (int) $page_number > 1
        ? (int) $offset + ((int) $page_number - 1) * (int) $posts
        : $offset;

    global $wp_query;

    if (is_archive() || is_search() || is_home()) {
        $args = $wp_query->query_vars; // Lấy query gốc
    } else {
        $args = array(
            'post_status' => 'publish',
            'post_type' => 'post',
            'offset' => $offset,
            'cat' => $cat,
            'tag__in' => $tags ? array_filter(array_map('trim', explode(',', $tags))) : '',
            'posts_per_page' => $posts ?: get_option('posts_per_page'),
            'paged' => $page_number,
            'ignore_sticky_posts' => true,
            'orderby' => $orderby,
            'order' => $order,
        );
    }


    // Added for Flatsome v2 fallback
    if (get_theme_mod('flatsome_fallback', 0) && $category) {
        $args['category_name'] = $category;
    }

    // If custom ids
    if (!empty($ids)) {
        $ids = explode(',', $ids);
        $ids = array_map('trim', $ids);

        $args = array(
            'post__in' => $ids,
            'post_type' => array(
                'post',
                'featured_item', // Include for its tag archive listing.
            ),
            'numberposts' => -1,
            'orderby' => 'post__in',
            'posts_per_page' => 9999,
            'ignore_sticky_posts' => true,
        );

        // Include for search archive listing.
        if (is_search()) {
            $args['post_type'][] = 'page';
        }
    }

    $recentPosts = new WP_Query($args);

    if (isset($found_posts_filter_callback)) {
        remove_filter('found_posts', $found_posts_filter_callback, 1);
    }

    Flatsome_Relay::render_container_open($recentPosts, $tag, $defined_atts, $atts);

    if ($type == 'grid') {
        flatsome_get_grid_height($grid_height, $_id);
    }

    get_flatsome_repeater_start($repeater);

    while ($recentPosts->have_posts()) : $recentPosts->the_post();

        $col_class    = array('post-item');
        $show_excerpt = $excerpt;

        if (get_post_format() == 'video') $col_class[] = 'has-post-icon';

        if ($type == 'grid') {
            if ($grid_total > $current_grid) $current_grid++;
            $current = $current_grid - 1;

            $col_class[] = 'grid-col';
            if ($grid[$current]['height']) $col_class[] = 'grid-col-' . $grid[$current]['height'];

            if ($grid[$current]['span']) $col_class[] = 'large-' . $grid[$current]['span'];
            if ($grid[$current]['md']) $col_class[] = 'medium-' . $grid[$current]['md'];

            // Set image size
            if ($grid[$current]['size']) $image_size = $grid[$current]['size'];

            // Hide excerpt for small sizes
            if ($grid[$current]['size'] == 'thumbnail') $show_excerpt = 'false';
        }

        include locate_template('content-my-blog-post.php', false, false);

    endwhile;
    wp_reset_postdata();

    // Get repeater end.
    get_flatsome_repeater_end($atts);

    Flatsome_Relay::render_container_close();

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('my_blog_posts', 'my_blog_posts_shortcode');
function render_my_blog_posts($atts = [])
{
    // Gọi lại đúng function trong shortcode cũ của bạn
    return my_blog_posts_shortcode($atts);
}


// Recent posts
// [recent_posts_row number="4" cat="tin-tuc" tag="" size="thumbnail" class=""]
add_shortcode('recent_posts_row', function ($atts) {
    $a = shortcode_atts([
        'number' => 5,             // số bài
        'cat'    => '',            // slug chuyên mục (tùy chọn)
        'tag'    => '',            // slug tag (tùy chọn)
        'size'   => 'thumbnail',   // kích thước ảnh: thumbnail/medium/medium_large...
        'class'  => '',            // thêm class ngoài nếu muốn
    ], $atts, 'recent_posts_row');

    $args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => (int)$a['number'],
        'ignore_sticky_posts' => true,
    ];
    if ($a['cat'] !== '') $args['category_name'] = sanitize_text_field($a['cat']);
    if ($a['tag'] !== '') $args['tag']           = sanitize_text_field($a['tag']);

    $q = new WP_Query($args);
    if (!$q->have_posts()) return '';

    ob_start(); ?>
    <div class="mm-rp <?php echo esc_attr($a['class']); ?>">
        <?php while ($q->have_posts()): $q->the_post();
            $pid = get_the_ID();
            $thumb = get_the_post_thumbnail($pid, $a['size'], [
                'class'   => 'mm-rp-img',
                'loading' => 'lazy',
                'alt'     => esc_attr(get_the_title()),
            ]);
            if (!$thumb) {
                // fallback rỗng (hoặc bạn có thể chèn ảnh mặc định)
                $thumb = '<span class="mm-rp-img mm-rp-img--ph"></span>';
            }
        ?>
            <article class="mm-rp-item">
                <a class="mm-rp-thumb" href="<?php the_permalink(); ?>"><?php echo $thumb; ?></a>
                <div class="mm-rp-content">
                    <time class="mm-rp-date color-black" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <i class="fa-solid fa-calendar-days"></i> <?php echo esc_html(get_the_date('d/m/Y')); ?>
                    </time>
                    <h3 class="mm-rp-title ">
                        <a class="color-black" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
            </article>
        <?php endwhile;
        wp_reset_postdata(); ?>
    </div>
<?php
    return ob_get_clean();
});


/* === CPT: Featured Services === */
add_action('init', function () {
    register_post_type('featured_service', [
        'labels' => [
            'name'               => 'Featured Services',
            'singular_name'      => 'Featured Service',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Service',
            'edit_item'          => 'Edit Service',
            'new_item'           => 'New Service',
            'view_item'          => 'View Service',
            'search_items'       => 'Search Services',
            'not_found'          => 'No services found',
            'not_found_in_trash' => 'No services found in Trash',
            'all_items'          => 'All Featured Services',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'featured-services'],
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-awards',
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
    ]);

    // (Optional) taxonomy để gợi ý Similar services
    register_taxonomy('service_cat', 'featured_service', [
        'labels' => [
            'name'          => 'Service Categories',
            'singular_name' => 'Service Category',
            'search_items'  => 'Search Service Categories',
            'all_items'     => 'All Service Categories',
            'edit_item'     => 'Edit Service Category',
            'add_new_item'  => 'Add New Service Category',
        ],
        'public'       => true,
        'hierarchical' => true,
        'rewrite'      => ['slug' => 'service-category'],
        'show_in_rest' => true,
    ]);
});

/* === Shortcode: [featured_services] ===
 * Params:
 * - count: số item (mặc định 6)
 * - cols:  số cột Desktop (mặc định 3)
 * - cat:   slug taxonomy service_cat (tùy chọn)
 * - class: thêm class ngoài (tùy chọn)
 */
add_shortcode('featured_services', function ($atts) {
    $a = shortcode_atts([
        'count' => 6,
        'cols'  => 3,
        'cat'   => '',
        'class' => '',
    ], $atts, 'featured_services');

    $args = [
        'post_type'      => 'featured_service',
        'post_status'    => 'publish',
        'posts_per_page' => (int)$a['count'],
    ];
    if ($a['cat'] !== '') {
        $args['tax_query'] = [[
            'taxonomy' => 'service_cat',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($a['cat']),
        ]];
    }

    $q = new WP_Query($args);
    if (!$q->have_posts()) return '';

    // Tạo ID riêng cho block (để CSS/JS target nếu cần)
    $block_id = 'fs-grid-' . wp_generate_password(6, false, false);

    ob_start(); ?>
    <section class="fs-grid <?php echo esc_attr($a['class']); ?>" id="<?php echo esc_attr($block_id); ?>"
        style="--fs-cols: <?php echo max(1, (int)$a['cols']); ?>;">
        <?php while ($q->have_posts()): $q->the_post();
            $pid   = get_the_ID();
            $link  = get_permalink($pid);
            $title = get_the_title($pid);
            $img   = get_the_post_thumbnail($pid, 'large', ['class' => 'fs-img', 'loading' => 'lazy', 'alt' => $title]);
            if (!$img) $img = '<span class="fs-img fs-img--ph"></span>';
        ?>
            <a class="fs-item" href="<?php echo esc_url($link); ?>">
                <figure class="fs-figure">
                    <?php echo $img; ?>
                    <figcaption class="fs-caption">
                        <h3 class="fs-title"><?php echo esc_html($title); ?></h3>
                    </figcaption>
                </figure>
            </a>
        <?php endwhile;
        wp_reset_postdata(); ?>
    </section>
<?php
    return ob_get_clean();
});
