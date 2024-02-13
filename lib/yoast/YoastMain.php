<?php

require_once( 'YoastOG.php' );

class YoastMain
{
    public static function register_functions()
    {
        // $handler = new self();

        // add_filter( 'wpseo_sitemap_entries_per_page', [ $handler, 'max_entries_per_sitemap' ] );

        // add_filter( 'wpseo_xml_sitemap_post_url', [ $handler, 'sitemap_post_url' ], 10, 2 );

        // add_filter( 'wp_sitemaps_max_urls', [ $handler, 'kama_sitemap_max_urls'], 10, 2 );

        // Отключение провайдера карт сайтов: пользователи и таксономии

        // add_filter( 'wp_sitemaps_add_provider', [ $handler, 'kama_remove_sitemap_provider' ], 10, 2 );
        
        //  Отключение типа записи из карты сайта

        // add_filter( 'wp_sitemaps_post_types', [ $handler,'wpkama_remove_sitemaps_post_types' ] );

        # Отключение таксономии из карты сайта

        // add_filter( 'wp_sitemaps_taxonomies', [ $handler,'wpkama_remove_sitemaps_taxonomies' ] );

        # Колонки Last Modified, Change Frequency, Priority

        // add_filter( 'wp_sitemaps_posts_entry', [ $handler, 'wpkama_sitemaps_posts_entry' ], 10, 2 );

        # Изменить параметры запроса WP_Query для карты сайта записей

        // add_filter( 'wp_sitemaps_posts_query_args', [ $handler, 'wp_kama_sitemaps_posts_query_args_filter' ], 10, 2 );
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

        // $entry[ 'priority' ] = self::PRIORITY[ 'low' ];
        
        // if ( array_key_exists( $post->post_type, self::PRIORITY ) )
        // {
        //     $entry[ 'priority' ] = self::PRIORITY[ $post->post_type ];
        // }

        // if ( WPMLTrid::get_trid( $post->ID ) == WPMLTrid::get_trid( get_option('page_on_front') ) )
        // {
        //     $entry[ 'priority' ] = self::PRIORITY[ 'high' ];
        // }

        $entry[ 'priority' ] = self::get_priority( $post );

        $entry[ 'changefreq' ] = 'weekly';

        return $entry;
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

    const POST_TYPES = [
        'tcb_symbol',

        'affiliate-links',
    ];

    public static function wpkama_remove_sitemaps_post_types( $post_types )
    {
        foreach ( self::POST_TYPES as $type )
        {
            unset( $post_types[ $type ] );
        }

        return $post_types;
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
    
    public static function kama_sitemap_max_urls( $num, $object_type )
    {
        return 1000;
    }

    // public static function sitemap_post_url( $url, $post )
    // {
    //     LegalDebug::debug( [
    //         'YoastMain' => 'sitemap_post_url',

    //         'ID' => $post->ID,

    //         'page_on_front' => get_option( 'page_on_front' ),

    //         'get_permalink' => get_permalink( $post->ID ),

    //         'get_post_permalink' => get_post_permalink( $post->ID ),

    //         // 'url' => $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER['HTTP_HOST'],
    //     ] );

    //     if ( $post->ID == get_option( 'page_on_front' ) )
    //     {
    //         return $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER['HTTP_HOST'];
    //     }
    
    //     return $url;
    // }
    
    public static function register()
    {
        YoastOG::register();
    }

    // public static function max_entries_per_sitemap()
    // {
    //     return 250;
    // }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/yoast/part-yoast-main.php';

    public static function print()
    {
        $args = self::get();

        echo '<title>' . $args['title'] . '</title>';

        foreach ( $args['meta'] as $key => $value ) {
            echo '<meta name="' . $key . '" content="' . $value . '" />';
        }
    }

    private static function get()
    {
        // $message['function'] = 'get';

        $post = get_post();

        return [
            'title' => YoastSEO()->meta->for_post( $post->ID )->title,

            'meta' =>
            [
                'description' => YoastSEO()->meta->for_post( $post->ID )->description,
            
                'keywords' => 'keywords',
                
                'author' => 'author',

                'viewport' => 'width=device-width, initial-scale=1.0',
            ]
        ];

        // $message['args'] = $args;

        // self::debug( $message );
    }

    public static function get_seo_title() {
        $post = get_post();

        if ( $post ) {
            return YoastSEO()->meta->for_post( $post->ID )->title;
        }

        return '';
    }

    public static function get_seo_description() {
        $post = get_post();

        if ( $post ) {
            return YoastSEO()->meta->for_post( $post->ID )->description;
        }

        return '';
    }

    public static function render()
    {
        load_template( self::TEMPLATE, false, self::get() );
    }

    public static function render_ob()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        echo $output;
    }
}

?>