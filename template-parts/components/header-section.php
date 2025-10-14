
<?php
/**
 * Header Section Component
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$tagline         = $args['tagline'] ?? '';
$title           = $args['title'] ?? '';
$tag_title       = $args['tag_title'] ?? '2';
$description     = $args['description'] ?? '';
$is_block_editor = $args['is_block_editor'] ?? false;
$extra_cls       = $args['extra_cls'] ?? '';

$classes = 'header-section';
if ( $extra_cls ) {
    $classes .= ' ' . esc_attr( $extra_cls );
}
?>
<header class="<?php echo $classes; ?>">
    <?php if ( $tagline ): ?>
        <p class="header-section__tagline"><?php echo esc_html( $tagline ); ?></p>
    <?php elseif ( $is_block_editor ): ?>
        <p class="header-section__tagline header-section__placeholder-text">Agrega un tagline...</p>
    <?php endif; ?>

    <?php if ( $title ): ?>
        <?php echo tag_title( (int) $tag_title, $title, 'header-section__title' ); ?>
    <?php elseif ( $is_block_editor ): ?>
        <?php echo tag_title( 2, 'Título de la sección', 'header-section__title', 'header-section__placeholder-text' ); ?>
    <?php endif; ?>

    <?php if ( $description ): ?>
        <p class="header-section__description"><?php echo esc_html( $description ); ?></p>
    <?php elseif ( $is_block_editor ): ?>
        <p class="header-section__description header-section__placeholder-text">Descripción de la sección...</p>
    <?php endif; ?>
</header>