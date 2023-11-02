<?php

class NotionAffiliate
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'billet_afillate' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'billet_afillate' ], 11, 4 );
	}

	const REVIEW_ABOUT_KEY = [
		'afillate' => 'field_6437df65a65cf',
	];

	const REVIEW_ABOUT_FIELD = [
		'afillate' => 'about-afillate',
	];

	public static function get_afillate( $url )
	{
		$id = url_to_postid( $url );

		if ( !empty( $id ) )
		{
			return $id;
		}

		return '';
	}

	public static function billet_afillate( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( NotionMain::META_FIELD[ 'about-afillate' ] == $meta_key )
		{
			$about_afillate = self::get_afillate( $meta_value );

			if ( !empty( $about_afillate ) )
			{
				// update_field( NotionMain::ACF_FIELD[ 'settings' ] . '_' . self::REVIEW_ABOUT_FIELD[ 'afillate' ], $about_afillate, $post_id );

				// $field = get_field( NotionMain::ACF_FIELD[ 'settings' ], $post_id );

				$field[ self::REVIEW_ABOUT_FIELD[ 'afillate' ] ] = $about_afillate;

				update_field( NotionMain::ACF_FIELD[ 'settings' ], $field, $post_id );

				LegalDebug::die( [
					'function' => 'NotionAffiliate::billet_afillate',
	
					'meta_key' => $meta_key,
	
					'meta_value' => $meta_value,
	
					'about_afillate' => $about_afillate,
	
					'field' => $field,
				] );
			}
		}
	}
}

?>