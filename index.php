<?php
if (!defined('ABSPATH')) exit;

/*
Plugin Name: Code Plus Basic
Plugin URI: https://yourwebsite.com/
Description: Dieses Plugin gibt die Öffnungszeiten eines Ladengeschäftes aus 
Version: 1.0
Author: Jan Behrens (JP | Code Plus)
Author URI: https://code-plus.media.de/
*/

define('CPM_INCLUDES', __DIR__.'/inc/');
define('CPM_ASSETS', __DIR__.'/assets/');
require_once(__DIR__.'/autoloading.php');

(new CPM_Plugin\Init(__DIR__));