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

		$properties = get_object_vars( $data );

		LegalDebug::debug( [
			'graph' => $data->@graph,
		] );

		// if ( !empty( $data[ '@graph' ] ) ) {
		// 	LegalDebug::debug( [
		// 		'@graph' => $data[ '@graph' ],
		// 	] );
		// }

		return $markup;
	}
}

?>