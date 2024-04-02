<?php

class ReviewRestricted
{
	public static function check_register()
	{
		return ToolNotFound::check_domain_restricted()
		
			&& self::check_contains_restricted_anchors();
	}

	public static function register()
	{
		if ( self::check_register() )
		{
			$handler = new self();
	
			add_action( 'the_content', [ $handler, 'modify_content' ] );
		}
	}

	const ATTRIBUTE = [
		'href' => 'href',
	];

	public static function replace_anchors( &$href, $language, $host )
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

	public static function modify_anchors( $dom )
	{
		$nodes = self::get_nodes_anchor( $dom );

		if ( $nodes->length == 0 )
		{
			return false;
		}

		$restricted = ToolNotFound::get_restricted();

		foreach ( $nodes as $node )
		{
			$href = $node->getAttribute( self::ATTRIBUTE[ 'href' ] );

			foreach ( $restricted as $host => $language )
			{
				if ( self::replace_anchors( $href, $language, $host ) )
				{
					break;
				}
			}

			$node->setAttribute( self::ATTRIBUTE[ 'href' ], $href );
		}

		return true;
	}

	const FORMAT = [
		'anchor' => '/%s/',
		
		'node' => '//a[contains(@href,"%s")]',
	];

	public static function get_nodes_anchor( $dom )
	{
		// $restricted = ToolNotFound::get_restricted();
		
		$restricted = ToolNotFound::get_restricted_languages_all();

		$query = [];

		// foreach ( $restricted as $host => $language )
		
		foreach ( $restricted as $language )
		{
			$query[] = sprintf( self::FORMAT[ 'node' ], $language );
		}

		return LegalDOM::get_nodes( $dom, implode( '|', $query ) );
	}

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

			// if ( LegalComponents::check_contains( sprintf( self::FORMAT[ 'anchor' ], $language ) ) )
			// {
			// 	$result = true;

			// 	break;
			// }
		}

        return $result;
    } 

	public static function modify_content( $content )
    {
		$dom = LegalDOM::get_dom( $content ); 

		self::modify_anchors( $dom );

		return $dom->saveHTML( $dom );
    }
}

?>