<?php
function futstream_customize_register($wp_customize) {
    // Painel Principal do Tema
    $wp_customize->add_panel('futstream_theme_options', [
        'title' => __('Futstream Theme Options', 'futstream'),
        'description' => __('Opções de personalização completa do tema', 'futstream'),
        'priority' => 10,
    ]);

    // Seções anteriores mantidas igual...

    // Opções de Logo no Rodapé
    $wp_customize->add_setting('futstream_footer_logo', [
        'sanitize_callback' => 'esc_url_raw'
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'futstream_footer_logo',
            [
                'label' => __('Logo do Rodapé', 'futstream'),
                'section' => 'futstream_footer_options',
                'settings' => 'futstream_footer_logo'
            ]
        )
    );

    // Opções de Anúncios em Artigos
    $wp_customize->add_section('futstream_single_post_ads', [
        'title' => __('Anúncios em Artigos', 'futstream'),
        'panel' => 'futstream_theme_options',
    ]);

    // Anúncio no Topo do Artigo
    $wp_customize->add_setting('futstream_single_top_ad', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post'
    ]);

    $wp_customize->add_control('futstream_single_top_ad', [
        'type' => 'textarea',
        'label' => __('Código de Anúncio no Topo do Artigo', 'futstream'),
        'section' => 'futstream_single_post_ads'
    ]);

    // Anúncio no Meio do Artigo
    $wp_customize->add_setting('futstream_single_middle_ad', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post'
    ]);

    $wp_customize->add_control('futstream_single_middle_ad', [
        'type' => 'textarea',
        'label' => __('Código de Anúncio no Meio do Artigo', 'futstream'),
        'section' => 'futstream_single_post_ads'
    ]);

    // Posição do Anúncio no Meio
    $wp_customize->add_setting('futstream_middle_ad_position', [
        'default' => '50',
        'sanitize_callback' => 'absint'
    ]);

    $wp_customize->add_control('futstream_middle_ad_position', [
        'type' => 'number',
        'label' => __('Posição do Anúncio no Meio (% do conteúdo)', 'futstream'),
        'section' => 'futstream_single_post_ads',
        'input_attrs' => [
            'min' => 10,
            'max' => 90,
            'step' => 10
        ]
    ]);

    // Anúncio no Final do Artigo
    $wp_customize->add_setting('futstream_single_bottom_ad', [
        'default' => '',
        'sanitize_callback' => 'wp_kses_post'
    ]);

    $wp_customize->add_control('futstream_single_bottom_ad', [
        'type' => 'textarea',
        'label' => __('Código de Anúncio no Final do Artigo', 'futstream'),
        'section' => 'futstream_single_post_ads'
    ]);
}
add_action('customize_register', 'futstream_customize_register');

// Gerar CSS Dinâmico
function futstream_dynamic_css() {
    $primary_color = get_theme_mod('primary_color', '#0056b3');
    $secondary_color = get_theme_mod('secondary_color', '#28a745');
    $text_color = get_theme_mod('text_color', '#333333');
    $background_color = get_theme_mod('background_color', '#ffffff');
    $primary_font = get_theme_mod('futstream_primary_font', 'Roboto');

    $custom_css = "
    :root {
        --futstream-primary: {$primary_color};
        --futstream-secondary: {$secondary_color};
        --futstream-text: {$text_color};
        --futstream-background: {$background_color};
    }

    body {
        font-family: '{$primary_font}', sans-serif;
        color: {$text_color};
        background-color: {$background_color};
    }

    .btn-primary {
        background-color: {$primary_color};
        border-color: {$primary_color};
    }

    .btn-secondary {
        background-color: {$secondary_color};
        border-color: {$secondary_color};
    }
    ";

    wp_add_inline_style('futstream-main-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'futstream_dynamic_css');
