<?php

class MultisiteMeta
{
	const FIELDS_TABS = [
		'items' => 'tabs-items'
	];

	const FIELDS_COMPILATION_FILTER = [
		'filter' => 'compilation-filter',
	];

	const FILTER_META_PREFIX = [
		// thirive theme

		'tcb_',

		'tcb2_',

		'_tve_',

		'tve_',

		'thrive_',

		// wpml plugin

		'_wpml_',

		// LinkWhisper Plugin

		'wpil_',

		// Rank Match plugin

		'rank_math_',

		// other

		'_ew',
	];

	const FILTER_META = [
		// multisite

		'mc_moved_to',

		'mc_moved_from',

		// remove schema plugin

		'remove_schema_page_specific',

		'_HunchSchemaMarkup',

		'_HunchSchemaType',

		// other

		'google_post_content',

		'theme_skin_tag',

		'sections',

		// acf plugin old fields

		'legal_post_type_wiki',

		// acf plugin bonus deprecated

		'ref-ssylka',

		'_ref-ssylka',

		'ref-perelinkovka',

		'_ref-perelinkovka',

		'link-bk',
		
		'_link-bk',

		'img',

		'_img',

		'data-okonchaniya',

		'_data-okonchaniya',

		'promokod',

		'_promokod',

		'category',

		'_category',

		'drugie-bonusy',

		'_drugie-bonusy',

		'pohozhie-bonusy',

		'_pohozhie-bonusy',

		// attachment

		'_edit_lock',

		'_wp_attachment_metadata',

		'_wp_attached_file',

		'_wp_old_slug',

		'_edit_last',

		// thirive

		// 'tcb_editor_enabled',

		// 'tcb2_ready',

		// '_tve_post_constants',

		// '_tve_js_modules_gutenberg',

		// '_tve_header',

		// '_tve_footer',

		// '_tve_assets_to_preload',

		// '_tve_base_inline_css',

		// '_tve_lightspeed_version',

		// '_tve_js_modules',

		// 'tve_globals',

		// 'tve_global_scripts',

		// 'tve_content_before_more',

		// 'tve_content_more_found',

		// 'tve_custom_css',

		// 'tve_has_masonry',

		// 'tve_has_typefocus',

		// 'tve_has_wistia_popover',

		// 'tve_updated_post',

		// 'tve_updated_post_tcb2-product-focused-02-homepage',

		// 'tve_custom_css_tcb2-product-focused-02-homepage',

		// 'tve_user_custom_css_tcb2-product-focused-02-homepage',

		// 'tve_has_masonry_tcb2-product-focused-02-homepage',

		// 'tve_has_typefocus_tcb2-product-focused-02-homepage',

		// 'tve_has_wistia_popover_tcb2-product-focused-02-homepage',

		// 'tve_page_events_tcb2-product-focused-02-homepage',

		// 'tve_globals_tcb2-product-focused-02-homepage',

		// 'tve_updated_post_tcb2-product-focused-01-homepage',

		// 'tve_custom_css_tcb2-product-focused-01-homepage',

		// 'tve_user_custom_css',

		// 'tve_page_events',

		// 'thrive_icon_pack_tcb2-product-focused-02-homepage',

		// 'thrive_tcb_post_fonts_tcb2-product-focused-02-homepage',

		// 'thrive_element_visibility',

		// 'thrive_icon_pack',

		// 'thrive_post_template',

		// 'thrive_theme_video_format_meta',

		// 'thrive_theme_audio_format_meta',

		// 'thrive_tcb_post_fonts',

		// wpml plugin

		// '_wpml_word_count',

		// '_wpml_media_duplicate',

		// '_wpml_media_featured',

		// LinkWhisper Plugin

		// 'wpil_sync_report3',

		// 'wpil_links_inbound_internal_count',

		// 'wpil_links_inbound_internal_count_data',

		// 'wpil_links_outbound_internal_count',

		// 'wpil_links_outbound_internal_count_data',

		// 'wpil_links_outbound_external_count',

		// 'wpil_links_outbound_external_count_data',

		// 'wpil_sync_report2_time',
	];

	const POST_META = [
		'moved-to' => 'mc_moved_to',

		'moved-from' => 'mc_moved_from',
    ];

	public static function register_functions_debug()
	{
		$handler = new self();

		add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );

