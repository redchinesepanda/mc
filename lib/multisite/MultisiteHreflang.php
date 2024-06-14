<?php

class MultisiteHreflang
{
	public static function register_functions_debug()
	{
		// $handler = new self();

		// add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );

		// add_action( 'category_pre_edit_form', [ $handler, 'mc_category_pre_edit_form_debug' ], 10, 2 );
		
		// add_filter( 'acf/settings/save_json', [ $handler, 'my_acf_json_save_point' ] );
	}

	// public static function my_acf_json_save_point( $path )
	// {
	// 	// return get_stylesheet_directory() . '/my-custom-folder';

	// 	LegalDebug::debug( [
	// 		'MultisiteHreflang' =>'my_acf_json_save_point',

	// 		'path' => $path,
	// 	] );

	// 	return $path;
	// }

    // public static function mc_edit_form_after_title_debug( $post )
	// {
    //     // $group_items = self::get_group_items_all( $post->ID );

	// 	// LegalDebug::debug( [
	// 	// 	'MultisiteHreflang' => 'mc_edit_form_after_title_debug',

	// 	// 	'group_items' => $group_items,
	// 	// ] );
    // }

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

	public static function get_blog_uri()
	{
		$current_blog_id = MultisiteBlog::get_current_blog_id();

		$current_blog_details = MultisiteBlog::get_blog_details( $current_blog_id );

		// LegalDebug::debug( [
        //     'MultisiteHreflang' => 'get_blog_uri',

		// 	'current_blog_id' => $current_blog_id,

		// 	'current_blog_details' => $current_blog_details,
        // ] );

		return $current_blog_details->siteurl;
	}

	public static function get_post_uri( $post )
	{
		// $url =  trim( get_bloginfo( 'url' ), '/' );
		
		$url =  self::get_blog_uri();

		// $post_path = Permalink_Manager_URI_Functions_Post::get_post_uri( $post );
		
		// $permalink_post_uri = Permalink_Manager_URI_Functions_Post::get_post_uri( $post );

		// $permalink_uri = ToolPermalink::get_post_uri( $post->ID );

		// $permalink_post_uri = '';

		// if ( class_exists( 'Permalink_Manager_URI_Functions_Post' ) )
		// {
		// 	$permalink_post_uri = Permalink_Manager_URI_Functions_Post::get_post_uri( $post );
		// }
		
		$post_path = ToolPermalink::get_post_uri( $post->ID );

		// LegalDebug::debug( [
		// 	'MultisiteHreflang' => 'get_post_uri',

		// 	'permalink_post_uri' => $permalink_post_uri,

		// 	'post_path' => $post_path,
		// ] );

		$language_code = WPMLMain::get_language_code( $post->ID );

		LegalDebug::debug( [
			'MultisiteHreflang' => 'get_post_uri',

			'$post' => $post->ID,

			'$url' => $url,

			'$post_path' => $post_path,

			'$language_code' => $language_code,
		] );

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

		$group_items_query = self::group_items_query( $terms );

		// LegalDebug::debug( [
		//     'MultisiteHreflang' => 'get_group_items',

		// 	'group_items_query' => $group_items_query,
		// ] );

		$posts = get_posts( $group_items_query );

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

			// $items[ $locale ] = [
			
			$items[] = [
				'post_title' => $post_title,

				'post_uri' => $post_uri,

				'language_code' => $language_code,

				'locale' => $locale,
			];
		}

		// LegalDebug::debug( [
		// 	'MultisiteHreflang' => 'get_group_items',

		// 	'items' => $items,
		// ] );

