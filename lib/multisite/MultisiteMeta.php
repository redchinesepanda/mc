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
		$handler = new self();

		add_action( 'edit_form_after_title', [ $handler, 'wp_kama_edit_form_after_title_action' ] );
	}

	function wp_kama_edit_form_after_title_action( $post )
	{
		LegalDebug::debug( [
			'MultisiteMeta' => 'register_functions_admin',

			'items' => get_field( self::FIELDS_TABS[ 'items' ] ),

			'filter' => get_field( self::FIELDS_COMPILATION_FILTER[ 'filter' ] ),

			'get_post_moved' => self::get_post_moved( null ),
		] );
	}

	const FILTER_META = [
		'_tve_js_modules_gutenberg',

		'tve_global_scripts',

		'thrive_element_visibility',

		'google_post_content',
	];

	const POST_META = [
		'moved-to' => 'mc_moved_to',
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

	public static function add_attachment_metadata( $attachment_id )
	{
		return wp_generate_attachment_metadata( $attachment_id, get_attached_file( $attachment_id ) );
	}

	public static function add_attachment_meta( $attachment_id )
	{
		return wp_update_attachment_metadata( $attachment_id, self::add_attachment_metadata( $attachment_id ) );
	}

	public static function get_post_moved( $post_id )
	{
		return get_post_meta( $post_id, self::POST_META[ 'moved-to' ], true );
	}

	public static function set_post_moved( $post_id, $blog_id, $moved_post_id )
	{
		$meta_value = self::get_post_moved( $post_id );

		// $meta_value = array_merge( $meta_value, [ $blog_id => $moved_post_id ] );

		LegalDebug::debug( [
			'MultisiteMain' =>'set_post_moved',

			'post_id' => $post_id,

			'blog_id' => $blog_id,

			'moved_post_id' => $moved_post_id,

			'meta_value' => $meta_value,
		] );
		
		$meta_value = [ $blog_id => $moved_post_id ];

		update_post_meta( $post_id, self::POST_META[ 'moved-to' ], $meta_value );
	}

	public static function check_post_moved( $post, $blog_id )
	{
		$post_moved = self::get_post_moved( $post[ 'ID' ] );

		LegalDebug::debug( [
			'MultisiteMain' => 'check_post_moved',
			
			'ID' => $post[ 'ID' ],

			'post_moved' => $post_moved,
		] );

		// if ( array_key_exists( $blog_id, $post_moved ) )
		
		if ( !empty( $post_moved[ $blog_id ] ) )
		{
			LegalDebug::debug( [
				'MultisiteMain' => 'check_post_moved',
	
				'get_post_status' => get_post_status( $post_moved[ $blog_id ] ),
			] );

			if ( get_post_status( $post_moved[ $blog_id ] ) )
			{
				return $post_moved[ $blog_id ];
			}
		}

		return false;
	}
}

?>