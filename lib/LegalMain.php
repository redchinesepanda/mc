<?php

require_once( 'LegalDebug.php' );

require_once( 'LegalComponents.php' );

require_once( 'acf/ACFMain.php' );

require_once( 'admin/AdminMain.php' );

require_once( 'breadcrumbs/LegalBreadcrumbsMain.php' );

require_once( 'dom/LegalDOM.php' );

require_once( 'oops/OopsMain.php' );

require_once( 'review/ReviewMain.php' );

require_once( 'tools/ToolsMain.php' );

require_once( 'wpml/WPMLMain.php' );

require_once( 'yoast/YoastMain.php' );

require_once( 'schema/SchemaMain.php' );

require_once( 'base/BaseMain.php' );

require_once( 'notfound/NotFoundMain.php' );

require_once( 'metrika/MetrikaMain.php' );

define( 'LEGAL_PATH', get_stylesheet_directory() );

define( 'LEGAL_URL', get_stylesheet_directory_uri() );

define( 'LEGAL_ROOT', site_url() );

class LegalMain {
	const LEGAL_PATH = \LEGAL_PATH;
    
	const LEGAL_URL = \LEGAL_URL;

	const LEGAL_ROOT = \LEGAL_ROOT;

	public static function register()
	{
		if ( self::check() )
		{
			LegalComponents::register();
	
			ACFMain::register();
	
			AdminMain::register();
	
			OopsMain::register();
	
			LegalBreadcrumbsMain::register();
	
			// ReviewMain::register();
	
			ToolsMain::register();
	
			WPMLMain::register();
	
			YoastMain::register();
	
			SchemaMain::register();
	
			BaseMain::register();
	
			NotFoundMain::register();
	
			MetrikaMain::register();
		}
	}

	public static function check_acf()
	{
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
		return is_plugin_active( 'advanced-custom-fields-pro/acf.php' );
	}

	public static function check()
	{
		return ( self::check_acf() );
	}
}

?>