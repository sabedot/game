<?php
function futstream_custom_home_query() {
    // Opções para personalizar a exibição de posts na home
    $show_posts = get_theme_mod('futstream_home_posts_display', true);
    $posts_type = get_theme_mod('futstream_home_posts_type', 'recent');
    $posts_limit = get_theme_mod('futstream_home_posts_limit', 6);

    if (!$show_posts) return;

    $args = [
        'posts_per_page' => $posts_limit,
        'post_status' => 'publish'
    ];

    switch ($posts_type) {
        case 'popular':
            $args['orderby'] = 'comment_count';
            break;
        case 'featured':
            $args['meta_key'] = 'futstream_featured_post';
            $args['meta_value'] = '1';
            break;
        default:
            $args['orderby'] = 'date';
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        ?>
        <section class="home-posts container my-5">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title text-center mb-4">
                        <?php _e('Últimas Notícias', 'futstream'); ?>
                    </h2>
                </div>
                <?php 
                while ($query->have_posts()) : $query->the_post();
                    ?>
                    <div class="col-md-4 mb-4">
                        <?php get_template_part('template-parts/content', 'card'); ?>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </section>
        <?php
    endif;
}
add_action('futstream_home_content', 'futstream_custom_home_query');

// Adicionar opções no customizador para posts da home
function futstream_home_posts_customizer($wp_customize) {
    $wp_customize->add_section('futstream_home_posts', [
        'title' => __('Posts na Página Inicial', 'futstream'),
        'panel' => 'futstream_theme_options'
    ]);

    $wp_customize->add_setting('futstream_home_posts_display', [
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean'
    ]);

    $wp_customize->add_control('futstream_home_posts_display', [
        'type' => 'checkbox',
        'label' => __('Exibir Posts na Página Inicial', 'futstream'),
        'section' => 'futstream_home_posts'
    ]);

    $wp_customize->add_setting('futstream_home_posts_type', [
        'default' => 'recent',
        'sanitize_callback' => 'sanitize_text_field'
    ]);

    $wp_customize->add_control('futstream_home_posts_type', [
        'type' => 'select',
        'label' => __('Tipo de Posts', 'futstream'),
        'section' => 'futstream_home_posts',
        'choices' => [
            'recent' => __('Mais Recentes', 'futstream'),
            'popular' => __('Mais Populares', 'futstream'),
            'featured' => __('Destacados', 'futstream')
        ]
    ]);

    $wp_customize->add_setting('futstream_home_posts_limit', [
        'default' => 6,
        'sanitize_callback' => 'absint'
    ]);

    $wp_customize->add_control('futstream_home_posts_limit', [
        'type' => 'number',
        'label' => __('Número de Posts', 'futstream'),
        'section' => 'futstream_home_posts',
        'input_attrs' => [
            'min' => 3,
            'max' => 12
        ]
    ]);
}
add_action('customize_register', 'futstream_home_posts_customizer');
