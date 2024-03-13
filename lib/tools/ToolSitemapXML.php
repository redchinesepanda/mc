<?php

// Втсрокнная Wordpress XML Карта Сайта
// https://wp-kama.ru/handbook/sitemap

class ToolSitemapXML
{
    // public static function register_functions()
    
	public static function register()
    {
        LegalDebug::debug( [
            'ToolSitemapXML',
        ] );

        $handler = new self(); 

        add_filter( 'wp_sitemaps_max_urls', [ $handler, 'kama_sitemap_max_urls'], 10, 2 );

        // Отключение провайдера карт сайтов: пользователи и таксономии

        add_filter( 'wp_sitemaps_add_provider', [ $handler, 'kama_remove_sitemap_provider' ], 10, 2 );
        
        //  Отключение типа записи из карты сайта

        add_filter( 'wp_sitemaps_post_types', [ $handler,'wpkama_remove_sitemaps_post_types' ] );

        # Отключение таксономии из карты сайта

        // add_filter( 'wp_sitemaps_taxonomies', [ $handler,'wpkama_remove_sitemaps_taxonomies' ] );

        # Добавление колонок Last Modified, Change Frequency, Priority

        add_filter( 'wp_sitemaps_posts_entry', [ $handler, 'wpkama_sitemaps_posts_entry' ], 10, 2 );

        # Изменение параметров запроса WP_Query для карты сайта posts

        add_filter( 'wp_sitemaps_posts_query_args', [ $handler, 'wp_kama_sitemaps_posts_query_args_filter' ], 10, 2 );
    }
    
    public static function kama_sitemap_max_urls( $num, $object_type )
    {
        return 1000;
    }

    const PROVIDERS = [
        'users',
        
        'taxonomies',
    ];

    public static function kama_remove_sitemap_provider( $provider, $name )
    {
        if( in_array( $name, self::PROVIDERS ) )
        {
            return false;
        }

        return $provider;
    }

    const POST_TYPES = [
        'tcb_symbol',

        'affiliate-links',

		'legal_bk_review',

		'tcb_lightbox',
    ];

    public static function wpkama_remove_sitemaps_post_types( $post_types )
    {
        foreach ( self::POST_TYPES as $type )
        {
            unset( $post_types[ $type ] );
        }

        return $post_types;
    }

    // const TAXONOMIES = [
    //     'post_tag',

    //     'page_group',

    //     'media_type',

    //     'page_type',

    //     'billet_feature',

    //     'billet_achievement',

    //     'offer_group',
    // ];

    // public static function wpkama_remove_sitemaps_taxonomies( $taxonomies )
    // {
    //     foreach ( self::TAXONOMIES as $taxonomy )
    //     {
    //         unset( $taxonomies[ $taxonomy ] );
    //     }

    //     return $taxonomies;
    // }
    
    public static function wp_kama_sitemaps_posts_query_args_filter( $args, $post_type )
    {
        $args[ 'suppress_filters' ] = true;

        return $args;
    }

    const PRIORITY = [
        'high' => 0.9,

        'page' => 0.7,

        'post' => 0.3,

        'low' => 0.2,
    ];
    
    public static function get_priority( $post )
    {
        if ( WPMLTrid::get_trid( $post->ID ) == WPMLTrid::get_trid( get_option('page_on_front') ) )
        {
            return self::PRIORITY[ 'high' ];
        }

        if ( array_key_exists( $post->post_type, self::PRIORITY ) )
        {
            return self::PRIORITY[ $post->post_type ];
        }

        return self::PRIORITY[ 'low' ];
    }

    public static function wpkama_sitemaps_posts_entry( $entry, $post )
    {
        LegalDebug::debug( [
            'ToolSitemapXML' => 'wpkama_sitemaps_posts_entry',
        ] );

        $entry[ 'lastmod' ] = get_the_modified_date( 'c', $post );

        $entry[ 'priority' ] = self::get_priority( $post );

        $entry[ 'changefreq' ] = 'weekly';

        return $entry;
    }
}

?>