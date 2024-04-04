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

	public static function check_not_language( $href )
	{
		return !self::check_language( $href );
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
		
		$filtered = array_filter( iterator_to_array( $nodes ), [ $handler, 'check_doamin_and_language' ] );

		foreach ( $filtered as $node )
		{
			$href = apply_filters( 'mc_url_restricted', $node->getAttribute( self::ATTRIBUTE[ 'href' ] ) );

			$node->setAttribute( self::ATTRIBUTE[ 'href' ], $href );

			LegalDebug::debug( [
				'ReviewRestricted' => 'replace_domain_and_language',

				'href' => $href,
			] );
		}
	}

	public static function check_domain_and_not_language( $item )
	{
		$href = $item->getAttribute( self::ATTRIBUTE[ 'href' ] );

		LegalDebug::debug( [
			'ReviewRestricted' => 'check_domain_and_not_language',

			'href' => $href,

			'check_domain' => self::check_domain( $href ),

			'check_not_language' => self::check_not_language( $href ),
        ] );

		return self::check_domain( $href )
		
			&& self::check_not_language( $href );
	}

	public static function replace_node( $new, $old )
	{
		try
		{
			$replace->parentNode->replaceChild( $new, $old );
		}
		catch ( DOMException $e )
		{
			LegalDebug::debug( [
				'ReviewRestricted' => 'replace_node',

				'node' => substr( $old->textContent, 0, 30 ),

				'message' => $e->getMessage(),
			] );
		}
	}

	const CLASSES = [
		'replaced-anchor' => 'legal-replaced-anchor'
	];

	public static function get_item( $node, $dom )
	{
		$item = $dom->createElement( 'span' );

		$item->setAttribute( 'class', self::CLASSES[ 'replaced-anchor' ] );

		$item->textContent = $node->textContent;

		return $item;
	}

	public static function replace_domain_and_not_language( $nodes, $dom )
	{
		$handler = new self();

		$filtered = array_filter( iterator_to_array( $nodes ), [ $handler, 'check_domain_and_not_language' ] );

		foreach ( $filtered as $node )
		{
			$href = $node->getAttribute( self::ATTRIBUTE[ 'href' ] );

			LegalDebug::debug( [
				'ReviewRestricted' => 'replace_domain_and_language',

				'href' => $href,
			] );

			$item = self::get_item( $node, $dom );

			self::replace_node( $item, $node );
		}
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

		self::replace_domain_and_not_language( $nodes, $dom );

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