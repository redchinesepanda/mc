<?php

class AdminWPML
{
	public static function register()
	{
		$handler = new self();
		
        add_action( 'wpml_admin_language_switcher_items', [ $handler, 'mc_wpml_admin_language_switcher_items' ] );
	}

	public static function mc_wpml_admin_language_switcher_items( $items )
	{
		// LegalDebug::debug( [
		// 	'AdminWPML' =>'mc_wpml_admin_language_switcher_items',

		// 	'$items' => $items,
		// ] );

		foreach( $items as $language => $item )
		{
			if ( !empty( $item[ 'flag' ] ) )
            {
				// LegalDebug::debug( [
				// 	'AdminWPML' =>'mc_wpml_admin_language_switcher_items',

				// 	'flag' => $item[ 'flag' ],
				// ] );
				
                $items[ $language ][ 'flag' ] = str_replace( "<img ", '<img loading="lazy" ', $item[ 'flag' ] );

				LegalDebug::debug( [
					'AdminWPML' =>'mc_wpml_admin_language_switcher_items',

					'flag' => $items[ $language ][ 'flag' ],
				] );
            }
		}

		return $items;
	}
}

?>