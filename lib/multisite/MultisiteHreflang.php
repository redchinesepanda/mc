<?php

class MultisiteHreflang
{
	public static function register_functions_debug()
	{
		$handler = new self();

		add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );

		// add_action( 'category_pre_edit_form', [ $handler, 'mc_category_pre_edit_form_debug' ], 10, 2 );
		
		add_filter( 'acf/settings/save_json', [ $handler, 'my_acf_json_save_point' ] );
	}

	public static function my_acf_json_save_point( $path )
	{
		// return get_stylesheet_directory() . '/my-custom-folder';

		LegalDebug::debug( [
			'MultisiteHreflang' =>'my_acf_json_save_point',

			'path' => $path,
		] );

		return $path;
	}

    public static function mc_edit_form_after_title_debug( $post )
	{
        $group_items = self::get_group_items_all( $post->ID );

		LegalDebug::debug( [
			'MultisiteHreflang' => 'mc_edit_form_after_title_debug',

			'group_items' => $group_items,
		] );
    }

	public static function group_items_query( $terms )
	{
		return [
			'posts_per_page' => -1,
			
			'post_type' => 'page',

			'tax_query' => [
				[
					'taxonomy' => WPMLTranslationGroups::TAXONOMY[ 'translation_group' ],

					'terms' => $terms,

					'field' => 'slug',

					'operator' => 'IN',
				],
			],
		];
	}

	const PATTERN = [
		'post-uri' => '%s/%s/%s',

		'post-uri-root' => '%s/%s',
	];

	public static function get_post_uri( $post )
	{
		$url = get_bloginfo( 'url' );

		$post_path = Permalink_Manager_URI_Functions_Post::get_post_uri( $post );

		$language_code = WPMLMain::get_language_code( $post->ID );

		if ( $language_code == 'en' )
        {
            $language_code = '';
        }

		if ( !empty( $language_code ) )
		{
			return sprintf( self::PATTERN[ 'post-uri' ], $url, $language_code, $post_path );
		}

		return sprintf( self::PATTERN[ 'post-uri-root' ], $url, $post_path );
	}

	public static function get_group_items( $terms )
	{
		$items = [];

		$posts = get_posts( self::group_items_query( $terms ) );

		foreach ( $posts as $post )
		{
			$post_title = $post->post_title;

			$post_uri = self::get_post_uri( $post );

			$language_code = WPMLMain::get_language_code( $post->ID );

			// LegalDebug::debug( [
            //     'MultisiteHreflang' => 'get_group_items',

			// 	'language_code' => $language_code,
            // ] );

			if ( empty( $language_code ) )
			{
				$language_code = MultisiteSiteOptions::get_blog_language();
			}

			$locale = WPMLMain::multisite_locale( $language_code );

			// LegalDebug::debug( [
            //     'MultisiteHreflang' => 'get_group_items',

			// 	'post_title' => $post_title,

			// 	'post_uri' => $post_uri,

			// 	'language_code' => $language_code,

			// 	'locale' => $locale,
            // ] );

			$items[ $locale ] = [
				'post_title' => $post_title,

				'post_uri' => $post_uri,
			];
		}

		return $items;
	}

	public static function get_group_items_all( $post_id )
	{
		$current_blog_id = MultisiteBlog::get_current_blog_id();

		$translation_groups = WPMLTranslationGroups::get_translation_group( $post_id );

		$blogs = MultisiteBlog::get_other_sites();
		
		// LegalDebug::debug( [
		// 	'MultisiteHreflang' => 'get_group_items_all',

		// 	'blogs' => count( $blogs ),
		// ] );

		$items = [];

		foreach ( $blogs as $blog )
		{
			MultisiteBlog::set_blog( $blog->blog_id );

			// $blog_locale = MultisiteBlog::get_blog_option( $blog->blog_id, MultisiteSiteOptions::OPTIONS[ 'blog-locale' ] );

			LegalDebug::debug( [
				'MultisiteHreflang' => 'get_group_items_all',

				'blog' => $blog,

				// 'blog_id' => $blog->blog_id,

				// 'blog_locale' => $blog_locale,

				// 'url' => get_bloginfo( 'url' ),
			] );

			$items[ $blog->blog_id ] = self::get_group_items( $translation_groups );

			// $items = array_merge( $items, self::get_group_items( $translation_groups ) );
		}

		MultisiteBlog::set_blog( $current_blog_id );

		return $items;
	}
}

?>