<?php

class NotionYoast
{
	public static function register() 
	{
		$handler = new self();

		add_filter( 'wpseo_title', [ $handler, 'legal_wpseo_filter_title' ], 10, 2 );

		add_filter( 'wpseo_metadesc', [ $handler, 'legal_wpseo_filter_description' ], 10, 2 );
	}

	const META_FIELD = [
		'title' => 'notion_wpseo_title',

		'description' => 'notion_wpseo_metadesc',
	]; 

	public static function legal_wpseo_filter( $meta_key, $default )
	{
		$post = get_post();

		if ( !empty( $post ) )
		{
			$meta_value = get_post_meta( $post->ID, $meta_key, true );

			if ( !empty( $meta_value ) )
			{
				return ReviewTitle::replace_placeholder( $meta_value );
			}
		}
		
		return $default;
	}

	public static function legal_wpseo_filter_title( $title, $presentation )
	{
		// $post = get_post();

		// if ( !empty( $post ) )
		// {
		// 	$meta_value = get_post_meta( $post->ID, self::META_FIELD[ 'title' ], true );

		// 	if ( !empty( $meta_value ) )
		// 	{
		// 		$title = ReviewTitle::replace_placeholder( $meta_value );
		// 	}
		// }
		
		// return $title;

		return self::legal_wpseo_filter( self::META_FIELD[ 'title' ], $title );
	}

	public static function legal_wpseo_filter_description( $meta_description, $presentation )
	{
		// $post = get_post();

		// if ( !empty( $post ) )
		// {
		// 	$meta_value = get_post_meta( $post->ID, self::META_FIELD[ 'description' ], true );

		// 	if ( !empty( $meta_value ) )
		// 	{
		// 		$meta_description = $meta_value;
		// 	}
		// }

		// return $meta_description;

		return self::legal_wpseo_filter( self::META_FIELD[ 'description' ], $meta_description );
	}
}

?>