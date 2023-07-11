<?php

// ini_set( 'error_reporting', -1 );
// ini_set( 'display_errors', 'On' );

class ToolRewrite
{
	public static function register()
	{
		$handler = new self();

		// add_action( 'parse_request', [ $handler, 'debug_404_rewrite_dump' ] );

		// add_action( 'template_redirect', [ $handler, 'debug_404_template_redirect' ], 99999 );

		// add_filter ( 'template_include', [ $handler, 'debug_404_template_dump' ] );

		add_filter( 'post_type_link', [ $handler, 'review_link' ], 10, 4 );
	}

	const TAXONOMY = 'page_group';

	public static function review_link( $post_link, $post, $leavename, $sample )
	{
		// LegalDebug::debug( [
		// 	'post_link' => $post_link,
			
		// 	'ID' => $post->ID,

		// 	'post_title' => $post->post_title,

		// 	'post_type' => $post->post_type,
			
		// 	'post_name' => $post->post_name,

		// 	'leavename' => ( $leavename ? 'true' : 'false' ),

		// 	'sample' => ( $sample ? 'true' : 'false' ),
		// ] );
		
		if ( in_array( $post->post_type, [ 'legal_bk_review' ] ) )
		{
			// $terms = get_the_terms( $post->ID, 'page_group' );

			// $terms = wp_get_post_terms( $post->ID, self::TAXONOMY );

			$term_id = get_post_meta( $post->ID, '_yoast_wpseo_primary_category', true );

			LegalDebug::debug( [
				'term_id' => $term_id,
			] );

			$page_group = '';

			// if ( !empty( $terms ) )
			
			if ( !empty( $term_id ) )
			{
				// $slug = array_pop( $terms )->slug;
				
				$slug = get_term( $term_id )->slug;

				LegalDebug::debug( [
					'post_name' => $post->post_name,

					'slug' => $slug,
				] );

				if ( $slug != $post->post_name ) {
					$page_group = $slug . '/' . $post->post_name;
				}
			}

			if ( !empty( $page_group ) ) {
				$post_link = str_replace( $post->post_name, $page_group, $post_link );
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