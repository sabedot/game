<?php
// Obter metadados do jogo
$game_date = get_post_meta(get_the_ID(), 'game_date', true);
$game_time = get_post_meta(get_the_ID(), 'game_time', true);
$game_teams = get_post_meta(get_the_ID(), 'game_teams', true);
$game_stream_link = get_post_meta(get_the_ID(), 'game_stream_link', true);

// Obter taxonomias
$championships = get_the_terms(get_the_ID(), 'championship');
$channels = get_the_terms(get_the_ID(), 'channel');
?>

<div class="card game-card">
    <?php if (has_post_thumbnail()) : ?>
        <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
    <?php endif; ?>

    <div class="card-body">
        <h5 class="card-title"><?php the_title(); ?></h5>
        
        <div class="game-meta">
            <?php if ($game_date) : ?>
                <p class="game-date">
                    <i class="fas fa-calendar"></i> 
                    <?php echo date_i18n('D, d/m/Y', strtotime($game_date)); ?>
                </p>
            <?php endif; ?>

            <?php if ($game_time) : ?>
                <p class="game-time">
                    <i class="fas fa-clock"></i> 
                    <?php echo esc_html($game_time); ?>
                </p>
            <?php endif; ?>

            <?php if ($championships) : ?>
                <p class="game-championship">
                    <i class="fas fa-trophy"></i>
                    <?php 
                    $champ_names = wp_list_pluck($championships, 'name');
                    echo esc_html(implode(', ', $champ_names)); 
                    ?>
                </p>
            <?php endif; ?>

            <?php if ($channels) : ?>
                <p class="game-channels">
                    <i class="fas fa-tv"></i>
                    <?php 
                    $channel_names = wp_list_pluck($channels, 'name');
                    echo esc_html(implode(', ', $channel_names)); 
                    ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if ($game_stream_link) : ?>
            <a href="<?php echo esc_url($game_stream_link); ?>" 
               class="btn btn-primary btn-stream" 
               target="_blank">
                <?php _e('Assistir Agora', 'futstream'); ?>
            </a>
        <?php endif; ?>
    </div>
</div>
