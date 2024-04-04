<?php

class ReviewRestricted
{
	public static function check_contains_restricted_anchors()
    {
		$result = false;

		$restricted = ToolNotFound::get_restricted();

		foreach ( $restricted as $host => $languages )
		{
			foreach ( $languages as $language )
			{
				if ( LegalComponents::check_contains( sprintf( self::FORMAT[ 'anchor' ], $language ) ) )
				{
					$result = true;
	
					break 2;
				}
			}
		}

        return $result;
    }

	public static function check_contains()
	{
		return self::check_contains_restricted_anchors();
	}

	public static function check_restricted()
	{
		return ToolNotFound::check_domain_restricted();
	}

	public static function register()
	{
		if ( self::check_restricted() )
		{
			$handler = new self();

			add_filter( 'mc_url_restricted', [ $handler, 'modify_href' ], 10, 2 );

			if ( self::check_contains() )
			{
				add_action( 'the_content', [ $handler, 'modify_content' ] );
			}
		}
	}

	public static function replace_href( &$href, $language, $host )
	{
		$pattern = sprintf( self::FORMAT[ 'anchor' ], $language );

		if ( str_contains( $href, $pattern ) )
		{
			$replace_host = parse_url( $href, PHP_URL_HOST );

			$href = str_replace( $replace_host, $host, $href );

			$href = str_replace( sprintf( self::FORMAT[ 'anchor' ], $language ), '/', $href );

			return true;
		}

		return false;
	}
	
	public static function modify_href( $href )
	{
		$restricted = ToolNotFound::get_restricted();

		foreach ( $restricted as $host => $languages )
		{
			foreach ( $languages as $language )
			{
				if ( self::replace_href( $href, $language, $host ) )
				{
					break 2;
				}
			}
		}

		return $href;
	}

	const ATTRIBUTE = [
		'href' => 'href',
	];

	// public static function check_item( $item )
	
	public static function check_domain( $href )
	{
		return BaseFooter::check_local( parse_url( $href, PHP_URL_HOST ) );
	}

	public static function check_language( $href )
	{
		return BaseFooter::check_language_contains( parse_url( $href, PHP_URL_PATH ) );
	}

	public static function check_doamin_and_language( $item )
	{
		$href = $item->getAttribute( self::ATTRIBUTE[ 'href' ] );

		// $url_host = parse_url( $href, PHP_URL_HOST );

		// return BaseFooter::check_local( $url_host );
		
		return self::check_domain( $href )
		
			&& self::check_language( $href );
	}

	// public static function check_current_language( $item )
	// {
	// 	return self::check_item( $item );
	// }

	// public static function filter_only_current_language( $items )
	// {
	// 	$handler = new self();

	// 	return array_filter( $items, [ $handler, 'check_current_language' ] );
	// }

	public static function replace_domain_and_language( $nodes )
	{
		$handler = new self();
		
		$filtered = array_filter( iterator_to_array( $nodes ), [ $handler, 'check_current_language' ] );

		foreach ( $filtered as $node )
		{
			$href = apply_filters( 'mc_url_restricted', $node->getAttribute( self::ATTRIBUTE[ 'href' ] ) );

			$node->setAttribute( self::ATTRIBUTE[ 'href' ], $href );
		}
	}

	public static function check_host_and_language( $item )
	{
		$href = $item->getAttribute( self::ATTRIBUTE[ 'href' ] );

		$url_host = parse_url( $href, PHP_URL_HOST );

		$url_path = parse_url( $href, PHP_URL_PATH );

		return BaseFooter::check_local( $url_host )
		
			&& self::check_language( $url_path );
	}

	public static function remove_anchors( $nodes )
	{
		$handler = new self();

		$filtered_nodes = array_filter( iterator_to_array( $nodes ), [ $handler, 'check_host_and_language' ] );
	}

	public static function modify_anchors( $dom )
	{
		$nodes = self::get_nodes_anchor( $dom );

		if ( $nodes->length == 0 )
		{
			return false;
		}

		self::replace_domain_and_language( $nodes );

		// $nodes = self::filter_only_current_language( iterator_to_array( $nodes ) );

		// foreach ( $nodes as $node )
		// {
		// 	$href = apply_filters( 'mc_url_restricted', $node->getAttribute( self::ATTRIBUTE[ 'href' ] ) );

		// 	$node->setAttribute( self::ATTRIBUTE[ 'href' ], $href );
		// }

		self::remove_anchors( $nodes );

		return true;
	}

	const FORMAT = [
		'anchor' => '/%s/',
		
		'node' => '//a[contains(@href,"%s")]',
	];

	public static function get_nodes_anchor( $dom )
	{
		$restricted = ToolNotFound::get_restricted_languages_all();

		$query = [];
		
		foreach ( $restricted as $language )
		{
			$query[] = sprintf( self::FORMAT[ 'node' ], $language );
		}

		return LegalDOM::get_nodes( $dom, implode( '|', $query ) );
	}

	public static function modify_content( $content )
    {
		$dom = LegalDOM::get_dom( $content ); 

		self::modify_anchors( $dom );

		return $dom->saveHTML( $dom );
    }
}

?>