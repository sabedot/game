<footer id="colophon" class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <?php 
                // Exibe logo do rodapé
                do_action('futstream_footer_branding'); 
                ?>

                <div class="footer-widgets">
                    <?php dynamic_sidebar('footer-sidebar'); ?>
                </div>

                <div class="site-info">
                    <?php 
                    $copyright_text = get_theme_mod('futstream_copyright_text', 
                        sprintf('© %s %s. Todos os direitos reservados.', date('Y'), get_bloginfo('name'))
                    );
                    echo wp_kses_post($copyright_text); 
                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>
