<?php

class AffiliateFilter
{
	const GROUP = [
        'about' => 'review-about',
    ];

	const ABOUT = [
		'afillate' => 'about-afillate',
	];

	const POST_TYPE = [
		'affiliate' => 'affiliate-links',

		'billet' => 'legal_billet',
	];

	public static function register_functions_admin()
	{
		// if ( MultisiteMain::check_multisite() )
		// {
		// 	if ( MultisiteBlog::check_main_domain() )
		// 	{
		// 		$handler = new self();

		// 		add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_brand_type' ], 10, 2 );
		
		// 		// add_action( 'restrict_manage_posts', [ $handler, 'brand_type_filter' ] );
		// 	}
		// }
	}

	public static function get_affiliate_id( $post_id )
	{
		return get_field( self::GROUP[ 'about' ] . '_' . self::ABOUT[ 'afillate' ], $post_id, false );
	}

	public static function set_brand_type( $post_id, $post )
    {
		$affiliate_id = self::get_affiliate_id( $post_id );

		// LegalDebug::debug( [
		// 	'AffiliateFilter' =>'set_brand_type',

		// 	'affiliate_id' => $affiliate_id,
		// ] );

		if ( $affiliate_id )
		{
			$term = BrandFilter::get_brand_term();

			// LegalDebug::debug( [
			// 	'BrandFilter' => 'set_brand_type',

			// 	'brand_id' => $brand_id,

			// 	'term' => $term,
			// ] );

			$term_ids = [];

			if ( ! empty( $term ) )
			{
				if ( ! has_term( $term, BrandFilter::TAXONOMY[ 'type' ], $affiliate_id ) )
				{
					$term_ids = wp_set_object_terms( $affiliate_id, $term, BrandFilter::TAXONOMY[ 'type' ], true );
				}
			}

			// LegalDebug::die( [
			// 	'BrandFilter' => 'set_brand_type',

			// 	'term_ids' => $term_ids,
			// ] );
		}
    }

	// public static function brand_type_filter()
	// {
	// 	BrandFilter::brand_type_filter( self::POST_TYPE[ 'affiliate' ] );
	// }
}

?>