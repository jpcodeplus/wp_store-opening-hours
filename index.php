<?php
if (!defined('ABSPATH')) exit;

/*
Plugin Name: WP Store Opening Times
Plugin URI: https://yourwebsite.com/
Description: Dieses Plugin gibt die Öffnungszeiten eines Ladengeschäftes aus 
Version: 1.0
Author: Jan Behrens (JP | Code Plus)
Author URI: https://code-plus.media.de/
*/

require_once(__DIR__.'/inc/cpm/Init.php');

(new Init(__DIR__));