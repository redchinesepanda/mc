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
			// $wpml_element_type = apply_filters( 'wpml_element_type', self::POST_TYPE[ 'billet' ] );
			
			$wpml_element_type = WPMLMain::get_element_type( $post_id );

			// $trid = wpml_get_content_trid( $wpml_element_type, $post_id );

			// $trid = apply_filters( 'wpml_element_trid', NULL, $post_id, $wpml_element_type );
			
			$trid = WPMLTrid::get_trid( $post_id );
	
			do_action(
				'wpml_set_element_language_details',

				[
					'element_id' => $post_id,
	
					'element_type' => $wpml_element_type,
					
					'trid' => $trid,
	
					'language_code' => $meta_value,
	
					'source_language_code' => null,
				]
			); 

			LegalDebug::die( [
				'function' => 'NotionWPML::billet_language_code',

				'meta_value' => $meta_value,

				'wpml_element_type' => $wpml_element_type,
				
				'original_post_language_info' => $original_post_language_info,

				'trid' => $trid,

				'set_language_args' => $set_language_args,
			] );
		}
	}
}

?>