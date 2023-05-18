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
			'data' => $data->context, 
		] );

		// $properties = get_object_vars( $data );

		// LegalDebug::debug( [
		// 	'data' => $data,

		// 	'properties' => $properties,
		// ] );

		// if ( !empty( $data[ '@graph' ] ) ) {
		// 	LegalDebug::debug( [
		// 		'@graph' => $data[ '@graph' ],
		// 	] );
		// }

		return $markup;
	}
}

?>