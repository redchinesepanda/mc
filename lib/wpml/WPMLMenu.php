<?php

class WPMLMenu
{
	public static function register()
	{
        $handler = new self();

		add_action( 'pre_get_posts', [ $handler, 'wpml_custom_query' ] );

		// LegalDebug::debug( [
		// 	'function' => 'WPMLMenu::register',
		// ] );
    }

	public static function wpml_custom_query( $query )
	{
		// LegalDebug::debug( [
		// 	'function' => 'WPMLMenu::wpml_custom_query',

		// 	'action' => $_POST[ 'action' ],
		// ] );

		// if( is_search() ) {
		
		if( !empty( $_POST[ 'action' ] ) ) {
			if( $_POST[ 'action' ] == 'menu-quick-search' ) {
				$query->query_vars['suppress_filters'] = true;

				LegalDebug::debug( [
					'function' => 'WPMLMenu::wpml_custom_query',

					'suppress_filters' => $query->query_vars['suppress_filters'],

					'query_vars' => $query->query_vars,
				] );
			}
		}
	}
}

?>