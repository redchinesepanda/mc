<?php

require_once( 'LegalDebug.php' );

require_once( 'acf/ACFMain.php' );

require_once( 'admin/AdminMain.php' );

require_once( 'breadcrumbs/LegalBreadcrumbsMain.php' );

require_once( 'dom/LegalDOM.php' );

require_once( 'oops/OopsMain.php' );

require_once( 'review/ReviewMain.php' );

require_once( 'tools/ToolsMain.php' );

require_once( 'wpml/WPMLMain.php' );

define( 'LEGAL_PATH', get_stylesheet_directory() );

define( 'LEGAL_URL', get_stylesheet_directory_uri() );

class LegalMain {
	const LEGAL_PATH = \LEGAL_PATH;
    
	const LEGAL_URL = \LEGAL_URL;

	public static function register()
	{
		ACFMain::register();

		AdminMain::register();

		// OopsMain::register();

		LegalBreadcrumbsMain::register();

		ReviewMain::register();

		ToolsMain::register();

		WPMLMain::register();
	}
}

?>