<?php

class MultisiteTerms
{
	const TAXONOMIES_WP = [
		'category' => 'category',

		'post-tag' => 'post_tag',
	];

	const TAXONOMIES_PAGE = [
		'page-type' => 'page_type',

		'offer-group' => 'offer_group',

		'page-group' => 'page_group',
	];

	const TAXONOMIES_BILLET = [
		'billet-achievement' => 'billet_achievement',

		'billet-type' => 'billet_type',

		'billet-feature' => 'billet_feature',
	];

	const TAXONOMIES_ATTACHMENT = [
		'media-type' => 'media_type',
	];

	public static function get_taxonomies()
	{
		return array_merge( self::TAXONOMIES_WP, self::TAXONOMIES_PAGE, self::TAXONOMIES_BILLET, self::TAXONOMIES_ATTACHMENT );
	}

	public static function get_post_terms( $post_id )
	{
		$taxonomies = self::get_taxonomies();

		$result = [];

		foreach ( $taxonomies as $taxonomy )
		{
			if ( $terms = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'slugs' ] ) )
			{
				$result[ $taxonomy ] = $terms;
			}
		}

		// return wp_get_object_terms( $post_id, self::get_taxonomies(), [ 'fields' => 'slugs' ] );

		return $result;
	}

	public static function add_post_terms( $post_id, $result )
	{
		// LegalDebug::debug( [
		// 	'MultisiteMain' => 'add_post_terms',

		// 	'post_id' => $post_id,

		//     'result-count' => count( $result ),

		//     'result' => $result,
		// ] );
		
		foreach ( $result as $taxonomy => $post_terms )
		{
			$object_terms = wp_set_object_terms( $post_id, $post_terms, $taxonomy, false );

			// LegalDebug::debug( [
			// 	'MultisiteMain' => 'add_post_terms',

			// 	'object_terms' => $object_terms,
			// ] );
		}
	}
}

?>