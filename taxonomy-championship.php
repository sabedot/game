<?php
get_header();

// Configurações de layout
$sidebar_position = get_theme_mod('futstream_sidebar_position', 'right');
$content_class = ($sidebar_position !== 'none') ? 'col-md-8' : 'col-md-12';
?>

<div class="container-fluid futstream-taxonomy-archive">
    <div class="row">
        <?php if ($sidebar_position === 'left') : ?>
            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($content_class); ?>">
            <main id="primary" class="site-main">
                <?php 
                // Título da taxonomia
                $term = get_queried_object();
                ?>
                <header class="page-header">
                    <h1 class="page-title">
                        <?php 
                        echo esc_html($term->name); 
                        if (!empty($term->description)) {
                            echo '<small class="taxonomy-description">' . esc_html($term->description) . '</small>';
                        }
                        ?>
                    </h1>
                </header>

                <?php 
                // Query personalizada para jogos desta taxonomia
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'game',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'championship',
                            'field'    => 'slug',
                            'terms'    => $term->slug,
                        ),
                    ),
                    'posts_per_page' => 12,
                    'paged' => $paged
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    ?>
                    <div class="row game-grid">
                        <?php 
                        while ($query->have_posts()) : $query->the_post();
                            ?>
                            <div class="col-md-4 mb-4">
                                <?php get_template_part('template-parts/content', 'game-card'); ?>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>

                    <?php
                    // Paginação
                    echo '<div class="pagination justify-content-center">';
                    echo paginate_links(array(
                        'total' => $query->max_num_pages,
                        'current' => $paged,
                        'prev_text' => __('&laquo; Anterior', 'futstream'),
                        'next_text' => __('Próximo &raquo;', 'futstream'),
                    ));
                    echo '</div>';

                    wp_reset_postdata();

                else :
                    ?>
                    <div class="alert alert-info">
                        <?php _e('Nenhum jogo encontrado neste campeonato.', 'futstream'); ?>
                    </div>
                    <?php
                endif;
                ?>
            </main>
        </div>

        <?php if ($sidebar_position === 'right') : ?>
            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
