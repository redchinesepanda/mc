<?php

require_once( 'BonusTemplateSingle.php' );

require_once( 'BonusAbout.php' );

require_once( 'BonusSummary.php' );

require_once( 'BonusRelated.php' );

require_once( 'BonusTemplateSingle.php' );

require_once( 'BonusFeatured.php' );

require_once( 'BonusDuration.php' );

require_once( 'BonusContent.php' );

require_once( 'BonusCategories.php' );

require_once( 'BonusPreview.php' );

class BonusMain
{
	const TEXT = [
		'actual-bonuses' => 'Actual Bonuses',

		'best-bookmaker-bonuses' => 'Best Bookmaker Bonuses',

		'bonus-amount' => 'Bonus amount',

		'bonus-preview' => 'Bonus Preview',

		'bonus-logo' => 'Bonus Logo',
		
		'bookmaker' => 'Bookmaker',

		'claim-bonus' => 'Claim Bonus',

		'get-bonus' => 'Get Bonus',

		'min-deposit' => 'Min. deposit',

		'more-information' => 'More Information',

		'other-bonuses' => 'Other bonuses',

		'promotion-expired' => 'Promotion Expired',

		'promotion-period' => 'Promotion period',

		'published' => 'Published',

		'similar-bonuses' => 'Similar Bonuses',

		'till' => 'till',

		'indefinitely' => 'indefinitely',

		'wagering' => 'Wagering',
	];

	public static function register_style( $styles = [] )
    {
        if ( self::check() )
		{
			if ( empty( $styles ) )
			{
                $styles = self::CSS;
            }

            ToolEnqueue::register_style( $styles );
        }
    }
	
	public static function check_not_admin()
    {
		return !is_admin();
    }

	public static function check_post_type()
    {
		return is_singular( [ 'post' ] );
    }

	const CATEGORY = [
		'bonusy',

		'bonusy-kz',

		'bonusy-by',
	];

	public static function check_category()
    {
		return has_category( self::CATEGORY );
    }

	public static function check()
    {
		// LegalDebug::debug( [
		// 	'function' => 'BonusMain::check',

		// 	'check_not_admin' => self::check_not_admin(),

		// 	'check_post_type' => self::check_post_type(),

		// 	'check_category' => self::check_category(),
		// ] );

        return self::check_not_admin() && self::check_post_type() && self::check_category();
    }

	public static function register_functions()
    {
		BonusFeatured::register_functions();

		BonusPreview::register_functions();

		BonusRelated::register_functions();

		BonusAbout::register_functions();

		BonusDuration::register_functions();
	}

	public static function register()
    {
        BonusAbout::register();

		BonusSummary::register();

		BonusRelated::register();

		BonusTemplateSingle::register();

		BonusFeatured::register();

		BonusDuration::register();

		BonusContent::register();

		BonusCategories::register();

		BonusPreview::register();
    }

	public static function get_id()
    {
		$post = get_post();

        if ( !empty( $post ) )
        {
            return $post->ID;
        }

        return 0;
    }
}

?>