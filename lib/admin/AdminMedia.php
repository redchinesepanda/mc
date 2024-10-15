<?php

class AdminMedia
{
	const TAXONOMY = [
		'media-type' => 'media_type',
	];

	public static function register()
	{
		$handler = new self();
		
		// add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_mega_billet' ] );

		// add_action( 'pre_get_posts', [ $handler, 'media_type_handler' ] );
		
		add_action( 'restrict_manage_posts', [ $handler, 'media_type_filter' ] );

		// LegalDebug::debug( [
		// 	'AdminMedia' => 'register-1',
		// ] );
	}

	public static function media_type_filter()
	{
		$screen = get_current_screen();

		// LegalDebug::debug( [
		// 	'AdminMedia' => 'media_type_filter-1',

		// 	'screen' => $screen,
		// ] );

		if ( 'upload' == $screen->id )
		{
			$selected = isset( $_GET[ self::TAXONOMY[ 'media-type' ] ] ) ? $_GET[ self::TAXONOMY[ 'media-type' ] ] : '';

			$dropdown_options = [ 
				'taxonomy' => self::TAXONOMY[ 'media-type' ],

				'show_option_all' => ToolLoco::translate( 'View all media types' ), 

				'hide_empty' => false, 

				'hierarchical' => false,

				 // default is cat which wouldn't filter custom taxonomies

				'value_field' => 'slug',

				'name' => self::TAXONOMY[ 'media-type' ], 

				'orderby' => 'name',

				'selected' =>  $selected,
			];

			wp_dropdown_categories( $dropdown_options );

			// LegalDebug::debug( [
			// 	'AdminMedia' => 'media_type_filter-2',
			// ] );
		}
	}

	// public static function media_type_handler( $query )
	// {
	// 	$scr = get_current_screen();

	// 	$media_type = filter_input( INPUT_GET, self::TAXONOMY[ 'media-type' ], FILTER_SANITIZE_STRING );

	// 	if ( ! $q->is_main_query() || ! is_admin() || ( int ) $media_type <= 0 || $scr->base !== 'upload' )
	// 	{
	// 		return '';
	// 	}
		
	// 	// get the posts

	// 	// $posts = get_posts( 'nopaging=1&category=' . $cat );

	// 	// get post ids

	// 	// $pids = empty( $posts ) ? false : wp_list_pluck($posts, 'ID');

	// 	// if ( ! empty( $pids ) )
	// 	// {
	// 		// $pidsTxt = implode( ',', $pids );

	// 		global $wpdb;

	// 		// Get the ids of media having retrieved posts as parent

	// 		// $mids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE post_parent IN ($pidsTxt)" );

	// 		// if ( ! empty($mids) )
	// 		// {
	// 		// 	// Force media query to retrieve only media having retrieved posts as parent

	// 		// 	$q->set( 'post__in', $mids );
	// 		// }
	// 		// else
	// 		// {
	// 		// 	// force media query to return no posts
			
	// 		// 	// Let query found nothing

	// 		// 	$q->set( 'p', -1 ); 
	// 		// }

	// 		LegalDebug::debug( [
	// 			'query' => $query,
	// 		] );

	// 	// }
	// }

	// public static function my_add_media_cat_dropdown()
	// {
	// 	$scr = get_current_screen();

	// 	if ( $scr->base !== 'upload' )
	// 	{
	// 		return '';
	// 	}

	// 	$cat = filter_input( INPUT_GET, 'postcat', FILTER_SANITIZE_STRING );

	// 	$selected = ( int ) $cat > 0 ? $cat : '-1';  

	// 	$args = [
	// 		'show_option_none' => 'All Post Categories',

	// 		'name' => 'postcat',

	// 		'selected' => $selected
	// 	];

	// 	wp_dropdown_categories( $args );
	// }
}

?>