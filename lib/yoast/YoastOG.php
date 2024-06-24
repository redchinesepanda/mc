<?php

class YoastOG
{
	public static function register_functions()
    {
        $handler = new self();

		// add_filter( 'wpseo_opengraph_image', [ $handler, 'current_image_og' ] );

		add_filter( 'wpseo_twitter_image', [ $handler, 'current_image_twitter' ] );

		// add_filter( 'post_thumbnail_url', [ $handler, 'wp_kama_post_thumbnail_url_filter' ], 10, 3 );

		// add_filter( 'post_thumbnail_id', [ $handler, 'wp_kama_post_thumbnail_id_filter' ], 10, 2 );

		// add_filter( 'has_post_thumbnail', [ $handler, 'wp_kama_has_post_thumbnail_filter' ], 10, 3 );

		// LegalDebug::debug( [
		// 	'YoastOG' => 'register_functions',
		// ] );
		
		// add_filter( 'default_post_metadata', [ $handler, 'default_post_metadata__thumbnail_id' ], 10, 5 );

		add_action( 'wpseo_add_opengraph_images', [ $handler, 'add_og_images' ] );

		// add_filter( 'wpseo_twitter_image', [ $handler, 'default_opengraph' ] );
    }

	public static function add_og_images( $image_container )
	{
		LegalDebug::debug( [
			'YoastOG' => 'add_og_images',

			// 'image_container' => $image_container,

			'has_images' => $image_container->has_images(),
		] );

		if ( ! $image_container->has_images() )
		{
			$og_attachments = self::get_og_attachments();
	
			// LegalDebug::debug([
			// 	'YoastOG' => 'add_default_opengraph',
	
			// 	'og_attachments' => $og_attachments,
			// ]);
	
			if ( !empty( $og_attachments ) )
			{
				foreach ( $og_attachments as $og_attachment )
				{
					$image_container->add_image_by_id( $og_attachment );
				}
			}
			else
			{
				$image_container->add_image( self::get_default_image() );
			}
		}
	}

	// function default_opengraph()
	// {
	// 	// global $default_opengraph;

	// 	$default_opengraph = self::current_image();
		
	// 	return $default_opengraph;
	// }

	// function default_post_metadata__thumbnail_id( $value, $object_id, $meta_key, $single, $meta_type )
	// {
	// 	if ( '_thumbnail_id' == $meta_key )
	// 	{
	// 		$page_on_front = get_option( 'page_on_front' );

	// 		$thumbnail_id = get_post_thumbnail_id( $page_on_front );

	// 		// $value = 123; // the ID for the default image

	// 		$value = $thumbnail_id;


	// 	}

	// 	// LegalDebug::debug( [
	// 	// 	'YoastOG' => 'register_functions',

	// 	// 	'value' => $value,

	// 	// 	'meta_key' => $meta_key,
	// 	// ] );
		
	// 	return $value;
	// }

	// public static function wp_kama_has_post_thumbnail_filter( $has_thumbnail, $post, $thumbnail_id ){
	// 	LegalDebug::debug( [
	// 		'YoastOG' => 'wp_kama_has_post_thumbnail_filter',
	// 	] );
	
	// 	// filter...
	// 	// return $has_thumbnail;

	// 	return true;
	// }

	public static function current_image_twitter( $image )
	{
		// LegalDebug::debug( [
		// 	'YoastOG' => 'current_image_twitter',
		// ] );

		return self::get_default_image();
	}

	public static function current_image_og( $image )
	{
		// LegalDebug::debug( [
		// 	'YoastOG' => 'current_image_og',
		// ] );

		return self::get_default_image();
	}

	// public static function get_image( $image )
	// {
	// 	$attachments = self::get_og_attachments();

	// 	if ( !empty( $attachments ) )
	// 	{

	// 	}

	// 	return self::get_default_image();
	// }

	public static function get_default_image()
	{
		return LegalMain::LEGAL_URL . '/assets/img/yoast/preview-default.webp';

		// $language = WPMLMain::current_language();

		// if ( empty( $language ) )
		// {
		// 	$language = 'default';
		// }

		// if ( empty( $language ) || ! file_exists( LegalMain::LEGAL_PATH . '/assets/img/yoast/preview-' . $language . '.webp' ) )
		// {
			// $language = 'default';
		// }

		// $url = LegalMain::LEGAL_URL . '/assets/img/yoast/preview-' . $language . '.webp';

		// LegalDebug::debug( [
		// 	'YoastOG' => 'current_image',

		// 	'image' => $image,

		// 	'language' => $language,

		// 	'url' => $url,
		// ] );

		// return $url;
	}

	const TAXONOMY = [
		'media' => 'media_type',
	];

	const MEDIA_TYPE = [
		'og' => 'legal-og-image',
	];

	public static function get_og_attachment_query()
	{
		return [
			'posts_per_page' => -1,
			
			'post_type' => 'attachment',

			'tax_query' => [
				[
					'taxonomy' => self::TAXONOMY[ 'media' ],
					
					'terms' => self::MEDIA_TYPE,

					'field' => 'slug',

					'operator' => 'IN',
				],
			],

			'fields' => 'ids',
		];
	}

	public static function get_og_attachments()
	{
		return get_posts( self::get_og_attachment_query() );
	}

	public static function register()
    {
        // $handler = new self();

		// add_filter( 'wpseo_opengraph_image', [ $handler, 'current_image_og' ] );

		// add_filter( 'wpseo_twitter_image', [ $handler, 'current_image_twitter' ] );
	
		// // add_filter( 'wpseo_locale', [ $handler, 'yst_wpseo_change_og_locale' ] );

		// add_filter( 'post_thumbnail_url', [ $handler, 'wp_kama_post_thumbnail_url_filter' ], 10, 3 );

		// add_filter( 'post_thumbnail_id', [ $handler, 'wp_kama_post_thumbnail_id_filter' ], 10, 2 );
    }
	
	public static function wp_kama_post_thumbnail_id_filter( $thumbnail_id, $post )
	{
		LegalDebug::debug( [
			'YoastOG' => 'wp_kama_post_thumbnail_id_filter',

			'thumbnail_id' => $thumbnail_id,

            'post' => $post->ID,
		] );

		if ( empty( $thumbnail_id ) )
		{
			
			$page_on_front = get_option( 'page_on_front' );

			$thumbnail_id = get_post_thumbnail_id( $page_on_front );

			LegalDebug::debug( [
				'YoastOG' => 'wp_kama_post_thumbnail_id_filter',
	
				'page_on_front' => $page_on_front,
	
				'thumbnail_id' => $thumbnail_id,
			] );
		}

		return $thumbnail_id;
	}

	public static function wp_kama_post_thumbnail_url_filter( $thumbnail_url, $post, $size )
	{
		if ( empty( $thumbnail_url ) )
		{
			$thumbnail_url = LegalMain::LEGAL_URL . '/assets/img/yoast/preview-default.webp';
		}
		
		return $thumbnail_url;
	}

	// function yst_wpseo_change_og_locale( $locale )
	// {
	// 	LegalDebug::debug( [
	// 		'YoastOG' => 'yst_wpseo_change_og_locale',

	// 		'locale' => $locale,
	// 	] );

	// 	if ( MiltisiteMain::check_multisite() )
	// 	{
	// 		if ( $locale_multisite = MultisiteSiteOptions::get_blog_locale() )
	// 		{
	// 			LegalDebug::debug( [
	// 				'YoastOG' => 'yst_wpseo_change_og_locale',
		
	// 				'locale_multisite' => $locale_multisite,
	// 			] );
	// 		}
	// 	}

	// 	return $locale;
	// }
}

?>