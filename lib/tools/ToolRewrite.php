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

	public static function review_link( $post_link, $post, $leavename, $sample )
	{
		LegalDebug::debug( [
			'post_link' => $post_link,
			
			'post' => $post->ID,

			'leavename' => $leavename,

			'sample' => $sample,
		] );
		// if ( false !== strpos( $post_link, '%projectscategory%') )
		// {
		// 	$projectscategory_type_term = get_the_terms( $post->ID, 'projectscategory' );

		// 	if ( !empty( $projectscategory_type_term ) )
		// 	{
		// 		$post_link = str_replace( '%projectscategory%', array_pop( $projectscategory_type_term )->
		// 		slug, $post_link );
		// 	} else
		// 	{
		// 		$post_link = str_replace( '%projectscategory%', 'uncategorized', $post_link );
		// 	}
		// }

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