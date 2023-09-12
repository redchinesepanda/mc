<?php

require_once( 'BaseHeader.php' );

require_once( 'BaseFooter.php' );

class BaseMain
{
	const TEXT = [
		'all-rights-reserved' => 'All rights reserved',

        'bet-now' => 'Bet now',

		'betting-sites' => 'Betting Sites',

		'choose-your-country' => 'Choose your country',

		'gambling-sites' => 'Gambling Sites',

		'legal-review-bk-header' => 'Legal Review BK Header',

		'legal-review-bk-footer' => 'Legal Review BK Footer',

		'match-center' => 'Match.Center',

        'match-center-is-not' => '<p>Match.Cener is not a gambling operator (we do not accept any bets). The content of this website is strictly for information purposes and does not constitute advice. We only review gambling operators who are licenced by their respective local and international regulators. We only claim information to be correct at the time of posting.</p><p>Always gamble responsibly and never risk money that you can not afford to lose!</p>',

		'online-casinos' => 'Online Casinos',

		'oops-page-not-found' => 'Oops! Page Not Found',

        'ouch' => 'Ouch',

        'this-bookie' => "This bookie doesn't pay for the referral program. But here are the offers of Match.Center partners",

		'you-must-have' => "You must have picked the wrong door because I haven't been able to lay my eye on the page you've been searching for.",
	];

	public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            ToolEnqueue::register_style( $styles );
        }
    }

    public static function register_script( $scripts = [] )
    {
        if ( self::check() ) {
            ToolEnqueue::register_script( $scripts );
        }
    }

	public static function register_inline_style( $name = '', $data = '' )
    {
		if ( self::check() ) {
            ToolEnqueue::register_inline_style( $name, $data );
        }
    }

	public static function check()
    {
        $lang = WPMLMain::current_language();

        // $permission_lang = in_array( $lang, [ 'ke', 'ro', 'en', 'ng', 'mx' ] );
        
        $permission_lang = true;
        
        return $permission_lang;
    }

	public static function register()
    {
        BaseHeader::register();

        BaseFooter::register();
    }

    public static function get_menu_id( $location )
	{
		$locations = get_nav_menu_locations();

		$menu_id = ( !empty( $locations[ $location ] ) ? $locations[ $location ] : 0 );

		// $menu_id_translated = apply_filters( 'wpml_object_id', $menu_id, 'nav_menu' );
		
        $menu_id_translated = WPMLMain::translated_menu_id( $menu_id );

		return $menu_id_translated;
	}
}

?>