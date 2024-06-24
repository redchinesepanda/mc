<?php

class YoastOG
{
	const TAXONOMY = [
		'media' => 'media_type',
	];

	const MEDIA_TYPE = [
		'og' => 'legal-og-image',
	];

	public static function register_functions()
    {
        $handler = new self();

		add_action( 'wpseo_add_opengraph_images', [ $handler, 'add_og_images' ] );

		add_filter( 'wpseo_opengraph_image', [ $handler, 'default_og_image' ] );

		add_filter( 'wpseo_twitter_image', [ $handler, 'default_twitter_image' ] );
    }

	public static function add_og_images( $image_container )
	{
		$thumbnail_id = get_post_thumbnail_id();

		// LegalDebug::debug( [
		// 	'YoastOG' => 'add_og_images',

		// 	// 'image_container' => $image_container,

		// 	// 'has_post_thumbnail' => has_post_thumbnail(),

		// 	'thumbnail_id' => $thumbnail_id,

		// 	// 'post_exists' => post_exists( $thumbnail_id ),

		// 	'wp_get_attachment_url' => wp_get_attachment_url( $thumbnail_id ),

		// 	'get_images' => $image_container->get_images(),

		// 	'has_images' => $image_container->has_images(),
		// ] );

		// if ( ! $image_container->has_images() )
		
		// if ( ! has_post_thumbnail() )
		
		if ( empty( wp_get_attachment_url( $thumbnail_id ) ) )
		{
			// $og_attachments = self::get_og_attachments();
			
			$og_attachment = self::get_og_attachment();
	
			// LegalDebug::debug([
			// 	'YoastOG' => 'add_default_opengraph',
	
			// 	'og_attachments' => $og_attachments,
			// ]);
	
			// if ( !empty( $og_attachments ) )
			
			if ( !empty( $og_attachment ) )
			{
				// foreach ( $og_attachments as $og_attachment )
				// {
				// 	$image_container->add_image_by_id( $og_attachment );
				// }

				$image_container->add_image_by_id( $og_attachment );
			}
			else
			{
				$image_container->add_image( self::get_default_image() );
			}
		}
	}

	public static function default_twitter_image( $image )
	{
		// LegalDebug::debug( [
		// 	'YoastOG' => 'default_twitter_image',
		// ] );

		return self::get_default_image();
	}

	public static function default_og_image( $image )
	{
		// LegalDebug::debug( [
		// 	'YoastOG' => 'default_og_image',
		// ] );

		// return self::get_default_image();

		return self::get_og_attachment_url();
	}

	public static function get_default_image()
	{
		return LegalMain::LEGAL_URL . '/assets/img/yoast/preview-default.webp';
	}

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

	public static function get_og_attachment()
	{
		$attachments = self::get_og_attachments();

		if ( ! empty( $attachments ) )
		{
			return array_shift( $attachments );
		}

		return null;
	}

	public static function get_og_attachment_url()
	{
		$attachment = self::get_og_attachment();

		if ( ! empty( $attachment ) )
		{
			if ( $attachment_url = wp_get_attachment_url( $attachment ) )
			{
				return $attachment_url;
			}
		}

		return self::get_default_image();
	}
}

?>