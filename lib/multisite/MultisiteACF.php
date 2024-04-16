<?php

class MultisiteACF
{
	const FIELDS_COMPILATION_FILTER = [
		'compilation-filter' => [
			'name' => 'compilation-filter',

			'key' => 'field_642ad18b8593a',
		],

		'billet-feture-bonus' => [
			'name' => 'billet-feture-bonus',

			'key' => 'field_651ab4be3b28d',
		],

		'billet-list-parts' => [
			'name' => 'billet-list-parts',

			'key' => 'field_6412f442f2c53',
		],

		'billet-feture-achievement' => [
			'name' => 'billet-feture-achievement',

			'key' => 'field_651aa238a7b35',
		],

		'billet-profit-items' => [
			'name' => 'billet-profit-items',

			'key' => 'field_64340371d58e4',
		],

		'billet-feture-main-description' => [
			'name' => 'billet-feture-main-description',

			'key' => 'field_6523a4f9e9751',
		],
	];

	public static function update_field( $field_name, $value, $post_id )
	{
		return update_field( $field_name, $value, $post_id );
	}

	public static function get_field_raw( $field_name, $post_id )
	{
		return get_field( $field_name, $post_id, false );
	}

	public static function get_field( $field_name, $post_id )
	{
		return get_field( $field_name, $post_id );
	}

	public static function get_field_names()
	{
		// LegalDebug::debug( [
		// 	'MultisiteACF' => 'get_field_names',

		// 	'array_column' => array_column( self::FIELDS_COMPILATION_FILTER, 'key' ),
		// ] );

		return array_merge( array_column( self::FIELDS_COMPILATION_FILTER, 'key' ), [] );
	}

	public static function get_fields( $post_id )
	{
		$fields = [];

		$field_names = self::get_field_names();

		foreach ( $field_names as $field_name )
		{
			$fields[ $field_name ] = self::get_field_raw( $field_name, $post_id );
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