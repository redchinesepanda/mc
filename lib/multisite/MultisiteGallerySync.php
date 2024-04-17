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

	public static function get_atts_pair( $key, $value )
	{
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

		return $result;
	}

	public static function set_gallery_shortcode( $post_id, $post )
    {
        $regex = sprintf( self::PATTERNS[ 'regex' ], get_shortcode_regex( self::SHORTCODES ) );

		$handler = new self();

		$result = preg_replace_callback( 
			$regex,

			[ $handler, 'replace_gallery_shortcodes_ids' ],

			$post[ 'post_content' ]
		);

		$post[ 'post_content' ] = $result;

		MultisitePost::update_post( $post );
    }
}

?>