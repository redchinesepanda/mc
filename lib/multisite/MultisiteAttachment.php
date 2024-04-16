<?php

class MultisiteAttachment
{
	const PATTERNS = [
		'url' => '%1$s/%2$s',
	];

	public static function register_functions_admin()
	{
		if ( MultisiteBlog::check_main_blog() )
		{
			$handler = new self();

			MultisiteAdmin::add_filter_all(
				MultisiteAdmin::PATTERNS[ 'handle-bulk-actions' ],

				MultisiteAdmin::POST_TYPES_ATTACHMENT,
				
				$handler,
				
				'mc_bulk_action_multisite_handler_attachment',
				
				10,
				
				3
			);
		}
	}

	public static function register_functions_debug()
	{
		if ( MultisiteBlog::check_not_main_blog() )
		{
			$handler = new self();

			add_action( 'edit_form_after_title', [ $handler, 'mc_debug_edit_form_after_title_action' ] );
		}
	}

	public static function mc_debug_edit_form_after_title_action()
	{
		$matches = self::get_gallery_shortcodes();

		$ids = self::get_shortcodes_attr_ids( $matches );

		LegalDebug::debug( [
			'MultisiteAttachment' => 'mc_debug_edit_form_after_title_action',

			'ids' => $ids,
		] );		
	}

	const SHORTCODES = [
		'gallery',
	];

	public static function get_shortcodes_attr_ids( $matches )
    {
        $ids = [];

        if ( !empty( $matches ) )
        {
            foreach ( $matches as $match )
            {
                $atts = shortcode_parse_atts( $match[ 3 ] );

                if ( !empty( $atts[ 'ids' ] ) )
                {
                    $ids[] = $atts[ 'ids' ];
                }
            }
        }

        return $ids;
    }

	public static function get_gallery_shortcodes()
    {
        $matches = [];

        $post = get_post();

        if ( $post )
        {
            $regex = get_shortcode_regex( self::SHORTCODES );

            $amount = preg_match_all( 
                '/' . $regex . '/', 
    
                $post->post_content,
    
                $matches,
    
                PREG_SET_ORDER
            );
        }

        return $matches;
    }

	public static function handle_attachments( $blog_id, $object_ids )
	{
		foreach ( $object_ids as $attachment_id )
		{
			if ( $post = MultisitePost::get_post( $attachment_id ) )
			{
				// LegalDebug::debug( [
				// 	'MultisiteAttachment' => 'handle_attachments',

				// 	'attachment_id' => $attachment_id,

				// 	'post' => $post[ 'ID' ],
				// ] );
				
				if ( $inserted_attachment_id = self::add_attachment_and_data( $blog_id, $post ) )
				{
					MultisiteMeta::set_post_moved( $post[ 'ID' ], $blog_id, $inserted_attachment_id );
				}
			}
		}
	}

	public static function copy_attachments( $blog_id, $post_id, $post )
    {
		$origin_post_ids = MultisiteAttachmentSync::get_origin_post_ids( $post_id, $post );

		self::handle_attachments( $blog_id, $origin_post_ids );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'copy_attachments',

		// 	'blog_id' => $blog_id,

		// 	'post_id' => $post_id,

		// 	'origin_post_ids' => $origin_post_ids,
		// ] );
	}

	public static function mc_bulk_action_multisite_handler_attachment( $redirect, $doaction, $object_ids )
	{
		$redirect = MultisiteAdmin::redirect_clean( $redirect );

		if ( MultisiteAdmin::check_doaction( $doaction ) )
		{
			$blog_id = MultisiteAdmin::get_blog_id( $doaction );

			self::handle_attachments( $blog_id, $object_ids );
			
			// foreach ( $object_ids as $attachment_id )
			// {
			// 	if ( $post = MultisitePost::get_post( $attachment_id ) )
			// 	{
			// 		LegalDebug::debug( [
			// 			'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

			// 			'attachment_id' => $attachment_id,

			// 			'post' => $post[ 'ID' ],
			// 		] );
					
			// 		if ( $inserted_attachment_id = self::add_attachment_and_data( $blog_id, $post ) )
			// 		{
			// 			MultisiteMeta::set_post_moved( $post[ 'ID' ], $blog_id, $inserted_attachment_id );
			// 		}
			// 	}
			// }

			// LegalDebug::debug( [
			// 	'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

			// 	'blog_id' => $blog_id,
			// ] );

			$redirect = MultisiteAdmin::redirect_set( $redirect, MultisiteAdmin::QUERY_ARG[ 'attachment-moved' ], count( $object_ids ), $blog_id );
		}

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

		// 	'redirect' => $redirect,

		// 	'doaction' => $doaction,

		// 	'check_doaction' => MultisiteAdmin::check_doaction( $doaction ),
		// ] );

		return $redirect;
	}
	
