<?php
get_header();

// Configurações de layout
$sidebar_position = get_theme_mod('futstream_sidebar_position', 'right');
$content_class = ($sidebar_position !== 'none') ? 'col-md-8' : 'col-md-12';
?>

<div class="container-fluid futstream-archive">
    <div class="row">
        <?php if ($sidebar_position === 'left') : ?>
            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($content_class); ?>">
            <main id="primary" class="site-main">
                <?php 
                // Título do arquivo
                the_archive_title('<header class="page-header"><h1 class="page-title">', '</h1></header>');
                
                // Descrição do arquivo
                the_archive_description('<div class="archive-description">', '</div>');
                ?>

                <div class="row blog-grid">
                    <?php 
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            ?>
                            <div class="col-md-4 mb-4">
                                <?php get_template_part('template-parts/content', 'card'); ?>
                            </div>
                            <?php
                        endwhile;

                        // Paginação
                        the_posts_pagination(array(
                            'mid_size'  => 2,
                            'prev_text' => __('Anterior', 'futstream'),
                            'next_text' => __('Próximo', 'futstream'),
                            'class'     => 'pagination justify-content-center',
                        ));

                    else :
                        get_template_part('template-parts/content', 'none');
                    endif;
                    ?>
                </div>
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
