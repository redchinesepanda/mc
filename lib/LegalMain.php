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

class LegalMain
{
	const LEGAL_PATH = \LEGAL_PATH;
    
	const LEGAL_URL = \LEGAL_URL;

	const LEGAL_ROOT = \LEGAL_ROOT;

	public static function register()
	{
		$handler = new self();
		
		add_action( 'wp', [ $handler, 'register_components' ] );

		self::register_functions();
	}

	public static function register_functions()
    {
		LegalComponents::register_functions();
	
		ToolsMain::register();

		if ( self::check_admin() )
		{
			ACFMain::register();
	
			AdminMain::register();
		}
	}

	public static function register_components()
	{
		LegalComponents::register();

		if ( self::check() )
		{
			OopsMain::register();
	
			LegalBreadcrumbsMain::register();
	
			ReviewMain::register();
	
			WPMLMain::register();
	
			YoastMain::register();
	
			SchemaMain::register();
	
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
		return !is_admin();
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
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$permission_acf = is_plugin_active( 'advanced-custom-fields-pro/acf.php' );

		$permission_wpml = is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' );

		// LegalDebug::debug( [
		// 	'function' => 'check_plugins',

		// 	'permission_acf' => $permission_acf,

		// 	'permission_wpml' => $permission_wpml,
		// ] );
	
		return $permission_acf && $permission_wpml;
	}

	public static function check()
	{
		// LegalDebug::debug( [
		// 	'function' => 'check_plugins',

		// 	'check_plugins' => self::check_plugins(),

		// 	'check_permissions' => self::check_permissions(),
		// ] );

		return self::check_plugins() && self::check_permissions();
	}
}

?>