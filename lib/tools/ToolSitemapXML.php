<?php

// Втсрокнная Wordpress XML Карта Сайта
// https://wp-kama.ru/handbook/sitemap

class ToolSitemapXML
{
    public static function register()
    {
        $handler = new self(); 

        add_filter( 'wp_sitemaps_max_urls', [ $handler, 'kama_sitemap_max_urls'], 10, 2 );

        // Отключение провайдера карт сайтов: пользователи и таксономии

        add_filter( 'wp_sitemaps_add_provider', [ $handler, 'kama_remove_sitemap_provider' ], 10, 2 );
        
        //  Отключение типа записи из карты сайта

        add_filter( 'wp_sitemaps_post_types', [ $handler,'wpkama_remove_sitemaps_post_types' ] );

        # Добавление колонок Last Modified, Change Frequency, Priority

        add_filter( 'wp_sitemaps_posts_entry', [ $handler, 'wpkama_sitemaps_posts_entry' ], 10, 2 );

        # Изменение параметров запроса WP_Query для карты сайта posts

        add_filter( 'wp_sitemaps_posts_query_args', [ $handler, 'wp_kama_sitemaps_posts_query_args_filter' ], 10, 2 );

        # Исключение отдельных url (url записи, рубрики, метки)

        // add_filter( 'wp_sitemaps_posts_query_args', [ $handler, 'kama_sitemaps_posts_query_args' ], 10, 2 );

        add_filter( 'icl_ls_languages', [ $handler, 'my_change_french_url_to_custom_external_site' ] );
    }

    public static function my_change_french_url_to_custom_external_site( $languages )
    {
        $updated = [];
        
        foreach( $languages as &$language )
        {
            if( $language['default_locale'] === 'pl_PL' )
            {
                $language['url'] = 'https://my-custom-external-url.com';
                break;

                $updated[] = $language;
            }
        }
    
        // return $languages;
        
        return $updated;
    }
    
    public static function kama_sitemaps_posts_query_args( $args, $post_type )
    {
        // if( 'page' !== $post_type )

        if( !in_array( $post_type, [ 'post', 'page' ] ) )
        {
            return $args;
        }

        $restricted_languages = ToolNotFound::get_restricted_languages();

        if ( empty( $restricted_languages ) )
        {
            return $args;
        }

        LegalDebug::debug( [
            'toolSitemapXML' => 'kama_sitemaps_posts_query_args',

            'restricted_languages' => $restricted_languages,
        ] );

        $current_language = $sitepress->get_current_language();

        global $sitepress;

        foreach ( $restricted_languages as $language )
        {
            $sitepress->switch_lang( $language );



            $sitepress->switch_lang( $current_language );
        }

        // учтем что этот параметр может быть уже установлен

        if( ! isset( $args['post__not_in'] ) )
        {
            $args['post__not_in'] = [];
        }

        // Исключаем посты
        foreach( [ 12, 24 ] as $post_id )
        {
            $args['post__not_in'][] = $post_id;
        }

        return $args;
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
        $entry[ 'lastmod' ] = get_the_modified_date( 'c', $post );

        $entry[ 'priority' ] = self::get_priority( $post );

        $entry[ 'changefreq' ] = 'weekly';

        return $entry;
    }
}

?>