<?php

// ini_set( 'error_reporting', -1 );
// ini_set( 'display_errors', 'On' );

class ToolRewrite
{
	const TAXONOMY = [
		'group' => 'page_group',
	];

	const POST_TYPE = [
		'review' => 'legal_bk_review',
	];

	const SLUG = [
		'bonus',

		'promo-codes',
	];

	public static function register()
	{
		$handler = new self();

		// add_action( 'parse_request', [ $handler, 'debug_404_rewrite_dump' ] );

		// add_action( 'template_redirect', [ $handler, 'debug_404_template_redirect' ], 99999 );

		// add_filter ( 'template_include', [ $handler, 'debug_404_template_dump' ] );

		// add_filter( 'post_type_link', [ $handler, 'review_link' ], 10, 4 );

		add_filter( 'rewrite_rules_array', [ $handler, 'mmp_rewrite_rules' ] );

		add_filter( 'post_type_link', [ $handler, 'filter_post_type_link' ], 10, 2 );

		add_filter( 'wp_unique_post_slug', [ $handler, 'wpse313422_non_unique_post_slug' ], 10, 6 );
	}

	public static function wpse313422_non_unique_post_slug( $slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug )
	{
		LegalDebug::debug( [
			'slug' => $slug,

			'post_ID' => $post_ID,

			'post_status' => $post_status,

			'post_type' => $post_type,

			'post_parent' => $post_parent,
			
			'original_slug' => $original_slug,
		] );

		if( $post_type === self::POST_TYPE[ 'review' ] && in_array( $original_slug, self::SLUG ) )
		{
			// Perform category conflict, permalink structure
			//     and other necessary checks.
			// Don't just use it as it is.

			return $original_slug;
		}

		return $slug;
	}

	public static function mmp_rewrite_rules( $rules )
	{
		$newRules = [];

		$newRules[ 'basename/(.+)/(.+)/(.+)/(.+)/?$' ] = 'index.php?custom_post_type_name=$matches[4]';
		
		// my custom structure will always have the post name as the 5th uri segment

		$newRules[ 'basename/(.+)/?$' ] = 'index.php?taxonomy_name=$matches[1]'; 

		return array_merge( $newRules, $rules );
	}

	public static function filter_post_type_link( $link, $post )
	{
		if ( $post->post_type != self::POST_TYPE[ 'review' ] )
		{
			return $link;
		}

		if ( $cats = get_the_terms( $post->ID, self::TAXONOMY[ 'group' ] ) )
		{
			$link = str_replace( '%taxonomy_name%', array_pop( $cats )->slug, $link );
			
			// see custom function defined below
		}

		return $link;
	}

	public static function review_link( $post_link, $post, $leavename, $sample )
	{
		if ( in_array( $post->post_type, [ 'legal_bk_review' ] ) )
		{
			$term_id = get_post_meta( $post->ID, '_yoast_wpseo_primary_' . self::TAXONOMY[ 'group' ], true );

			// $wpseo_primary_term = new WPSEO_Primary_Term( self::TAXONOMY[ 'group' ], $post->ID );
        	
			// $term_id = $wpseo_primary_term->get_primary_term();

			// LegalDebug::debug( [
			// 	'term_id' => $term_id,
			// ] );

			$page_group = '';

			if ( !empty( $term_id ) )
			{
				$slug = get_term( $term_id )->slug;

				// LegalDebug::debug( [
				// 	'post_link' => $post_link,

				// 	'post_name' => $post->post_name,

				// 	'slug' => $slug,
				// ] );

				if ( $slug != $post->post_name ) {
					$page_group = $slug . '/' . $post->post_name;
					
					// $page_group = '/' . $slug;
				}
			}

			if ( !empty( $page_group ) ) {
				$post_link = str_replace( $post->post_name, $page_group, $post_link );
				
				// $post_link = str_replace( '/%taxonomy_name%', $page_group, $post_link );
			}
		}

		return $post_link;
	}

	// public static function debug_404_rewrite_dump( &$wp ) {
	// 	global $wp_rewrite;

	// 	global $wp_the_query;
		
	// 	LegalDebug::debug( [
	// 		'rewrite rules' => var_export( $wp_rewrite->wp_rewrite_rules(), true ),

	// 		'permalink structure' => var_export( $wp_rewrite->permalink_structure, true ),

	// 		'page permastruct' => var_export( $wp_rewrite->get_page_permastruct(), true ),

	// 		'matched rule and query' => var_export( $wp->matched_rule, true ),

	// 		'matched query' => var_export( $wp->matched_query, true ),

	// 		'request' => var_export( $wp->request, true ),

	// 		'the query' => var_export( $wp_the_query, true ),
	// 	] );
	// }
	
	// public static  function debug_404_template_redirect() {
	// 	global $wp_filter;

	// 	LegalDebug::debug( [
	// 		'template redirect filters' => var_export( $wp_filter[current_filter()], true ),
	// 	] );
	// }
	
	// public static  function debug_404_template_dump( $template ) { 
	// 	LegalDebug::debug( [
	// 		'template file selected' => var_export( $template, true ),
	// 	] );
	// }
}

?>