<?php

class MultisiteAttachment
{
	const PATTERNS = [
		'url' => '%1$s/%2$s',

		// 'regex' => '/%s/',

		// 'shortcode' => '[%1$s %2$s]',

		// 'attr-pair' => '%1$s="%2$s"',
	];

	// const SHORTCODES = [
	// 	'gallery' => 'gallery',
	// ];

	public static function register_functions_mainsite()
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

	public static function handle_attachments( $blog_id, $object_ids )
	{
		foreach ( $object_ids as $attachment_id )
		{
			if ( $post = MultisitePost::get_post( $attachment_id ) )
			{
				// LegalDebug::debug( [
				// 	'MultisiteAttachment' => 'handle_attachments',

				// 	'attachment_id' => $attachment_id,

				// 	'post-ID' => $post[ 'ID' ],

				// 	'post' => $post,
				// ] );

				$post_terms = MultisiteTerms::get_post_terms( $attachment_id );

				$post_meta = MultisiteMeta::get_post_meta( $attachment_id );

				$post_fields = MultisiteACF::get_fields( $attachment_id );
				
				// if ( $inserted_attachment_id = self::add_attachment_and_data( $blog_id, $post ) )
				
				if ( $inserted_attachment_id = self::add_attachment_and_data( $blog_id, $post, $post_meta, $post_fields, $post_terms ) )
				{
					MultisiteMeta::set_post_moved( $post[ 'ID' ], $blog_id, $inserted_attachment_id );

					// LegalDebug::debug( [
					// 	'MultisiteAttachment' => 'handle_attachments',
	
					// 	'inserted_attachment_id' => $inserted_attachment_id,
					// ] );
				}
			}
		}

		// LegalDebug::die( [
		// 	'MultisiteAttachment' => 'handle_attachments',

		// 	'blog_id' => $blog_id,

		// 	'object_ids' => $object_ids,
		// ] );
	}

	public static function copy_attachments( $blog_id, $post_id, $post )
    {
		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'copy_attachments',

		// 	'blog_id' => $blog_id,

		// 	'post_id' => $post_id,
		// ] );

		// $field_post_ids = MultisiteAttachmentSync::get_origin_post_ids( $post_id, $post );
		
		$field_post_ids = MultisiteAttachmentSync::get_origin_post_ids( $post_id );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'copy_attachments',

		// 	'field_post_ids' => $field_post_ids,
		// ] );

		$gallery_post_ids = MultisiteGallerySync::get_gallery_shortcodes_ids( $post_id, $post );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'copy_attachments',

		// 	'gallery_post_ids' => $gallery_post_ids,
		// ] );

		$shortcodes_post_ids = MultisiteShortcodeSync::get_shortcodes_image_ids( $post_id, $post );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'copy_attachments',

		// 	'shortcodes_post_ids' => $shortcodes_post_ids,
		// ] );

		// $post_thumbnail_ids = MultisiteAttachmentSync::get_post_thumbnail_ids( $post_id );

		// $origin_post_ids = array_merge( $field_post_ids, $gallery_post_ids, $post_thumbnail_ids );
		
		$origin_post_ids = array_merge(
			$field_post_ids,
			
			$gallery_post_ids,
		
			$shortcodes_post_ids
		);

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'copy_attachments',

		// 	'origin_post_ids' => $origin_post_ids,
		// ] );

		self::handle_attachments( $blog_id, $origin_post_ids );
	}

	public static function mc_bulk_action_multisite_handler_attachment( $redirect, $doaction, $object_ids )
	{
		// if ( MultisiteAdmin::check_doaction( $doaction ) )
		
		if ( MultisiteAdmin::check_doaction( $doaction, MultisiteAdmin::DOACTION[ 'move-to' ] ) )
		{
			$redirect = MultisiteAdmin::redirect_clean( $redirect );

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

	// public static function insert_attachment( $path_moved, $uploads, $unique_filename )
	
	public static function insert_attachment( $path_moved, $uploads, $unique_filename, $post )
	{
		$url_moved = sprintf( self::PATTERNS[ 'url' ], $uploads[ 'url' ], $unique_filename );

		$attachment = [
			'guid' => $url_moved,

			'post_mime_type' => self::get_mime_type( $path_moved ),
			
			'post_title' => self::get_title( $unique_filename ),

			'post_content' => $post[ 'post_content' ],

			'post_excerpt' => $post[ 'post_excerpt' ],

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

		// 	'post' => $post[ 'ID' ],

		// 	'path' => $path,

		// 	'blog_id' => $blog_id,

		// 	'post_moved_id' => $post_moved_id,

		// 	'check_moved' => MultisiteMeta::check_moved( $post_moved_id ),
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

			// if ( $inserted_attachment_id = self::insert_attachment( $path_moved, $uploads, $unique_filename ) )
			
			if ( $inserted_attachment_id = self::insert_attachment( $path_moved, $uploads, $unique_filename, $post ) )
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
	
	// public static function add_attachment_and_data( $blog_id, $post )
	
	public static function add_attachment_and_data( $blog_id, $post, $post_meta, $post_fields, $post_terms )
	{
		$inserted_attachment_id = false;

		$origin_post_id = $post[ 'ID' ];

		$post_moved_id = MultisiteMeta::get_moved( $post, $blog_id );

		$path = self::get_path( $origin_post_id );

		MultisiteBlog::set_blog( $blog_id );

		// LegalDebug::debug( [
		// 	'MultisiteAttachment' => 'add_attachment_and_data',

		// 	'origin_post_id' => $origin_post_id,

		// 	'post_moved_id' => $post_moved_id,

		// 	'path' => $path,
		// ] );

		if ( $inserted_attachment_id = self::add_attachment( $post, $path, $blog_id, $post_moved_id ) )
		{
			// LegalDebug::debug( [
			// 	'MultisiteAttachment' => 'add_attachment_and_data',
	
			// 	'inserted_attachment_id' => $inserted_attachment_id,
			// ] );

			MultisiteTerms::add_post_terms( $inserted_attachment_id, $post_terms );

			MultisiteMeta::add_post_meta( $inserted_attachment_id, $post_meta );

			MultisiteMeta::add_attachment_meta( $inserted_attachment_id );

			MultisiteACF::add_fields( $inserted_attachment_id, $post_fields );

			MultisiteMeta::set_post_moved_from( $inserted_attachment_id, $origin_post_id );
		}

		MultisiteBlog::restore_blog();

		return $inserted_attachment_id;
	}
}

?>