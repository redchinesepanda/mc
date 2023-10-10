<?php

class ToolEncode
{
	public static function encode( $content )
	{
		// return mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' );
		
		return mb_convert_encoding( $content, 'UTF-8', 'HTML-ENTITIES' );

		// return $content;
	}
}

?>