<?php

class WPOptimizeMain
{
	public static function check_plugin()
    {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        return is_plugin_active( 'wp-optimize-premium/wp-optimize.php' );
    }
	
	public static function register_functions()
    {
        $handler = new self();

        // add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );

		add_action( 'plugins_loaded', [ $handler, 'set_wpo_cache_files_dir' ], 0 );
    }

	public static  function set_wpo_cache_files_dir()
	{
		if ( !defined( 'WPO_CACHE_FILES_DIR' ) )
		{
			define( 'WPO_CACHE_FILES_DIR', ABSPATH . 'wp-content/cache/wpo-cache/' . $_SERVER[ 'HTTP_HOST' ] );
		}
	}

	// function mc_edit_form_after_title_debug( $post )
	// {
	// 	LegalDebug::debug( [
	// 		'WPOptimizeMain' => 'mc_edit_form_after_title_debug',

	// 		'WPO_CACHE_FILES_DIR' => WPO_CACHE_FILES_DIR,
			
	// 		'ABSPATH' => ABSPATH,

	// 		'new_cashe_dir' => ABSPATH . 'wp-content/cache/wpo-cache/' . $_SERVER['HTTP_HOST'],
	// 	] );
	// }
}

?>