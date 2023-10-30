<?php

class NotionWPML
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'billet_language_code' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'billet_language_code' ], 11, 4 );
	}

	const POST_TYPE = [
		'billet' => 'legal_billet',
	];

	public static function billet_language_code( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( NotionMain::META_FIELD[ 'language-code' ] == $meta_key )
		{
			$wpml_element_type = apply_filters( 'wpml_element_type', self::POST_TYPE[ 'billet' ] );

			$original_post_language_info = apply_filters(
				'wpml_element_language_details',

				null,

				[
					'element_id' => $post_id,
					
					'element_type' => 'post'
				]
			);

			$set_language_args = [
				'element_id' => $post_id,

				'element_type' => $wpml_element_type,

				'trid' => $original_post_language_info->trid,

				'language_code' => $meta_value,

				'source_language_code' => $original_post_language_info->language_code
			];
	
			do_action( 'wpml_set_element_language_details', $set_language_args );
		}
	}

	// add_action('wp_footer', 'element_connect_on_insert');
 
	public static function my_insert_posts()
	{
		$output = array();
	
		// Create original post object
		$my_original_post = array(
			'post_title'    => 'My original post',
			'post_content'  => 'This is my original post.',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_category' => array(1)
		);
	
		// Create translation post object
		$my_translated_post = array(
			'post_title'    => 'My translated post',
			'post_content'  => 'This is my translated post.',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_category' => array(2) // NOTE: this is the translated category id!
		);
	
		// Insert the 2 posts into the database
		$original_post_id = wp_insert_post( $my_original_post );
		$translated_post_id = wp_insert_post( $my_translated_post );
	
		return $output = array(
			'original' => $original_post_id,
			'translation' => $translated_post_id
		);
	}
	
	
	public static function element_connect_on_insert()
	{
		$inserted_post_ids = my_insert_posts();
	
		if ( $inserted_post_ids)
		{
			// https://wpml.org/wpml-hook/wpml_element_type/

			$wpml_element_type = apply_filters( 'wpml_element_type', 'post' );
			
			// get the language info of the original post
			// https://wpml.org/wpml-hook/wpml_element_language_details/

			$get_language_args = [
				'element_id' => $inserted_post_ids['original'],
				
				'element_type' => 'post'
			];

			$original_post_language_info = apply_filters(
				'wpml_element_language_details',

				null,

				$get_language_args
			);
			
			$set_language_args = array(
				'element_id'    => $inserted_post_ids['translation'],
				'element_type'  => $wpml_element_type,
				'trid'   => $original_post_language_info->trid,
				'language_code'   => 'de',
				'source_language_code' => $original_post_language_info->language_code
			);
	
			do_action( 'wpml_set_element_language_details', $set_language_args );
		}
	}
}

?>