<?php
class FutstreamThemePanel {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_theme_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_theme_page() {
        add_menu_page(
            'Futstream Theme',    // Page title
            'Futstream Options',  // Menu title
            'manage_options',     // Capability
            'futstream-theme',    // Menu slug
            [$this, 'render_theme_page'], // Callback function
            'dashicons-admin-generic', // Icon
            99 // Position
        );

        // Submenus
        add_submenu_page(
            'futstream-theme',
            'Configurações Gerais',
            'Configurações Gerais',
            'manage_options',
            'futstream-general',
            [$this, 'render_general_page']
        );

        add_submenu_page(
            'futstream-theme',
            'Layout e Estilo',
            'Layout e Estilo',
            'manage_options',
            'futstream-layout',
            [$this, 'render_layout_page']
        );

        add_submenu_page(
            'futstream-theme',
            'Opções de Anúncios',
            'Opções de Anúncios',
            'manage_options',
            'futstream-ads',
            [$this, 'render_ads_page']
        );
    }

    public function register_settings() {
        // Registrar configurações para cada seção
        register_setting('futstream_general_settings', 'futstream_general_options');
        register_setting('futstream_layout_settings', 'futstream_layout_options');
        register_setting('futstream_ads_settings', 'futstream_ads_options');
    }

    public function render_theme_page() {
        ?>
        <div class="wrap futstream-theme-panel">
            <h1>Futstream Theme Options</h1>
            <div class="theme-dashboard">
                <div class="dashboard-info">
                    <h2>Bem-vindo ao Painel do Tema Futstream</h2>
                    <p>Aqui você pode personalizar completamente seu tema de streaming de futebol.</p>
                </div>
                <div class="quick-actions">
                    <h3>Ações Rápidas</h3>
                    <a href="<?php echo admin_url('admin.php?page=futstream-general'); ?>" class="button button-primary">Configurações Gerais</a>
                    <a href="<?php echo admin_url('admin.php?page=futstream-layout'); ?>" class="button button-secondary">Layout e Estilo</a>
                    <a href="<?php echo admin_url('admin.php?page=futstream-ads'); ?>" class="button button-secondary">Configurar Anúncios</a>
                </div>
            </div>
        </div>
        <?php
    }

    public function render_general_page() {
        $options = get_option('futstream_general_options', []);
        ?>
        <div class="wrap">
            <h1>Configurações Gerais</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('futstream_general_settings');
                do_settings_sections('futstream_general_settings');
                ?>
                <table class="form-table">
                    <tr>
                        <th>Logo do Site</th>
                        <td>
                            <input type="text" name="futstream_general_options[logo]" 
                                   value="<?php echo esc_attr($options['logo'] ?? ''); ?>" 
                                   class="regular-text">
                            <input type="button" class="button" value="Escolher Logo" id="upload-logo-btn">
                        </td>
                    </tr>
                    <tr>
                        <th>Título do Site para SEO</th>
                        <td>
                            <input type="text" name="futstream_general_options[seo_title]" 
                                   value="<?php echo esc_attr($options['seo_title'] ?? ''); ?>" 
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th>Descrição Curta</th>
                        <td>
                            <textarea name="futstream_general_options[site_description]" 
                                      class="large-text"><?php echo esc_textarea($options['site_description'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function render_layout_page() {
        $options = get_option('futstream_layout_options', []);
        ?>
        <div class="wrap">
            <h1>Layout e Estilo</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('futstream_layout_settings');
                do_settings_sections('futstream_layout_settings');
                ?>
                <table class="form-table">
                    <tr>
                        <th>Esquema de Cores</th>
                        <td>
                            <input type="color" name="futstream_layout_options[primary_color]" 
                                   value="<?php echo esc_attr($options['primary_color'] ?? '#0056b3'); ?>">
                            <label>Cor Primária</label>
                            
                            <input type="color" name="futstream_layout_options[secondary_color]" 
                                   value="<?php echo esc_attr($options['secondary_color'] ?? '#28a745'); ?>">
                            <label>Cor Secundária</label>
                        </td>
                    </tr>
                    <tr>
                        <th>Fonte Principal</th>
                        <td>
                            <select name="futstream_layout_options[font_family]">
                                <?php 
                                $fonts = ['Roboto', 'Open Sans', 'Montserrat', 'Lato'];
                                foreach($fonts as $font) {
                                    $selected = ($options['font_family'] ?? 'Roboto') == $font ? 'selected' : '';
                                    echo "<option value='{$font}' {$selected}>{$font}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Layout de Página</th>
                        <td>
                            <select name="futstream_layout_options[sidebar_position]">
                                <option value="right" <?php selected($options['sidebar_position'] ?? 'right', 'right'); ?>>Sidebar à Direita</option>
                                <option value="left" <?php selected($options['sidebar_position'] ?? 'right', 'left'); ?>>Sidebar à Esquerda</option>
                                <option value="none" <?php selected($options['sidebar_position'] ?? 'right', 'none'); ?>>Sem Sidebar</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function render_ads_page() {
        $options = get_option('futstream_ads_options', []);
        ?>
        <div class="wrap">
            <h1>Opções de Anúncios</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('futstream_ads_settings');
                do_settings_sections('futstream_ads_settings');
                ?>
                <table class="form-table">
                    <tr>
                        <th>Anúncio de Cabeçalho</th>
                        <td>
                            <textarea name="futstream_ads_options[header_ad]" 
                                      class="large-text"><?php echo esc_textarea($options['header_ad'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Anúncio de Rodapé</th>
                        <td>
                            <textarea name="futstream_ads_options[footer_ad]" 
                                      class="large-text"><?php echo esc_textarea($options['footer_ad'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Limite de Anúncios por Página</th>
                        <td>
                            <input type="number" name="futstream_ads_options[max_ads_per_page]" 
                                   value="<?php echo esc_attr($options['max_ads_per_page'] ?? 3); ?>" 
                                   min="1" max="10">
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}

new FutstreamThemePanel();
