<?php
/**
 * Template para o arquivo de Custom Post Type 'game'.
 * Exibe uma lista de todos os jogos.
 */

get_header(); // Inclui o cabeçalho do tema
?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title">
            <?php
            post_type_archive_title( '', true ); // Exibe o título do arquivo do CPT (ex: "Jogos")
            ?>
        </h1>
    </header><!-- .page-header -->

    <div class="game-archive-list">
        <?php
        if ( have_posts() ) :
            /* Inicia o Loop */
            while ( have_posts() ) :
                the_post();

                // Obtenha os campos personalizados (assumindo que existem)
                $game_date_time = get_post_meta( get_the_ID(), 'game_date', true );
                $home_team      = get_post_meta( get_the_ID(), 'home_team', true );
                $away_team      = get_post_meta( get_the_ID(), 'away_team', true );
                $championship_terms = get_the_terms( get_the_ID(), 'championship' );
                $championship_name = ! empty( $championship_terms ) ? $championship_terms[0]->name : '';

                // Formate a data e hora
                $date_obj = new DateTime( $game_date_time );
                $formatted_date = $date_obj->format( 'd/m/Y' );
                $formatted_time = $date_obj->format( 'H:i' );
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'game-archive-item' ); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php if ( $championship_name ) : ?>
                            <p class="game-championship"><?php echo esc_html( $championship_name ); ?></p>
                        <?php endif; ?>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p class="game-teams"><?php echo esc_html( $home_team ); ?> vs <?php echo esc_html( $away_team ); ?></p>
                        <p class="game-datetime">Data: <?php echo esc_html( $formatted_date ); ?> - Hora: <?php echo esc_html( $formatted_time ); ?></p>
                        <?php the_excerpt(); // Exibe um resumo do conteúdo ?>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e( 'Ver Detalhes', 'futstream' ); ?></a>
                    </footer><!-- .entry-footer -->
                </article><!-- #post-<?php the_ID(); ?> -->
                <?php

            endwhile;

            the_posts_navigation(); // Navegação de paginação

        else :
            // Se nenhum jogo for encontrado
            ?>
            <p><?php esc_html_e( 'Nenhum jogo encontrado.', 'futstream' ); ?></p>
            <?php
        endif;
        ?>
    </div>

</main><!-- #main -->

<?php
get_footer(); // Inclui o rodapé do tema
?>
