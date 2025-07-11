<?php
get_header();

// Verificar layout baseado no customizador
$sidebar_position = get_theme_mod('futstream_sidebar_position', 'right');
$content_class = ($sidebar_position !== 'none') ? 'col-md-8' : 'col-md-12';
?>

<div class="container-fluid futstream-main-content">
    <div class="row">
        <?php if ($sidebar_position === 'left') : ?>
            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($content_class); ?>">
            <main id="primary" class="site-main">
                <?php 
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        // Usar template parts para modularidade
                        get_template_part('template-parts/content', get_post_type());
                    endwhile;

                    // Navegação entre páginas
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('Anterior', 'futstream'),
                        'next_text' => __('Próximo', 'futstream'),
                    ));

                else :
                    // Conteúdo quando não há posts
                    get_template_part('template-parts/content', 'none');
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
