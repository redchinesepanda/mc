<?php

class WPMLUrl
{
	// const ELEMENT = [
	// 	'anchor' => '<a',
	// ];

	// public static function check_contains_anchor()
    // {
    //     return LegalComponents::check_contains( self::ELEMENT[ 'anchor' ] );
    // }

	public static function check_url_modify()
	{
		return ToolNotFound::check_domain_restricted()
		
			&& self::check_contains_anchor();
	}

	public static function register()
	{
		if ( self::check_url_modify() )
		{
			$handler = new self();

			add_filter( 'stylesheet_directory_uri', 'modify_stylesheet_directory_uri', 10, 3 );

			// add_action( 'the_content', [ $handler, 'modify_content' ] );
		}
    }

	public static function modify_stylesheet_directory_uri( $stylesheet_dir_uri, $stylesheet, $theme_root_uri )
	{
		LegalDebug::debug( [
			'WPMLUrl' =>'modify_stylesheet_directory_uri',

			'$stylesheet_dir_uri' => $stylesheet_dir_uri,

            '$stylesheet' => $stylesheet,
			
            '$theme_root_uri' => $theme_root_uri,
        ] );

		return $stylesheet_dir_uri;
	}

	// public static function modify_content( $content )
	// {
	// 	$dom = LegalDOM::get_dom( $content ); 

	// 	self::modify_anchors( $dom );

	// 	return $dom->saveHTML( $dom );
	// }

	// public static function get_nodes_anchor( $dom )
	// {
	// 	return LegalDOM::get_nodes( $dom, "//a" );
	// }

	// public static function modify_anchors( $dom )
	// {
	// 	$nodes = self::get_nodes_anchor( $dom );

	// 	if ( $nodes->length == 0 )
	// 	{
	// 		return false;
	// 	}

	// 	foreach ( $nodes as $node )
    //     {
	// 		$href = $node->getAttribute( 'href' );

	// 		// $href = str_replace( 'http://', '', $href );

	// 		// $node->setAttribute( 'href', $href );
	// 	}

	// 	return true;
	// }
}

?>