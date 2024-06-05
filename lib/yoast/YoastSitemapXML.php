<?php

class YoastSitemapXML
{
	public static function register_functions()
    {
        $handler = new self();

        // Exclude a post type
	
		add_filter( 'wpseo_sitemap_exclude_post_type', [ $handler, 'sitemap_exclude_post_type' ], 10, 2 );

        // Exclude a taxonomy
	
		add_filter( 'wpseo_sitemap_exclude_taxonomy', [ $handler, 'sitemap_exclude_taxonomy' ], 10, 2 );
    }

	const POST_TYPES = [
        'affiliate-links',

        'author',
    ];

	function sitemap_exclude_post_type( $excluded, $post_type )
	{
		// return $post_type === 'recipes';
		
		return in_array( $post_type, self::POST_TYPES );
	}

	const TAXONOMY = [
        'post_tag',

        'translation_group',

        'offer_group',

        'page_group',

        'billet_achievement',

        'media_type',

        'billet_type',

        'page_type',

        'billet_feature',
    ];

	function sitemap_exclude_taxonomy( $excluded, $taxonomy )
	{
		// return $post_type === 'recipes';
		
		return in_array( $taxonomy, self::TAXONOMY );
	}
}

?>