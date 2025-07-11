<?php
/**
 * Template para a exibição de um único Custom Post Type 'game'.
 * Exibe todos os detalhes de uma partida de futebol.
 */

get_header(); // Inclui o cabeçalho do tema
?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();

        // Obtenha os campos personalizados usando get_field() do ACF
        $game_date_time       = get_field( 'game_date' );
        $home_team            = get_field( 'home_team' );
        $away_team            = get_field( 'away_team' );
        $transmission_link    = get_field( 'transmission_link' );
        $game_venue           = get_field( 'game_venue' ); // LINHA DESCOMENTADA: Agora obtém o local do jogo
        $tv_station           = get_field( 'tv_station' );
        $home_team_badge      = get_field( 'home_team_badge' );
        $away_team_badge      = get_field( 'away_team_badge' );
        $highlights_video_url = get_field( 'highlights_video_url' );

        // Obtenha os termos de taxonomias
        $channel_terms      = get_the_terms( get_the_ID(), 'channel' );
        $championship_terms = get_the_terms( get_the_ID(), 'championship' );

        // Formate a data e hora para português completo usando date_i18n()
        $formatted_date_time_full = '';
        if ( $game_date_time ) {
            $timestamp = strtotime( $game_date_time ); // Converte a string de data para timestamp
            // Formato: Dia da semana por extenso, dia do mês de Mês por extenso de Ano às HH:MM
            $formatted_date_time_full = date_i18n( 'l, j \d\e F \d\e Y \à\s H:i', $timestamp );
        }
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-game-content' ); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="game-thumbnail">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="game-info">
                    <!-- Nova seção para os times e escudos, agora dentro de game-info -->
                    <div class="teams-and-badges-display">
                        <div class="team-display home-team-display">
                            <?php if ( $home_team_badge ) : ?>
                                <img src="<?php echo esc_url( $home_team_badge ); ?>" alt="<?php echo esc_attr( $home_team ); ?> Badge">
                            <?php endif; ?>
                            <span class="team-name"><?php echo esc_html( $home_team ); ?></span>
                        </div>
                        <span class="vs-text">vs</span>
                        <div class="team-display away-team-display">
                            <?php if ( $away_team_badge ) : ?>
                                <img src="<?php echo esc_url( $away_team_badge ); ?>" alt="<?php echo esc_attr( $away_team ); ?> Badge">
                            <?php endif; ?>
                            <span class="team-name"><?php echo esc_html( $away_team ); ?></span>
                        </div>
                    </div>

                    <div class="game-details-list">
                        <?php if ( $formatted_date_time_full ) : ?>
                            <p><strong>Data e Hora:</strong> <?php echo esc_html( $formatted_date_time_full ); ?></p>
                        <?php endif; ?>

                        <?php if ( $game_venue ) : // LINHA ADICIONADA: Exibe o local do evento ?>
                            <p><strong>Local:</strong> <?php echo esc_html( $game_venue ); ?></p>
                        <?php endif; ?>

                        <?php if ( $tv_station ) : ?>
                            <p><strong>Transmissão na TV:</strong> <?php echo esc_html( $tv_station ); ?></p>
                        <?php endif; ?>

                        <?php if ( $championship_terms && ! is_wp_error( $championship_terms ) ) : ?>
                            <p><strong>Campeonato:</strong>
                                <?php foreach ( $championship_terms as $term ) : ?>
                                    <a href="<?php echo esc_url( get_term_link( $term->term_id, 'championship' ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( $channel_terms && ! is_wp_error( $channel_terms ) ) : ?>
                            <p><strong>Canais/Plataformas:</strong>
                                <?php foreach ( $channel_terms as $term ) : ?>
                                    <a href="<?php echo esc_url( get_term_link( $term->term_id, 'channel' ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <?php if ( $transmission_link ) : ?>
                        <p class="transmission-link">
                            <a href="<?php echo esc_url( $transmission_link ); ?>" target="_blank" rel="noopener noreferrer" class="button-watch">Assistir Transmissão</a>
                        </p>
                    <?php endif; ?>
                </div><!-- .game-info -->

                <div class="game-description" style="margin-top: 30px;">
                    <?php the_content(); // Conteúdo principal do post (descrição do jogo, etc.) ?>
                </div>

                <?php if ( $highlights_video_url ) : ?>
                    <h3 style="margin-top: 30px;">Melhores Momentos</h3>
                    <?php
                    if ( strpos( $highlights_video_url, 'youtube.com' ) !== false || strpos( $highlights_video_url, 'youtu.be' ) !== false ) {
                        parse_str( parse_url( $highlights_video_url, PHP_URL_QUERY ), $youtube_vars );
                        $video_id = $youtube_vars['v'] ?? '';
                        if ( ! empty( $video_id ) ) {
                            echo '<div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; background: #000;">';
                            echo '<iframe src="https://www.youtube.com/embed/' . esc_attr( $video_id ) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>';
                            echo '</div>';
                        } else {
                            echo '<p class="highlights-link"><a href="' . esc_url( $highlights_video_url ) . '" target="_blank" rel="nofollow">Assista aos Melhores Momentos</a></p>';
                        }
                    } else {
                        echo '<p class="highlights-link"><a href="' . esc_url( $highlights_video_url ) . '" target="_blank" rel="nofollow">Assista aos Melhores Momentos</a></p>';
                    }
                    ?>
                <?php endif; ?>

            </div><!-- .entry-content -->

            <footer class="entry-footer">
                <?php
                the_post_navigation(
                    array(
                        'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Anterior:', 'futstream' ) . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Próximo:', 'futstream' ) . '</span> <span class="nav-title">%title</span>',
                    )
                );
                ?>
            </footer><!-- .entry-footer -->
        </article><!-- #post-<?php the_ID(); ?> -->

        <?php
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;

    endwhile; // Fim do loop
    ?>
</main><!-- #main -->

<?php
get_footer(); // Inclui o rodapé do tema
?>
