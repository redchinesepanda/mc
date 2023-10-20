<?php

require_once( 'billet/BilletMain.php' );

require_once( 'compilation/CompilationMain.php' );

require_once( 'tabs/CompilationTabsMain.php' );

require_once( 'bonus/BonusMain.php' );

require_once( 'template/TemplateMain.php' );

require_once( 'wiki/WikiMain.php' );

class LegalComponents
{
	public static function register_functions()
    {
		BonusMain::register_functions();

		CompilationTabsMain::register_functions();

		WikiMain::register_functions();
	}

	public static function register()
	{
	// 	$handler = new self();
		
	// 	add_action( 'wp', [ $handler, 'register_components' ] );
	// }

	// public static function register_components()
	// {
		if ( self::check() )
		{
			BilletMain::register();
	
			CompilationMain::register();
			
			CompilationTabsMain::register();
	
			BonusMain::register();
	
			TemplateMain::register();

			WikiMain::register();
		}
	}
	
	public static function check_post_type_post()
	{
		return is_singular( 'post' );
	}

	public static function check_post_type_page()
	{
		return is_singular( 'page' );
	}

	public static function check_taxonomy()
	{
		return has_term( 'compilation', 'page_type' );
	}

	public static function check()
    {
		// $permission_single = ;

        // $permission_term = ;

		// $permission_main = ;

		// LegalDebug::debug( [
		// 	'function' => 'check_plugins',

		// 	'permission_single' => $permission_single,

		// 	'permission_term' => $permission_term,

		// 	'permission_main' => $permission_main,
		// ] );
        
        return (
			self::check_post_type_page()
			
			&& self::check_taxonomy()
			
			&& LegalMain::check()
		)
		
		|| self::check_post_type_post();
    }
}

?>