<?php

class LegalDOM
{
	// public static function get_dom( $content )
	// {
	// 	$dom = new DOMDocument();

	// 	if ( !empty( $content ) )
	// 	{
	// 		// $dom->loadHTML( $content, LIBXML_NOERROR );
			
	// 		$dom->loadHTML( $content, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED );
	// 	}

	// 	return $dom;
	// }

	public static function get_dom( $content )
	{
		$dom = new DOMDocument();

		// $dom->formatOutput=false;

		// $dom->preserveWhiteSpace=true;

		// $dom->validateOnParse=false;

		// $dom->standalone=true;

		// $dom->strictErrorChecking=false;

		// $dom->recover=true;

		// $dom = new DOMDocument( '1.0', 'utf-8' );

		if ( ! empty( $content ) )
		{
			$dom->preserveWhiteSpace = false;
			
			// $dom->loadHTML( $content, LIBXML_NOERROR );
			
			// $dom->loadHTML( $content, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED );

			// $dom->loadHTML( '<div>' . $content . '</div>', LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED );

			// Работает 1 начало

			$dom->loadHTML(
				'<?xml encoding="utf-8"\?\>'
				
				. '<div>' . $content . '</div>',
				
				LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED

				// LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED | LIBXML_NOBLANKS
			);

			// Работает 1 конец

			// Работает 2 начало

			// $content = mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' );

			// $dom->loadHTML( '<div>' . $content . '</div>', LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED );

			// Работает 2 конец

			$container = $dom->getElementsByTagName( 'div' )->item( 0 );

			$container = $container->parentNode->removeChild( $container );

			while ( $dom->firstChild )
			{
				$dom->removeChild( $dom->firstChild );
			}

			while ( $container->firstChild )
			{
				$dom->appendChild( $container->firstChild );
			}
		}

		return $dom;
	}

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
					// $node = $parent->ownerDocument->importNode( $node, true );

					$imported_node = $parent->ownerDocument->importNode( $node, true );

					// LegalDebug::debug( [
					// 	'$node' => $node,

					// 	'$imported_node' => $imported_node ? $imported_node : 'false',
					// ] );

					if ( !empty( $imported_node ) )
					{
						$parent->appendChild( $imported_node );
					}
				}
			}
		}
	}

	// public static function insertBeforeHTML( $dom, $html, $node )
	// {
	// 	$template = new DOMDocument;
		
	// 	$template->loadHtml( $html );
		
	// 	$node->parentNode->insertBefore( $dom->importNode( $template->documentElement, true ), $node );
	// }
	
	public static function insertBeforeHTML( $content, $child )
	{
		if ( ! empty( $content ) )
		{
			$dom = self::get_dom( $content );
			
			if ( $dom->hasChildNodes() )
			{
				foreach ( $dom->childNodes as $node )
				{
					$node = $child->ownerDocument->importNode( $node, true );

					if ( ! empty( $node ) )
					{
						$child->ownerDocument->insertBefore( $node, $child );
					}
				}
			}
		}
	}

	public static function getInnerHTML( $node )
	{
		$innerHTML = [];

		$child_nodes = $node->childNodes;

		foreach ( $child_nodes as $child_node )
		{ 
			$innerHTML[] = $node->ownerDocument->saveHTML( $child_node );
		}

		return implode( '', $innerHTML );
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

	public static function get_nodes( $dom, $query )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( $query );

		return $nodes;
	}

	public static function get_next_element( $dom, $node )
	{
		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( 'following-sibling::*[1]', $node );

		if ( $nodes->length )
		{
			return $nodes->item( 0 );
		}

		return null;
	}

	// public static function addClass( $node, $class )
	// {
	// 	$attribute_classes = $node->getAttribute( 'class' );

	// 	$classess = explode( ' ', $attribute_classes );

	// 	$classess[] = $class;

	// 	$node->setAttribute( 'class', implode( ' ', $classess ) );
	// }

	const XPATH_QUERY = [
		'previous-element' => 'preceding-sibling::%s[1]',
	];

	public static function get_previous_element( $dom, $node, $tag = '*' )
	{
		$xpath = new DOMXPath( $dom );

		$query = sprintf( self::XPATH_QUERY[ 'previous-element' ], $tag );

		$nodes = $xpath->query( $query, $node );

		if ( $nodes->length )
		{
			return $nodes->item( 0 );
		}

		return null;
	}

	public static function remove_child( $dom, $node )
	{
		try
		{
			$node->parentNode->removeChild( $node );
		}
		catch ( DOMException $e )
		{
			LegalDebug::debug( [
				'LegalDOM' => 'remove_child,removeChild',

				'node' => substr( $node->textContent, 0, 30 ),

				'message' => $e->getMessage(),
			] );
		}
	}

	public static function getFirstChildTextNode( $node )
	{
		$textNode = null;

		foreach( $node->childNodes as $child )
		{
			if ( $child->nodeType == XML_TEXT_NODE )
			{
				$textNode = $child;
				
				break;
			}
		}

		return $textNode;
	}
}

?>