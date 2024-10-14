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

	public static function check_cta_current_language( $cta_item )
    {
		$language = MultisiteSiteOptions::get_blog_language();

		LegalDebug::debug( [
			'ToolReviewCTA' => 'check_cta_current_language-1',

			'language' => $language,

			'cta_item-language' => $cta_item[ 0 ],
		] );

        return strtolower( $cta_item[ 0 ] ) == $language;
    }

    public static function filter_cta_current_language( $cta_data )
    {
        // $language = MultisiteSiteOptions::get_blog_language();

        $handler = new self();

        return array_filter( $cta_data, [ $handler, 'check_cta_current_language' ] );
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

		LegalDebug::debug( [
			'ToolReviewCTA' => 'get_cta_csv-1',

			'result' => $result,
		] );
	}

	public static function get_cta_data()
	{
		$cta_data = self::get_cta_csv();

		$cta_data = self::filter_cta_current_language( $cta_data );

		LegalDebug::debug( [
			'ToolReviewCTA' => 'get_cta_data-1',

			'cta_data' => $cta_data,
		] );
	}
}

?>