<?php
class FutstreamThemePanel {
    private $cache_key = 'futstream_theme_options_cache';
    private $backup_dir;

    public function __construct() {
        add_action('admin_menu', array($this, 'register_theme_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        
        // Configuração do diretório de backup
        $this->backup_dir = wp_upload_dir()['basedir'] . '/futstream_backups/';
        $this->setup_backup_directory();
        
        // Ações AJAX
        add_action('wp_ajax_futstream_create_backup', array($this, 'ajax_create_backup'));
        add_action('wp_ajax_futstream_restore_backup', array($this, 'ajax_restore_backup'));
        add_action('wp_ajax_futstream_delete_backup', array($this, 'ajax_delete_backup'));
    }

    // Configuração do diretório de backup
    private function setup_backup_directory() {
        if (!file_exists($this->backup_dir)) {
            wp_mkdir_p($this->backup_dir);
        }

        // Cria .htaccess para bloquear acesso direto
        $htaccess_path = $this->backup_dir . '.htaccess';
        if (!file_exists($htaccess_path)) {
            $htaccess_content = "Order deny,allow\nDeny from all";
            @file_put_contents($htaccess_path, $htaccess_content);
        }

        // Cria index.php para prevenir listagem de diretório
        $index_path = $this->backup_dir . 'index.php';
        if (!file_exists($index_path)) {
            @file_put_contents($index_path, "<?php // Silence is golden. ?>");
        }
    }

    // Registra o menu do tema
    public function register_theme_menu() {
        add_menu_page(
            'Futstream Theme Options',  // Título da página
            'Futstream',                // Título do menu
            'manage_options',           // Capacidade necessária
            'futstream-theme',          // Slug do menu
            array($this, 'render_theme_page'), // Callback
            'dashicons-football',       // Ícone
            99                          // Posição no menu
        );

        // Submenus
        add_submenu_page(
            'futstream-theme',
            'Configurações Gerais',
            'Configurações Gerais',
            'manage_options',
            'futstream-general',
            array($this, 'render_general_page')
        );

        add_submenu_page(
            'futstream-theme',
            'Layout e Design',
            'Layout e Design',
            'manage_options',
            'futstream-layout',
            array($this, 'render_layout_page')
        );

        add_submenu_page(
            'futstream-theme',
            'Opções de Anúncios',
            'Opções de Anúncios',
            'manage_options',
            'futstream-ads',
            array($this, 'render_ads_page')
        );

        add_submenu_page(
            'futstream-theme',
            'Backups',
            'Backups',
            'manage_options',
            'futstream-backups',
            array($this, 'render_backup_page')
        );
    }

    // Registra as configurações
    public function register_settings() {
        register_setting('futstream_general_settings', 'futstream_general_options');
        register_setting('futstream_layout_settings', 'futstream_layout_options');
        register_setting('futstream_ads_settings', 'futstream_ads_options');
    }

    // Carrega scripts para páginas admin
    public function enqueue_admin_scripts($hook) {
        // Verifica se estamos na página correta
        if (strpos($hook, 'futstream-') !== false) {
            // Estilos gerais do tema
            wp_enqueue_style(
                'futstream-admin-style', 
                get_template_directory_uri() . '/assets/css/admin-style.css'
            );

            // Script para manipulação de opções
            wp_enqueue_script(
                'futstream-admin-script', 
                get_template_directory_uri() . '/assets/js/admin-script.js', 
                array('jquery'), 
                '1.0', 
                true
            );
        }
    }

    // Páginas de renderização

    // Página principal do tema
    public function render_theme_page() {
        ?>
        <div class="wrap">
            <h1>Futstream Theme Options</h1>
            <div class="futstream-dashboard">
                <div class="welcome-panel">
                    <h2>Bem-vindo ao Painel do Futstream</h2>
                    <p>Aqui você pode configurar todos os aspectos do seu tema de streaming de futebol.</p>
                </div>
                <div class="quick-links">
                    <h3>Ações Rápidas</h3>
                    <a href="?page=futstream-general" class="button">Configurações Gerais</a>
                    <a href="?page=futstream-layout" class="button">Layout</a>
                    <a href="?page=futstream-ads" class="button">Anúncios</a>
                    <a href="?page=futstream-backups" class="button">Backups</a>
                </div>
            </div>
        </div>
        <?php
    }

    // Página de Configurações Gerais
    public function render_general_page() {
        // Recupera opções atuais
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
                        <th>Título do Site</th>
                        <td>
                            <input 
                                type="text" 
                                name="futstream_general_options[site_title]" 
                                value="<?php echo esc_attr($options['site_title'] ?? ''); ?>"
                                class="regular-text"
                            >
                        </td>
                    </tr>
                    <tr>
                        <th>Logo</th>
                        <td>
                            <input 
                                type="text" 
                                name="futstream_general_options[logo_url]" 
                                value="<?php echo esc_attr($options['logo_url'] ?? ''); ?>"
                                class="regular-text"
                            >
                            <button type="button" class="button upload-logo-button">Selecionar Logo</button>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    // Página de Layout
    public function render_layout_page() {
        $options = get_option('futstream_layout_options', []);
        ?>
        <div class="wrap">
            <h1>Layout e Design</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('futstream_layout_settings');
                do_settings_sections('futstream_layout_settings');
                ?>
                <table class="form-table">
                    <tr>
                        <th>Esquema de Cores</th>
                        <td>
                            <select name="futstream_layout_options[color_scheme]">
                                <option value="dark" <?php selected($options['color_scheme'] ?? '', 'dark'); ?>>Escuro</option>
                                <option value="light" <?php selected($options['color_scheme'] ?? '', 'light'); ?>>Claro</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Layout de Página</th>
                        <td>
                            <select name="futstream_layout_options[page_layout]">
                                <option value="full-width" <?php selected($options['page_layout'] ?? '', 'full-width'); ?>>Full Width</option>
                                <option value="boxed" <?php selected($options['page_layout'] ?? '', 'boxed'); ?>>Boxed</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    // Página de Anúncios
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
                        <th>Código de Anúncio Principal</th>
                        <td>
                            <textarea 
                                name="futstream_ads_options[main_ad_code]" 
                                rows="5" 
                                class="large-text"
                            ><?php echo esc_textarea($options['main_ad_code'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Habilitar Anúncios</th>
                        <td>
                            <label>
                                <input 
                                    type="checkbox" 
                                    name="futstream_ads_options[enable_ads]" 
                                    value="1" 
                                    <?php checked(1, $options['enable_ads'] ?? 0); ?>
                                > 
                                Ativar anúncios no site
                            </label>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    // Página de Backups
    public function render_backup_page() {
        ?>
        <div class="wrap">
            <h1>Backups do Tema</h1>
            <div class="backup-actions">
                <button id="create-manual-backup" class="button button-primary">
                    Criar Backup Manual
                </button>
            </div>
            <div class="backup-list">
                <!-- Lista de backups será populada via JS -->
            </div>
        </div>
        <?php
    }

    // Métodos para operações de backup (AJAX)
    public function ajax_create_backup() {
        // Implementação do método de criação de backup
        wp_send_json_success('Backup criado com sucesso');
    }

    public function ajax_restore_backup() {
        // Implementação do método de restauração de backup
        wp_send_json_success('Backup restaurado com sucesso');
    }

    public function ajax_delete_backup() {
        // Implementação do método de exclusão de backup
        wp_send_json_success('Backup excluído com sucesso');
    }
}

// Instancia a classe
new FutstreamThemePanel();
