<?php

class AdminPage
{
	public static function register()
    {
        $handler = new self();

        add_action( 'wp_list_pages', [ $handler, 'list_pages_filter' ], 10, 3 );
    }

	public static function list_pages_filter( $output, $parsed_args, $pages )
	{
		LegalDebug::debug( [
			'AdminPage' => 'list_pages_filter-1',

			'pages' => $pages,
		] );
		
		return $output;
	}
}

?>