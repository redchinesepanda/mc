<?php

class ToolTransiterate
{
	const TEMPLATE = [
		'a' => [ 'ă', 'â', 'å', 'æ', ],

		'i' => [ 'î', ],

		's' => [ 'ș', ],

		't' => [ 'ț', ],

		'o' => [ 'ó', ],

		'-' => [ '–', '—', ],
	];

	const REMOVE = [
		':',
	];

	public static function replace( $string )
    {
		foreach ( self::TEMPLATE as $replacement => $values )
		{
			$string = str_replace( $values, $replacement, $string );
		}

		$string = str_replace( self::REMOVE, '', $string );

		LegalDebug::debug( [
			'ToolTransiterate' => 'replace-1',

			'string' => $string,
		] );

		$string = preg_replace( '/--+/', '-', $string );

		LegalDebug::debug( [
			'ToolTransiterate' => 'replace-2',

			'string' => $string,
		] );
        
		return $string;
    }
}

?>