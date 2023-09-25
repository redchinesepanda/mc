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
		'best-bookmaker-bonuses' => 'Best Bookmaker Bonuses',

		'bonus-amount' => 'Bonus amount',

		'bonus-preview' => 'Bonus Preview',

		'bonus-logo' => 'Bonus Logo',
		
		'bookmaker' => 'Bookmaker',

		'claim-bonus' => 'Claim Bonus',

		'get-bonus' => 'Get Bonus',

		'min-deposit' => 'Min. deposit',

		'promotion-expired' => 'Promotion Expired',

		'promotion-period' => 'Promotion period',

		'published' => 'Published',

		'similar-bonuses' => 'Similar Bonuses',

		'till' => 'till',

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

	public static function check()
    {
        $permission_admin = !is_admin();

        $permission_post_type = is_singular( [ 'page', 'post' ] );
        
        return $permission_admin && $permission_post_type;
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