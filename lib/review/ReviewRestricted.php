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

	public static function check_domain( $href )
	{
		return BaseFooter::check_local( parse_url( $href, PHP_URL_HOST ) );
	}

	public static function check_not_domain( $href )
	{
		return !self::check_domain( $href );
	}

	public static function check_language( $href )
	{
		return BaseFooter::check_language_contains( parse_url( $href, PHP_URL_PATH ) );
	}

	public static function check_not_language( $href )
	{
		return !self::check_language( $href );
	}

	public static function filetr_doamin_and_language( $item )
	{
		$href = $item->getAttribute( self::ATTRIBUTE[ 'href' ] );
		
		return self::check_domain( $href )
		
			&& self::check_language( $href );
	}

	public static function modify_filtered( $nodes )
	{
		foreach ( $nodes as $node )
		{
			$href = apply_filters( 'mc_url_restricted', $node->getAttribute( self::ATTRIBUTE[ 'href' ] ) );

			LegalDebug::debug( [
				'ReviewRestricted' => 'modify_filtered',

				'old' => $node->getAttribute( self::ATTRIBUTE[ 'href' ] ),

				'new' => $href,
			] );

			$node->setAttribute( self::ATTRIBUTE[ 'href' ], $href );
		}
	}

	public static function modify_all( $nodes, $dom )
	{
		$handler = new self();
		
		// $filtered = array_filter( iterator_to_array( $nodes ), [ $handler, 'filetr_doamin_and_language' ] );

		$nodes_domain_and_language = self::get_nodes_domain_and_language( $dom );

		self::modify_filtered( $nodes_domain_and_language );

		// foreach ( $filtered as $node )
		// {
		// 	$href = apply_filters( 'mc_url_restricted', $node->getAttribute( self::ATTRIBUTE[ 'href' ] ) );

		// 	$node->setAttribute( self::ATTRIBUTE[ 'href' ], $href );

		// 	// LegalDebug::debug( [
		// 	// 	'ReviewRestricted' => 'modify_all',

		// 	// 	'href' => $href,
		// 	// ] );
		// }
	}

	public static function filter_not_domain( $item )
	{
		$href = $item->getAttribute( self::ATTRIBUTE[ 'href' ] );

		LegalDebug::debug( [
			'ReviewRestricted' => 'filter_not_domain',

			'href' => $href,

			'check_not_domain' => self::check_not_domain( $href ),
        ] );

		return self::check_not_domain( $href );
	}

	public static function filter_domain_and_not_language( $item )
	{
		$href = $item->getAttribute( self::ATTRIBUTE[ 'href' ] );

		LegalDebug::debug( [
			'ReviewRestricted' => 'filter_domain_and_not_language',

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
			$old->parentNode->replaceChild( $new, $old );
		}
		catch ( DOMException $exception )
		{
			LegalDebug::debug( [
				'ReviewRestricted' => 'replace_node',

				'textContent' => substr( $old->textContent, 0, 30 ),

				'getMessage' => $exception->getMessage(),
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

	public static function replace_filtered( $nodes, $dom )
	{
		foreach ( $nodes as $node )
		{
			$href = $node->getAttribute( self::ATTRIBUTE[ 'href' ] );

			LegalDebug::debug( [
				'ReviewRestricted' => 'replace_filtered',

				'href' => $href,
			] );

			$item = self::get_item( $node, $dom );

			self::replace_node( $item, $node );
		}
	}
	
	public static function replace_all( $nodes, $dom )
	{
		$handler = new self();

		// $filtered = array_filter( iterator_to_array( $nodes ), [ $handler, 'filter_domain_and_not_language' ] );

		$nodes_domain_and_not_language = self::get_nodes_domain_and_not_language( $dom );

		self::replace_filtered( $nodes_domain_and_not_language, $dom );

		// $filtered = array_filter( iterator_to_array( $nodes ), [ $handler, 'filter_not_domain' ] );
		
		$nodes_not_domain = self::get_nodes_not_domain( $dom );

		self::replace_filtered( $nodes_not_domain, $dom );
	}

	public static function modify_anchors( $dom )
	{
		$nodes = self::get_nodes_anchor( $dom );

		if ( $nodes->length == 0 )
		{
			return false;
		}

		self::replace_all( $nodes, $dom );

		self::modify_all( $nodes, $dom );

		return true;
	}

	const FORMAT = [
		'anchor' => '/%s/',
		
		'node' => '//a[contains(@href,"%s")]',

		// .//a
		// [not(self::node()[contains(@href,"match.center")])]
		// [not(self::node()[contains(@href,"old.match.center")])]

		'root' => '//a%s',

		'folder' => '/%s/',

		'contains' => '[contains(@href,"%s")]',

		'not-contains' => '[not(self::node()[contains(@href,"%s")])]',
	];
	
    public static function get_hosts()
	{
		return [
			LegalMain::get_main_host_production(),

			ToolRobots::get_host(),

			LegalMain::get_main_host(),
		];
	}

    public static function get_language( $format )
	{
		$current_language = sprintf( self::FORMAT[ 'folder' ], WPMLMain::current_language() );

		return sprintf( $format, $current_language );
	}

    public static function get_nodes_domain_x_language( $dom, $format_domain, $format_language = '' )
	{
		$query = [];

		$language = '';

		if ( !empty( $format ) )
		{
			$language = self::get_language( $format );
		}

		$hosts = self::get_hosts();

		foreach ( $hosts as $host )
		{
			$domain = sprintf( $format_domain, $host );

			$query[] = sprintf( self::FORMAT[ 'root' ], $domain . $language );
		}

		LegalDebug::debug( [
			'ReviewRestricted' => 'get_nodes_domain_x_language',

			'query' => implode( '|', $query ),
        ] );

		return LegalDOM::get_nodes( $dom, implode( '|', $query ) );
	}

    public static function get_nodes_not_domain( $dom )
	{
		// $query = [];

		// $hosts = self::get_hosts();

		// foreach ( $hosts as $host )
		// {
		// 	$query[] = sprintf( self::FORMAT[ 'not-contains' ], $host );
		// }

		// LegalDebug::debug( [
		// 	'ReviewRestricted' => 'get_nodes_not_domain',

		// 	'query' => implode( '|', $query ),
        // ] );

		// return LegalDOM::get_nodes( $dom, sprintf( self::FORMAT[ 'root' ], implode( '', $query ) ) );

		return self::get_nodes_domain_x_language( $dom, self::FORMAT[ 'not-contains' ] );
	}

    public static function get_nodes_domain_and_language( $dom )
	{
		return self::get_nodes_domain_x_language( $dom, self::FORMAT[ 'contains' ] self::FORMAT[ 'contains' ] );
	}

    public static function get_nodes_domain_and_not_language( $dom )
	{
		return self::get_nodes_domain_x_language( $dom,, self::FORMAT[ 'contains' ] self::FORMAT[ 'not-contains' ] );
	}

	public static function get_nodes_anchor( $dom )
	{
		$query = [];

		$hosts = array_merge( self::get_hosts(), BaseFooter::HOST_EXTERNAL );

		foreach ( $hosts as $host )
		{
			$query[] = sprintf( self::FORMAT[ 'node' ], $host );
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