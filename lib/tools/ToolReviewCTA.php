<?php

class ToolReviewCTA
{
	public static function register_functions_admin()
	{
		if ( MultisiteMain::check_multisite() )
		{
		// 	$handler = new self();
	
		// 	add_filter( 'bulk_actions-edit-page', [ $handler, 'add_anchor_href_item' ] );
	
		// 	add_filter( 'handle_bulk_actions-edit-page', [ $handler, 'handle_anchor_href_item' ], 10, 3);
	
		// 	add_action( 'admin_notices', [ $handler, 'notify_anchor_href_item' ] );

			self::get_cta_data();
		}
    }

	const CTA_FIELDS = [
		'location' => 0,
		'bookmaker' => 1,
		'license' => 2,
		'regulator' => 3,
		'date-founded' => 4,
		'apps' => 5,
		'min-deposit' => 6,
		'margin' => 7,
	];

	public static function filter_cta_bookmaker( $cta_data, $bookmaker_name )
    {
        return array_filter( $cta_data, function( $cta_item ) use ( $bookmaker_name )
        {
            return $cta_item[ self::CTA_FIELDS[ 'bookmaker' ] ] == $bookmaker_name;
		} );
    }

	public static function filter_cta_current_language( $cta_data )
    {
		$current_language = MultisiteSiteOptions::get_blog_language();

        return array_filter( $cta_data, function( $cta_item ) use ( $current_language )
        {
			$cta_item_language = strtolower( $cta_item[ self::CTA_FIELDS[ 'location' ] ] );

			if ( $cta_item_language == 'uk' )
			{
				$cta_item_language = 'en';
			}

            return $cta_item_language == $current_language;
		} );
    }

	// public static function check_cta_current_language( $cta_item )
    // {
	// 	$current_language = MultisiteSiteOptions::get_blog_language();

	// 	$cta_item_language = strtolower( $cta_item[ self::CTA_FIELDS[ 'location' ] ] );

	// 	if ( $cta_item_language == 'uk' )
	// 	{
	// 		$cta_item_language = 'en';
	// 	}

	// 	// LegalDebug::debug( [
	// 	// 	'ToolReviewCTA' => 'check_cta_current_language-1',

	// 	// 	'current_language' => $current_language,

	// 	// 	'cta_item_language' => $cta_item_language,
	// 	// ] );

    //     return $cta_item_language == $current_language;
    // }

    // public static function filter_cta_current_language( $cta_data )
    // {
    //     // $language = MultisiteSiteOptions::get_blog_language();

    //     $handler = new self();

    //     return array_filter( $cta_data, [ $handler, 'check_cta_current_language' ] );
    // }

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

	public static function get_cta_data()
	{
		$cta_data = self::get_cta_csv();

		$cta_data = self::filter_cta_current_language( $cta_data );

		$bookmaker_name = '10bet';

		$cta_data = self::filter_cta_bookmaker( $cta_data, $bookmaker_name );

		LegalDebug::debug( [
			'ToolReviewCTA' => 'get_cta_data-1',

			'cta_data' => $cta_data,
		] );
	}
}

?>