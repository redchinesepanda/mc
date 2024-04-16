<?php

class MultisiteMeta
{
	const FIELDS_TABS = [
		'items' => 'tabs-items'
	];

	const FIELDS_COMPILATION_FILTER = [
		'filter' => 'compilation-filter',
	];

	public static function register_functions_admin()
	{
		// $handler = new self();

		// add_action( 'edit_form_after_title', [ $handler, 'wp_kama_edit_form_after_title_action' ] );
	}

	// function wp_kama_edit_form_after_title_action( $post )
	// {
	// 	$post = get_post();

	// 	LegalDebug::debug( [
	// 		'MultisiteMeta' => 'register_functions_admin',

	// 		'items' => get_field( self::FIELDS_TABS[ 'items' ] ),

	// 		'filter' => get_field( self::FIELDS_COMPILATION_FILTER[ 'filter' ] ),

	// 		'get_post_moved-to' => self::get_post_moved( $post->ID ),

	// 		'get_post_moved-from' => self::get_post_moved( $post->ID, self::POST_META[ 'moved-from' ] ),
	// 	] );
	// }

	public static function get_post_moved_id( $origin_post_id )
	{
		if ( $post = get_post( $origin_post_id ) )
		{
			return self::get_post_moved( $post->ID, self::POST_META[ 'moved-from' ] );
		}

		return false;
	}

	const FILTER_META = [
		'_tve_js_modules_gutenberg',

		'tve_global_scripts',

		'thrive_element_visibility',

		'google_post_content',
	];

	const POST_META = [
		'moved-to' => 'mc_moved_to',

		'moved-from' => 'mc_moved_from',
    ];

	public static function filter_not_thrive( $meta_key )
	{
		return !in_array( $meta_key, self::FILTER_META );
	}

	public static function get_post_meta( $post_id )
	{
		// return get_post_custom( $post_id );

		$handler = new self();

        return array_filter( get_post_custom( $post_id ), [ $handler, 'filter_not_thrive' ], ARRAY_FILTER_USE_KEY );
	}

	public static function add_post_meta( $post_id, $post_meta )
	{
		foreach ( $post_meta as $key => $values )
		{
			// if you do not want weird redirects

			if( '_wp_old_slug' === $key )
			{
				continue;
			}

			foreach ( $values as $value )
			{
				update_post_meta( $post_id, $key, $value );
			}
		}

		return true;
	}

	public static function get_attachment_metadata( $attachment_id )
	{
		return wp_generate_attachment_metadata( $attachment_id, get_attached_file( $attachment_id ) );
	} 

	public static function add_attachment_meta( $attachment_id )
	{
		return wp_update_attachment_metadata( $attachment_id, self::get_attachment_metadata( $attachment_id ) );
	}

	public static function get_post_moved( $post_id, $meta_key = '' )
	{
		if ( empty( $meta_key ) )
		{
			$meta_key = self::POST_META[ 'moved-to' ];
		}

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'get_post_moved',

		// 	'post_id' => $post_id,

		// 	'meta_key' => $meta_key,
		// ] );

		return get_post_meta( $post_id, $meta_key, true );
	}

	public static function set_post_moved_from( $post_id, $origin_post_id )
	{
		// LegalDebug::debug( [
		// 	'MultisiteMeta' =>'set_post_moved_from',

		// 	'post_id' => $post_id,

		// 	'origin_post_id' => $origin_post_id,
		// ] );

		update_post_meta( $post_id, self::POST_META[ 'moved-from' ], $origin_post_id );
	}

	public static function set_post_moved( $post_id, $blog_id, $moved_post_id )
	{
		$meta_value = self::get_post_moved( $post_id );

		// $meta_value = array_merge( $meta_value, [ $blog_id => $moved_post_id ] );
		
		$updated_meta_value = [ $blog_id => $moved_post_id ];

		// LegalDebug::debug( [
		// 	'MultisiteMeta' =>'set_post_moved',

		// 	'post_id' => $post_id,

		// 	'blog_id' => $blog_id,

		// 	'moved_post_id' => $moved_post_id,

		// 	'meta_value' => $meta_value,

		// 	'updated_meta_value' => $updated_meta_value,
		// ] );

		update_post_meta( $post_id, self::POST_META[ 'moved-to' ], $updated_meta_value );
	}

	// public static function check_post( $id )
	// {
	// 	return is_single( $id );
	// }

	// public static function check_page( $id )
	// {
	// 	return is_page( $id );
	// }

	// public static function check_attachment( $id )
	// {
	// 	return is_attachment( $id );
	// }

	public static function check_not_moved( $id )
	{
		return ! self::check_moved( $id );
	}

	public static function check_moved( $id )
	{
		// return self::check_post( $id )
		
		//     || self::check_page( $id )
			
		// 	|| self::check_attachment( $id );

		return get_post_status( $id );
	}

	public static function check_post_moved( $post, $blog_id )
	{
		$post_moved = self::get_post_moved( $post[ 'ID' ] );

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'check_post_moved',
			
		// 	'ID' => $post[ 'ID' ],

		// 	'post_moved' => $post_moved,

		// 	'not_empty' => !empty( $post_moved[ $blog_id ] ),
		// ] );

		// if ( array_key_exists( $blog_id, $post_moved ) )
		
		if ( !empty( $post_moved[ $blog_id ] ) )
		{
			// LegalDebug::debug( [
			// 	'MultisiteMeta' => 'check_post_moved',
	
			// 	'post_moved_id' => $post_moved[ $blog_id ],
			// ] );

			// if ( self::check_moved( $post ) )
			// {
				return $post_moved[ $blog_id ];
			// }
		}

		return false;
	}

	public static function get_moved( $post, $blog_id )
	{
		$post_moved = self::get_post_moved( $post[ 'ID' ] );

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'check_post_moved',
			
		// 	'ID' => $post[ 'ID' ],

		// 	'blog_id' => $blog_id,

		// 	'post_moved' => $post_moved,
		// ] );

		// if ( array_key_exists( $blog_id, $post_moved ) )
		
		if ( !empty( $post_moved[ $blog_id ] ) )
		{
			// LegalDebug::debug( [
			// 	'MultisiteMeta' => 'check_post_moved',
	
			// 	'check_moved' => self::check_moved( $post ),
			// ] );

			// if ( self::check_moved( $post ) )
			// {
				return $post_moved[ $blog_id ];
			// }
		}

		return false;
	}

	public static function set_term_moved_from( $term_id, $origin_term_id )
	{
		// LegalDebug::debug( [
		// 	'MultisiteMeta' =>'set_term_moved_from',

		// 	'term_id' => $term_id,

		// 	'origin_term_id' => $origin_term_id,
		// ] );

		return update_term_meta( $term_id, self::POST_META[ 'moved-from' ], $origin_term_id, '' );
	}

	public static function get_term_moved_from( $term_id )
	{
		return get_term_meta( $term_id, self::POST_META[ 'moved-from' ], true );
	}
}

?>