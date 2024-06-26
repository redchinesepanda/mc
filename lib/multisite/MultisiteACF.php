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

		'tabs-items' => [
			'name' => 'tabs-items',

			'key' => 'field_6423d199c433a',
		],

		'media-author' => [
			'name' => 'media-author',

			'key' => 'media-author',
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

		// return array_merge( array_column( self::FIELDS_COMPILATION_FILTER, 'key' ), [] );
		
		return array_merge( array_column( self::FIELDS_COMPILATION_FILTER, 'name' ), [] );
	}

	public static function get_fields( $post_id )
	{
		$fields = [];

		$field_names = self::get_field_names();

		foreach ( $field_names as $field_name )
		{
			// LegalDebug::debug( [
			// 	'MultisiteACF' => 'get_fields',

			// 	'field_name' => $field_name,
			// ] );

			$field_value = self::get_field_raw( $field_name, $post_id );

			if ( !empty( $field_value ) )
			{
				$fields[ $field_name ] = $field_value;
			}

			// $fields[ $field_name ] = self::get_field_raw( $field_name, $post_id );

			// LegalDebug::debug( [
			// 	'MultisiteACF' => 'get_fields',

			// 	'fields' => $fields,
			// ] );
		}

		return $fields;
	}

	public static function add_fields( $post_id, $fields )
	{
		foreach ( $fields as $field_name => $field_value )
		{
			// LegalDebug::debug( [
			// 	'MultisiteACF' => 'add_fields',

			// 	'field_name' => $field_name,

			// 	'field_value' => $field_value,
			// ] );

			if ( ! empty( $field_value ) )
			{
				update_field( $field_name, $field_value, $post_id );
			}
		}

		return true;
	}

	// https://wp-kama.ru/plugin/acf/local-json

	// add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );
	
	// function my_acf_json_load_point( $paths ) {
	
	// 	// // remove original path (optional)
	// 	// unset( $paths[0] );
	
	// 	// // append path
	// 	// $paths[] = get_stylesheet_directory() . '/my-custom-folder';
	
	// 	LegalDebug::debug( [
	// 		'functions.php' =>'my_acf_json_load_point',
	
	// 		'paths' => $paths,
	// 	] );
	
	// 	return $paths;
	// }
	
	// add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );
	
	// function my_acf_json_save_point( $path )
	// {
	// 	// return get_stylesheet_directory() . '/my-custom-folder';
	
	// 	LegalDebug::debug( [
	// 		'functions.php' =>'my_acf_json_save_point',
	
	// 		'path' => $path,
	// 	] );
	
	// 	return $path;
	// }
	
	// add_filter( 'acf/json/save_paths', 'custom_acf_json_save_paths', 10, 2 );
	
	// function custom_acf_json_save_paths( $paths, $post )
	// {
	// 	// if ( $post['title'] === 'Theme Settings' ) {
	// 	//     $paths = array( get_stylesheet_directory() . '/options-pages' );
	// 	// }
	
	// 	// if ( $post['title'] === 'Theme Settings Fields' ) {
	// 	//     $paths = array( get_stylesheet_directory() . '/field-groups' );
	// 	// }
	
	// 	LegalDebug::debug( [
	// 		'functions.php' =>'custom_acf_json_save_paths',
	
	// 		'paths' => $paths,
	// 	] );
	
	// 	return $paths;
	// }
}

?>