		// add_action( 'category_pre_edit_form', [ $handler, 'mc_category_pre_edit_form_debug' ], 10, 2 );
	}

	function mc_edit_form_after_title_debug( $post )
	{
		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'register_functions_admin',

		// 	'post_parent' => $post->post_parent,
		// ] );

		$moved_to = get_post_meta( $post->ID, self::POST_META[ 'moved-to' ], true );

		$moved_to_function = MultisiteMeta::get_post_moved( $post->ID );

		$moved_from = get_post_meta( $post->ID, self::POST_META[ 'moved-from' ], true );

		$moved_from_function = MultisiteMeta::get_post_moved( $post->ID, MultisiteMeta::POST_META[ 'moved-from' ] );

		LegalDebug::debug( [
			'MultisiteMeta' => 'register_functions_admin',

			'ID' => $post->ID,

			'moved_to' => $moved_to,

			'moved_to-gettype' => gettype( $moved_to ),

			'moved_to_function' => $moved_to_function,

			'moved_to_function-gettype' => gettype( $moved_to_function ),

			'moved_from' => $moved_from,

			'moved_from_function' => $moved_from_function,

			'moved_from_function-gettype' => gettype( $moved_from_function ),
		] );

		// foreach ( $post_meta as $key => $value )
        // {
        //     LegalDebug::debug( [
        //         'MultisiteMeta' => 'register_functions_admin',

		// 		'key' => $key,

		// 		'value' => $value,
        //     ] );

		// 	// delete_post_meta( $post->ID, $key );
		// }
	}

	// function mc_category_pre_edit_form_debug( $term, $taxonomy )
	// {
	// 	$term_meta = get_term_meta( $term->term_id );

	// 	foreach ( $term_meta as $key => $value )
    //     {
    //         LegalDebug::debug( [
    //             'MultisiteMeta' => 'mc_category_pre_edit_form_debug',

	// 			'key' => $key,

	// 			'value' => $value,
    //         ] );

	// 		// delete_post_meta( $post->ID, $key );
	// 	}
	// }

	public static function get_post_moved_id( $origin_post_id )
	{
		if ( $post = get_post( $origin_post_id ) )
		{
			return self::get_post_moved( $post->ID, self::POST_META[ 'moved-from' ] );
		}

		return false;
	}

	public static function check_contains_prefix( $string, $array )
	{
		// $string = 'My nAmE is Tom.';

		// $array = array("name","tom");

		// if(0 < count(array_intersect(array_map('strtolower', explode(' ', $string)), $array)))
		// {
		// //do sth
		// }

		// $amount = count( array_intersect( array_map( 'strtolower', explode( ' ', $string ) ), $array ) );

		// if ( $amount > 0 )
		// {
		// 	return true;
		// }

		foreach ( $array as $item )
		{
            if ( str_contains( $string, $item) )
			{
                return true;
            }
        }

		return false;
	}

	public static function filter_not_prefix( $meta_key )
	{
		// return !in_array( $meta_key, self::FILTER_META_PREFIX );

		return !self::check_contains_prefix( $meta_key, self::FILTER_META_PREFIX );
	}

	// public static function filter_not_thrive( $meta_key )

	public static function filter_not_meta_key( $meta_key )
	{
		return !in_array( $meta_key, self::FILTER_META );
	}

	public static function filter_meta_key( $meta_key )
	{
		return self::filter_not_meta_key( $meta_key )

			&& self::filter_not_prefix( $meta_key );
	}

	public static function get_post_meta( $post_id )
	{
		// return get_post_custom( $post_id );

		$handler = new self();

        return array_filter( get_post_custom( $post_id ), [ $handler, 'filter_meta_key' ], ARRAY_FILTER_USE_KEY );
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
	
	// public static function get_post_moved( $post_id, $blog_id, $meta_key = '' )

	public static function check_post_moved_type( $post_moved )
	{
		LegalDebug::debug( [
			'MultisiteMeta' => 'check_post_moved_type-1',

			'post_moved' => $post_moved,

			'gettype' => gettype( $post_moved ),

			'not_empty' => ( ! empty( $post_moved ) ),

			'in_array' => in_array( gettype( $post_moved ), [ 'integer', 'array' ] ),

			'is_array' => is_array( $post_moved ),

			'is_numeric' => is_numeric( $post_moved ),

			// 'str_contains' => str_contains( $post_moved, ' ' ),

			'condition-test-1' => ( is_array( $post_moved ) || is_numeric( $post_moved ) && ! str_contains( $post_moved, ' ' ) ),
		] );

		return ! empty( $post_moved )
		
			&& in_array( gettype( $post_moved ), [ 'integer', 'array' ] );
	}

	public static function get_post_moved( $post_id, $meta_key = '' )
	{
		LegalDebug::debug( [
			'MultisiteMeta' => 'get_post_moved-1',

			'post_id' => $post_id,

			'meta_key' => $meta_key,
		] );

		if ( empty( $meta_key ) )
		{
			$meta_key = self::POST_META[ 'moved-to' ];
		}

		LegalDebug::debug( [
			'MultisiteMeta' => 'get_post_moved-2',

			'meta_key' => $meta_key,
		] );

		// $moved_to = get_post_meta( $post_id, $meta_key, true );

		// if ( !empty( $moved_to[ $blog_id ] ) )
		// {
		// 	return $moved_to[ $blog_id ];
		// }

		// return null;

		$post_moved = get_post_meta( $post_id, $meta_key, true );
		
		LegalDebug::debug( [
			'MultisiteMeta' => 'get_post_moved-3',

			'post_moved' => $post_moved,

			'check_post_moved_type' => self::check_post_moved_type( $post_moved ),
		] );

		// if ( ! empty( $post_moved ) && ( is_array( $post_moved ) || is_numeric( $post_moved ) ) )
		
		// if ( ! empty( $post_moved ) && ( is_array( $post_moved ) ) )
		
		// if ( ! empty( $post_moved ) && ( in_array( gettype( $post_moved ), [ 'integer', 'array' ] ) ) )

		if ( $meta_key == self::POST_META[ 'moved-to' ] )
		{
			if ( self::check_post_moved_type( $post_moved ) )
			{
				return $post_moved;
			}
		}

		if ( ! empty( $post_moved ) )
		{
			return $post_moved;
		}
		
		return null;
		
		// return get_post_meta( $post_id, $meta_key, false );
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
		$post_moved = self::get_post_moved( $post_id );

		// $meta_value = array_merge( $meta_value, [ $blog_id => $moved_post_id ] );
		
		// $updated_meta_value = [ $blog_id => $moved_post_id ];
		
		$updated_post_moved = [];

		// if ( ! empty( $meta_value ) && is_array( $meta_value ) )

		if ( self::check_post_moved_type( $post_moved ) )
		{
			$updated_post_moved = $post_moved;
		}

		$updated_post_moved[ $blog_id ] = $moved_post_id;

		update_post_meta( $post_id, self::POST_META[ 'moved-to' ], $updated_post_moved );

		// LegalDebug::die( [
		// 	'MultisiteMeta' =>'set_post_moved',

		// 	'post_id' => $post_id,

		// 	'blog_id' => $blog_id,

		// 	'moved_post_id' => $moved_post_id,

		// 	'meta_value' => $meta_value,

		// 	'updated_meta_value' => $updated_meta_value,
		// ] );
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

		if ( empty( $id) )
		{
			return false;
		}

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
			
		// 	'post' => $post[ 'ID' ],

		// 	'blog_id' => $blog_id,

		// 	'post_moved' => $post_moved,

		// 	'!empty' => !empty( $post_moved[ $blog_id ] ),
		// ] );

		if ( !empty( $post_moved[ $blog_id ] ) )
		{
			// LegalDebug::debug( [
			// 	'MultisiteMeta' => 'check_post_moved',
	
			// 	'check_moved' => self::check_moved( $post ),
			// ] );

			return $post_moved[ $blog_id ];
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

	public static function get_term_meta( $term_id )
	{
		$handler = new self();

        return array_filter( get_term_meta( $term_id ), [ $handler, 'filter_meta_key' ], ARRAY_FILTER_USE_KEY );
	}

	public static function add_term_meta( $term_id, $term_meta )
	{
		foreach ( $term_meta as $key => $values )
		{
			foreach ( $values as $value )
			{
				update_term_meta( $post_id, $key, $value );
			}
		}

		return true;
	}
}

?>