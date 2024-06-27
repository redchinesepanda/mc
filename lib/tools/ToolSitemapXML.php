<?php

// Втсрокнная Wordpress XML Карта Сайта
// https://wp-kama.ru/handbook/sitemap

class ToolSitemapXML
{
    public static function register_functions()
    {
        // Disable WP XML Sitemaps

        // add_filter( 'wp_sitemaps_enabled', '__return_false' );

        $handler = new self();

        // add_filter( 'wp_sitemaps_max_urls', [ $handler, 'kama_sitemap_max_urls'], 10, 2 );

        // Отключение провайдера карт сайтов: пользователи и таксономии

        add_filter( 'wp_sitemaps_add_provider', [ $handler, 'kama_remove_sitemap_provider' ], 10, 2 );
        
        //  Отключение типа записи из карты сайта

        add_filter( 'wp_sitemaps_post_types', [ $handler,'wpkama_remove_sitemaps_post_types' ] );

        # Добавление колонок Last Modified, Change Frequency, Priority

        add_filter( 'wp_sitemaps_posts_entry', [ $handler, 'wpkama_sitemaps_posts_entry' ], 10, 2 );

        # Изменение параметров запроса WP_Query для карты сайта posts

        add_filter( 'wp_sitemaps_posts_query_args', [ $handler, 'wp_kama_sitemaps_posts_query_args_filter' ], 10, 2 );

        # WP_Query отдавет массив только с ID, что улучшит скорость генерации страницы и снизит нагрузку
        
        // add_filter( 'wp_sitemaps_posts_query_args', [ $handler, 'optimize_sitemap_posts_query' ], 10, 1 );

        add_filter( 'posts_join', [ $handler, 'wp_kama_posts_join_filter' ] );

        add_filter( 'posts_clauses', [ $handler, 'wp_kama_posts_clauses_filter' ] );

        add_filter( 'posts_where', 'wp_kama_posts_where_filter' );
    }

    
    public static function wp_kama_posts_where_filter( $where )
    {
        LegalDebug::debug( [
            'ToolSitemapXML' => 'wp_kama_posts_where_filter',

            'where' => $where,
        ] );

        return $where;
    }

    public static function wp_kama_posts_clauses_filter( $clauses )
    {
        LegalDebug::debug( [
            'ToolSitemapXML' => 'wp_kama_posts_clauses_filter',

            'clauses' => $clauses,
        ] );

        return $clauses;
    }

    public static function wp_kama_posts_join_filter( $join )
    {
        LegalDebug::debug( [
            'ToolSitemapXML' => 'wp_kama_posts_join_filter',

            'join' => $join,
        ] );
        
        return $join;
    }

    public static function check_sitemap_enabled()
    {
        // $is_sitemaps_enabled = wp_sitemaps_get_server()->sitemaps_enabled();

        // LegalDebug::debug( [
        //     'ToolSitemapXML' => 'check_sitemap_enabled',

        //     'is_sitemaps_enabled' => $is_sitemaps_enabled,
        // ] ); 

        // return $is_sitemaps_enabled;
        
        return wp_sitemaps_get_server()->sitemaps_enabled();
    }

    public static function register()
    {
        // LegalDebug::debug( [
        //     'ToolSitemapXML' => 'register',

        //     'check_sitemap_enabled' => self::check_sitemap_enabled(),
        // ] ); 

        // if ( self::is_sitemap_page() )
        // {
        //     $handler = new self();

        //     # Исключение отдельных язвков из карты сайта

        //     add_filter( 'posts_where', [ $handler, 'prepare_filter_where' ] );
        // }
    }

    /*
     * Устанавливается на хуке wp после parse_request
     */

    // public static function is_sitemap_page()
    // {
    //     global $wp_version;
    
    //     if( ! did_action( 'parse_request' ) )
    //     {
    //         _doing_it_wrong( __FUNCTION__, 'Can`t be called before `parse_request` hook.', $wp_version );
    
    //         return false;
    //     }
    
    //     return (bool) sanitize_text_field( get_query_var( 'sitemap' ) );
    // }

    // public static function check_filter()
    // {
    //     // return self::is_sitemap_page()

    //     //     && ToolNotFound::check_restricted();

    //     return self::is_sitemap_page();
    // }

    // public static function prepare_filter_where( $where )
	// {
    //     // LegalDebug::debug( [
    //     //     'is_sitemap_page()' => self::is_sitemap_page(),
    //     // ] );

    //     // if ( !self::is_sitemap_page() )
        
    //     if ( self::check_filter() )
    //     {
    //         $participate = 'NOT IN';

    //         $restricted_languages = [];

    //         if ( ToolNotFound::check_domain() )
    //         {
    //             $participate = 'IN';

    //             $restricted_languages = ToolNotFound::get_restricted_languages();
    //         }

    //         // $restricted_languages = ToolNotFound::get_restricted_languages();

    //         // LegalDebug::debug( [
    //         //     'restricted_languages' => $restricted_languages,
    //         // ] );

    //         $values = "'" . join( "', '", $restricted_languages ) . "'";

    //         $where = preg_replace(
    //             '/wpml_translations.language_code(\s=\s\'[a-z]+\')?/',
                
    //             'wpml_translations.language_code ' . $participate . ' (' . $values . ')',
                
    //             $where
    //         );
    //     }
		
    //     return $where;
	// }
    
    public static function kama_sitemap_max_urls( $num, $object_type )
    {
        return 100;
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
    
    public static function wp_kama_sitemaps_posts_query_args_filter( $args, $post_type )
    {
        LegalDebug::debug( [
            'ToolSitemapXML' => 'wp_kama_sitemaps_posts_query_args_filter',

            'args' => $args,
        ] );

        $args[ 'suppress_filters' ] = true;

        return $args;
    }

    // public static function optimize_sitemap_posts_query( $args )
    // {
    //     $args[ 'fields' ] = 'ids';

    //     return $args;
    // }

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
        $entry[ 'lastmod' ] = get_the_modified_date( 'c', $post );

        $entry[ 'priority' ] = self::get_priority( $post );

        $entry[ 'changefreq' ] = 'weekly';

        return $entry;
    }
}

?>