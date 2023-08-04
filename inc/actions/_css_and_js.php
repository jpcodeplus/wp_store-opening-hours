<?php
function cpm_enqueue_scripts()
{
    $folder = '../../assets/';
    $plugin_url = plugin_dir_url(__FILE__) . $folder;
    $plugin_path = plugin_dir_path(__FILE__) . $folder;

    $script_path = $plugin_path . 'js/script.js';
    $style_path = $plugin_path . 'css/styles.css';

    $script_ver = file_exists($script_path) ? filemtime($script_path) : false;
    $style_ver = file_exists($style_path) ? filemtime($style_path) : false;

    if ($script_ver) {
        wp_register_script('cpm-script', $plugin_url . 'js/script.js', array('jquery'), $script_ver, true);
        wp_enqueue_script('cpm-script');
    }

    if ($style_ver) {
        wp_register_style('cpm-style', $plugin_url . 'css/styles.css', array(), $style_ver, 'all');
        wp_enqueue_style('cpm-style');
    }
}

add_action('wp_enqueue_scripts', 'cpm_enqueue_scripts');
