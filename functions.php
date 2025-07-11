<?php

if ( ! function_exists( 'futstream_setup' ) ) :
    /**
     * Configurações iniciais do tema.
     * Registra menus, suportes a recursos do tema, etc.
     */
    function futstream_setup() {
        // Suporte para miniaturas (featured images)
        add_theme_support( 'post-thumbnails' );

        // Registra menus de navegação
        register_nav_menus( array(
            'primary' => __( 'Menu Principal', 'futstream' ),
        ) );

        // Suporte a HTML5 para formulários de busca, comentários, galerias e legendas.
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        // Adiciona suporte para o título do site via add_theme_support().
        add_theme_support( 'title-tag' );

        // Adiciona suporte para blocos de alinhamento amplo e completo
        add_theme_support( 'align-wide' );

        // Adiciona suporte para cores personalizadas no editor
        add_theme_support(
            'editor-color-palette',
            array(
                array(
                    'name'  => __( 'Azul Principal', 'futstream' ),
                    'slug'  => 'primary-blue',
                    'color' => '#0056b3',
                ),
                array(
                    'name'  => __( 'Verde Futebol', 'futstream' ),
                    'slug'  => 'football-green',
                    'color' => '#28a745',
                ),
                array(
                    'name'  => __( 'Branco', 'futstream' ),
                    'slug'  => 'white',
                    'color' => '#ffffff',
                ),
                array(
                    'name'  => __( 'Cinza Escuro', 'futstream' ),
                    'slug'  => 'dark-gray',
                    'color' => '#333333',
                ),
            )
        );
    }
endif;
add_action( 'after_setup_theme', 'futstream_setup' );

/**
 * Enfileira scripts e estilos para o tema.
 */
