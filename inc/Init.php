<?php
namespace CPM_Plugin;

class Init
{

    protected $plugin_base;

    function __construct($plugin_base)
    {
        $this->plugin_base = $plugin_base;
        add_action('init', [$this, 'init_action']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'backend_scripts']);
    }

    function init_action()
    {
        add_action('admin_menu', [$this, 'create_admin_menu']); // Erstellt das
    }

    function frontend_scripts()
    {
        $folder = '../assets/';

        $plugin["url"] = plugin_dir_url(__FILE__) . $folder;
        $plugin["path"] = plugin_dir_path(__FILE__) . $folder;

        $file["script"] = 'js/script.js';
        $file["style"] = 'css/styles.css';

        $path["script"] =  $plugin["path"] . $file["script"];
        $path["style"] =  $plugin["path"] . $file["style"];

        $version['script'] = file_exists($path["script"]) ? filemtime($path["script"]) : false;
        $version['style'] = file_exists($path["style"]) ? filemtime($path["style"]) : false;

        if ($version['script']) {
            wp_register_script('cpm-script', $plugin["url"] . $file["script"], array('jquery'), $version['script'], true);
            wp_enqueue_script('cpm-script');
        }

        if ($version['style']) {
            wp_register_style('cpm-style', $plugin["url"] . $file["style"], array(), $version['style'], 'all');
            wp_enqueue_style('cpm-style');
        }
    }
    function backend_scripts()
    {
        $folder = '../assets/';

        $plugin["url"] = plugin_dir_url(__FILE__) . $folder;
        $plugin["path"] = plugin_dir_path(__FILE__) . $folder;

        $file["script"] = 'js/admin.js';
        $file["style"] = 'css/admin.css';

        $path["script"] =  $plugin["path"] . $file["script"];
        $path["style"] =  $plugin["path"] . $file["style"];

        $version['script'] = file_exists($path["script"]) ? filemtime($path["script"]) : false;
        $version['style'] = file_exists($path["style"]) ? filemtime($path["style"]) : false;

        if ($version['script']) {
            wp_register_script('cpm-admin-script', $plugin["url"] . $file["script"], array('jquery'), $version['script'], true);
            wp_enqueue_script('cpm-admin-script');
        }

        if ($version['style']) {
            wp_register_style('cpm-admin-style', $plugin["url"] . $file["style"], array(), $version['style'], 'all');
            wp_enqueue_style('cpm-admin-style');
        }
    }

    public function create_admin_menu()
    {
        $page_title = 'Titel der Seite';
        $menu_title = 'Code Plus'; // Titel im Menü
        $access_rights = 'manage_options';
        $menu_slug = 'cpm-plugin';
        $content = [$this, 'get_admin_page_content'];
        $icon_url ='none';
        $position = -1;
        add_menu_page(__($page_title), $menu_title, $access_rights, $menu_slug, $content, $icon_url, $position);
    }

    public function get_admin_page_content(){
        $user = wp_get_current_user();
        $nicename = $user->data->user_nicename;
        echo "<h1>Hi $nicename,</h1>
        <p class='demo'>Wollkommen im Dashboard von Code Plus</p>";
    }
}
