<?php

class AdminWPML
{
	public static function register()
	{
		$handler = new self();
		
        // add_action( 'wpml_admin_language_switcher_items', [ $handler, 'mc_wpml_admin_language_switcher_items' ] );
        
		// add_action( 'admin_bar_menu', [ $handler, 'mc_admin_bar_menu' ] );
	}

	// public static function mc_admin_bar_menu( $wp_admin_bar )
	// {
	// 	LegalDebug::debug( [
	// 		'AdminWPML' =>'mc_admin_bar_menu',

	// 		'$wp_admin_bar' => $wp_admin_bar,
	// 	] );

	// 	return $wp_admin_bar;
	// }

	public static function mc_wpml_admin_language_switcher_items( $items )
	{
		foreach( $items as $language => $item )
		{
			if ( !empty( $item[ 'flag' ] ) )
            {
				$items[ $language ][ 'flag' ] = str_replace( "img ", 'img loading="lazy" ', $item[ 'flag' ] );
            }

			// LegalDebug::debug( [
			// 	'AdminWPML' => 'mc_wpml_admin_language_switcher_items',

			// 	'flag' => $items[ $language ][ 'flag' ],
			// ] );
		}

		LegalDebug::debug( [
			'AdminWPML' => 'mc_wpml_admin_language_switcher_items',

			'items' => $items,
		] );

		return $items;
	}
}

?>