function futstream_scripts() {
    // Enfileira o style.css principal
    wp_enqueue_style( 'futstream-style', get_stylesheet_uri() );

    // Exemplo de como enfileirar um script JS (se você tiver um)
    // wp_enqueue_script( 'futstream-main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'futstream_scripts' );

/**
 * Registra Custom Post Types (CPTs) e Taxonomias.
 */
function futstream_register_custom_types() {
    // CPT: Jogo
    $labels_game = array(
        'name'                  => _x( 'Jogos', 'Post Type General Name', 'futstream' ),
        'singular_name'         => _x( 'Jogo', 'Post Type Singular Name', 'futstream' ),
        'menu_name'             => __( 'Jogos', 'futstream' ),
        'name_admin_bar'        => __( 'Jogo', 'futstream' ),
        'add_new'               => __( 'Adicionar Novo', 'futstream' ),
        'add_new_item'          => __( 'Adicionar Novo Jogo', 'futstream' ),
        'new_item'              => __( 'Novo Jogo', 'futstream' ),
        'edit_item'             => __( 'Editar Jogo', 'futstream' ),
        'view_item'             => __( 'Ver Jogo', 'futstream' ),
        'all_items'             => __( 'Todos os Jogos', 'futstream' ),
        'search_items'          => __( 'Buscar Jogos', 'futstream' ),
        'parent_item_colon'     => __( 'Jogo Pai:', 'futstream' ),
        'not_found'             => __( 'Nenhum jogo encontrado.', 'futstream' ),
        'not_found_in_trash'    => __( 'Nenhum jogo encontrado na lixeira.', 'futstream' ),
        'featured_image'        => _x( 'Imagem do Jogo', 'Overrides the "Featured Image" phrase for this post type. Added in 4.3', 'futstream' ),
        'set_featured_image'    => _x( 'Definir imagem do jogo', 'Overrides the "Set featured image" phrase for this post type. Added in 4.3', 'futstream' ),
        'remove_featured_image' => _x( 'Remover imagem do jogo', 'Overrides the "Remove featured image" phrase for this post type. Added in 4.3', 'futstream' ),
        'use_featured_image'    => _x( 'Usar como imagem do jogo', 'Overrides the "Use as featured image" phrase for this post type. Added in 4.4', 'futstream' ),
        'archives'              => _x( 'Arquivos de Jogos', 'The post type archive label used in nav menus. Default "Post Archives". Added in 4.4', 'futstream' ),
        'insert_into_item'      => _x( 'Inserir no jogo', 'Overrides the "Insert into post"/"Insert into page" phrase (used when inserting media into a post). Added in 4.4', 'futstream' ),
        'uploaded_to_this_item' => _x( 'Enviado para este jogo', 'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase (used when viewing media attached to a post). Added in 4.4', 'futstream' ),
        'filter_items_list'     => _x( 'Filtrar lista de jogos', 'Screen reader text for the filter links on the list table. Added in 4.4', 'futstream' ),
        'items_list_navigation' => _x( 'Navegação da lista de jogos', 'Screen reader text for the pagination links on the list table. Added in 4.4', 'futstream' ),
        'items_list'            => _x( 'Lista de jogos', 'Screen reader text for the items list. Added in 4.4', 'futstream' ),
    );
    $args_game = array(
        'label'                 => __( 'Jogo', 'futstream' ),
        'description'           => __( 'Informações sobre partidas de futebol', 'futstream' ),
        'labels'                => $labels_game,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-video-alt3',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Para o editor de blocos (Gutenberg)
    );
    register_post_type( 'game', $args_game );

    // Taxonomia: Campeonato (para CPT Jogo)
    $labels_championship = array(
        'name'                       => _x( 'Campeonatos', 'Taxonomy General Name', 'futstream' ),
        'singular_name'              => _x( 'Campeonato', 'Taxonomy Singular Name', 'futstream' ),
        'menu_name'                  => __( 'Campeonatos', 'futstream' ),
        'all_items'                  => __( 'Todos os Campeonatos', 'futstream' ),
        'parent_item'                => __( 'Campeonato Pai', 'futstream' ),
        'parent_item_colon'          => __( 'Campeonato Pai:', 'futstream' ),
        'new_item_name'              => __( 'Novo Nome de Campeonato', 'futstream' ),
        'add_new_item'               => __( 'Adicionar Novo Campeonato', 'futstream' ),
        'edit_item'                  => __( 'Editar Campeonato', 'futstream' ),
        'update_item'                => __( 'Atualizar Campeonato', 'futstream' ),
        'view_item'                  => __( 'Ver Campeonato', 'futstream' ),
        'separate_items_with_commas' => __( 'Separar campeonatos com vírgulas', 'futstream' ),
        'add_or_remove_items'        => __( 'Adicionar ou remover campeonatos', 'futstream' ),
        'choose_from_most_used'      => __( 'Escolher entre os campeonatos mais usados', 'futstream' ),
        'popular_items'              => __( 'Campeonatos Populares', 'futstream' ),
        'search_items'               => __( 'Buscar Campeonatos', 'futstream' ),
        'not_found'                  => __( 'Nenhum campeonato encontrado', 'futstream' ),
        'no_terms'                   => __( 'Nenhum campeonato', 'futstream' ),
        'items_list'                 => __( 'Lista de campeonatos', 'futstream' ),
        'items_list_navigation'      => __( 'Navegação da lista de campeonatos', 'futstream' ),
    );
    $args_championship = array(
        'labels'                     => $labels_championship,
        'hierarchical'               => true, // true para categoria, false para tags
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true, // Para o editor de blocos (Gutenberg)
    );
    register_taxonomy( 'championship', array( 'game' ), $args_championship );

    // Taxonomia: Canal/Plataforma (para CPT Jogo)
    $labels_channel = array(
        'name'                       => _x( 'Canais', 'Taxonomy General Name', 'futstream' ),
        'singular_name'              => _x( 'Canal', 'Taxonomy Singular Name', 'futstream' ),
        'menu_name'                  => __( 'Canais', 'futstream' ),
        'all_items'                  => __( 'Todos os Canais', 'futstream' ),
        'parent_item'                => __( 'Canal Pai', 'futstream' ),
        'parent_item_colon'          => __( 'Canal Pai:', 'futstream' ),
        'new_item_name'              => __( 'Novo Nome de Canal', 'futstream' ),
        'add_new_item'               => __( 'Adicionar Novo Canal', 'futstream' ),
        'edit_item'                  => __( 'Editar Canal', 'futstream' ),
        'update_item'                => __( 'Atualizar Canal', 'futstream' ),
        'view_item'                  => __( 'Ver Canal', 'futstream' ),
        'separate_items_with_commas' => __( 'Separar canais com vírgulas', 'futstream' ),
        'add_or_remove_items'        => __( 'Adicionar ou remover canais', 'futstream' ),
        'choose_from_most_used'      => __( 'Escolher entre os canais mais usados', 'futstream' ),
        'popular_items'              => __( 'Canais Populares', 'futstream' ),
        'search_items'               => __( 'Buscar Canais', 'futstream' ),
        'not_found'                  => __( 'Nenhum canal encontrado', 'futstream' ),
        'no_terms'                   => __( 'Nenhum canal', 'futstream' ),
        'items_list'                 => __( 'Lista de canais', 'futstream' ),
        'items_list_navigation'      => __( 'Navegação da lista de canais', 'futstream' ),
    );
    $args_channel = array(
        'labels'                     => $labels_channel,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'channel', array( 'game' ), $args_channel );
}
add_action( 'init', 'futstream_register_custom_types' );

// Carregamento de textdomain
if ( ! function_exists( 'futstream_load_textdomain' ) ) {
    function futstream_load_textdomain() {
        load_theme_textdomain( 'futstream', get_template_directory() . '/languages' );
    }
}
add_action( 'after_setup_theme', 'futstream_load_textdomain' );

// Carregar arquivos de inclusão
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/widgets.php';

// Suporte a recursos modernos
function futstream_theme_setup() {
    // Suportes existentes...

    // Adicionar suporte para blocos do Gutenberg
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');

    // Suporte a WooCommerce
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'futstream_theme_setup');

// Carregar estilos e scripts de forma otimizada
function futstream_enqueue_scripts() {
    // Estilo principal
    wp_enqueue_style('futstream-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
    
    // Fontes externas
    wp_enqueue_style('futstream-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    // Scripts
    wp_enqueue_script('futstream-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);

    // Comentários
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'futstream_enqueue_scripts');

// Incluir nav walker
require_once get_template_directory() . '/inc/class-bootstrap-nav-walker.php';

// Adicionar suporte para Bootstrap (via CDN)
function futstream_bootstrap_scripts() {
    // CSS Bootstrap
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css');
    
    // JS Bootstrap (defer)
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'futstream_bootstrap_scripts');

// Adicionar meta boxes para informações do jogo
function futstream_game_meta_boxes() {
    add_meta_box(
        'futstream_game_details',
        __('Detalhes do Jogo', 'futstream'),
        'futstream_game_details_callback',
        'game',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'futstream_game_meta_boxes');

function futstream_game_details_callback($post) {
    wp_nonce_field('futstream_game_details_nonce', 'game_details_nonce');
    
    $game_date = get_post_meta($post->ID, 'game_date', true);
    $game_time = get_post_meta($post->ID, 'game_time', true);
    $game_teams = get_post_meta($post->ID, 'game_teams', true);
    $game_stream_link = get_post_meta($post->ID, 'game_stream_link', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="game_date"><?php _e('Data do Jogo', 'futstream'); ?></label></th>
            <td><input type="date" id="game_date" name="game_date" value="<?php echo esc_attr($game_date); ?>" /></td>
        </tr>
        <tr>
            <th><label for="game_time"><?php _e('Hora do Jogo', 'futstream'); ?></label></th>
            <td><input type="time" id="game_time" name="game_time" value="<?php echo esc_attr($game_time); ?>" /></td>
        </tr>
        <tr>
            <th><label for="game_teams"><?php _e('Times', 'futstream'); ?></label></th>
            <td><input type="text" id="game_teams" name="game_teams" value="<?php echo esc_attr($game_teams); ?>" /></td>
        </tr>
        <tr>
            <th><label for="game_stream_link"><?php _e('Link de Transmissão', 'futstream'); ?></label></th>
            <td><input type="url" id="game_stream_link" name="game_stream_link" value="<?php echo esc_url($game_stream_link); ?>" /></td>
        </tr>
    </table>
    <?php
}

// Salvar meta dados do jogo
function futstream_save_game_details($post_id) {
    // Verificações de segurança
    if (!isset($_POST['game_details_nonce']) || 
        !wp_verify_nonce($_POST['game_details_nonce'], 'futstream_game_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Salvar meta dados
    $meta_keys = ['game_date', 'game_time', 'game_teams', 'game_stream_link'];
    
    foreach ($meta_keys as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
        }
    }
}
add_action('save_post_game', 'futstream_save_game_details');

// Adicionar colunas personalizadas na listagem de jogos
function futstream_game_columns($columns) {
    $columns['game_date'] = __('Data do Jogo', 'futstream');
    $columns['game_time'] = __('Hora do Jogo', 'futstream');
    $columns['championships'] = __('Campeonatos', 'futstream');
    return $columns;
}
add_filter('manage_game_posts_columns', 'futstream_game_columns');

function futstream_game_column_content($column, $post_id) {
    switch ($column) {
        case 'game_date':
            echo get_post_meta($post_id, 'game_date', true);
            break;
        case 'game_time':
            echo get_post_meta($post_id, 'game_time', true);
            break;
        case 'championships':
            $terms = get_the_terms($post_id, 'championship');
            if ($terms) {
                $names = wp_list_pluck($terms, 'name');
                echo implode(', ', $names);
            }
            break;
    }
}
add_action('manage_game_posts_custom_column', 'futstream_game_column_content', 10, 2);

// Personalizar excerpt
function futstream_custom_excerpt_length($length) {
    return 20; // Número de palavras no excerpt
}
add_filter('excerpt_length', 'futstream_custom_excerpt_length');

function futstream_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'futstream_excerpt_more');

// Adicionar classes ao body
function futstream_body_classes($classes) {
    // Adicionar classe de layout
    $sidebar_position = get_theme_mod('futstream_sidebar_position', 'right');
    $classes[] = 'sidebar-' . $sidebar_position;

    // Verificar se é página única
    if (is_single() || is_page()) {
        $classes[] = 'single-content';
    }

    return $classes;
}
add_filter('body_class', 'futstream_body_classes');

// Adicionar suporte a imagens destacadas
function futstream_post_thumbnails() {
    add_theme_support('post-thumbnails');
    
    // Tamanhos de imagem personalizados
    add_image_size('futstream-card', 370, 220, true);
    add_image_size('futstream-single', 800, 400, true);
}
add_action('after_setup_theme', 'futstream_post_thumbnails');

// Registrar áreas de widgets adicionais
function futstream_additional_widgets() {
    register_sidebar(array(
        'name'          => __('Barra Lateral de Posts', 'futstream'),
        'id'            => 'sidebar-posts',
        'description'   => __('Widgets para a barra lateral de posts e páginas', 'futstream'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'futstream_additional_widgets');

// Função para exibir anúncios em posts
function futstream_display_post_ads($content) {
    // Verificar se está em um post único
    if (!is_single()) return $content;

    // Recuperar configurações de anúncios
    $top_ad = get_theme_mod('futstream_single_top_ad', '');
    $middle_ad = get_theme_mod('futstream_single_middle_ad', '');
    $bottom_ad = get_theme_mod('futstream_single_bottom_ad', '');
    $middle_ad_position = get_theme_mod('futstream_middle_ad_position', 50);

    // Anúncio no topo
    if (!empty($top_ad)) {
        $content = '<div class="single-top-ad">' . $top_ad . '</div>' . $content;
    }

    // Anúncio no meio
    if (!empty($middle_ad)) {
        // Dividir o conteúdo
        $content_parts = futstream_split_content($content, $middle_ad_position);
        $content = $content_parts[0] . 
                   '<div class="single-middle-ad">' . $middle_ad . '</div>' . 
                   $content_parts[1];
    }

    // Anúncio no final
    if (!empty($bottom_ad)) {
        $content .= '<div class="single-bottom-ad">' . $bottom_ad . '</div>';
    }

    return $content;
}
add_filter('the_content', 'futstream_display_post_ads');

// Função auxiliar para dividir o conteúdo
function futstream_split_content($content, $percent) {
    $content_length = mb_strlen(strip_tags($content));
    $split_position = intval($content_length * ($percent / 100));

    $current_length = 0;
    $split_index = 0;

    // Encontrar a posição de divisão mais próxima de um parágrafo
    $paragraphs = preg_split('/(<p>|<\/p>)/', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    foreach ($paragraphs as $index => $paragraph) {
        if (strip_tags($paragraph) != '') {
            $current_length += mb_strlen(strip_tags($paragraph));
            
            if ($current_length >= $split_position) {
                $split_index = $index;
                break;
            }
        }
    }

    // Reconstruir o conteúdo
    $first_part = implode('', array_slice($paragraphs, 0, $split_index + 1));
    $second_part = implode('', array_slice($paragraphs, $split_index + 1));

    return [$first_part, $second_part];
}

// Função para exibir logo do rodapé
function futstream_footer_logo() {
    $footer_logo = get_theme_mod('futstream_footer_logo');
    
    if ($footer_logo) {
        echo '<div class="footer-logo">';
        echo '<img src="' . esc_url($footer_logo) . '" alt="' . get_bloginfo('name') . '">';
        echo '</div>';
    }
}
add_action('futstream_footer_branding', 'futstream_footer_logo');

// Incluir o painel do tema
require_once get_template_directory() . '/inc/theme-panel.php';

// Função para carregar opções do tema
function futstream_get_theme_option($section, $key, $default = '') {
    $options = get_option($section, []);
    return $options[$key] ?? $default;
}

function futstream_admin_styles() {
    wp_enqueue_style('futstream-admin-styles', get_template_directory_uri() . '/assets/css/admin-styles.css');
}
add_action('admin_enqueue_scripts', 'futstream_admin_styles');



/**
 * Suporte ao Elementor
 */
add_action('after_setup_theme', function() {
    add_theme_support('elementor');
});
