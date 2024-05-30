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

		// add_action( 'pre_get_posts', [ $handler, 'my_filter_media_by_cat' ] );
		
		add_action( 'restrict_manage_posts', [ $handler, 'media_type_filter' ] );
	}

	public static function my_filter_media_by_cat( $q )
	{
		$scr = get_current_screen();

		$cat = filter_input(INPUT_GET, 'postcat', FILTER_SANITIZE_STRING );

		if ( ! $q->is_main_query() || ! is_admin() || (int)$cat <= 0 || $scr->base !== 'upload' )
			return;
		
		// get the posts

		$posts = get_posts( 'nopaging=1&category=' . $cat );

		// get post ids

		$pids = empty( $posts ) ? false : wp_list_pluck($posts, 'ID');

		if ( ! empty( $pids ) )
		{
			$pidsTxt = implode( ',', $pids );

			global $wpdb;

			// Get the ids of media having retrieved posts as parent

			$mids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE post_parent IN ($pidsTxt)" );

			if ( ! empty($mids) )
			{
				// Force media query to retrieve only media having retrieved posts as parent

				$q->set( 'post__in', $mids );
			}
			else
			{
				// force media query to return no posts
			
				// Let query found nothing

				$q->set( 'p', -1 ); 
			}
		}
	}

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

	public static function media_type_filter()
	{
		$screen = get_current_screen();

		if ( 'upload' == $screen->id )
		{
			$dropdown_options = [ 
				'taxonomy' => self::TAXONOMY[ 'media-type' ],

				'show_option_all' => ToolLoco::translate( 'View all media types' ), 

				'hide_empty' => false, 

				'hierarchical' => false,

				 // default is cat which wouldn't filter custom taxonomies

				'value_field' => 'slug',

				'name' => self::TAXONOMY[ 'media-type' ], 

				'orderby' => 'name',
			];

			wp_dropdown_categories( $dropdown_options );
		}
	}
}

?>