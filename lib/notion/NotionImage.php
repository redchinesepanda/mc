<?php

class NotionImage
{
	const REVIEW_ABOUT_KEY = [
		'logo' => 'about-logo',
	];

	const REVIEW_ABOUT_FIELD = [
		'logo' => 'field_6437df25a65cd',
	];

	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'billet_logo' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'billet_logo' ], 11, 4 );

		add_filter( 'getimagesize_mimes_to_exts', [ $handler, 'more_mimes_to_exts' ] );

		// add_action( 'edit_form_after_title', [ $handler, 'billet_image_show' ], 10, 4 );
	}

	
	public static function more_mimes_to_exts( $mime_to_ext )
	{
		$mime_to_ext['svg'] = 'image/svg';

		return $mime_to_ext;
	}

	public static function get_image_id( $data )
	{
		if ( is_array( $data ) )
		{
			return array_shift( $data );
		}

		return $data;
	}

	public static function billet_logo( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( NotionMain::META_FIELD[ 'about-logo' ] == $meta_key )
		{
			// $field = get_field( NotionMain::ACF_FIELD[ 'settings' ], $post->ID );

			// $field[ self::REVIEW_ABOUT_FIELD[ 'logo' ] ] = self::get_image_id( $meta_value );

			// update_field( NotionMain::ACF_FIELD[ 'settings' ], $field, $post_id );
			
			$field[ self::REVIEW_ABOUT_KEY[ 'logo' ] ] = self::get_image_id( $meta_value );

			update_field( NotionMain::ACF_KEY[ 'settings' ], $field, $post_id );
		}
	}

	// public static function billet_image_show( $post )
	// {
	// 	LegalDebug::debug( [
	// 		'NotionImage' => 'billet_image_show',

	// 		NotionMain::META_FIELD[ 'about-logo' ] => get_post_meta( $post->ID, NotionMain::META_FIELD[ 'about-logo' ], true ),

	// 		self::REVIEW_ABOUT_FIELD[ 'logo' ] => get_field( NotionMain::ACF_FIELD[ 'settings' ] . '_' . self::REVIEW_ABOUT_FIELD[ 'logo' ], $post->ID, false ),
	// 	] );
	// }
}

?>