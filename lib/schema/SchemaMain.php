<?php

class SchemaMain
{
	public static function register()
    {
        $handler = new self();

        add_filter( 'hunch_schema_markup', [ $handler, 'markup' ] );
    }

	public static function markup( $markup )
	{
		$data = '';

		if ( !empty( $markup ) ) {
			$data = json_decode( $markup );
		}

		LegalDebug::debug( [
			'markup' => $markup,

			'markup_empty' => ( !empty( $markup ) ? $markup : 'false' ),

			'$data' => $data,
		] );
		
		if ( !empty( $data ) ) {
			if ( property_exists( $data, '@context' ) ) {
				foreach( $data->{"@graph"} as $node ) {
					if ( property_exists( $node, 'author' ) ) {
						unset( $node->author );
					}
				}
			}
		}
		
		return json_encode( $data );
	}
}

?>