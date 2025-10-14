<?php
/**
 * Team Member Card Component
 * 
 * @param array $args {
 *     @type WP_Post $post           El objeto post del miembro del equipo
 *     @type string  $class_modifier Clase CSS adicional (opcional)
 *     @type bool    $show_contact   Mostrar información de contacto (default: true)
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$defaults = [
    'post'          => null,
    'class_modifier' => '',
    'show_contact'   => true,
];

$args = wp_parse_args( $args, $defaults );
extract( $args );

if ( ! $post || ! is_a( $post, 'WP_Post' ) ) {
    return;
}

// Setup post data
$original_post = $GLOBALS['post'] ?? null;
$GLOBALS['post'] = $post;
setup_postdata( $post );

// Get ACF fields for this team member
$role = get_field('role', $post->ID);
$description = get_field('description', $post->ID);
$photo = get_field('photo', $post->ID);
$contact_info = get_field('contact_info', $post->ID);
$related_author = get_field('related_author', $post->ID);

// Get tag title card or default to h3
$tag_title_card = $args['tag_title_card'] ?? 'h3';

// Check if we have a related author and get author URL
$has_author_link = false;
$author_url = '';
if ( $related_author && is_object( $related_author ) ) {
    $author_url = get_author_posts_url( $related_author->ID );
    $has_author_link = !empty( $author_url );
}

// Build classes
$classes = [
    'team-member',
    $class_modifier ? 'team-member--' . $class_modifier : '',
    $has_author_link ? 'team-member--linked' : '',
];
$classes = array_filter( $classes );

?>
<article id="team-member-<?php echo $post->ID; ?>" class="<?php echo esc_attr( implode(' ', $classes) ); ?>">
    <?php if ( $has_author_link ): ?>
        <a href="<?php echo esc_url( $author_url ); ?>" 
           class="team-member__link" 
           title="<?php echo esc_attr( sprintf( __('Ver artículos de %s', 'acf-starter-theme'), get_the_title($post->ID) ) ); ?>"
           aria-label="<?php echo esc_attr( sprintf( __('Ver todos los artículos escritos por %s', 'acf-starter-theme'), get_the_title($post->ID) ) ); ?>">
    <?php endif; ?>
    
    <div class="team-member__inner">
        
        <!-- Photo Section -->
        <?php if ( $photo ): ?>
            <div class="team-member__photo">
                <img src="<?php echo esc_url($photo['sizes']['medium_large'] ?? $photo['url']); ?>" 
                     alt="<?php echo esc_attr($photo['alt'] ?: get_the_title($post->ID)); ?>" 
                     loading="lazy"
                     class="team-member__image">
            </div>
        <?php elseif ( has_post_thumbnail($post->ID) ): ?>
            <div class="team-member__photo">
                <?php echo get_the_post_thumbnail($post->ID, 'medium_large', [
                    'loading' => 'lazy', 
                    'alt' => get_the_title($post->ID),
                    'class' => 'team-member__image'
                ]); ?>
            </div>
        <?php endif; ?>
        
        <!-- Content Section -->
        <div class="team-member__content">
            <div class="team-member__info">

                <?php echo tag_title( $tag_title_card, get_the_title($post->ID), 'team-member__name' ); ?>
                
                <?php if ( $role ): ?>
                    <p class="team-member__role"><?php echo esc_html($role); ?></p>
                <?php endif; ?>
                
                <?php if ( $description ): ?>
                    <div class="team-member__description">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php elseif ( has_excerpt($post->ID) ): ?>
                    <div class="team-member__bio">
                        <?php echo wp_kses_post(get_the_excerpt($post->ID)); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Contact Information -->
            <?php if ( $show_contact && $contact_info && (
                !empty($contact_info['email']) || 
                !empty($contact_info['linkedin_url']) || 
                !empty($contact_info['additional_link']['url'])
            ) ): ?>
                <div class="team-member__contact">
                    <?php if ( !empty($contact_info['email']) ): ?>
                        <a href="mailto:<?php echo esc_attr($contact_info['email']); ?>" 
                           class="team-member__contact-item team-member__email" 
                           onclick="event.stopPropagation()"
                           title="<?php echo esc_attr(sprintf(__('Enviar email a %s', 'acf-starter-theme'), get_the_title($post->ID))); ?>">
                            <span class="team-member__contact-icon">✉</span>
                            <span class="team-member__contact-text"><?php echo esc_html($contact_info['email']); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( !empty($contact_info['linkedin_url']) ): ?>
                        <a href="<?php echo esc_url($contact_info['linkedin_url']); ?>" 
                           class="team-member__contact-item team-member__linkedin" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           onclick="event.stopPropagation()"
                           title="<?php echo esc_attr(sprintf(__('Ver perfil de LinkedIn de %s', 'acf-starter-theme'), get_the_title($post->ID))); ?>">
                            <span class="team-member__contact-icon">💼</span>
                            <span class="team-member__contact-text"><?php esc_html_e('LinkedIn', 'acf-starter-theme'); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( !empty($contact_info['additional_link']['url']) ): ?>
                        <a href="<?php echo esc_url($contact_info['additional_link']['url']); ?>" 
                           class="team-member__contact-item team-member__additional-link" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           onclick="event.stopPropagation()"
                           title="<?php echo esc_attr($contact_info['additional_link']['label'] ?: __('Enlace adicional', 'acf-starter-theme')); ?>">
                            <span class="team-member__contact-icon">🔗</span>
                            <span class="team-member__contact-text">
                                <?php echo esc_html($contact_info['additional_link']['label'] ?: __('Ver más', 'acf-starter-theme')); ?>
                            </span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if ( $has_author_link ): ?>
        </a>
    <?php endif; ?>
</article>

<?php
// Restore original post data
if ( $original_post ) {
    $GLOBALS['post'] = $original_post;
    setup_postdata( $original_post );
} else {
    wp_reset_postdata();
}
?>