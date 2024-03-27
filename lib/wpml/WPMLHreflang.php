<?php

class WPMLHreflang
{
	public static function register()
    {
		if ( ToolNotFound::check_domain_restricted() )
		{
			$handler = new self();

			// add_filter( 'wpml_hreflangs', [ $handler, 'legal_hreflang_domain' ] );

			add_filter( 'wpml_hreflangs', [ $handler, 'legal_hreflang_x_default' ] );
		}
    }

	public static function legal_hreflang_domain( $hreflang_items )
	{
		// LegalDebug::debug( [
		// 	'WPMLHreflang' => 'legal_hreflang_domain',

		// 	'hreflang_items' => $hreflang_items,
		// ] );

		if ( ToolNotFound::check_domain_restricted() )
		{
			$current_host = ToolRobots::get_host();

			$main_host = LegalMain::get_main_host();

			foreach ( $hreflang_items as $hreflang => $url )
			{
				if ( $hreflang != 'x-default' )
				{
					$code = self::get_language_from_url( $url );

					$replace_host = $main_host;

					if ( $restricted_host = ToolNotFound::get_restricted_language_host( $code ) )
					{
						$replace_host = $restricted_host;
					}

					$hreflang_items[ $hreflang ] = str_replace( $current_host, $replace_host, $url );
				}
			}
		}

		return $hreflang_items;
	}

	public static function get_language_from_url( $href )
	{
		$parsed_url = parse_url( $href );

		// LegalDebug::debug( [
		// 	'WPMLHreflang' => 'get_language_from_url',

		// 	'parsed_url' => $parsed_url,
		// ] );

		$matches = [];

		preg_match('/(\/[a-z]{2}(-[a-z]{2})?\/)/', $href, $matches);

		if ( !empty( $matches ) )
		{
			return trim( array_shift( $matches ), '/' );
		}

		return '';
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