		return $items;
	}

	public static function get_group_items_all( $post_id )
	{
		$current_blog_id = MultisiteBlog::get_current_blog_id();

		// $current_blog = MultisiteBlog::get_blog_details( $current_blog_id );

		// $current_domain = $current_blog->domain;
		
		$current_domain = MultisiteBlog::get_domain( $current_blog_id );

		// $current_domain = '';

		$translation_groups = WPMLTranslationGroups::get_translation_group( $post_id );

		// $blogs = MultisiteBlog::get_other_sites( $current_domain );
		
		$blogs = MultisiteBlog::get_all_sites( $current_domain );
		
		// LegalDebug::debug( [
		// 	'MultisiteHreflang' => 'get_group_items_all',

		// 	'current_domain' => $current_domain,

		// 	'translation_groups' => $translation_groups,

		// 	'blogs' => count( $blogs ),
		// ] );

		$items = [];

		foreach ( $blogs as $blog )
		{
			MultisiteBlog::set_blog( $blog->blog_id );

			// $blog_locale = MultisiteBlog::get_blog_option( $blog->blog_id, MultisiteSiteOptions::OPTIONS[ 'blog-locale' ] );

			// LegalDebug::debug( [
			// 	'MultisiteHreflang' => 'get_group_items_all',

			// 	// 'blog' => $blog,

			// 	'blog_id' => $blog->blog_id,

			// 	// 'blog_locale' => $blog_locale,

			// 	// 'url' => get_bloginfo( 'url' ),
			// ] );

			// $items[ $blog->blog_id ] = self::get_group_items( $translation_groups );

			if ( MultisiteBlog::check_not_main_blog() )
			{
				$group_items = self::get_group_items( $translation_groups );

				// LegalDebug::debug( [
				// 	'MultisiteHreflang' => 'get_group_items_all',

				// 	'blog_id' => $blog->blog_id,
		
				// 	'group_items' => $group_items,
				// ] );

				$items = array_merge( $items, $group_items );
			}
		}

		MultisiteBlog::set_blog( $current_blog_id );

		return $items;
	}

	const TEMPLATE = [
        'multiste-hreflang' => LegalMain::LEGAL_PATH . '/template-parts/multisite/part-multisite-hreflang.php',
    ];

	public static function parse_hreflang( $items )
	{
		$hreflangs = [];

		// foreach ( $items as $locale => $item )
		
		foreach ( $items as $item )
		{
			$locale = $item[ 'locale' ];

			$hreflang = WPMLMain::get_hreflang( $locale );

			if ( $locale == 'en_GB' )
			{
				$hreflang = 'x-default';
			}

			$hreflangs[] = [
				'hreflang' => $hreflang,

				'href' => $item[ 'post_uri' ],
			];
		}

		return $hreflangs;
	}

	public static function prepare_hreflang()
	{
		if ( MiltisiteMain::check_multisite() )
        {
			$args = [];

			if ( $post = get_post() )
			{
				$items = self::get_group_items_all( $post->ID );

				$args = [
					'items' => self::parse_hreflang( $items ),
				];
			}

			return self::render_hreflang( $args );
		}

		return '';
    }

	public static function parse_languages( $items )
	{
		$languages = [];

		// foreach ( $items as $locale => $item )
		
		foreach ( $items as $item )
		{
			$language_code = $item[ 'language_code' ];

			// $hreflang = WPMLMain::get_hreflang( $locale );

			// if ( $locale == 'en_GB' )
			// {
			// 	$hreflang = 'x-default';
			// }

			$languages[ $language_code ] = [
				// 'hreflang' => $hreflang,

				'url' => $item[ 'post_uri' ],
			];
		}

		return $languages;
	}

	public static function prepare_languages()
	{
		// $languages = [];

		// if ( MiltisiteMain::check_multisite() )
        // {
			// $args = [];

			if ( $post = get_post() )
			{
				$group_items_all = self::get_group_items_all( $post->ID );

				// $args = [
				// 	'items' => self::parse_languages( $group_items_all ),
				// ];

				// LegalDebug::debug( [
				// 	'MultisiteHreflang' => 'prepare_languages',

				// 	'group_items_all' => $group_items_all,
				// ] );

				$languages = self::parse_languages( $group_items_all );

				return $languages;
			}

			// return self::render_hreflang( $args );
		// }

		// return '';

		// return $languages;

		return [];
    }

	public static function render_hreflang( $args )
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'multiste-hreflang' ], $args );
    }
}

?>