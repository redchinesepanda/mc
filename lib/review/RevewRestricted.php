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

	public static function modify_anchors( $dom )
	{
		$nodes = self::get_nodes_anchor( $dom );

		// if ( $nodes->length == 0 )
		// {
		// 	return false;
		// }

		LegalDebug::debug( [
			'ReviewRestricted' => 'modify_anchors',

            'length' => $nodes->length,

			'nodes' => $nodes,
		] );

		// $node = $nodes->item( $nodes->length - 1 );

		// $section = $dom->createElement( 'div' );

		// $section->setAttribute( 'class', 'legal-section-anchors' );

		// LegalDOM::appendHTML( $section, ReviewAnchors::render() );

		// try
		// {
		// 	$node->parentNode->insertBefore( $section, $node->nextSibling );
		// }
		// catch ( DOMException $e )
		// {
		// 	LegalDebug::debug( [
		// 		'BonusPreview' => 'insert_anchors',

		// 		'node' => substr( $node->textContent, 0, 30 ),

		// 		'message' => $e->getMessage(),
		// 	] );
		// }

		return true;
	}

	public static function get_nodes_anchor( $dom )
	{
		return LegalDOM::get_nodes( $dom, "//a" );
	}

	public static function check_contains_restricted_anchors()
    {
		$result = false;

		$restricted = ToolNOtFound::get_restricted();

		foreach ( $restricted as $host => $language )
		{
			if ( LegalComponents::check_contains( vsprintf( '/%s/', $language ) ) )
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