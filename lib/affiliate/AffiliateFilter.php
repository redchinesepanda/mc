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
		if ( MultisiteMain::check_multisite() )
		{
			if ( MultisiteBlog::check_main_domain() )
			{
				$handler = new self();

				add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_brand_type' ], 10, 2 );
		
				add_action( 'restrict_manage_posts', [ $handler, 'brand_type_filter' ] );
			}
		}
	}

	public static function set_brand_type( $post_id, $post )
    {
		$about = get_field( self::GROUP[ 'about' ] . '_' . self::ABOUT[ 'afillate' ], $post_id );

		LegalDebug::die( [
			'AffiliateFilter' =>'set_brand_type',

			'about' => $about,
		] );

		// if ( $about )
		// {
		// 	if ( $about[ self::ABOUT[ 'afillate' ] ] )
		// 	{

		// 	}
		// }


        // $brand_id = get_field( self::FIELD[ 'brand' ], $post_id );

		// if ( $brand_id )
		// {
		// 	$term = self::get_brand_term();

		// 	// LegalDebug::debug( [
		// 	// 	'BrandFilter' => 'set_brand_type',

		// 	// 	'brand_id' => $brand_id,

		// 	// 	'term' => $term,
		// 	// ] );

		// 	$term_ids = [];

		// 	if ( ! empty( $term ) )
		// 	{
		// 		if ( ! has_term( $term, self::TAXONOMY[ 'type' ], $brand_id ) )
		// 		{
		// 			$term_ids = wp_set_object_terms( $brand_id, $term, self::TAXONOMY[ 'type' ], true );
		// 		}
		// 	}

		// 	// LegalDebug::die( [
		// 	// 	'BrandFilter' => 'set_brand_type',

		// 	// 	'term_ids' => $term_ids,
		// 	// ] );
		// }
    }

	public static function brand_type_filter()
	{
		BrandFilter::brand_type_filter( self::POST_TYPE[ 'affiliate' ] );
	}
}

?>