<?php

require_once( 'billet/BilletMain.php' );

require_once( 'brand/BrandMain.php' );

require_once( 'compilation/CompilationMain.php' );

require_once( 'tabs/CompilationTabsMain.php' );

require_once( 'bonus/BonusMain.php' );

require_once( 'template/TemplateMain.php' );

require_once( 'wiki/WikiMain.php' );

require_once( 'forecast/ForecastMain.php' );

require_once( 'affiliate/AffiliateMain.php' );

class LegalComponents
{
	public static function register_functions_admin()
	{
		BrandMain::register_functions_admin();

		AffiliateMain::register_functions_admin();
	}

	public static function register_functions()
    {
		BonusMain::register_functions();

		CompilationMain::register_functions();

		CompilationTabsMain::register_functions();

		WikiMain::register_functions();

		BilletMain::register_functions();
	}

	public static function register()
	{
		if ( self::check() )
		{
			BilletMain::register();
	
			CompilationMain::register();
			
			CompilationTabsMain::register();
	
			BonusMain::register();
	
			// TemplateMain::register();

			WikiMain::register();

			ForecastMain::register();
		}

		TemplateMain::register();
	}

	public static function check_not_admin()
    {
		return !is_admin();
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

	// const TERMS = array_merge( self::TERMS_REVIEW, self::TERMS_COMPILATION );
	
	const TERMS = [ ...self::TERMS_REVIEW, ...self::TERMS_COMPILATION ];

	// const TERMS = [
    //     'promo-codes',

    //     'bonus',

    //     'review',

    //     'app',

    //     'registration',

    //     'how-to-play',

    //     'withdrawal',

    //     'obzor-bk',

    //     'obzor-bk-betera',

    //     'obzor-bk-1xbet',

    //     'compilation',
    // ];

	const TERMS_REVIEW = [
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
    ];
	
	const TERMS_COMPILATION = [
        'compilation',
    ];

	const TERMS_WIKI = [
        'legal-wiki',
    ];

	const TERMS_BONUS = [
		'bonusy',

		'bonusy-kz',

		'bonusy-by',
	];

	public static function check_category( $terms = self::TERMS_BONUS )
    {
		return has_category( $terms );
    }

	public static function check_taxonomy( $terms = self::TERMS )
	{
		// return has_term( self::TERMS, self::TAXONOMY[ 'page_type' ] );
		
		return has_term( $terms, self::TAXONOMY[ 'page_type' ] );
	}
	
	public static function check_not_found()
	{
		return is_404();
	}

	public static function check()
    {
		// LegalDebug::debug( [
		// 	'function' => 'check_plugins',

		// 	'check_post_type_page' => self::check_post_type_page(),

		// 	'check_taxonomy' => self::check_taxonomy(),

		// 	'LegalMain::check' => LegalMain::check(),

		// 	'check_post_type_post' => self::check_post_type_post(),

		// 	'check_not_found' => self::check_not_found(),
		// ] );
        
        return (
			self::check_post_type_page()
			
			&& self::check_taxonomy()
			
			&& LegalMain::check()
		)
		
		|| self::check_post_type_post()

		|| self::check_not_found();

		// || ToolNotFound::check();
    }

    public static function check_contains( $class = '' )
    {
        if ( $post = get_post() )
		{
			if ( $post->post_type == 'post' )
			{
				if ( $content = get_field( BonusContent::FIELD[ 'bonus-content' ], $post->ID ) )
				{
					return str_contains( $content, $class );
				}
			}

			return str_contains( $post->post_content, $class );
		}

		return false;
    }

	public static function check_shortcode( $shortcode = '' )
	{
		$post = get_post();

		if ( $post )
		{
			if ( $post->post_type == 'post' )
			{
				if ( $content = get_field( BonusContent::FIELD[ 'bonus-content' ], $post->ID ) )
				{
					return has_shortcode( $content, $shortcode );
				}
			}

			return has_shortcode( $post->post_content, $shortcode );
		}

		return false;
	}

	public static function render_main( $template, $args )
    {
		ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }

	public static function print_main( $template, $args )
    {
		load_template( $template, false, $args );
    }
}

?>