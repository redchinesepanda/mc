<?php

class MultisiteACF
{
	const FIELDS_COMPILATION_FILTER = [
		'filter' => [
			'name' => 'compilation-filter',

			'key' => 'field_642ad18b8593a',
		],
	];

	public static function get_field_raw( $post_id, $field_name )
	{
		return get_field( $field_name, $post_id, false );
	}

	public static function get_field_names()
	{
		LegalDebug::debug( [
			'MultisiteACF' => 'get_field_names',

			'array_column' => array_column( self::FIELDS_COMPILATION_FILTER, 'key' ),
		] );

		return array_merge( array_column( self::FIELDS_COMPILATION_FILTER, 'key' ), [] );
	}

	public static function get_fields( $post_id )
	{
		$fields = [];

		$field_names = self::get_field_names();

		foreach ( $field_names as $field_name )
		{
			$fields[] = self::get_field_raw( $field_name, $post_id );
		}

		return $fields;
	}

	public static function add_fields( $post_id, $fields )
	{
		foreach ( $fields as $field_name => $field_value )
		{
			update_field( $field_name, $field_value, $post_id );
		}

		return true;
	}
}

?>