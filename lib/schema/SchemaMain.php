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

		if ( !empty( $data[ '@graph' ] ) ) {
			LegalDebug::debug( [
				'@graph' => $data[ '@graph' ],
			] );
		}

		return $markup;
	}
}

?>