<?php
/**
 * Recent Posts Block Render Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 */

// Block attributes
$block_id = isset($block['anchor']) ? $block['anchor'] : 'recent-posts-' . $block['id'];
$class_name = isset($block['className']) ? $block['className'] : '';

// Get ACF fields
$posts_count = get_field('posts_count') ?: 3;
$tag_title_card = get_field('tag_title_card') ?: 'h3';

// Query recent posts
$recent_posts = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $posts_count,
    'orderby' => 'date',
    'order' => 'DESC',
    'meta_query' => [
        [
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS'
        ]
    ]
]);

if (!$recent_posts->have_posts()) {
    if ($is_preview) {
        echo '<p>No se encontraron posts recientes con imagen destacada.</p>';
    }
    return;
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="recent-posts-block <?php echo esc_attr($class_name); ?>">
    <div class="container">
        <div class="recent-posts-grid" data-posts="<?php echo esc_attr($posts_count); ?>">
            <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                <article class="recent-post-card">
                    <a href="<?php the_permalink(); ?>" class="post-link">
                        <div class="post-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', ['alt' => get_the_title()]); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="post-content">
                            <div class="post-meta">
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date('d M Y'); ?>
                                </time>
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                ?>
                                    <span class="post-category">
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php echo tag_title($tag_title_card, get_the_title(), 'post-title'); ?>

                            <?php if (has_excerpt()) : ?>
                                <p class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <?php else : ?>
                                <p class="post-excerpt"><?php echo wp_trim_words(get_the_content(), 20); ?></p>
                            <?php endif; ?>

                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php
// Reset post data
wp_reset_postdata();
?>