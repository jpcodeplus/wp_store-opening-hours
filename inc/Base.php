<?php

namespace CPM;
use CPM\Logger;

class Base
{
    protected $logger;

    public function __construct(string $pluginFile)
    {
        $this->logger = new Logger(__DIR__.'mylog.txt');
        $this->registerHooks();
    }

    protected function registerHooks(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScriptAndStyles']);
    }

    public function enqueueScriptAndStyles(): void
    {
        wp_register_script( 'custom-script', plugins_url( 'assets/js/script.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'custom-script' );
    
        wp_register_style( 'custom-style', plugins_url( 'assets/css/styles.css', __FILE__ ), array(), '1.0', 'all' );
        wp_enqueue_style( 'custom-style' );
    }
}
