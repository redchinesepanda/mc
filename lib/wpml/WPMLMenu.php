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
		if( !empty( $_POST[ 'action' ] ) ) {
			if( $_POST[ 'action' ] == 'menu-quick-search' ) {
				$query->query_vars[ 'suppress_filters' ] = true;

				$query->query_vars[ 'posts_per_page' ] = -1;
			}
		}
	}
}

?>