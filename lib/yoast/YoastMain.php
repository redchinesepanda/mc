<?php

require_once( 'YoastOG.php' );

require_once( 'YoastSitemapXML.php' );

class YoastMain
{
    public static function check_plugin()
    {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        return is_plugin_active( 'wordpress-seo/wp-seo.php' );
    }

    public static function check_api()
    {
        return function_exists( 'YoastSEO' );
    }

    public static function check_functions()
    {
        return function_exists( 'yoast_get_primary_term_id' );
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_loaded', [ $handler, 'wpwc_fix_yoast_seo_robots_txt' ] );

        add_filter( 'wpseo_json_ld_output', '__return_false' );
    }

    public static function register_functions()
    {
        $handler = new self();

        add_action( 'wpseo_register_extra_replacements', [ $handler, 'register_my_plugin_extra_replacements' ] );

        // add_filter( 'wpseo_sitemap_entries_per_page', [ $handler, 'max_entries_per_sitemap' ] );

        // add_filter( 'wpseo_xml_sitemap_post_url', [ $handler, 'sitemap_post_url' ], 10, 2 );

        \add_filter( 'wpseo_indexable_forced_included_post_types', [ $handler, 'include_post_types' ] );

        \add_action( 'init', [ $handler, 'init' ] );

        \add_filter( 'wpseo_force_creating_and_using_attachment_indexables', '__return_true' );

        add_action( 'wp_loaded', [ $handler, 'wpwc_fix_yoast_seo_robots_txt' ] );

        YoastSitemapXML::register_functions();

        YoastOG::register_functions();
    }

    /**
     * Fix Yoast SEO robots.txt changes.
     * https://wordpress.org/support/topic/disable-robots-txt-changing-by-yoast-seo/#post-16648736
     */

    public static function wpwc_fix_yoast_seo_robots_txt()
    {
        global $wp_filter;

        if ( isset( $wp_filter['robots_txt']->callbacks ) && is_array( $wp_filter['robots_txt']->callbacks ) )
        {
            foreach ( $wp_filter['robots_txt']->callbacks as $callback_priority => $callback )
            {
                foreach ( $callback as $function_key => $function )
                {
                    if ( 'filter_robots' === $function['function'][1] )
                    {
                        unset( $wp_filter['robots_txt']->callbacks[ $callback_priority ][ $function_key ] );
                    }
                }
            }
        }
    }

    const REPLACEVAR = [
        'billets-amount' => '%%billetsamount%%',

        'year' => '%%YEAR%%',

        'month' => '%%MONTH%%',

        'month-year' => '%%MONTH_YEAR%%',
    ];

    public static function register_my_plugin_extra_replacements()
    {
        $handler = new self();

        wpseo_register_var_replacement( self::REPLACEVAR[ 'billets-amount' ], [ $handler, 'retrieve_billetsamount_replacement' ], 'basic', '[MC] This is a current [legal-tabs] unique billets amount' );

        wpseo_register_var_replacement( self::REPLACEVAR[ 'year' ], [ $handler, 'retrieve_year' ], 'basic', '[MC] This is a current year' );

        wpseo_register_var_replacement( self::REPLACEVAR[ 'month' ], [ $handler, 'retrieve_month' ], 'basic', '[MC] This is a current month' );

        wpseo_register_var_replacement( self::REPLACEVAR[ 'month-year' ], [ $handler, 'retrieve_month_year' ], 'basic', '[MC] This is a current month and year' );
    }

    public static function retrieve_billetsamount_replacement( $var1 )
    {
        return CompilationTabs::get_billets_amount();
    }

    public static function retrieve_year()
    {
        $format = ReviewTitle::FORMAT[ ReviewTitle::CLASSES[ 'date-year' ] ];

        return ReviewTitle::format_date( $format );
    }

    public static function retrieve_month()
    {
        $format = ReviewTitle::FORMAT[ ReviewTitle::CLASSES[ 'date-month' ] ];

        return ReviewTitle::format_date( $format );
    }

    public static function retrieve_month_year()
    {
        $format = ReviewTitle::FORMAT[ ReviewTitle::CLASSES[ 'date-month-year' ] ];

        return ReviewTitle::format_date( $format );
    }

    public static function include_post_types( $post_types )
    {
        $post_types[] = 'attachment';

        return $post_types;
    }

    public static function init( $post_types )
    {
        $handler = new self();

        \add_filter( 'wpseo_indexable_excluded_post_types', [ $handler, 'exclude_post_types' ] );
    }
    
    public static function exclude_post_types( $post_types )
    {
        $filtered_post_types = [];

        foreach ( $post_types as $post_type )
        {
           if ( $post_type !== 'attachment' )
           {
              $filtered_post_types[] = $post_type;
           }
        }

        return $filtered_post_types;
    }

    // public static function max_entries_per_sitemap()
    // {
    //     return 250;
    // }

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

    // public static function print()
    // {
    //     $args = self::get();

    //     echo '<title>' . $args['title'] . '</title>';

    //     foreach ( $args['meta'] as $key => $value )
    //     {
    //         echo '<meta name="' . $key . '" content="' . $value . '" />';
    //     }
    // }

    // private static function get()
    // {
    //     $post = get_post();

    //     return [
    //         'title' => YoastSEO()->meta->for_post( $post->ID )->title,

    //         'meta' =>
    //         [
    //             'description' => YoastSEO()->meta->for_post( $post->ID )->description,
            
    //             'keywords' => 'keywords',
                
    //             'author' => 'author',

    //             'viewport' => 'width=device-width, initial-scale=1.0',
    //         ]
    //     ];
    // }

    // const PLACEHOLDER = [
    //     'billets-amount' => '{billets-amount}',
    // ];

    public static function check()
    {
        return function_exists( 'YoastSEO' );
    }

    public static function get_seo_title()
    {
        $post = get_post();

        if ( $post )
        {
            if ( self::check_api() )
            {
                return YoastSEO()->meta->for_post( $post->ID )->title;
            }

            return $post->post_title;
        }

        return '';
    }

    public static function get_seo_description()
    {
        if ( self::check() )
        {
            $post = get_post();
    
            if ( $post )
            {
                if ( self::check_api() )
                {
                    return YoastSEO()->meta->for_post( $post->ID )->description;
                }
            }
        }

        return '';
    }

    const TAXONOMY = [
        'category' => 'category',
    ];

    public static function get_primary_term_id( $id, $category = self::TAXONOMY[ 'category' ] )
    {
        if ( self::check_functions() )
        {
            return yoast_get_primary_term_id( self::TAXONOMY[ 'category' ], $id );
        }

        return 0;
    }

    // const TEMPLATE = [
    //     'main' => LegalMain::LEGAL_PATH . '/template-parts/yoast/part-yoast-main.php',
    // ];

    // public static function render()
    // {
    //     load_template( self::TEMPLATE[ 'main' ], false, self::get() );
    // }

    // public static function render_ob()
    // {
    //     ob_start();

    //     load_template( self::TEMPLATE[ 'main' ], false, self::get() );

    //     $output = ob_get_clean();

    //     echo $output;
    // }
}

?>