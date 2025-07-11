<?php
class Futstream_Game_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'futstream_game_widget',
            __('Futstream - Jogos Próximos', 'futstream'),
            array('description' => __('Exibe próximos jogos', 'futstream'))
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title'] ?? '');
        
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // Query para buscar jogos próximos
        $games_query = new WP_Query(array(
            'post_type' => 'game',
            'posts_per_page' => $instance['number'] ?? 5,
            'meta_key' => 'game_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'game_date',
                    'value' => date('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            )
        ));

        if ($games_query->have_posts()) :
            echo '<ul class="futstream-upcoming-games">';
            while ($games_query->have_posts()) : $games_query->the_post();
                ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                        <?php // Adicionar meta de data/hora ?>
                    </a>
                </li>
                <?php
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        endif;

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = $instance['title'] ?? __('Próximos Jogos', 'futstream');
        $number = $instance['number'] ?? 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Título:', 'futstream'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">
                <?php _e('Número de Jogos:', 'futstream'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo $this->get_field_id('number'); ?>" 
                   name="<?php echo $this->get_field_name('number'); ?>" 
                   type="number" 
                   value="<?php echo esc_attr($number); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? 
            sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? 
            absint($new_instance['number']) : 5;
        return $instance;
    }
}

function futstream_register_widgets() {
    register_widget('Futstream_Game_Widget');
}
add_action('widgets_init', 'futstream_register_widgets');

// Registrar áreas de widgets
function futstream_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar Principal', 'futstream'),
        'id'            => 'sidebar-1',
        'description'   => __('Adicione widgets para a sidebar principal', 'futstream'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Rodapé - Coluna 1', 'futstream'),
        'id'            => 'footer-1',
        'description'   => __('Widgets para a primeira coluna do rodapé', 'futstream'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'futstream_widgets_init');
