<?php
namespace Starter\Theme;

defined('ABSPATH') || exit;
        
$fields = \Starter\Theme\ph_get_data();
if (empty($fields['enabled'])) {
    return;
}

$style = sprintf(
    'background-image:linear-gradient(to bottom, rgba(0,0,0,%s),rgba(0,0,0,%s)),url(%s);',
    esc_attr((string) $fields['overlay']),
    esc_attr((string) $fields['overlay']),
    esc_url($fields['bg_url'])
);
?>

<section class="pageheader" style="<?php echo $style; ?>">
    <div class="container pageheader__inner">
        <?php if (!empty($fields['kicker'])): ?>
            <p class="pageheader__kicker"><?php echo esc_html($fields['kicker']); ?></p>
        <?php endif; ?>

        <h1 class="pageheader__title"><?php echo esc_html($fields['title']); ?></h1>

        <?php if (!empty($fields['subtitle'])): ?>
            <p class="pageheader__subtitle"><?php echo esc_html($fields['subtitle']); ?></p>
        <?php endif; ?>

        <?php if (!empty($fields['breadcrumbs'])): ?>
            <div class="pageheader__breadcrumbs">
                <?php \Starter\Theme\render_breadcrumbs(); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($fields['show_form']) && !empty($fields['form_id'])): ?>
            <div class="pageheader__form">
                <?php echo do_shortcode('[gravityform id="' . esc_attr($fields['form_id']) . '" title="false" description="false" ajax="true"]'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>