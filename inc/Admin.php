<?php

namespace CPM_Plugin;

use CPM_Plugin\UI\Dashboard;

class Admin
{
    private $plugin_slug;
    private $dashboard;

    function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'backend_scripts']);
        add_action('admin_menu', [$this, 'hide_menu_items']);
        add_action('current_screen', [$this, 'redirect_to_plugin_page']);
        add_action('admin_menu', [$this, 'create_menu']); // Erstellt das

        $this->plugin_slug = '';
        $this->dashboard = new Dashboard();
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
       
        $profil_url = admin_url('profile.php');



        $greeting = $this->greeting($nicename);


        $site_url = $this->dashboard->link('Homepage', get_site_url(), 'link link_website');
        $logout_url = $this->dashboard->link('Logout', wp_logout_url(), 'link link_logout');
        $profil_url = $this->dashboard->link('User Settings', admin_url('profile.php'), 'link link_profil');

        $myurl = explode('://',home_url());
        $datetime = $this->dashboard->datetime();


        $top_line = "
        <header class='cpm_topline'>
        <h1 class='greeting'>$greeting</h1>
        <div class='top-links'>
            $site_url 
            $profil_url
            $logout_url
        </div>
        </header>
        <div class='cpm_topinfo'>
        <span class='cpm_topinfo-domain'>Domain: $myurl[1]</span>
        <span class='cpm_topinfo-date'>$datetime</span>
        </div>
        ";

        echo "
        <div class='cpm_dashboard'>

        $top_line
     
        $site_url

        <a href='https://testpress.local/wp-admin/plugins.php'>Plugins</a>
        <p class='demo'>Wollkommen im Dashboard von Code Plus</p>
        
        </div>
        ";
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

    function hide_menu_items()
    {

        $pages = [
            'edit.php', 'edit-comments.php', 'themes.php', 'options-general.php',
            'tools.php', 'upload.php', 'users.php', 'edit.php?post_type=page', 'index.php', 'plugins.php', 'about.php'
        ];

        foreach ($pages as $page) {
            remove_menu_page($page);
        }
    }

    function redirect_to_plugin_page()
    {
        $screen = get_current_screen();

        if ($screen->base == 'dashboard' || $screen->base == 'about') {
            wp_redirect(admin_url('admin.php?page=cpm-base'));
            exit;
        }
    }


    function greeting($name)
    {
        // Definieren Sie Arrays mit Grußbotschaften für verschiedene Tageszeiten
        $morning_greetings = array("Guten Morgen, $name! Die Welt wartet auf dich!", "Aufstehen und glänzen, $name! Es ist ein neuer Tag!", "Morgenstund hat Gold im Mund, $name!", "Einen wunderschönen Morgen, $name!", "Die Welt ist dein, $name! Gib Gas!", "Der frühe Vogel fängt den Wurm, $name!", "Mach heute zu deinem Tag, $name!");
        $afternoon_greetings = array("Ein schöner Nachmittag, nicht wahr, $name?", "Genießen Sie den Nachmittag, $name!", "Perfekte Zeit für eine Pause, $name!", "Hoffe, dein Tag ist gut, $name!", "Was für ein sonniger Nachmittag, $name!", "Sonnige Grüße, $name!", "Zeit für einen Spaziergang, $name!");
        $evening_greetings = array("Guten Abend, $name! Hoffe, du hattest einen schönen Tag!", "Abenddämmerung ist hier, $name! Genieße den ruhigen Abend!", "Zeit für Entspannung, $name!", "Wünsche dir einen gemütlichen Abend, $name!", "Guten Abend und gute Nacht, $name!");

        // Holen Sie sich die aktuelle Stunde
        $current_hour = date('H');

        // Wählen Sie einen zufälligen Gruß basierend auf der Tageszeit
        if ($current_hour >= 6 && $current_hour < 12) {
            $greeting = $morning_greetings[array_rand($morning_greetings)];
        } elseif ($current_hour >= 12 && $current_hour < 18) {
            $greeting = $afternoon_greetings[array_rand($afternoon_greetings)];
        } else {
            $greeting = $evening_greetings[array_rand($evening_greetings)];
        }

        return $greeting;
    }
}
