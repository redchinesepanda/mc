<?php

class NotionYoast
{
	public static function register() 
	{
		$handler = new self();

		add_filter( 'wpseo_title', [ $handler, 'wp_kama_wpseo_title_filter' ], 10, 2 );

		add_filter( 'wpseo_metadesc', [ $handler, 'wp_kama_wpseo_metadesc_filter' ], 10, 2 );
	}

	const META_FIELD = [
		'title' => 'notion_wpseo_title',

		'description' => 'notion_wpseo_metadesc',
	]; 

	public static function wp_kama_wpseo_title_filter( $title, $presentation )
	{
		$post = get_post();

		if ( !empty( $post ) )
		{
			$meta_value = get_post_meta( $post->ID, self::META_FIELD[ 'title' ], true );

			if ( !empty( $meta_value ) )
			{
				$title = $meta_value;
			}
		}
		
		return $title;
	}

	public static function wp_kama_wpseo_metadesc_filter( $meta_description, $presentation )
	{
		$post = get_post();

		if ( !empty( $post ) )
		{
			$meta_value = get_post_meta( $post->ID, self::META_FIELD[ 'description' ], true );

			if ( !empty( $meta_value ) )
			{
				$meta_description = $meta_value;
			}
		}

		return $meta_description;
	}
}

?>