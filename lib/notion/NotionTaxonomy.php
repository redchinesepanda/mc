<?php

class NotionTaxonomy
{
	public static function register_functions()
	{
		$handler = new self();

		add_action( 'added_post_meta', [ $handler, 'billet_feature' ], 11, 4 );

		add_action( 'updated_post_meta', [ $handler, 'billet_feature' ], 11, 4 );
	}

	const TAXONOMY = [
		'feature' => 'billet_feature',
	];

	public static function billet_afillate( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( NotionMain::META_FIELD[ 'feature' ] == $meta_key )
		{
			// update_field( NotionMain::ACF_FIELD[ 'settings' ] . '_' . self::REVIEW_ABOUT_FIELD[ 'afillate' ], $about_afillate, $post_id );
				
			// $field[ self::REVIEW_ABOUT_KEY[ 'afillate' ] ] = self::get_afillate_id( $meta_value );

			// update_field( NotionMain::ACF_KEY[ 'settings' ], $field, $post_id );

			$terms = self::format( $meta_value, self::TAXONOMY[ 'feature' ] );

			LegalDebug::die( [
				'function' => 'NotionTaxonomy::billet_afillate',

				'meta_key' => $meta_key,

				'meta_value' => $meta_value,

				'terms' => $terms,
			] );
		}
	}

	public function format( $value, $taxonomy )
	{
		// $this->importer = $importer;

		if ( empty( $value ) )
		{
			return [];
		}

		// Make sure we have an array of terms.
		$values = ! is_array( $value ) ? explode( ',', $value ) : $value;

		$terms = [];

		foreach ( $values as $value )
		{
			$value = wp_strip_all_tags( $value );

			$term = term_exists( $value, $taxonomy );

			if ( 0 === $term || null === $term )
			{
				$term = wp_insert_term( $value, $taxonomy );
			}

			if ( !is_wp_error( $term ) )
			{
				$terms[] = (int) $term['term_id'];
			}
		}

		return $terms;
	}
}

?>