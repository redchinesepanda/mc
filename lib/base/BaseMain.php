<?php

require_once( 'BaseHeader.php' );

require_once( 'BaseFooter.php' );

class BaseMain
{
	const TEXT = [
        'accept-all' => 'Accept all cookies',

        'accept-necessary' => 'Accept only necessary cookies',

        'according-to-the-law' => 'According to the law, you have the right to use the services of this site only if you have reached the age of majority in your country',

		'all-countries' => 'All Countries',

		'all-rights-reserved' => 'All rights reserved',

        'bet-now' => 'Bet now',

		'betting-sites' => 'Betting Sites',

		'change-country' => 'Change country',

		'choose-your-country' => 'Choose your country',

		'сookies' => 'Cookies!',

        'do-you-confirm' => 'Do you confirm that you are already 18 years old?',

		'gambling-sites' => 'Gambling Sites',

        'hide' => 'Hide',

        'i-accept' => 'I Accept',

		'legal-review-bk-header' => 'Legal Review BK Header',

		'legal-review-bk-footer' => 'Legal Review BK Footer',

		'match-center' => 'Match.Center',

        'match-center-is-not' => '<p>Match.Cener is not a gambling operator (we do not accept any bets). The content of this website is strictly for information purposes and does not constitute advice. We only review gambling operators who are licenced by their respective local and international regulators. We only claim information to be correct at the time of posting.</p><p>Always gamble responsibly and never risk money that you can not afford to lose!</p>',

		'more-information' => 'More Information',

        'no' => 'No',

		'online-casinos' => 'Online Casinos',

		'oops-page-not-found' => 'Oops! Page Not Found',

        'ouch' => 'Ouch',

        'show-all' => 'Show All',

        'we-are-professionals' => 'Our team of casino and betting professionals brings years of experience to review and recommend the best online gambling sites in the UK.',

        'we-provide-only' => "We thoroughly investigate and provide transparent information about the sites we review because we value our readers' trust above all else.",

        'our-reviews' => 'Fairness is about being objective and equally treating all gambling products, established and new. We supply the facts and metrics, you make the decision.',

        'we-focus-on' => 'We focus on analysing and selecting relevant data for our readers, including many factors such as geographical location, preferred sports or game types, and more.',

        'expertise' => 'Expertise',

        'transparency' => 'Transparency',

        'fairness' => 'Fairness',

        'relevance' => 'Relevance',

        'this-bookie' => "This bookie doesn't pay for the referral program. But here are the offers of Match.Center partners",

        'this-website' => 'This website is only for adults.',

        'to-give' => 'To give you the best possible experience, this site uses cookies and by continuing to use the site you agree that we can save them on your device. By clicking "I Accept" you consent to the use of cookies unless you have disabled them.',

        'we-are-sorry' => 'We are sorry, we cannot allow minors access to our website.',

        'what-is' => 'What is Match.Center?',

        'yes' => 'Yes',
        
        'you-must-be' => 'You must be 18 years or older to access this website. It is part of our commitment to responsible gaming.',

		'you-must-have' => "You must have picked the wrong door because I haven't been able to lay my eye on the page you've been searching for.",

        'you-re-of' => "You're of age",
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
        // $lang = WPMLMain::current_language();

        // $permission_lang = in_array( $lang, [ 'ke', 'ro', 'en', 'ng', 'mx' ] );
        
        $permission_lang = true;
        
        return $permission_lang;
    }

    public static function register_functions()
	{
		BaseHeader::register_functions();

        BaseFooter::register_functions();
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