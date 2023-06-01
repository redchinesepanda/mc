<?php

class WPMLMenu
{
	public static function register()
	{
        $handler = new self();

		add_action( 'pre_get_posts', [ $handler, 'wpml_custom_query' ] );
    }

	public static function wpml_custom_query( $query )
	{
		if( is_search() ) {
			$query->query_vars['suppress_filters'] = true;

			LegalDebug::debug( [
				'suppress_filters' => $query->query_vars['suppress_filters'],
			] );
		}
	}
}

?>