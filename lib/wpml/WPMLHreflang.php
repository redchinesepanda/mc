<?php

class WPMLHreflang
{
	public static function register()
    {
		// if ( !ToolNotFound::check_domain_restricted() )
		// {
		// 	return false;
		// }

		if ( MiltisiteMain::check_multisite() )
        {
			$handler = new self();

			add_filter( 'wpml_hreflangs', [ $handler, 'change_page_hreflang' ] );
		}

		// add_filter( 'wpml_hreflangs', [ $handler, 'legal_hreflang_domain' ] );

		// // add_filter( 'wpml_hreflangs', [ $handler, 'legal_hreflang_x_default' ] );

		// return true;
    }
  
    public static function change_page_hreflang( $hreflang_items )
    {
		$hreflang = [];

		if ( MiltisiteMain::check_multisite() )
		{
			return $hreflang;
		}

        if ( !empty( $hreflang_items ) )
        {
			if ( $post = get_post() )
			{
				$multisite_items = MultisiteHreflang::get_group_items_all( $post->ID );

				$multisite_hreflang = MultisiteHreflang::parse_hreflang( $multisite_items );

				// $multisite_hreflang = MultisiteHreflang::get_group_items_all( $post->ID );

				// LegalDebug::debug( [
				// 	'WPMLHreflang' => 'change_page_hreflang',

				// 	'hreflang_items' => $hreflang_items,

				// 	'multisite_hreflang' => $multisite_hreflang,
				// ] );

				// $items = self::get_group_items_all( $post->ID );

				// $args = [
				// 	'items' => self::parse_hreflang( $items ),
				// ];
				
				foreach ( $multisite_hreflang as $item )
				{
					// if ( $item_locale == 'en_GB' )
					// {
					// 	$item_locale = 'x-default';
					// }

					$hreflang = $item[ 'hreflang' ];

					// LegalDebug::debug( [
					// 	'WPMLHreflang' => 'change_page_hreflang',
	
					// 	'hreflang_code' => $hreflang_code,
	
					// 	'array_key_exists' => array_key_exists( $hreflang_code, $hreflang_items ),
					// ] );

					if ( array_key_exists( $hreflang, $hreflang_items ) )
					{
						unset( $hreflang_items[ $hreflang ] );
					}
					
					// $hreflang[] = '<link rel="alternate" hreflang="' . esc_attr( $hreflang_code ) . '" href="' . esc_url( $hreflang_url ) . '">' . PHP_EOL;
				}
			}
    
            // echo apply_filters( 'wpml_hreflangs_html', implode( '', $hreflang ) );
        }
            
        // return false;

		return $hreflang_items;
    }

	// public static function check_hreflang_exists( $hreflang_items, $language )
	// {
	// 	$hreflang_exists = false;

	// 	foreach( $hreflang_items as $hreflang => $url )
	// 	{
	// 		$code = self::get_language_from_url( $url );

	// 		if ( $code == $language )
	// 		{
	// 			$hreflang_exists = $hreflang;

	// 			break;
	// 		}
	// 	}

	// 	return $hreflang_exists;
	// }

	// public static function modify_url_main( &$hreflang_items, $current_host, $main_host )
	// {
	// 	$restricted_languages = ToolNotFound::get_restricted_languages();

	// 	foreach( $restricted_languages as $language )
	// 	{
	// 		if ( $hreflang = self::check_hreflang_exists( $hreflang_items, $language ) )
	// 		{
	// 			$restricted_host = ToolNotFound::get_restricted_language_host( $language );

	// 			$hreflang_items[ $hreflang ] = str_replace( $current_host, $restricted_host, $hreflang_items[ $hreflang ] );

	// 			$replace_code = ToolNotFound::get_default_language( $restricted_host );

	// 			$hreflang_items[ $hreflang ] = str_replace( '/' . $replace_code . '/', '/', $hreflang_items[ $hreflang ] );
	// 		}
	// 	}
	// }

