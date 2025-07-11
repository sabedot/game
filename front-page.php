<?php
/**
 * Template para a página inicial do tema FutStream.
 * Exibe um calendário dos próximos jogos.
 */

get_header(); // Inclui o cabeçalho do tema
?>

<main id="primary" class="site-main">
    <section class="upcoming-games">

    <main id="primary" class="site-main">
    <section class="upcoming-games">
        <h2 class="section-title"><?php esc_html_e( 'Próximos Jogos', 'futstream' ); ?></h2>

        <?php
        // Query para buscar os próximos jogos (CPT 'game')
        $args = array(
            'post_type'      => 'game',
            'posts_per_page' => 10, // Quantidade de jogos a exibir
            'meta_key'       => 'game_date', // Campo personalizado para a data do jogo
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
            'meta_query'     => array(
                array(
                    'key'     => 'game_date',
                    'value'   => date('Y-m-d H:i:s'), // Apenas jogos a partir da data/hora atual
                    'compare' => '>=',
                    'type'    => 'DATETIME',
                ),
            ),
        );

        $upcoming_games = new WP_Query( $args );

        if ( $upcoming_games->have_posts() ) :
            echo '<div class="game-list">';
            while ( $upcoming_games->have_posts() ) : $upcoming_games->the_post();
                // ... (seu código existente para exibir os jogos do CPT 'game') ...
                // Obtenha os campos personalizados
                $game_date_time = get_post_meta( get_the_ID(), 'game_date', true ); // Ex: '2025-07-15 20:00:00'
                $home_team      = get_post_meta( get_the_ID(), 'home_team', true );
                $away_team      = get_post_meta( get_the_ID(), 'away_team', true );
                $transmission_link = get_post_meta( get_the_ID(), 'transmission_link', true );
                $championship_terms = get_the_terms( get_the_ID(), 'championship' );
                $championship_name = ! empty( $championship_terms ) ? $championship_terms[0]->name : '';

                // Formate a data e hora
                $date_obj = new DateTime( $game_date_time );
                $formatted_date = $date_obj->format( 'd/m/Y' );
                $formatted_time = $date_obj->format( 'H:i' );
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'game-item' ); ?>>
                    <header class="game-header">
                        <h3 class="game-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php if ( $championship_name ) : ?>
                            <p class="game-championship"><?php echo esc_html( $championship_name ); ?></p>
                        <?php endif; ?>
                    </header>
                    <div class="game-details">
                        <p class="game-teams"><?php echo esc_html( $home_team ); ?> vs <?php echo esc_html( $away_team ); ?></p>
                        <p class="game-datetime">Data: <?php echo esc_html( $formatted_date ); ?> - Hora: <?php echo esc_html( $formatted_time ); ?></p>
                        <?php if ( $transmission_link ) : ?>
                            <p class="game-transmission"><a href="<?php echo esc_url( $transmission_link ); ?>" target="_blank" rel="noopener noreferrer">Assistir Transmissão</a></p>
                        <?php endif; ?>
                    </div>
                </article>
                <?php
            endwhile;
            echo '</div>';
            wp_reset_postdata(); // Reseta a query original do WordPress
        else :
            ?>
            <p><?php esc_html_e( 'Nenhum jogo futuro encontrado no momento.', 'futstream' ); ?></p>
            <?php
        endif;
        ?>
    </section>

    <?php
    /**
     * Hook para adicionar conteúdo após a seção de "Próximos Jogos".
     * O plugin FutStream ESPN Games Integration usará este hook.
     */
    do_action( 'futstream_after_upcoming_games' );
    ?>

    <!-- Você pode adicionar outras seções aqui, como "Campeonatos em Destaque" ou "Times Populares" -->

</main><!-- #main -->

        <h2 class="section-title"><?php esc_html_e( 'Próximos Jogos', 'futstream' ); ?></h2>

        <?php
        // Query para buscar os próximos jogos (CPT 'game')
        $args = array(
            'post_type'      => 'game',
            'posts_per_page' => 10, // Quantidade de jogos a exibir
            'meta_key'       => 'game_date', // Campo personalizado para a data do jogo
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
            'meta_query'     => array(
                array(
                    'key'     => 'game_date',
                    'value'   => date('Y-m-d H:i:s'), // Apenas jogos a partir da data/hora atual
                    'compare' => '>=',
                    'type'    => 'DATETIME',
                ),
            ),
        );

        $upcoming_games = new WP_Query( $args );

        

        if ( $upcoming_games->have_posts() ) :
            echo '<div class="game-list">';
            while ( $upcoming_games->have_posts() ) : $upcoming_games->the_post();
                // Obtenha os campos personalizados
                $game_date_time = get_post_meta( get_the_ID(), 'game_date', true ); // Ex: '2025-07-15 20:00:00'
                $home_team      = get_post_meta( get_the_ID(), 'home_team', true );
                $away_team      = get_post_meta( get_the_ID(), 'away_team', true );
                $transmission_link = get_post_meta( get_the_ID(), 'transmission_link', true );
                $championship_terms = get_the_terms( get_the_ID(), 'championship' );
                $championship_name = ! empty( $championship_terms ) ? $championship_terms[0]->name : '';

                // Formate a data e hora
                $date_obj = new DateTime( $game_date_time );
                $formatted_date = $date_obj->format( 'd/m/Y' );
                $formatted_time = $date_obj->format( 'H:i' );
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'game-item' ); ?>>
                    <header class="game-header">
                        <h3 class="game-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php if ( $championship_name ) : ?>
                            <p class="game-championship"><?php echo esc_html( $championship_name ); ?></p>
                        <?php endif; ?>
                    </header>
                    <div class="game-details">
                        <p class="game-teams"><?php echo esc_html( $home_team ); ?> vs <?php echo esc_html( $away_team ); ?></p>
                        <p class="game-datetime">Data: <?php echo esc_html( $formatted_date ); ?> - Hora: <?php echo esc_html( $formatted_time ); ?></p>
                        <?php if ( $transmission_link ) : ?>
                            <p class="game-transmission"><a href="<?php echo esc_url( $transmission_link ); ?>" target="_blank" rel="noopener noreferrer">Assistir Transmissão</a></p>
                        <?php endif; ?>
                    </div>
                </article>
                <?php
            endwhile;
            echo '</div>';
            wp_reset_postdata(); // Reseta a query original do WordPress
        else :
            ?>
            <p><?php esc_html_e( 'Nenhum jogo futuro encontrado no momento.', 'futstream' ); ?></p>
            <?php
        endif;
        ?>
    </section>

    <!-- Você pode adicionar outras seções aqui, como "Campeonatos em Destaque" ou "Times Populares" -->

</main><!-- #main -->

<?php
get_footer(); // Inclui o rodapé do tema

// No frontpage.php, adicione um log ou debug
if ( $upcoming_games->have_posts() ) {
    error_log('Número de posts: ' . $upcoming_games->post_count);
}
?>


