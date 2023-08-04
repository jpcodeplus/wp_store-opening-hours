<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

/*
Plugin Name: WP Store Opening Times
Plugin URI: https://yourwebsite.com/
Description: Dieses Plugin gibt die Öffnungszeiten eines Ladengeschäftes aus 
Version: 1.0
Author: Jan Behrens (JP | Code Plus)
Author URI: https://code-plus.media.de/
*/

// Register the autoloader
spl_autoload_register(function ($class) {
    $prefix = 'CPM\\';
    $baseDir = __DIR__ . '/inc/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Use the namespace to avoid conflicts
use CPM\Base;

// Create a new instance of the PluginBasics class
(new Base(__FILE__));

