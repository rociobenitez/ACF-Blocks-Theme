<?php
/**
* Dynamic Block Template.
* @param   array $attributes - A clean associative array of block attributes.
* @param   array $block - All the block settings and attributes.
* @param   string $content - The block inner HTML (usually empty unless using inner blocks).
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Get ACF fields
$layout_variant = get_field('layout_variant') ?: 'background';
$image_id = get_field('image');
$heading = get_field('heading');
$heading_tag = get_field('heading_tag') ?: 'h2';
$subheading = get_field('subheading');
$body = get_field('body');
$link = get_field('link');
$link_style = get_field('link_style') ?: 'primary';
?>

<div <?php echo get_block_wrapper_attributes(["class" => 'cta cta--' . $layout_variant]); ?>>
	<?php if ($image_id): ?>
	<div class="cta__image">
		<?php echo wp_get_attachment_image( $image_id, "large" ); ?>
	</div>
	<?php endif; ?>
	
	<div class="cta__content">
		<?php if (!empty($subheading)): ?>
			<p class="cta__subheading"><?php echo esc_html($subheading); ?></p>
		<?php endif; ?>
		
		<?php if (!empty($heading)): ?>
			<<?php echo esc_attr($heading_tag); ?> class="cta__heading"><?php echo esc_html($heading); ?></<?php echo esc_attr($heading_tag); ?>>
		<?php endif; ?>
		
		<?php if (!empty($body)): ?>
			<div class="cta__body"><?php echo wp_kses_post($body); ?></div>
		<?php endif; ?>
		
		<?php if (!empty($link) && !empty($link['url'])): ?>
			<a target="<?php echo !empty($link['target']) ? esc_attr($link['target']) : '_self'; ?>" 
			   href="<?php echo esc_url($link['url']); ?>" 
			   class="cta__button btn btn--<?php echo esc_attr($link_style); ?>">
				<?php echo esc_html($link['title'] ?: 'Saber más'); ?>
			</a>
		<?php endif; ?>
	</div>
</div>