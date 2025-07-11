<?php
/**
 * Template Name: Elementor Full Width
 * Template Post Type: page
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    wp_footer();
    ?>
</body>
</html>