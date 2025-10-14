<?php
/**
 * Render Template for the Teams Block
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Block ID and classes
$id = $block['anchor'] ?? ('related-' . $block['id']);

// Detect if in block editor
$is_block_editor = function_exists('get_current_screen') && ( is_admin() && ( $s = get_current_screen() ) && $s->is_block_editor() );

// ACF fields
$tagline         = trim((string) get_field('tagline'));
$title           = trim((string) get_field('title'));
$tag_title       = trim((string) get_field('tag_title'));
$description     = trim((string) get_field('description'));
$related         = get_field('members');
$tag_title_card  = trim((string) get_field('tag_title_card'));
$items_per_row   = (int) ( get_field('items_per_row') ?: 3 );
$btn_see_more    = (array) get_field('button') ?: [];

$related_count = is_array($related) ? count($related) : 0;
if ( $related_count === 0 ) {
    return;
}

$classes = [
    'teams',
    'teams--py-lg',
    'teams--cols-' . $items_per_row,
];

$attrs = get_block_wrapper_attributes([
    'class' => implode(' ', $classes),
    'id' => esc_attr($id),
    'data-cols' => esc_attr($items_per_row),
    'data-items-per-row' => esc_attr($items_per_row),
]);

?>
<section <?php echo $attrs; ?>>
    <?php if ( $is_block_editor && $related_count === 0 ): ?>
        <div class="editor-help" role="note">
            <p style="padding: 2em; text-align: center; background: #f6f6f6; border: 1px dashed #ccc;">
                <?php esc_html_e( 'No hay miembros del equipo seleccionados. Edita el bloque para añadir algunos.', 'acf-starter-theme' ); ?>
            </p>
        </div>
    <?php else: ?>

    <div class="container">
        <!-- Header Section -->
        <?php if ($title): ?>
            <?php
            echo render_component('header-section', [
                'tagline'         => $tagline,
                'title'           => $title,
                'tag_title'       => $tag_title,
                'description'     => $description,
                'is_block_editor' => $is_block_editor,
                'extra_cls'       => 'related__header',
            ]);
            ?>
        <?php endif; ?>

        <!-- Team Members Grid -->
        <?php 
        render_team_grid( $related, [
            'columns' => $items_per_row,
            'class_modifier' => 'grid-item',
            'show_contact' => true,
            'wrapper_class' => 'teams__grid',
        ]); 
        ?>
        
        <?php if ( !empty($btn_see_more['url']) ): ?>
            <div class="teams__cta">
                <a href="<?php echo esc_url($btn_see_more['url']); ?>" 
                   class="btn btn--sm btn--outline"
                   <?php echo !empty($btn_see_more['target']) ? 'target="' . esc_attr($btn_see_more['target']) . '"' : ''; ?>>
                    <?php echo esc_html($btn_see_more['title'] ?: __('Ver más', 'acf-starter-theme')); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <?php endif; ?>
</section>
