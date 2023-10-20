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
		// if ( LegalMain::check_admin() )
		// {
		// 	BonusMain::register_always();
		// }

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

	const TAXONOMY = [
        'page_type' => 'page_type',
    ];

	const TERMS = [
        'promo-codes',

        'bonus',

        'review',

        'app',

        'registration',

        'how-to-play',

        'withdrawal',

        'obzor-bk',

        'obzor-bk-betera',

        'obzor-bk-1xbet',

        'compilation',
    ];

	public static function check_taxonomy()
	{
		return has_term( self::TERMS, self::TAXONOMY[ 'page_type' ] );
	}
	
	public static function check_not_found()
	{
		return is_404();
	}

	public static function check()
    {
		LegalDebug::debug( [
			'function' => 'check_plugins',

			'permission_single' => $permission_single,

			'permission_term' => $permission_term,

			'permission_main' => $permission_main,

			'check_not_found' => $check_not_found,
		] );
        
        return (
			self::check_post_type_page()
			
			&& self::check_taxonomy()
			
			&& LegalMain::check()
		)
		
		|| self::check_post_type_post()

		|| self::check_not_found();
    }
}

?>