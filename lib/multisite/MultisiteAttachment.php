<?php

class MultisiteAttachment
{
	public static function register_functions_admin()
	{
		$handler = new self();

		// add_filter( 'bulk_actions-upload', 'mc_bulk_multisite_actions_upload' );

		// perform bulk action

		// add_filter( 'handle_bulk_actions-upload', 'mc_bulk_action_multisite_handler_attachment', 10, 3 );

		MultisiteAdmin::add_filter_all(
			MultisiteAdmin::PATTERNS[ 'handle-bulk-actions' ],

			MultisiteAdmin::POST_TYPES_ATTACHMENT,
			
			$handler,
			
			'mc_bulk_action_multisite_handler_attachment',
			
			10,
			
			3
		);
	}

	// function mc_bulk_multisite_actions_upload( $bulk_array )
	// {
	// 	if( 2 == get_current_blog_id() )
	// 	{
	// 		return $bulk_array;
	// 	}
		
	// 	$bulk_array[ 'rudr_copy_attachment_to' ] = 'Move to &laquo;Store&raquo;';
	// 	return $bulk_array;
	// }

	public static function mc_bulk_action_multisite_handler_attachment( $redirect, $doaction, $object_ids )
	{
		$redirect = MultisiteAdmin::redirect_clean( $redirect );

		// do something for our bulk action

		// if ( 'rudr_copy_attachment_to' === $doaction )

		// LegalDebug::die( [
		// 	'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

		// 	'check_doaction' => MultisiteAdmin::check_doaction( $doaction ),
		// ] );

		if ( MultisiteAdmin::check_doaction( $doaction ) )
		{
			$blog_id = MultisiteAdmin::get_blog_id( $doaction );

			// $count = 0;
			
			// $blog_id = 2;
			
			foreach( $object_ids as $attachment_id )
			{
				// for each media selected
				if ( $path = self::get_path( $attachment_id ) )
				{
					LegalDebug::debug( [
						'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

						'attachment_id' => $attachment_id,

						'path' => $path,
					] );

					self::add_attachment_and_data( $blog_id, $path );
				}
				// if( $attachment = self::mc_copy_attachment_to_blog( $attachment_id, $blog_id ) )
				// {
					// $count++;
				// }
			}

			LegalDebug::die( [
				'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

				'blog_id' => $blog_id,
			] );

			$redirect = MultisiteAdmin::redirect_set( $redirect, count( $object_ids ), $blog_id );

			// $redirect = add_query_arg( 'rudr_bulk_media', $count, $redirect );

			$redirect = MultisiteAdmin::redirect_set( $redirect, MultisiteAdmin::QUERY_ARG[ 'attachment-moved' ], count( $object_ids ), $blog_id );
		}

		LegalDebug::die( [
			'MultisiteAttachment' => 'mc_bulk_action_multisite_handler_attachment',

			'redirect' => $redirect,

			'doaction' => $doaction,

			'check_doaction' => self::check_doaction( $doaction ),
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

	public static function get_title( $filename )
	{
		return preg_replace( '/\.[^.]+$/', '', $filename );
	}

	public static function add_attachment( $path, $blog_id )
	{
		$uploads = wp_upload_dir();

		$filename = wp_unique_filename( $uploads[ 'path' ], basename( $path ) );

		$new_file = $uploads[ 'path' ] . "/$filename";

		$new_file_url = $uploads[ 'url' ] . "/$filename";

		// copy the media file into another multisite subsite uploads directory

		$sideload = @copy( $file, $new_file );

		if( false === $sideload )
		{
			return false;
		}

		// it is time to insert media file into media gallery

		$inserted_attachment_id = wp_insert_attachment(
			[
				'guid' => $new_file_url,

				'post_mime_type' => self::get_mime_type( $new_file ),

				'post_title' => self::get_title( $filename ),

				'post_content' => '',

				'post_status' => 'inherit',
			],

			$new_file
		);

		LegalDebug::debug( [
			'MultisiteAttachment' => 'add_attachment',

			'blog_id' => $post_id,

			'inserted_attachment_id' => $inserted_attachment_id,
		] );

		if ( ! is_wp_error( $inserted_attachment_id ) )
		{
			return $inserted_attachment_id;
		}

		return 0;
	}

	// public static function add_attachment_and_data( $blog_id, $path, $post_terms, $post_meta, $post_fields )
	
	public static function add_attachment_and_data( $blog_id, $path )
	{
		MultisiteBlog::set_blog( $blog_id );

		if ( $attachment_id = self::add_attachment( $path, $blog_id ) )
		{
			MultisiteMeta::add_attachment_meta( $attachment_id );

			LegalDebug::die( [
				'MultisiteAttachment' => 'add_attachment_and_data',

				'attachment_id' => $attachment_id,
			] );
		}

		MultisiteBlog::restore_blog();
	}

	// public static function mc_copy_attachment_to_blog( $attachment_id, $blog_id )
	// {

	// 	// get image path unscaled or you can use get_attached_file() if it is not necessary to copy full-sized originals 
	// 	// $file = ;

	// 	// exit the function if an attachment with this specific ID doesn't exist
	// 	// if( ! $file ) {
	// 	// 	return false;
	// 	// }

	// 	if ( $path = self::get_path( $attachment_id ) )
	// 	{
	// 		self::add_attachment_and_data( $blog_id, $path );
	// 	}

	// 	// switching to a blog we are going to copy the image to
	// 	// switch_to_blog( $blog_id );

	// 	// $uploads = wp_upload_dir();

	// 	// $filename = wp_unique_filename( $uploads[ 'path' ], basename( $file ) );
	// 	// $new_file = $uploads[ 'path' ] . "/$filename";
	// 	// $new_file_url = $uploads[ 'url' ] . "/$filename";

	// 	// // copy the media file into another multisite subsite uploads directory
	// 	// $sideload = @copy( $file, $new_file );

	// 	// if( false === $sideload ) {
	// 	// 	return false;
	// 	// }

	// 	// // it is time to insert media file into media gallery
	// 	// $inserted_attachment_id = wp_insert_attachment(
	// 	// 	array(
	// 	// 		'guid' => $new_file_url,
	// 	// 		'post_mime_type' => mime_content_type( $new_file ),
	// 	// 		'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
	// 	// 		'post_content'   => '',
	// 	// 		'post_status'    => 'inherit',
	// 	// 	),
	// 	// 	$new_file
	// 	// );

	// 	// make sure this file is included, because wp_generate_attachment_metadata() depends on it
	// 	// require_once( ABSPATH . 'wp-admin/includes/image.php' );
	// 	// update the attachment metadata.
	// 	// wp_update_attachment_metadata(
	// 	// 	$inserted_attachment_id,
	// 	// 	wp_generate_attachment_metadata( $inserted_attachment_id, $new_file )
	// 	// );

	// 	// restore_current_blog();

	// 	// return true;
	// }
}

?>