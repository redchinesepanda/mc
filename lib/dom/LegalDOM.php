<?php

class LegalDOM
{
	public static function get_dom( $content )
	{
		$dom = new DOMDocument();

		if ( !empty( $content ) )
		{
			$dom->loadHTML( $content, LIBXML_NOERROR );
			
			// $dom->loadHTML( $content, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED );
		}

		return $dom;
	}

	public static function appendHTML( DOMNode $parent, $source )
	{
		$dom = new DOMDocument();

		if ( !empty( $source ) )
		{
			// $dom->loadHTML( $source, LIBXML_NOERROR );
			
			$dom->loadHTML( $source, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED  );

			// if ( $dom->getElementsByTagName( 'body' )->item( 0 )->hasChildNodes() ) {
			
			if ( $dom->hasChildNodes() )
			{
				// foreach ( $dom->getElementsByTagName( 'body' )->item( 0 )->childNodes as $node ) {
				
				foreach ( $dom->childNodes as $node )
				{
					$node = $parent->ownerDocument->importNode( $node, true );

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