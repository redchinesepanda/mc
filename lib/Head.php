<?php

class Head
{
	public static function register()
    {
        $handler = new self();
		
        add_action('wp_print_scripts', [ $handler, 'legal_remove_all_scripts' ], 100);

        add_action('wp_print_styles', [ $handler, 'legal_remove_all_styles' ], 100);

        Billet::register();
	}

    public function legal_remove_all_scripts()
    {
        global $wp_scripts;
        $wp_scripts->queue = [];
    }
    
    public function legal_remove_all_styles()
    {
        global $wp_styles;
        $wp_styles->queue = [];
    }
}

?>