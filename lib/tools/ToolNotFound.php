<?php

ini_set( 'error_reporting', -1 );
ini_set( 'display_errors', 'On' );

class ToolNotFound
{
	// public static function check()
    // {
	// 	$not_logged_in = !is_user_logged_in();

	// 	$singilar_custom = is_singular( [ 'legal_billet', 'legal_compilation' ] );

    //     return ( $not_logged_in && $singilar_custom );
    // }

	public static function register()
    {
        $handler = new self();

		// add_action( 'template_redirect', [ $handler, 'set_not_found' ] );

		// add_action( 'parse_request', [ $handler, 'debug_404_rewrite_dump' ] );

		// add_action( 'template_redirect', [ $handler, 'debug_404_template_redirect' ], 99999 );

		// add_filter ( 'template_include', [ $handler, 'debug_404_template_dump' ] );

		add_action ( 'wp_head', [ $handler, 'get_trash' ] );
    }

	// public static function set_not_found()
	// {
	// 	if ( self::check() )
	// 	{
	// 		global $wp_query;

	// 		$wp_query->set_404();
	// 	}
	// }

	function get_trash( &$wp )
	{
		$posts = get_posts( [
			'posts_per_page' => -1,

			'post_type' => [ 'post', 'page', 'legal_bk_review' ],

			'post_status' => 'trash'
		] );

		LegalDebug::debug( [
			'posts' => $posts,
		] );
	}

	function debug_404_rewrite_dump( &$wp )
	{
		global $wp_rewrite;

		global $wp_the_query;

		LegalDebug::debug( [
			'function' => 'debug_404_rewrite_dump',
			
			'rewrite rules' => var_export( $wp_rewrite->wp_rewrite_rules(), true ),

			'permalink structure' => var_export( $wp_rewrite->permalink_structure, true ),

			'page permastruct' => var_export( $wp_rewrite->get_page_permastruct(), true ),

			'matched rule and query' => var_export( $wp->matched_rule, true ),

			'request' => var_export( $wp->request, true ),

			'the query' => var_export( $wp_the_query, true )
		] );

		// echo '<h2>rewrite rules</h2>';

		// echo var_export( $wp_rewrite->wp_rewrite_rules(), true );

		// echo '<h2>permalink structure</h2>';

		// echo var_export( $wp_rewrite->permalink_structure, true );

		// echo '<h2>page permastruct</h2>';

		// echo var_export( $wp_rewrite->get_page_permastruct(), true );

		// echo '<h2>matched rule and query</h2>';

		// echo var_export( $wp->matched_rule, true );

		// echo '<h2>matched query</h2>';

		// echo var_export( $wp->matched_query, true );

		// echo '<h2>request</h2>';

		// echo var_export( $wp->request, true );
		
		// echo '<h2>the query</h2>';

		// echo var_export( $wp_the_query, true );
	}

	function debug_404_template_redirect()
	{
		global $wp_filter;

		LegalDebug::debug( [
			'function' => 'debug_404_template_redirect',
			
			'template redirect filters' =>  var_export( $wp_filter[current_filter()], true ),
		] );
		
		// echo '<h2>template redirect filters</h2>';

		// echo var_export( $wp_filter[current_filter()], true );
	}

	function debug_404_template_dump( $template )
	{
		LegalDebug::debug( [
			'function' => 'debug_404_template_dump',
			
			'template file selected' =>  var_export( $template, true ),
		] );

		// echo '<h2>template file selected</h2>';

		// echo var_export( $template, true );
		
		// echo '</pre>';

		exit();
	}
}

?>