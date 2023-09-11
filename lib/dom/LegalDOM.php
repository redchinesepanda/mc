<?php

class LegalDOM
{
	public static function get_dom( $content )
	{
		$dom = new DOMDocument();

		if ( !empty( $content ) )
		{
			// $dom->loadHTML( $content, LIBXML_NOERROR );
			
			$dom->loadHTML( $content, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED );
		}

		return $dom;
	}

	// public static function get_dom( $content )
	// {
	// 	$dom = new DOMDocument();

	// 	if ( !empty( $content ) )
	// 	{
	// 		// $dom->loadHTML( $content, LIBXML_NOERROR );
			
	// 		// $dom->loadHTML( $content, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED );
			
	// 		$dom->loadHTML( '<div>' . $content . '</div>', LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED );

	// 		$container = $dom->getElementsByTagName( 'div' )->item( 0 );

	// 		$container = $container->parentNode->removeChild( $container );

	// 		while ( $dom->firstChild )
	// 		{
	// 			$dom->removeChild( $dom->firstChild );
	// 		}

	// 		while ( $container->firstChild )
	// 		{
	// 			$dom->appendChild( $container->firstChild );
	// 		}
	// 	}

	// 	return $dom;
	// }

	public static function appendHTML( DOMNode $parent, $content )
	{
		// $dom = new DOMDocument();

		if ( !empty( $content ) )
		{
			// $dom->loadHTML( $content, LIBXML_NOERROR );
			
			// $dom->loadHTML( $content, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED  );

			$dom = self::get_dom( $content );

			// if ( $dom->getElementsByTagName( 'body' )->item( 0 )->hasChildNodes() ) {
			
			if ( $dom->hasChildNodes() )
			{
				// foreach ( $dom->getElementsByTagName( 'body' )->item( 0 )->childNodes as $node ) {
				
				foreach ( $dom->childNodes as $node )
				{
					LegalDebug::debug( [
						'$node' => $node,
					] );

					// $node = $parent->ownerDocument->importNode( $node, true );
					
					$node = $dom->importNode( $node, true );

					$parent->appendChild( $node );
				}
			}
		}
	}

	public static function clean( &$node )
    {
        if ( $node->hasChildNodes() )
		{
            foreach ( $node->childNodes as $child )
			{
                self::clean( $child );
            }
        }
		else
		{
            $node->textContent = preg_replace( '/\s+/', ' ', $node->textContent );
        }
    }
}

?>