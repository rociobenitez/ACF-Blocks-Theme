<?php
/**
 * Card Component Template
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$post_id   = isset($args['post_id']) ? (int) $args['post_id'] : 0;
$cta_text  = isset($args['cta_text']) ? (string) $args['cta_text'] : __('Ver más','textdomain');
$aspect_ratio = isset($args['aspect_ratio']) ? (string) $args['aspect_ratio'] : '4-3';
$extra_cls = isset($args['extra_cls']) ? sanitize_html_class($args['extra_cls']) : '';

if ( ! $post_id ) return; 

$title = get_the_title($post_id);
if ( ! $title ) return;

$permalink = get_permalink($post_id);
$excerpt   = wp_trim_words( wp_strip_all_tags( get_the_excerpt($post_id) ), 28, '…' );

// Thumbnail
$thumb = get_the_post_thumbnail( $post_id, 'medium', [
	'class'   => 'card-image',
	'loading' => 'lazy',
	'decoding'=> 'async',
] );

?>
<article class="card <?php echo esc_attr($extra_cls); ?>">
	<a class="card-link" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
		<div class="card-media aspect-ratio--<?php echo esc_attr($aspect_ratio); ?>">
			<?php if ( $thumb ) : ?>
				<?php echo $thumb; ?>
			<?php else : ?>
				<div class="card-image card-image--placeholder" aria-hidden="true">
					<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="80" height="80" fill="transparent"/>
						<path d="M20 30L40 15L60 30M20 50L40 35L60 50" stroke="#ccc" stroke-width="2" fill="none"/>
					</svg>
				</div>
			<?php endif; ?>
		</div>

		<div class="card-content">
			<h3 class="card-title"><?php echo esc_html($title); ?></h3>
			<?php if ( $excerpt ): ?>
				<p class="card-excerpt"><?php echo esc_html($excerpt); ?></p>
			<?php endif; ?>
			<div class="card-actions">
				<span class="btn--ghost btn--sm card-btn">
					<?php echo esc_html($cta_text); ?>
					<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
						<path d="M8 0L6.6 1.4L12.2 7H0v2h12.2l-5.6 5.6L8 16l8-8z"/>
					</svg>
				</span>
			</div>
		</div>
	</a>
</article>
