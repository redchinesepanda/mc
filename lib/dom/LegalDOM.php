<?php

class LegalDOM
{
	public static function get_dom( $content )
	{
		$dom = new DOMDocument();

		$dom->loadHTML( $content, LIBXML_NOERROR );

		return $dom;
	}

	public static function appendHTML( DOMNode $parent, $source ) {
		$tmpDoc = new DOMDocument();

		$tmpDoc->loadHTML( $source, LIBXML_NOERROR );

		foreach ( $tmpDoc->getElementsByTagName( 'body' )->item( 0 )->childNodes as $node ) {
			$node = $parent->ownerDocument->importNode( $node, true );

			$parent->appendChild( $node );
		}
	}
}

?>