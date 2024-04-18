<?php

class MultisiteGallerySync
{
	const PATTERNS = [
		'regex' => '/%s/',

		'shortcode' => '[%1$s %2$s]',

		'attr-pair' => '%1$s="%2$s"',
	];
	
	const SHORTCODES = [
		'gallery' => 'gallery',
	];

	public static function register_functions_subsite()
	{
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();

			MultisiteAdmin::add_filter_all(
				MultisiteAdmin::PATTERNS[ 'handle-bulk-actions' ],
				
				MultisiteAdmin::get_post_types_post(),
				
				$handler,
				
				'mc_bulk_action_sync_galleries',
				
				10,
				
				3
			);
		}
	}

	public static function mc_bulk_action_sync_galleries( $redirect, $doaction, $object_ids )
	{
		$redirect = MultisiteAdmin::redirect_clean( $redirect );

		// LegalDebug::die( [
		// 	'MultisiteGallerySync' =>'mc_bulk_action_sync_galleries',

		// 	'doaction' => $doaction,

		// 	'check_doaction' => MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-galleries' ] ),
		// ] );

		if ( MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-galleries' ] ) )
		{
			foreach ( $object_ids as $post_id )
			{
				if ( $post = MultisitePost::get_post( $post_id ) )
				{
					self::set_gallery_shortcode( $post[ 'ID' ], $post );
				}
			}

			$redirect = MultisiteAdmin::redirect_set(
				$redirect,
				
				MultisiteAdmin::QUERY_ARG[ 'galleries-synced' ],
				
				count( $object_ids ),
				
				MultisiteBlog::get_current_blog_id()
			);
		}

		return $redirect;
	}

	public static function get_atts_pair( $value, $key )
	{
		LegalDebug::debug( [
			'MultisiteGallerySync' => 'get_atts_pair',

			'value' => $value,

			'key' => $key,
		] );

		return sprintf( self::PATTERNS[ 'attr-pair' ], $key, $value );
	}

	public static function get_atts_part( $atts )
	{
		$handler = new self();

		return implode( ' ', array_map(
			[ $handler, 'get_atts_pair' ],

			$atts,

			array_keys( $atts )
		) );
	}

	public static function set_gallery_shortcode_moved_ids( $attachment_ids )
	{
		foreach ( $attachment_ids as $key => $origin_post_id )
		{
			if ( $post_moved_id = MultisitePost::get_post_moved_id( $origin_post_id ) )
			{
				$attachment_ids[ $key ] = $post_moved_id;
			}
		}

		return $attachment_ids;
	}

	public static function sync_gallery_shortcode_ids( $match )
	{
		$atts = shortcode_parse_atts( $match[ 3 ] );

		if ( ! empty( $atts[ 'ids' ] ) )
        {
            $ids = explode( ',', $atts[ 'ids' ] );
			
			$ids = self::set_gallery_shortcode_moved_ids( $ids );

			$atts[ 'ids' ] = implode( ',', $ids );
        }

		return self::get_atts_part( $atts );
	}

	public static function replace_gallery_shortcodes_ids( $match )
	{
		$atts = self::sync_gallery_shortcode_ids( $match );

		$result = sprintf( self::PATTERNS[ 'shortcode' ], self::SHORTCODES[ 'gallery' ], $atts );

		LegalDebug::debug( [
			'MultisiteGallerySync' =>'replace_gallery_shortcodes_ids',

			'match' => $match,

			'result' => $result,
		] );

		return $result;
	}

	public static function get_gallery_shortcode_regexp()
	{
		return sprintf( self::PATTERNS[ 'regex' ], get_shortcode_regex( self::SHORTCODES ) );
	}

	public static function set_gallery_shortcode( $post_id, $post )
    {
        // $regex = sprintf( self::PATTERNS[ 'regex' ], get_shortcode_regex( self::SHORTCODES ) );

		$handler = new self();

		$result = preg_replace_callback( 
			// $regex,

			self::get_gallery_shortcode_regexp(),

			[ $handler, 'replace_gallery_shortcodes_ids' ],

			$post[ 'post_content' ]
		);

		$post[ 'post_content' ] = $result;

		LegalDebug::die( [
			'MultisiteGallerySync' =>'set_gallery_shortcode',

			'post_id' => $post_id,
		] );

		// MultisitePost::update_post( $post );
    }

	public static function register_functions_debug()
	{
		// if ( MultisiteBlog::check_not_main_blog() )
		// {
			// $handler = new self();

			// add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );
		// }
	}

	public static function get_gallery_matches_ids( $matches )
	{
		$result = [];

		foreach ( $matches as $match )
		{
			// LegalDebug::debug( [
			// 	'MultisiteGallerySync' => 'get_gallery_matches_ids',

			// 	'match' => $match,
			// ] );

			if ( ! empty( $match[ 3 ] ) )
			{
				$atts = shortcode_parse_atts( $match[ 3 ] );

				// LegalDebug::debug( [
				// 	'MultisiteGallerySync' => 'get_gallery_matches_ids',
	
				// 	'atts' => $atts,
				// ] );

				if ( ! empty( $atts[ 'ids' ] ) )
				{
					$ids = explode( ',', $atts[ 'ids' ] );

					$result = array_merge( $result, $ids );
				}
			} 
		}

		return $result;
	}

	public static function get_gallery_shortcodes_ids( $post_id, $post )
    {
        $matches = [];

		$handler = new self();

		$result = preg_match_all( 
			self::get_gallery_shortcode_regexp(),

			$post[ 'post_content' ],

			$matches,

			PREG_SET_ORDER
		);

		// LegalDebug::debug( [
		// 	'MultisiteGallerySync' => 'get_gallery_shortcodes_ids',

		// 	'matches' => $matches,
		// ] );

		$ids = self::get_gallery_matches_ids( $matches );

		return $ids;
    }

	// function mc_edit_form_after_title_debug( $post )
	// {
	// 	$sync_post = MultisitePost::get_post( $post->ID );

	// 	LegalDebug::debug( [
	// 		'MultisiteGallerySync' => 'mc_edit_form_after_title_debug',

	// 		'get_gallery_shortcodes_ids' => self::get_gallery_shortcodes_ids( $sync_post[ 'ID' ], $sync_post ),
	// 	] );
	// }
}

?>