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

	public static function billet_feature( $meta_id, $post_id, $meta_key, $meta_value )
	{
		if ( NotionMain::META_FIELD[ 'feature' ] == $meta_key )
		{
			$features = json_decode( $meta_value );

			$terms = self::format( $features, self::TAXONOMY[ 'feature' ] );

			$result = wp_set_post_terms( $post_id, $terms, self::TAXONOMY[ 'feature' ], false );

			// LegalDebug::die( [
			// 	'function' => 'NotionTaxonomy::billet_feature',

			// 	'meta_key' => $meta_key,

			// 	'meta_value' => $meta_value,

			// 	'terms' => $terms,

			// 	'result' => $result,
			// ] );
		}
	}

	public static function format( $value, $taxonomy )
	{
		if ( empty( $value ) )
		{
			return [];
		}

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