	// public static function modify_url_restricted( &$hreflang_items, $current_host, $main_host )
	// {
	// 	foreach ( $hreflang_items as $hreflang => $url )
	// 	{
	// 		if ( $hreflang != 'x-default' )
	// 		{
	// 			$code = self::get_language_from_url( $url );

	// 			if ( empty( $code ) )
	// 			{
	// 				$code = WPMLMain::current_language();
	// 			}

	// 			$replace_host = $main_host;

	// 			if ( $restricted_host = ToolNotFound::get_restricted_language_host( $code ) )
	// 			{
	// 				$replace_host = $restricted_host;
	// 			}
				
	// 			$hreflang_items[ $hreflang ] = str_replace( $current_host, $replace_host, $url );

	// 			$replace_code = ToolNotFound::get_default_language( $replace_host );

	// 			$hreflang_items[ $hreflang ] = str_replace( '/' . $replace_code . '/', '/', $hreflang_items[ $hreflang ] );
	// 		}
	// 	}
	// }

	// public static function clear_hreflang( $hreflang_items )
	// {
	// 	$hreflang = strtolower( WPMLMain::get_hreflang() );

	// 	if ( array_key_exists( $hreflang, $hreflang_items ) )
	// 	{
	// 		return [
	// 			$hreflang => $hreflang_items[ $hreflang ],

	// 			'x-default' => $hreflang_items[ $hreflang ],
	// 		];
	// 	}

	// 	return $hreflang_items;
	// }

	// public static function legal_hreflang_domain( $hreflang_items )
	// {
	// 	$current_host = ToolRobots::get_host();

	// 	$main_host = LegalMain::get_main_host();

	// 	if ( ToolNotFound::check_domain_restricted() )
	// 	{
	// 		$hreflang_items = self::clear_hreflang( $hreflang_items );

	// 		self::modify_url_restricted( $hreflang_items, $current_host, $main_host );
	// 	}
	// 	else
	// 	{
	// 		self::modify_url_main( $hreflang_items, $current_host, $main_host );
	// 	}

	// 	return $hreflang_items;
	// }

	// public static function get_language_from_url( $href )
	// {
	// 	$parsed_url = parse_url( $href );

	// 	// LegalDebug::debug( [
	// 	// 	'WPMLHreflang' => 'get_language_from_url',

	// 	// 	'parsed_url' => $parsed_url,
	// 	// ] );

	// 	$matches = [];

	// 	preg_match('/(\/[a-z]{2}(-[a-z]{2})?\/)/', $href, $matches);

	// 	if ( !empty( $matches ) )
	// 	{
	// 		return trim( array_shift( $matches ), '/' );
	// 	}

	// 	return '';
	// }

	// public static function legal_hreflang_x_default( $hreflang_items )
	// {
	// 	if ( empty( $hreflang_items[ 'x-default' ] ) && is_singular() )
	// 	{
	// 		// LegalDebug::debug( [
	// 		// 	'function' => 'WPMLHreflang::legal_hreflang_x_default',

	// 		// 	'message' => 'x-default is empty',
	// 		// ] );

	// 		// $post_type = 'post_' . get_post_type();

	// 		// $translations = apply_filters('wpml_get_element_translations', [], apply_filters('wpml_element_trid', false, get_the_ID(), $post_type), $post_type);

	// 		// if ( !empty( $translations ) )
	// 		// {
	// 		// 	foreach ( $translations as $lang => $item )
	// 		// 	{
	// 		// 		if ( empty( $item->source_language_code ) )
	// 		// 		{
	// 		// 			$x_default = $lang;

	// 		// 			break;
	// 		// 		}
	// 		// 	}
	// 		// }
	  
	// 		// if ( isset( $x_default, $hreflang_items[ $x_default ] ) )
	// 		// {
	// 		// 	$hreflang_items[ 'x-default' ] = $hreflang_items[ $x_default ];
	// 		// }
	// 	}
	  
	// 	return $hreflang_items;
	// }
}

?>