	public static function get_path( $attachment_id )
	{
		return wp_get_original_image_path( $attachment_id );
	}

	public static function get_mime_type( $url )
	{
		return mime_content_type( $url );
	}

	public static function get_title( $unique_filename )
	{
		return preg_replace( '/\.[^.]+$/', '', $unique_filename );
	}
	
	// public static function check_post_moved( $post, $blog_id )
	// {
	// 	return MultisiteMeta::check_post_moved( $post, $blog_id );
	// }

	public static function copy_file( $path, $uploads, $unique_filename )
	{
		$path_moved = sprintf( self::PATTERNS[ 'url' ], $uploads[ 'path' ], $unique_filename );

		if ( @copy( $path, $path_moved ) )
		{
			return $path_moved;
		}

		return false;
	}

	public static function insert_attachment( $path_moved, $uploads, $unique_filename )
	{
		$url_moved = sprintf( self::PATTERNS[ 'url' ], $uploads[ 'url' ], $unique_filename );

		$attachment = [
			'guid' => $url_moved,

			'post_mime_type' => self::get_mime_type( $path_moved ),
			
			'post_title' => self::get_title( $unique_filename ),

			'post_content' => '',

			'post_status' => 'inherit',
		];

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'insert_attachment',

		// 	'attachment' => $attachment,
		// ] );

		$inserted_attachment_id = wp_insert_attachment( $attachment, $path_moved );

		if ( ! is_wp_error( $inserted_attachment_id ) )
		{
			return $inserted_attachment_id;
		}

		return false;
	}

	public static function get_unique_filename( $path, $uploads )
	{
		return wp_unique_filename( $uploads[ 'path' ], basename( $path ) );
	}

	public static function add_attachment( $post, $path, $blog_id, $post_moved_id )
	{
		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'add_attachment',

		// 	'check_moved' => MultisiteMeta::check_moved( $post_moved_id ),

		// 	'post_moved_id' => $post_moved_id,
		// ] );
		
		if ( MultisiteMeta::check_moved( $post_moved_id ) )
		{
			return $post_moved_id;
		}

		// if ( ! MultisiteMeta::check_post_moved( $post, $blog_id ) )
		// {
			
		$uploads = wp_upload_dir();

		$unique_filename = self::get_unique_filename( $path, $uploads );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'add_attachment',

		// 	'unique_filename' => $unique_filename,
		// ] );

		if ( $path_moved = self::copy_file( $path, $uploads, $unique_filename ) )
		{
			// LegalDebug::debug( [
			// 	'MultisiteAttachment' => 'add_attachment',

			// 	'path_moved' => $path_moved,
			// ] );

			if ( $inserted_attachment_id = self::insert_attachment( $path_moved, $uploads, $unique_filename ) )
			{
				// LegalDebug::debug( [
				// 	'MultisiteAttachment' => 'add_attachment',

				// 	'blog_id' => $blog_id,

				// 	'inserted_attachment_id' => $inserted_attachment_id,
				// ] );

				return $inserted_attachment_id;
			}
		}

		// }
		// }

		return false;
	}
	
	public static function add_attachment_and_data( $blog_id, $post )
	{
		$inserted_attachment_id = false;

		$origin_post_id = $post[ 'ID' ];

		$post_moved_id = MultisiteMeta::get_moved( $post, $blog_id );

		$path = self::get_path( $origin_post_id );

		MultisiteBlog::set_blog( $blog_id );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'add_attachment_and_data',

		// 	'path' => $path,

		// 	'post_moved_id' => $post_moved_id,

		// 	'check_moved' => MultisiteMeta::check_moved( $post_moved_id ),

		// 	'check_not_moved-id' => MultisiteMeta::check_not_moved( $post_moved_id ),
			
		// 	'check_not_moved-false' => MultisiteMeta::check_not_moved( false ),
		// ] ); 

		// if ( MultisiteMeta::check_not_moved( $post_moved_id ) )
		// {

		if ( $inserted_attachment_id = self::add_attachment( $post, $path, $blog_id, $post_moved_id ) )
		{
			// LegalDebug::debug( [
			// 	'MultisiteAttachment' => 'add_attachment_and_data',
	
			// 	'inserted_attachment_id' => $inserted_attachment_id,
			// ] );

			MultisiteMeta::add_attachment_meta( $inserted_attachment_id );

			MultisiteMeta::set_post_moved_from( $inserted_attachment_id, $origin_post_id );
		}
			
		// }

		MultisiteBlog::restore_blog();

		return $inserted_attachment_id;
	}
}

?>