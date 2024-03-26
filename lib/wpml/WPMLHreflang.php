<?php

class WPMLHreflang
{
	public static function register()
    {
        $handler = new self();

		add_filter( 'wpml_hreflangs', [ $handler, 'legal_hreflang_domain' ] );

		// add_filter( 'wpml_hreflangs', [ $handler, 'legal_hreflang_x_default' ] );
    }

	public static function legal_hreflang_x_default( $hreflang_items )
	{
		LegalDebug::debug( [
			'WPMLHreflang' => 'legal_hreflang_x_default',

			'hreflang_items' => $hreflang_items,
		] );

		return $hreflang_items;
	}

	public static function legal_hreflang_x_default( $hreflang_items )
	{
		if ( empty( $hreflang_items[ 'x-default' ] ) && is_singular() )
		{
			// LegalDebug::debug( [
			// 	'function' => 'WPMLHreflang::legal_hreflang_x_default',

			// 	'message' => 'x-default is empty',
			// ] );

			// $post_type = 'post_' . get_post_type();

			// $translations = apply_filters('wpml_get_element_translations', [], apply_filters('wpml_element_trid', false, get_the_ID(), $post_type), $post_type);

			// if ( !empty( $translations ) )
			// {
			// 	foreach ( $translations as $lang => $item )
			// 	{
			// 		if ( empty( $item->source_language_code ) )
			// 		{
			// 			$x_default = $lang;

			// 			break;
			// 		}
			// 	}
			// }
	  
			// if ( isset( $x_default, $hreflang_items[ $x_default ] ) )
			// {
			// 	$hreflang_items[ 'x-default' ] = $hreflang_items[ $x_default ];
			// }
		}
	  
		return $hreflang_items;
	}
}

?>