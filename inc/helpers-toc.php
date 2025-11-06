<?php
/**
 * Helper Functions for TOC (Table of Contents) Components
 */

function st_render_toc( $args = [] ) {
    if (!is_singular() || !in_the_loop() || !is_main_query()) {
        return '';
    }

    $post_id = get_the_ID();
    $blocks  = parse_blocks( get_post_field( 'post_content', $post_id ) );

    $headings = [];
    mytheme_collect_headings($blocks, $headings);

    if (empty($headings)) {
        return '';
    }

    ob_start();
    ?>
    <nav class="toc" aria-label="<?php esc_attr_e('Table of contents', ST_TEXT_DOMAIN ); ?>">
        <strong class="toc__title"><?php esc_html_e('Contenido', ST_TEXT_DOMAIN ); ?></strong>
        <ul class="toc__list">
            <?php foreach ($headings as $item): ?>
                <li class="toc__item toc__item--h<?php echo (int) $item['level']; ?>">
                    <a href="#<?php echo esc_attr($item['id']); ?>">
                        <?php echo esc_html($item['text']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
    return ob_get_clean();
}

/**
 * Collect headings (h2, h3) from a list of blocks
 * @param array $blocks List of blocks (from parse_blocks)
 * @param array $headings Output array of headings collected
 * @param string $parent_anchor_prefix Optional prefix for anchors
 * @return void
 */
function st_collect_headings(array $blocks, array &$headings, $parent_anchor_prefix = '') {
    foreach ($blocks as $b) {
        // Si es un heading
        if ($b['blockName'] === 'core/heading') {
            $level = $b['attrs']['level'] ?? 2;
            if (!in_array($level, [2,3], true)) {
                continue;
            }

            // Texto plano del heading
            $raw = trim( wp_strip_all_tags( render_block($b) ) );
            if ($raw === '') {
                continue;
            }

            // Anchor: si existe en attrs, úsalo; si no, lo generas
            $anchor = $b['attrs']['anchor'] ?? sanitize_title($raw);

            $headings[] = [
                'level' => $level,
                'id'    => $anchor,
                'text'  => $raw,
            ];
        }

        // Rebursivo: innerBlocks
        if (!empty($b['innerBlocks'])) {
            st_collect_headings($b['innerBlocks'], $headings);
        }
    }
}
