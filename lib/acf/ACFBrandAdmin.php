<?php

class ACFBrandAdmin
{
	const POST_TYPES = [
		'billet' => 'edit-legal_billet',

		'page' => 'edit-page',
	];

	const DOACTION = [
		'search-brands' => 'mc_search_brands',
	];
	
	const TEXT = [
		'search-brands' => 'Search Brands',
	];

	public static function register()
    {
        $handler = new self();
        
        add_filter( 'bulk_actions-' . self::POST_TYPE[ 'billet' ], [ $handler, 'mc_bulk_brand_actions' ], 10, 2 );
        
        add_filter( 'bulk_actions-' . self::POST_TYPE[ 'page' ], [ $handler, 'mc_bulk_brand_actions' ], 10, 2 );

		add_action( 'admin_notices', [ $handler, 'mc_bulk_multisite_notices' ] );
    }

	public static function mc_bulk_brand_actions( $bulk_array )
	{
		$bulk_array = array_merge( $bulk_array, [
			self::DOACTION[ 'search-brands' ] => ToolLoco::translate( self::TEXT[ 'search-brands' ] ),
		] );

		return $bulk_array;
	}

	public static function mc_bulk_updated_notices()
	{
		if ( $request_updated = self::check_request_updated( $_REQUEST ) )
		{
			$message = self::get_message(
				MultisiteMain::TEXT_PLURAL[ 'post-has-been-updated' ],

				[
					$request_updated,
				]
			);
			
			$args = [
                'message' => $message,
			];

			self::print_notices( $args );
		}
	}
}

?>