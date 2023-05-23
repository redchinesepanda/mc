<?php

class LegalDOM
{
	public static function get_dom( $content )
	{
		LegalDebug::debug( [
			'content' => ( !empty( $content ) ? 'set' : 'unset' ),
		] );

		$dom = new DOMDocument();

		if ( !empty( $content ) ) {
			$dom->loadHTML( $content, LIBXML_NOERROR );

			LegalDebug::debug( [
				'loadHTML' => 'done',
			] );
		}

		// $dom->loadHTML( $content, LIBXML_NOERROR );

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