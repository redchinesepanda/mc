<?php

class ToolTransiterate
{
	const TEMPLATE = [
		'a' => [ 'ă', 'â' ],

		'i' => [ 'î' ],

		's' => [ 'ș' ],

		't' => [ 'ț' ],
	];

	public static function replace ( $string )
    {
		foreach( self::TEMPLATE as $replacement => $values ) {
			$string = str_replace( $values, $replacement, $string);
		}
        
		return $string;
    }
}

?>