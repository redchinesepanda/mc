<?php

require_once( 'LegalDebug.php' );

require_once( 'LegalComponents.php' );

require_once( 'LegalHosts.php' );

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

require_once( 'notion/NotionMain.php' );

require_once( 'multisite/MultisiteMain.php' );

require_once( 'wp-optimize/WPOptimizeMain.php' );

define( 'LEGAL_PATH', get_stylesheet_directory() );

define( 'LEGAL_URL', get_stylesheet_directory_uri() );

define( 'LEGAL_ROOT', site_url() );

class LegalMain
{
	const LEGAL_PATH = \LEGAL_PATH;
    
	const LEGAL_URL = \LEGAL_URL;

	const LEGAL_ROOT = \LEGAL_ROOT;

	public static function register()
	{
		// if ( self::check_plugins() )
		// {
			$handler = new self();
		
			add_action( 'wp', [ $handler, 'register_components' ] );

			self::register_functions();
		// }

		// LegalDebug::debug( [
		// 	'LegalMain' => 'register',
		// ] );
	}

	public static function register_functions()
    {
		LegalComponents::register_functions();

		ACFMain::register_functions();

		ToolsMain::register_functions();
	
		SchemaMain::register();

		BaseMain::register_functions();

		YoastMain::register_functions();

		ReviewMain::register_functions();

		WPMLMain::register_functions();

		MultisiteMain::register_functions();

		WPOptimizeMain::register_functions();

		if ( self::check_admin() )
		{
			ACFMain::register();
	
			AdminMain::register();

			NotionMain::register_functions();

			MultisiteMain::register_functions_admin();

			LegalComponents::register_functions_admin();

			ToolsMain::register_functions_admin();
		}
	}

	public static function register_components()
	{
		LegalComponents::register();

		NotionMain::register();

		ToolsMain::register();

		if ( self::check() )
		{
			OopsMain::register();
	
			LegalBreadcrumbsMain::register();
	
			ReviewMain::register();
	
			WPMLMain::register();
	
			YoastMain::register();
	
			BaseMain::register();
	
			NotFoundMain::register();
	
			MetrikaMain::register();
		}
	}

	public static function check_admin()
	{
		return is_admin();
	}

	public static function check_not_admin()
	{
		// return !is_admin();

		return !self::check_admin();
	}

	public static function check_not_ajax()
	{
		return !wp_doing_ajax();
	}

	public static function check_permissions()
	{
		// LegalDebug::debug( [
		// 	'function' => 'check_permissions',

		// 	'check_not_ajax' => $check_not_ajax,

		// 	'check_not_admin' => $check_not_admin,
		// ] );

		return self::check_not_ajax()

			&& self::check_not_admin();
	}

	public static function check_plugins()
	{
		return true;

		// include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// $permission_acf = is_plugin_active( 'advanced-custom-fields-pro/acf.php' );

		// $permission_wpml = is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' );

		// $permission_yoast = is_plugin_active( 'wordpress-seo/wp-seo.php' );

		// LegalDebug::debug( [
		// 	'function' => 'check_plugins',

		// 	'permission_acf' => $permission_acf,

		// 	'permission_wpml' => $permission_wpml,

		// 	'permission_yoast' => $permission_yoast,
		// ] );
	
		// return $permission_acf

			// && $permission_wpml;

			// && $permission_yoast;
	}

	public static function check()
	{
		// LegalDebug::debug( [
		// 	'function' => 'check_plugins',

		// 	'check_plugins' => self::check_plugins(),

		// 	'check_permissions' => self::check_permissions(),
		// ] );

		// return self::check_plugins() && self::check_permissions();
		
		return self::check_permissions();
	}

	// const HOST_PRODUCTION = [
	// 	'mc' => 'match.center',

	// 	'es' => 'es.match.center',
	// ];

	// const HOST_DEBUG = [
	// 	'old' => 'old.match.center',

	// 	'oldpl' => 'oldpl.match.center',

	// 	'oldes' => 'oldes.match.center',

	// 	'test' => 'test.match.center',

	// 	// 'es' => 'es.match.center',
	// ];

	// public static function check_host_production()
	// {
	// 	if ( in_array( $_SERVER[ 'HTTP_HOST' ], self::HOST_PRODUCTION ) )
	// 	{
	// 		return true;
	// 	}

	// 	return false;
	// }

	// public static function get_main_host()
	// {
	// 	// $host = self::HOST_DEBUG;

	// 	if ( self::check_host_production() )
	// 	{
	// 		// $host = self::HOST_PRODUCTION;

	// 		return self::get_main_host_production();
	// 	}

	// 	// return array_shift( $host );

	// 	$host = self::HOST_DEBUG;
		
	// 	return array_shift( $host );
	// }

	// public static function get_main_host_production()
	// {
	// 	$host = self::HOST_PRODUCTION;

	// 	return array_shift( $host );
	// }
}

?>