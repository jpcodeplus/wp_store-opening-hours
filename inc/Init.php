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
        remove_action('wp_head', 'wp_generator');

        (new Login());
    }

    function init_action()
    {
        (new Admin());
       
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




}
