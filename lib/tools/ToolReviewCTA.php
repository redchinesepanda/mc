<?php

class ToolReviewCTA
{
	const CTA_CSV_FIELDS = [
		'location' => 0,

		'bookmaker' => 1,

		'license' => 2,

		'regulator' => 3,

		'date-founded' => 4,

		'apps' => 5,

		'min-deposit' => 6,
		
		'margin' => 7,
	];

	const POST_TYPE = [
		'page' => 'page',

		// 'post' => 'post',
	];

	const ACTION = [
        'set-cta-fields'=> 'set-cta-fields',

        'done-cta-fields'=> 'done-cta-fields',
    ];

	public static function register_functions_admin()
	{
		if ( MultisiteMain::check_multisite() )
		{
			$handler = new self();
	
			add_filter( 'bulk_actions-edit-' . self::POST_TYPE[ 'page' ], [ $handler, 'add_cta_fields_item' ] );

			add_filter( 'handle_bulk_actions-edit-' . self::POST_TYPE[ 'page' ], [ $handler, 'handle_cta_fields_item' ], 10, 3);

			add_action( 'admin_notices', [ $handler, 'notify_cta_fields_item' ] );

			// self::get_cta_data_item();
		}
    }

	public static function add_cta_fields_item( $bulk_actions )
    {
    	$bulk_actions[ self::ACTION[ 'set-cta-fields' ] ] = ToolLoco::translate( 'Set CTA Fields' );

    	return $bulk_actions;
    }
	
	public static function redirect_clean( $redirect )
	{
		return remove_query_arg( self::ACTION, $redirect );
	}

	public static function handle_cta_fields_item( $redirect_url, $action, $post_ids )
    {
        if ( $action == self::ACTION[ 'set-cta-fields' ] )
        {
            $redirect_url = self::redirect_clean( $redirect_url );
    	
    		foreach ( $post_ids as $post_id )
            {
    			$post = get_post( $post_id );

                if ( $post )
                {
					// LegalDebug::debug( [
					// 	'ToolAnchorAttributes' => 'handle_cta_fields_item',

					// 	'post_id' => $post_id,
					// ] );

                    self::modify_fields( $post_id, $post );
                }
    		}

    		$redirect_url = add_query_arg( self::ACTION[ 'done-cta-fields' ], count( $post_ids ), $redirect_url );
    	}

    	return $redirect_url;
    }

	public static function notify_cta_fields_item()
    {
    	if ( ! empty( $_REQUEST[ self::ACTION[ 'done-cta-fields' ] ] ) )
        {
    		$num_changed = (int) $_REQUEST[ self::ACTION[ 'done-cta-fields' ] ];

    		$message = sprintf( ToolLoco::translate( 'CTA Fields set for %d posts' ), $num_changed );

            $args = [
                'message' => $message,
			];

            self::print_notices( $args );
    	}
    }

	public static function filter_cta_bookmaker( $cta_data, $bookmaker_name )
    {
        return array_filter( $cta_data, function( $cta_item ) use ( $bookmaker_name )
        {
            return $cta_item[ self::CTA_CSV_FIELDS[ 'bookmaker' ] ] == $bookmaker_name;
		} );
    }

	public static function filter_cta_current_language( $cta_data )
    {
		$current_language = MultisiteSiteOptions::get_blog_language();

        return array_filter( $cta_data, function( $cta_item ) use ( $current_language )
        {
			$cta_item_language = strtolower( $cta_item[ self::CTA_CSV_FIELDS[ 'location' ] ] );

			if ( $cta_item_language == 'uk' )
			{
				$cta_item_language = 'en';
			}

            return $cta_item_language == $current_language;
		} );
    }

	public static function get_cta_csv()
	{
		$path = LegalMain::LEGAL_PATH . '/assets/data/review/cta.csv';

		$result = [];

		if ( ( $handle = fopen( $path, 'r' ) ) !== FALSE)
		{
			while ( ( $row = fgetcsv( $handle, 1000, ',' ) ) !== false )
			{
				$num = count( $row );

				$result[] = $row;
			}

			fclose( $handle );
		}

		// LegalDebug::debug( [
		// 	'ToolReviewCTA' => 'get_cta_csv-1',

		// 	'result' => $result,
		// ] );

		return $result;
	}

	public static function get_cta_data_item( $bookmaker_name = '' )
	{
		$cta_data = self::get_cta_csv();

		$cta_data = self::filter_cta_current_language( $cta_data );

		$bookmaker_name = '10bet';

		if ( ! empty( $bookmaker_name ) )
		{
			$cta_data = self::filter_cta_bookmaker( $cta_data, $bookmaker_name );
		}

		// LegalDebug::debug( [
		// 	'ToolReviewCTA' => 'get_cta_data-1',

		// 	'cta_data' => $cta_data,
		// ] );

		if ( ! empty( $cta_data ) && count( $cta_data ) == 1 )
		{
			return array_shift( $cta_data );
		}

		return null;
	}

	const CTA_ACF_FIELDS = [
        'license' => 'review-cta-license',
		
        'regulator' => 'review-cta-regulator',

        'date-founded' => 'review-cta-date-founded',

        'apps' => 'review-cta-apps',

        'min-deposit' => 'review-cta-min-deposit',

        'margin' => 'review-cta-margin',
	];

	public static function update_cta_fields( $cta_item, $post_id )
	{
		update_field( self::CTA_ACF_FIELDS[ 'license' ], $cta_item[ self::CTA_CSV_FIELDS[ 'license' ] ], $post_id );
		
		update_field( self::CTA_ACF_FIELDS[ 'regulator' ], $cta_item[ self::CTA_CSV_FIELDS[ 'regulator' ] ], $post_id );

		update_field( self::CTA_ACF_FIELDS[ 'date-founded' ], $cta_item[ self::CTA_CSV_FIELDS[ 'date-founded' ] ], $post_id );

		update_field( self::CTA_ACF_FIELDS[ 'apps' ], $cta_item[ self::CTA_CSV_FIELDS[ 'apps' ] ], $post_id );

		update_field( self::CTA_ACF_FIELDS[ 'min-deposit' ], $cta_item[ self::CTA_CSV_FIELDS[ 'min-deposit' ] ], $post_id );

		update_field( self::CTA_ACF_FIELDS[ 'margin' ], $cta_item[ self::CTA_CSV_FIELDS[ 'margin' ] ], $post_id );
	}

	public static function modify_fields( $post_id, $post )
	{
		$bookmaker_name = ReviewAbout::get_title( $post_id );

		$cta_item = self::get_cta_data_item( $bookmaker_name );

		if ( ! empty( $cta_item ) )
		{
			self::update_cta_fields( $cta_item, $post_id );
		}
	}

	const TEMPLATE = [
        'cta-fields-notices' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-cta-fields-notices.php',
    ];

    public static function print_notices( $args )
    {
        LegalComponents::print_main( self::TEMPLATE[ 'cta-fields-notices' ], $args );
    }
}

?>