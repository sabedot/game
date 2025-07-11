<?php
get_header();

// Configurações de layout
$sidebar_position = get_theme_mod('futstream_sidebar_position', 'right');
$content_class = ($sidebar_position !== 'none') ? 'col-md-8' : 'col-md-12';
?>

<div class="container-fluid futstream-single-post">
    <div class="row">
        <?php if ($sidebar_position === 'left') : ?>
            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($content_class); ?>">
            <main id="primary" class="site-main">
                <?php 
                while (have_posts()) : the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php 
                            // Categorias
                            $categories = get_the_category();
                            if (!empty($categories)) {
                                echo '<div class="post-categories mb-3">';
                                foreach ($categories as $category) {
                                    echo '<span class="badge bg-primary me-2">' . 
                                         esc_html($category->name) . 
                                         '</span>';
                                }
                                echo '</div>';
                            }
                            ?>

                            <h1 class="entry-title"><?php the_title(); ?></h1>

                            <div class="entry-meta d-flex justify-content-between mb-3">
                                <span class="author vcard">
                                    <i class="fas fa-user"></i> 
                                    <?php the_author_posts_link(); ?>
                                </span>
                                <span class="posted-on">
                                    <i class="fas fa-calendar"></i> 
                                    <?php echo get_the_date(); ?>
                                </span>
                            </div>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <figure class="post-thumbnail mb-4">
                                <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded']); ?>
                            </figure>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php 
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . __('Páginas:', 'futstream'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <footer class="entry-footer">
                            <?php 
                            // Tags
                            $tags = get_the_tags();
                            if ($tags) {
                                echo '<div class="tags-links">';
                                foreach ($tags as $tag) {
                                    echo '<a href="' . get_tag_link($tag->term_id) . '" class="badge bg-secondary me-2">' . 
                                         esc_html($tag->name) . 
                                         '</a>';
                                }
                                echo '</div>';
                            }
                            ?>
                        </footer>
                    </article>

                    <?php
                    // Navegação entre posts
                    the_post_navigation(array(
                        'prev_text' => '<span class="nav-subtitle">' . __('Anterior:', 'futstream') . '</span> ' .
                                       '<span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . __('Próximo:', 'futstream') . '</span> ' .
                                       '<span class="nav-title">%title</span>',
                    ));

                    // Comentários
                    if (comments_open() || get_comments_number()) {
                        comments_template();
                    }

                endwhile;
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
