<?php

class LegalDOM
{
	public static function get_dom( $content )
	{
		if ( empty( $content ) ) {
			return null;
		}

		$dom = new DOMDocument();

		$dom->loadHTML( $content, LIBXML_NOERROR );

		return $dom;
	}

	public static function appendHTML( DOMNode $parent, $source ) {
		$tmpDoc = new DOMDocument();

		if ( !empty( $source ) ) {
			$tmpDoc->loadHTML( $source, LIBXML_NOERROR );

			if ( $tmpDoc->getElementsByTagName( 'body' )->item( 0 )->hasChildNodes() ) {
				foreach ( $tmpDoc->getElementsByTagName( 'body' )->item( 0 )->childNodes as $node ) {
					$node = $parent->ownerDocument->importNode( $node, true );

					$parent->appendChild( $node );
				}
			}
		}
	}

	public static function clean( &$node )
    {
        if ( $node->hasChildNodes() ) {
            foreach ( $node->childNodes as $child ) {
                self::clean( $child );
            }
        } else {
            $node->textContent = preg_replace( '/\s+/', ' ', $node->textContent );
        }
    }
}

?>