<?php
/**
 * CTA Banner Block Template.
 * 
 * @param   array $attributes - A clean associative array of block attributes.
 * @param   array $block - All the block settings and attributes.
 * @param   string $content - The block inner HTML (usually empty unless using inner blocks).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Obtener los campos de ACF
$tagline = get_field('tagline');
$title = get_field('title');
$content = get_field('content');
$image = get_field('image');
$image_position = get_field('image_position') ?: 'right';
$primary_button = get_field('primary_button');
$secondary_button = get_field('secondary_button');

// Si no hay título, no mostrar el bloque
if ( empty($title) ) {
    return;
}

// Clases CSS
$classes = [
    'cta-banner',
    'image-position-' . $image_position
];

// Si hay imagen, añadir clase
if ( $image ) {
    $classes[] = 'has-image';
}

// Estilos inline para imagen de fondo
$background_style = '';
if ( $image && $image_position === 'background' ) {
    $background_style = 'background-image: url(' . esc_url( $image['sizes']['large'] ?? $image['url'] ) . ');';
}
?>

<div <?php echo get_block_wrapper_attributes(['class' => implode(' ', $classes)]); ?>>
    
    <?php if ( $image_position === 'background' ) : ?>
        <!-- Banner con imagen de fondo -->
        <div class="cta-banner-bg" style="<?php echo $background_style; ?>">
            <div class="cta-overlay"></div>
            <div class="cta-container">
                <div class="cta-content">
                    <?php if ( $tagline ) : ?>
                        <span class="cta-tagline"><?php echo esc_html( $tagline ); ?></span>
                    <?php endif; ?>
                    
                    <h2 class="cta-title"><?php echo esc_html( $title ); ?></h2>
                    
                    <?php if ( $content ) : ?>
                        <div class="cta-description">
                            <p><?php echo wp_kses_post( nl2br( $content ) ); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $primary_button || $secondary_button ) : ?>
                        <div class="cta-buttons">
                            <?php if ( $primary_button ) : ?>
                                <a 
                                    href="<?php echo esc_url( $primary_button['url'] ); ?>" 
                                    class="cta-button cta-button--primary wp-element-button"
                                    <?php echo $primary_button['target'] ? 'target="' . esc_attr( $primary_button['target'] ) . '"' : ''; ?>
                                >
                                    <?php echo esc_html( $primary_button['title'] ); ?>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ( $secondary_button ) : ?>
                                <a 
                                    href="<?php echo esc_url( $secondary_button['url'] ); ?>" 
                                    class="cta-button cta-button--secondary"
                                    <?php echo $secondary_button['target'] ? 'target="' . esc_attr( $secondary_button['target'] ) . '"' : ''; ?>
                                >
                                    <?php echo esc_html( $secondary_button['title'] ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    <?php else : ?>
        <!-- Banner con imagen a los lados -->
        <div class="cta-container">
			<div class="container">

				<?php if ( $image && $image_position === 'left' ) : ?>
					<div class="cta-image-container">
						<?php echo wp_get_attachment_image( $image['ID'], 'large', false, ['class' => 'cta-image'] ); ?>
					</div>
				<?php endif; ?>
				
				<div class="cta-content">
					<?php if ( $tagline ) : ?>
						<span class="cta-tagline"><?php echo esc_html( $tagline ); ?></span>
					<?php endif; ?>
					
					<h2 class="cta-title"><?php echo esc_html( $title ); ?></h2>
					
					<?php if ( $content ) : ?>
						<div class="cta-description">
							<p><?php echo wp_kses_post( nl2br( $content ) ); ?></p>
						</div>
					<?php endif; ?>
					
					<?php if ( $primary_button || $secondary_button ) : ?>
						<div class="cta-buttons">
							<?php if ( $primary_button ) : ?>
								<a 
									href="<?php echo esc_url( $primary_button['url'] ); ?>" 
									class="cta-button cta-button--primary btn--md"
									<?php echo $primary_button['target'] ? 'target="' . esc_attr( $primary_button['target'] ) . '"' : ''; ?>
								>
									<?php echo esc_html( $primary_button['title'] ); ?>
								</a>
							<?php endif; ?>
							
							<?php if ( $secondary_button ) : ?>
								<a 
									href="<?php echo esc_url( $secondary_button['url'] ); ?>" 
									class="cta-button cta-button--secondary btn--md"
									<?php echo $secondary_button['target'] ? 'target="' . esc_attr( $secondary_button['target'] ) . '"' : ''; ?>
								>
									<?php echo esc_html( $secondary_button['title'] ); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				
				<?php if ( $image && $image_position === 'right' ) : ?>
					<div class="cta-image-container">
						<?php echo wp_get_attachment_image( $image['ID'], 'large', false, ['class' => 'cta-image'] ); ?>
					</div>
				<?php endif; ?>

			</div>
        </div>
    <?php endif; ?>
    
</div>