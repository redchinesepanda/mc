<?php

class ToolReviewCTA
{
	public static function register_functions_admin()
	{
		// if ( MultisiteMain::check_multisite() )
		// {
		// 	$handler = new self();
	
		// 	add_filter( 'bulk_actions-edit-page', [ $handler, 'add_anchor_href_item' ] );
	
		// 	add_filter( 'handle_bulk_actions-edit-page', [ $handler, 'handle_anchor_href_item' ], 10, 3);
	
		// 	add_action( 'admin_notices', [ $handler, 'notify_anchor_href_item' ] );
		// }

		self::get_data_csv();
    }

	public static function get_data_csv()
	{
		$path = LegalMain::LEGAL_PATH . '/assets/data/review/cta.csv';

		$result = [];

		// $row_index = 1;

		if ( ( $handle = fopen( $path, "r" ) ) !== FALSE)
		{
			while ( ( $row = fgetcsv( $handle, 1000, ',' ) ) !== false )
			{
				$num = count( $row );

				$result[] = $row;

				// $row_index++;

				// for ( $c=0; $c < $num; $c++ )
				// {
				// 	echo $row[ $c ] . "<br />\n";
				// }
			}

			fclose( $handle );
		}

		LegalDebug::debug( [
			'ToolReviewCTA' => 'get_data_csv-1',

			'result' => $result,
		] );
	}
}

?>