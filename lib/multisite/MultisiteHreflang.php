<?php

class MultisiteHreflang
{
	public static function register_functions_debug()
	{
		$handler = new self();

		add_action( 'edit_form_after_title', [ $handler, 'mc_edit_form_after_title_debug' ] );

		// add_action( 'category_pre_edit_form', [ $handler, 'mc_category_pre_edit_form_debug' ], 10, 2 );
	}

    function mc_edit_form_after_title_debug( $post )
	{
        $group_items = self::get_group_items( $post->ID );

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

	public static function get_group_items( $terms )
	{
		$items = [];

		$posts = get_posts( self::group_items_query( $terms ) );

		foreach ( $posts as $post )
		{
			$items[] = get_post_permalink( $post->ID );
		}

		return $items;
	}

	public static function get_group_items_all( $post_id )
	{
		$current_blog_id = MultisiteBlog::get_current_blog_id();

		$translation_groups = WPMLTranslationGroups::get_translation_group( $post_id );

		$blogs = MultisiteBlog::get_other_sites();

		$items = [];

		foreach ( $blogs as $blog )
		{
			MultisiteBlog::set_blog( $blog->blog_id );

			$blog_locale = MultisiteBlog::get_blog_option( $blog->blog_id, MultisiteSiteOptions::OPTIONS[ 'blog-locale' ] );

			LegalDebug::debug( [
				'MultisiteHreflang' => 'get_group_items_all',

				'blog_id' => $blog->blog_id,

				'blog_locale' => $blog_locale,
			] );

			$items[ $blog_locale ] = get_group_items( $translation_groups );
		}

		MultisiteBlog::set_blog( $current_blog_id );

		return $items;
	}
}

?>