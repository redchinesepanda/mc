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

	public static function register_functions_admin()
	{
		// $handler = new self();

		// add_action( 'edit_form_after_title', [ $handler, 'mc_debug_edit_form_after_title_action' ] );
	}

	// function mc_debug_edit_form_after_title_action( $post )
	// {
	// 	$post = get_post();

	// 	$terms = self::get_post_terms( $post->ID );

	// 	self::add_post_terms( $post->ID, $terms );

	// 	LegalDebug::debug( [
	// 		'MultisiteMeta' => 'register_functions_admin',

	// 		'terms' => $terms,
	// 	] );
	// }

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
			// if ( $terms = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'slugs' ] ) )
			
			// if ( $terms = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'id=>slug' ] ) )
			
			if ( $terms = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'all' ] ) )
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
		// 	'MultisiteTerms' => 'add_post_terms',

		// 	'post_id' => $post_id,

		//     'result-count' => count( $result ),

		//     'result' => $result,
		// ] );
		
		foreach ( $result as $taxonomy => $post_terms )
		{
			$slugs = array_column( $post_terms, 'slug' );

			$term_ids = wp_set_object_terms( $post_id, $slugs, $taxonomy, false );
			
			// $object_terms = wp_set_object_terms( $post_id, $post_terms, $taxonomy, false );

			LegalDebug::debug( [
				'MultisitePost' => 'add_post_terms',

				'taxonomy' => $taxonomy,

				'slugs' => $slugs,

				'term_ids' => $term_ids,
			] );

			foreach ( $term_ids as $key => $term_id )
			{
				$args = [
					'name' => $post_terms[ $key ]->name,
				];

				LegalDebug::debug( [
					'MultisiteTerms' => 'add_post_terms',

					'args' => $args,
				] );

				wp_update_term( $term_id, $taxonomy, $args );

				MultisiteMeta::set_term_moved_from( $term_id, $post_terms[ $key ]->term_id )
			}
		}
	}
}

?>