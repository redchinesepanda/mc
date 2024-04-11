<?php

class MultisiteAttachment
{
	const PATTERNS = [
		'url' => '%1$s/%2$s',
	];

	public static function register_functions_admin()
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

	public static function mc_bulk_action_multisite_handler_attachment( $redirect, $doaction, $object_ids )
	{
		$redirect = MultisiteAdmin::redirect_clean( $redirect );

		if ( MultisiteAdmin::check_doaction( $doaction ) )
		{
			$blog_id = MultisiteAdmin::get_blog_id( $doaction );
			
			foreach ( $object_ids as $attachment_id )
			{
				if ( $post = MultisitePost::get_post( $attachment_id ) )
				{
					LegalDebug::debug( [
						'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

						'attachment_id' => $attachment_id,

						'post' => $post[ 'ID' ],
					] );
					
					if ( $inserted_attachment_id = self::add_attachment_and_data( $blog_id, $post ) )
					{
						MultisiteMeta::set_post_moved( $post[ 'ID' ], $blog_id, $inserted_attachment_id );
					}
				}
			}

			LegalDebug::debug( [
				'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

				'blog_id' => $blog_id,
			] );

			$redirect = MultisiteAdmin::redirect_set( $redirect, MultisiteAdmin::QUERY_ARG[ 'attachment-moved' ], count( $object_ids ), $blog_id );
		}

		LegalDebug::die( [
			'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

			'redirect' => $redirect,

			'doaction' => $doaction,

			'check_doaction' => MultisiteAdmin::check_doaction( $doaction ),
		] );

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
	
	public static function check_post_moved( $post, $blog_id )
	{
		return MultisiteMeta::check_post_moved( $post, $blog_id );
	}

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

		LegalDebug::debug( [
			'MultisiteAttachment' => 'insert_attachment',

			'attachment' => $attachment,
		] );

		$inserted_attachment_id = wp_insert_attachment(
			$attachment,

			$path_moved
		);

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

	public static function add_attachment( $post, $path, $blog_id )
	{
		LegalDebug::debug( [
			'MultisiteAttachment' => 'add_attachment',

			'check_post_moved' => self::check_post_moved( $post, $blog_id ),
		] );

		// if ( ! self::check_post_moved( $post, $blog_id ) )
		// {
			$uploads = wp_upload_dir();

			$unique_filename = self::get_unique_filename( $path, $uploads );

			LegalDebug::debug( [
				'MultisiteAttachment' => 'add_attachment',

				'unique_filename' => $unique_filename,
			] );

			if ( $path_moved = self::copy_file( $path, $uploads, $unique_filename ) )
			{
				LegalDebug::debug( [
					'MultisiteAttachment' => 'add_attachment',

					'path_moved' => $path_moved,
				] );

				if ( $inserted_attachment_id = self::insert_attachment( $path, $uploads, $unique_filename ) )
				{
					LegalDebug::debug( [
						'MultisiteAttachment' => 'add_attachment',
	
						'blog_id' => $blog_id,
	
						'inserted_attachment_id' => $inserted_attachment_id,
					] );

					return $inserted_attachment_id;
				}
			}
		// }

		return false;
	}
	
	public static function add_attachment_and_data( $blog_id, $post )
	{
		$inserted_attachment_id = false;

		$post_moved_id = MultisiteMeta::get_moved( $post, $blog_id );

		$path = self::get_path( $post[ 'ID' ] );

		MultisiteBlog::set_blog( $blog_id );

		LegalDebug::debug( [
			'MultisiteAttachment' => 'add_attachment_and_data',

			'path' => $path,

			'post_moved_id' => $post_moved_id,

			'check_moved' => MultisiteMeta::check_moved( $post_moved_id ),
		] );

		if ( ! $post_moved_id || ! MultisiteMeta::check_moved( $post_moved_id ) )
		{
			if ( $inserted_attachment_id = self::add_attachment( $post, $path, $blog_id ) )
			{
				LegalDebug::debug( [
					'MultisiteAttachment' => 'add_attachment_and_data',
		
					'inserted_attachment_id' => $inserted_attachment_id,
				] );

				MultisiteMeta::add_attachment_meta( $inserted_attachment_id );
			}
			
		}

		MultisiteBlog::restore_blog();

		return $inserted_attachment_id;
	}
}

?>