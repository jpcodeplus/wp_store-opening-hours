<?php

namespace CPM_Plugin;

class Admin
{
    private $plugin_slug;
    function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'backend_scripts']);
        add_action('admin_menu', [$this, 'hide_menu_items']);
        add_action('current_screen', [$this, 'redirect_to_plugin_page']);
        add_action('admin_menu', [$this, 'create_menu']); // Erstellt das

        $this->plugin_slug = '';
    }

    public function create_menu()
    {
        $page_title = 'Titel der Seite';
        $menu_title = 'Dashboard'; // Titel im Menü
        $access_rights = 'manage_options';
        $menu_slug = 'cpm-base';
        $content = [$this, 'get_content'];
        $icon_url = 'none';
        $position = -1;
        add_menu_page(__($page_title), $menu_title, $access_rights, $menu_slug, $content, $icon_url, $position);
    }

    public function get_content()
    {
        $user = wp_get_current_user();
        $nicename = $user->data->user_nicename;

        $gravatar_url = $this->get_gravatar('behrens.codeplus@gmail.com');
        $site_url = get_site_url();

        echo "<h1>Hi $nicename,</h1>
        <img src='$gravatar_url' alt='' />
        $site_url
        <a href='$site_url'>Homepage</a>
        <a href='https://testpress.local/wp-admin/plugins.php'>Plugins</a>
        <p class='demo'>Wollkommen im Dashboard von Code Plus</p>";
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


    function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    function hide_menu_items() {

        $pages = ['edit.php','edit-comments.php','themes.php','options-general.php',
    'tools.php','upload.php','users.php','edit.php?post_type=page','index.php','plugins.php','about.php'];

        foreach($pages as $page){
            remove_menu_page($page);  
        } 
    }

    function redirect_to_plugin_page() {
        $screen = get_current_screen();
    
        if ($screen->base == 'dashboard' || $screen->base == 'about') {
            wp_redirect(admin_url('admin.php?page=cpm-base')); 
            exit;
        }
    }
}
