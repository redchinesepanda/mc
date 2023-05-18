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
		$data = json_decode( $markup );

		LegalDebug::debug( [
			'@graph' => $data->{"@graph"},
		] );

		if ( property_exists( $data, '@context' ) ) {
			foreach( $data->{"@graph"} as $node ) {
				if ( property_exists( $node, 'author' ) ) {
					unset( $node->author );

					// LegalDebug::debug( [
					// 	'author' => $node->author,
					// ] );
				}
			}

			LegalDebug::debug( [
				'@graph' => $data->{"@graph"},
			] );
		}

		return $markup;
	}
}

?>