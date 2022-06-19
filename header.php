<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php
    if (!function_exists('_wp_render_title_tag')) {
        function theme_slug_render_title()
        {
            ?>
            <title><?php wp_title('|', true, 'right'); ?></title>
            <?php
        }

        add_action('wp_head', 'theme_slug_render_title');
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="<?php echo cs_get_option('color-site'); ?>">
    <?php if (!cs_get_option('is_seo_plugin')): ?>
        <meta name="description" content="<?php echo cs_get_option('desc'); ?>">
        <meta name="keywords" content="<?php echo cs_get_option('keywords'); ?>">
    <?php endif; ?>
    <link rel="icon"
          href="<?php echo (cs_get_option('favicon')) ? wp_get_attachment_url(cs_get_option('favicon')) : WF_URI . '/assets/img/favicon.png'; ?>"
          type="image/gif" sizes="32x32">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
get_template_part('template/header/header-one');
