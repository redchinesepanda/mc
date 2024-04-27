<?php

class MultisiteShortcodeSync
{
	const PATTERNS = [
		'regex' => '/%s/',

		'shortcode' => '[%1$s %2$s]%3$s[/%1$s]',

		'attr-pair' => '%1$s="%2$s"',
	];

	// const SHORTCODES = [
	// 	'mega' => 'billet-mega',
	// ];

	public static function register_functions_debug()
	{
		$handler = new self();

		add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );
	}

	function mc_edit_form_after_title_debug( $post )
	{
		$post_prepared = MultisitePost::get_post( $post->ID );

		// self::get_mega_shortcodes_ids( $post->ID, $post_prepared );

		self::set_shortcodes( $post->ID, $post_prepared );

		// LegalDebug::debug( [
		// 	'MultisiteMeta' => 'register_functions_admin',

		// 	'post_parent' => $post->post_parent,
		// ] );
	}

	public static function register_functions_subsite()
	{
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();

			MultisiteAdmin::add_filter_all(
				MultisiteAdmin::PATTERNS[ 'handle-bulk-actions' ],
				
				MultisiteAdmin::get_post_types_post(),
				
				$handler,
				
				'mc_bulk_action_sync_shortcodes',
				
				10,
				
				3
			);
		}
	}

	public static function mc_bulk_action_sync_shortcodes( $redirect, $doaction, $object_ids )
	{
		$redirect = MultisiteAdmin::redirect_clean( $redirect );

		// LegalDebug::debug( [
		// 	'MultisiteGallerySync' =>'mc_bulk_action_sync_shortcodes',

		// 	'doaction' => $doaction,

		// 	'check_doaction' => MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-shortcodes' ] ),
		// ] );

		if ( MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'sync-shortcodes' ] ) )
		{
			foreach ( $object_ids as $post_id )
			{
				if ( $post = MultisitePost::get_post( $post_id ) )
				{
					// LegalDebug::debug( [
					// 	'MultisiteGallerySync' =>'mc_bulk_action_sync_shortcodes',
			
					// 	'ID' => $post[ 'ID' ],
					// ] );

					self::set_shortcodes( $post[ 'ID' ], $post );
				}
			}

			$redirect = MultisiteAdmin::redirect_set(
				$redirect,
				
				MultisiteAdmin::QUERY_ARG[ 'shortcodes-synced' ],
				
				count( $object_ids ),
				
				MultisiteBlog::get_current_blog_id()
			);
		}

		return $redirect;
	}

	public static function sync_shortcode_ids( $match )
	{
		$atts = shortcode_parse_atts( $match[ 3 ] );

		if ( ! empty( $atts[ 'id' ] ) )
        {
            $ids = explode( ',', $atts[ 'id' ] );
			
			$ids = MultisiteGallerySync::set_gallery_shortcode_moved_ids( $ids );

			$atts[ 'id' ] = implode( ',', $ids );
        }

		return MultisiteGallerySync::get_atts_part( $atts );
	}

	public static function replace_shortcodes_ids( $match )
	{
		$atts = self::sync_shortcode_ids( $match );

		$shortcode = $match[ 2 ];

		$content = $match[ 5 ];

		$result = sprintf( self::PATTERNS[ 'shortcode' ], $shortcode, $atts, $content );

		// LegalDebug::debug( [
		// 	'MultisiteGallerySync' =>'replace_gallery_shortcodes_ids',

		// 	'match' => $match,

		// 	'result' => $result,
		// ] );

		return $result;
	}

	public static function get_shortcodes()
	{
		return [
			BilletMega::SHORTCODE[ 'mega' ],
		];
	}

	public static function get_shortcodes_regexp()
	{
		return MultisiteGallerySync::get_gallery_shortcode_regexp( self::get_shortcodes() );
	}

	public static function set_shortcodes( $post_id, $post )
    {
        $handler = new self();

		$result = preg_replace_callback( 
			self::get_shortcodes_regexp(),

			[ $handler, 'replace_shortcodes_ids' ],

			$post[ 'post_content' ]
		);

		$post[ 'post_content' ] = $result;

		// LegalDebug::die( [
		// 	'MultisiteGallerySync' =>'set_gallery_shortcode',

		// 	'post_id' => $post_id,

		// 	'result' => $result,
		// ] );

		MultisitePost::update_post( $post );
    }

	public static function get_matches_image_ids( $matches )
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

				if ( ! empty( $atts[ 'mode' ] ) )
				{
					if ( ! empty( $atts[ 'id' ] ) )
					{
						$ids = explode( ',', $atts[ 'id' ] );
	
						$result = array_merge( $result, $ids );
					}
				}
			} 
		}

		return $result;
	}

	public static function get_shortcodes_image_ids( $post_id, $post )
    {
        $matches = [];

		$result = preg_match_all( 
			self::get_shortcodes_regexp(),

			$post[ 'post_content' ],

			$matches,

			PREG_SET_ORDER
		);

		// LegalDebug::debug( [
		// 	'MultisiteShortcodeSync' => 'get_shortcodes_ids',

		// 	'matches' => $matches,
		// ] );

		$ids = self::get_matches_image_ids( $matches );

		return $ids;
    }
}

?>