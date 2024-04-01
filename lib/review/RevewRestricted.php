<?php

class RevewRestricted
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

	public static function modify_anchors( $dom )
	{
		$nodes = self::get_nodes_anchor( $dom );

		if ( $nodes->length == 0 )
		{
			return false;
		}

		$restricted = ToolNotFound::get_restricted();

		$main_host = LegalMain::get_main_host();

		LegalDebug::debug( [
			'ReviewRestricted' => 'modify_anchors',

			'restricted' => $restricted,

			'main_host' => $main_host,
		] );

		foreach ( $nodes as $node )
		{
			$href = $node->getAttribute( self::ATTRIBUTE[ 'href' ] );

			foreach ( $restricted as $host => $language )
			{
				LegalDebug::debug( [
					'href' => $href,
				] );

				$href = str_replace( $main_host, $host, $href );

				LegalDebug::debug( [
					'href' => $href,
				] );

				$href = str_replace( vsprintf( self::FORMAT[ 'anchor' ], $language ), '/', $href );

				LegalDebug::debug( [
					'href' => $href,
				] );
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
			$query[] = vsprintf( self::FORMAT[ 'node' ], $language );
		}

		return LegalDOM::get_nodes( $dom, implode( '|', $query ) );
	}

	public static function check_contains_restricted_anchors()
    {
		$result = false;

		$restricted = ToolNotFound::get_restricted();

		foreach ( $restricted as $host => $language )
		{
			if ( LegalComponents::check_contains( vsprintf( self::FORMAT[ 'anchor' ], $language ) ) )
			{
				$result = true;

				break;
			}
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